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
use App\Models\Tbl_requisition_slip;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_receive_inventory;
use App\Models\Tbl_customer_wis;
use App\Models\Tbl_pay_bill;
use App\Models\Tbl_bill;
use App\Models\Tbl_write_check;
use App\Models\Tbl_debit_memo;
use App\Models\Tbl_warehouse_issuance_report;
use App\Models\Tbl_warehouse_receiving_report;
use App\Models\Tbl_inventory_adjustment;
use App\Models\Tbl_receive_payment;
use App\Models\Tbl_user;

use Carbon\Carbon;
use Validator;
use DB;
use App\Globals\Accounting;
use App\Globals\CustomerWIS;
use App\Globals\Item;
use App\Globals\Warehouse2;
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
	public static function insertTransaction($shop_id, $trans_data = array())
	{
		$insert_trans['shop_id'] = $shop_id;
		$insert_trans['transaction_number'] = Self::get_ref_num($shop_id, 'accounting_transaction'); // MUST BE AUTO GENERATED
		$insert_trans['transaction_user_id'] = Self::getUserid();
		$insert_trans['transaction_created_at'] = Carbon::now();

		$acctg_trans_id = Tbl_acctg_transaction::insertGetId($insert_trans);

		$trans_data['acctg_transaction_id'] = $acctg_trans_id;
		$trans_data['date_created'] = Carbon::now();
		Tbl_acctg_transaction_list::insert($trans_data);
		return $acctg_trans_id;
	}

	public static function updateTransaction($acctg_trans_id, $trans_data = array())
	{
		$trans_data['acctg_transaction_id'] = $acctg_trans_id;
		$trans_data['date_created'] = Carbon::now();

		Tbl_acctg_transaction_list::insert($trans_data);

		$get = Tbl_acctg_transaction::where("acctg_transaction_id", $acctg_trans_id)->first();

		if($get)
		{
			$datenow = $get->transaction_created_at;
			if($get->acctg_transaction_history)
			{
                $serialize = unserialize($get_data->acctg_transaction_history);
				$serialize[$datenow] = collect($get)->toArray();

                $update['acctg_transaction_history'] = serialize($serialize);
                Tbl_acctg_transaction::where("acctg_transaction_id", $acctg_transaction_id)->update($update);
			}
			else
			{
				$serialize[$datenow] = collect($get)->toArray();
                $update['acctg_transaction_history'] = serialize($serialize);
                Tbl_acctg_transaction::where("acctg_transaction_id", $acctg_transaction_id)->update($update);
			}
		}

		$update_trans['transaction_user_id'] = Self::getUserid();
		$update_trans['transaction_created_at'] = Carbon::now();
		Tbl_acctg_transaction::where("acctg_transaction_id", $acctg_trans_id)->update($update_trans);

		return $acctg_trans_id;
	}
	 /* 
	 	<-- PARAMS -->
	 	$transaction_data['transaction_ref_name'] - Reference Name
	 	$transaction_data['transaction_ref_id'] - Reference ID
	 	$transaction_data['transaction_list_number'] - Reference Number
	 	$transaction_data['transaction_date'] - Date

	 	$attached_transaction_data[0]['transaction_ref_name'] - Reference Name
	 	$attached_transaction_data[0]['transaction_ref_id'] - Reference ID
	 	$attached_transaction_data[0]['transaction_list_number'] - Reference Number
	 	$attached_transaction_data[0]['transaction_date'] - Date
			
	 */

    public static function getUserid()
    {
        $user_id = 0;
        $user_data = Tbl_user::where("user_email", session('user_email'))->shop()->value('user_id');
        if($user_data)
        {
            $user_id = $user_data;
        }
        return $user_id;
    }
	public static function postTransaction($shop_id, $transaction_data, $attached_transaction_data = array())
	{
		$check = Self::check_transaction($shop_id, $transaction_data['transaction_ref_name'], $transaction_data['transaction_ref_id']);
		if(!$check)
		{
			$acctg_trans_id = Self::insertTransaction($shop_id, $transaction_data);
		}
		else
		{
			$acctg_trans_id = $check;
			// Tbl_acctg_transaction_list::where("acctg_transaction_id", $acctg_trans_id)->delete();
			Self::updateTransaction($acctg_trans_id, $transaction_data);
		}

		if(is_numeric($acctg_trans_id))
		{
			Self::attached_transaction($acctg_trans_id, $attached_transaction_data);			
		}
		return $acctg_trans_id;
	}
	public static function attached_transaction($acctg_trans_id, $attached_transaction_data = array())
	{
		$date =  Carbon::now();
		if(count($attached_transaction_data) > 0)
		{
			$list = null;
			foreach ($attached_transaction_data as $key => $value) 
			{
				$list[$key] = $value;
				$list[$key]['acctg_transaction_id'] = $acctg_trans_id;
				$list[$key]['date_created'] = $date;
			}
			if(count($list) > 0)
			{
				Self::insertTransactionList($list);
			}
		}
	}
	public static function insertTransactionList($transaction_data)
	{
		Tbl_acctg_transaction_list::insert($transaction_data);
	}
	public static function check_transaction($shop_id, $transaction_name = '', $transaction_id = 0)
	{
		$check = Tbl_acctg_transaction_list::acctgTransaction()->where("shop_id", $shop_id)->where("transaction_ref_name", $transaction_name)
											->where("transaction_ref_id", $transaction_id)->orderBy("acctg_transaction_list_id","ASC")->first();
		
		$return = null;
		if($check)
		{
			$return = $check->acctg_transaction_id;
		}
		return $return;
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
	public static function vendorValidation($insert, $insert_item, $transaction_type = '')
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

        if($transaction_type)
        {
        	$return .= Self::check_transaction_ref_number(Self::shop_id(), $insert['transaction_refnumber'], $transaction_type);
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
	public static function shop_id()
	{
		$shop_id = Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');

		return $shop_id;
	}
	
	public static function customer_validation($insert, $insert_item, $transaction_type = '')
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

        if($transaction_type)
        {
        	$return .= Self::check_transaction_ref_number(Self::shop_id(), $insert['transaction_refnum'], $transaction_type);
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
	public static function check_transaction_ref_number($shop_id, $transaction_refnum, $transaction_type)
	{
		$return = null;
		$get = null;

		if($transaction_type == 'sales_invoice')
		{
			$get = Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->where('is_sales_receipt',0)->first();
		}
		if($transaction_type == 'sales_receipt')
		{
			$get = Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->where('is_sales_receipt',1)->first();
		}
		if($transaction_type == 'credit_memo')
		{
			$get = Tbl_credit_memo::where('cm_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($transaction_type == 'estimate_quotation')
		{
			$get = Tbl_customer_estimate::where('est_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->where('is_sales_order',0)->first();
		}
		if($transaction_type == 'sales_order')
		{
			$get = Tbl_customer_estimate::where('est_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->where('is_sales_order',1)->first();
		}
		if($transaction_type == 'warehouse_issuance_slip')
		{
			$get = Tbl_customer_wis::where('cust_wis_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($transaction_type == 'warehouse_transfer')
		{
			$get = Tbl_warehouse_issuance_report::where('wis_shop_id', $shop_id)->where('wis_number', $transaction_refnum)->first();
		}
		if($transaction_type == 'receiving_report')
		{
			$get = Tbl_warehouse_receiving_report::where('rr_shop_id', $shop_id)->where('rr_number', $transaction_refnum)->first();
		}
		if($transaction_type == 'purchase_requisition')
		{
			$get = Tbl_requisition_slip::where('shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($transaction_type == 'purchase_order')
		{
			$get = Tbl_purchase_order::where('po_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($transaction_type == 'received_inventory')
		{
			$get = Tbl_receive_inventory::where('ri_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
			//die(var_dump($get));
		}
		if($transaction_type == 'enter_bills')
		{
			$get = Tbl_bill::where('bill_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($transaction_type == 'pay_bill')
		{
			$get = Tbl_pay_bill::where('paybill_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($transaction_type == 'write_check')
		{
			$get = Tbl_write_check::where('wc_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($transaction_type == 'debit_memo')
		{
			$get = Tbl_debit_memo::where('db_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($transaction_type == 'inventory_adjustment')
		{
			$get = Tbl_inventory_adjustment::where('adj_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($transaction_type == 'received_payment')
		{
			$get = Tbl_receive_payment::where('rp_shop_id', $shop_id)->where('transaction_refnum', $transaction_refnum)->first();
		}
		if($get)
		{
			$return = "Duplicate transaction number <br>";
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
            if($item_type != 4 && $item_type != 5)
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
		//die(var_dump($entry_data)); 
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
		elseif($btn_action == 'swis')
		{
			$return = '/member/customer/wis/create?ids='.$transaction_id;
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
		$get = null;
		if($transaction_type == 'accounting_transaction')
		{
			$get = Tbl_acctg_transaction::where('shop_id', $shop_id)->orderBy("acctg_transaction_id", "DESC")->first();
			if($get)
			{
				$get->transaction_refnum = $get->transaction_number;
			}
		}
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
		if($transaction_type == 'warehouse_issuance_slip')
		{
			$get = Tbl_customer_wis::where('cust_wis_shop_id', $shop_id)->orderBy('cust_wis_id','DESC')->first();
		}
		if($transaction_type == 'warehouse_transfer')
		{
			$get = Tbl_warehouse_issuance_report::where('wis_shop_id', $shop_id)->orderBy('wis_id','DESC')->first();
			if($get)
			{
				$get->transaction_refnum = $get->wis_number;
			}
		}
		if($transaction_type == 'receiving_report')
		{
			$get = Tbl_warehouse_receiving_report::where('rr_shop_id', $shop_id)->orderBy('rr_id','DESC')->first();
			if($get)
			{
				$get->transaction_refnum = $get->rr_number;
			}
		}
		if($transaction_type == 'purchase_requisition')
		{
			$get = Tbl_requisition_slip::where('shop_id', $shop_id)->orderBy('requisition_slip_id','DESC')->first();
		}
		if($transaction_type == 'purchase_order')
		{
			$get = Tbl_purchase_order::where('po_shop_id', $shop_id)->orderBy('po_id','DESC')->first();
		}
		if($transaction_type == 'received_inventory')
		{
			$get = Tbl_receive_inventory::where('ri_shop_id', $shop_id)->orderBy('ri_id','DESC')->first();
		}
		if($transaction_type == 'enter_bills')
		{
			$get = Tbl_bill::where('bill_shop_id', $shop_id)->orderBy('bill_id','DESC')->first();
		}
		if($transaction_type == 'pay_bill')
		{
			$get = Tbl_pay_bill::where('paybill_shop_id', $shop_id)->orderBy('paybill_id','DESC')->first();
		}
		if($transaction_type == 'write_check')
		{
			$get = Tbl_write_check::where('wc_shop_id', $shop_id)->orderBy('wc_id','DESC')->first();
		}
		if($transaction_type == 'debit_memo')
		{
			$get = Tbl_debit_memo::where('db_shop_id', $shop_id)->orderBy('db_id','DESC')->first();
		}
		if($transaction_type == 'inventory_adjustment')
		{
			$get = Tbl_inventory_adjustment::where('adj_shop_id', $shop_id)->orderBy('inventory_adjustment_id','DESC')->first();
		}
		if($transaction_type == 'received_payment')
		{
			$get = Tbl_receive_payment::where('rp_shop_id', $shop_id)->orderBy('rp_id','DESC')->first();
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
	public static function refill_inventory($shop_id, $warehouse_id , $item_info, $ref_name = '', $ref_id = 0, $remarks = '')
	{
		$return = null;

		if(count($item_info) > 0)
		{
			$_item = null;
			foreach ($item_info as $key => $value) 
			{
				$item_type = Item::get_item_type($value['item_id']);
				if($item_type == 1)
				{
					$qty = $value['item_qty'] * UnitMeasurement::getQty($value['item_um']);
					$_item[$key]['item_id'] = $value['item_id'];
			        $_item[$key]['quantity'] = $qty;
			        $_item[$key]['remarks'] = $value['item_description'];
				}
				elseif($item_type == 5 || $item_type == 4)
				{
					$bundle_list = Item::get_bundle_list($value['item_id']);
					if(count($bundle_list) > 0)
					{
						foreach ($bundle_list as $key_bundle => $value_bundle) 
						{
							$qty = $value['item_qty'] * ($value_bundle->bundle_qty * UnitMeasurement::getQty($value_bundle->bundle_um_id));
							$_item[$key.'b'.$key_bundle]['item_id'] = $value_bundle->bundle_item_id;
							$_item[$key.'b'.$key_bundle]['quantity'] = $qty;
							$_item[$key.'b'.$key_bundle]['remarks'] = $value_bundle->item_sales_information;
						}
					}
				}
			}
			if(count($_item) > 0)
			{
				$return = Warehouse2::refill_bulk($shop_id, $warehouse_id, $ref_name, $ref_id, $remarks, $_item);

				foreach ($item_info as $key => $value) 
				{
					$item_type = Item::get_item_type($value['item_id']);
					if($item_type == 5 || $item_type == 4)
					{
						Warehouse2::refill_bundling_item($shop_id, $warehouse_id, $value['item_id'], $value['item_qty'], $ref_name, $ref_id);
					}
				}
			}
		}

		return $return;
	}
	public static function inventory_refill_update($shop_id, $warehouse_id,  $item_info, $ref_name, $ref_id)
	{
		Warehouse2::inventory_delete_inventory_refill($shop_id, $warehouse_id, $ref_name, $ref_id, $item_info);
	}

	public static function inventory_consume_update($shop_id, $warehouse_id, $ref_name, $ref_id)
	{
		Warehouse2::update_inventory_consume($shop_id, $warehouse_id, $ref_name, $ref_id);
	}
	public static function inventory_validation($type = 'refill', $shop_id, $warehouse_id, $item_info, $remarks = '')
	{
		$return = null;
		$_item = null;
		if(count($item_info) > 0)
		{
			foreach ($item_info as $key => $value) 
			{
				$item_type = Item::get_item_type($value['item_id']);
				if($item_type == 1 || $item_type == 5 || $item_type == 4)
				{
					$qty = $value['item_qty'] * UnitMeasurement::getQty($value['item_um']);
					$_item[$key]['item_id'] = $value['item_id'];
			        $_item[$key]['quantity'] = $qty;
			        $_item[$key]['remarks'] = $value['item_description'];
				}
			}
		}
		if(count($_item) > 0)
		{
			foreach ($_item as $key => $value) 
			{
				if($type == 'refill')
				{
					$return = Warehouse2::refill_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks']);
				}
				if($type == 'consume')
				{
					// $return = Warehouse2::consume_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks']);
				}
			}
		}
		else
		{
			$return = "Please select item";
		}

		return $return;
	}
	public static function consume_inventory($shop_id, $warehouse_id , $item_info, $ref_name = '', $ref_id = 0, $remarks = '')
	{
		$return = null;
		if(count($item_info) > 0)
		{
			$_item = null;
			foreach ($item_info as $key => $value) 
			{
				$item_type = Item::get_item_type($value['item_id']);
				if($item_type == 1 || $item_type == 5 || $item_type == 4)
				{
					$qty = $value['item_qty'] * UnitMeasurement::getQty($value['item_um']);
					$_item[$key]['item_id'] = $value['item_id'];
			        $_item[$key]['quantity'] = $qty;
			        $_item[$key]['remarks'] = $value['item_description'];
				}
			}
			if(count($_item) > 0)
			{
				$return = Warehouse2::consume_bulk($shop_id, $warehouse_id, $ref_name, $ref_id, $remarks, $_item);
			}
		}
		return $return;
	}
	public static function get_refuser($user_info)
	{
		$date = date("F j, Y, g:i a");
		$return = $date;
		if($user_info)
		{
	        $first_name         = $user_info->user_first_name;
	        $last_name         = $user_info->user_last_name;
	        $return  = 'Printed by: '.$first_name.' '.$last_name.'           '.$date.'           ';
		}

		return $return;
	}
}