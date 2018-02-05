<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Cart2;
use App\Globals\WarehouseTransfer;
use App\Globals\Warehouse2; 
use App\Globals\Item;
use App\Globals\Customer;
use App\Globals\Transaction;
use App\Globals\UnitMeasurement;
use App\Globals\TransactionCreditMemo;
use App\Globals\AccountingTransaction;

use Session;
use Carbon\Carbon;
use App\Globals\Pdf_global;

class TransactionCreditMemoController extends Member
{
    public function getIndex()
	{
		$data['page'] = "Credit Memo";
		return view('member.accounting_transaction.customer.credit_memo.credit_memo_list',$data);
	}
	public function getLoadCreditMemo(Request $request)
	{
		$data['_credit_memo'] = TransactionCreditMemo::get($this->user_info->shop_id, 10, $request->search_keyword, $request->tab_type);
		return view('member.accounting_transaction.customer.credit_memo.credit_memo_table',$data);		
	}
	public function getCreate(Request $request)
	{
		$data['page'] = "Create Credit Memo";		
        $data["_customer"]  = Customer::getAllCustomer();
        $data["transaction_refnum"]  = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'credit_memo');
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['action']		= "/member/transaction/credit_memo/create-credit-memo";
        if($request->id)
        {
        	$data['action']		= "/member/transaction/credit_memo/update-credit-memo";
        	$data['credit_memo'] = TransactionCreditMemo::info($this->user_info->shop_id, $request->id);
        	$data['credit_memo_item'] = TransactionCreditMemo::info_item($request->id);
        }

		return view('member.accounting_transaction.customer.credit_memo.credit_memo',$data);
	}
	public function postCreateCreditMemo(Request $request)
	{
		$btn_action = $request->button_action;

		$insert['transaction_refnum'] 	 = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_address;
		$insert['transaction_date']      = $request->transaction_date;
		$insert['customer_message']      = $request->customer_message;
		$insert['customer_memo']         = $request->customer_memo;
        $insert['cm_used_ref_name'] 	 = $request->use_credit;

		$insert_item = null;
		foreach ($request->item_id as $key => $value)
		{
			if($value)
			{
				$insert_item[$key]['item_id'] = $value;
				$insert_item[$key]['item_servicedate'] = $request->item_servicedate[$key];
				$insert_item[$key]['item_description'] = $request->item_description[$key];
				$insert_item[$key]['item_um'] = $request->item_um[$key];
				$insert_item[$key]['item_qty'] = str_replace(',', '', $request->item_qty[$key]);
				$insert_item[$key]['item_rate'] = str_replace(',', '', $request->item_rate[$key]);
				$insert_item[$key]['item_amount'] = str_replace(',', '', $request->item_amount[$key]);
				$insert_item[$key]['item_taxable'] = $request->item_taxable[$key];
			}
		}
		$return = null;
		$warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
		$validate = AccountingTransaction::inventory_validation('refill', $this->user_info->shop_id, $warehouse_id, $insert_item);
		if(!$validate)
		{
			$validate = TransactionCreditMemo::postInsert($this->user_info->shop_id, $insert, $insert_item);
		}
		if(is_numeric($validate))
		{
			$return['status'] = 'success';
			$return['status_message'] = 'Success creating credit memo.';
			$return['call_function'] = 'success_credit_memo';
			$return['status_redirect'] = AccountingTransaction::get_redirect('credit_memo', $validate ,$btn_action);	
		}
		else
		{
			$return['status'] = 'error';
			$return['status_message'] = $validate;
		}

		return json_encode($return);
	}

	public function postUpdateCreditMemo(Request $request)
	{
		$btn_action = $request->button_action;
		$credit_memo_id = $request->credit_memo_id;

		$insert['transaction_refnum'] 	 = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_address;
		$insert['transaction_date']      = $request->transaction_date;
		$insert['customer_message']      = $request->customer_message;
		$insert['customer_memo']         = $request->customer_memo;
        $insert['cm_used_ref_name'] 	 = $request->use_credit;

		$insert_item = null;
		foreach ($request->item_id as $key => $value)
		{
			if($value)
			{
				$insert_item[$key]['item_id'] = $value;
				$insert_item[$key]['item_servicedate'] = $request->item_servicedate[$key];
				$insert_item[$key]['item_description'] = $request->item_description[$key];
				$insert_item[$key]['item_um'] = $request->item_um[$key];
				$insert_item[$key]['item_qty'] = str_replace(',', '', $request->item_qty[$key]);
				$insert_item[$key]['item_rate'] = str_replace(',', '', $request->item_rate[$key]);
				$insert_item[$key]['item_amount'] = str_replace(',', '', $request->item_amount[$key]);
				$insert_item[$key]['item_taxable'] = $request->item_taxable[$key];
			}
		}
		$return = null;
		$warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
		$validate = AccountingTransaction::inventory_validation('refill', $this->user_info->shop_id, $warehouse_id, $insert_item);
		if(!$validate)
		{
			$validate = TransactionCreditMemo::postUpdate($credit_memo_id, $this->user_info->shop_id, $insert, $insert_item);
		}
		if(is_numeric($validate))
		{
			$return['status'] = 'success';
			$return['status_message'] = 'Success updating credit memo.';
			$return['call_function'] = 'success_credit_memo';
			$return['status_redirect'] = AccountingTransaction::get_redirect('credit_memo', $validate ,$btn_action);	
		}
		else
		{
			$return['status'] = 'error';
			$return['status_message'] = $validate;
		}

		return json_encode($return);
	}
	public function getPrint(Request $request)
	{
		$id = $request->id;
        $footer = AccountingTransaction::get_refuser($this->user_info);

        $data['cm'] = TransactionCreditMemo::info($this->user_info->shop_id, $id);
        $data["transaction_type"] = "CREDIT MEMO";
        $data["_cmline"] = TransactionCreditMemo::info_item($id);

        $pdf = view('member.accounting_transaction.customer.credit_memo.cm_print', $data);
        return Pdf_global::show_pdf($pdf, null, $footer);
	}
}