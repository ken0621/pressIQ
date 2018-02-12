<?php
namespace App\Globals;

use App\Models\Tbl_debit_memo;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_debit_memo_line;
use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_requisition_slip_item;
use App\Models\Tbl_purchase_order_line;
use App\Globals\AccountingTransaction;

use Carbon\Carbon;
use Session;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionDebitMemo
{
	public static function getOpenDM($shop_id, $vendor_id)
    {
        return Tbl_debit_memo::where('db_shop_id',$shop_id)->where('db_vendor_id', $vendor_id)->get();
    }
    public static function info($shop_id, $dm_id)
    {
        return Tbl_debit_memo::vendor()->where('db_shop_id',$shop_id)->where('db_id', $dm_id)->first();
    }
    public static function info_item($dm_id)
    {
        return Tbl_debit_memo_line::um()->db_item()->where('dbline_db_id', $dm_id)->get();
    }

    public static function get($shop_id, $paginate = null, $search_keyword = null, $status = null)
    {
        $data = Tbl_debit_memo::Vendor()->where('db_shop_id',$shop_id);

        if($search_keyword)
        {
            $data->where(function($q) use ($search_keyword)
            {   
                $q->orWhere("vendor_company", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_last_name", "LIKE", "%$search_keyword%");
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("db_id", "LIKE", "%$search_keyword%");
                $q->orWhere("db_amount", "LIKE", "%$search_keyword%");
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
            $data->where('db_memo_status',$tab);
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
        $val = AccountingTransaction::vendorValidation($insert, $insert_item, 'debit_memo');
        if(!$val)
        {
            $ins['db_shop_id']          = $shop_id;
            $ins['transaction_refnum']  = $insert['transaction_refnumber'];
            $ins['db_vendor_id']        = $insert['vendor_id'];
            $ins['db_vendor_email']     = $insert['vendor_email'];
            $ins['db_date']             = date('Y-m-d', strtotime($insert['transaction_date']));
            $ins['db_message']          = $insert['vendor_message'];
            $ins['db_memo']             = $insert['vendor_memo'];
            $ins['date_created']        = Carbon::now();

            $total = collect($insert_item)->sum('item_amount');
            $ins['db_amount'] = $total;

            /* INSERT DM IN DATABASE */
            $dm_id = Tbl_debit_memo::insertGetId($ins);

            /* Transaction Journal */
            $entry["reference_module"]  = "debit-memo";
            $entry["reference_id"]      = $dm_id;
            $entry["name_id"]           = $insert['vendor_id'];
            $entry["total"]             = $total;
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';
            
            $return = Self::insertLine($dm_id, $insert_item, $entry);
            $return = $dm_id;
        }
        else
        {
            $return = $val;
        }  
        return $return;
    }

    public static function postUpdate($dm_id, $shop_id, $insert, $insert_item)
    {
        $val = AccountingTransaction::vendorValidation($insert, $insert_item);
        if(!$val)
        {
            $ins['db_shop_id']          = $shop_id;
            $ins['transaction_refnum']  = $insert['transaction_refnumber'];
            $ins['db_vendor_id']        = $insert['vendor_id'];
            $ins['db_vendor_email']     = $insert['vendor_email'];
            $ins['db_date']             = date('Y-m-d', strtotime($insert['transaction_date']));
            $ins['db_message']          = $insert['vendor_message'];
            $ins['db_memo']             = $insert['vendor_memo'];
            $ins['date_created']        = Carbon::now();

            $total = collect($insert_item)->sum('item_amount');
            $ins['db_amount'] = $total;

            /* INSERT DM IN DATABASE */
            Tbl_debit_memo::where('db_id', $dm_id)->update($ins);

            /* Transaction Journal */
            $entry["reference_module"]  = "debit-memo";
            $entry["reference_id"]      = $dm_id;
            $entry["name_id"]           = $insert['vendor_id'];
            $entry["total"]             = $total;
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';
            
            Tbl_debit_memo_line::where('dbline_db_id', $dm_id)->delete();

            $return = Self::insertLine($dm_id, $insert_item, $entry);
            $return = $dm_id;
        }
        else
        {
            $return = $val;
        }  
        return $return;
    }

    public static function insertLine($dm_id, $insert_item, $entry)
    {
        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {   
            $itemline[$key]['dbline_db_id']        = $dm_id;
            $itemline[$key]['dbline_item_id']      = $value['item_id'];
            $itemline[$key]['dbline_description']  = $value['item_description'];
            $itemline[$key]['dbline_um']           = $value['item_um'];
            $itemline[$key]['dbline_qty']          = $value['item_qty'];
            $itemline[$key]['dbline_rate']         = $value['item_rate'];
            $itemline[$key]['dbline_amount']       = $value['item_amount'];
            $itemline[$key]['dbline_refname']      = $value['item_ref_name'];
            $itemline[$key]['dbline_refid']        = $value['item_ref_id'];

        }
        if(count($itemline) > 0)
        {
            Tbl_debit_memo_line::insert($itemline);
            $return = AccountingTransaction::entry_data($entry, $insert_item);
        }

        return $return;
    }
    public static function appliedTransaction($dm_id)
    {
        if($dm_id != null)
        {
            $applied_transaction = Session::get('applied_transaction');
            if($applied_transaction > 0)
            {
                foreach ($applied_transaction as $key => $value)
                { 
                    Self::checkPolineQty($key, $dm_id);
                } 
            }  
        }
    }
    public static function checkPolineQty($po_id, $dm_id)
    {
        $poline = Tbl_purchase_order_line::where('poline_po_id', $po_id)->get();

        $ctr = 0;
        foreach ($poline as $key => $value)
        {
            $dmline = Tbl_debit_memo_line::where('dbline_db_id', $dm_id)->where('dbline_refname', 'purchase_order')->where('dbline_item_id', $value->poline_item_id)->where('dbline_refid',$po_id)->first();
            
            $update['poline_qty'] = $value->poline_qty - $dmline->dbline_qty;

            Tbl_purchase_order_line::where('poline_id', $value->poline_id)->update($update);    

            if($update['poline_qty'] <= 0)
            {
                $ctr++;
            }
        }
        if($ctr >= count($poline))
        {
            $updates["po_is_billed"] = $dm_id;
            Tbl_purchase_order::where("po_id",$po_id)->update($updates);
        }
    }
   
}