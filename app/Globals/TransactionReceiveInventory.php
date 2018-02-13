<?php
namespace App\Globals;


use App\Models\Tbl_receive_inventory_line;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_receive_inventory;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_debit_memo;
use App\Models\Tbl_bill;
use Carbon\Carbon;
use Session;
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
        return $count;
	}
    public static function info($shop_id, $ri_id)
    {
        return Tbl_receive_inventory::vendor()->where("ri_shop_id", $shop_id)->where("ri_id", $ri_id)->first();
    }
    public static function info_item($ri_id)
    {
        return Tbl_receive_inventory_line::um()->item()->where("riline_ri_id", $ri_id)->get();        
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
        $val = AccountingTransaction::vendorValidation($insert, $insert_item, 'receive_inventory');
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
            $ins['ri_remarks']          = $insert['vendor_remarks'] != null ? $insert['vendor_remarks'] : '';
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

            if($bill)
            {
                Self::insertLine($shop_id, $receive_inventory_id, $insert_item);
                $return = $receive_inventory_id;
            }

        }
        else
        {
            $return = $val;
        }
        return $return;
	}

    public static function postUpdate($receive_inventory_id, $shop_id, $insert, $insert_item)
    {
        $val = AccountingTransaction::vendorValidation($insert, $insert_item);
        if(!$val)
        {
            $update['ri_shop_id']          = $shop_id;
            $update['transaction_refnum']  = $insert['transaction_refnumber'];
            $update['ri_vendor_id']        = $insert['vendor_id'];
            $update['ri_mailing_address']  = $insert['vendor_address'];
            $update['ri_vendor_email']     = $insert['vendor_email'];
            $update['ri_terms_id']         = $insert['vendor_terms'];
            $update['ri_date']             = date("Y-m-d", strtotime($insert['transaction_date']));
            $update['ri_due_date']         = date("Y-m-d", strtotime($insert['transaction_duedate']));
            $update['ri_remarks']          = $insert['vendor_remarks'] != null ? $insert['vendor_remarks'] : '';
            $update['ri_memo']             = $insert['vendor_memo'];
            $update['date_created']        = Carbon::now();
            $update['inventory_only']      = 1;

            /* TOTAL */
            $total = collect($insert_item)->sum('item_amount');
            $update['ri_total_amount'] = $total;

        
            /*INSERT RI HERE*/
            Tbl_receive_inventory::where('ri_id',$receive_inventory_id)->update($update);
            Tbl_receive_inventory_line::where('riline_ri_id', $receive_inventory_id)->delete();

            /*INSERT ENTER BILL HERE*/
            $bill = Tbl_bill::where('bill_ri_id', $receive_inventory_id)->first();
            
            if($bill)
            {
                TransactionEnterBills::postUpdate($bill->bill_id, $receive_inventory_id, $shop_id, $insert, $insert_item);
            }

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
            $itemline[$key]['riline_ref_name']     = $value['item_ref_name'];
            $itemline[$key]['riline_ref_id']       = $value['item_ref_id'];
            $itemline[$key]['riline_description']  = $value['item_description'];
            $itemline[$key]['riline_um']           = $value['item_um'];
            $itemline[$key]['riline_qty']          = $value['item_qty'];
            $itemline[$key]['riline_rate']         = $value['item_rate'];
            $itemline[$key]['riline_amount']       = $value['item_amount'];

        }
        if(count($itemline) > 0)
        {
            $return = Tbl_receive_inventory_line::insert($itemline);   
        }
        return $return;
    }
    public static function checkPolineQty($po_id, $ri_id)
    {
        $poline = Tbl_purchase_order_line::where('poline_po_id', $po_id)->get();

        $ctr = 0;
        foreach ($poline as $key => $value)
        {
            $receivedline = Tbl_receive_inventory_line::where('riline_ri_id', $ri_id)->where('riline_ref_name', 'purchase_order')->where('riline_item_id', $value->poline_item_id)->where('riline_ref_id',$po_id)->first();
            
            $update['poline_qty'] = $value->poline_qty - $receivedline->riline_qty;
            
            Tbl_purchase_order_line::where('poline_id', $value->poline_id)->update($update);    

            if($update['poline_qty'] <= 0)
            {
                $ctr++;
            }
        }
        if($ctr >= count($poline))
        {
            $updates["po_is_billed"] = $ri_id;
            Tbl_purchase_order::where("po_id",$po_id)->update($updates);
        }
    }
    public static function appliedTransaction($shop_id, $ri_id)
    {
        if($ri_id != null)
        {
            $applied_transaction = Session::get('applied_transaction');
            if($applied_transaction > 0)
            {
                foreach ($applied_transaction as $key => $value)
                { 
                    Self::checkPolineQty($key, $ri_id);
                } 
            }  
        }

        Self::insert_acctg_transaction($shop_id, $ri_id, $applied_transaction);
    }
    public static function insert_acctg_transaction($shop_id, $transaction_id, $applied_transaction = array())
    {
        $get_transaction = Tbl_receive_inventory::where("ri_shop_id", $shop_id)->where("ri_id", $transaction_id)->first();
        $transaction_data = null;
        if($get_transaction)
        {
            $transaction_data['transaction_ref_name'] = "receive_inventory";
            $transaction_data['transaction_ref_id'] = $transaction_id;
            $transaction_data['transaction_list_number'] = $get_transaction->transaction_refnum;
            $transaction_data['transaction_date'] = $get_transaction->ri_date;

            $attached_transaction_data = null;
            if(count($applied_transaction) > 0)
            {
                foreach ($applied_transaction as $key => $value) 
                {
                    $get_data = Tbl_purchase_order::where("po_shop_id", $shop_id)->where("po_id", $key)->first();
                    if($get_data)
                    {
                        $attached_transaction_data[$key]['transaction_ref_name'] = "purchase_order";
                        $attached_transaction_data[$key]['transaction_ref_id'] = $key;
                        $attached_transaction_data[$key]['transaction_list_number'] = $get_data->transaction_refnum;
                        $attached_transaction_data[$key]['transaction_date'] = $get_data->po_date;
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