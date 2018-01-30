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
use App\Globals\TransactionPayBills;
use App\Globals\AccountingTransaction;
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
    public function getIndex()
    {
        $data['page'] = 'Pay Bills';
        return view('member.accounting_transaction.vendor.pay_bills.pay_bills_list', $data);
    }
    public function getLoadPayBills(Request $request)
    {
        $data['_pay_bills'] = TransactionPayBills::get($this->user_info->shop_id, 10, $request->search_keyword);
        return view('member.accounting_transaction.vendor.pay_bills.pay_bills_table', $data);
    }
    public function getCreate(Request $request)
    {
        $data['page'] = 'Create Pay Bills';

    	$data["v_id"]           = $request->vendor_id;
        $data["bill_id"]        = $request->bill_id;
        $data["_vendor"]        = Vendor::getAllVendor('active');
        $data['_account']       = Accounting::getAllAccount('all',null,['Bank']);
        $data['_payment_method']= Tbl_payment_method::where("archived",0)->where("shop_id", $this->user_info->shop_id)->get();
        $data["transaction_refnum"] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'pay_bill');
        $data['action']         = "/member/transaction/pay_bills/create-pay-bills";

        $pb_id = $request->id;

        if($pb_id)
        {
            $data['pb']     = TransactionPayBills::info($this->user_info->shop_id, $pb_id);
            $data["_bill"]  = TransactionPayBills::info_item($this->user_info->shop_id, $data["pb"]->paybill_vendor_id, $data["pb"]->paybill_id);
            $data['action'] = "/member/transaction/pay_bills/update-pay-bills";
        }

        return view('member.accounting_transaction.vendor.pay_bills.pay_bills', $data);
    }

    public function getLoadVendorPayBill($vendor_id)
    {
        $data["_bill"] = Billing::getAllBillByVendor($vendor_id);
        return view('member.accounting_transaction.vendor.pay_bills.load_pay_bills', $data);
    }

    public function postCreatePayBills(Request $request)
    {
        $btn_action  = $request->button_action;

        $insert["vendor_id"]                 = $request->vendor_id;
        $insert["transaction_refnumber"]     = $request->transaction_refnumber;
        $insert["paybill_ap_id"]             = $request->paybill_ap_id != "" ? $request->paybill_ap_id : 0;
        $insert["paybill_date"]              = $request->paybill_date;
        $insert["paybill_total_amount"]      = $request->paybill_total_amount;
        $insert["paybill_payment_method"]    = $request->paybill_payment_method;
        $insert["paybill_ref_num"]           = $request->paybill_ref_num;
        $insert["paybill_memo"]              = $request->vendor_memo;

        
        $insert_item = null;
        $ctr_bill = 0;

        foreach($request->line_is_checked as $key => $value)
        {
            if($value)
            {
                $ctr_bill++;
            }
            
            $insert_item[$key]["line_is_checked"]         = $request->line_is_checked[$key];
            $insert_item[$key]["pbline_reference_name"]   = $request->pbline_txn_type[$key];
            $insert_item[$key]["pbline_reference_id"]     = $request->pbline_bill_id[$key];
            $insert_item[$key]["item_amount"]             = str_replace(',', '',$request->pbline_amount[$key]);
            $insert_item[$key]["item_discount"]           = 0;
            $insert_item[$key]["item_id"]                 = 0;
            $insert_item[$key]["item_qty"]                = 0;
            $insert_item[$key]["item_description"]        = 0;    
        }
        //die(var_dump($request->line_is_checked));
        
        if($ctr_bill != 0)
        {
            $validate = TransactionPayBills::postInsert($this->user_info->shop_id, $insert, $insert_item);

            $return = null;
            if(is_numeric($validate))
            {
                $return['status'] = 'success';
                $return['status_message'] = 'Success creating pay Bills.';
                $return['call_function'] = 'success_pay_bills';
                $return['status_redirect'] = AccountingTransaction::get_redirect('pay_bills', $validate ,$btn_action);
            }
            else
            {
                $return['status'] = 'error';
                $return['status_message'] = $validate;
            }
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = 'Please Select Item';
        }
        return json_encode($return);

    }

    public function postUpdatePayBills(Request $request)
    {
        $btn_action  = $request->button_action;
        $paybill_id  = $request->pb_id;

        $insert["vendor_id"]                 = $request->vendor_id;
        $insert["transaction_refnumber"]     = $request->transaction_refnumber;
        $insert["paybill_ap_id"]             = $request->paybill_ap_id != "" ? $request->paybill_ap_id : 0;
        $insert["paybill_date"]              = $request->paybill_date;
        $insert["paybill_total_amount"]      = $request->paybill_total_amount;
        $insert["paybill_payment_method"]    = $request->paybill_payment_method;
        $insert["paybill_ref_num"]           = $request->paybill_ref_num;
        $insert["paybill_memo"]              = $request->vendor_memo;

        $insert_item = null;
        $ctr_bill = 0;

        foreach($request->line_is_checked as $key => $value)
        {
            if($value)
            {
                $ctr_bill++;
            }
            
            $insert_item[$key]["line_is_checked"]         = $request->line_is_checked[$key];
            $insert_item[$key]["pbline_reference_name"]   = $request->pbline_txn_type[$key];
            $insert_item[$key]["pbline_reference_id"]     = $request->pbline_bill_id[$key];
            $insert_item[$key]["item_amount"]             = str_replace(',', '',$request->pbline_amount[$key]);
            $insert_item[$key]["item_discount"]           = 0;
            $insert_item[$key]["item_id"]                 = 0;
            $insert_item[$key]["item_qty"]                = 0;
            $insert_item[$key]["item_description"]        = 0;    
        }
        
        if($ctr_bill != 0)
        {
            $validate = TransactionPayBills::postUpdate($paybill_id, $this->user_info->shop_id, $insert, $insert_item);

            $return = null;
            if(is_numeric($validate))
            {
                $return['status'] = 'success';
                $return['status_message'] = 'Success creating pay Bills.';
                $return['call_function'] = 'success_pay_bills';
                $return['status_redirect'] = AccountingTransaction::get_redirect('pay_bills', $validate ,$btn_action);
            }
            else
            {
                $return['status'] = 'error';
                $return['status_message'] = $validate;
            }
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = 'Please Select Item';
        }
        return json_encode($return);
    }
}