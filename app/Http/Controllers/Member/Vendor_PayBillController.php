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
use App\Models\Tbl_pay_bill;
use App\Models\Tbl_pay_bill_line;
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
        $data['action']         = "/member/vendor/paybill/add";
        $data["_bill"]       = Billing::getAllBillByVendor($data["v_id"]);

        $id = Request::input('id');
        if($id)
        {
            $data["paybill"]         = Tbl_pay_bill::where("paybill_id", $id)->first();
            $data["_paybill_line"]   = Tbl_pay_bill_line::where("pbline_pb_id", $id)->get();
            $data["_bill"]           = Billing::getAllBillByVendorWithPaybill($data["paybill"]->paybill_vendor_id, $data["paybill"]->paybill_id);
            // dd($data["_invoice"]);
            $data['action']             = "/member/vendor/paybill/update/".$data["paybill"]->paybill_id;
        }

        return view("member.pay_bill.pay_bill", $data);
    }

    public function load_vendor_pb($vendor_id)
    {
        $data["_bill"] = Billing::getAllBillByVendor($vendor_id);
        return view('member.pay_bill.load_pay_bill_items', $data);
    }

    public function add_pay_bill()
    {
        // dd(Request::input());
        $insert["paybill_shop_id"]           = $this->getShopId();
        $insert["paybill_vendor_id"]         = Request::input('paybill_vendor_id');
        $insert["paybill_ap_id"]           = Request::input('paybill_ap_id') != "" ? Request::input('paybill_ap_id') : 0;
        $insert["paybill_date"]              = datepicker_input(Request::input('paybill_date'));
        $insert["paybill_total_amount"]      = convertToNumber(Request::input('paybill_total_amount'));
        $insert["paybill_payment_method"]    = Request::input('paybill_payment_method');
        $insert["paybill_memo"]              = Request::input('paybill_memo');
        $insert["paybill_date_created"]      = Carbon::now();

        $paybill_id  = Tbl_pay_bill::insertGetId($insert);

        $txn_line = Request::input('line_is_checked');
        foreach($txn_line as $key=>$txn)
        {
            if($txn == 1)
            {
                $insert_line["pbline_pb_id"]            = $paybill_id;
                $insert_line["pbline_reference_name"]   = Request::input('pbline_txn_type')[$key];
                $insert_line["pbline_reference_id"]     = Request::input('pbline_bill_id')[$key];
                $insert_line["pbline_amount"]           = convertToNumber(Request::input('pbline_amount')[$key]);

                Tbl_pay_bill_line::insert($insert_line);
                if($insert_line["pbline_reference_name"] == 'bill')
                {
                    //bill
                    Billing::updateAmountApplied($insert_line["pbline_reference_id"]);
                }
            }
        }

        $bill_data = AuditTrail::get_table_data("tbl_bill","bill_id",$paybill_id);
        AuditTrail::record_logs("Added","bill",$paybill_id,"",serialize($bill_data));

        $button_action = Request::input('button_action');

        $json["status"]         = "success";
        $json["rcvpayment_id"]  = $paybill_id;
        $json["message"]        = "Successfully Pay Bill";
        $json["redirect"]            = "/member/vendor/paybill";

        if($button_action == "save-and-edit")
        {
            $json["redirect"]    = "/member/vendor/paybill?id=".$paybill_id;
        }

        return json_encode($json);
    }

    public function update_pay_bill($paybill_id)
    {

        $old_data = AuditTrail::get_table_data("tbl_pay_bill","paybill_id",$paybill_id);

        $update["paybill_shop_id"]           = $this->getShopId();
        $update["paybill_vendor_id"]         = Request::input('paybill_vendor_id');
        $update["paybill_ap_id"]             = Request::input('paybill_ap_id') != "" ? Request::input('paybill_ap_id') : 0;
        $update["paybill_date"]              = datepicker_input(Request::input('paybill_date'));
        $update["paybill_total_amount"]      = convertToNumber(Request::input('paybill_total_amount'));
        $update["paybill_payment_method"]    = Request::input('paybill_payment_method');
        $update["paybill_memo"]              = Request::input('paybill_memo');
        $update["paybill_date_created"]      = Carbon::now();

        Tbl_pay_bill::where("paybill_id", $paybill_id)->update($update);
        Tbl_pay_bill_line::where("pbline_pb_id", $paybill_id)->delete();

        $txn_line = Request::input('line_is_checked');
        foreach($txn_line as $key=>$txn)
        {
            if($txn == 1)
            {
                $insert_line["pbline_pb_id"]            = $paybill_id;
                $insert_line["pbline_reference_name"]   = Request::input('pbline_txn_type')[$key];
                $insert_line["pbline_reference_id"]     = Request::input('pbline_bill_id')[$key];
                $insert_line["pbline_amount"]           = convertToNumber(Request::input('pbline_amount')[$key]);

                Tbl_pay_bill_line::insert($insert_line);
                if($insert_line["pbline_reference_name"] == 'bill')
                {
                    //bill
                    Billing::updateAmountApplied($insert_line["pbline_reference_id"]);
                }
            }
            else
            {
                Billing::updateAmountApplied(Request::input('pbline_bill_id')[$key]);
            }
        }

        $new_data = AuditTrail::get_table_data("tbl_pay_bill","paybill_id",$paybill_id);
        AuditTrail::record_logs("Updated","bill",$paybill_id,serialize($old_data),serialize($new_data));


        $button_action = Request::input('button_action');

        $json["status"]         = "success";
        $json["bill_id"]        = $paybill_id;
        $json["message"]        = "Successfully updated Pay Bills";
        $json["redirect"]            = "/member/vendor/paybill?id=".$paybill_id;
        
        if($button_action == "save-and-new")
        {
            $json["redirect"]   = '/member/vendor/paybill';
        }

        return json_encode($json);
    }
}
