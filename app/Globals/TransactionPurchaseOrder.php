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

class TransactionPurchaseOrder
{
	public static function countTransaction($shop_id)
	{
		return Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_status","accepted")->count();
	}
	public function postInsert($purchase_order)
	{
		$insert['po_shop_id']         = Purchase_Order::getShopId();
		$insert['po_ap_account']      = Purchase_Order::getApAccount(); 
		$insert['transaction_refnum'] = $purchase_order['transaction_refnumber'];
        $insert['po_vendor_id']       = $purchase_order['vendor_id'];
        $insert['po_billing_address'] = $purchase_order['vendor_address'];
        $insert['po_vendor_email']    = $purchase_order['vendor_email'];
        $insert['po_terms_id']        = $purchase_order['vendor_terms'];
        $insert['po_date']     		  = $purchase_order['transaction_date'];
        $insert['po_due_date']   	  = $purchase_order['transaction_duedate'];
        $insert['po_message']         = $purchase_order['vendor_message'];
        $insert['po_memo']            = $purchase_order['vendor_memo'];
        $insert['ewt']             	  = $purchase_order['vendor_ewt'];
        $insert['po_terms_id']        = $purchase_order['vendor_terms'];
        $insert['po_discount_value']  = $purchase_order['vendor_discount'];
        $insert['po_discount_type']   = $purchase_order['vendor_discounttype'];
        $insert['taxable']            = $purchase_order['vendor_tax'];
        $insert['po_subtotal_price']  = $purchase_order['subtotal_price'];
        $insert['po_overall_price']   = $purchase_order['overall_price'];
        $insert['date_created']       = Carbon::now();

        $purchase_order_id = $insert;
        
        return $purchase_order_id;
	}

	public function validation()
	{
		$validation['transaction_refnum'] = 'required',
        $validation['po_vendor_email']    = 'email',
        $validation['po_vendor_id']		  = 'required'
	}
}
