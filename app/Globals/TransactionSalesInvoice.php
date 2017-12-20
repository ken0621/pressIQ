<?php
namespace App\Globals;

use App\Models\Tbl_customer_estimate;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionSalesInvoice
{
	public static function countTransaction($shop_id, $customer_id)
	{
		return Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_customer_id",$customer_id)->where("est_status","accepted")->count();
	}
	public static function postInsert($shop_id, $insert, $insert_item = array())
	{
		$ins['inv_shop_id']                  = $shop_id;  
		$ins['inv_customer_id']              = $insert['customer_id'];  
		$ins['transaction_refnumber'] 		 = $insert['transaction_refnumber'];   
        $ins['inv_customer_email']           = $insert['customer_email'];
        $ins['inv_customer_billing_address'] = $insert['customer_address'];
        $ins['inv_terms_id']                 = $insert['customer_terms'];
        $ins['inv_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
        $ins['inv_due_date']                 = date("Y-m-d", strtotime($insert['transaction_duedate']));
        $ins['ewt']                          = $insert['customer_ewt'];
        $ins['inv_discount_type']            = $insert['customer_discounttype'];
        $ins['inv_discount_value']           = $insert['customer_discount'];
        $ins['taxable']                      = $insert['customer_tax'];
        $ins['inv_message']                  = $insert['customer_message'];
        $ins['inv_memo']                     = $insert['customer_memo'];
        $ins['date_created']                 = Carbon::now();

        /* SUBTOTAL */
        $subtotal_price = collect($item_info)->sum('item_amount');

        /* DISCOUNT */
        $discount = $insert['customer_discount'];
        if($insert['customer_discounttype'] == 'percent') $discount = (convertToNumber($insert['customer_discount']) / 100) * $subtotal_price;

        /* TAX */
        $tax = (collect($item_info)->where('item_taxable', '1')->sum('item_amount')) * 0.12;

        /* EWT */
        $ewt = $subtotal_price*convertToNumber($insert['customer_ewt']);

        /* OVERALL TOTAL */
        $overall_price  = convertToNumber($subtotal_price) - $ewt - $discount + $tax;

        $ins['inv_subtotal_price']           = $subtotal_price;
        $ins['inv_overall_price']            = $overall_price;
	}
}