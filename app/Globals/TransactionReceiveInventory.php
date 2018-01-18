<?php
namespace App\Globals;


use App\Models\Tbl_receive_inventory_line;
use App\Models\Tbl_receive_inventory;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_debit_memo;
use App\Models\Tbl_bill;
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

    public static function info($shop_id, $ri_id)
    {
        return Tbl_receive_inventory::vendor()->where("ri_shop_id", $shop_id)->where("ri_id", $ri_id)->first();
    }
    public static function info_item($ri_id)
    {
        return Tbl_receive_inventory_line::um()->where("riline_ri_id", $ri_id)->get();        
    }
    
    public static function get($shop_id, $paginate = null, $search_keyword = null)
    {
        $data = Tbl_receive_inventory::vendor()->where('ri_shop_id', $shop_id);

        if($search_keyword)
        {
            $data->where(function($q) use ($search_keyword)
            {   
                $q->orWhere("vendor_company", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_last_name", "LIKE", "%$search_keyword%");
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("ri_id", "LIKE", "%$search_keyword%");
                $q->orWhere("ri_total_amount", "LIKE", "%$search_keyword%");
            });
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
            $ins['ri_date']         	= date("Y-m-d", strtotime($insert['transaction_date']));
            $ins['ri_due_date']         = date("Y-m-d", strtotime($insert['transaction_duedate']));
            $ins['ri_memo']             = $insert['vendor_memo'];
            $ins['date_created']		= Carbon::now();
            $ins['inventory_only']		= 1;

            /* TOTAL */
            $total = collect($insert_item)->sum('item_amount');

            $ins['ri_total_amount'] = $total;

            /*INSERT RI HERE*/
            $receive_inventory_id = Tbl_receive_inventory::insertGetId($ins);

            /*INSERT ENTER BILL HERE*/
            $bill = TransactionEnterBills::postInsert($receive_inventory_id, $shop_id, $insert, $insert_item);

            /* Transaction Journal */
            /*$entry["reference_module"]  = "receive-inventory";
            $entry["reference_id"]      = $receive_inventory_id;
            $entry["name_id"]           = $insert['vendor_id'];
            $entry["total"]             = collect($insert_item)->sum('itemline_amount');
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';*/

            $return = Self::insertLine($shop_id, $receive_inventory_id, $insert_item);
            $return = $receive_inventory_id;
        }
        else
        {
            $return = $val;
        }
        return $return;
	}

    public static function insertLine($shop_id, $receive_inventory_id, $insert_item)
    {
        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {   
            $itemline[$key]['riline_ri_id']        = $receive_inventory_id;
            $itemline[$key]['riline_item_id']      = $value['item_id'];
            //$itemline[$key]['riline_ref_name']      = $value['reference_name'];
            //$itemline[$key]['riline_ref_id']        = $value['reference_id'];
            $itemline[$key]['riline_description']  = $value['item_description'];
            $itemline[$key]['riline_um']           = $value['item_um'];
            $itemline[$key]['riline_qty']          = $value['item_qty'];
            $itemline[$key]['riline_rate']         = $value['item_rate'];
            $itemline[$key]['riline_amount']       = $value['item_amount'];

        }
        if(count($itemline) > 0)
        {
            $return = Tbl_receive_inventory_line::insert($itemline);   
            Tbl_bill::where('bill_shop_id', $shop_id)->where('bill_ri_id', $receive_inventory_id)->first();
        }

        return $return;
    }
}