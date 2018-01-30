<?php
namespace App\Globals;

use App\Models\Tbl_purchase_order;
use App\Models\Tbl_bill_item_line;
use App\Models\Tbl_bill;
use App\Globals\AccountingTransaction;
use App\Globals\Warehouse2;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionEnterBills
{
	public static function countTransaction($shop_id, $vendor_id)
	{
		return Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed',0)->count();
	}
    public static function info($shop_id, $bill_id)
    {
        return Tbl_bill::vendor()->where("bill_shop_id", $shop_id)->where("bill_id", $bill_id)->first();
    }
    public static function info_item($bill_id)
    {
        return Tbl_bill_item_line::um()->item()->where("itemline_bill_id", $bill_id)->get();        
    }
    public static function get($shop_id, $paginate = null, $search_keyword = null, $status = null)
    {
        $data = Tbl_bill::vendor()->where('bill_shop_id', $shop_id);
       
        if($search_keyword)
        {
            $data->where(function($q) use ($search_keyword)
            {   
                $q->orWhere("vendor_company", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_last_name", "LIKE", "%$search_keyword%");
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("bill_id", "LIKE", "%$search_keyword%");
                $q->orWhere("bill_total_amount", "LIKE", "%$search_keyword%");
            });
        }

        if($status != 'all')
        {
            $tab = 0;
            
            if($status == 'open')
            {
                $tab = 0;
            }
            if($status == 'closed')
            {
                $tab = 1;
            }
            $data->where('bill_is_paid',$tab);

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
	public static function postInsert($ri_id, $shop_id, $insert, $insert_item)
	{
    	$val = AccountingTransaction::vendorValidation($insert, $insert_item);
    
        if(!$val)
        {
    		$ins['bill_shop_id']          = $shop_id;
            $ins['bill_ri_id']            = $ri_id;
    		$ins['transaction_refnum']    = $insert['transaction_refnumber'];
            $ins['bill_vendor_id']        = $insert['vendor_id'];
            $ins['bill_mailing_address']  = $insert['vendor_address'];
            $ins['bill_vendor_email']     = $insert['vendor_email'];
            $ins['bill_terms_id']         = $insert['vendor_terms'];
            $ins['bill_date']         	  = date("Y-m-d", strtotime($insert['transaction_date']));
            $ins['bill_due_date']         = date("Y-m-d", strtotime($insert['transaction_duedate']));
            $ins['bill_memo']             = $insert['vendor_memo'];
            $ins['date_created']		  = Carbon::now();
            $ins['inventory_only']		  = 0;

             /* TOTAL */
            $total = collect($insert_item)->sum('item_amount');

            $ins['bill_total_amount'] = $total;
            
            /*INSERT RI HERE*/
            $enter_bills_id = Tbl_bill::insertGetId($ins);
            
            /* Transaction Journal */
            $entry["reference_module"]  = "enter-bills";
            $entry["reference_id"]      = $enter_bills_id;
            $entry["name_id"]           = $insert['vendor_id'];
            $entry["total"]             = collect($insert_item)->sum('item_amount');
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';            

            $return = Self::insertLine($enter_bills_id, $insert_item, $entry);
            
            $return = $enter_bills_id;

            $warehouse_id = Warehouse2::get_current_warehouse($shop_id);

            if(!$ri_id) // ENTER BILL
            {
                AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'enter_bills', $enter_bills_id, 'Refill upon creating ENTER BILLS'.$ins['transaction_refnum']);
            }
            else // RECEIVE INVENTORY
            {
                AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'receive_inventory', $ri_id, 'Refill upon RECEIVING INVENTORY '.$ins['transaction_refnum']);
            }
        }
        else
        {
            $return = $val;
        }

        return $return;
	}

    public static function postUpdate($enter_bills_id, $ri_id, $shop_id, $insert, $insert_item)
    {
        $val = AccountingTransaction::vendorValidation($insert, $insert_item);
    
        if(!$val)
        {
            $update['bill_shop_id']          = $shop_id;
            $update['bill_ri_id']            = $ri_id;
            $update['transaction_refnum']    = $insert['transaction_refnumber'];
            $update['bill_vendor_id']        = $insert['vendor_id'];
            $update['bill_mailing_address']  = $insert['vendor_address'];
            $update['bill_vendor_email']     = $insert['vendor_email'];
            $update['bill_terms_id']         = $insert['vendor_terms'];
            $update['bill_date']             = date("Y-m-d", strtotime($insert['transaction_date']));
            $update['bill_due_date']         = date("Y-m-d", strtotime($insert['transaction_duedate']));
            $update['bill_memo']             = $insert['vendor_memo'];
            $update['date_created']          = Carbon::now();
            $update['inventory_only']        = 0;

             /* TOTAL */
            $total = collect($insert_item)->sum('item_amount');

            $update['bill_total_amount'] = $total;
            
            /*INSERT RI HERE*/
            Tbl_bill::where('bill_id', $enter_bills_id)->update($update);
            
            /* Transaction Journal */
            $entry["reference_module"]  = "enter-bills";
            $entry["reference_id"]      = $enter_bills_id;
            $entry["name_id"]           = $insert['vendor_id'];
            $entry["total"]             = collect($insert_item)->sum('item_amount');
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';            

            Tbl_bill_item_line::where("itemline_bill_id", $enter_bills_id)->delete();

            $return = Self::insertLine($enter_bills_id, $insert_item, $entry);
            $return = $enter_bills_id;

            $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
            /* UPDATE INVENTORY HERE */
            if(!$ri_id) // ENTER BILL
            {
                AccountingTransaction::inventory_refill_update($shop_id, $warehouse_id, $insert_item, 'enter_bills', $enter_bills_id); 
                AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'enter_bills', $enter_bills_id, 'Refill upon creating ENTER BILLS'.$ins['transaction_refnum']);
            }
            else // RECEIVE INVENTORY
            {
                AccountingTransaction::inventory_refill_update($shop_id, $warehouse_id, $insert_item, 'receive_inventory', $ri_id); 
                AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'receive_inventory', $ri_id, 'Refill upon RECEIVING INVENTORY '.$ins['transaction_refnum']);
            }
        }
        else
        {
            $return = $val;
        }

        return $return;
    }

    public static function insertLine($enter_bills_id, $insert_item, $entry)
    {
        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {   
            $itemline[$key]['itemline_bill_id']      = $enter_bills_id;
            $itemline[$key]['itemline_ref_id']       = $value['item_ref_id'];
            $itemline[$key]['itemline_ref_name']     = $value['item_ref_name'];
            $itemline[$key]['itemline_item_id']      = $value['item_id'];
            $itemline[$key]['itemline_description']  = $value['item_description'];
            $itemline[$key]['itemline_um']           = $value['item_um'];
            $itemline[$key]['itemline_qty']          = $value['item_qty'];
            $itemline[$key]['itemline_rate']         = $value['item_rate'];
            $itemline[$key]['itemline_amount']       = $value['item_amount'];

        }
        if(count($itemline) > 0)
        {
            Tbl_bill_item_line::insert($itemline);
            $return = AccountingTransaction::entry_data($entry, $insert_item);
        }

        return $return;
    }
}