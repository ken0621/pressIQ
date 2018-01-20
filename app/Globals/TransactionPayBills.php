<?php
namespace App\Globals;

use App\Models\Tbl_purchase_order;
use App\Models\Tbl_pay_bill_line;
use App\Models\Tbl_pay_bill;
use App\Models\Tbl_bill;

use App\Globals\AccountingTransaction;
use Carbon\Carbon;

use Validator;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionPayBills
{
	public static function info($shop_id, $paybill_id)
    {
        return Tbl_pay_bill::where("paybill_shop_id", $shop_id)->where("paybill_id", $paybill_id)->first();
    }
    public static function info_item($shop_id, $vendor_id, $paybill_id)
    {
        $bill_in_paybill = Tbl_pay_bill_line::select("pbline_reference_id")->where("pbline_reference_name", 'bill')->where("pbline_pb_id", $paybill_id)->get()->toArray();

        return  Tbl_bill::appliedPayment($shop_id)->byVendor($shop_id, $vendor_id)->payBill($paybill_id, $bill_in_paybill)->orderBy("bill_id")->get()->toArray();
    }
	public static function get($shop_id, $paginate = null, $search_keyword = null)
	{
		$data = Tbl_pay_bill::vendor()->where('paybill_shop_id', $shop_id);

		if($search_keyword)
        {
            $data->where(function($q) use ($search_keyword)
            {   
                $q->orWhere("vendor_company", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("vendor_last_name", "LIKE", "%$search_keyword%");
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("paybill_id", "LIKE", "%$search_keyword%");
                $q->orWhere("paybill_total_amount", "LIKE", "%$search_keyword%");
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
		$val = Self::payBillsValidation($insert, $insert_item);
		if(!$val)
		{
			$ins["paybill_shop_id"]			  = $shop_id;
			$ins["paybill_vendor_id"]         = $insert['vendor_id'];
			$ins["transaction_refnum"]        = $insert['transaction_refnumber'];
	        $ins["paybill_ap_id"]             = $insert['paybill_ap_id'];
	        $ins["paybill_date"]              = date('Y-m-d', strtotime($insert['paybill_date']));
	        $ins["paybill_payment_method"]    = $insert['paybill_payment_method'];
	        $ins["paybill_ref_num"]    		  = $insert['paybill_ref_num'];
	        $ins["paybill_memo"]              = $insert['paybill_memo'];
	        $ins["paybill_date_created"]      = Carbon::now();

	        /*TOTAL*/
	        $total = collect($insert_item)->sum('item_amount');
	        $ins['paybill_total_amount'] = $total;

	        /*INSERT PB HERE*/
	        $pay_bill_id = Tbl_pay_bill::insertGetId($ins);
	               
	        /* Transaction Journal */
	        $entry["reference_module"]  = "pay-bill";
	        $entry["reference_id"]      = $pay_bill_id;
	        $entry["name_id"]           = $insert['vendor_id'];
	        $entry["total"]             = $total;
	        $entry["vatable"]           = '';
	        $entry["discount"]          = '';
	        $entry["ewt"]               = '';

	        $return = Self::insertLine($pay_bill_id, $shop_id, $insert_item, $entry);
	        $return = $pay_bill_id;
		}
		else
		{
			$return = $val;
		}

		return $return;
	}
	public static function postUpdate($pay_bill_id, $shop_id, $insert, $insert_item)
	{
		$val = Self::payBillsValidation($insert, $insert_item);
		if(!$val)
		{
			$ins["paybill_shop_id"]			  = $shop_id;
			$ins["paybill_vendor_id"]         = $insert['vendor_id'];
			$ins["transaction_refnum"]        = $insert['transaction_refnumber'];
	        $ins["paybill_ap_id"]             = $insert['paybill_ap_id'];
	        $ins["paybill_date"]              = date('Y-m-d', strtotime($insert['paybill_date']));
	        $ins["paybill_payment_method"]    = $insert['paybill_payment_method'];
	        $ins["paybill_ref_num"]    		  = $insert['paybill_ref_num'];
	        $ins["paybill_memo"]              = $insert['paybill_memo'];
	        $ins["paybill_date_created"]      = Carbon::now();


	        /*TOTAL*/
	        $total = collect($insert_item)->sum('item_amount');
	        $ins['paybill_total_amount'] = $total;

	        /*INSERT PB HERE*/
	        Tbl_pay_bill::where('paybill_id', $pay_bill_id)->update($ins);
	               
	        /* Transaction Journal */
	        $entry["reference_module"]  = "pay-bill";
	        $entry["reference_id"]      = $pay_bill_id;
	        $entry["name_id"]           = $insert['vendor_id'];
	        $entry["total"]             = $total;
	        $entry["vatable"]           = '';
	        $entry["discount"]          = '';
	        $entry["ewt"]               = '';

			Tbl_pay_bill_line::where('pbline_pb_id', $pay_bill_id)->delete();

	        $return = Self::insertLine($pay_bill_id, $shop_id, $insert_item, $entry);

	        $return = $pay_bill_id;
		}
		else
		{
			$return = $val;
		}

		return $return;
	}
	public static function payBillsValidation($insert, $insert_item)
	{
		$return = null;
        if(!$insert["vendor_id"])
        {
            $return .= '<li style="list-style:none">Please Select Vendor.</li>';          
        }
        if(!$insert['paybill_ap_id'])
        {
            $return .= '<li style="list-style:none">Please Select Payment Account.</li>';          
        }

		$rules['transaction_refnumber'] = 'required';

        $validator = Validator::make($insert, $rules);
        if($validator->fails())
        {
            foreach ($validator->messages()->all('<li style="list-style:none">:message</li><br>') as $keys => $message)
            {
                $return .= $message;
            }
        }
        return $return;
	}

	public static function insertLine($pay_bill_id, $shop_id, $insert_item, $entry)
    {

        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {   
        	if($value["line_is_checked"] == 1)
        	{
	        	$itemline["pbline_pb_id"]            = $pay_bill_id;
	            $itemline["pbline_reference_name"]   = $value['pbline_reference_name'];
	            $itemline["pbline_reference_id"]     = $value['pbline_reference_id'];
	            $itemline["pbline_amount"]           = $value['item_amount'];

	            Tbl_pay_bill_line::insert($itemline);

		        if($itemline["pbline_reference_name"] == 'bill')
		        {
		        	Self::updateAppliedAmount($itemline["pbline_reference_id"], $shop_id);
		        }
			}
			else
	    	{
	    		Self::updateAppliedAmount($value['pbline_reference_id'], $shop_id);   
	    	}
        }
        
        $return = AccountingTransaction::entry_data($entry, $insert_item);

        return $return;
    }

    public static function updateAppliedAmount($bill_id, $shop_id)
    {

    	$payment_applied = Tbl_bill::appliedPayment($shop_id)->where("bill_id",$bill_id)->value("amount_applied");

    	$update['bill_applied_payment'] = $payment_applied;
 
    	Tbl_bill::where('bill_id', $bill_id)->update($update);

    	$check_bill_amount = Tbl_bill::where('bill_id',$bill_id)->value('bill_total_amount');
    	$check_applied_payment = Tbl_bill::where('bill_id',$bill_id)->value('bill_applied_payment');
    	

    	if($check_applied_payment == $check_bill_amount)
    	{
    		$update['bill_is_paid'] = 1;
    	}
    	else
    	{
    		$update['bill_is_paid'] = 0;
    	} 	

    	Tbl_bill::where('bill_id', $bill_id)->update($update);
    }

}