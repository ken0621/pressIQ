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
		return Tbl_credit_memo::where("cm_shop_id", $shop_id)->where("cm_customer_id", $customer_id)->where("cm_type",1)->where("cm_used_ref_name","retain_credit")->where('cm_status',0)->count();
	}

	public static function get($shop_id, $paginate = null, $search_keyword = null)
	{
		$data = Tbl_receive_payment::customer()->where('rp_shop_id', $shop_id);

		if($search_keyword)
		{
			$data->where(function($q) use ($search_keyword)
            {
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("rp_id", "LIKE", "%$search_keyword%");
                $q->orWhere("company", "LIKE", "%$search_keyword%");
                $q->orWhere("first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("last_name", "LIKE", "%$search_keyword%");
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

	public static function info($shop_id, $rp_id)
	{
		return Tbl_receive_payment::customer()->where("rp_shop_id", $shop_id)->where("rp_id", $rp_id)->first();
	}
	public static function info_item($rp_id)
	{
		return Tbl_receive_payment_line::invoice()->where("rpline_rp_id", $rp_id)->get();		
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
	        $insert["rp_payment_ref_no"]	= $insert['transaction_ref_no'];
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
   	        $return = $val;
		}
		else
		{
			$return = $val;
		}
		return $return;
	}

	public static function postUpdate($rp_id, $shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item);
		if(!$val)
		{
			$ins["rp_shop_id"]           = $shop_id;
	        $ins["rp_customer_id"]       = $insert['customer_id']; 
	        $ins["transaction_refnum"]   = $insert['transaction_refnum'];
	        $ins["rp_customer_email"]    = $insert['customer_email'];
	        $ins["rp_ar_account"]        = $insert['rp_ar_account'];
	        $ins["rp_date"]              = $insert['transaction_date'];
	        $ins["rp_total_amount"]      = $insert['rp_total_amount'];
	        $ins["rp_payment_method"]    = $insert['transaction_payment_method'];
	        $ins["rp_payment_ref_no"]	= $insert['transaction_ref_no'];
	        $ins["rp_memo"]              = $insert['customer_memo'];
	        $ins["date_created"]         = Carbon::now();

        	Tbl_receive_payment::where('rp_id', $rp_id)->update($ins);

        	/* INSERT CODE HERE THAT WILL RETURN THE PAYMENT ON THE INVOICE */
        	Tbl_receive_payment_line::where('rpline_rp_id', $rp_id)->delete();
        	$val = Self::insertline($rp_id, $insert_item);

        	/* Transaction Journal */
	        $entry["reference_module"]      = "receive-payment";
	        $entry["reference_id"]          = $rp_id;
	        $entry["name_id"]               = $ins["rp_customer_id"];
	        $entry["total"]                 = $ins["rp_total_amount"];
	        $entry_data[0]['account_id']    = $ins["rp_ar_account"];
	        $entry_data[0]['vatable']       = 0;
	        $entry_data[0]['discount']      = 0;
	        $entry_data[0]['entry_amount']  = $ins["rp_total_amount"];

   	        $entry_journal = Accounting::postJournalEntry($entry, $entry_data);
   	        $return = $val;
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

            if($insert_line[$key]["rpline_reference_name"] == 'invoice')
            {
                $ret = Invoice::updateAmountApplied($insert_line[$key]["rpline_reference_id"]);
            }
		}
		$return = null;
		if(count($insert_line) > 0)
		{			
			$return = $rcvpayment_id;
            Tbl_receive_payment_line::insert($insert_line);
		}
		return $return;
	}
}