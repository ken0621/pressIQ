<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Globals\Customer;
use App\Globals\Vendor;
use App\Globals\Billing;
use App\Globals\Accounting;
use App\Globals\Invoice;
use App\Globals\WriteCheck;
use App\Globals\BillPayment;
use App\Globals\Utilities;
use App\Globals\Pdf_global;

use App\Models\Tbl_payment_method;
use App\Models\Tbl_receive_payment;
use App\Models\Tbl_receive_payment_line;
use App\Models\Tbl_pay_bill;
use App\Models\Tbl_pay_bill_line;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_user;

use Session;
use Redirect;
use PDF;
use Carbon\Carbon;
use App\Globals\AuditTrail;

class TransactionPayBillsController extends Member
{
	public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
    }
    public function getIndex()
    {
        $data['page'] = 'Pay Bills';
        return view('member.accounting_transaction.vendor.pay_bills.pay_bills_list', $data);
    }

    public function getCreate(Request $request)
    {
        $data['page'] = 'Create Pay Bills';

    	$data["v_id"]           = $request->vendor_id;
        $data["bill_id"]        = $request->bill_id;
        $data["_vendor"]        = Vendor::getAllVendor('active');
        $data['_account']       = Accounting::getAllAccount('all',null,['Bank']);
        $data['_payment_method']= Tbl_payment_method::where("archived",0)->where("shop_id", $this->getShopId())->get();

        $data['action']     = "/member/transaction/pay_bills/create-pay-bills";

        return view('member.accounting_transaction.vendor.pay_bills.pay_bills', $data);
    }

    public function postCreatePayBills(Request $request)
    {
        $btn_action  = $request->button_action;

        $insert["paybill_vendor_id"]         = $request->paybill_vendor_id;
        $insert["paybill_ap_id"]             = $request->paybill_ap_id != "" ? $request->paybill_ap_id : 0;
        $insert["paybill_date"]              = $request->paybill_date;
        $insert["paybill_total_amount"]      = $request->paybill_total_amount;
        $insert["paybill_payment_method"]    = $request->paybill_payment_method;
        $insert["paybill_memo"]              = $request->paybill_memo;

        $insert = null;
        $ctr_bill = 0;
        foreach($request->line_is_checked as $key => $value)
        {
            if($value)
            {
                $ctr_bill++;
                $insert[$key]["line_is_checked"]         = $request->line_is_checked[$key];
                $insert[$key]["pbline_reference_name"]   = $request->pbline_txn_type[$key];
                $insert[$key]["pbline_reference_id"]     = $request->pbline_bill_id[$key];
                $insert[$key]["pbline_amount"]           = str_replace(',', '',$request->pbline_amount[$key]);
            }

            die(var_dump($btn_action));
        }
    }
}