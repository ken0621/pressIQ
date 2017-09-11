<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Globals\Payment;

class ShopMemberController extends Shop
{
    public function getIndex()
    {
        $data["page"] = "Dashboard";
        return view("member.dashboard", $data);
    }
    public function getRegister()
    {
    	$data["page"] = "Register";
    	return view("member.register", $data);
    }
    public function getLogin()
    {
    	$data["page"] = "Login";
    	return view("member.login", $data);
    }
    public function getTest()
    {
        $shop_id    = $this->shop_info->shop_id; //tbl_shop
        $key        = "paymaya"; //link reference name
        $success    = "/checkout/finish/success"; //redirect if payment success
        $failed     = "/checkout/finish/error"; //redirect if payment failed
        $debug      = false;

        $error = Payment::payment_redirect($shop_id, $key, $success, $failed, $debug);
        dd($error);
    }
}