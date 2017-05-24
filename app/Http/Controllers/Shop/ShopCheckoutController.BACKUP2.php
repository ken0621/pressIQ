<?php 

    /* PAYMENT GATEWAY */
    public function submit_using_credit_card()
    {
        dd("Under Maintenance");
    }
    public function submit_using_paypal()
    {
        dd("Under Maintenance");
    }
    public function submit_using_ipay88($cart, $payment_method_id)
    {
        $payment_method = DB::table("tbl_online_pymnt_method")->where("method_id", $payment_method_id)->first();
        switch ($payment_method->method_code_name) 
        {
            case 'bdo':
                $payment_id = 5;
            break;

            case 'bpi':
                $payment_id = 5;
            break;

            case 'metrobank':
                $payment_id = 5;
            break;
            
            default:
                $payment_id = 1;
            break;
        }
        
        // Create Order
        $cart["order_status"] = "Failed";
        $result = Ec_order::create_ec_order_automatic($cart);

        if(isset($result['order_id']['status']))
        {
              return Redirect::back()
                 ->withErrors($result['order_id']['status_message'])
                 ->withInput()
                 ->send();
        }

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
            return Redirect::back()->with('fail', 'Some error occurred. Please try again.')->send();
        }
        else
        {
            $ipay88 = array(
                'merchantKey'   => $online_payment_api->api_secret_id,
                'merchantCode'  => $online_payment_api->api_client_id,
                'paymentId'     => $payment_id, //Optional value 1=credit card 5=bancnet
                'refNo'         => $reference_number,
                'amount'        => '15.00',
                'currency'      => "PHP",
                'prodDesc'      => $cart['product_summary'],
                'userName'      => $full_name,
                'userEmail'     => Request::input("customer_email"),
                'userContact'   => Request::input("customer_mobile"),
                'remark'        => 'Some Remarks Here!',
                'lang'          => 'UTF-8',
                'responseUrl'   => URL::to('/ipay88_response'),
                'backendUrl'    => URL::to('/ipay88_response')
                );
            
            Session::put('ipay88', $ipay88);
            Session::put('ipay88_order', $result);

            return redirect('/postPaymentWithIPay88')->send();    
        }  
    }
    public function submit_using_proofofpayment($file, $cart)
    {
        $shop_id    = $this->shop_info->shop_id;
        $shop_key   = $this->shop_info->shop_key;

        /* SAVE THE IMAGE IN THE FOLDER */
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
               return Redirect::back()->with('fail', 'Image upload failed. Please try again.')->send();
            }
        }

        $result = Ec_order::create_ec_order_automatic($cart);
        if(isset($result['order_id']['status']))
        {
              return Redirect::to("/checkout")
                 ->withErrors($result['order_id']['status_message'])
                 ->withInput()
                 ->send();
        }

        Cart::clear_all($this->shop_info->shop_id);

        return Redirect::to('/order_placed?order=' . Crypt::encrypt(serialize($result)))->send();
    }
    public function submit_using_paymaya()
    {
        dd("Under Maintenance");
    }
    public function submit_using_paynamics()
    {
        dd("Under Maintenance");
    }
    public function submit_using_dragonpay()
    {
        dd("Under Maintenance");
    }
    public function submit_using_ewallet($cart)
    {
        $sum = $cart["sum"];
        $get_cart = Cart::get_cart($this->shop_info->shop_id);

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
                    ->withInput()
                    ->send();
            }
        }
        else
        {
            $send['errors'][0] = "Only members with slot can use the wallet option.";
            return Redirect::back()->withErrors($send)->withInput()->send();
        }

        $result = Ec_order::create_ec_order_automatic($cart);
        if(isset($result['order_id']['status']))
        {
              return Redirect::back()
                 ->withErrors($result['order_id']['status_message'])
                 ->withInput()
                 ->send();
        }

        if(Self::$slot_now != null)
        {
            if(isset($result['order_id']))
            {
                Mlm_slot_log::slot_array($arry_log);
            }
        }
     
        Cart::clear_all($this->shop_info->shop_id);

        return Redirect::to('/order_placed?order=' . Crypt::encrypt(serialize($result)))->send();
    }
    /* END PAYMENT GATEWAY */

    public function validate_payment()
    {
        if(!isset(Self::$customer_info->customer_id))
        {
            $check_email = Tbl_customer::where('shop_id', $this->shop_info->shop_id)->where('email', Request::input("email"))->where("password", "!=", "")->count();

            if ($check_email)
            {
                return Redirect::to('/checkout/login')->with('warning', 'An account already exists with the email "' . Request::input("email") . '". Please enter your password below to continue.')->send();
            }
        }

        if ( !Request::input("payment_method_id") ) 
        {
            Session::put("checkout_input", Request::input());

            return Redirect::to("/checkout/payment")->send();
        }
    }
    public function validate_submit()
    {
        $message = [];
        // Validate Customer Info
        $rules["customer_first_name"]   = 'required';
        $rules["customer_middle_name"]  = '';
        $rules["customer_last_name"]    = 'required';
        $rules["customer_email"]        = 'required';
        $rules["customer_birthdate"]    = 'required';
        $rules["customer_mobile"]       = 'required';
        $rules["customer_state_province"] = 'required';
        $rules["customer_city"]         = 'required';
        $rules["customer_address"]      = 'required';
        $rules["payment_method_id"]     = '';
        $rules["taxable"]               = 'required';

        $ec_order_load = Request::input('ec_order_load');
        if($ec_order_load == 1)
        {
            $rules['ec_order_load_number'] = 'required';
        }
        $ec_order_merchant_school = Request::input('ec_order_merchant_school');

        if($ec_order_merchant_school >= 1)
        {
            // $input['merchant_school_s_id'] = Request::input('merchant_school_s_id');
            // foreach($input['merchant_school_s_id'] as $key => $value)
            // {
            //     $rules['merchant_school_s_id.' . $key] = 'required';
            //     $rules['merchant_school_s_name.' . $key] = 'required';
            //     $message['merchant_school_s_id.' . $key .'.required'] = 'All Student ID field is required';
            //     $message['merchant_school_s_name.' . $key .'.required'] = 'All Student Name field is required';
            // }
            
        }
        return $validator = Validator::make(Request::input(), $rules, $message);
    }
    public function restructure_cart()
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

        /* REASTRUCTURE */
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
        $cart['ec_order_merchant_school'] = Request::input('ec_order_merchant_school');
        if($cart['ec_order_merchant_school'] >= 1)
        {
            $cart['merchant_school_i_id'] = Request::input('merchant_school_i_id'); 
            $cart['merchant_school_s_id'] = Request::input('merchant_school_s_id'); 
            $cart['merchant_school_s_name'] = Request::input('merchant_school_s_name'); 
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
        $cart["product_summary"] = $product_summary;
        $cart["sum"] = $sum;

        if(isset(Self::$customer_info->customer_id))
        {
            $cart["customer_id"] = Self::$customer_info->customer_id;
        }
        else
        {
            $cart["customer_id"] = null;
        }

        return $cart;
    }
    public function check_stocks()
    {
        $stock = Cart::check_product_stock(Cart::get_cart($this->shop_info->shop_id));
        if ($stock["status"] == "fail") 
        {
            return Redirect::back()->with('fail', $stock["error"])->send();
        }
    }
    public function check_payment_method_enabled($cart)
    {
        $payment_method = Tbl_online_pymnt_method::leftJoin('tbl_online_pymnt_link', 'tbl_online_pymnt_link.link_method_id', '=', 'tbl_online_pymnt_method.method_id')
                                                  ->where("tbl_online_pymnt_method.method_id", $cart["payment_method_id"])
                                                  ->where("tbl_online_pymnt_link.link_shop_id", $this->shop_info->shop_id)
                                                  ->where("tbl_online_pymnt_link.link_is_enabled", 1)
                                                  ->first();

        if (!$payment_method) 
        {
            return Redirect::back()->with('fail', 'Invalid payment method. Please try again.')->send();
        }
    }
    public function check_payment_method($cart)
    {
        $file = Input::file('payment_upload');
        $payment_method = DB::table("tbl_online_pymnt_link")->where("link_method_id", $cart["payment_method_id"])
                                                            ->where("link_is_enabled", 1)
                                                            ->where("link_shop_id", $this->shop_info->shop_id)
                                                            ->first();

        if ($payment_method->link_reference_name == "other") 
        {
            $use_payment_method = DB::table("tbl_online_pymnt_method")->where("method_id", $payment_method->link_method_id)->first();

            switch ($use_payment_method->method_code_name) 
            {
                case 'e-wallet': return $this->submit_using_ewallet($cart); break;
                default: return $this->submit_using_proofofpayment($file, $cart); break;
            }
        }
        else
        {
            $use_payment_method = DB::table("tbl_online_pymnt_api")->where("api_id", $payment_method->link_reference_id)->first();
            if (isset($use_payment_method->api_gateway_id)) 
            {
                $use_gateway        = DB::table("tbl_online_pymnt_gateway")->where("gateway_id", $use_payment_method->api_gateway_id)->first();
                
                switch ($use_gateway->gateway_code_name) 
                {
                    case 'paypal2': return $this->submit_using_paypal(); break;
                    case 'paymaya': return $this->submit_using_paymaya(); break;
                    case 'paynamics': return $this->submit_using_paynamics(); break;
                    case 'dragonpay': return $this->submit_using_dragonpay(); break;
                    case 'other': return $this->submit_using_proofofpayment($file, $cart); break;
                    case 'ipay88': return $this->submit_using_ipay88($cart, $cart["payment_method_id"]); break;
                    default: dd("Some error occurred"); break;
                }
            }
            else
            {
                return $this->submit_using_proofofpayment($file, $cart);
            }
        }
    }

    // public function submit()
    // {
    //     $validator = $this->validate_submit();
    //     if ($validator->fails()) 
    //     {
    //         return Redirect::back()
    //                     ->withErrors($validator)
    //                     ->withInput();
    //     }
    //     else
    //     {
    //         $this->validate_payment();
    //         $cart = $this->restructure_cart();
    //         $this->check_stocks();
    //         $this->check_payment_method_enabled($cart);
    //         $this->check_payment_method($cart);
    //     }
    // }

    /*Ipay88 Function*/

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