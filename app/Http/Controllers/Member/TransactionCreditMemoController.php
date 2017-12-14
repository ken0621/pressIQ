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

class TransactionCreditMemoController extends Member
{
    public function getIndex()
	{
		$data['page'] = "Credit Memo";
		return view('member.accounting_transaction.customer.credit_memo.credit_memo_list',$data);
	}
	public function getCreate()
	{
		$data['page'] = "Create Credit Memo";		
        $data["_customer"]  = Customer::getAllCustomer();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();

		return view('member.accounting_transaction.customer.credit_memo.credit_memo',$data);
	}
}