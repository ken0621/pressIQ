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

        $val = AccountingTransaction::vendorValidation($insert, $insert_item);
        if(!$val)
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

            /*INSERT RI HERE*/
            /*$receive_inventory_id = Tbl_bill::insertGetId($ins);*/
            $receive_inventory_id = 0;

            /* Transaction Journal */
            $entry = null;
            if($ins['inventory_only'] == 0)
            {
                /* Transaction Journal */
                $entry["reference_module"]  = "bill";
                $entry["reference_id"]      = $receive_inventory_id;
                $entry["name_id"]           = $ins['bill_vendor_id'];
                $entry["total"]             = collect($insert_item)->sum('item_amount');
                $entry["vatable"]           = '';
                $entry["discount"]          = '';
                $entry["ewt"]               = '';            
            }
            $transaction_bill = "bill";
            if($ins['inventory_only'] != 0)
            {
                $transaction_bill = "receive_inventory";
            }

            $return = Self::insertLine($receive_inventory_id, $insert_item, $entry);
        }
        else
        {
            $return = $val;
        }
        return $return;
	}

    public static function insertLine($receive_inventory_id, $insert_item, $entry)
    {
        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {   
            $itemline[$key]['itemline_bill_id']      = $receive_inventory_id;
            $itemline[$key]['itemline_item_id']      = $value['item_id'];
            $itemline[$key]['itemline_description']  = $value['item_description'];
            $itemline[$key]['itemline_um']           = $value['item_um'];
            $itemline[$key]['itemline_qty']          = $value['item_qty'];
            $itemline[$key]['itemline_rate']         = $value['item_rate'];
            $itemline[$key]['itemline_amount']       = $value['item_amount'];

        }
        if(count($itemline) > 0)
        {
            Tbl_customer_invoice_line::insert($itemline);
            $return = AccountingTransaction::entry_data($entry, $insert_item);
        }

        return $return;
    }
}