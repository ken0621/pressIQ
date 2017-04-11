<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Globals\Customer;
use App\Globals\Vendor;
use App\Globals\Billing;
use App\Globals\Accounting;
use App\Globals\Invoice;

use App\Models\Tbl_payment_method;
use App\Models\Tbl_receive_payment;
use App\Models\Tbl_receive_payment_line;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_user;

use Request;
use Session;
use Redirect;
use PDF;
use Carbon\Carbon;
use App\Globals\AuditTrail;

class Vendor_PayBillController extends Member
{
    public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public function index()
    {        
        $data["v_id"]           = Request::input("vendor_id");
        $data["_vendor"]        = Vendor::getAllVendor('active');
        $data['_account']       = Accounting::getAllAccount();
        $data['_payment_method']= Tbl_payment_method::where("archived",0)->where("shop_id", $this->getShopId())->get();
        $data['action']         = "/member/customer/pay_bill/add";
        $data["_bill"]       = Billing::getAllBillByVendor($data["v_id"]);

        $id = Request::input('id');
        if($id)
        {
            $data["paybill"]         = Tbl_receive_payment::where("rp_id", $id)->first();
            $data["_paybill_line"]   = Tbl_receive_payment_line::where("rpline_rp_id", $id)->get();
            $data["_bill"]           = Billing::getAllInvoiceByCustomerWithRcvPymnt($data["paybill"]->paybill_vendor_id, $data["paybill"]->paybill_id);
            // dd($data["_invoice"]);
            $data['action']             = "/member/customer/receive_payment/update/".$data["paybill"]->paybill_id;
        }

        return view("member.pay_bill.pay_bill", $data);
    }

    public function load_vendor_pb($vendor_id)
    {
        $data["_bill"] = Billing::getAllBillByVendor($vendor_id);
        return view('member.pay_bill.load_pay_bill_items', $data);
    }

    public function add_receive_payment()
    {
        // dd(Request::input());
        $insert["rp_shop_id"]           = $this->getShopId();
        $insert["rp_customer_id"]       = Request::input('rp_customer_id');
        $insert["rp_ar_account"]        = Request::input('rp_ar_account') or 0;
        $insert["rp_date"]              = datepicker_input(Request::input('rp_date'));
        $insert["rp_total_amount"]      = convertToNumber(Request::input('rp_total_amount'));
        $insert["rp_payment_method"]    = Request::input('rp_payment_method');
        $insert["rp_memo"]              = Request::input('rp_memo');
        $insert["date_created"]         = Carbon::now();

        $rcvpayment_id  = Tbl_receive_payment::insertGetId($insert);

        $txn_line = Request::input('line_is_checked');
        foreach($txn_line as $key=>$txn)
        {
            if($txn == 1)
            {
                $insert_line["rpline_rp_id"]            = $rcvpayment_id;
                $insert_line["rpline_reference_name"]   = Request::input('rpline_txn_type')[$key];
                $insert_line["rpline_reference_id"]     = Request::input('rpline_txn_id')[$key];
                $insert_line["rpline_amount"]           = convertToNumber(Request::input('rpline_amount')[$key]);

                Tbl_receive_payment_line::insert($insert_line);
                if($insert_line["rpline_reference_name"] == 'invoice')
                {
                    Invoice::updateAmountApplied($insert_line["rpline_reference_id"]);
                }
            }
        }

        $rcv_data = AuditTrail::get_table_data("tbl_receive_payment","rp_id",$rcvpayment_id);
        AuditTrail::record_logs("Added","receive_payment",$rcvpayment_id,"",serialize($rcv_data));

        $button_action = Request::input('button_action');

        $json["status"]         = "success";
        $json["rcvpayment_id"]  = $rcvpayment_id;
        $json["message"]        = "Successfully received payment";
        $json["redirect"]            = "/member/customer/receive_payment";

        if($button_action == "save-and-edit")
        {
            $json["redirect"]    = "/member/customer/receive_payment?id=".$rcvpayment_id;
        }

        return json_encode($json);
    }

    public function update_receive_payment($rcvpayment_id)
    {
        // dd(Request::input());

        $old_data = AuditTrail::get_table_data("tbl_receive_payment","rp_id",$rcvpayment_id);

        $update["rp_customer_id"]       = Request::input('rp_customer_id');
        $update["rp_ar_account"]        = Request::input('rp_ar_account') or 0;
        $update["rp_date"]              = datepicker_input(Request::input('rp_date'));
        $update["rp_total_amount"]      = convertToNumber(Request::input('rp_total_amount'));
        $update["rp_payment_method"]    = Request::input('rp_payment_method');
        $update["rp_memo"]              = Request::input('rp_memo');

        Tbl_receive_payment::where("rp_id", $rcvpayment_id)->update($update);
        Tbl_receive_payment_line::where("rpline_rp_id", $rcvpayment_id)->delete();

        $txn_line = Request::input('line_is_checked');
        foreach($txn_line as $key=>$txn)
        {
            if($txn == 1)
            {
                $insert_line["rpline_rp_id"]            = $rcvpayment_id;
                $insert_line["rpline_reference_name"]   = Request::input('rpline_txn_type')[$key];
                $insert_line["rpline_reference_id"]     = Request::input('rpline_txn_id')[$key];
                $insert_line["rpline_amount"]           = convertToNumber(Request::input('rpline_amount')[$key]);

                Tbl_receive_payment_line::insert($insert_line);
                if($insert_line["rpline_reference_name"] == 'invoice')
                {
                    Invoice::updateAmountApplied($insert_line["rpline_reference_id"]);
                }
            }
        }

        $new_data = AuditTrail::get_table_data("tbl_receive_payment","rp_id",$rcvpayment_id);
        AuditTrail::record_logs("Updated","receive_payment",$rcvpayment_id,serialize($old_data),serialize($new_data));


        $button_action = Request::input('button_action');

        $json["status"]         = "success";
        $json["rcvpayment_id"]  = $rcvpayment_id;
        $json["message"]        = "Successfully updated payment";
        $json["url"]            = "/member/customer/receive_payment?id=".$rcvpayment_id;
        
        if($button_action == "save-and-new")
        {
            $json["redirect"]   = '/member/customer/receive_payment';
        }

        return json_encode($json);
    }
}
