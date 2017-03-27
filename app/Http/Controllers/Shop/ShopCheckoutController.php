<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

use Validator;
use Carbon\Carbon;

use App\Globals\Mlm_slot_log;
use App\Globals\Item_code;
use App\Globals\Cart;
use App\Globals\Customer;
use App\Globals\Ec_order;
use App\Models\Tbl_customer;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_item_code;
use App\Models\Tbl_country;
use App\Models\Tbl_online_pymnt_method;
use App\Models\Tbl_item;
use App\Models\Tbl_item_code_item;
// use App\Globals\Mlm_slot_log;    
class ShopCheckoutController extends Shop
{
    public function index()
    {
        $data["page"]            = "Checkout";
        $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);
        $data['ec_order_load'] = 0;
        foreach($data['get_cart'] as $value)
        {
            foreach($value as $key2=>$value2)
            {
                if($value2['cart_product_information']['item_category_id'] == 17)
                {
                    $data['ec_order_load'] = 1;
                }
            }
            
        }
        $data["_payment_method"] = Tbl_online_pymnt_method::get();
        if(Self::$customer_info != null)
        {
            $customer_info = Tbl_customer::where('tbl_customer.customer_id', Self::$customer_info->customer_id)->info()->first();
        }
        if(isset($customer_info))
        {
            $data['customer_first_name'] = $customer_info->first_name;
            $data['customer_middle_name'] = $customer_info->middle_name;
            $data['customer_last_name'] = $customer_info->last_name;
            $data['customer_email'] = $customer_info->email;
            $data['customer_mobile'] = $customer_info->customer_mobile;
            $data['customer_state_province'] = $customer_info->customer_state;
            $data['customer_city'] = $customer_info->customer_city;
            $data['customer_address'] = $customer_info->customer_street . ' ' .  $customer_info->customer_state . ' ' . $customer_info->customer_city;
        }
        else
        {
            $data['customer_first_name'] = '';
            $data['customer_middle_name'] = '';
            $data['customer_last_name'] = '';
            $data['customer_email'] = '';
            $data['customer_mobile'] = '';
            $data['customer_state_province'] = '';
            $data['customer_city'] = '';
            $data['customer_address'] = '';
        }

        return view("checkout", $data);
        
    }
    public function submit()
    {
        // Validate Customer Info
        $rules["customer_first_name"]   = 'required';
        $rules["customer_middle_name"]  = 'required';
        $rules["customer_last_name"]    = 'required';
        $rules["customer_email"]        = 'required';
        $rules["customer_birthdate"]    = 'required';
        $rules["customer_mobile"]       = 'required';
        $rules["customer_state_province"] = 'required';
        $rules["customer_city"]         = 'required';
        $rules["customer_address"]      = 'required';
        $rules["payment_method_id"]     = 'required';
        $rules["taxable"]               = 'required';

        $ec_order_load = Request::input('ec_order_load');
        if($ec_order_load == 1)
        {
            $rules['ec_order_load_number'] = 'required';
        }

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

            // Get sum
            $sum = 0;
            foreach ($get_cart['cart'] as $key => $value) 
            {
                array_push($invline_item_id, $value["product_id"]);
                array_push($invline_discount, $value["cart_product_information"]["product_discounted_value"]);
                array_push($invline_rate, $value["cart_product_information"]["product_price"]);
                array_push($invline_qty, $value["quantity"]);
                array_push($invline_discount_remark, "");
                array_push($invline_description, "");
                array_push($invline_service_date, date('Y-m-d H:i:s'));
                $add_sum = ($value["cart_product_information"]["product_price"]- $value["cart_product_information"]["product_discounted_value"]) * $value["quantity"];
                $sum += $add_sum;
            }
            
            // dd($add_sum);

            $cart['ec_order_load'] = Request::input('ec_order_load');
            if($ec_order_load == 1)
            {
                $cart['ec_order_load_number'] = Request::input('ec_order_load_number');
            }
            else
            {
                $cart['ec_order_load_number'] = null;
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
            $cart["order_status"] = "Pending"; // Processing
            $cart["shop_id"] = $this->shop_info->shop_id;
            // LUKE uwu desu
            if(isset(Self::$customer_info->customer_id))
            {
                $cart["customer_id"] = Self::$customer_info->customer_id;
            }
            else
            {
                $cart["customer_id"] = null;
            }
            
            
            if($cart["payment_method_id"] == 6)
            {
                if(Self::$slot_now != null)
                {
                    $check_wallet = $this->check_wallet(Self::$slot_now);
                    if($check_wallet >= $sum )
                    {
                        // return $check_wallet;
                        $log = 'Thank you for purchasing. ' .$sum. ' is deducted to your wallet';
                        $arry_log['wallet_log_slot'] = Self::$slot_now->slot_id;
                        $arry_log['shop_id'] = Self::$slot_now->shop_id;
                        $arry_log['wallet_log_slot_sponsor'] = Self::$slot_now->slot_id;
                        $arry_log['wallet_log_details'] = $log;
                        $arry_log['wallet_log_amount'] = $sum * (-1);
                        $arry_log['wallet_log_plan'] = "REPURCHASE";
                        $arry_log['wallet_log_status'] = "released";   
                        $arry_log['wallet_log_claimbale_on'] = Carbon::now(); 
                        

                        $cart["order_status"] = "Processing";
                    }
                    else
                    {
                        $send['errors'][0] = "Your wallet only have, " . number_format($check_wallet) . ' where the needed amount is ' . number_format($sum) ;
                        return Redirect::back()
                            ->withErrors($send)
                            ->withInput();
                    }
                    // dd($sum);
                }
                else
                {
                    $send['errors'][0] = "Only members with slot can use the wallet option.";
                    return Redirect::back()
                        ->withErrors($send)
                        ->withInput();
                }
            }

            $stock = Cart::check_product_stock($get_cart);
            if ($stock["status"] == "fail") 
            {
                return Redirect::back()->with('fail', $stock["error"]);
            }

            $result = Ec_order::create_ec_order_automatic($cart);
               if(isset($result['order_id']['status']))
               {
                        return Redirect::back()
                            ->withErrors($result['order_id']['status_message'])
                            ->withInput();
               }
            if($cart["payment_method_id"] == 6)
            {
                if(Self::$slot_now != null)
                {
                    if(isset($result['order_id']))
                    {
                        Mlm_slot_log::slot_array($arry_log);
                        $this->give_product_code($get_cart['cart'], Self::$slot_now, $result['order_id']);
                    }
                }
            }

            Cart::clear_all($this->shop_info->shop_id);
            
            return Redirect::to("/order_placed");
        }
    }
    public function give_product_code($cart, $slot_info, $order_id)
    {
        // $ec_order = Tbl_ec_order::
        $shop_id = $slot_info->shop_id;
        foreach($cart as $key => $value)
        {
            /* FOR ACTIVATION KEY */
            $condition = false;
            while($condition == false)
            {
               $activation_code  = Item_code::random_code_generator(8);
               $check_activation = Tbl_item_code::where("item_activation_code",$activation_code)->first();
               $code_pin         = Tbl_item_code::where("item_code_pin",$shop_id)->count() + 1;
               if(!$check_activation)
               {
                   $condition = true;
               }
            }
            $rel_insert[$key]["item_activation_code"]          = $activation_code;
            $rel_insert[$key]["customer_id"]                   = $slot_info->slot_owner;
            $rel_insert[$key]["item_id"]                       = $value['cart_product_information']['item_id'];
            $rel_insert[$key]["shop_id"]                       = $slot_info->shop_id;
            $rel_insert[$key]["item_code_pin"]                 = $code_pin;
            $rel_insert[$key]["item_code_price"]               = $value['cart_product_information']['product_price'];
            $rel_insert[$key]["item_code_price_total"]         = $value['cart_product_information']['product_current_price'];
            $rel_insert[$key]["ec_order_id"] = $order_id;
            $rel_insert[$key]["slot_id"] = $slot_info->slot_id;
        }

        Tbl_item_code::insert($rel_insert);
                        
        $items = Tbl_item_code::where('ec_order_id', $order_id)->get();
        foreach($items as $key => $value)
        {
            $insert_item_per[$value->item_id]['item_id'] =  $value->item_id;
            $item = Tbl_item::where('item_id', $value->item_id)->first();
            if($item)
            {
                $insert_item_per[$value->item_id]['item_name'] = $item->item_name;
                $insert_item_per[$value->item_id]['item_price'] = $item->item_price;  
                $insert_item_per[$value->item_id]['item_code_id'] = $value->item_code_id;
                if(isset($insert_item_per[$value->item_id]['item_quantity']))
                {
                    $insert_item_per[$value->item_id]['item_quantity'] += 1;
                }
                else
                {
                    $insert_item_per[$value->item_id]['item_quantity'] = 1;
                }
            }
        }
        Tbl_item_code_item::insert($insert_item_per);

        Item_code::use_item_code_all_ec_order($order_id);

    }
    public function check_wallet($slot_now)
    {
        $slot_id = $slot_now->slot_id;
        $sum_wallet = Mlm_slot_log::get_sum_wallet($slot_id);
        return $sum_wallet;
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