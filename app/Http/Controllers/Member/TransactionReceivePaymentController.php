<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Cart2;
use App\Globals\WarehouseTransfer;
use App\Globals\Warehouse2;
use App\Globals\Payment;
use App\Globals\Item;
use App\Globals\Customer;
use App\Globals\Accounting;
use App\Globals\Transaction;
use App\Globals\UnitMeasurement;

use Session;
use Carbon\Carbon;
use App\Globals\Pdf_global;

class TransactionReceivePaymentController extends Member
{
	public function getIndex()
	{
		$data['page'] = "Receive Payment";
		return view('member.accounting_transaction.customer.receive_payment.receive_payment_list',$data);
	}
	public function getCreate() 
	{
		$data['page'] = "Receive Payment";
        $data["_customer"]       = Customer::getAllCustomer();
        $data['_payment_method'] = Payment::get_payment_method($this->user_info->shop_id);
        $data['_account']       = Accounting::getAllAccount('all','',['Bank']);
		return view('member.accounting_transaction.customer.receive_payment.receive_payment',$data);
	}
}