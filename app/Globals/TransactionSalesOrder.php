<?php
namespace App\Globals;

use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_customer_estimate_line;
use App\Models\Tbl_item;
use Carbon\Carbon;
use DB;
use App\Globals\AccountingTransaction;
use Session;
/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionSalesOrder
{
	public static function getOpenSO($shop_id, $customer_id)
	{
		return Tbl_customer_estimate::where("is_sales_order",1)->where("est_status","accepted")->where("est_shop_id", $shop_id)->where("est_customer_id",$customer_id)->get();
	}
	public static function countTransaction($shop_id, $customer_id)
	{
		return Tbl_customer_estimate::where("is_sales_order",0)->where("est_status","accepted")->where("est_shop_id", $shop_id)->where("est_customer_id",$customer_id)->count();
	}
	public static function info($shop_id, $sales_order_id)
	{
		return Tbl_customer_estimate::customer()->where("est_shop_id", $shop_id)->where("est_id", $sales_order_id)->first();
	}
	public static function info_item($sales_order_id)
	{
		
		$data = Tbl_customer_estimate_line::estimate_item()->um()->where("estline_est_id", $sales_order_id)->get();		
		foreach($data as $key => $value) 
        {
        	//$data[$key]->invty_count = Tbl_item::recordloginventory($warehouse_id)->where('item_id', $value->estline_item_id)->value('inventory_count');
            $qty = UnitMeasurement::um_qty($value->estline_um);

            $total_qty = $value->estline_qty * $qty;
            $data[$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->estline_um);
        }
        return $data;		
	}
	public static function info_item_whse($sales_order_id, $warehouse_id)
	{
		
		$data = Tbl_customer_estimate_line::estimate_item()->um()->where("estline_est_id", $sales_order_id)->get();		
		foreach($data as $key => $value) 
        {
        	$data[$key]->invty_count = Tbl_item::recordloginventory($warehouse_id)->where('item_id', $value->estline_item_id)->value('inventory_count');
            $qty = UnitMeasurement::um_qty($value->estline_um);

            $total_qty = $value->estline_qty * $qty;
            $data[$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->estline_um);
        }
        return $data;		
	}
	public static function getAllOpenSO($shop_id)
    {
        return Tbl_customer_estimate::customer()->where('est_shop_id',$shop_id)->where("est_status","accepted")->where('is_sales_order', 1)->get();
    }
    public static function getCountAllOpenSO($shop_id)
    {
        return Tbl_customer_estimate::customer()->where('est_shop_id',$shop_id)->where("est_status","accepted")->where('is_sales_order', 1)->count();
    }

	public static function get($shop_id, $paginate = null, $search_keyword = null, $status = null)
	{
		$data = Tbl_customer_estimate::customer()->where('est_shop_id', $shop_id)->where('is_sales_order',1);

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
	public static function postInsert($shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item, 'sales_order');
		if(!$val)
		{
			$return  = null; 
			$ins['est_shop_id']                  = $shop_id;  
			$ins['est_customer_id']              = $insert['customer_id'];  
			$ins['transaction_refnum']	 		 = $insert['transaction_refnum'];   
	        $ins['est_customer_email']           = $insert['customer_email'];
	        $ins['est_customer_billing_address'] = $insert['customer_address'];
	        $ins['est_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
	        $ins['est_message']                  = $insert['customer_message'];
	        $ins['est_memo']                     = $insert['customer_memo'];
	        $ins['date_created']                 = Carbon::now();

	        /* SUBTOTAL */
	        $subtotal_price = collect($insert_item)->sum('item_amount');

	        /* OVERALL TOTAL */
	        $overall_price  = convertToNumber($subtotal_price);

	        $ins['est_subtotal_price']           = $subtotal_price;
	        $ins['est_overall_price']            = $overall_price;
	        $ins['is_sales_order'] 				 = 1;    
            $ins['est_status']					 = 'accepted';   

	        /* INSERT SALES ORDER HERE */
	        $sales_order_id = Tbl_customer_estimate::insertGetId($ins);
	        // $sales_order_id = 0;

	        $return = Self::insertline($sales_order_id, $insert_item);
		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}

	public static function postUpdate($sales_order_id, $shop_id, $insert, $insert_item = array())
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
	        $ins['est_message']                  = $insert['customer_message'];
	        $ins['est_memo']                     = $insert['customer_memo'];
	        $ins['date_created']                 = Carbon::now();

	        /* SUBTOTAL */
	        $subtotal_price = collect($insert_item)->sum('item_amount');

	        /* OVERALL TOTAL */
	        $overall_price  = convertToNumber($subtotal_price);

	        $ins['est_subtotal_price']           = $subtotal_price;
	        $ins['est_overall_price']            = $overall_price;
	        $ins['is_sales_order'] 				 = 1;    
            $ins['est_status']					 = 'accepted';   

	        /* INSERT SALES ORDER HERE */
	        Tbl_customer_estimate::where('est_id', $sales_order_id)->update($ins);
	        // $sales_order_id = 0;
	        Tbl_customer_estimate_line::where('estline_est_id', $sales_order_id)->delete();

	        $return = Self::insertline($sales_order_id, $insert_item);
		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}
	public static function insertline($sales_order_id, $insert_item)
	{
		$itemline = null;
		$return = null;
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

			$itemline[$key]['estline_est_id'] 			= $sales_order_id;
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

			$itemline[$key]['estline_refname'] 			= $value['item_refname'];
			$itemline[$key]['estline_refid'] 			= $value['item_refid'];
		}
		if(count($itemline) > 0)
		{
			Tbl_customer_estimate_line::insert($itemline);
			$return = $sales_order_id;
		}

		return $return;
	}

    public static function applied_transaction($shop_id, $transaction_id = 0)
    {
        $applied_transaction = Session::get('applied_transaction_so');
        if(count($applied_transaction) > 0)
        {
            foreach ($applied_transaction as $key => $value) 
            {
                $update['est_status'] = 'closed';
                Tbl_customer_estimate::where("est_id", $key)->where('est_shop_id', $shop_id)->update($update);
            }
        }

        Self::insert_acctg_transaction($shop_id, $transaction_id, $applied_transaction);
    }
    public static function insert_acctg_transaction($shop_id, $transaction_id, $applied_transaction = array())
    {
    	$get_transaction = Tbl_customer_estimate::where("est_shop_id", $shop_id)->where("est_id", $transaction_id)->first();
    	$transaction_data = null;
    	if($get_transaction)
    	{
    		$transaction_data['transaction_ref_name'] = "sales_order";
		 	$transaction_data['transaction_ref_id'] = $transaction_id;
		 	$transaction_data['transaction_list_number'] = $get_transaction->transaction_refnum;
		 	$transaction_data['transaction_date'] = $get_transaction->est_date;

		 	$attached_transaction_data = null;
		 	if(count($applied_transaction) > 0)
		 	{
			 	foreach ($applied_transaction as $key => $value) 
			 	{
			 		$get_data = Tbl_customer_estimate::where("est_shop_id", $shop_id)->where("est_id", $key)->first();
			 		if($get_data)
			 		{
				 		$attached_transaction_data[$key]['transaction_ref_name'] = "estimate_qoutation";
					 	$attached_transaction_data[$key]['transaction_ref_id'] = $key;
					 	$attached_transaction_data[$key]['transaction_list_number'] = $get_data->transaction_refnum;
					 	$attached_transaction_data[$key]['transaction_date'] = $get_data->est_date;
			 		}
			 	}
		 	}
    	}

    	if($transaction_data)
		{
			AccountingTransaction::postTransaction($shop_id, $transaction_data, $attached_transaction_data);
		}
    }
}