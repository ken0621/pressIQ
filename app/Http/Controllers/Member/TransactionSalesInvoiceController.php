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

		return view('member.accounting_transaction.customer.sales_invoice.sales_invoice',$data);
	} 
}