<?php

namespace App\Http\Controllers;

/*use Illuminate\Http\Request;*/

use Request;
use Redirect;
use App\Http\Controllers\Controller;
use App\Globals\Dragonpay2\Dragon_RequestPayment;
use App\Globals\Mlm_member;
use App\Models\Tbl_mlm_slot;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_gc;
use Session;
use Carbon\Carbon;
use App\Globals\Ec_order;
use DB;
class PaymentController extends Controller
{
    protected $_merchantid = 'MYPHONE' ;
    protected $_merchantkey = 'Ez9MiNqWBS2BHuO' ;
    
    public function index()
    {
        $data['_page'] = "Dragonpay";
        return view('payment', $data);
    }

    public function onSubmitPayment()
    {
        $request = Request::all();
        $requestpayment = new Dragon_RequestPayment($this->_merchantkey);

        $this->_data = array(
            'merchantid'    => $requestpayment->setMerchantId($this->_merchantid),
            'txnid'         => $requestpayment->setTxnId($request['txnid']),
            'amount'        => $requestpayment->setAmount($request['amount']),
            'ccy'           => $requestpayment->setCcy($request['ccy']),
            'description'   => $requestpayment->setDescription($request['description']),
            'email'         => $requestpayment->setEmail($request['email']),
            'digest'        => $requestpayment->getdigest(),
            'param1'        => "test"
        );

        Dragon_RequestPayment::make($this->_merchantkey, $this->_data);   
    }

    public function dragonpay_postback()
    {
        $request = Request::all();

        $insert["log_date"] = Carbon::now();
        $insert["content"]  = serialize($request);
        DB::table("tbl_dragonpay_logs")->insert($insert);

        if ($request["status"] == "S") 
        {
            $from = $request["param1"];

            if ($from == "checkout") 
            {
                $order_id = $request["param2"];

                try 
                {
                    $update['ec_order_id'] = $order_id;
                    $update['order_status'] = "Processing";
                    $update['payment_status'] = 1;
                    $order = Ec_order::update_ec_order($update);
                } 
                catch (\Exception $e) 
                {
                    $last["log_date"] = Carbon::now();
                    $last["content"]  = $e->getMessage();
                    DB::table("tbl_dragonpay_logs")->insert($last);  
                }      
            }
        }
    }
}
