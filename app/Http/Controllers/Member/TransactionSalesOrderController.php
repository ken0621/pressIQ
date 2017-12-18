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

	public function getCreate()
	{
		$data['page'] = "Create Sales Order";		
        $data["_customer"]  = Customer::getAllCustomer();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['action']		= "/member/transaction/sales_order/create-sales-order";

		return view('member.accounting_transaction.customer.sales_order.sales_order',$data);
	}
	public function postCreateSalesOrder(Request $request)
	{
		$btn_action = $request->button_action;

		$insert['transaction_refnumber'] = $request->transaction_refnumber;
		$insert['customer_id'] 			 = $request->customer_id;
		$insert['customer_email']        = $request->customer_email;
		$insert['customer_address']      = $request->customer_address;
		$insert['transaction_date']      = $request->transaction_date;
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
		die(var_dump($btn_action));
	}
}