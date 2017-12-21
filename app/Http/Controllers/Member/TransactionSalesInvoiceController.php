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
use App\Globals\TransactionSalesInvoice;

use Session;
use Carbon\Carbon;
use App\Globals\Pdf_global;

class TransactionSalesInvoiceController extends Member
{
  	public function getIndex()
	{
		$data['page'] = "Sales Invoice";
		return view('member.accounting_transaction.customer.sales_invoice.sales_invoice_list',$data);
	}

	public function getCreate()
	{
		$data['page'] = "Create Sales Invoice";		
        $data["_customer"]  = Customer::getAllCustomer();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["_terms"]     = Customer::getTerms($this->user_info->shop_id,0);
        $data['action']		= "/member/transaction/sales_invoice/create-sales-invoice";

		return view('member.accounting_transaction.customer.sales_invoice.sales_invoice',$data);
	} 
	public function postCreateSalesInvoice(Request $request)
	{
		$btn_action = $request->button_action;

		$insert['transaction_refnum'] 	 = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_address;
		$insert['transaction_date']      = date("Y-m-d", strtotime($request->transaction_date));
		$insert['transaction_duedate']   = date("Y-m-d", strtotime($request->transaction_duedate));
		$insert['customer_message']      = $request->customer_message;
		$insert['customer_memo']         = $request->customer_memo;
		$insert['customer_ewt']          = $request->customer_ewt;
		$insert['customer_terms']        = $request->customer_terms;
		$insert['customer_discount']     = $request->customer_discount;
		$insert['customer_discounttype'] = $request->customer_discounttype;
		$insert['customer_tax'] 		 = $request->customer_tax;

		$insert_item = null;
		foreach ($request->item_id as $key => $value) 
		{
			if($value)
			{
				$insert_item[$key]['item_id'] 		   	= $value;
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
		$validate = TransactionSalesInvoice::postInsert($this->user_info->shop_id, $insert, $insert_item);
		if(is_numeric($validate))
		{
			
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
		return TransactionSalesInvoice::CountTransaction($this->user_info->shop_id, $customer_id);
	}
	public function getLoadTransaction(Request $request)
	{
		dd("Under Maintenance");
	}
}