<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use App\Globals\Customer;
use App\Globals\Accounting;
use App\Globals\Invoice;
use App\Globals\CreditMemo;

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

/**
 * Receive Payment Module - all payment related module
 *
 * @author Bryan Kier Aradanas
 */

class Customer_ReceivePaymentController extends Member
{

    public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public function index()
    {    

        $data["c_id"] = Request::input("customer_id");
        $data["_customer"]      = Customer::getAllCustomer();
        $data['_account']       = Accounting::getAllAccount('all','',['Bank']);
        $data['_payment_method']= Tbl_payment_method::where("archived",0)->where("shop_id", $this->getShopId())->get();
        $data['action']         = "/member/customer/receive_payment/add";
        $data["_invoice"] = Invoice::getAllInvoiceByCustomer($data["c_id"]);

        $id = Request::input('id');
        if($id)
        {
            $data["rcvpayment"]         = Tbl_receive_payment::where("rp_id", $id)->first();
            $data["_rcvpayment_line"]   = Tbl_receive_payment_line::where("rpline_rp_id", $id)->get();
            $data["_invoice"]           = Invoice::getAllInvoiceByCustomerWithRcvPymnt($data["rcvpayment"]->rp_customer_id, $data["rcvpayment"]->rp_id);
            $data['action']             = "/member/customer/receive_payment/update/".$data["rcvpayment"]->rp_id;
        }

        return view("member.receive_payment.receive_payment", $data);
    }

    public function load_customer_rp($customer_id)
    {
        $data["_invoice"] = Invoice::getAllInvoiceByCustomer($customer_id);
        return view('member.receive_payment.load_receive_payment_items', $data);
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

                $cm_amount = CreditMemo::cm_amount(Request::input('rpline_txn_id')[$key]);
                
                $insert_line["rpline_amount"]           = convertToNumber(Request::input('rpline_amount')[$key]) + $cm_amount;

                Tbl_receive_payment_line::insert($insert_line);

                if($insert_line["rpline_reference_name"] == 'invoice')
                {
                    Invoice::updateAmountApplied($insert_line["rpline_reference_id"]);
                }
            }
        }
        /* Transaction Journal */
        $entry["reference_module"]      = "receive-payment";
        $entry["reference_id"]          = $rcvpayment_id;
        $entry["name_id"]               = $insert["rp_customer_id"];
        $entry["total"]                 = $insert["rp_total_amount"];
        $entry_data[0]['account_id']    = $insert["rp_ar_account"];
        $entry_data[0]['vatable']       = 0;
        $entry_data[0]['discount']      = 0;
        $entry_data[0]['entry_amount']  = $insert["rp_total_amount"];
        $inv_journal = Accounting::postJournalEntry($entry, $entry_data);
        
        $rcv_data = AuditTrail::get_table_data("tbl_receive_payment","rp_id",$rcvpayment_id);
        AuditTrail::record_logs("Added","receive_payment",$rcvpayment_id,"",serialize($rcv_data));

        $button_action = Request::input('button_action');

        $json["status"]         = "success";
        $json["rcvpayment_id"]  = $rcvpayment_id;
        $json["message"]        = "Successfully received payment";
        $json["redirect"]       = "/member/customer/receive_payment";

        if($button_action == "save-and-edit")
        {
            $json["redirect"]    = "/member/customer/receive_payment?id=".$rcvpayment_id;
        }

        return json_encode($json);
    }

    public function update_receive_payment($rcvpayment_id)
    {
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
           
                $cm_amount = CreditMemo::cm_amount(Request::input('rpline_txn_id')[$key]);
                $insert_line["rpline_amount"]           = convertToNumber(Request::input('rpline_amount')[$key]) + $cm_amount;

                Tbl_receive_payment_line::insert($insert_line);
                if($insert_line["rpline_reference_name"] == 'invoice')
                {
                    Invoice::updateAmountApplied(Request::input('rpline_txn_id')[$key]);
                }
            }
            else
            {
                Invoice::updateAmountApplied(Request::input('rpline_txn_id')[$key]);
            }
        }

        /* Transaction Journal */
        $entry["reference_module"]      = "receive-payment";
        $entry["reference_id"]          = $rcvpayment_id;
        $entry["name_id"]               = $update["rp_customer_id"];
        $entry["total"]                 = $update["rp_total_amount"];
        $entry_data[0]['account_id']    = $update["rp_ar_account"];
        $entry_data[0]['vatable']       = 0;
        $entry_data[0]['discount']      = 0;
        $entry_data[0]['entry_amount']  = $update["rp_total_amount"];
        $inv_journal = Accounting::postJournalEntry($entry, $entry_data);

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
