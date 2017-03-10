<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use App\Globals\Customer;
use App\Globals\Accounting;
use App\Globals\Invoice;

use App\Models\Tbl_payment_method;
use App\Models\Tbl_receive_payment;
use App\Models\Tbl_receive_payment_line;

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
        $data["_customer"]      = Customer::getAllCustomer();
        $data['_account']       = Accounting::getAllAccount();
        $data['action']         = "/member/customer/receive_payment/add";
        $data['_payment_method']= Tbl_payment_method::where("archived",0)->where("shop_id", $this->user_info->shop_id )->get();

        $id = Request::input('id');
        if($id)
        {
            $data["rcvpayment"]         = Tbl_receive_payment::where("rp_id", $id)->first();
            $data["_rcvpayment_line"]   = Tbl_receive_payment_line::where("rpline_rp_id", $id)->get();
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
        $insert["rp_date"]              = date("Y-m-d H:i:s", strtotime(Request::input('rp_date')));
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
                $insert_line["rpline_rp_id"]    = $rcvpayment_id;
                $insert_line["rpline_txn_type"] = Request::input('rpline_txn_type')[$key];
                $insert_line["rpline_txn_id"]   = Request::input('rpline_txn_id')[$key];
                $insert_line["rpline_amount"]   = convertToNumber(Request::input('rpline_amount')[$key]);

                Tbl_receive_payment_line::insert($insert_line);
            }
        }

        AuditTrail::record_logs("Added","receive_payment",$rcvpayment_id,"",serialize($insert));

        $json["status"]         = "success";
        $json["rcvpayment_id"]  = $rcvpayment_id;

        return json_encode($json);
    }

    public function update_receive_payment()
    {
        
    }
}
