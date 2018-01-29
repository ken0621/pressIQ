<?php
namespace App\Globals;
use App\Models\Tbl_acctg_transaction;
use App\Models\Tbl_acctg_transaction_list;
use App\Models\Tbl_acctg_transaction_item;
use App\Models\Tbl_transaction_ref_number;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_chart_of_account;


use Carbon\Carbon;
use Validator;
use DB;
use App\Globals\Accounting;
/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class AccountingTransaction
{

	public static function check_coa_exist($shop_id, $account_number, $account_name)
	{
		$check = Tbl_chart_of_account::where("account_shop_id", $shop_id)->where("account_name", $account_name)->first();
		$return = null;
		if($check)
		{
			$up['account_number'] = $account_number;
			Tbl_chart_of_account::where("account_shop_id", $shop_id)->where("account_name", $account_name)->update($up);
			$return = $check->account_id;
		}
		else
		{
			$ins['account_shop_id'] = $shop_id;
			$ins['account_name'] = $account_name;
			$ins['account_number'] = $account_number;
			$ins['account_code'] = 'accounting-receivable';
			$ins['account_type_id'] = 2;
			$return = Tbl_chart_of_account::insertGetId($ins);
		}
		return $return;
	}
	/**
	  * @param  
		$trans_data = [
		transaction_ref_name
		transaction_ref_id
		transaction_list_number	
		transaction_date]

		$trans_item = [
			itemline_item_id	int(10) unsigned	 
			itemline_item_um	int(10) unsigned NULL	 
			itemline_item_description	text	 
			itemline_item_qty	double	 
			itemline_item_rate	double	 
			itemline_item_taxable	tinyint(4)	 
			itemline_item_discount	double	 
			itemline_item_discount_type	varchar(255)	 
			itemline_item_discount_remarks	varchar(255)	 
			itemline_item_amount double	
		]
	  */
	public static function insertTransaction($shop_id, $trans_data = array(), $trans_item = array())
	{
		$insert_trans['shop_id'] = $shop_id;
		$insert_trans['transaction_number'] = "TR00001"; // MUST BE AUTO GENERATED

		$acctg_trans_id = Tbl_acctg_transaction::insertGetId($insert_trans);

		$trans_data['acctg_transaction_id'] = $acctg_trans_id;
		$trans_data['date_created'] = Carbon::now();
		Tbl_acctg_transaction_list::insert($trans_data);

		Self::insertItemline($acctg_trans_id, $trans_item);
	}
	public static function postTransaction($shop_id, $transaction_data, $transaction_item)
	{
		$check = Self::check_transaction($shop_id, $transaction_data['transaction_ref_name'], $transaction_data['transaction_ref_id']);
		if(!$check)
		{
			Self::insertTransaction($shop_id, $transaction_data, $transaction_item);
		}
	}
	public static function insertItemline($acctg_trans_id, $trans_item)
	{
		if(count($trans_item) > 0)
		{
			foreach ($trans_item as $key => $value)
			{
				$ins['acctg_transaction_id'] 		  	= $acctg_trans_id;
				$ins['itemline_item_id'] 			  	= isset($value['item_id']) ? $value['item_id'] : '';
				$ins['itemline_item_um'] 			  	= isset($value['item_um']) ? $value['item_um'] : '';
				$ins['itemline_item_description']     	= isset($value['item_description']) ? $value['item_description'] : '';
				$ins['itemline_item_qty'] 			  	= isset($value['item_qty']) ? $value['item_qty'] : '';
				$ins['itemline_item_rate'] 			  	= isset($value['item_rate']) ? $value['item_rate'] : '';
				$ins['itemline_item_taxable'] 		  	= isset($value['item_taxable']) ? $value['item_taxable'] : '';
				$ins['itemline_item_discount'] 		  	= isset($value['item_discount']) ? $value['item_discount'] : '';
				$ins['itemline_item_discount_type'] 	= isset($value['item_discount_type']) ? $value['item_discount_type'] : '';
				$ins['itemline_item_discount_remarks'] 	= isset($value['item_discount_remarks']) ? $value['item_discount_remarks'] : '';
				$ins['itemline_item_amount'] 			= isset($value['item_amount']) ? $value['item_amount'] : '';

				Tbl_acctg_transaction_item::insert($ins);
			}
		}
	}
	public static function check_transaction($shop_id, $transaction_name, $transaction_id)
	{
		$check = Tbl_acctg_transaction_list::acctgTransaction()->where("shop_id", $shop_id)->where("transaction_ref_name", $transaction_name)
											->where("transaction_ref_id", $transaction_id)->first();
		
		$return = null;
		if($check)
		{
			$return = $check->acctg_transaction_id;
		}
		return $return;
	}
	public static function updateTransaction($shop_id, $acctg_trans_id, $trans_item = array())
	{
		
	}
	public static function vendorValidation($insert, $insert_item)
	{
		$return = null;
        if(count($insert_item) <= 0)
        {
            $return .= '<li style="list-style:none">Please Select Item.</li>';
        }
        if(!$insert['vendor_id'])
        {
            $return .= '<li style="list-style:none">Please Select Vendor.</li>';          
        }

		$rules['transaction_refnumber'] = 'required';
        $rules['vendor_email']    		= 'email';

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
	
	public static function customer_validation($insert, $insert_item)
	{
		$return = null;
        if(count($insert_item) <= 0)
        {
            $return .= '<li style="list-style:none">Please Select Item.</li>';
        }

		if(!$insert['customer_id'])
        {
        	$return .= '<li style="list-style:none">Please select customer.</li>';        	
        }

        $rules['transaction_refnum'] = 'required';
        $rules['customer_email'] = 'email';

        $validator = Validator::make($insert, $rules);
        if($validator->fails())
        {
            foreach ($validator->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
            {
                $return .= $message;
            }
        }
        return $return;
	}

	public static function entry_data($entry, $insert_item)
	{
		foreach ($insert_item as $key => $value) 
		{
			/* DISCOUNT PER LINE */
	        $discount       = isset($value['item_discount']) ? $value['item_discount'] : 0;
	        $discount_type  = 'fixed';
	        if(strpos($discount, '%'))
            {
            	$discount       = substr($discount, 0, strpos($discount, '%')) / 100;
                $discount_type  = 'percent';
                $discount 		= $value['item_amount'] * $discount; 
            }

			$item_type = Item::get_item_type($value['item_id']);
            /* TRANSACTION JOURNAL */  
            if($item_type != 4 || $item_type != 5)
            {
                $entry_data[$key]['item_id']            = $value['item_id'];
                $entry_data[$key]['entry_qty']          = $value['item_qty'];
                $entry_data[$key]['vatable']            = 0;
                $entry_data[$key]['discount']           = $discount;
                $entry_data[$key]['entry_amount']       = $value['item_amount'];
                $entry_data[$key]['entry_description']  = $value['item_description'];                    
            }
            else
            {
                $item_bundle = Item::get_item_in_bundle($value['item_id']);
                if(count($item_bundle) > 0)
                {
                    foreach ($item_bundle as $key_bundle => $value_bundle) 
                    {
                        $item_data = Item::get_item_details($value_bundle->bundle_item_id);
                        $entry_data['b'.$key.$key_bundle]['item_id']            = $value_bundle->bundle_item_id;
                        $entry_data['b'.$key.$key_bundle]['entry_qty']          = $value['item_qty'] * (UnitMeasurement::um_qty($value_bundle->bundle_um_id) * $value_bundle->bundle_qty);
                        $entry_data['b'.$key.$key_bundle]['vatable']            = 0;
                        $entry_data['b'.$key.$key_bundle]['discount']           = 0;
                        $entry_data['b'.$key.$key_bundle]['entry_amount']       = $item_data->item_price * $entry_data['b'.$key.$key_bundle]['entry_qty'];
                        $entry_data['b'.$key.$key_bundle]['entry_description']  = $item_data->item_sales_information; 
                    }
                }
            }
		}

        $inv_journal = Accounting::postJournalEntry($entry, $entry_data);
        return $inv_journal;
	}
	public static function get_redirect($transaction_type, $transaction_id, $btn_action = 'sclose')
	{
		$return = null;
		if($btn_action == 'sclose')
		{
			$return = '/member/transaction/'.$transaction_type;
		}
		elseif($btn_action == 'sedit')
		{
			$return = '/member/transaction/'.$transaction_type.'/create?id='.$transaction_id;
		}
		elseif($btn_action == 'sprint')
		{
			$return = '/member/transaction/'.$transaction_type.'/print?id='.$transaction_id;
		}
		elseif($btn_action == 'snew')
		{
			$return = '/member/transaction/'.$transaction_type.'/create';
		}	

		return $return;	
	}
	public static function get_ref_num($shop_id, $transaction_type)
	{
		$return = null;
		if($transaction_type)
		{
			$get = Tbl_transaction_ref_number::where('shop_id', $shop_id)->where('key', $transaction_type)->first();
			if($get)
			{
				$date = explode('/', $get->other);
				if(isset($date[2]))
				{
					$datetoday = date($date[0]).date($date[1]).date($date[2]);
					$ctr = sprintf("%'.04d", Self::get_count_last_transaction($shop_id, $transaction_type, $get->separator));
					$return = $get->prefix.$datetoday.$get->separator.$ctr;
				} 
			}
		}
		return $return;
	}
	public static function get_count_last_transaction($shop_id, $transaction_type, $separator)
	{
		$return = 1;
		if($transaction_type == 'sales_invoice')
		{
			$get = Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('is_sales_receipt',0)->orderBy('inv_id','DESC')->first();
		}
		if($transaction_type == 'sales_receipt')
		{
			$get = Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('is_sales_receipt',1)->orderBy('inv_id','DESC')->first();
		}
		if($transaction_type == 'credit_memo')
		{
			$get = Tbl_credit_memo::where('cm_shop_id', $shop_id)->orderBy('cm_id','DESC')->first();
		}
		if($transaction_type == 'estimate_quotation')
		{
			$get = Tbl_customer_estimate::where('est_shop_id', $shop_id)->where('is_sales_order',0)->orderBy('est_id','DESC')->first();
		}
		if($transaction_type == 'sales_order')
		{
			$get = Tbl_customer_estimate::where('est_shop_id', $shop_id)->where('is_sales_order',1)->orderBy('est_id','DESC')->first();
		}

		if($get)
		{
			$number = explode("$separator", $get->transaction_refnum);
			if(isset($number[1]))
			{
				$return = $number[1] + 1;
			}
		}
		return $return;
	}
}