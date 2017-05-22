<?php

namespace App\Http\Controllers;

/*use Illuminate\Http\Request;*/

use Request;
use Redirect;
use App\Http\Controllers\Controller;

use App\Globals\Dragonpay\RequestPayment;

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
        //dd($request['txnid']);
        $requestpayment = new RequestPayment($this->_merchantkey);

        $this->_data = array(
            'merchantid'    => $requestpayment->setMerchantId($this->_merchantid),
            'txnid'         => $requestpayment->setTxnId($request['txnid']),
            'amount'        => $requestpayment->setAmount($request['amount']),
            'ccy'           => $requestpayment->setCcy($request['ccy']),
            'description'   => $requestpayment->setDescription($request['description']),
            'email'         => $requestpayment->setEmail($request['email']),
            'digest'        => $requestpayment->getdigest(),
        );

        //dd($requestpayment->getdigest());
        RequestPayment::make($this->_merchantkey, $this->_data);   
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
            return Redirect::to("/mlm");
        }
        else
        {
            dd("Transaction failed. </br> Please do not refresh the page and wait while we are processing your payment. This can take a few minutes.");
        }
    }

}
