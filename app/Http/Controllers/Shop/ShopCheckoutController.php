<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Globals\Cart;

class ShopCheckoutController extends Shop
{
    public function index()
    {
        $data["page"]       = "Checkout";
        $data["get_cart"]   = Cart::get_cart($this->shop_info->shop_id);
        return view("checkout", $data);
    }
    public function order_placed()
    {
    	$data["page"] = "Checkout - Order Placed";
    	return view("order_placed", $data);
    }
    public function addtocart()
    {
        $data["page"] = "Checkout - Add to Cart";
        return view("addto_cart", $data);
    }
}