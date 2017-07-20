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
use App\Models\Tbl_ec_order;
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
        $temp = DB::table("tbl_ipay88_temp")->where("reference_number", $request['RefNo'])->first();
        if ($temp) 
        {
            $shop_id = $temp->shop_id;
            $customer_id = $temp->customer_id;
            
            /* Logs */
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
            $ipay88_logs["shop_id"] = $shop_id;
            $ipay88_logs["response"] = serialize($request);
            $ipay88_logs["from"] = "response";

            if ($request) 
            {
                try 
                {
                    /* Success */
                    if($request['Status'] == 1)
                    {
                        $payment_status = 1;
                        $order_status   = "Processing";
                        $order_id = Cart::submit_order($shop_id, $payment_status, $order_status, $customer_id);
                        
                        $ipay88_logs["order_id"] = $order_id;
                        DB::table("tbl_ipay88_logs")->insert($ipay88_logs);
                       
                        /* Confirmed Payment */
                        $order = Tbl_ec_order::customer()->customer_otherinfo()->payment_method()->where("ec_order_id",$order_id)->first();

                        /* EMAIL SUCCESSFUL ORDER */
                        $pass_data["order_details"] = $order;
                        $pass_data["order_item"] = Tbl_ec_order_item::item()->where("ec_order_id",$order_id)->groupBy("ec_order_id")->get();
                        $pass_data["order_status"] = $order_status; 
                        Mail_global::create_email_content($pass_data, $shop_id, "successful_order");

                        /* Redirect */
                        return Redirect::to('/order_placed?order=' . Crypt::encrypt(serialize($order_id)))->send();
                    } 
                    elseif($request['Status'] == 6)
                    {
                        DB::table("tbl_ipay88_logs")->insert($ipay88_logs);

                        return Redirect::to("/product#pending_modal");
                    }
                    elseif ($request['Status'] == 0) 
                    {
                        DB::table("tbl_ipay88_logs")->insert($ipay88_logs);

                        return Redirect::to("/product#fail_modal");
                    }
                    else 
                    {
                        DB::table("tbl_ipay88_logs")->insert($ipay88_logs);

                        return redirect('/checkout')->withErrors($request['ErrDesc'])->send();
                    }    
                } 
                catch (\Exception $e) 
                {
                    $insert_error['response'] = $e->getMessage();
                    $insert_error['shop_id'] = $shop_id;
                    DB::table("tbl_ipay88_logs")->insert($insert_error);

                    return redirect('/checkout')->withErrors($request['ErrDesc'])->send();
                }
            }
            else
            {
                return Redirect::to("/checkout")->with('fail', 'Session has been expired. Please try again.')->send();
            }
        }
        else
        {
            dd("Some error occurred. Please try again later.");
        }
    }
    public function ipay88_backend()
    {
        $request = Request::all();
        $temp = DB::table("tbl_ipay88_temp")->where("reference_number", $request['RefNo'])->first();
        if ($temp) 
        {
            $shop_id = $temp->shop_id;
            $customer_id = $temp->customer_id;
            
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
            $ipay88_logs["shop_id"] = $shop_id;
            $ipay88_logs["response"] = serialize($request);
            $ipay88_logs["from"] = "backend";

            if ($request) 
            {
                try 
                {
                    /* Success */
                    if($request['Status'] == 1)
                    {
                        $payment_status = 1;
                        $order_status   = "Processing";
                        $order_id = Cart::submit_order($shop_id, $payment_status, $order_status, $customer_id);
                        
                        $ipay88_logs["order_id"] = $order_id;
                        DB::table("tbl_ipay88_logs")->insert($ipay88_logs);
                       
                        /* Confirmed Payment */
                        $order = Tbl_ec_order::customer()->customer_otherinfo()->payment_method()->where("ec_order_id",$order_id)->first();
                        
                        /* EMAIL SUCCESSFUL ORDER */
                        $pass_data["order_details"] = $order;
                        $pass_data["order_item"] = Tbl_ec_order_item::item()->where("ec_order_id",$order_id)->groupBy("ec_order_id")->get();
                        $pass_data["order_status"] = $order_status; 
                        Mail_global::create_email_content($pass_data, $shop_id, "successful_order");

                        /* Redirect */
                        return true;
                    } 
                    elseif($request['Status'] == 6)
                    {
                        DB::table("tbl_ipay88_logs")->insert($ipay88_logs);

                        return false;
                    }
                    elseif ($request['Status'] == 0) 
                    {
                        DB::table("tbl_ipay88_logs")->insert($ipay88_logs);

                        return false;
                    }
                    else 
                    {
                        DB::table("tbl_ipay88_logs")->insert($ipay88_logs);

                        return false;
                    }    
                } 
                catch (\Exception $e) 
                {
                    $insert_error['response'] = $e->getMessage();
                    $insert_error['shop_id'] = $shop_id;
                    DB::table("tbl_ipay88_logs")->insert($insert_error);

                    return false;
                }
            }
            else
            {
                return false;
            }
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
                    $update['ec_order_id'] = $order_id;
                    $update['order_status'] = "Processing";
                    $update['payment_status'] = 1;
                    $order = Ec_order::update_ec_order($update);

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
            return Redirect::to('/mlm/login?notify=2&success=1');
        }
    }
    public function dragonpay_postback()
    {
        $request = Request::all();

        $insert["log_date"] = Carbon::now();
        $insert["content"]  = serialize($request);
        DB::table("tbl_dragonpay_logs")->insert($insert);

        if (Request::input("status") == "S") 
        {
            $from = Request::input('param1');
            if ($from == "checkout") 
            {
                $order_id = Request::input("param2");
                $order = DB::table('tbl_ec_order')->where('ec_order_id', $order_id)->first();

                if($order)
                {  
                    try 
                    {
                        $update['ec_order_id'] = $order_id;
                        $update['order_status'] = "Processing";
                        $update['payment_status'] = 1;
                        $order = Ec_order::update_ec_order($update);

                        $this->after_email_payment($order_id);
                    } 
                    catch (\Exception $e) 
                    {
                        $last["log_date"] = Carbon::now();
                        $last["content"]  = $e->getMessage();
                        DB::table("tbl_dragonpay_logs")->insert($last);  
                    }   
                }
            }
            elseif ($from == "register")
            {
                $order_id = Request::input("param2");
                $order = DB::table('tbl_ec_order')->where('ec_order_id', $order_id)->first();

                if($order)
                {
                    try 
                    {
                        Item_code::ec_order_slot($order_id);
                        
                        $update['ec_order_id'] = $order_id;
                        $update['order_status'] = "Processing";
                        $update['payment_status'] = 1;
                        $order = Ec_order::update_ec_order($update);

                        $this->after_email_payment($order_id);
                    } 
                    catch (\Exception $e) 
                    {
                        $last["log_date"] = Carbon::now();
                        $last["content"]  = $e->getMessage();
                        DB::table("tbl_dragonpay_logs")->insert($last);  
                    }  
                }
            }
        }
    }
    public function dragonpay_logs()
    {
        $dragonpay = DB::table("tbl_dragonpay_logs")->orderBy("id", "DESC")->first();

        if (is_serialized($dragonpay->content)) 
        {
            dd(unserialize($dragonpay->content));
        }
        else
        {
            dd($dragonpay->content);
        }
    }
    public function paymaya_success()
    {
        $order_id = Crypt::decrypt(Request::input("order_id"));
        $from = Request::input("from");

        $order = DB::table('tbl_ec_order')->where('ec_order_id', $order_id)->first();
        if($order)
        {
            Item_code::ec_order_slot($order_id);

            $update['ec_order_id']    = $order_id;
            $update['order_status']   = "Processing";
            $update['payment_status'] = 1;
            $order = Ec_order::update_ec_order($update);

            $this->after_email_payment($order_id);

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
        $order_id = Crypt::decrypt(Request::input("order"));
        $this->failmaya($order_id);
        return Redirect::to('/mlm/login?notify=3');
    }
    public function paymaya_cancel()
    {
        $order_id = Crypt::decrypt(Request::input("order"));
        $this->failmaya($order_id);
        return Redirect::to('/mlm/login?notify=4');
    }
    public function failmaya($order_id)
    {
        $update['ec_order_id']    = $order_id;
        $update['order_status']   = "Failed";
        $update['payment_status'] = 0;
        $order = Ec_order::update_ec_order($update);

        // $customer = DB::table("tbl_ec_order")->select("tbl_ec_order.ec_order_id", "tbl_ec_order.customer_id as order_customer_id", "tbl_customer.*")
        //                                      ->join("tbl_customer", "tbl_customer.customer_id", "=", "tbl_ec_order.customer_id")
        //                                      ->where("tbl_ec_order.ec_order_id", $order_id)
        //                                      ->first();
    
        // $update_customer["email"] = "f_" . $customer->email;
        // $update_customer["first_name"] = "f_" . $customer->first_name;
        // $update_customer["last_name"] = "f_" . $customer->last_name;
        // $update_customer["middle_name"] = "f_" . $customer->middle_name;
        // $update_customer["mlm_username"] = "f_" . $customer->mlm_username;

        // DB::table("tbl_customer")->where("customer_id", $customer->customer_id)->update($update_customer);
    }
    public function after_email_payment($order_id)
    {
        /* Email  */
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

            if ($data["get_cart"]["new_account"] == false) 
            {
                $data["shipping_address"] = DB::table("tbl_customer_address")->where("purpose", "shipping")
                                                                             ->where("customer_id", $data["get_cart"]["tbl_customer"]["customer_id"])
                                                                             ->first();

                $data["shipping_address"]->state_id = isset(DB::table("tbl_locale")->where("locale_name", $data["shipping_address"]->customer_state)->first()->locale_id) ? DB::table("tbl_locale")->where("locale_name", $data["shipping_address"]->customer_state)->first()->locale_id : null;
                $data["shipping_address"]->city_id = isset(DB::table("tbl_locale")->where("locale_name", $data["shipping_address"]->customer_city)->first()->locale_id) ? DB::table("tbl_locale")->where("locale_name", $data["shipping_address"]->customer_city)->first()->locale_id : null;
                $data["shipping_address"]->zipcode_id = isset(DB::table("tbl_locale")->where("locale_name", $data["shipping_address"]->customer_zipcode)->first()->locale_id) ? DB::table("tbl_locale")->where("locale_name", $data["shipping_address"]->customer_zipcode)->first()->locale_id : null;
            }
            
            $data["customer"] = DB::table("tbl_customer")->leftJoin("tbl_customer_other_info", "tbl_customer.customer_id", "=", "tbl_customer_other_info.customer_id")
                                                         ->where("tbl_customer.customer_id", $data["get_cart"]["tbl_customer"]["customer_id"])
                                                         ->first();
            
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
        /* Validation */
        $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);

        // if ($data["get_cart"]["new_account"] == true) 
        // {
            $validate["full_name"] = Request::input("full_name");
            $validate["contact_number"] = Request::input("contact_number");
            $validate["customer_state"] = Request::input("customer_state");
            $validate["customer_city"] = Request::input("customer_city");
            $validate["customer_zip"] = Request::input("customer_zip");
            $validate["customer_street"] = Request::input("customer_street");

            $rules["full_name"] = 'required';
            $rules["contact_number"] = 'required';
            $rules["customer_state"] = 'required';
            $rules["customer_city"] = 'required';
            $rules["customer_zip"] = 'required';
            $rules["customer_street"] = 'required';

            $validator = Validator::make($validate, $rules);

            if ($validator->fails()) 
            {
                return Redirect::back()
                            ->withErrors($validator)
                            ->withInput();
            }
        // } 

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

        $customer_info["billing_state"] = Self::locale_id_to_name(Request::input("billing_customer_state"));
        $customer_info["billing_city"] = Self::locale_id_to_name(Request::input("billing_customer_city"));
        $customer_info["billing_zip"] = Self::locale_id_to_name(Request::input("billing_customer_zip"));
        $customer_info["billing_street"] = Request::input("billing_customer_street");

        $customer_info['load_wallet']['ec_order_load'] = Request::input('ec_order_load');
        $customer_info['load_wallet']['ec_order_load_number'] = Request::input('ec_order_load_number');

        $customer_info['billing_equals_shipping'] = Request::input('billing_equals_shipping') !== null ? false : true;
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
