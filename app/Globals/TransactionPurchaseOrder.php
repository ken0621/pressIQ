<?php
namespace App\Globals;

use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_shop;
use Carbon\Carbon;
use Validator;
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

	public static function postInsert($shop_id, $insert, $insert_item)
	{
		$ins['po_shop_id']         = $shop_id;
		$ins['transaction_refnum'] = $insert['transaction_refnumber'];
        $ins['po_vendor_id']       = $insert['vendor_id'];
        $ins['po_billing_address'] = $insert['vendor_address'];
        $ins['po_vendor_email']    = $insert['vendor_email'];
        $ins['po_terms_id']        = $insert['vendor_terms'];
        $ins['po_date']     	   = date("Y-m-d", strtotime($insert['transaction_date']));
        $ins['po_due_date']   	   = date("Y-m-d", strtotime($insert['transaction_duedate']));
        $ins['po_message']         = $insert['vendor_message'];
        $ins['po_memo']            = $insert['vendor_memo'];
        $ins['ewt']                = $insert['vendor_ewt'];
        $ins['po_terms_id']        = $insert['vendor_terms'];
        $ins['po_discount_value']  = $insert['vendor_discount'];
        $ins['po_discount_type']   = $insert['vendor_discounttype'];
        $ins['taxable']            = $insert['vendor_tax'];
        $ins['date_created']       = Carbon::now();

         /* SUBTOTAL */
        $subtotal_price = collect($insert_item)->sum('item_amount'); 

        /* DISCOUNT */
        $discount = $insert['vendor_discount'];
        if($insert['vendor_discounttype'] == 'percent')
        {
            $discount = (convertToNumber($insert['vendor_discount']) / 100) * $subtotal_price;
        }

        /* TAX */
        $tax = (collect($insert_item)->where('item_taxable', '1')->sum('item_amount')) * 0.12;

        /* EWT */
        $ewt = $subtotal_price * convertToNumber($insert['vendor_ewt']);

        /* OVERALL TOTAL */
        $overall_price  = convertToNumber($subtotal_price) - $ewt - $discount + $tax;

        $ins['po_subtotal_price'] = $subtotal_price;
        $ins['po_overall_price']  = $overall_price;
        
        die(var_dump($ins));
	}

	public static function validation($shop_id, $insert)
	{
        //dd($ins['po_subtotal_price']);
        $status_message = null;

		$rules['transaction_refnum'] = 'required';
        $rules['po_vendor_email']    = 'email';
        $rules['po_vendor_id']		 = 'required';

        $validator = Validator::make($insert, $rules);

        if($validator->fails())
        {
            $status = 'error';
            foreach ($validator->messages()->all('<li style=`list-style:none`>:message</li>') as $key => $message) {
                $status_message .= $message;
            }
        }
        /*if($shop_id)
        {
            $shop_data = Tbl_shop::where('shop_id',$shop_id)->first();
            if(!$shop_data)
            {
                $status_message .= 'Your account does not exist. <br>';                
            }
        }
        if($insert['item_id'] = NULL)
        {
            $item_data = Tbl_item::where('item_id',$insert['item_id'])->where('shop_id',$shop_id)->first();
            if(!$item_data)
            {
                $status_message .= 'no item. <br>';          
            }             
        }*/
        return $status_message;
	}
}
