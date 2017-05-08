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
// use App\Globals\Mlm_slot_log;    

/*4/29/17 this will import the data/class needed by ipay88 payment mode by:brain*/
use App\IPay88\RequestPayment;
use App\Models\Tbl_online_pymnt_api;

class ShopCheckoutController extends Shop
{
    public function index()
    {
        $data["page"]            = "Checkout";
        $data["get_cart"]        = Cart::get_cart($this->shop_info->shop_id);

        if (!isset($data["get_cart"]['cart'])) 
        {
            return Redirect::to('/');
        }

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

        $data["_payment_method"] = Tbl_online_pymnt_method::leftJoin('tbl_online_pymnt_link', 'tbl_online_pymnt_link.link_method_id', '=', 'tbl_online_pymnt_method.method_id')
                                                          ->leftJoin('tbl_online_pymnt_other', 'tbl_online_pymnt_link.link_reference_id', '=', 'tbl_online_pymnt_other.other_id')
                                                          ->where("tbl_online_pymnt_link.link_shop_id", $this->shop_info->shop_id)
                                                          ->where("tbl_online_pymnt_link.link_is_enabled", 1)
                                                          ->get();

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

            $i = 0;
            $len = count($get_cart['cart']);

            foreach ($get_cart['cart'] as $key => $value) 
            {
                if ($i == $len - 1) 
                {
                    $product_summary = $value["cart_product_information"]["product_name"] . " (x" . $value["quantity"] . ") - " . currency("PHP", $value["cart_product_information"]["product_current_price"]) . "";
                }
                else
                {
                    $product_summary = $value["cart_product_information"]["product_name"] . " (x" . $value["quantity"] . ") - " . currency("PHP", $value["cart_product_information"]["product_current_price"]) . ", ";
                }

                $i++;

                array_push($invline_item_id, $value["product_id"]);
                array_push($invline_discount, $value["cart_product_information"]["product_discounted_value"]);
                array_push($invline_rate, $value["cart_product_information"]["product_price"]);
                array_push($invline_qty, $value["quantity"]);
                array_push($invline_discount_remark, "");
                array_push($invline_description, "");
                array_push($invline_service_date, date('Y-m-d H:i:s'));
                $add_sum = ($value["cart_product_information"]["product_price"] - $value["cart_product_information"]["product_discounted_value"]) * $value["quantity"];
                $sum += $add_sum;
            }

            $cart['ec_order_load'] = Request::input('ec_order_load');
            if($cart['ec_order_load'] == 1)
            {
                $cart['ec_order_load_number'] = Request::input('ec_order_load_number');
            }
            else
            {
                $cart['ec_order_load_number'] = null;
                $cart['ec_order_load'] = 0;
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
            $cart["payment_status"] = 0;
            $cart["payment_upload"] = "";


            if(isset(Self::$customer_info->customer_id))
            {
                $cart["customer_id"] = Self::$customer_info->customer_id;
            }
            else
            {
                $cart["customer_id"] = null;
            }

            /* -------------------------------------------------------------------------- */

            // Check Stocks
            $stock = Cart::check_product_stock($get_cart);
            if ($stock["status"] == "fail") 
            {
                return Redirect::back()->with('fail', $stock["error"]);
            }

            /* -------------------------------------------------------------------------- */

            // Check Payment Method if enabled
            $payment_method = Tbl_online_pymnt_method::leftJoin('tbl_online_pymnt_link', 'tbl_online_pymnt_link.link_method_id', '=', 'tbl_online_pymnt_method.method_id')
                                                      ->where("tbl_online_pymnt_method.method_id", $cart["payment_method_id"])
                                                      ->where("tbl_online_pymnt_link.link_shop_id", $this->shop_info->shop_id)
                                                      ->where("tbl_online_pymnt_link.link_is_enabled", 1)
                                                      ->first();

            if (!$payment_method) 
            {
                return Redirect::back()->with('fail', 'Invalid payment method. Please try again.');
            }

            /* -------------------------------------------------------------------------- */

            // Payment Method using E-Wallet
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
                }
                else
                {
                    $send['errors'][0] = "Only members with slot can use the wallet option.";
                    return Redirect::back()
                        ->withErrors($send)
                        ->withInput();
                }
            }
            // Payment Method With Proof of Payment
            elseif($cart["payment_method_id"] != 1 && $cart["payment_method_id"] != 2 && $cart["payment_method_id"] != 8)
            {
                $shop_id    = $this->shop_info->shop_id;
                $shop_key   = $this->shop_info->shop_key;

                /* SAVE THE IMAGE IN THE FOLDER */
                $file               = Input::file('payment_upload');

                if ($file) 
                {
                    $extension          = $file->getClientOriginalExtension();
                    $filename           = str_random(15).".".$extension;
                    $destinationPath    = 'uploads/'.$shop_key."-".$shop_id.'/ecommerce-upload';

                    if(!File::exists($destinationPath)) 
                    {
                        $create_result = File::makeDirectory(public_path($destinationPath), 0775, true, true);
                    }

                    $upload_success    = Input::file('payment_upload')->move($destinationPath, $filename);

                    /* SAVE THE IMAGE PATH IN THE DATABASE */
                    $image_path = $destinationPath."/".$filename;

                    if( $upload_success ) 
                    {
                       $cart['payment_upload'] = "/" . $image_path;
                    } 
                    else 
                    {
                       return Redirect::back()->with('fail', 'Image upload failed. Please try again.');
                    }
                }
            }
            // Payment Method with Payment Facility (Temporary)
            /* Credit Card */
            if ($cart["payment_method_id"] == 1) 
            {
                dd("Under Maintenance");
            }
            /* Paypal */
            elseif ($cart["payment_method_id"] == 2)
            {
                dd("Under Maintenance");           
            }
            /* iPay88 */
            elseif ($cart["payment_method_id"] == 8)
            {
                $shop_id= $this->shop_info->shop_id;
                $online_payment_api = Tbl_online_pymnt_api::where('api_shop_id', $shop_id)
                                                          ->where('api_gateway_id', "6")
                                                          ->first();

                $full_name          = Request::input("customer_first_name") . ' '
                                        . Request::input("customer_middle_name") . ' '
                                        . Request::input("customer_last_name");

                $reference_number = $this->shop_info->shop_id . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);
                $exist_reference  = DB::table("tbl_ipay88_logs")->where("shop_id", $this->shop_info->shop_id)->where("log_reference_number", $reference_number)->first();

                if ($exist_reference) 
                {
                    return Redirect::back()->with('fail', 'Some error occurred. Please try again.');
                }
                else
                {
                    $ipay88 = array(
                        'merchantKey'   => $online_payment_api->api_secret_id,
                        'merchantCode'  => $online_payment_api->api_client_id,
                        'paymentId'     => 1, //Optional value 1=credit card 5=bancnet
                        'refNo'         => $reference_number,
                        'amount'        => '15.00',
                        'currency'      => "PHP",
                        'prodDesc'      => $product_summary,
                        'userName'      => $full_name,
                        'userEmail'     => Request::input("customer_email"),
                        'userContact'   => Request::input("customer_mobile"),
                        'remark'        => 'Some Remarks Here!',
                        'lang'          => 'UTF-8',
                        'responseUrl'   => URL::to('/ipay88_response'),
                        'backendUrl'    => URL::to('/ipay88_response')
                        );
                    
                    Session::put('ipay88', $ipay88);
                    Session::put('ipay88_data', Request::input());

                    return redirect('/postPaymentWithIPay88');     
                }             
            }
            
            /* -------------------------------------------------------------------------- */


            // Create Order
            $result = Ec_order::create_ec_order_automatic($cart);
            if(isset($result['order_id']['status']))
            {
                  return Redirect::back()
                     ->withErrors($result['order_id']['status_message'])
                     ->withInput();
            }

            /* -------------------------------------------------------------------------- */

            // Luke's Process with E-Wallet
            if($cart["payment_method_id"] == 6)
            {
                if(Self::$slot_now != null)
                {
                    if(isset($result['order_id']))
                    {
                        Mlm_slot_log::slot_array($arry_log);
                        $this->give_product_code($get_cart['cart'], Self::$slot_now, $result['order_id']);

                        /* SMS Notification */
                        // $txt[0]["txt_to_be_replace"]    = "[name]";
                        // $txt[0]["txt_to_replace"]       = $invoice['first_name'];
                        // $result  = Sms::SendSms($invoice['customer_mobile'], "membership_code_purchase", $txt, $shop_id);
                    }
                }
            }

            /* -------------------------------------------------------------------------- */

            // Clear Cart
            Cart::clear_all($this->shop_info->shop_id);

            /* -------------------------------------------------------------------------- */

            // Redirect
            return Redirect::to('/order_placed?order=' . Crypt::encrypt(serialize($result)));
        }
    }
    /*Ipay88 Function*/
    public function postPaymentWithIPay88($order_id)
    {
        echo "Please do not refresh the page and wait while we are processing your payment. This can take a few minutes.";

        $data = Session::get('ipay88');
        
        $requestpayment = new RequestPayment($data["merchantKey"]);

        $this->_data = array(
            'merchantCode'  => $requestpayment->setMerchantCode($data["merchantCode"]),
            'paymentId'     => $requestpayment->setPaymentId($data["paymentId"]),
            'refNo'         => $requestpayment->setRefNo($data["refNo"]),
            'amount'        => $requestpayment->setAmount($data["amount"]),
            'currency'      => $requestpayment->setCurrency($data["currency"]),
            'prodDesc'      => $requestpayment->setProdDesc($data["prodDesc"]),
            'userName'      => $requestpayment->setUserName($data["userName"]),
            'userEmail'     => $requestpayment->setUserEmail($data["userEmail"]),
            'userContact'   => $requestpayment->setUserContact($data["userContact"]),
            'remark'        => $requestpayment->setRemark($data["remark"]),
            'lang'          => $requestpayment->setLang($data["lang"]),
            'signature'     => $requestpayment->getSignature(),
            'responseUrl'   => $requestpayment->setResponseUrl($data["responseUrl"]),
            'backendUrl'    => $requestpayment->setBackendUrl($data["backendUrl"])
            );
        
        Session::forget('ipay88');

        RequestPayment::make($data["merchantKey"], $this->_data);     
    }

    public function ipay88_response()
    {
        $request = Request::all();
        $ipay88_data = Session::get("ipay88_data");
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
                return redirect('/checkout')->withErrors($request['ErrDesc'].'. '.'Please refer to ipay88 Appendix I - 3.0 Error Description.');    
            } 
            else 
            {
                echo "Please do not refresh the page and wait while we are processing your payment. This can take a few minutes.";
                echo "<form id='autosubmit' action='/checkout' method='post'>";
                echo "<input type='hidden' name='_token' value='" . csrf_token() . "'>";
                echo "<input type='hidden' name='ipay88' value='1'>";
                if (is_array($ipay88_data) || is_object($ipay88_data))
                {
                    foreach ($ipay88_data as $key => $val) 
                    {
                        if (is_array($val)) 
                        {
                            foreach ($val as $key0 => $val0) 
                            {
                                echo "<input type='hidden' name='" . ucfirst($key) . "[" . $key0 . "]" . "' value='" . htmlspecialchars($val0) . "'>";
                            }
                        }
                        else
                        {
                            echo "<input type='hidden' name='".ucfirst($key)."' value='".htmlspecialchars($val)."'>";
                        }
                    }
                }
                echo "</form>";
                echo "
                <script type='text/javascript'>
                    function submitForm() {
                        document.getElementById('autosubmit').submit();
                    }
                    window.onload = submitForm;
                </script>

                ";      
            }
        }
        else
        {
            return Redirect::to("/checkout")->with('fail', 'Session has been expired. Please try again.');
        }
    }
    /*End Ipay88*/
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
            $rel_insert[$key]["ec_order_id"]                   = $order_id;
            $rel_insert[$key]["slot_id"]                       = $slot_info->slot_id;
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
        $order = Request::input('order');
        if (!$order) 
        {
            return Redirect::to("/");
        }

        $data = unserialize(Crypt::decrypt($order));

        $data['_order'] = Tbl_ec_order_item::where("ec_order_id", $data["order_id"])
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

    	return view("order_placed", $data);
    }
    public function addtocart()
    {
        $data["page"] = "Checkout - Add to Cart";
        return view("addto_cart", $data);
    }
}