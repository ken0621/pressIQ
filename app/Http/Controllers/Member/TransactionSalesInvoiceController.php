<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Cart2;
use App\Globals\WarehouseTransfer;
use App\Globals\Warehouse2;
use App\Globals\Item;
use App\Globals\Transaction;
use App\Models\Tbl_warehouse_issuance_report;

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
}