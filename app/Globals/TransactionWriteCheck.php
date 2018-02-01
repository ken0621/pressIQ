<?php
namespace App\Globals;
use App\Models\Tbl_write_check_account_line;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_write_check_line;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_write_check;
use App\Models\Tbl_customer;
use App\Models\Tbl_vendor;
use App\Models\Tbl_bill;

use App\Globals\AccountingTransaction;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionWriteCheck
{
	public static function countTransaction($shop_id, $vendor_id)
	{
		return Tbl_bill::where('bill_shop_id',$shop_id)->where('bill_vendor_id', $vendor_id)->where('bill_is_paid', 0)->count();
	}
    public static function info($shop_id, $wc_id)
    {
        return Tbl_write_check::vendor()->customer()->where("wc_shop_id", $shop_id)->where("wc_id", $wc_id)->first();
    }
    public static function info_item($wc_id)
    {
        return Tbl_write_check_line::um()->where("wcline_wc_id", $wc_id)->get();       
    }
    public static function acc_line($wc_id)
    {
        return Tbl_write_check_account_line::where("accline_wc_id", $wc_id)->get();       
    }
	public static function get($shop_id, $paginate = null, $search_keyword = null)
	{
		$data = Tbl_write_check::vendor()->customer()->where('wc_shop_id', $shop_id);
		
		if($search_keyword)
        {
            $data->where(function($q) use ($search_keyword)
            {   
                $q->orWhere("vendor_company", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_last_name", "LIKE", "%$search_keyword%");

                $q->orWhere("company", "LIKE", "%$search_keyword%");
                $q->orWhere("first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("last_name", "LIKE", "%$search_keyword%");

                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("wc_id", "LIKE", "%$search_keyword%");
                $q->orWhere("wc_total_amount", "LIKE", "%$search_keyword%");
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
	public static function getAllWC($shop_id)
	{
		$data = Tbl_write_check::where("wc_shop_id", $shop_id)->get();
        
        foreach ($data as $key => $value) 
        {
            $v_data = Tbl_vendor::where("vendor_id",$value->wc_reference_id)->first();

            $name = isset($v_data) ? ($v_data->vendor_company != "" ? $v_data->vendor_company : $v_data->vendor_first_name." ".$v_data->vendor_last_name) : "";
            
            if($value->wc_reference_name == "customer")
            {
                $c_data = Tbl_customer::where("customer_id",$value->wc_reference_id)->first();
                
                $name = isset($c_data) ? ($c_data->company != "" ? $c_data->company : $c_data->first_name." ".$c_data->last_name) : "";
            }

            $data[$key]->name = $name;
        }
		
		return $data;
	}

	public static function postInsert($shop_id, $insert, $insert_item)
	{
		$val = AccountingTransaction::vendorValidation($insert, $insert_item, 'write_check');
		if(!$val)
		{
			$ins['wc_shop_id']				= $shop_id;
			$ins['transaction_refnum']		= $insert['transaction_refnumber'];
			$ins['wc_reference_id']         = $insert['vendor_id'];
	        $ins['wc_reference_name']       = $insert['wc_reference_name'];
	        $ins['wc_customer_vendor_email']= $insert['vendor_email'];
	        $ins['wc_mailing_address']      = $insert['wc_mailing_address'];
	        $ins['wc_cash_account']         = 0;
	        $ins['wc_payment_date']         = date('Y-m-d', strtotime($insert['wc_payment_date']));
	        $ins['wc_memo']                 = $insert['wc_memo'];
	        $ins['date_created']            = Carbon::now();

	        /*TOTAL*/
	        $total = collect($insert_item)->sum('item_amount');
	        $ins['wc_total_amount'] = $total;
	       
	        /*INSERT CV HERE*/
	        $write_check_id = Tbl_write_check::insertGetId($ins);

	        /* Transaction Journal */
	        $entry["reference_module"]  = "write-check";
	        $entry["reference_id"]      = $write_check_id;
	        $entry["name_id"]           = $insert['vendor_id'];
	        $entry["name_reference"]    = $insert['wc_reference_name'];
	        $entry["total"]             = collect($insert_item)->sum('itemline_amount');
	        $entry["vatable"]           = '';
	        $entry["discount"]          = '';
	        $entry["ewt"]               = '';

	        $return = Self::insertLine($write_check_id, $insert_item, $entry);
	        $return = $write_check_id;

            $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
            AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'write_check', $write_check_id, 'Refill upon creating WRITE CHECK '.$ins['transaction_refnum']);
		}
		else
		{
			$return = $val;
		}

        return $return;
	}
    public static function postUpdate($write_check_id, $shop_id, $insert, $insert_item)
    {
        $val = AccountingTransaction::vendorValidation($insert, $insert_item);
        if(!$val)
        {
            $ins['wc_shop_id']              = $shop_id;
            $ins['transaction_refnum']      = $insert['transaction_refnumber'];
            $ins['wc_reference_id']         = $insert['vendor_id'];
            $ins['wc_reference_name']       = $insert['wc_reference_name'];
            $ins['wc_customer_vendor_email']= $insert['vendor_email'];
            $ins['wc_mailing_address']      = $insert['wc_mailing_address'];
            $ins['wc_cash_account']         = 0;
            $ins['wc_payment_date']         = date('Y-m-d', strtotime($insert['wc_payment_date']));
            $ins['wc_memo']                 = $insert['wc_memo'];
            $ins['date_created']            = Carbon::now();

            /*TOTAL*/
            $total = collect($insert_item)->sum('item_amount');
            $ins['wc_total_amount'] = $total;
           
            /*INSERT CV HERE*/
            Tbl_write_check::where('wc_id', $write_check_id)->update($ins);

            /* Transaction Journal */
            $entry["reference_module"]  = "write-check";
            $entry["reference_id"]      = $write_check_id;
            $entry["name_id"]           = $insert['vendor_id'];
            $entry["name_reference"]    = $insert['wc_reference_name'];
            $entry["total"]             = $total;
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';

            Tbl_write_check_line::where('wcline_wc_id', $write_check_id)->delete();
            $return = Self::insertLine($write_check_id, $insert_item, $entry);
            $return = $write_check_id;

            
            $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
            /* UPDATE INVENTORY HERE */
            AccountingTransaction::inventory_refill_update($shop_id, $warehouse_id, $insert_item, 'write_check', $write_check_id); 
            AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'write_check', $write_check_id, 'Refill upon creating WRITE CHECK '.$ins['transaction_refnum']);
        }
        else
        {
            $return = $val;
        }

        return $return;
    }
	public static function insertLine($write_check_id, $insert_item, $entry)
    {
        $itemline = null;
        if($insert_item > 0)
        {
            foreach ($insert_item as $key => $value) 
            {   
                $itemline[$key]['wcline_wc_id']       = $write_check_id;
                $itemline[$key]['wcline_item_id']     = $value['item_id'];
                $itemline[$key]['wcline_ref_id']      = $value['item_ref_id'] != NULL ? $value['item_ref_id'] : 0;
                $itemline[$key]['wcline_ref_name']    = $value['item_ref_name'] != NULL ? $value['item_ref_name'] : '';
                $itemline[$key]['wcline_description'] = $value['item_description'];
                $itemline[$key]['wcline_um']          = $value['item_um'];
                $itemline[$key]['wcline_qty']         = $value['item_qty'];
                $itemline[$key]['wcline_rate']        = $value['item_rate'];
                $itemline[$key]['wcline_amount']      = $value['item_amount'];
            }
                
        }
        if(count($itemline) > 0)
        {
            Tbl_write_check_line::insert($itemline);
            $return = AccountingTransaction::entry_data($entry, $insert_item);
        }

        return $return;
    }
    public static function checkPoQty($wc_id = null, $po_data = array())
    {
        if($wc_id != null)
        {
            if(count($po_data) > 0)
            {
                foreach ($po_data as $key => $value)
                { 
                    Self::checkPolineQty($key, $wc_id);
                }   
            }
        }
    }
    public static function checkPolineQty($po_id, $wc_id)
    {
        $poline = Tbl_purchase_order_line::where('poline_po_id', $po_id)->get();

        $ctr = 0;
        foreach ($poline as $key => $value)
        {
            $wcline = Tbl_write_check_line::where('wcline_wc_id', $wc_id)->where('wcline_item_id', $value->poline_item_id)->where('wcline_ref_name', 'purchase_order')->where('wcline_ref_id',$po_id)->first();
            
            $update['poline_qty'] = $value->poline_qty - $wcline->wcline_qty;       
            Tbl_purchase_order_line::where('poline_id', $value->poline_id)->update($update);    

            if($update['poline_qty'] <= 0)
            {
                $ctr++;
            }
        }
        if($ctr >= count($poline))
        {
            $updates["po_is_billed"] = $wc_id;
            Tbl_purchase_order::where("po_id",$po_id)->update($updates);
        }
    }

}