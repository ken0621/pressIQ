<?php
namespace App\Globals;

use App\Models\Tbl_purchase_order;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionReceiveInventory
{
	public static function countTransaction($shop_id, $vendor_id)
	{
		return Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed',0)->count();
	}
	public static function postInsert($shop_id, $insert, $insert_item)
	{
		$ins['bill_shop_id']          = $shop_id;
		$ins['transaction_refnum']    = $insert['transaction_refnumber'];
        $ins['bill_vendor_id']        = $insert['vendor_id'];
        $ins['bill_mailing_address']  = $insert['vendor_address'];
        $ins['bill_vendor_email']     = $insert['vendor_email'];
        $ins['bill_terms_id']         = $insert['vendor_terms'];
        $ins['bill_date']         	  = $insert['transaction_date'];
        $ins['bill_due_date']         = $insert['transaction_duedate'];
        $ins['bill_memo']             = $insert['vendor_memo'];
        $ins['date_created']		  = Carbon::now();
        $ins['inventory_only']		  = 1;

         /* TOTAL */
        $total = collect($insert_item)->sum('item_amount');

        $ins['bill_total_amount'] = $total;
        die(var_dump($total));
        return $ins;

	}

}