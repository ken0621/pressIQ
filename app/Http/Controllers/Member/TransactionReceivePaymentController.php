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

		$insert['transaction_refnum']	 		= $request->transaction_refnumber;
		$insert['customer_id'] 			 		= $request->customer_id;
		$insert['customer_email']        		= $request->customer_email;
		$insert['transaction_payment_method']   = $request->transaction_payment_method;
		$insert['transaction_ref_no']     		= $request->transaction_ref_no;
		$insert['rp_ar_account']  				= $request->rp_ar_account;
		$insert['customer_memo']         	    = $request->customer_memo;
		$insert['transaction_date']       	    = date("Y-m-d", strtotime($request->transaction_date));
		$insert['rp_total_amount']				= $request->rp_total_amount;

		$insert_item = null;
		$txn_line = $request->line_is_checked;
		if($txn_line)
		{
	        foreach($txn_line as $key => $txn)
	        {
	            if($txn == 1)
	            {
	                $insert_item[$key]["rpline_reference_name"]   = $request->rpline_txn_type[$key];
	                $insert_item[$key]["rpline_reference_id"]     = $request->rpline_txn_id[$key];
	                $insert_item[$key]["rpline_amount"] 		  = $request->rpline_amount[$key];
	            }
	        }
		}

        $return = null;
		$validate = TransactionReceivePayment::postInsert($this->user_info->shop_id, $insert, $insert_item);
		if(is_numeric($validate))
		{
			$return['status'] = 'success';
			$return['status_message'] = 'Success receive payment.';
			$return['call_function'] = 'success_receive_payment';
			$return['status_redirect'] = AccountingTransaction::get_redirect('receive_payment', $validate ,$btn_action);
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
		return TransactionReceivePayment::countAvailableCredit($this->user_info->shop_id, $customer_id);
	}
	public function getLoadCredit(Request $request)
	{
		$data['_cm'] = TransactionCreditMemo::loadAvailableCredit($this->user_info->shop_id, $request->c);
		return view("member.accounting_transaction.customer.receive_payment.receive_payment",$data);
	}
}