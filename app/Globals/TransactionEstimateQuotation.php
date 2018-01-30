<?php
namespace App\Globals;

use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_customer_estimate_line;
use Carbon\Carbon;
use DB;
use App\Globals\AccountingTransaction;
/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionEstimateQuotation
{
	public static function getOpenEQ($shop_id, $customer_id)
	{
		return Tbl_customer_estimate::where("is_sales_order",0)->where("est_status","accepted")->where("est_shop_id", $shop_id)->where("est_customer_id",$customer_id)->get();
	}

	public static function getAllOpenEQ($shop_id)
    {
        return Tbl_customer_estimate::customer()->where('est_shop_id',$shop_id)->where("est_status","accepted")->where('is_sales_order', 0)->get();
    }

	public static function info($shop_id, $eq_id)
	{
		return Tbl_customer_estimate::customer()->where("est_shop_id", $shop_id)->where("est_id", $eq_id)->first();
	}
	public static function info_item($eq_id)
	{
		return Tbl_customer_estimate_line::um()->where("estline_est_id", $eq_id)->get();		
	}

	public static function get($shop_id, $paginate = null, $search_keyword = null, $status = null)
	{
		$data = Tbl_customer_estimate::customer()->where('est_shop_id', $shop_id)->where('is_sales_order',0);

		if($search_keyword)
		{
			$data->where(function($q) use ($search_keyword)
            {
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("est_id", "LIKE", "%$search_keyword%");
                $q->orWhere("company", "LIKE", "%$search_keyword%");
                $q->orWhere("first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("last_name", "LIKE", "%$search_keyword%");
            });
		}

		if($status != 'all')
		{
			$data->where('est_status',$status);
		}
		if($paginate)
		{
			$data = $data->paginate($paginate);
		}
		else
		{
			$data = $data->get();
		}

		return $data;
	}
	public static function postUpdate($estimate_id, $shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item);
		if(!$val)
		{
			$return  = null; 
			$ins['est_shop_id']                  = $shop_id;  
			$ins['est_customer_id']              = $insert['customer_id'];  
			$ins['transaction_refnum']	 		 = $insert['transaction_refnum'];   
	        $ins['est_customer_email']           = $insert['customer_email'];
	        $ins['est_customer_billing_address'] = $insert['customer_address'];
	        $ins['est_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
	        $ins['est_exp_date']                 = date("Y-m-d", strtotime($insert['transaction_duedate']));
	        $ins['est_message']                  = $insert['customer_message'];
	        $ins['est_memo']                     = $insert['customer_memo'];
	        $ins['date_created']                 = Carbon::now();

	        /* SUBTOTAL */
	        $subtotal_price = collect($insert_item)->sum('item_amount');

	        /* OVERALL TOTAL */
	        $overall_price  = convertToNumber($subtotal_price);

	        $ins['est_subtotal_price']           = $subtotal_price;
	        $ins['est_overall_price']            = $overall_price;


	        /* INSERT INVOICE HERE */
	        Tbl_customer_estimate::where('est_id', $estimate_id)->update($ins);


	        Tbl_customer_estimate_line::where('estline_est_id', $estimate_id)->delete();

	        $return = Self::insertline($estimate_id, $insert_item);

			// /* INSERT TRANSACTION HERE */
			// $acctg['transaction_ref_name'] = "estimate_quotation";
			// $acctg['transaction_ref_id'] = $estimate_id;
			// $acctg['transaction_list_number'] = $ins['transaction_refnum'];
			// $acctg['transaction_date'] = $ins['est_date'];
			// AccountingTransaction::postTransaction($shop_id, $acctg, $insert_item);
		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}
	public static function postInsert($shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item, 'estimate_quotation');
		if(!$val)
		{
			$return  = null; 
			$ins['est_shop_id']                  = $shop_id;  
			$ins['est_customer_id']              = $insert['customer_id'];  
			$ins['transaction_refnum']	 		 = $insert['transaction_refnum'];   
	        $ins['est_customer_email']           = $insert['customer_email'];
	        $ins['est_customer_billing_address'] = $insert['customer_address'];
	        $ins['est_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
	        $ins['est_exp_date']                 = date("Y-m-d", strtotime($insert['transaction_duedate']));
	        $ins['est_message']                  = $insert['customer_message'];
	        $ins['est_memo']                     = $insert['customer_memo'];
	        $ins['date_created']                 = Carbon::now();

	        /* SUBTOTAL */
	        $subtotal_price = collect($insert_item)->sum('item_amount');

	        /* OVERALL TOTAL */
	        $overall_price  = convertToNumber($subtotal_price);

	        $ins['est_subtotal_price']           = $subtotal_price;
	        $ins['est_overall_price']            = $overall_price;


	        /* INSERT INVOICE HERE */
	        $estimate_id = Tbl_customer_estimate::insertGetId($ins);

	        $return = Self::insertline($estimate_id, $insert_item);

			// /* INSERT TRANSACTION HERE */
			// $acctg['transaction_ref_name'] = "estimate_quotation";
			// $acctg['transaction_ref_id'] = $estimate_id;
			// $acctg['transaction_list_number'] = $ins['transaction_refnum'];
			// $acctg['transaction_date'] = $ins['est_date'];
			// AccountingTransaction::postTransaction($shop_id, $acctg, $insert_item);
		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}
	public static function insertline($estimate_id, $insert_item)
	{
		$itemline = null;
		foreach ($insert_item as $key => $value) 
		{	
	        /* DISCOUNT PER LINE */
	        $discount       = $value['item_discount'];
	        $discount_type  = 'fixed';
	        if(strpos($discount, '%'))
            {
            	$discount       = substr($discount, 0, strpos($discount, '%')) / 100;
                $discount_type  = 'percent';
            }

			$itemline[$key]['estline_est_id'] 			= $estimate_id;
			$itemline[$key]['estline_service_date'] 	= $value['item_servicedate'];
			$itemline[$key]['estline_item_id'] 			= $value['item_id'];
			$itemline[$key]['estline_description'] 		= $value['item_description'];
			$itemline[$key]['estline_um'] 				= $value['item_um'];
			$itemline[$key]['estline_qty'] 				= $value['item_qty'];
			$itemline[$key]['estline_rate'] 			= $value['item_rate'];
			$itemline[$key]['estline_discount'] 		= $discount;
			$itemline[$key]['estline_discount_type'] 	= $discount_type;
			$itemline[$key]['estline_discount_remark'] 	= $value['item_remarks'];
			$itemline[$key]['taxable'] 					= $value['item_taxable'] != null ? $value['item_taxable'] : 0;
			$itemline[$key]['estline_amount'] 			= $value['item_amount'];
			$itemline[$key]['date_created'] 			= Carbon::now();
		}
		if(count($itemline) > 0)
		{
			Tbl_customer_estimate_line::insert($itemline);
			$return = $estimate_id;
		}

		return $return;
	}

}