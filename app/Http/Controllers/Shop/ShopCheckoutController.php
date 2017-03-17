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
use App\Globals\Ec_order;
use Validator;
use Carbon\Carbon;

class ShopCheckoutController extends Shop
{
    public function index()
    {
        $data["page"]            = "Checkout";
        $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);
        $data["_payment_method"] = Tbl_online_pymnt_method::get();
        // dd($data["get_cart"]);
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
            // Explode Birthday
            $get_birthday = Request::input("customer_birthdate")[0] . " " . Request::input("customer_birthdate")[1] . ", " . Request::input("customer_birthdate")[2];
            // Variant ID (Array)
            $invline_item_id = [];
            // Discounted Price (Array)
            $invline_discount = [];
            // Original Price (Array)
            $invline_rate = [];
            // Qty (Array)
            $invline_qty = [];
            // Discount Remark (Array)
            $invline_discount_remark = [];
            // Description (Array)
            $invline_description = [];
            // Date (Array)
            $invline_service_date = [];
            // Restructure Cart
            foreach ($get_cart['cart'] as $key => $value) 
            {
                array_push($invline_item_id, $value["product_id"]);
                array_push($invline_discount, $value["cart_product_information"]["product_discounted_value"]);
                array_push($invline_rate, $value["cart_product_information"]["product_price"]);
                array_push($invline_qty, $value["quantity"]);
                array_push($invline_discount_remark, "");
                array_push($invline_description, "");
                array_push($invline_service_date, date('Y-m-d H:i:s'));
            }
            $cart["invline_item_id"] = $invline_item_id;
            $cart["invline_discount"] = $invline_discount;
            $cart["invline_rate"] = $invline_rate;
            $cart["invline_qty"] = $invline_qty;
            $cart["invline_discount_remark"] = $invline_discount_remark;
            $cart["invline_service_date"] = $invline_service_date;
            $cart["invline_description"] = $invline_description;
            $cart["customer"] = null;
            $cart["customer"]["customer_first_name"] = Request::input("customer_first_name");
            $cart["customer"]["customer_middle_name"] = Request::input("customer_middle_name");
            $cart["customer"]["customer_last_name"] = Request::input("customer_last_name");
            $cart["customer"]["customer_email"] = Request::input("customer_email");
            $cart["customer"]["customer_birthdate"] = $get_birthday;
            $cart["customer"]["customer_mobile"] = Request::input("customer_mobile");
            $cart["customer"]["customer_country_id"] = $get_country ? $get_country->country_id : '420';
            $cart["customer"]["customer_state_province"] = Request::input("customer_state_province");
            $cart["customer"]["customer_city"] = Request::input("customer_city");
            $cart["customer"]["customer_address"] = Request::input("customer_address");
            $cart["payment_method_id"] = Request::input("payment_method_id");
            $cart["taxable"] = Request::input("taxable");
            $cart["shop_id"] = $this->shop_info->shop_id;

            $result = Ec_order::create_ec_order_automatic($cart);

            Cart::clear_all($this->shop_info->shop_id);
            
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