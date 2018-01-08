<?php
namespace App\Globals;


use App\Models\Tbl_receive_inventory_line;
use App\Models\Tbl_receive_inventory;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_debit_memo;

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
		$debit_memo   = Tbl_debit_memo::where('db_shop_id',$shop_id)->where('db_vendor_id', $vendor_id)->count();
        $purchase_order = Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed', 0)->count();

        $count = $debit_memo + $purchase_order;
        //die(var_dump($count));
        return $count;
	}
    
	public static function postInsert($shop_id, $insert, $insert_item)
	{
        $val = AccountingTransaction::vendorValidation($insert, $insert_item);
        if(!$val)
        {
    		$ins['ri_shop_id']          = $shop_id;
    		$ins['transaction_refnum']  = $insert['transaction_refnumber'];
            $ins['ri_vendor_id']        = $insert['vendor_id'];
            $ins['ri_mailing_address']  = $insert['vendor_address'];
            $ins['ri_vendor_email']     = $insert['vendor_email'];
            $ins['ri_terms_id']         = $insert['vendor_terms'];
            $ins['ri_date']         	= $insert['transaction_date'];
            $ins['ri_due_date']         = $insert['transaction_duedate'];
            $ins['ri_memo']             = $insert['vendor_memo'];
            $ins['date_created']		= Carbon::now();
            $ins['inventory_only']		= 1;

            /* TOTAL */
            $total = collect($insert_item)->sum('item_amount');

            $ins['ri_total_amount'] = $total;

            /*INSERT RI HERE*/
            $receive_inventory_id = Tbl_receive_inventory::insertGetId($ins);

            /* Transaction Journal */
            /*$entry["reference_module"]  = "receive-inventory";
            $entry["reference_id"]      = $receive_inventory_id;
            $entry["name_id"]           = $insert['vendor_id'];
            $entry["total"]             = collect($insert_item)->sum('itemline_amount');
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';*/

            $return = Self::insertLine($receive_inventory_id, $insert_item);
            $return = $receive_inventory_id;
        }
        else
        {
            $return = $val;
        }
        return $return;
	}

    public static function insertLine($receive_inventory_id, $insert_item)
    {
        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {   
            $itemline[$key]['riline_ri_id']     = $receive_inventory_id;
            $itemline[$key]['riline_item_id']      = $value['item_id'];
            //$itemline[$key]['riline_ref_name']      = $value['reference_name'];
            //$itemline[$key]['riline_ref_id']        = $value['reference_id'];
            $itemline[$key]['riline_description']  = $value['item_description'];
            $itemline[$key]['riline_um']           = $value['item_um'];
            $itemline[$key]['riline_qty']          = $value['item_qty'];
            $itemline[$key]['riline_rate']     = $value['item_rate'];
            $itemline[$key]['riline_amount']       = $value['item_amount'];

            //$bill_id = $itemline[$key]['riline_ref_id'];
        }
        if(count($itemline) > 0)
        {
            $return = Tbl_receive_inventory_line::insert($itemline);
            
            Tbl_bill::where('bill_id', $bill_id);

            //$return = AccountingTransaction::entry_data($entry, $insert_item);
        }

        return $return;
    }
}