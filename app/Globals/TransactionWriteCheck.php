<?php
namespace App\Globals;

use App\Models\Tbl_purchase_order;
use App\Models\Tbl_write_check;
use App\Models\Tbl_vendor;
use App\Models\Tbl_customer;
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
		return Tbl_purchase_order::where('po_shop_id',$shop_id)->where('po_vendor_id', $vendor_id)->where('po_is_billed','!=', '0')->count();
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
            	//dd($value->wc_reference_name);
                $c_data = Tbl_customer::where("customer_id",$value->wc_reference_id)->first();
                
                $name = isset($c_data) ? ($c_data->company != "" ? $c_data->company : $c_data->first_name." ".$c_data->last_name) : "";
            }

            $data[$key]->name = $name;
            //dd($data);
        }
		
		return $data;
	}

	public static function postInsert($shop_id, $insert, $insert_item)
	{
		$val = AccountingTransaction::vendorValidation($insert, $insert_item);
		if(!$val)
		{
			$ins['wc_shop_id']				= $shop_id;
			$ins['transaction_refnum']		= $insert['transaction_refnumber'];
			$ins['wc_reference_id']         = $insert['vendor_id'];
	        $ins['wc_reference_name']       = $insert['wc_reference_name'];
	        $ins['wc_customer_vendor_email']= $insert['wc_customer_vendor_email'];
	        $ins['wc_mailing_address']      = $insert['wc_mailing_address'];
	        $ins['wc_cash_account']         = 0;
	        $ins['wc_payment_date']         = $insert['wc_payment_date'];
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
        foreach ($insert_item as $key => $value) 
        {   
            $itemline[$key]['wcline_wc_id']       = $write_check_id;
            $itemline[$key]['wcline_item_id']     = $value['item_id'];
            $itemline[$key]['wcline_description'] = $value['item_description'];
            $itemline[$key]['wcline_um']          = $value['item_um'];
            $itemline[$key]['wcline_qty']         = $value['item_qty'];
            $itemline[$key]['wcline_rate']        = $value['item_rate'];
            $itemline[$key]['wcline_amount']      = $value['item_amount'];

        }
        if(count($itemline) > 0)
        {
            //Tbl_write_check_line::insert($itemline);
            $return = AccountingTransaction::entry_data($entry, $insert_item);
        }

        return $return;
    }

}