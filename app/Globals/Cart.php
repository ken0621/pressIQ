<?php
namespace App\Globals;
use App\Models\Tbl_customer;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use App\Models\Tbl_item;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_cart;
use App\Models\Tbl_coupon_code;
use App\Models\Tbl_user;
use App\Models\Tbl_ec_variant;
use App\Models\Tbl_ec_order;
use App\Models\Tbl_ec_order_item;
use App\Globals\Ecom_Product;
use DB;
use Session;
use Carbon\Carbon;
use App\Globals\Mlm_discount;
use App\Globals\Mlm_member;
use App\Models\Tbl_mlm_item_points;
use App\Globals\Mlm_plan;
use Crypt;

class Cart
{
    public static function get_unique_id($shop_id)
    {
        return "cart:".$_SERVER["REMOTE_ADDR"]."_".$shop_id;
    }
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
        
        $unique_id = Cart::get_unique_id($shop_id);
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
        $unique_id             = Cart::get_unique_id($shop_id);
        $data                  = Session::get($unique_id);
        $customer_setings      = Cart::customer_get_settings($shop_id);

        $total_product_price   = 0;
        $total_shipping        = 0;
        $total_coupon_discount = 0;
        $total_overall_price   = 0;
        $total_quantity        = 0;

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

        if(isset($data["cart"]))
        {     
            /* SET UP CART INFORMATION */
            foreach($data["cart"] as $key => $info)
            {
                $item_discount          = "no_discount";
                $item_discounted_value  = 0;
                $item_discounted_remark = "";

                $item = Ecom_Product::getVariantInfo($info["product_id"]);
                // dd($item);
                $data["cart"][$key]["cart_product_information"]                                   = null;
                $data["cart"][$key]["cart_product_information"]["variant_id"]                     = $item->evariant_id;
                $data["cart"][$key]["cart_product_information"]["item_id"]                        = $item->item_id;
                $data["cart"][$key]["cart_product_information"]["product_name"]                   = $item->eprod_name;
                $data["cart"][$key]["cart_product_information"]["variant_name"]                   = $item->evariant_item_label;
                $data["cart"][$key]["cart_product_information"]["product_stocks"]                 = $item->inventory_count;
                $data["cart"][$key]["cart_product_information"]["product_sku"]                    = $item->item_sku;
                $data["cart"][$key]["cart_product_information"]["product_price"]                  = $item->evariant_price;
                $data["cart"][$key]["cart_product_information"]["image_path"]                     = $item->image_path;
                $data["cart"][$key]["cart_product_information"]["item_category_id"]               = $item->item_category_id;
                /* CHECK IF DISCOUNT EXISTS */
                $check_discount = Tbl_item_discount::where("discount_item_id",$item->item_id)->first();
                if($check_discount)
                {
                    if(strtotime($check_discount->item_discount_date_start) <= strtotime($date_now) && strtotime($check_discount->item_discount_date_end) >= strtotime($date_now))
                    {

                        $current_price = $check_discount->item_discount_value;
                        // if($check_discount->item_discount_type == "fixed")
                        // {
                        //     $item_discounted       = "fixed";
                        //     $item_discounted_value = $check_discount->item_discount_value;
                        // }
                        // else if($check_discount->item_discount_type == "percentage")
                        // {
                        //     $item_discounted       = "percentage";
                        //     $item_discounted_value = $item->item_price * ($check_discount->item_discount_value);
                        // }
                        $item_discounted_remark    = $check_discount->item_discount_remark;
                    }
                }
                if(Session::get('mlm_member') != null)
                {
                    $session = Session::get('mlm_member');
                    if($session['slot_now'])
                    {
                        $discount_membership = Mlm_discount::get_discount_single($session['slot_now']->shop_id, $item->item_id, $session['slot_now']->slot_membership);
                        if(isset($current_price))
                        {
                             $discount_a = $current_price;
                        }
                       else
                       {
                            $discount_a = $item->item_price;
                       }
                        if($discount_membership['type'] == 0)
                        {
                            $item_discounted_value = $discount_membership['value']; 
                        }
                        else
                        {
                            $item_discounted_value =   $discount_a *   ($discount_membership['value']/100); 
                        }
                        $active_plan_product_repurchase = Mlm_plan::get_all_active_plan_repurchase($session['slot_now']->shop_id);
                        $item_points = Tbl_mlm_item_points::where('item_id', $item->item_id)->where('membership_id', $session['slot_now']->slot_membership)
                        ->first();
                        if($item_points)
                        {
                           foreach($active_plan_product_repurchase as $key2 => $value2)
                            {
                                $code = $value2->marketing_plan_code;
                                if($code == 'DISCOUNT_CARD_REPURCHASE' || $code == 'UNILEVEL_REPURCHASE_POINTS' || $code == 'UNILEVEL')
                                {
                                    
                                    
                                }
                                else
                                {
                                    // dd($code);
                                    $data["cart"][$key]["cart_product_information"]["membership_points"][$value2->marketing_plan_label] = $item_points->$code * $info['quantity'];
                                }
                            } 
                        }
                    }
                }
                //u s 2  q n a  m a m a t a y i h h h h
                $current_price                                                                    = $item->evariant_price - $item_discounted_value;
                $data["cart"][$key]["cart_product_information"]["product_discounted"]             = isset($item_discounted) ? $item_discounted : null;
                $data["cart"][$key]["cart_product_information"]["product_discounted_value"]       = isset($item_discounted_value) ? $item_discounted_value : null;
                $data["cart"][$key]["cart_product_information"]["product_discounted_remark"]      = isset($item_discounted_remark) ? $item_discounted_remark : null;
                $data["cart"][$key]["cart_product_information"]["product_current_price"]          = $current_price;

                $total_product_price = $total_product_price + ($current_price * $info['quantity']);
                $total_quantity += $info['quantity'];
            }
        }        

        /* SET OTHER PRICE INFO  */
        $data["sale_information"]                                      = null;
        $data["sale_information"]["total_product_price"]               = $total_product_price;  
        $data["sale_information"]["total_shipping"]                    = $total_shipping;
        $data["sale_information"]["total_quantity"]                    = $total_quantity;
        $data["sale_information"]["minimum_purchase"]                  = 500;

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

    public static function update_cart($variant_id, $quantity, $shop_id = null)
    {
        //get_shop_info
        if (!$shop_id) 
        {
            $shop_info = Cart::get_shop_info();
            $shop_id = $shop_info->shop_id;
        }

        $unique_id               = Cart::get_unique_id($shop_id);
        $insert                  = Session::get($unique_id);
        foreach ($insert['cart'] as $key => $value) 
        {
            if($value['product_id'] == $variant_id)
            {
                $insert['cart'][$key]["quantity"] = $quantity;
            }
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

        $unique_id  =  Cart::get_unique_id($shop_id);
        $_cart      = Session::get($unique_id);
        $condition  = false;

        if($_cart)
        {
            foreach($_cart["cart"] as $key => $cart)
            {
                if($cart["product_id"] == $product_id)
                {
                    $condition = true;

                    Tbl_cart::where("date_added",$cart["date_added"])
                            ->where("shop_id",$cart['shop_id'])
                            ->where("product_id",$cart['product_id'])
                            ->where("unique_id_per_pc",$cart['unique_id_per_pc'])
                            ->delete();

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
                 Session::put($unique_id,$_cart);

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

        $unique_id =  Cart::get_unique_id($shop_id);
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

        $unique_id =  Cart::get_unique_id($shop_id);
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

        $unique_id = Cart::get_unique_id($shop_id);
        $data      = Session::get($unique_id);
        if(!$data)
        {
            Cart::customer_settings($shop_id);
        }

        return $data;
    }

    public static function generate_coupon_code($word_limit, $price, $minimum_quantity = 0, $type="fixed", $coupon_product_id = null)
    {
        //get_shop_info
        $shop_id = Cart::get_shop_info();

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
            $insert["coupon_product_id"]       =  isset($coupon_product_id) ? $coupon_product_id : null;              
            $insert["coupon_code_amount"]      =  $price;                     
            $insert["coupon_discounted"]       =  $type;                     
            $insert["shop_id"]                 =  $shop_id;
            $insert["coupon_minimum_quantity"] =  $minimum_quantity;         
            $insert["date_created"]            =  Carbon::now();  
            Tbl_coupon_code::insert($insert);

            $message["status"]         = "success";
            $message["status_message"] = "Successfully generate a coupon code.";
        }  

        return $message;                              
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
                $unique_id                  = Cart::get_unique_id($shop_id);
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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $word_limit; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function check_product_stock($cart)
    {
        $message["status"] = "success";
        
        foreach ($cart["cart"] as $key => $value) 
        {
            $item = Ecom_Product::getVariantInfo($value["product_id"]);
            
            if ($item["item_type_id"] != 2) 
            {
                if ($value["quantity"] > $item->inventory_count) 
                {
                    $message["status"]       = "fail";
                    $message["error"][$key]  = $item->eprod_name . " exceeds the current stock (" . $item->inventory_count . ")";
                }
            }
            
        }
        
        return $message;
    }


    /* return content of SESSION */
    public static function get_info($shop_id)
    {
        $data = Session::get(Cart::get_unique_id($shop_id));
        return $data;
    }



    /*
     * TITLE: CUSTOMER SET INFO
     * 
     * Allows us to set information for customer that will be processed later on
     *
     * @param
     *    $shop_id (int)
     *    $customer_information (array)
     *      - first_name
     *      - last_name, email, password, shipping_state, shipping_city, shipping_zip, shipping_street) 
     *      - email
     *      - password
     *      - shipping_state
     *      - shipping_city
     *      - shipping_zip
     *      - shipping_street
     *    $customer_validation (array) - If on of the string is in this array - It will trigger a validation.
     *      - check_account
     *      - check_name
     *      - check_address
     *      - check_contact
     *
     * @return (array)
     *    - status (error, success)
     *    - status_message (contains message if there is an error)
     *
     * @author (Guillermo Tabligan)
     *
     */
    public static function customer_set_info($shop_id, $customer_information, $validation = array())
    {
        $unique_id = Cart::get_unique_id($shop_id);
        
        /* GET INITIAL CART DATA */
        $data = Cart::get_info($shop_id);

        /* READY INFORMATION FOR SESSION */
        $data["new_account"] = (isset($customer_information["new_account"]) ? $customer_information["new_account"] : (isset($data["new_account"]) ? $data["new_account"] : null));;
        $data["billing_equals_shipping"] = (isset($customer_information["billing_equals_shipping"]) ? $customer_information["billing_equals_shipping"] : (isset($data["billing_equals_shipping"]) ? $data["billing_equals_shipping"] : true));;

        /* SET BASIC INFORMATION */
        $data["tbl_customer"]['customer_id']    = Tbl_customer::max("customer_id") + 1;
        $data["tbl_customer"]['first_name']     = (isset($customer_information["first_name"]) ? $customer_information["first_name"] : (isset($data["tbl_customer"]['first_name']) ? $data["tbl_customer"]['first_name'] : null));
        $data["tbl_customer"]['last_name']      = (isset($customer_information["last_name"]) ? $customer_information["last_name"] : (isset($data["tbl_customer"]['last_name']) ? $data["tbl_customer"]['last_name'] : null));
        $data["tbl_customer"]['middle_name']    = (isset($customer_information["middle_name"]) ? $customer_information["middle_name"] : (isset($data["tbl_customer"]['middle_name']) ? $data["tbl_customer"]['middle_name'] : null));
        $data["tbl_customer"]['email']          = (isset($customer_information["email"]) ? $customer_information["email"] : (isset($data["tbl_customer"]['email']) ? $data["tbl_customer"]['email'] : null));
        $data["tbl_customer"]['password']       = isset($customer_information["password"]) ? $customer_information["password"] : randomPassword();
        $data["tbl_customer"]['shop_id']        = $shop_id;
        $data["tbl_customer"]['country_id']     = 420;

        /* SET SHIPPINGING INFROMATION */
        $data["tbl_customer_address"]["shipping"]["country_id"] = 420;
        $data["tbl_customer_address"]["shipping"]["customer_state"] = (isset($customer_information["shipping_state"]) ? $customer_information["shipping_state"] : (isset($data["tbl_customer_address"]["shipping"]["customer_state"]) ? $data["tbl_customer_address"]["shipping"]["customer_state"] : null));
        $data["tbl_customer_address"]["shipping"]["customer_city"] = (isset($customer_information["shipping_city"]) ? $customer_information["shipping_city"] : (isset($data["tbl_customer_address"]["shipping"]["customer_city"]) ? $data["tbl_customer_address"]["shipping"]["customer_city"] : null));;
        $data["tbl_customer_address"]["shipping"]["customer_zip_code"] = (isset($customer_information["shipping_zip"]) ? $customer_information["shipping_zip"] : (isset($data["tbl_customer_address"]["shipping"]["customer_zip_code"]) ? $data["tbl_customer_address"]["shipping"]["customer_zip_code"] : null));;
        $data["tbl_customer_address"]["shipping"]["customer_street"] = (isset($customer_information["shipping_street"]) ? $customer_information["shipping_street"] : (isset($data["tbl_customer_address"]["shipping"]["customer_street"]) ? $data["tbl_customer_address"]["shipping"]["customer_street"] : null));;
        $data["tbl_customer_address"]["shipping"]["purpose"] = "shipping";
        
        /* SET  BILLING INFORMATION */
        if($data["billing_equals_shipping"] == true)
        {
            $data["tbl_customer_address"]["billing"]["country_id"] = 420;
            $data["tbl_customer_address"]["billing"]["customer_state"] = $data["tbl_customer_address"]["shipping"]["customer_state"];
            $data["tbl_customer_address"]["billing"]["customer_city"] = $data["tbl_customer_address"]["shipping"]["customer_city"];
            $data["tbl_customer_address"]["billing"]["customer_zip_code"] = $data["tbl_customer_address"]["shipping"]["customer_zip_code"];
            $data["tbl_customer_address"]["billing"]["customer_street"] = $data["tbl_customer_address"]["shipping"]["customer_street"];
            $data["tbl_customer_address"]["billing"]["purpose"] = "billing"; 
        }

        $data = Cart::customer_set_info_ec_order($shop_id, $data, $customer_information);

        /* VALIDATIONS */
        $check_account = Cart::customer_set_info_check_account($shop_id, $data["new_account"], $data["tbl_customer"]['email'], $data["tbl_customer"]["password"]);
        $check_name = "success";
        $check_address = "success";
        $check_contact = "success";

        /* VALIDATIONS RETURN MESSAGE */
        if((in_array("check_account", $validation)) && $check_account != "success")
        {
            $message["status"] = "error";
            $message["status_message"] = $check_account;
        }
        elseif((in_array("check_name", $validation)) && $check_name != "success")
        {
            $message["status"] = "error";
            $message["status_message"] = $check_account;
        }
        else
        {
            Session::put($unique_id, $data);
            $message["status"]         = "success";
            $message["status_message"] = "Customer Information Successfully Updated"; 
        }

        return $message;
    }

    public static function customer_set_info_ec_order($shop_id, $data, $customer_information)
    { 
        $data["tbl_ec_order"]["ec_order_id"] = Tbl_ec_order::max("ec_order_id") + 1;

        /* PAYMENT METHOD ID */
        $payment_method_id = (isset($customer_information["method_id"]) ? $customer_information["method_id"] : (isset($data["method_id"]) ? $data["method_id"] : null));;

        /* COMPUTE SERICE FEE */
        if($payment_method_id != null)
        {
            $service_fee = 15;
        }
        else
        {
            $service_fee = 0;
        }

        /* INITIALIZE TOTALS */
        $subtotal = 0;
        $shipping_fee = 0;

        $_cart = Self::get_cart($shop_id)["cart"];

        /* ITEM ON CART */
        foreach($_cart as $key => $cart)
        {
            $data["tbl_ec_order_item"][$key]["item_id"] = $cart["cart_product_information"]["item_id"];
            $data["tbl_ec_order_item"][$key]["price"] = $cart["cart_product_information"]["product_price"];
            $data["tbl_ec_order_item"][$key]["quantity"] = $cart["quantity"];
            $data["tbl_ec_order_item"][$key]["subtotal"] = $cart["cart_product_information"]["product_price"] * $cart["quantity"];
            $data["tbl_ec_order_item"][$key]["total"] = $cart["cart_product_information"]["product_price"] * $cart["quantity"];
            $data["tbl_ec_order_item"][$key]["tax"] = 0;
            $data["tbl_ec_order_item"][$key]["ec_order_id"] = $data["tbl_ec_order"]["ec_order_id"];

            $subtotal += $data["tbl_ec_order_item"][$key]["total"];
        }

        $total = $subtotal + ($shipping_fee + $service_fee);

        /* SUMMARY OF DATA FOR ORDER */
        $data["tbl_ec_order"]["customer_id"] = $data["tbl_customer"]["customer_id"];
        $data["tbl_ec_order"]["customer_email"] = $data["tbl_customer"]["email"];
        $data["tbl_ec_order"]["billing_address"] = $data["tbl_customer_address"]["shipping"]["customer_street"] . ", " . $data["tbl_customer_address"]["shipping"]["customer_zip_code"] . ", " . $data["tbl_customer_address"]["shipping"]["customer_city"] . ", " . $data["tbl_customer_address"]["shipping"]["customer_state"];
        $data["tbl_ec_order"]["discount_coupon_amount"] = null;
        $data["tbl_ec_order"]["discount_coupon_type"] = null;
        $data["tbl_ec_order"]["subtotal"] = $subtotal;
        $data["tbl_ec_order"]["shipping_fee"] = $shipping_fee;
        $data["tbl_ec_order"]["service_fee"] = $service_fee;
        $data["tbl_ec_order"]["total"] = $total;
        $data["tbl_ec_order"]["coupon_id"] = null;
        $data["tbl_ec_order"]["shop_id"] = $shop_id;
        $data["tbl_ec_order"]["created_date"] = Carbon::now();
        $data["tbl_ec_order"]["payment_method_id"] = $payment_method_id;
        $data["tbl_ec_order"]["shipping_group"] = null;
        $data["tbl_ec_order"]["order_status"] = "Pending";
        $data["tbl_ec_order"]["payment_status"] = 0;
        

        return $data;
    }
    public static function customer_set_info_check_account($shop_id, $new_account, $email, $password)
    {
        if($new_account == true) //NEW ACCOUNT VALIDATION
        {
            $check_exist = Tbl_customer::where("shop_id", $shop_id)->where("email", $email)->first();

            if($check_exist)
            {
                return "You cannot use <b>" . $email . "</b> because this belongs to one of the existing users. If you are the owner of this account then continue with password.";
            }
            else
            {
                return "success";
            }
        }
        else //ACCOUNT EXIST VALIDATION
        {
            $check_exist = Tbl_customer::where("shop_id", $shop_id)->where("email", $email)->first();

            if(!$check_exist)
            {
                return "The e-mail and password you entered doesn't belong to any account.";
            }
            elseif(Crypt::decrypt($check_exist["password"]) != $password)
            {
                return "The e-mail and password you entered doesn't belong to any account.";
            }
            else
            {
                Mlm_member::add_to_session($shop_id, $check_exist->customer_id);
                return "success";
            }
        }
    }

    public static function get_userip()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }
}