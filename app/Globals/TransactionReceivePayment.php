<?php
namespace App\Globals;

use App\Models\Tbl_credit_memo;
use App\Models\Tbl_receive_payment;
use App\Models\Tbl_receive_payment_line;
use Carbon\Carbon;
use DB;
use App\Globals\AccountingTransaction;
use App\Globals\Invoice;
use App\Globals\Accounting;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionReceivePayment
{
	public static function countAvailableCredit($shop_id, $customer_id)
	{
		return Tbl_credit_memo::where("cm_shop_id", $shop_id)->where("cm_customer_id", $customer_id)->where("cm_type",1)->where("cm_used_ref_name","retain_credit")->count();
	}
	public static function postInsert($shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item);
		if(!$val)
		{
			$insert["rp_shop_id"]           = $shop_id;
	        $insert["rp_customer_id"]       = $insert['customer_id']; 
	        $insert["transaction_refnum"]   = $insert['transaction_refnum'];
	        $insert["rp_customer_email"]    = $insert['customer_email'];
	        $insert["rp_ar_account"]        = $insert['rp_ar_account'];
	        $insert["rp_date"]              = $insert['transaction_date'];
	        $insert["rp_total_amount"]      = $insert['rp_total_amount'];
	        $insert["rp_payment_method"]    = $insert['transaction_payment_method'];
	        $insert["rp_memo"]              = $insert['customer_memo'];
	        $insert["date_created"]         = Carbon::now();

        	$rcvpayment_id  = Tbl_receive_payment::insertGetId($insert);

        	$val = Self::insertline($rcvpayment_id, $insert_item);

        	/* Transaction Journal */
	        $entry["reference_module"]      = "receive-payment";
	        $entry["reference_id"]          = $rcvpayment_id;
	        $entry["name_id"]               = $insert["rp_customer_id"];
	        $entry["total"]                 = $insert["rp_total_amount"];
	        $entry_data[0]['account_id']    = $insert["rp_ar_account"];
	        $entry_data[0]['vatable']       = 0;
	        $entry_data[0]['discount']      = 0;
	        $entry_data[0]['entry_amount']  = $insert["rp_total_amount"];

   	        $entry_journal = Accounting::postJournalEntry($entry, $entry_data);

		}
		else
		{
			$return = $val;
		}
		return $return;
	}
	public static function insertline($rcvpayment_id, $insert_item)
	{
		foreach ($insert_item as $key => $value) 
		{
            $insert_line[$key]["rpline_rp_id"]            = $rcvpayment_id;
            $insert_line[$key]["rpline_reference_name"]   = $value['rpline_reference_name'];
            $insert_line[$key]["rpline_reference_id"]     = $value['rpline_reference_id'];
            $insert_line[$key]["rpline_amount"]    		  = $value['rpline_amount'];

            if($insert_line["rpline_reference_name"] == 'invoice')
            {
                $ret = Invoice::updateAmountApplied($insert_line["rpline_reference_id"]);
            }
		}
		$return = null;
		if(count($insert_line) > 0)
		{			
			$return = 1;
            Tbl_receive_payment_line::insert($insert_line);
		}
		return $return;
	}
}