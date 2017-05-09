<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
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
    public function index()
    {
        $data["page"] 	  = "Checkout - Login";
        $data["get_cart"] = Cart::get_cart($this->shop_info->shop_id);

        if (!isset($data["get_cart"]['cart'])) 
        {
            return Redirect::to('/');
        }

        return view("checkout_login", $data);
    }
}