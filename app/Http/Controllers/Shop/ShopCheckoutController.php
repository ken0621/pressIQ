<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Globals\Cart;
use App\Models\Tbl_country;
use App\Models\Tbl_online_pymnt_method;
use App\Globals\Customer;
use Validator;

class ShopCheckoutController extends Shop
{
    public function index()
    {
        $data["page"]            = "Checkout";
        $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);
        $data["_payment_method"] = Tbl_online_pymnt_method::get();

        return view("checkout", $data);
    }
    public function submit()
    {
        // Validate Customer Info
        $rules["customer_first_name"] = 'required';
        $rules["customer_middle_name"] = 'required';
        $rules["customer_last_name"] = 'required';
        $rules["customer_email"] = 'required';
        $rules["customer_birthdate"] = 'required';
        $rules["customer_mobile"] = 'required';
        $rules["customer_state_province"] = 'required';
        $rules["customer_city"] = 'required';
        $rules["customer_address"] = 'required';
        $rules["payment_method_id"] = 'required';
        $rules["taxable"] = 'required';

        $validator = Validator::make(Request::input(), $rules);

        if ($validator->fails()) 
        {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else
        {
            // Get Cart
            $get_cart = Cart::get_cart($this->shop_info->shop_id);
            // Get Country ID (Philippines)
            $get_country = Tbl_country::where("country_name", "Philippines")->first();
            // Variant ID (Array)
            $invline_item_id = [];
            // Discounted Price (Array)
            $invline_discount = [];
            // Original Price (Array)
            $invline_rate = [];
            // Restructure Cart
            foreach ($get_cart['cart'] as $key => $value) 
            {
                array_push($invline_item_id, $value["product_id"]);
                array_push($invline_discount, $value["cart_product_information"]["product_discounted_value"]);
                array_push($invline_rate, $value["cart_product_information"]["product_price"]);
            }
            $cart["invline_item_id"] = $invline_item_id;
            $cart["invline_discount"] = $invline_discount;
            $cart["invline_rate"] = $invline_rate;
            $cart["customer_first_name"] = Request::input("customer_first_name");
            $cart["customer_middle_name"] = Request::input("customer_middle_name");
            $cart["customer_last_name"] = Request::input("customer_last_name");
            $cart["customer_email"] = Request::input("customer_email");
            $cart["customer_birthdate"] = Request::input("customer_birthdate");
            $cart["customer_mobile"] = Request::input("customer_mobile");
            $cart["customer_country_id"] = $get_country ? $get_country->country_id : '420';
            $cart["customer_state_province"] = Request::input("customer_state_province");
            $cart["customer_city"] = Request::input("customer_city");
            $cart["customer_address"] = Request::input("customer_address");
            $cart["payment_method_id"] = Request::input("payment_method_id");
            $cart["taxable"] = Request::input("taxable");
            $cart["shop_id"] = $this->shop_info->shop_id;

            $result = Customer::createCustomer($this->shop_info->shop_id ,$cart);
            
            return Redirect::to("/");
        }
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