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
use App\Globals\TransactionEstimateQuotation;
use App\Globals\AccountingTransaction;

use Session;
use Carbon\Carbon;
use App\Globals\Pdf_global;

class TransactionEstimateQuotationController extends Member
{
	public function getIndex()
	{
		$data['page'] = "Estimate and Quotation";
		return view('member.accounting_transaction.customer.estimate_quotation.estimate_quotation_list',$data);
	}	
	public function getLoadEstimateQuotation(Request $request)
	{
		$data['_estimate_quotation'] = TransactionEstimateQuotation::get($this->user_info->shop_id, 10, $request->search_keyword, $request->tab_type);
		return view('member.accounting_transaction.customer.estimate_quotation.estimate_quotation_table',$data);		
	}
	public function getCreate()
	{
		$data['page'] = "Create Estimate and Quotation";		
        $data["_customer"]  = Customer::getAllCustomer();
        $data["transaction_refnum"]  = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'estimate_quotation');
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['action']		= "/member/transaction/estimate_quotation/create-estimate-quotation";

		return view('member.accounting_transaction.customer.estimate_quotation.estimate_quotation',$data);
	}
	public function postCreateEstimateQuotation(Request $request)
	{
		$btn_action = $request->button_action;

		$insert['transaction_refnum'] 	 = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_address;
		$insert['transaction_date']      = $request->transaction_date;
		$insert['transaction_duedate']   = $request->transaction_duedate;
		$insert['customer_message']      = $request->customer_message;
		$insert['customer_memo']         = $request->customer_memo;

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
				$insert_item[$key]['item_discount'] = str_replace(',', '', $request->item_discount[$key]);
				$insert_item[$key]['item_remarks'] = $request->item_remarks[$key];
				$insert_item[$key]['item_amount'] = str_replace(',', '', $request->item_amount[$key]);
				$insert_item[$key]['item_taxable'] = $request->item_taxable[$key];
			}
		}
		$return = null;
		$validate = TransactionEstimateQuotation::postInsert($this->user_info->shop_id, $insert, $insert_item);
		if(is_numeric($validate))
		{
			$return['status'] = 'success';
			$return['status_message'] = 'Success creating estimate and quotation.';
			$return['call_function'] = 'success_estimate_quotation';
			$return['status_redirect'] = AccountingTransaction::get_redirect('estimate_quotation', $validate ,$btn_action);
		}
		else
		{
			$return['status'] = 'error';
			$return['status_message'] = $validate;
		}

		return json_encode($return);
	}
}