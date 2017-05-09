<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

class ShopCheckoutLoginController extends Shop
{
    public function index()
    {
        $data["page"] = "Checkout - Login";
        return view("checkout_login", $data);
    }
}