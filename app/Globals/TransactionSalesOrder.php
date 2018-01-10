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
	public static function getAllOpenSO($shop_id)
    {
        return Tbl_customer_estimate::Customer()->where('est_shop_id',$shop_id)->where("est_status","accepted")->where('is_sales_order', 1)->get();
    }
	public static function postInsert($shop_id, $insert, $insert_item = array())
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
	        $ins['est_terms_id']                 = $insert['customer_terms'];
	        $ins['est_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
	        $ins['est_due_date']                 = date("Y-m-d", strtotime($insert['transaction_duedate']));
	        $ins['ewt']                          = $insert['customer_ewt'];
	        $ins['est_discount_type']            = $insert['customer_discounttype'];
	        $ins['est_discount_value']           = $insert['customer_discount'];
	        $ins['taxable']                      = $insert['customer_tax'];
	        $ins['est_message']                  = $insert['customer_message'];
	        $ins['est_memo']                     = $insert['customer_memo'];
	        $ins['date_created']                 = Carbon::now();

	        /* SUBTOTAL */
	        $subtotal_price = collect($insert_item)->sum('item_amount');

	        /* DISCOUNT */
	        $discount = $insert['customer_discount'];
	        if($insert['customer_discounttype'] == 'percent') $discount = (convertToNumber($insert['customer_discount']) / 100) * $subtotal_price;

	        /* TAX */
	        $tax = (collect($insert_item)->where('item_taxable', '1')->sum('item_amount')) * 0.12;

	        /* EWT */
	        $ewt = $subtotal_price*convertToNumber($insert['customer_ewt']);

	        /* OVERALL TOTAL */
	        $overall_price  = convertToNumber($subtotal_price) - $ewt - $discount + $tax;

	        $ins['est_subtotal_price']           = $subtotal_price;
	        $ins['est_overall_price']            = $overall_price;
	        $ins['is_sales_order'] 				 = 1;    
            $ins['est_status']					 = 'accepted';   

	        /* INSERT SALES ORDER HERE */
	        // $sales_order_id = Tbl_customer_estimate::insertGetId($ins);
	        $sales_order_id = 0;

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
			$itemline[$key]['taxable'] 					= $value['item_taxable'];
			$itemline[$key]['estline_amount'] 			= $value['item_amount'];
			$itemline[$key]['date_created'] 			= Carbon::now();
		}
		if(count($itemline) > 0)
		{
			// Tbl_customer_estimate_line::insert($itemline);
		}

		return $return;
	}

}