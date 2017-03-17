<?php
namespace App\Globals;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use App\Models\Tbl_item;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_cart;
use App\Models\Tbl_coupon_code;
use App\Models\Tbl_user;
use App\Models\Tbl_ec_variant;
use App\Globals\Ecom_Product;
use DB;
use Session;
use Carbon\Carbon;

class Cart
{
    public static function get_shop_info()
    {
        $shop_info = Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');

        return $shop_info;
    }
    public static function add_to_cart($product_id,$quantity,$shop_id = null)
    {
        //get_shop_info
        if (!$shop_id) 
        {
            $shop_id = Cart::get_shop_info();
        }
        
        $unique_id = "cart:".$_SERVER["REMOTE_ADDR"]."_".$shop_id;
        $check     = Tbl_ec_variant::where("evariant_id",$product_id)->first();
        if(number_format($quantity) <= 0)
        {
            $message["status"]         = "error";
            $message["status_message"] = "Value is not available.";
        }
        else if(!$check)
        {
            $message["status"]         = "error";
            $message["status_message"] = "Product not found.";
        }
        else
        {
            $_cart                                            = Session::get($unique_id);
            $insert["cart"][$product_id]["product_id"]        = $product_id;
            $insert["cart"][$product_id]["quantity"]          = $quantity;
            $insert["cart"][$product_id]["shop_id"]           = $shop_id;
            $insert["cart"][$product_id]["unique_id_per_pc"]  = $unique_id;
            $insert["cart"][$product_id]["date_added"]        = Carbon::now();
            if($_cart && isset($_cart["cart"]))
            {
                $condition = false;

                foreach($_cart["cart"] as $key => $cart)
                {
                    if($key == $product_id)
                    {
                        $_cart["cart"][$key]["quantity"] = $_cart["cart"][$key]["quantity"] + $quantity;
                        $condition = true;

                        Tbl_cart::where("date_added",$_cart["cart"][$key]["date_added"])
                                ->where("shop_id",$shop_id)
                                ->where("product_id",$product_id)
                                ->where("unique_id_per_pc",$unique_id)
                                ->update($_cart["cart"][$key]);
                    }
                }

                if($condition == false)
                {
                    $_cart["cart"][$product_id] = $insert["cart"][$product_id];
                    Tbl_cart::insert($insert["cart"][$product_id]);
                    Session::put($unique_id,$_cart);
                }
                else
                {
                    $insert = $_cart;
                    Session::put($unique_id,$insert);                  
                }

                $message["status"]         = "success";
                $message["status_message"] = "Added to cart.";
            }
            else
            {
                Tbl_cart::insert($insert["cart"][$product_id]);
                Session::put($unique_id,$insert);
                $message["status"]         = "success";
                $message["status_message"] = "Added to cart.";
            }
        }
        return $message;
    }

    public static function get_cart($shop_id = null)
    {
        //get_shop_info
        if (!$shop_id) 
        {
            $shop_info = Cart::get_shop_info();
            $shop_id = $shop_info->shop_id;
        }

        /* INITIALIZE */
        $date_now              = Carbon::now();
        $unique_id             = "cart:".$_SERVER["REMOTE_ADDR"]."_".$shop_id;
        $data                  = Session::get($unique_id);
        $customer_setings      = Cart::customer_get_settings($shop_id);

        $total_product_price   = 0;
        $total_shipping        = 0;
        $total_coupon_discount = 0;
        $total_overall_price   = 0;

        /* CHECK IF COUPON ALREADY USED */
        if(isset($data["applied_coupon_id"]))
        {
            $coupon_code_id = $data["applied_coupon_id"];

            $check          = Tbl_coupon_code::where("coupon_code_id",$coupon_code_id)->where("shop_id",$shop_id)->first();
            if($check->used == 1 || $check->blocked == 1)
            {
                $data       = Session::get($unique_id);
                unset($data["applied_coupon_id"]);
                Session::put($unique_id,$data);
                $data       = Session::get($unique_id);
            }
        }

        /* GET CUSTOMER SETTINGS*/
        $data["customer_information"] = $customer_setings["customer_information"];         
        $data["shipping_information"] = $customer_setings["customer_shipping_address"];         
        $data["billing_information"]  = $customer_setings["customer_billing_address"]; 
        if(isset($data["cart"]))
        {     
            /* SET UP CART INFORMATION */
            foreach($data["cart"] as $key => $info)
            {
                $item_discount          = "no_discount";
                $item_discounted_value  = 0;
                $item_discounted_remark = "";

                $item = Ecom_Product::getVariantInfo($info["product_id"]);
                $data["cart"][$key]["cart_product_information"]                                   = null;
                $data["cart"][$key]["cart_product_information"]["variant_id"]                     = $item->evariant_id;
                $data["cart"][$key]["cart_product_information"]["product_name"]                   = $item->eprod_name;
                $data["cart"][$key]["cart_product_information"]["variant_name"]                   = $item->evariant_item_label;
                $data["cart"][$key]["cart_product_information"]["product_stocks"]                 = $item->inventory_count;
                $data["cart"][$key]["cart_product_information"]["product_sku"]                    = $item->item_sku;
                $data["cart"][$key]["cart_product_information"]["product_price"]                  = $item->evariant_price;
                $data["cart"][$key]["cart_product_information"]["image_path"]                     = $item->image_path;

                /* CHECK IF DISCOUNT EXISTS */
                $check_discount = Tbl_item_discount::where("discount_item_id",$item->item_id)->first();
                if($check_discount)
                {
                    if(strtotime($check_discount->item_discount_date_start) <= strtotime($date_now) && strtotime($check_discount->item_discount_date_end) >= strtotime($date_now))
                    {
                        if($check_discount->item_discount_type == "fixed")
                        {
                            $item_discounted       = "fixed";
                            $item_discounted_value = $check_discount->item_discount_value;
                        }
                        else if($check_discount->item_discount_type == "percentage")
                        {
                            $item_discounted       = "percentage";
                            $item_discounted_value = $item->item_price * ($check_discount->item_discount_value);
                        }

                        $item_discounted_remark    = $check_discount->item_discount_remark;
                    }
                }

                $current_price                                                                    = $item->item_price - isset($item_discounted_value) ? $item_discounted_value : 0;
                $data["cart"][$key]["cart_product_information"]["product_discounted"]             = isset($item_discounted) ? $item_discounted : null;
                $data["cart"][$key]["cart_product_information"]["product_discounted_value"]       = isset($item_discounted_value) ? $item_discounted_value : null;
                $data["cart"][$key]["cart_product_information"]["product_discounted_remark"]      = isset($item_discounted_remark) ? $item_discounted_remark : null;
                $data["cart"][$key]["cart_product_information"]["product_current_price"]          = $current_price;

                $total_product_price = $total_product_price + $current_price;
            }
        }        

        /* SET OTHER PRICE INFO  */
        $data["sale_information"]                                      = null;
        $data["sale_information"]["total_product_price"]               = $total_product_price;  
        $data["sale_information"]["total_shipping"]                    = $total_shipping;
        

        /* APPLY COUPON DISCOUNT */
        if(isset($data["applied_coupon_id"]))
        {
            $coupon_code_id = $data["applied_coupon_id"];
            $check          = Tbl_coupon_code::where("coupon_code_id",$coupon_code_id)->where("shop_id",$shop_id)->first();
            if($check)
            {
                if($check->coupon_discounted == "fixed")
                {
                    $total_coupon_discount = $check->coupon_code_amount;
                }
                else if($check->coupon_discounted == "percentage")
                {
                    $total_coupon_discount = $total_product_price - ($total_product_price * ($item->coupon_code_amount/100));
                }             
            }
        }

        /* CHECK IF TOTAL PRICE IS NEGATIVE */
        $total_overall_price                                                = $total_product_price + $total_shipping - $total_coupon_discount;
        if($total_overall_price < 0)
        {
            $total_overall_price = 0;
        }

        /* SET OTHER PRICE INFO  */
        $data["sale_information"]["total_coupon_discount"]             = $total_coupon_discount; 
        $data["sale_information"]["total_overall_price"]               = $total_overall_price; 

        return $data;
    }

    public static function update_cart($quantity, $shop_id = null)
    {
        //get_shop_info
        if (!$shop_id) 
        {
            $shop_info = Cart::get_shop_info();
            $shop_id = $shop_info->shop_id;
        }

        $unique_id               = "cart:".$_SERVER["REMOTE_ADDR"]."_".$shop_id;
        $insert                  = Session::get($unique_id);
        foreach ($insert['cart'] as $key => $value) 
        {
            $insert['cart'][$key]["quantity"] = $quantity;
        }
       
        Session::put($unique_id,$insert);

        $message["status"]         = "success";
        $message["status_message"] = "Cart updated.";

        return $message;
    }

    public static function delete_product($product_id, $shop_id = null)
    {
        //get_shop_info
        if (!$shop_id) 
        {
            $shop_info = Cart::get_shop_info();
            $shop_id = $shop_info->shop_id;
        }

        $unique_id  = "cart:".$_SERVER["REMOTE_ADDR"]."_".$shop_id;
        $_cart      = Session::get($unique_id);
        $condition  = false;

        if($_cart)
        {
            foreach($_cart["cart"] as $key => $cart)
            {
                if($key == $product_id)
                {
                    $condition = true;

                    Tbl_cart::where("date_added",$_cart["cart"][$key]["date_added"])
                            ->where("shop_id",$_cart["cart"][$key]['shop_id'])
                            ->where("product_id",$_cart["cart"][$key]['product_id'])
                            ->where("unique_id_per_pc",$_cart["cart"][$key]['unique_id_per_pc'])
                            ->delete($_cart["cart"][$key]);

                    unset($_cart["cart"][$key]);
                }
            }

            if($condition == false)
            {
                 $message["status"]         = "error";
                 $message["status_message"] = "Product doesn't exists.";
            }
            else
            {
                 Session::put($unique_id,$_cart["cart"]);
                 $message["status"]         = "success";
                 $message["status_message"] = "Successfully removed.";
            }
        }  
        else
        {
             $message["status"]         = "error";
             $message["status_message"] = "Product doesn't exists.";
        }
        
        return $message;
    }

    public static function clear_all($shop_id = null)
    {
        //get_shop_info
        if (!$shop_id) 
        {
            $shop_info = Cart::get_shop_info();
            $shop_id = $shop_info->shop_id;
        }

        $unique_id = "cart:".$_SERVER["REMOTE_ADDR"]."_".$shop_id;
        $_cart     = Session::get($unique_id);

        if(isset($_cart["cart"]))
        {

            foreach($_cart["cart"] as $key => $cart)
            {
                    Tbl_cart::where("date_added",$_cart["cart"][$key]["date_added"])
                            ->where("shop_id",$_cart["cart"][$key]['shop_id'])
                            ->where("product_id",$_cart["cart"][$key]['product_id'])
                            ->where("unique_id_per_pc",$_cart["cart"][$key]['unique_id_per_pc'])
                            ->delete($_cart["cart"][$key]);
            }
            Session::forget($unique_id);

            $message["status"]         = "success";
            $message["status_message"] = "Cleared all product.";
        }
        else
        {
            $message["status"]         = "error";
            $message["status_message"] = "Nothing to clear.";
        }

        return $message;
    }

    public static function customer_settings($shop_id = null,$customer_id = null,$customer_information = null,$customer_shipping_address = null,$customer_billing_address = null,$customer_payment_method = null,$customer_payment_proof = null)
    {
        //get_shop_info
        if (!$shop_id) 
        {
            $shop_info = Cart::get_shop_info();
            $shop_id = $shop_info->shop_id;
        }

        $unique_id = "customer_settings:".$_SERVER["REMOTE_ADDR"]."_".$shop_id;
        if($customer_id && $customer_id != 0)
        {
            $data["customer_id"] = $customer_id;
        }
        else
        {
            $data["customer_id"] = null;
        }

        if($customer_information)
        {
            $data["customer_information"]['first_name']    = $customer_information["first_name"];
            $data["customer_information"]['middle_name']   = $customer_information["middle_name"];
            $data["customer_information"]['last_name']     = $customer_information["last_name"];
            $data["customer_information"]['email']         = $customer_information["email"];
            $data["customer_information"]['company']       = $customer_information["company"];
            $data["customer_information"]['birthday']      = $customer_information["birthday"];
        }
        else
        {
            $data["customer_information"]['first_name']    = null;
            $data["customer_information"]['middle_name']   = null;
            $data["customer_information"]['last_name']     = null;
            $data["customer_information"]['email']         = null;
            $data["customer_information"]['company']       = null;
            $data["customer_information"]['birthday']      = null;            
        }

        if($customer_shipping_address)
        {
            $data["customer_shipping_address"]['state']    = $customer_shipping_address["state"];
            $data["customer_shipping_address"]['city']     = $customer_shipping_address["city"];
            $data["customer_shipping_address"]['zip']      = $customer_shipping_address["zip"];
            $data["customer_shipping_address"]['street']   = $customer_shipping_address["street"];
            $data["customer_shipping_address"]['address']  = $customer_shipping_address["address"];
        }
        else
        {
            $data["customer_shipping_address"]['state']    = null;
            $data["customer_shipping_address"]['city']     = null;
            $data["customer_shipping_address"]['zip']      = null;
            $data["customer_shipping_address"]['street']   = null;
            $data["customer_shipping_address"]['address']  = null;
        }

        if($customer_billing_address)
        {
            $data["customer_billing_address"]['state']     = $customer_billing_address["state"];
            $data["customer_billing_address"]['city']      = $customer_billing_address["city"];
            $data["customer_billing_address"]['zip']       = $customer_billing_address["zip"];
            $data["customer_billing_address"]['street']    = $customer_billing_address["street"];
            $data["customer_billing_address"]['address']   = $customer_billing_address["address"];
        }
        else
        {
            $data["customer_billing_address"]['state']     = null;
            $data["customer_billing_address"]['city']      = null;
            $data["customer_billing_address"]['zip']       = null;
            $data["customer_billing_address"]['street']    = null;
            $data["customer_billing_address"]['address']   = null;
        }

        if($customer_payment_method)
        {
            $data["customer_payment_method"] = $customer_payment_method;
        }
        else
        {
            $data["customer_payment_method"] = null;
        }

        if($customer_payment_proof)
        {
            $data["customer_payment_proof"]  = null;
        }
        else
        {
            $data["customer_payment_proof"]  = null;
        }


        Session::put($unique_id,$data);
        $message["status"]         = "success";
        $message["status_message"] = "Settings update.";

        return $message;
    }

    public static function customer_get_settings($shop_id = null)
    {
        //get_shop_info
        if (!$shop_id) 
        {
            $shop_info = Cart::get_shop_info();
            $shop_id = $shop_info->shop_id;
        }

        $unique_id = "customer_settings:".$_SERVER["REMOTE_ADDR"]."_".$shop_id;
        $data      = Session::get($unique_id);
        if(!$data)
        {
            Cart::customer_settings($shop_id);
        }

        return $data;
    }

    public static function generate_coupon_code($word_limit,$price,$type="fixed")
    {
        //get_shop_info
        $shop_info = Cart::get_shop_info();
        $shop_id = $shop_info->shop_id;

        if($type != "fixed" && $type != "percentage")
        {
            $message["status"]         = "error";
            $message["status_message"] = "Invalid type.";
        }
        else if($price <= 0)
        {
            $message["status"]         = "error";
            $message["status_message"] = "Invalid price.";
        }   
        else
        {
            $condition                = false;
            $generated_word           = Cart::random_code_generator($word_limit);
            while($condition == false)
            {
                $check                = Tbl_coupon_code::where("coupon_code",$generated_word)->where("shop_id",$shop_id)->first();
                if(!$check)
                {
                    $condition = true;
                }
                else
                {
                    $generated_word   = Cart::random_code_generator($word_limit);
                }
            }

            $coupon   = Tbl_coupon_code::where("shop_id",$shop_id)->orderBy("id_per_coupon","DESC")->first();
            if($coupon)
            {
                $id_per_coupon = $coupon->id_per_coupon + 1;
            }
            else
            {
                $id_per_coupon = 1;
            }

            $insert["id_per_coupon"]           =  $id_per_coupon;                
            $insert["coupon_code"]             =  $generated_word;              
            $insert["coupon_code_amount"]      =  $price;                     
            $insert["coupon_discounted"]       =  $type;                     
            $insert["shop_id"]                 =  $shop_id;          
            $insert["date_created"]            =  Carbon::now();  
            Tbl_coupon_code::insert($insert);

            $message["status"]         = "success";
            $message["status_message"] = "Successfully generate a coupon code.";
        }                                
    }

    public static function use_coupon_code($coupon_code)
    {   
        //get_shop_info
        $shop_info = Cart::get_shop_info();
        $shop_id = $shop_info->shop_id;

        $check = Tbl_coupon_code::where("coupon_code",$coupon_code)->where("shop_id",$shop_id)->first();       
        if($check)
        {
            if($check->used == 1)
            {
                $message["status"]         = "error";
                $message["status_message"] = "This coupon code is already used";
            }
            else if($check->blocked == 1)
            {
                $message["status"]         = "error";
                $message["status_message"] = "This coupon code is blocked";
            }
            else
            {
                $unique_id                  = "cart:".$_SERVER["REMOTE_ADDR"]."_".$shop_id;
                $_cart                      = Session::get($unique_id);
                $_cart["applied_coupon_id"] = $check->coupon_code_id;
                Session::put($unique_id,$_cart); 


                $message["status"]          = "success";
                $message["status_message"]  = "Coupon code applied.";
            }
        }   
        else
        {
            $message["status"]         = "error";
            $message["status_message"] = "Coupon code does not exists.";
        }     
    }

    public static function random_code_generator($word_limit)
    {
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $word_limit; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}