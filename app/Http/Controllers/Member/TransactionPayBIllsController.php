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

        return view('member.accounting_transaction.vendor.pay_bills.pay_bills', $data);
    }
    
}