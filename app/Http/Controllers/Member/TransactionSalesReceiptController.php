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
use App\Globals\TransactionSalesReceipt;
use App\Globals\TransactionEstimateQuotation;
use App\Globals\TransactionSalesOrder;

use App\Globals\AccountingTransaction;

use Session;
use Carbon\Carbon;
use App\Globals\Pdf_global;

class TransactionSalesReceiptController extends Member
{
  	public function getIndex()
	{
		$data['page'] = "Sales Receipt";
		return view('member.accounting_transaction.customer.sales_receipt.sales_receipt_list',$data);
	} 	
	public function getLoadSalesReceipt(Request $request)
	{
		$data['_sales_receipt'] = TransactionSalesReceipt::get($this->user_info->shop_id, 10, $request->search_keyword);
		return view('member.accounting_transaction.customer.sales_receipt.sales_receipt_table',$data);		
	}

	public function getCreate(Request $request)
	{
		$data['page'] = "Create Sales Receipt";		
        $data["transaction_refnum"]  = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'sales_receipt');
        $data["_customer"]  = Customer::getAllCustomer();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['action']		= "/member/transaction/sales_receipt/create-sales-receipt";
        if($request->id)
        {
        	$data['action']		= "/member/transaction/sales_receipt/update-sales-receipt";
        	$data['sales_receipt'] = TransactionSalesReceipt::info($this->user_info->shop_id, $request->id);
        	$data['sales_receipt_item'] = TransactionSalesReceipt::info_item($request->id);
        }

		return view('member.accounting_transaction.customer.sales_receipt.sales_receipt',$data);
	} 
	public function postCreateSalesReceipt(Request $request)
	{
		$btn_action = $request->button_action;

		$insert['transaction_refnum']	 = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_address;
		$insert['transaction_date']      = $request->transaction_date;
		$insert['customer_message']      = $request->customer_message;
		$insert['customer_memo']         = $request->customer_memo;
		$insert['customer_ewt']          = $request->customer_ewt;
		$insert['customer_discount']     = $request->customer_discount;
		$insert['customer_discounttype'] = $request->customer_discounttype;
		$insert['customer_tax'] 		 = $request->customer_tax;

		$insert_item = null;
		foreach ($request->item_id as $key => $value) 
		{
			if($value)
			{
				$insert_item[$key]['item_id'] 			= $value;
				$insert_item[$key]['item_servicedate'] 	= date("Y-m-d", strtotime($request->item_servicedate[$key]));
				$insert_item[$key]['item_description'] 	= $request->item_description[$key];
				$insert_item[$key]['item_um'] 			= $request->item_um[$key];
				$insert_item[$key]['item_qty'] 			= str_replace(',', '', $request->item_qty[$key]);
				$insert_item[$key]['item_rate'] 		= str_replace(',', '', $request->item_rate[$key]);
				$insert_item[$key]['item_discount'] 	= str_replace(',', '', $request->item_discount[$key]);
				$insert_item[$key]['item_remarks'] 		= $request->item_remarks[$key];
				$insert_item[$key]['item_amount'] 		= str_replace(',', '', $request->item_amount[$key]);
				$insert_item[$key]['item_taxable'] 		= $request->item_taxable[$key];
			}
		}
		$return = null;
		$validate = null;
		if(CustomerWIS::settings($shop_id) == 0)
		{
			$warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
			$validate = AccountingTransaction::inventory_validation('consume', $this->user_info->shop_id, $warehouse_id, $insert_item);
		}
		if(!$validate)
		{
			$return = null;
			$validate = TransactionSalesReceipt::postInsert($this->user_info->shop_id, $insert, $insert_item);
		}

		if(is_numeric($validate))
		{			
			$return['status'] = 'success';
			$return['status_message'] = 'Success creating sales receipt.';
			$return['call_function'] = 'success_sales_receipt';
			$return['status_redirect'] = AccountingTransaction::get_redirect('sales_receipt', $validate ,$btn_action);
		}
		else
		{
			$return['status'] = 'error';
			$return['status_message'] = $validate;
		}

		return json_encode($return);
	}

	public function postUpdateSalesReceipt(Request $request)
	{
		$btn_action = $request->button_action;
		$sales_receipt_id = $request->sales_receipt_id;

		$insert['transaction_refnum']	 = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_address;
		$insert['transaction_date']      = $request->transaction_date;
		$insert['customer_message']      = $request->customer_message;
		$insert['customer_memo']         = $request->customer_memo;
		$insert['customer_ewt']          = $request->customer_ewt;
		$insert['customer_discount']     = $request->customer_discount;
		$insert['customer_discounttype'] = $request->customer_discounttype;
		$insert['customer_tax'] 		 = $request->customer_tax;

		$insert_item = null;
		foreach ($request->item_id as $key => $value) 
		{
			if($value)
			{
				$insert_item[$key]['item_id'] 			= $value;
				$insert_item[$key]['item_servicedate'] 	= date("Y-m-d", strtotime($request->item_servicedate[$key]));
				$insert_item[$key]['item_description'] 	= $request->item_description[$key];
				$insert_item[$key]['item_um'] 			= $request->item_um[$key];
				$insert_item[$key]['item_qty'] 			= str_replace(',', '', $request->item_qty[$key]);
				$insert_item[$key]['item_rate'] 		= str_replace(',', '', $request->item_rate[$key]);
				$insert_item[$key]['item_discount'] 	= str_replace(',', '', $request->item_discount[$key]);
				$insert_item[$key]['item_remarks'] 		= $request->item_remarks[$key];
				$insert_item[$key]['item_amount'] 		= str_replace(',', '', $request->item_amount[$key]);
				$insert_item[$key]['item_taxable'] 		= $request->item_taxable[$key];
			}
		}
		$return = null;
		$validate = null;
		if(CustomerWIS::settings($shop_id) == 0)
		{
			$warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
			$validate = AccountingTransaction::inventory_validation('consume', $this->user_info->shop_id, $warehouse_id, $insert_item);
		}
		if(!$validate)
		{
			$return = null;
			$validate = TransactionSalesReceipt::postUpdate($sales_receipt_id, $this->user_info->shop_id, $insert, $insert_item);
		}
		if(is_numeric($validate))
		{			
			$return['status'] = 'success';
			$return['status_message'] = 'Success updating sales receipt.';
			$return['call_function'] = 'success_sales_receipt';
			$return['status_redirect'] = AccountingTransaction::get_redirect('sales_receipt', $validate ,$btn_action);
		}
		else
		{
			$return['status'] = 'error';
			$return['status_message'] = $validate;
		}

		return json_encode($return);
	}

	public function getCountTransaction(Request $request)
	{
		$customer_id = $request->customer_id;
		return TransactionSalesReceipt::CountTransaction($this->user_info->shop_id, $customer_id);
	}
	public function getLoadTransaction(Request $request)
	{
		$data['_eq'] = TransactionEstimateQuotation::getOpenEQ($this->user_info->shop_id, $request->c);
		$data['_so'] = TransactionSalesOrder::getOpenSO($this->user_info->shop_id, $request->c);
		$data['customer_name'] = Customer::get_name($this->user_info->shop_id, $request->c);
		return view("member.accounting_transaction.customer.sales_receipt.load_transaction", $data);
	}
	
	public function getPrint(Request $request)
	{
		dd("Under Maintenance");
	}
}