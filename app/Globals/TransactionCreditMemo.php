<?php
namespace App\Globals;

use App\Models\Tbl_credit_memo;
use App\Models\Tbl_credit_memo_line;
use Carbon\Carbon;
use DB;
use App\Globals\AccountingTransaction;
use App\Globals\Warehouse2;
/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionCreditMemo
{
	public static function loadAvailableCredit($shop_id, $customer_id)
	{
		return Tbl_credit_memo::where("cm_shop_id", $shop_id)->where("cm_customer_id", $customer_id)->where("cm_type",1)->where("cm_used_ref_name","retain_credit")->where("cm_status",0)->get();
	}

	public static function info($shop_id, $credit_memo_id)
	{
		return Tbl_credit_memo::customer()->where("cm_shop_id", $shop_id)->where("cm_id", $credit_memo_id)->first();
	}
	public static function info_item($credit_memo_id)
	{
		$data = Tbl_credit_memo_line::cm_item()->um()->where("cmline_cm_id", $credit_memo_id)->get();

		return $data;
	}
	public static function postUpdate($cm_id, $shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item);
		if(!$val)
		{
	        /* SUBTOTAL */
	        $subtotal_price = collect($insert_item)->sum('item_amount');
	        /* OVERALL TOTAL */
	        $overall_price  = convertToNumber($subtotal_price); 

			$return  = null; 
			$ins['cm_shop_id']                  = $shop_id;  
			$ins['cm_customer_id']              = $insert['customer_id'];  
			$ins['transaction_refnum']	 		= $insert['transaction_refnum'];   
	        $ins['cm_customer_email']           = $insert['customer_email'];
	        $ins['cm_customer_billing_address'] = $insert['customer_address'];
	        $ins['cm_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
	        $ins['cm_message']                  = $insert['customer_message'];
	        $ins['cm_memo']                     = $insert['customer_memo'];
	        $ins['cm_amount']                   = $overall_price;
	        $ins['date_created']                = Carbon::now();

	        /* INSERT CREDIT MEMO HERE */
	        Tbl_credit_memo::where('cm_id', $cm_id)->update($ins);;

	        /* Transaction Journal */
	        $entry["reference_module"]  = "credit-memo";
	        $entry["reference_id"]      = $cm_id;
	        $entry["name_id"]           = $insert['customer_id'];
	        $entry["total"]             = $overall_price;
	        $entry["vatable"]           = '';
	        $entry["discount"]          = '';
	        $entry["ewt"]               = '';


	        Tbl_credit_memo_line::where('cmline_cm_id', $cm_id)->delete();
	        $return = Self::insertline($cm_id, $insert_item, $entry);
			$warehouse_id = Warehouse2::get_current_warehouse($shop_id);
			/* UPDATE INVENTORY HERE */
			AccountingTransaction::inventory_refill_update($shop_id, $warehouse_id, $insert_item, 'credit_memo', $cm_id); 
			AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'credit_memo', $cm_id, 'Refill upon creating CREDIT MEMO '.$ins['transaction_refnum']);
		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}	
	public static function postInsert($shop_id, $insert, $insert_item = array())
	{
		$val = AccountingTransaction::customer_validation($insert, $insert_item);
		if(!$val)
		{
	        /* SUBTOTAL */
	        $subtotal_price = collect($insert_item)->sum('item_amount');
	        /* OVERALL TOTAL */
	        $overall_price  = convertToNumber($subtotal_price); 

			$return  = null; 
			$ins['cm_shop_id']                  = $shop_id;  
			$ins['cm_customer_id']              = $insert['customer_id'];  
			$ins['transaction_refnum']	 		= $insert['transaction_refnum'];   
	        $ins['cm_customer_email']           = $insert['customer_email'];
	        $ins['cm_customer_billing_address'] = $insert['customer_address'];
	        $ins['cm_date']                     = date("Y-m-d", strtotime($insert['transaction_date']));
	        $ins['cm_message']                  = $insert['customer_message'];
	        $ins['cm_memo']                     = $insert['customer_memo'];
	        $ins['cm_amount']                   = $overall_price;
	        $ins['date_created']                = Carbon::now();

	        /* INSERT CREDIT MEMO HERE */
	        $cm_id = Tbl_credit_memo::insertGetId($ins);

	        /* Transaction Journal */
	        $entry["reference_module"]  = "credit-memo";
	        $entry["reference_id"]      = $cm_id;
	        $entry["name_id"]           = $insert['customer_id'];
	        $entry["total"]             = $overall_price;
	        $entry["vatable"]           = '';
	        $entry["discount"]          = '';
	        $entry["ewt"]               = '';

	        $return = Self::insertline($cm_id, $insert_item, $entry);

			$warehouse_id = Warehouse2::get_current_warehouse($shop_id);
			AccountingTransaction::refill_inventory($shop_id, $warehouse_id, $insert_item, 'credit_memo', $cm_id, 'Refill upon creating CREDIT MEMO '.$ins['transaction_refnum']);
		}
		else
		{
			$return = $val;
		}		

        return $return; 
	}
	public static function insert_acctg_transaction($shop_id, $transaction_id, $applied_transaction = array())
    {
    	$get_transaction = Tbl_credit_memo::where("cm_shop_id", $shop_id)->where("cm_id", $transaction_id)->first();
    	$transaction_data = null;
    	if($get_transaction)
    	{
    		$transaction_data['transaction_ref_name'] = "credit_memo";
		 	$transaction_data['transaction_ref_id'] = $transaction_id;
		 	$transaction_data['transaction_list_number'] = $get_transaction->transaction_refnum;
		 	$transaction_data['transaction_date'] = $get_transaction->cm_date;

		 	$attached_transaction_data = null;
    	}

    	if($transaction_data)
		{
			AccountingTransaction::postTransaction($shop_id, $transaction_data, $attached_transaction_data);
		}
    }
	public static function get($shop_id, $paginate = null, $search_keyword = null, $status = null)
	{
		$data = Tbl_credit_memo::customer()->where('cm_shop_id', $shop_id);

		if($search_keyword)
		{
			$data->where(function($q) use ($search_keyword)
            {
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("cm_id", "LIKE", "%$search_keyword%");
                $q->orWhere("company", "LIKE", "%$search_keyword%");
                $q->orWhere("first_name", "LIKE", "%$search_keyword%");
                $q->orWhere("middle_name", "LIKE", "%$search_keyword%");
                $q->orWhere("last_name", "LIKE", "%$search_keyword%");
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
			$data->where('cm_status',$tab);
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
	public static function insertline($cm_id, $insert_item, $entry)
	{
		$itemline = null;
		$return = null;
		foreach ($insert_item as $key => $value) 
		{	
			$itemline[$key]['cmline_cm_id'] 			= $cm_id;
			$itemline[$key]['cmline_service_date'] 		= isset($value['item_servicedate']) ? $value['item_servicedate'] : '';
			$itemline[$key]['cmline_item_id'] 			= $value['item_id'];
			$itemline[$key]['cmline_description'] 		= $value['item_description'];
			$itemline[$key]['cmline_um'] 				= $value['item_um'];
			$itemline[$key]['cmline_qty'] 				= $value['item_qty'];
			$itemline[$key]['cmline_rate'] 				= $value['item_rate'];
			$itemline[$key]['cmline_amount'] 			= $value['item_amount'];
			$itemline[$key]['created_at'] 				= Carbon::now();
		}
		if(count($itemline) > 0)
		{
			Tbl_credit_memo_line::insert($itemline);
			$return = AccountingTransaction::entry_data($entry, $insert_item);
			$return = $cm_id;
		}

		return $return;
	}

}