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
use App\Globals\TransactionSalesOrder;
use App\Globals\TransactionEstimateQuotation;
use App\Globals\AccountingTransaction;

use Session;
use Carbon\Carbon;
use App\Globals\Pdf_global;

class TransactionSalesOrderController extends Member
{
  	public function getIndex()
	{
		$data['page'] = "Sales Order";
		return view('member.accounting_transaction.customer.sales_order.sales_order_list',$data);
	} 	
	public function getLoadSalesOrder(Request $request)
	{
		$data['_sales_order'] = TransactionSalesOrder::get($this->user_info->shop_id, 10, $request->search_keyword, $request->tab_type);
		return view('member.accounting_transaction.customer.sales_order.sales_order_table',$data);		
	}

	public function getCreate()
	{
		$data['page'] = "Create Sales Order";		
        $data["_customer"]  = Customer::getAllCustomer();
        $data['_item']      = Item::get_all_category_item();
        $data["transaction_refnum"]  = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'sales_order');
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['action']		= "/member/transaction/sales_order/create-sales-order";

		return view('member.accounting_transaction.customer.sales_order.sales_order',$data);
	}
	public function postCreateSalesOrder(Request $request)
	{
		$btn_action = $request->button_action;

		$insert['transaction_refnum'] 	 = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_address;
		$insert['transaction_date']      = datepicker_input($request->transaction_date);
		$insert['customer_message']      = $request->customer_message;
		$insert['customer_memo']         = $request->customer_memo;

		$insert_item = null;
		foreach ($request->item_id as $key => $value) 
		{
			if($value)
			{
				$insert_item[$key]['item_id'] = $value;
				$insert_item[$key]['item_servicedate'] = datepicker_input($request->item_servicedate[$key]);
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
		$validate = TransactionSalesOrder::postInsert($this->user_info->shop_id, $insert, $insert_item);
		if(is_numeric($validate))
		{
			$return['status'] = 'success';
			$return['status_message'] = 'Success creating sales order.';
			$return['call_function'] = 'success_sales_order';
			$return['status_redirect'] = AccountingTransaction::get_redirect('sales_order', $validate ,$btn_action);
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
		return TransactionSalesOrder::CountTransaction($this->user_info->shop_id, $customer_id);
	}

	public function getLoadTransaction(Request $request)
	{
		$data['_eq'] = TransactionEstimateQuotation::getOpenEQ($this->user_info->shop_id, $request->c);
		$data['customer_name'] = Customer::get_name($this->user_info->shop_id, $request->c);
		return view("member.accounting_transaction.customer.sales_order.load_transaction", $data);
	}
	public function getPrint(Request $request)
	{
		dd("Under Maintenance");
	}
}