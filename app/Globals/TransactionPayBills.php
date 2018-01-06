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
	public static function postInsert($shop_id, $insert, $insert_item)
	{
		$val = Self::payBillsValidation($insert, $insert_item);
		if(!$val)
		{
			$ins["paybill_shop_id"]			  = $shop_id;
			$ins["paybill_vendor_id"]         = $insert['vendor_id'];
			$ins["transaction_refnum"]        = $insert['transaction_refnumber'];
	        $ins["paybill_ap_id"]             = $insert['paybill_ap_id'];
	        $ins["paybill_date"]              = $insert['paybill_date'];
	        $ins["paybill_payment_method"]    = $insert['paybill_payment_method'];
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
	        $entry["total"]             = collect($insert_item)->sum('item_amount');
	        $entry["vatable"]           = '';
	        $entry["discount"]          = '';
	        $entry["ewt"]               = '';

	        $return = Self::insertLine($shop_id, $pay_bill_id, $insert_item, $entry);
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
        if(!$insert['vendor_id'])
        {
            $return .= '<li style="list-style:none">Please Select Vendor.</li>';          
        }
        if(!$insert['paybill_ap_id'])
        {
            $return .= '<li style="list-style:none">Please Select Payment Account.</li>';          
        }

		$rules['transaction_refnumber'] = 'required';
        $rules['vendor_id'] = 'required';

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

	public static function insertLine($shop_id, $pay_bill_id, $insert_item, $entry)
    {
    	$pb_shop_id = Tbl_pay_bill_line::PBInfo()->where('paybill_shop_id', $shop_id)->get();
    	die(var_dump($pb_shop_id));
        
        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {   
        	if($value["line_is_checked"] == 1)
        	{
	        	$itemline[$key]["pbline_pb_id"]            = $pay_bill_id;
	            $itemline[$key]["pbline_reference_name"]   = $value['pbline_reference_name'];
	            $itemline[$key]["pbline_reference_id"]     = $value['pbline_reference_id'];
	            $itemline[$key]["pbline_amount"]           = $value['item_amount'];

	            $pay_bill_amount = $itemline[$key]["pbline_amount"];
	        	$bill_id 		 = $itemline[$key]["pbline_reference_id"];
	        	
	        	$check_bill_amount = Tbl_bill::where('bill_id',$bill_id)->value('bill_total_amount');// shop_id

	        	if($pay_bill_amount == $check_bill_amount)
	        	{
	        		$update['bill_is_paid'] = 1;
	        	}
	        	else
	        	{
	        		$update['bill_is_paid'] = 0;
	        		
	        	} 	

	        	$payment_applied = Tbl_bill::appliedPayment($pb_shop_id)->where("bill_id",$bill_id)->value("amount_applied");

	        	$update['bill_applied_payment'] = $pay_bill_amount;
	        		
	        	Tbl_bill::where('bill_id', $bill_id)->update($update);
        	}
        	
        }
        
        if(count($itemline) > 0)
        {
            Tbl_pay_bill_line::insert($itemline);
            $return = AccountingTransaction::entry_data($entry, $insert_item);
        }

        return $return;
    }

}