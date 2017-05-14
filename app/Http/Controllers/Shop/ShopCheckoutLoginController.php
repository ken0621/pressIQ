<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Models\Tbl_customer;
use Crypt;
use Redirect;
use Request;
use View;
use File;
use Input;
use Validator;
use Carbon\Carbon;
use URL;
use Session;
use DB;

use App\Globals\Cart;

class ShopCheckoutLoginController extends Shop
{
    public function cart_exist($data)
    {
        if (!isset($data["get_cart"]['cart'])) 
        {
            return Redirect::to('/')->send();
        }
    }
    public function if_loggedin()
    {
        if(isset(Self::$customer_info->customer_id))
        {
            return Redirect::to('/checkout')->send();
        }
    }
    public function index()
    {
        if(Request::isMethod("post"))
        {
            /*  CHECK IF AN E-MAIL ALREADY EXIST */
            if (Request::input("email")) 
            {
                $check_email = Tbl_customer::where('shop_id', $this->shop_info->shop_id)->where('email', Request::input("email"))->count();

                if($check_email)
                {
                    return Redirect::to('/checkout/login?email=' . Request::input("email"))->with('warning', 'An account already exists with the email "' . Request::input("email") . '". Please enter your password below to continue.')->send();
                }
                else //IF E-MAIL DOESN'T EXIST CONTINUE TO FORM
                {
                    return Redirect::to("/checkout");
                }
            }
        }
        else
        {
            $data["page"]     = "Checkout - Login";
            $data["get_cart"] = Cart::get_cart($this->shop_info->shop_id);
            $this->cart_exist($data);
            $this->if_loggedin();
            return view("checkout_login", $data);
        }

        
    }
}