<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Illuminate\Http\Request;
use View;
use Session;
use DB;
use Carbon\Carbon;
use App\Models\Tbl_product;
use App\Globals\Ecom_Product;
use App\Models\Tbl_ec_product;
use App\Globals\Cart2;
use App\Globals\Ec_wishlist;

class ShopCart2Controller extends Shop
{
    public function index(Request $request)
    {
        $data["cart"] = Cart2::get_cart_info();
        // dd($data);
        return view("cart_modal", $data);
    }
    public function add_cart(Request $request)
    {
        /* Get Active Cart */
        $active_cart_key = Cart2::get_cart_key();
        if (!$active_cart_key) 
        {
            /* Define Cart Key and Customer ID */
            if(Self::$customer_info)
            {   
                $cart_key = "customer-" . Self::$customer_info->customer_id;
                $customer_id = Self::$customer_info->customer_id;
            }
            else
            {
                $cart_key = "customer-" . time();
                $customer_id = 0;
            }

            /* Set Cart Key */
            Cart2::set_cart_key($cart_key);

            $key    = "price_level_id";
            $value  = "0";

            /* Set Customer ID */
            Cart2::set($key, $value);

            $key    = "customer_id";
            $value  = $customer_id;

            /* Set Invoice ID */
            Cart2::set($key, $value);

            $key    = "invoice_id";
            $value  = "0";

            /* Set Receipt ID */
            Cart2::set($key, $value);

            $key    = "receipt_id";
            $value  = "0";

            /* Set Shipping Fee */
            Cart2::set($key, $value);

            $key    = "shipping_fee";
            $value  = "0";

            /* Set Discount */
            Cart2::set($key, $value);

            $key    = "global_discount";
            $value  = "0";

            Cart2::set($key, $value);
        }

        /* Define Item */
        $item_id = $request->item_id;
        $quantity = $request->quantity;
        $shop_id = $this->shop_info->shop_id;
        
        /* Add to Cart */
        Cart2::add_item_to_cart($shop_id, $item_id, $quantity);

        /* Return Success */
        return response()->json("success");
    }    
}