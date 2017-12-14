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

class TransactionSalesReceiptController extends Member
{
  	public function getIndex()
	{
		$data['page'] = "Sales Receipt";
		return view('member.accounting_transaction.customer.sales_receipt.sales_receipt_list',$data);
	} 
}