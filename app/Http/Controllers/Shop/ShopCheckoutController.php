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

use App\Globals\Mlm_member;
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
use App\Models\Tbl_ec_order_item;
use App\Models\Tbl_merchant_school;
use App\Models\Tbl_locale;
use App\Models\Tbl_email_template;
use App\Globals\Mail_global;
// use App\Globals\Item_code;
// use App\Globals\Mlm_slot_log;    

/*4/29/17 this will import the data/class needed by ipay88 payment mode by:brain*/
use App\Models\Tbl_online_pymnt_api;

class ShopCheckoutController extends Shop
{
    /* Payment Facilities Response */
    public function ipay88_response()
    {
        $request = Request::all();
        $shop_id = $this->shop_info->shop_id;

        if ($request) 
        {
            // LOGS
            $ipay88_logs["log_merchant_code"] = $request['MerchantCode'];
            $ipay88_logs["log_payment_id"] = $request['PaymentId'];
            $ipay88_logs["log_reference_number"] = $request['RefNo'];
            $ipay88_logs["log_amount"] = $request['Amount'];
            $ipay88_logs["log_currency"] = $request['Currency'];
            $ipay88_logs["log_remarks"] = $request['Remark'];
            $ipay88_logs["log_trans_id"] = $request['TransId'];
            $ipay88_logs["log_auth_code"] = $request['AuthCode'];
            $ipay88_logs["log_status"] = $request['Status'];
            $ipay88_logs["log_error_desc"] = $request['ErrDesc'];
            $ipay88_logs["log_signature"] = $request['Signature'];
            $ipay88_logs["shop_id"] = $this->shop_info->shop_id;

            DB::table("tbl_ipay88_logs")->insert($ipay88_logs);

            if($request['Status'] == 0)
            {
                dd($request['ErrDesc'].'. '.'Please refer to ipay88 Appendix I - 3.0 Error Description.');
                // return redirect('/checkout')->withErrors($request['ErrDesc'].'. '.'Please refer to ipay88 Appendix I - 3.0 Error Description.')->send();    
            } 
            else 
            {
                $shop_id        = $this->shop_info->shop_id;
                $payment_status = 1;
                $order_status   = "Processing";

                $order_id = Cart::submit_order($shop_id, $payment_status, $order_status, Self::$customer_info ? Self::$customer_info->customer_id : null);
                Cart::clear_all($this->shop_info->shop_id);

                // Redirect
                return Redirect::to('/order_placed?order=' . Crypt::encrypt(serialize($order_id)))->send();
            }
        }
        else
        {
            return Redirect::to("/checkout")->with('fail', 'Session has been expired. Please try again.')->send();
        }
    }
    public function dragonpay_return()
    {
        if (Request::input("status") == "S") 
        {
            $from = Request::input('param1');
            if ($from == "checkout") 
            {
                $order_id = Request::input("param2");
                $order = DB::table('tbl_ec_order')->where('ec_order_id', $order_id)->first();

                if($order)
                {
                    return Redirect::to('/order_placed?order=' . Crypt::encrypt(serialize($order_id)));
                }
            }
            elseif ($from == "register")
            {
                return Redirect::to('/mlm/login?notify=1&success=1');
            }
        }
        else
        {
            return Redirect::to('/mlm/login?notify=3');
        }
    }
    public function dragonpay_postback()
    {
        $order_id = Request::input("param2");
        
        try 
        {
            $request = Request::all();
            
            // Insert Dragonpay Logs
            $insert["log_date"] = Carbon::now();
            $insert["response"] = serialize($request);
            $insert["order_id"] = $order_id;
            
            DB::table("tbl_dragonpay_logs_other")->insert($insert);
    
            if (Request::input("status") == "S") 
            {
                $from = Request::input('param1');
                $order = DB::table('tbl_ec_order')->where('ec_order_id', $order_id)->first();
    
                if($order)
                {
                    if ($from == "register")
                    {
                        $this->put_temporary($order_id);
                        Item_code::ec_order_slot($order_id);
                    }
                    
                    $update['ec_order_id'] = $order_id;
                    $update['order_status'] = "Processing";
                    $update['payment_status'] = 1;
                    $order = Ec_order::update_ec_order($update);
    
                    $this->after_email_payment($order_id);
                }
            }
        } 
        catch (\Exception $e) 
        {
            $insert["log_date"] = Carbon::now();
            $insert["response"] = serialize($e->getMessage());
            $insert["order_id"] = $order_id;
        } 
    }
    public function paymaya_success()
    {
        $order_id = Crypt::decrypt(Request::input("order_id"));
        $from = Request::input("from");
        $order = DB::table('tbl_ec_order')->where('ec_order_id', $order_id)->first();
        if($order)
        {
            if ($from == "checkout") 
            {
                return Redirect::to('/order_placed?order=' . Crypt::encrypt(serialize($order_id)));
            }
            elseif ($from == "register")
            {
                return Redirect::to('/mlm/login?notify=1');
            }
        }
    }
    public function paymaya_failure()
    {
        return Redirect::to('/mlm/login?notify=3');
    }
    public function paymaya_cancel()
    {
        return Redirect::to('/mlm/login?notify=4');
    }
    public function paymaya_webhook_success()
    {
        try 
        {
            $order_id = (int)Request::input("requestReferenceNumber");
            $order = DB::table('tbl_ec_order')->where('ec_order_id', $order_id)->first();
            if($order)
            {
                $insert["order_id"] = $order_id;
                $insert["log_date"] = Carbon::now();
                $insert["ip_address"] = get_current_ip();
                $insert["response"] = serialize(Request::input());
                DB::table("tbl_paymaya_logs_other")->insert($insert);
                  
                $this->put_temporary($order_id);
                Item_code::ec_order_slot($order_id);
    
                $update['ec_order_id']    = $order_id;
                $update['order_status']   = "Processing";
                $update['payment_status'] = 1;
                $order = Ec_order::update_ec_order($update);
                
                $this->after_email_payment($order_id);
            }
            else
            {
                $order_id = (int)Request::input("requestReferenceNumber");
                $insert["order_id"] = $order_id;
                $insert["log_date"] = Carbon::now();
                $insert["ip_address"] = get_current_ip();
                $insert["response"] = 'invalid order';
                DB::table("tbl_paymaya_logs_other")->insert($insert);
            }
        } 
        catch (\Exception $e) 
        {
            $order_id = (int)Request::input("requestReferenceNumber");
            $insert["order_id"] = $order_id;
            $insert["log_date"] = Carbon::now();
            $insert["ip_address"] = get_current_ip();
            $insert["response"] = serialize($e->getMessage());
            DB::table("tbl_paymaya_logs")->insert($insert);
        } 
        dd(Request::input());
    }
    public function paymaya_webhook_failure()
    {
        try{
            $order_id = Request::input("requestReferenceNumber");
            $this->failmaya($order_id);
        } 
        catch (\Exception $e) 
        {
            $order_id = Request::input("requestReferenceNumber");
            $insert["order_id"] = $order_id;
            $insert["log_date"] = Carbon::now();
            $insert["ip_address"] = get_current_ip();
            $insert["response"] = serialize($e->getMessage());
            DB::table("tbl_paymaya_logs")->insert($insert);
        } 
        dd(Request::input());
    }
    public function paymaya_webhook_cancel()
    {
        try{
            $order_id = Request::input("requestReferenceNumber");
            $this->failmaya($order_id);
        }
        catch (\Exception $e) 
        {
            $order_id = Request::input("requestReferenceNumber");
            $insert["order_id"] = $order_id;
            $insert["log_date"] = Carbon::now();
            $insert["ip_address"] = get_current_ip();
            $insert["response"] = serialize($e->getMessage());
            DB::table("tbl_paymaya_logs")->insert($insert);
        }
        dd(Request::input());
    }
    public function paymaya_logs()
    {
        $data["_dragonpay"] = DB::table("tbl_paymaya_logs")->orderBy("id", "DESC")->get();
        foreach ($data["_dragonpay"] as $key => $value) 
        {
            $data["_dragonpay"][$key]->extracted = is_serialized($value->response) ? unserialize($value->response) : $value->response;
        }
        
        return view("paymaya.logs", $data);
    }
    public function paymaya_logs_view($id)
    {
        $data["_dragonpay"] = DB::table("tbl_paymaya_logs_other")->where("order_id", $id)->get();
        foreach ($data["_dragonpay"] as $key => $value) 
        {
            $data["_dragonpay"][$key]->extracted = is_serialized($value->response) ? unserialize($value->response) : $value->response;
        }
        
        return view("paymaya.logs_view", $data);
    }
    public function dragonpay_logs()
    {
        $data["_dragonpay"] = DB::table("tbl_dragonpay_logs")->orderBy("id", "DESC")->get();
        foreach ($data["_dragonpay"] as $key => $value) 
        {
            $data["_dragonpay"][$key]->extracted = is_serialized($value->response) ? unserialize($value->response) : $value->response;
            $data["_dragonpay"][$key]->count = DB::table("tbl_dragonpay_logs_other")->where("order_id", $value->order_id)->count();
        }
        
        return view("dragonpay.logs", $data);
    }
    public function dragonpay_logs_view($id)
    {
        $data["_dragonpay"] = DB::table("tbl_dragonpay_logs_other")->where("order_id", $id)->get();
        foreach ($data["_dragonpay"] as $key => $value) 
        {
            $data["_dragonpay"][$key]->extracted = is_serialized($value->response) ? unserialize($value->response) : $value->response;
        }
        
        return view("dragonpay.logs_view", $data);
    }
    public function failmaya($order_id)
    {
        $insert["order_id"] = $order_id;
        $insert["log_date"] = Carbon::now();
        $insert["ip_address"] = get_current_ip();
        try
        {
            $insert["response"] = serialize(Request::input());
            DB::table("tbl_paymaya_logs_other")->insert($insert);
        } 
        catch (\Exception $e) 
        {
            $insert["response"] = serialize($e->getMessage());
            DB::table("tbl_paymaya_logs")->insert($insert);
        }
        
        $update['ec_order_id']    = $order_id;
        $update['order_status']   = "Failed";
        $update['payment_status'] = 0;
        $order = Ec_order::update_ec_order($update);

        $this->after_email_payment($order_id);
    }
    public function after_email_payment($order_id)
    {
        /* Email Checkout */
        $data_order                = DB::table("tbl_ec_order")->where("ec_order_id", $order_id)->first();
        $data_customer             = DB::table("tbl_customer")->where("customer_id", $data_order->customer_id)->first();
        if ($data_order) 
        {
            $data["template"]         = Tbl_email_template::where("shop_id", $this->shop_info->shop_id)->first();
            $data['mail_to']          = $data_order->customer_email;
            $data['mail_subject']     = "Account Verification";
            $data['account_password'] = Crypt::decrypt($data_customer->password);
            $data['mlm_username']     = $data_customer->mlm_username;
            $data['mlm_email']        = $data_customer->email; 
            $result = Mail_global::password_mail($data, $data_order->shop_id);
        }
        /* End Email Checkout */
    }
    public function put_temporary($order_id)
    {
        $order = DB::table("tbl_ec_order")->where("ec_order_id", $order_id)->first();
        $customer = DB::table("tbl_customer")->where("customer_id", $order->customer_id)->first();
        $temporary = is_serialized($customer->temporary) ? unserialize($customer->temporary) : [];
        if (isset($temporary) && $temporary && count($temporary) > 0) 
        {
            DB::table("tbl_customer")->where("customer_id", $customer->customer_id)->update($temporary);
        }
    }
    /* End Payment Facilities */

    public function index()
    {
        $data["page"]            = "Checkout";
        $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);
        /* DO NOT ALLOW ON THIS PAGE IF THERE IS NOT CART */
        if (isset($data["get_cart"]['cart']) && isset($data["get_cart"]["tbl_customer"]) && isset($data["get_cart"]["tbl_customer_address"]) && isset($data["get_cart"]["tbl_ec_order"]) && isset($data["get_cart"]["tbl_ec_order_item"]) && isset($data["get_cart"]["sale_information"])) 
        {
            $data['ec_order_load'] = 0;
            foreach($data['get_cart']['cart'] as $key => $value)
            {
                if($value['cart_product_information']['item_category_id'] == 17)
                {
                    $data['ec_order_load'] = 1;
                }      
            }
            return view("checkout", $data);
        }
        else
        { 
            return Redirect::to('/')->send();
        }
    }
    public function locale()
    {
        $parent = Request::input("parent");
        $_locale = Tbl_locale::where("locale_parent", $parent)->orderBy("locale_name")->get();

        foreach($_locale as $locale)
        {
            echo "<option value='" . $locale->locale_id . "'>" . $locale->locale_name . "</option>";
        }

    }
    public function session()
    {
        dd(Cart::get_info($this->shop_info->shop_id));
    }
    public function checkout_side()
    {
        $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);
        return view("checkout_side", $data);
    }
    public function submit()
    {
        /* SPLIT NAME TO FIRST NAME AND LAST NAME */
        $full_name = Request::input("full_name");
        $_name = $this->split_name($full_name);

        /* SET FIRST NAME, LAST NAME AND CONTACT */
        $customer_info["current_user"] = Self::$customer_info;
        $customer_info["first_name"] = $_name[0];
        $customer_info["last_name"] = $_name[1];
        $customer_info["customer_contact"] = Request::input("contact_number");

        $customer_info["shipping_state"] = Self::locale_id_to_name(Request::input("customer_state"));
        $customer_info["shipping_city"] = Self::locale_id_to_name(Request::input("customer_city"));
        $customer_info["shipping_zip"] = Self::locale_id_to_name(Request::input("customer_zip"));
        $customer_info["shipping_street"] = Request::input("customer_street");

        $customer_info['load_wallet']['ec_order_load'] = Request::input('ec_order_load');
        $customer_info['load_wallet']['ec_order_load_number'] = Request::input('ec_order_load_number');
        // dd($customer_info);
        $customer_set_info_response = Cart::customer_set_info($this->shop_info->shop_id, $customer_info, array("check_shipping", "check_name"));


        if($customer_set_info_response["status"] == "error")
        { 
            return Redirect::back()->with('error', $customer_set_info_response["status_message"])->withInput();
        }
        else
        {
            return Redirect::to("/checkout/payment");
        }
    }
    public function update_method()
    {
        $customer_info["method_id"] = Request::input("method_id");
        $old_session = $order = Cart::get_info($this->shop_info->shop_id);
        $customer_set_info_response = Cart::customer_set_info_ec_order($this->shop_info->shop_id, $old_session, $customer_info);
        $unique_id = Cart::get_unique_id($this->shop_info->shop_id);
        Session::put($unique_id, $customer_set_info_response);
        echo json_encode("Success!"); 
    }
    public function locale_id_to_name($locale_id)
    {
        return Tbl_locale::where("locale_id", $locale_id)->pluck("locale_name");
    }
    public function payment()
    {
        if(Request::isMethod("post"))
        {
            return Cart::process_payment($this->shop_info->shop_id);
        }
        else
        {
            $data["page"]            = "Checkout Payment";
            $data["_payment_method"] = $this->get_payment_method();
            $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);
            return view("checkout_payment", $data);  
        }
    }
    public function payment_upload()
    {
        $id = Crypt::decrypt(Request::input("id"));

        if (Request::isMethod("post")) 
        {
            $input = Input::all();
            $rules = array('payment_upload' => 'required|mimes:jpeg,png,gif,bmp');
            $validator = Validator::make($input, $rules);

            if ($validator->fails()) 
            {
                $messages = $validator->messages();
                return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
            } 
            else 
            {
                $file = Input::file("payment_upload");
                /* SAVE THE IMAGE IN THE FOLDER */
                if ($file) 
                {
                    $extension          = $file->getClientOriginalExtension();
                    $filename           = str_random(15).".".$extension;
                    $destinationPath    = 'uploads/'.$this->shop_info->shop_key."-".$this->shop_info->shop_id.'/ecommerce-upload';
                    
                    if(!File::exists($destinationPath)) 
                    {
                        $create_result = File::makeDirectory(public_path($destinationPath), 0775, true, true);
                    }

                    $upload_success    = Input::file('payment_upload')->move($destinationPath, $filename);

                    /* SAVE THE IMAGE PATH IN THE DATABASE */
                    $image_path = $destinationPath."/".$filename;

                    if( $upload_success ) 
                    {
                       $update['ec_order_id'] = $id;
                       $update['payment_upload'] = "/" . $image_path;
                       $update['order_status'] = "Pending";
                       $update['payment_status'] = 0;
                       $order = Ec_order::update_ec_order($update);

                       if ($order["status"] == "success") 
                       {
                           return Redirect::to("/");
                       }
                       else
                       {
                           return Redirect::back()->with('fail', 'Image upload failed. Please try again.')->send();
                       }
                    } 
                    else 
                    {
                       return Redirect::back()->with('fail', 'Image upload failed. Please try again.')->send();
                    }
                }
            }
        }
        else
        {
            $data["page"] = "Checkout Payment Upload";
            $data['_order'] = Tbl_ec_order_item::where("ec_order_id", $id)
                                               ->leftJoin('tbl_ec_variant', 'tbl_ec_order_item.item_id', '=', 'evariant_id')
                                               ->get();

            $data['summary'] = [];
            $subtotal = 0;
            $shipping = 0;
            $total = 0;

            foreach ($data['_order'] as $key => $value) 
            {
                $subtotal += $value->total;
            }
            
            $data['summary']['subtotal'] = $subtotal;

            return view("checkout_payment_upload", $data);
        }
    }
    public function get_payment_method()
    {
        $payment_method = Tbl_online_pymnt_method::leftJoin('tbl_online_pymnt_link', 'tbl_online_pymnt_link.link_method_id', '=', 'tbl_online_pymnt_method.method_id')
                                                          ->leftJoin('tbl_online_pymnt_other', 'tbl_online_pymnt_link.link_reference_id', '=', 'tbl_online_pymnt_other.other_id')
                                                          ->leftJoin('tbl_image', 'tbl_online_pymnt_link.link_img_id', '=', 'tbl_image.image_id')
                                                          ->where("tbl_online_pymnt_link.link_shop_id", $this->shop_info->shop_id)
                                                          ->where("tbl_online_pymnt_link.link_is_enabled", 1)
                                                          ->get();

        return $payment_method;
    }
    public function addtocart()
    {
        $data["page"] = "Checkout - Add to Cart";
        return view("addto_cart", $data);
    }
    function split_name($name)
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return array($first_name, $last_name);
    }
    public function order_placed()
    {
        $data["page"] = "Checkout - Order Placed";
        $order = Request::input('order');
        if (!$order) 
        {
            return Redirect::to("/");
        }

        $order_id = unserialize(Crypt::decrypt($order));
    
        $data['_order'] = Tbl_ec_order_item::where("ec_order_id", $order_id)
                                           ->leftJoin('tbl_ec_variant', 'tbl_ec_order_item.item_id', '=', 'evariant_id')
                                           ->get();

        $data['summary'] = [];
        $subtotal = 0;
        $shipping = 0;
        $total = 0;

        foreach ($data['_order'] as $key => $value) 
        {
            $subtotal += $value->total;
        }
        
        $data['summary']['subtotal'] = $subtotal;
        $data['order_id'] = $order_id;

        return view("order_placed", $data);
    }
}
