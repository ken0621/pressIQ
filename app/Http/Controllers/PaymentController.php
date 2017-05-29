<?php

namespace App\Http\Controllers;

/*use Illuminate\Http\Request;*/

use Request;
use Redirect;
use App\Http\Controllers\Controller;

use App\Globals\Dragonpay\Dragon_RequestPayment;
use App\Globals\Mlm_member;
use App\Models\Tbl_mlm_slot;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_gc;
use Session;
use Carbon\Carbon;
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
        );

        Dragon_RequestPayment::make($this->_merchantkey, $this->_data);   
    }

    public function postback_url()
    {
        dd("postback");
    }

    public function return_url()
    {
        $status = Request::input("status");

        if ($status == "S") 
        {
            // $shop_id =  Session::get('shop_id_session');
            $shop_id = 5;
            $register_session = Session::get('mlm_register_step_1');
            $customer_id = Mlm_member::register_slot_insert_customer($shop_id, $register_session);
            

            $register_session_2 = Session::get('mlm_register_step_2');
            $slot_sponsor = Tbl_mlm_slot::where('slot_nick_name', $register_session['sponsor'])->first();
            $insert['slot_no'] = Mlm_plan::set_slot_no($shop_id, null);
            $insert['shop_id'] = $shop_id;
            $insert['slot_owner'] = $customer_id;
            $insert['slot_created_date'] = Carbon::now();
            $insert['slot_membership'] = $register_session_2['membership'];
            $insert['slot_status'] = 'PS';
            $insert['slot_sponsor'] = $slot_sponsor->slot_id;
            // $insert['slot_nick_name'] = 
            $id = Tbl_mlm_slot::insertGetId($insert);
            $a = Mlm_compute::entry($id);
            $c = Mlm_gc::slot_gc($id);
            $slot_info = Mlm_compute::get_slot_info($id);
            Mlm_compute::set_slot_nick_name_2($slot_info);
            $data['status'] = 'success';
            $data['message'][0] = 'Membership Code Already Used.';
            $data['link'] = '/mlm';

            Session::forget('mlm_register_step_1');
            Session::forget('mlm_register_step_2');
            Session::forget('mlm_register_step_3');

            Mlm_member::add_to_session_edit($shop_id, $customer_id, $id);

            return Redirect::to("/mlm");
        }
        else
        {
            dd("Transaction failed. </br> Please do not refresh the page and wait while we are processing your payment. This can take a few minutes.");
        }
    }

}
