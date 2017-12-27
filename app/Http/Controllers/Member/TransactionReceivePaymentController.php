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
use App\Globals\TransactionReceivePayment;

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
        $data['action'] 		= "/member/transaction/receive_payment/create-receive-payment";

		return view('member.accounting_transaction.customer.receive_payment.receive_payment',$data);
	}
	public function postCreateReceivePayment(Request $request)
	{
		$btn_action = $request->button_action;

		$insert['transaction_refnumber'] 		= $request->transaction_refnumber;
		$insert['customer_id'] 			 		= $request->customer_id;
		$insert['customer_email']        		= $request->customer_email;
		$insert['transaction_payment_method']   = $request->transaction_payment_method;
		$insert['transaction_ref_no']     		= $request->transaction_ref_no;
		$insert['rp_ar_account']  				= $request->rp_ar_account;
		$insert['customer_memo']         	    = $request->customer_memo;

		$txn_line = Request::input('line_is_checked');
        foreach($txn_line as $key=>$txn)
        {
            if($txn == 1)
            {
                $insert_item[$key]["rpline_reference_name"]   = $request->rpline_txn_type[$key];
                $insert_item[$key]["rpline_reference_id"]     = $request->rpline_txn_id[$key];
                $insert_item[$key]["rpline_amount"] 		  = $request->rpline_amount[$key];
            }
        }
        
		die(var_dump($btn_action));
	}

	public function getCountTransaction(Request $request)
	{
		$customer_id = $request->customer_id;
		return TransactionReceivePayment::countAvailableCredit($this->user_info->shop_id, $customer_id);
	}
	public function getLoadCredit(Request $request)
	{
		dd("Under Maintenance");
	}
}