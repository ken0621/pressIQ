<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Request as Request2;
use Crypt;
use Redirect;
use View;
use Input;
use File;
use Image;
use Mail;
use DB;
use URL;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Globals\Payment;
use App\Globals\ShopEvent;
use App\Globals\CustomerBeneficiary;
use App\Globals\Customer;
use App\Globals\MemberSlotGenealogy;
use App\Rules\Uniqueonshop;
use App\Globals\MLM2;
use App\Globals\FacebookGlobals;
use App\Globals\SocialNetwork;
use App\Globals\GoogleGlobals;
use App\Globals\EmailContent;
use App\Globals\Mail_global;
use App\Globals\Transaction;
use App\Globals\Warehouse2;
use App\Models\Tbl_customer;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_customer_other_info;
use App\Models\Tbl_email_template;
use App\Models\Tbl_transaction_list;
use App\Models\Tbl_transaction_item;
use App\Models\Tbl_mlm_slot_bank;
use App\Models\Tbl_country;
use App\Models\Tbl_locale;
use App\Models\Tbl_vmoney_wallet_logs;
use App\Models\Tbl_mlm_encashment_settings;
use App\Models\Tbl_payout_bank;
use App\Models\Tbl_online_pymnt_api;
use App\Globals\Currency;
use App\Globals\Cart2;
use App\Globals\Item;
use App\Globals\Mlm_tree;
use Jenssegers\Agent\Agent;
use App\Globals\Mlm_slot_log;
use Validator;
use Google_Client; 
use Google_Service_Drive;
use Google_Service_Plus;
use stdClass;

// PAYMAYA
use App\Globals\PayMaya\PayMayaSDK;
use App\Globals\PayMaya\API\Checkout;
use App\Globals\PayMaya\API\Customization;
use App\Globals\PayMaya\API\Webhook;
use App\Globals\PayMaya\Core\CheckoutAPIManager;
use App\Globals\PayMaya\Checkout\User;
use App\Globals\PayMaya\Model\Checkout\ItemAmountDetails;
use App\Globals\PayMaya\Model\Checkout\ItemAmount;
use App\Globals\PayMaya\Core\Constants;

class ShopMemberController extends Shop
{
    public function getIndex()
    {
        $data["page"] = "Dashboard";
        $data["mode"] = session("get_success_mode");
        $data["zero_currency"] = Currency::format(0);
        session()->forget("get_success_mode");

        if(Self::$customer_info)
        {
            $data["customer_summary"]   = MLM2::customer_income_summary($this->shop_info->shop_id, Self::$customer_info->customer_id);
            $data["wallet"]             = $data["customer_summary"]["_wallet"];
            $data["points"]             = $data["customer_summary"]["_points"];
            $data["_wallet_plan"]       = $data["customer_summary"]["_wallet_plan"];
            $data["_point_plan"]        = $data["customer_summary"]["_point_plan"];
            $data["_slot"]              = MLM2::customer_slots($this->shop_info->shop_id, Self::$customer_info->customer_id);
            $data["_recent_rewards"]    = MLM2::customer_rewards($this->shop_info->shop_id, Self::$customer_info->customer_id, 5);
            $data["_direct"]            = MLM2::customer_direct($this->shop_info->shop_id, Self::$customer_info->customer_id, 5);
            $data['mlm_pin'] = '';
            $data['mlm_activation'] = '';
            
            if(MLM2::check_unused_code($this->shop_info->shop_id, Self::$customer_info->customer_id) && $this->mlm_member == false)
            {
                $data['check_unused_code'] = MLM2::check_unused_code($this->shop_info->shop_id, Self::$customer_info->customer_id);
                $data['mlm_pin'] = MLM2::get_code($data['check_unused_code'])['mlm_pin'];
                $data['mlm_activation'] = MLM2::get_code($data['check_unused_code'])['mlm_activation'];
                
                $store["temp_pin"] = $data['mlm_pin'];
                $store["temp_activation"] = $data['mlm_activation'];
                session($store);
            }
   
            $data["not_placed_slot"] = new stdClass();
            $data["not_placed_slot"]->slot_id = 0;
            $data["not_placed_slot"]->slot_no = 0;
   
            $data["_unplaced"] = MLM2::unplaced_slots($this->shop_info->shop_id, Self::$customer_info->customer_id);
            if(isset($data["_unplaced"][0]))
            {
                if($data["_unplaced"][0]->slot_placement == 0)
                {
                    $data["not_placed_yet"] = true;
                    $data["not_placed_slot"] = $data["_unplaced"][0];
                }
            }
            $data['_event'] = ShopEvent::get($this->shop_info->shop_id ,0 ,3 ,Carbon::now(), Self::$customer_info->customer_id, ['all','members']);
        }
        
        $data["item_kit_id"] = Item::get_first_assembled_kit($this->shop_info->shop_id);

        return Self::load_view_for_members('member.dashboard', $data);
    }
    public function getEventDetails(Request $request)
    {
        $data['event'] = ShopEvent::first($this->shop_info->shop_id, $request->id);

        return Self::load_view_for_members('member.view_events', $data);
    }
    public function getEventReserve(Request $request)
    {
        $data['page'] = "Reserve a Seat";
        $data['event'] = ShopEvent::first($this->shop_info->shop_id, $request->id);
        $data['action'] = '/members/event-reserve-submit';

        $data['customer_details'] = null;
        $data['customer_address'] = null;
        if(Self::$customer_info)
        {
            $customer = Customer::info(Self::$customer_info->customer_id, $this->shop_info->shop_id);
            $data['customer_details'] = $customer['customer'];
            $data['customer_address'] = $customer['shipping'];
        }
        return Self::load_view_for_members('member.event_popup_form', $data);
    }
    public function postEventReserveSubmit(Request $request)
    {
        $insert['reservee_fname']           = $request->reservee_fname;
        $insert['reservee_mname']           = $request->reservee_mname;
        $insert['reservee_lname']           = $request->reservee_lname;
        $insert['reservee_address']         = $request->reservee_address;
        $insert['reservee_contact']         = $request->reservee_contact;
        $insert['reservee_enrollers_code']  = $request->reservee_enrollers_code;

        $validate['reservee_fname']             = 'required';
        $validate['reservee_mname']             = 'required';
        $validate['reservee_lname']             = 'required';
        $validate['reservee_address']           = 'required';
        $validate['reservee_contact']           = 'required';
        $validate['reservee_enrollers_code']    = 'required';

        $validator = Validator::make($insert, $validate);

        $insert['reserve_date']  = Carbon::now();
        
        $return['status'] = null;
        $return['status_message'] = null;
        if(!$validator->fails()) 
        {
            $return_id = ShopEvent::reserved_seat($request->event_id, Self::$customer_info->customer_id, $insert);

            if(is_numeric($return_id))
            {
                $return['status'] = 'success';
                $return['call_function'] = 'success_reserve';
            }
            else
            {                
                $return['status'] = 'error';
                $return['status_message'] = $return_id;
            }
        }
        else
        {
            $message = null;
            foreach($validator->errors()->all() as $error)
            {
                $message .= "<div>" . $error . "</div>";
            }
            $return['status'] = 'error';
            $return['status_message'] = $message;
        }

        return json_encode($return);
    }
    public function getLead()
    {
        $data["page"] = "LEAD";
        $data["url"] = "http://" . $_SERVER["SERVER_NAME"];
        return view('member2.lead', $data);
    }
    public function getSlotInfo()
    {
        $slot_id            = Crypt::decrypt(request("slot_no"));
        $key                = request("key");
        $data["slot_info"]  = $slot_info = Tbl_mlm_slot::where("slot_id", $slot_id)->customer()->first();

        if(md5($slot_info->slot_id . $slot_info->slot_no) == $key)
        {
            return Self::load_view_for_members('member.slot_info', $data);   
        }
        else
        {
            return "ERROR OCCURRED";
        }
    }
    public function getAutologin()
    {
        $data["force_login"] = true;
        $data["password"] = Crypt::decrypt(request()->password);
        return view("member.autologin", $data);
    }
    public function getRequestPayout()
    {
        $data["page"] = "Request Payout";
        $data["_slot"] = MLM2::customer_slots($this->shop_info->shop_id, Self::$customer_info->customer_id);
        return view("member2.request_payout", $data);
    }
    public function postRequestPayout()
    {
        $store["request_wallet"] = request("request_wallet");
        session($store);
        return Self::payout_validation();
    }
    public function payout_validation()
    {
        $return = "";
        $_slot = MLM2::customer_slots($this->shop_info->shop_id, Self::$customer_info->customer_id);
        
        foreach($_slot as $key => $slot)
        {
            $request_amount = request("request_wallet")[$key];

            if(doubleval($slot->current_wallet) < doubleval($request_amount))
            {
                $return .= "<div>The amount you are trying to request for <b>" . $slot->slot_no . "</b> is more than the amount you currently have.</div>";
            }

            if($request_amount < 0)
            {
                $return .= "<div>The amount you are trying to request for <b>" . $slot->slot_no . "</b> is less than zero.</div>";
            }
        }

        return $return;
    }
    public function anyVerifyPayout()
    {
        $data["page"] = "Verify Payout";
        $_slot = MLM2::customer_slots($this->shop_info->shop_id, Self::$customer_info->customer_id);
        
        $payout_setting = Tbl_mlm_encashment_settings::where("shop_id", $this->shop_info->shop_id)->first();

        $tax = $payout_setting->enchasment_settings_tax;
        $service_charge = $payout_setting->enchasment_settings_p_fee;
        $other_charge = $payout_setting->encashment_settings_o_fee;
        $minimum = $payout_setting->enchasment_settings_minimum;

        $total_payout = 0;

        if(request()->isMethod("post"))
        {
            $request_method = "post";
        }
        else
        {
            $request_method = "get";
        }

        if(Self::payout_validation() == "")
        {
            $request_wallet = session("request_wallet");

            foreach($_slot as $key => $slot)
            {
                $amount = doubleval($request_wallet[$key]);

                $_slot[$key]->request_amount = $amount;
                $_slot[$key]->display_request_amount = Currency::format($amount);

                $tax_amount = ($tax / 100) * $amount;
                $take_home = $amount - ($tax_amount + $service_charge + $other_charge);

                if($take_home < 0)
                {
                    $take_home = 0;
                }

                $_slot[$key]->tax_amount = $tax_amount;
                $_slot[$key]->service_charge = $service_charge;
                $_slot[$key]->other_charge = $other_charge;
                $_slot[$key]->take_home = $take_home;

                $_slot[$key]->display_tax_amount = Currency::format($tax_amount);
                $_slot[$key]->display_service_charge = Currency::format($service_charge);
                $_slot[$key]->display_other_charge = Currency::format($other_charge);
                $_slot[$key]->display_take_home = Currency::format($take_home);

                if($take_home == 0)
                {
                    unset($_slot[$key]);
                }
                else
                {
                    if($request_method == "post")
                    {
                        $shop_id    = $this->shop_info->shop_id;
                        $customer_info = Self::$customer_info;

                        if($customer_info->customer_payout_method == "unset")
                        {
                            $method     = "cheque";
                        }
                        else
                        {
                            $method     = $customer_info->customer_payout_method;
                        }

                        $slot_id    = $slot->slot_id;
                        $remarks    = "Request by Customer";
                        $other      = 0;
                        $date       = date("m/d/Y");
                        $status     = "PENDING";

                        $slot_payout_return = MLM2::slot_payout($shop_id, $slot_id, $method, $remarks, $take_home, $tax_amount, $charge_amount, $other, $date, $status);
                    }
                }

                $total_payout += $take_home;
            }


            if($request_method == "get")
            {
                $data["total_payout"] = $total_payout;
                $data["display_total_payout"] = Currency::format($total_payout);

                $data["_slot"] = $_slot;

                return view("member2.verify_payout", $data); 
            }
        }
        else
        {
            echo "SERVER ERROR";
        }
    }
    public function getPayoutSetting()
    {
        $data["page"] = "Payout";
        $data['_slot'] = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->bank()->get();
        $data["_method"] = unserialize($this->shop_info->shop_payout_method);

        $data["_bank"] = Tbl_payout_bank::shop($this->shop_info->shop_id)->get();
        $data["tin_number"] = Self::$customer_info->tin_number;
        return view("member2.payout_settings", $data);
    }
    public function postPayoutSetting()
    {
        $shop_id = $this->shop_info->shop_id;

        /* UPDATE CUSTOMER PAYOUT METHOD */
        $update_customer["customer_payout_method"] = request("customer_payout_method");
        $update_customer["tin_number"] = request("tin_number");
        Tbl_customer::where("customer_id", Self::$customer_info->customer_id)->update($update_customer);


        /* UPDATE EON METHOD */
        foreach(request("eon_slot_code") as $key => $eon_slot_no)
        {
            $update_mlm_slot["slot_eon_account_no"] = request("eon_account_no")[$key];
            $update_mlm_slot["slot_eon_card_no"] = request("eon_card_no")[$key];
            Tbl_mlm_slot::where("shop_id", $shop_id)->where("slot_no", $eon_slot_no)->update($update_mlm_slot);
        }


        /* UPDATE BANK DETAILS */
        foreach(request("bank_slot_no") as $key => $bank_slot_no)
        {
            $slotinfo = Tbl_mlm_slot::where("shop_id", $shop_id)->where("slot_no", $bank_slot_no)->first();

            if(request("bank_id")[$key] != "")
            {
                $check_bank_exist = Tbl_mlm_slot_bank::where("slot_id", $slotinfo->slot_id)->first();

                if($check_bank_exist)
                {
                    $update_bank["payout_bank_id"] = request("bank_id")[$key];
                    $update_bank["bank_account_number"] = request("bank_account_no")[$key];
                    Tbl_mlm_slot_bank::where("slot_id", $slotinfo->slot_id)->update($update_bank);
                }
                else
                {
                    $insert_bank["slot_id"] = $slotinfo->slot_id;
                    $insert_bank["payout_bank_id"] = request("bank_id")[$key];
                    $insert_bank["bank_account_number"] = request("bank_account_no")[$key];
                    Tbl_mlm_slot_bank::insert($insert_bank);
                }
            }
        }

        echo json_encode("success");
    }

    public function getPayoutSettingSuccess()
    {
        $data["title"] = "Success!";
        $data["message"] = "Payout details has been successfully updated.";
        return view("member2.success", $data);
    }
    public static function store_login_session($email, $password)
    {
        $store["email"]         = $email;
        $store["auth"]          = $password;
        $sess["mlm_member"]     = $store;

        session($sess);
    }
    public function getLogin()
    {
        $data["page"] = "Login";
        $get_fb = FacebookGlobals::check_app_key($this->shop_info->shop_id);
        
        if($get_fb)
        {
            $data['fb_login_url'] = FacebookGlobals::get_link($this->shop_info->shop_id);
        }
        
        $get_google = GoogleGlobals::check_app_key($this->shop_info->shop_id);
        
        if($get_google)
        {
            $data['google_app_id'] = SocialNetwork::get_keys($this->shop_info->shop_id, 'googleplus')['app_id'];
        }
        $data['show_fb'] = null;
        if(request("pass") == "123")
        {
            $data['show_fb'] = 123;
        }

        return Self::load_view_for_members("member.login", $data, false);
    }
    public function postAuthCallback(Request $request)
    {
        session_start();

        $pass = isset($request->id) ? $request->id : null;
        $email = isset($request->email) ? $request->email : null;
        $client_id = '431988284265-f8brg2nuvhmmgs3l5ip8bdogj62jkidp.apps.googleusercontent.com';
        $client_secret = '1hArs-eRANIXj1uaubhajbu8';
        $redirect_uri = 'http://myphone.digimahouse.dev/member';

        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("https://www.googleapis.com/auth/plus/login");
        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");

        $plus = new Google_Service_Plus($client);
        if (isset($_REQUEST['logout'])) 
        {
            unset($_SESSION['access_token']);
        }
        if (isset($_POST['code'])) 
        {
            $client->authenticate($_POST['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) 
        {
            $client->setAccessToken($_SESSION['access_token']);
            $_SESSION['token'] = $client->getAccessToken();

        } else 
        {
            $authUrl = $client->createAuthUrl();
        }

        // if (isset($authUrl)) 
        // {
        //     print "<a class='login' href='$authUrl'><img src='logogoo/Red-signin-Medium-base-32dp.png'></a>";
        // } 
        // else 
        // {
        //     print "<a class='logout' href='pruebas.php?logout'>Cerrar:</a>";
        // }
        $correo = null;
        $me = $plus->people->get("me");
    }
    public function getSigninGoogle()
    {
        return view('signin_google');
    }
    public function postLoginGoogleSubmit(Request $request)
    {
        $pass = isset($request->id) ? $request->id : null;
        $email = isset($request->email) ? $request->email : null;

        session_start();
        $_SESSION['access_token'] = $request->access_token;

        $check = Tbl_customer::where('email',$email)->where('shop_id',$this->shop_info->shop_id)->first();
        if($check && $pass)
        {
            Self::store_login_session($email,$pass);
        }
        else
        {
            $ins['email']           = $request->email;
            $ins['first_name']      = ucfirst($request->first_name);
            $ins['last_name']       = ucfirst($request->last_name);
            $ins['password']        = Crypt::encrypt($request->id);
            $ins['mlm_username']    = $request->email;
            $ins['ismlm']           = 1;
            $ins['created_at']      = Carbon::now();
            $ins['signup_with']     = 'googleplus';

            $reg = Customer::register($this->shop_info->shop_id, $ins);  
            if($reg)
            {
                $email = $request->email;
                $pass = $request->id;
                Self::store_login_session($email,$pass);
            }             
        }

        echo json_encode("success");
    }
    public function getLoginSubmit()
    {
        $user_profile = FacebookGlobals::user_profile($this->shop_info->shop_id);
        $email = isset($user_profile['email']) ? $user_profile['email'] : null;
        $check = Tbl_customer::where('email',$email)->where('shop_id', $this->shop_info->shop_id)->first();

        $data = collect($user_profile)->toArray();

        if(count($user_profile) > 0 && $check && isset($data['email']) && isset($data['id']))
        {
            Self::store_login_session($data['email'],$data['id']);

            return Redirect::to("/members")->send();
        }
        else
        {
            return Redirect::to('/members/register');                
        }
    }
    public function postLogin(Request $request)
    {
        $validate["email"]      = ["required"];
        $validate["password"]   = ["required"];
        $data                   = $this->validate(request(), $validate);
        
        $email = Tbl_mlm_slot::where("slot_no", $data["email"])->customer()->value('email');
        
        if($email)
        {
            $data["email"] = $email;
        }

        Self::store_login_session($data["email"], $data["password"]);

        return Redirect::to("/members")->send();
    }
    public function getLogout()
    {
        session()->forget("mlm_member");
        GoogleGlobals::revoke_access($this->shop_info->shop_id);

        return Redirect::to("/members/login");
    }
    public function getRegister()
    {
        $data["page"] = "Register";
        $get = FacebookGlobals::check_app_key($this->shop_info->shop_id);
        
        if($get)
        {
            $data['fb_login_url'] = FacebookGlobals::get_link_register($this->shop_info->shop_id);
        }
        
        if(request("d") == 1)
        {
            $dummy["email"] = strtolower(randomPassword()) . "@gmail.com";
            $dummy["first_name"] = ucfirst(randomPassword());
            $dummy["last_name"] = ucfirst(randomPassword());
            $dummy["middle_name"] = ucfirst(randomPassword());
            $dummy["contact"] = ucfirst(randomPassword()) . ucfirst(randomPassword());
            $dummy["password"] = ucfirst(randomPassword());
            $data["dummy"] = $dummy;
        }
        
        return Self::load_view_for_members("member.register", $data, false);
    }

    public function getRegisterSubmit()
    {
        $user_profile = FacebookGlobals::user_profile($this->shop_info->shop_id);

        if(count($user_profile) > 0)
        {
            $data = collect($user_profile)->toArray();
            $email = isset($data['email']) ? $data['email'] : '';
            $pass = $data['id'];
            $check = Tbl_customer::where('email',$email)->where('shop_id',$this->shop_info->shop_id)->first();

            $ins['email'] = $email;

            $rules['email'] = 'required';

            $validator = Validator::make($ins, $rules);

            if($validator->fails()) 
            {
                $messages = $validator->messages();
                return Redirect::to('/members/register')->with('error', 'We need your email address for you to register.');
            }
            else
            {    
                if(!$check)
                {
                    $ins['first_name']      = $data['first_name'];
                    $ins['last_name']       = $data['last_name'];
                    $ins['middle_name']     = $data['middle_name'] == null ? '' : $data['middle_name'] ;
                    $ins['gender']          = $data['gender'] == null ? 'male' : $data['gender'];
                    $ins['password']        = Crypt::encrypt($data['id']);
                    $ins['mlm_username']    = $data['email'];
                    $ins['ismlm']           = 1;
                    $ins['created_at']      = Carbon::now();
                    $ins['signup_with']     = 'facebook';
                    
                    Customer::register($this->shop_info->shop_id, $ins);  
                }
                else
                {
                    $email = $check->email;
                    $pass = Crypt::decrypt($check->password);
                }

                if($email && $pass)
                {
                    Self::store_login_session($email,$pass);

                    return Redirect::to("/members")->send();
                }
            }   
        }
        else
        {
            return Redirect::to("/members/register")->send();               
        }
    }
    public function postRegister(Request $request)
    {
        $shop_id                                = $this->shop_info->shop_id;
        $validate["first_name"]                 = ["required", "string", "min:2"];
        $validate["middle_name"]                = "";
        $validate["last_name"]                  = ["required", "string", "min:2"];
        $validate["gender"]                     = ["required"];
        $validate["contact"]                    = ["required", "string", "min:10"];
        $validate["email"]                      = ["required","min:5","email", new Uniqueonshop("tbl_customer", $shop_id)];
        $validate["b_day"]                      = ["required","integer"];
        $validate["b_month"]                    = ["required","integer"];
        $validate["b_year"]                     = ["required","integer"];
        $validate["password"]                   = ["required", "confirmed","min:5"];
        $validate["password_confirmation "]     = [];

        $insert                                 = $this->validate(request(), $validate);
        $raw_password                           = $insert["password"];
        $insert["birthday"]                     = $insert["b_month"] . "/" . $insert["b_day"] . "/" . $insert["b_year"];
        $insert["password"]                     = Crypt::encrypt($insert["password"]);
        $insert["created_at"]                   = Carbon::now();

        unset($insert["b_month"]);
        unset($insert["b_year"]);
        unset($insert["b_day"]);

        if(Customer::register($this->shop_info->shop_id, $insert))
        {
            Self::store_login_session($insert["email"], $raw_password);
        }

        if(session("checkout_after_register"))
        {
            session()->forget("checkout_after_register");
            return Redirect::to("/members/checkout")->send();
        }
        else
        {
            return Redirect::to("/members")->send();
        }
    }

    public function getForgotPassword()
    {
        $data["page"] = "Forgot Password";
        return view("member.forgot_password");
    }
    public function postForgotPasswordSubmit()
    {
        $shop_id = $this->shop_info->shop_id;
        $validate = Customer::check_email($shop_id, Request2::input('email'));
        
        $return_data = null;
        if($validate)
        {
            if($validate->signup_with != 'member_register')
            {
                $return_data['status'] = 'danger';
                $return_data['status_message'] = "We're not able forgot password when your account was sign up with Facebook or Google+";
            }
            else
            {               
                $content_key = "front_forgot_password";
                if(EmailContent::checkIfexisting($content_key, $shop_id) != 0)
                {
                    $email_content["subject"] = EmailContent::getSubject($content_key, $shop_id);
                    $email_content["shop_key"] = $this->shop_info->shop_key;
                    $data["email"] = $validate->email;
                    $new_password = Crypt::decrypt($validate->password);

                    $txt[0]["txt_to_be_replace"] = "[name]";
                    $txt[0]["txt_to_replace"] = $validate->first_name." ".$validate->middle_name." ".$validate->last_name;

                    $txt[1]["txt_to_be_replace"] = "[domain_name]";
                    $txt[1]["txt_to_replace"] = $_SERVER["SERVER_NAME"];

                    $txt[2]["txt_to_be_replace"] = "[password]";
                    $txt[2]["txt_to_replace"] = $new_password;

                    $change_content = $txt;

                    $email_content["content"] = EmailContent::email_txt_replace($content_key, $change_content, $shop_id);

                    $data["template"] = Tbl_email_template::where("shop_id", $shop_id)->first();
                    if(isset($data['template']->header_image))
                    {
                        if (!File::exists(public_path() . $data['template']->header_image))
                        {
                            $data['template']->header_image = null;
                        }
                    }   

                    Mail_global::send_email($data['template'], $email_content, $shop_id, $validate->email);


                    $return_data['status'] = 'success';
                    $return_data['status_message'] = "Successfully Sent Email.";
                }
                else
                {
                    $return_data['status'] = 'danger';
                    $return_data['status_message'] = "Something wen't wrong please contact your admin.";
                } 
            }
        }
        else
        {
            $return_data['status'] = 'danger';
            $return_data['status_message'] = "Can't find your record.";
        }

        return Redirect::back()->with($return_data['status'], $return_data['status_message']);
    }
    /* LOGIN AND REGISTRATION - END */
    public function getProfile()
    {
        $data["page"]                = "Profile";
        $data["mlm"]                 = isset(Self::$customer_info->ismlm) ? Self::$customer_info->ismlm : 0;
        $data["profile"]             = Tbl_customer::shop(Self::$customer_info->shop_id)->where("tbl_customer.customer_id", Self::$customer_info->customer_id)->first();
        $data["profile_address"]     = Tbl_customer_address::where("customer_id", Self::$customer_info->customer_id)->where("purpose", "permanent")->first();
        $data["profile_info"]        = Tbl_customer_other_info::where("customer_id", Self::$customer_info->customer_id)->first();
        $data["_country"]            = Tbl_country::get();
        $data["_locale"]             = Tbl_locale::where("locale_parent", 0)->orderBy("locale_name", "asc")->get();
        $data["allowed_change_pass"] = isset(Self::$customer_info->signup_with) ? (Self::$customer_info->signup_with == "member_register" ? true : false) : false;

        $data['beneficiary'] = null;
        if(Self::$customer_info)
        {
            $data["customer_summary"]   = MLM2::customer_income_summary($this->shop_info->shop_id, Self::$customer_info->customer_id);
            $data["wallet"]             = $data["customer_summary"]["_wallet"];

            $data['beneficiary'] = CustomerBeneficiary::first(Self::$customer_info->customer_id);
        }


        // $data["allowed_change_pass"] = true;

        return (Self::load_view_for_members("member.profile", $data));
    }
    public function postProfileUpdateInfo(Request $request)
    {
        $form = $request->all();
        // $validate['first_name'] = 'required';
        // $validate['middle_name'] = 'required';
        // $validate['last_name'] = 'required';
        // $validate['b_month'] = 'required';
        // $validate['b_day'] = 'required';
        // $validate['b_year'] = 'required';
        $validate['country_id'] = 'required';
        // $validate['customer_state'] = 'required';
        // $validate['customer_city'] = 'required';
        // $validate['customer_zipcode'] = 'required';
        $validate['customer_street'] = 'required';

        $validator = Validator::make($form, $validate);
        
        if (!$validator->fails()) 
        {           
            /* Birthday Fix */
            if ($request->birthdate) 
            {
                $birthday = date("Y-m-d", strtotime($request->birthdate));
            }
            else
            {
                $birthday = date("Y-m-d", strtotime($request->b_month . "/" . $request->b_day . "/" . $request->b_year)); 
            }
            
            /* Customer Data */
            if($request->first_name)
            {
                $insert_customer["first_name"]  = $request->first_name;
            }
            
            if ($request->middle_name) 
            {
                $insert_customer["middle_name"] = $request->middle_name;
            }

            if ($request->last_name) 
            {
                $insert_customer["last_name"]   = $request->last_name;
            }
            
            $insert_customer["b_day"]       = $birthday;
            $insert_customer["birthday"]    = $birthday;
            $insert_customer["country_id"]  = $request->country_id;
            $insert_customer["updated_at"]  = Carbon::now();

            Tbl_customer::where("customer_id", Self::$customer_info->customer_id)
                        ->shop(Self::$customer_info->shop_id)
                        ->update($insert_customer);

            /* Customer Address */
            $state_name    = Tbl_locale::where("locale_id", $request->customer_state)->first();
            $city_name     = Tbl_locale::where("locale_id", $request->customer_city)->first();
            $barangay_name = Tbl_locale::where("locale_id", $request->customer_zipcode)->first();

            $insert_customer_address["country_id"] = $request->country_id;
            $insert_customer_address["customer_state"] = isset($state_name) ? $state_name->locale_name : '';
            $insert_customer_address["customer_city"] = isset($city_name)  ? $city_name->locale_name : '';
            $insert_customer_address["customer_zipcode"] = isset($barangay_name) ? $barangay_name->locale_name : '';
            $insert_customer_address["customer_street"] = $request->customer_street;
            $insert_customer_address["state_id"] = $request->customer_state;
            $insert_customer_address["city_id"] = $request->customer_city;
            $insert_customer_address["barangay_id"] = $request->customer_zipcode;
            
            $exist = Tbl_customer_address::where("customer_id", Self::$customer_info->customer_id)->where("purpose", "permanent")->first();
            
            if ($exist) 
            {
                /* Update */
                $insert_customer_address["updated_at"] = Carbon::now();
                
                Tbl_customer_address::where("customer_id", Self::$customer_info->customer_id)->where("purpose", "permanent")->update($insert_customer_address);
            }
            else
            {
                /* Insert */
                $insert_customer_address["created_at"] = Carbon::now();
                $insert_customer_address["customer_id"] = Self::$customer_info->customer_id;
                $insert_customer_address["purpose"] = "permanent";
                
                Tbl_customer_address::insert($insert_customer_address);
            }
            
            echo json_encode("success");
        }
        else
        {
            $result = $validator->errors();
            echo json_encode($result);
        }
    }
    public function postProfileUpdateBeneficiary(Request $request)
    {
        $form = $request->all();
        $validate['beneficiary_fname']       = 'required';
        $validate['beneficiary_mname']       = 'required';
        $validate['beneficiary_lname']       = 'required';
        $validate['beneficiary_contact_no']  = 'required|numeric';
        $validate['beneficiary_email']       = 'required|email';

        $validator = Validator::make($form, $validate);
        
        if(!$validator->fails()) 
        {
            $update['beneficiary_fname']       = $request->beneficiary_fname;
            $update['beneficiary_mname']       = $request->beneficiary_mname;
            $update['beneficiary_lname']       = $request->beneficiary_lname;
            $update['beneficiary_contact_no']  = $request->beneficiary_contact_no;
            $update['beneficiary_email']       = $request->beneficiary_email;

            $beneficiary_id = CustomerBeneficiary::create(Self::$customer_info->customer_id, $update);

            if(is_numeric($beneficiary_id))
            {
                echo json_encode("success");
            }
        }
        else
        {
            $result = $validator->errors();
            echo json_encode($result);
        }
    }
    public function postProfileUpdateReward(Request $request)
    {
        $update_customer["downline_rule"] = $request->downline_rule;
        Tbl_customer::where("customer_id", Self::$customer_info->customer_id)->update($update_customer);
        echo json_encode("success");
    }
    public function postProfileUpdatePicture(Request $request)
    {
        $customer_id = $request->customer_id;
        $input = $request->all();
        $rules = array('profile_image' => 'required|mimes:jpeg,png,gif,bmp');
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
            $file = Input::file("profile_image");
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

                /* RESIZE IMAGE */
                $upload_success    = Image::make(Input::file('profile_image'))->fit(250, 250)->save($destinationPath."/".$filename);;

                /* SAVE THE IMAGE PATH IN THE DATABASE */
                $image_path = $destinationPath."/".$filename;

                if( $upload_success ) 
                {
                   $exist = Tbl_customer::where("customer_id", $customer_id)->first();
                   if (isset($exist->profile) && $exist->profile) 
                   {
                       $delete_file = $exist->profile;
                       File::delete($delete_file);
                   }

                   $update['profile'] = $image_path;
                   Tbl_customer::where("customer_id", $customer_id)->where("shop_id", $this->shop_info->shop_id)->update($update);

                   echo json_encode("success");
                } 
                else 
                {
                   echo json_encode("failed");
                }
            }
        }
    }
    public function postProfileUpdatePassword(Request $request)
    {
        $form = $request->all();

        $old = $request->old_password;
        $new = Crypt::decrypt(Tbl_customer::where("customer_id", Self::$customer_info->customer_id)->where("shop_id", $this->shop_info->shop_id)->value("password"));

        if ($old == $new) 
        {
            $validate['password'] = 'required|confirmed|min:6';
            $validator = Validator::make($form, $validate);
            
            if (!$validator->fails()) 
            {           
                $insert_customer["password"]  = Crypt::encrypt($request->password);

                Tbl_customer::where("customer_id", Self::$customer_info->customer_id)
                            ->shop(Self::$customer_info->shop_id)
                            ->update($insert_customer);

                $email = Tbl_customer::where("customer_id", Self::$customer_info->customer_id)
                            ->shop(Self::$customer_info->shop_id)
                            ->value('email');

                $pass = $request->password;

                Self::store_login_session($email,$pass);
                
                echo json_encode("success");
            }
            else
            {
                $result = $validator->errors();
                echo json_encode($result);
            }
        }
        else
        {
            $result[0] = "Old password mismatched.";
            echo json_encode($result);
        }
    }
    public function getNotification()
    {
        $data["page"] = "Notification";
        $data["_rewards"]    = MLM2::customer_rewards($this->shop_info->shop_id, Self::$customer_info->customer_id, 5);
        return (Self::load_view_for_members("member.notification", $data));
    }
    public function getGenealogy(Request $request)
    {
        $data["page"] = "Genealogy";
        $data['_slot'] = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->get();
        $slot = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->first();
        $data['slot_no'] = 0;
        $data['mode'] = 'sponsor';
        
        if($slot)
        {
            $data['slot_no'] = $slot->slot_no;
            $data['mode'] = $request->mode;
        }

        return (Self::load_view_for_members("member.genealogy", $data));
    }
    public function getGenealogyTree(Request $request)
    {
        $slot_no  = $request->slot_no;
        $shop_id  = $this->shop_info->shop_id;
        $mode = $request->mode;
        $check = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->where('slot_no',$slot_no)->where('shop_id',$shop_id)->first();

        if($check)
        {
            $data = MemberSlotGenealogy::tree($shop_id, $check->slot_id, $mode);
            return Self::load_view_for_members('member.genealogy_tree', $data);            
        }
        else
        {
            die('Invalid slot!');
        }
    }
    public function getGenealogyDownline(Request $request)
    {
        $data = MemberSlotGenealogy::downline($request->x, $request->mode);
        return $data;
    }
    public function getNetwork()
    {
        $data["page"] = "Network List";
        $data['_slot'] = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->get();

        if(request()->input("slot_no") == "")
        {
            $slot_no = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->value("slot_no");
            return Redirect::to("/members/network?slot_no=" . $slot_no);
        }
        else
        {
            $data["_tree_level"] = MLM2::get_sponsor_network_tree($this->shop_info->shop_id, request()->input("slot_no"));
            return (Self::load_view_for_members("member.network", $data));
        }
    }
    public function getNetworkSlot()
    {
        $data["page"] = "Network List";
        $data['_slot'] = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->get();

        if(request()->input("slot_no") == "")
        {
            $slot_no = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->value("slot_no");
            return Redirect::to("/members/network?slot_no=" . $slot_no);
        }
        else
        {
            $data["_tree"] = MLM2::get_sponsor_network($this->shop_info->shop_id, request()->input("slot_no"), request('level'));
            return (Self::load_view_for_members("member.network_slot", $data));
        }
    }
    public function getReport()
    {
        $data["page"]           = "Report";
        $data["_rewards"]       = MLM2::customer_rewards($this->shop_info->shop_id, Self::$customer_info->customer_id, 0);
        $data["_codes"]         = MLM2::check_purchased_code($this->shop_info->shop_id, Self::$customer_info->customer_id);
        return (Self::load_view_for_members("member.report", $data));
    }
    public function getLeadList()
    {
        $data["page"]       = "Lead List";
        $shop_id            = $this->shop_info->shop_id;
        $_slot              = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->get();
        
        $query              = Tbl_customer::where("shop_id", $shop_id);

        if(count($_slot) > 0)
        {
    		$query->where(function($q) use ($_slot)
    		{
    			foreach($_slot as $slot)
    			{
    				$q->orWhere("customer_lead", $slot->slot_id);
    			}
    		});
        }
        else
        {
            $query->where("customer_lead", "-1");
        }
        

        $data["_lead"]      = $query->get();
        
        return (Self::load_view_for_members("member.lead", $data)); 
    }
    public function getWalletLogs()
    {
        $data["page"] = "Wallet Logs";
        return (Self::load_view_for_members("member.wallet_logs", $data));
    }
    public function getWalletEncashment()
    {
        $data["page"]           = "Wallet Encashment";
        $data["_encashment"]    = MLM2::customer_payout($this->shop_info->shop_id, Self::$customer_info->customer_id, 0);
        $total_payout           = MLM2::customer_total_payout(Self::$customer_info->customer_id);
        $data["total_payout"]   = Currency::format($total_payout);
        return (Self::load_view_for_members("member.wallet_encashment", $data));
    }
    public function getSlot()
    {
        $data["page"] = "Slot";
        return (Self::load_view_for_members("member.slot", $data));
    }
    public function getEonCard()
    {
        $data["page"] = "Eon Card";
        return (Self::load_view_for_members("member.eon_card", $data));
    }
    public function getOrder()
    {
        $data["page"] = "Orders";
        $shop_id = $this->shop_info->shop_id;
        Transaction::get_transaction_filter_customer(Self::$customer_info->customer_id);
        $data["_order"] = Transaction::get_transaction_list($shop_id, 'ORDER', '', 20);
        return (Self::load_view_for_members("member.order", $data));
    }
    public function getOrderDetails(Request $request, $transaction_list_id)
    {
        $data['shop_key'] = strtoupper($this->shop_info->shop_key);
        $data['shop_address'] = ucwords($this->shop_info->shop_street_address.' '.$this->shop_info->shop_city.', '.$this->shop_info->shop_zip);
        Transaction::get_transaction_filter_customer(Self::$customer_info->customer_id);
        $data['list'] = Tbl_transaction_list::transaction()->where('transaction_list_id',$transaction_list_id);
        
        if(session('get_transaction_filter_customer_id'))
        {
            $data['list']->where('transaction_reference_table', 'tbl_customer')->where('tbl_transaction.transaction_reference_id', session('get_transaction_filter_customer_id'));
            $data['list']->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_transaction.transaction_reference_id');
        }
        $data['list'] = $data['list']->first();
        $data['_item'] = Tbl_transaction_item::where('transaction_list_id',$transaction_list_id)->get();
        $data['customer_name'] = Transaction::getCustomerNameTransaction($data['list']->transaction_id);
        
        return (Self::load_view_for_members("member.order_details", $data));
    }
    public function getWishlist()
    {
        $data["page"] = "Wishlist";
        return (Self::load_view_for_members("member.wishlist", $data));
    }
    public function getCheckout()
    {
        $data["page"]       = "Checkout";
        $shop_id            = $this->shop_info->shop_id;
        $data["_payment"]   = $_payment = Payment::get_list($shop_id);
        $data["_locale"]    = Tbl_locale::where("locale_parent", 0)->orderBy("locale_name", "asc")->get();
        $data["cart"]       = Cart2::get_cart_info();
        
        if(!Self::$customer_info)
        {
            $store["checkout_after_register"] = true;
            session($store);
            return redirect("/members/register");
        }
        else
        {
            return (Self::load_view_for_members("member.checkout", $data)); 
        }

        
    }
    public function postCheckout()
    {
        /* Update Address */
        $exist_address = Tbl_customer_address::where("customer_id", Self::$customer_info->customer_id)->first();
        if ($exist_address) 
        {
            $update["customer_street"] = request('customer_street');
            Tbl_customer_address::where("customer_id", Self::$customer_info->customer_id)->update($update);
        }
        else
        {
            $insert["customer_street"] = request('customer_street');
            $insert["customer_id"] = Self::$customer_info->customer_id;
            $insert["country_id"] = 420;
            $insert["purpose"] = "billing";
            $insert["archived"] = 0;
            Tbl_customer_address::insert($insert);
            $insert["purpose"] = "shipping";
            Tbl_customer_address::insert($insert);
        }
        
        $method                                             = request('method');
        $shop_id                                            = $this->shop_info->shop_id;
        $transaction_new["transaction_reference_table"]     = "tbl_customer";
        $transaction_new["transaction_reference_id"]        = Self::$customer_info->customer_id;
        $transaction_type                                   = "ORDER";
        $transaction_date                                   = Carbon::now();
        
        Transaction::create_set_method($method);
        $transaction_list_id                                = Transaction::create($shop_id, $transaction_new, $transaction_type, $transaction_date, "-");

        if(is_numeric($transaction_list_id))
        {
            $success    = "/members?success=1"; //redirect if payment success
            $failed     = "/members?failed=1"; //redirect if payment failed
            $error      = Payment::payment_redirect($shop_id, $method, $transaction_list_id, $success, $failed);
        }
        else
        {
            return Redirect::to("/members/checkout")->with("error", "Your cart is empty.");
        }
    }
    public function getNonMember()
    {
        $data["page"] = "NonMember";
        return (Self::load_view_for_members("member.nonmember", $data));
    }
    public function getTest($method)
    {
        $shop_id    = $this->shop_info->shop_id; //tbl_shop
        $key        = $method; //link reference name
        $success    = "/members?success=1"; //redirect if payment success
        $failed     = "/members?failed=1"; //redirect if payment failed
        $debug      = true;

        $error = Payment::payment_redirect($shop_id, $key, $success, $failed, $debug);
    }
    public function getVmoney()
    {
        $slot = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->first();
        $data["page"] = "V-Money";

        if ($slot) 
        {
            $data["wallet"] = Mlm_slot_log::get_sum_wallet(isset($slot->slot_id) ? $slot->slot_id : 0);
        }
        else
        {
            $data["wallet"] = 0;
        }

        $data["minimum"] = isset(DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_minimum_encashment")->first()->settings_value) ? DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_minimum_encashment")->first()->settings_value : 0;
        $data["percent"] = isset(DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_percent_fee")->first()->settings_value) ? DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_percent_fee")->first()->settings_value : 0;
        $data["fixed"] = isset(DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_fixed_fee")->first()->settings_value) ? DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_fixed_fee")->first()->settings_value : 0;

        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.vmoney", $data));
    }
    public function postVmoney(Request $request)
    {
        $slot_get = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->first();
        $slot_id  = isset($slot_get->slot_id) ? $slot_get->slot_id : 0;

        if ($slot_id) 
        {
            /* Fee */
            $current_wallet     = $request->wallet_amount;
            $fixed              = isset(DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_fixed_fee")->first()->settings_value) ? DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_fixed_fee")->first()->settings_value : 0;
            $percent            = isset(DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_percent_fee")->first()->settings_value) ? DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_percent_fee")->first()->settings_value : 0;
            $percent_value      = ($percent / 100) * $current_wallet;
            $convenience_fee    = $fixed + $percent_value; 
            $total_fee          = $current_wallet + $convenience_fee;
            $slot               = DB::table("tbl_mlm_slot")->where("slot_id", $slot_id)->first();
            $wallet             = Mlm_slot_log::get_sum_wallet($slot->slot_id);
            $minimum_encashment = isset(DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_minimum_encashment")->first()->settings_value) ? DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_minimum_encashment")->first()->settings_value : 0;
            
            if (isset($slot) && $slot) 
            {
                if ($minimum_encashment <= $request->wallet_amount) 
                {
                    if ($wallet > $request->wallet_amount) 
                    {
                        if ($request->vmoney_email) 
                        {
                            if($request->wallet_amount)
                            {   
                                /* API */
                                $post = 'mxtransfer.svc';
                                /* $environment = isset(DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_environment")->first()->settings_value) ? DB::table("tbl_settings")->where("shop_id", $this->shop_info->shop_id)->where("settings_key", "vmoney_environment")->first()->settings_value : 0; */
                                if (get_domain() == "philtechglobalinc.com") 
                                {
                                    $environment = 1;
                                }
                                else
                                {
                                    $environment = 0;
                                }

                                /* Sandbox */
                                if ($environment == 0) 
                                {
                                    $pass["apiKey"] = 'Vqzs90pKLb6iwsGQhnRS'; // Vendor API Key issued by VMoney
                                    $pass["merchantId"] = 'M239658948226'; // Merchant ID registered within VMoney
                                    /* Set URL Sandbox or Live */
                                    $url = "http://test.vmoney.com/gtcvbankmerchant/";
                                }
                                /* Production */
                                else
                                {
                                    $pass["apiKey"] = 'z9Gy1dBbnyj9cxMqXSKF'; // Vendor API Key issued by VMoney
                                    $pass["merchantId"] = 'M132582139240'; // Merchant ID registered within VMoney
                                    /* Set URL Sandbox or Live */
                                    $url = "https://philtechglobalinc.vmoney.com/gtcvbankmerchant/";
                                }

                                $pass["recipient"] = $request->vmoney_email; // Recipient's email address
                                $pass["merchantRef"] = Self::$customer_info->customer_id . time(); // Merchant reference number
                                $pass["amount"] = $request->wallet_amount; // Amount of the transaction
                                $pass["currency"] = 'PHP'; // Currency being transferred (ie PHP)
                                $pass["message"] = 'Philtech VMoney Wallet Transfer'; // Memo or notes for transaction

                                $post_params = $url . $post . "?" . http_build_query($pass);

                                try 
                                {
                                    $client = new Client();
                                    $response = $client->post($post_params, $pass);
                                    $stream = $response->getBody();
                                    $contents = $stream->getContents(); // returns all the contents
                                    $contents = $stream->getContents(); // empty string
                                    $stream->rewind(); // Seek to the beginning
                                    $contents = $stream->getContents(); // returns all the contents
                                    $data_decoded = json_decode($contents);

                                    /* Result */
                                    if ($data_decoded->resultCode == "000") 
                                    {   
                                        $data_a['status'] = "success";
                                        $logs["status"] = 1;

                                        $arry_log['wallet_log_slot'] = $slot->slot_id;
                                        $arry_log['shop_id'] = $slot->shop_id;
                                        $arry_log['wallet_log_slot_sponsor'] = $slot->slot_id;
                                        $arry_log['wallet_log_details'] = 'You have transferred ' . $current_wallet . ' To your E-Money. ' . $total_fee . ' is deducted to your wallet including tax and convenience fee.';
                                        $arry_log['wallet_log_amount'] = -($total_fee);
                                        $arry_log['wallet_log_plan'] = "E_MONEY";
                                        $arry_log['wallet_log_status'] = "released";   
                                        $arry_log['wallet_log_claimbale_on'] = Carbon::now();

                                        Mlm_slot_log::slot_array($arry_log);
                                    }
                                    else
                                    {
                                        $data_a['status'] = "error";
                                        $logs["status"] = 0;
                                    }
                                    
                                    $data_a['message'] = $data_decoded->resultMsg;

                                    $logs["vmoney_wallet_logs_date"] = Carbon::now();
                                    $logs["vmoney_wallet_logs_email"] = $request->vmoney_email;
                                    $logs["vmoney_wallet_logs_amount"] = $current_wallet;
                                    $logs["customer_id"] = Self::$customer_info->customer_id;
                                    $logs["txnId"] = isset($data_decoded->txnId) ? $data_decoded->txnId : "None";
                                    $logs["merchantRef"] = isset($data_decoded->merchantRef) ? $data_decoded->merchantRef : "None";
                                    $logs["message"] = isset($data_decoded->resultMsg) ? $data_decoded->resultMsg : "None";
                                    $logs["fee"] = $fixed;
                                    $logs["tax"] = $percent_value;
                                    Tbl_vmoney_wallet_logs::insert($logs);
                                } 
                                catch (\Exception $e) 
                                {
                                    $data_a['status'] = "error";
                                    $data_a['message'] = 'Caught exception: ' .  $e->getMessage();    
                                }
                            }
                            else
                            {
                                $data_a['status'] = "error";
                                $data_a['message'] = "Wallet Amount is required";  
                            }
                        }
                        else
                        {
                            $data_a['status'] = "error";
                            $data_a['message'] = "Email Recipient is required";   
                        }
                    }
                    else
                    {
                        $data_a['status'] = "error";
                        $data_a['message'] = "Not enough wallet";   
                    }
                }
                else
                {
                    $data_a['status'] = "error";
                    $data_a['message'] = "The minimum_encashment is PHP. " . number_format($minimum_encashment, 2);   
                }
            }
            else
            {
                $data_a['status'] = "error";
                $data_a['message'] = "No slot";   
            }
        
            return Redirect::back()->with("result", $data_a);
        }
    }

    /* AJAX */
    public function postVerifySponsor(Request $request)
    {
        $shop_id                = $this->shop_info->shop_id;
        $sponsor                = MLM2::verify_sponsor($shop_id, $request->verify_sponsor);
        if(!$sponsor)
        {
            if($request->verify_sponsor == "")
            {
                $return = "<div class='error-message'>The sponsor you entered is <b>BLANK</b>.</div>";
            }
            else
            {
                $return = "<div class='error-message'>We can't find sponsor \"<b>" . $request->verify_sponsor . "</b>\".<br>Please check carefully if you have the right details.</div>";
            }
        }
        else
        {
            $sponsor_have_placement = MLM2::check_sponsor_have_placement($shop_id,$sponsor->slot_id);
            
            if($sponsor_have_placement == 0)
            {
                $return = "<div class='error-message'>Sponsor \"<b>" . $request->verify_sponsor . "</b>\".<br>should have a placement first.</div>";
            }
            else
            {    
                $data["page"]                   = "CARD";
                $data["sponsor"]                = $sponsor; 
                $data["sponsor_customer"]       = Customer::get_info($shop_id, $sponsor->slot_owner);
                $data["sponsor_profile_image"]  = $data["sponsor_customer"]->profile == "" ? "/themes/brown/img/user-placeholder.png" : $data["sponsor_customer"]->profile;
                
                $store["sponsor"] = $sponsor->slot_no;
                
                session($store);

                $return = (Self::load_view_for_members("member.card", $data));
            }
        }

        return $return;
    }
    public function postVerifyCode(Request $request)
    {
        $shop_id                                = $this->shop_info->shop_id;
        $validate["pin"]                        = ["required", "string", "alpha_dash"];
        $validate["activation"]                 = ["required", "string", "alpha_dash"];
        $validator                              = Validator::make($request->all(), $validate);

        $message = "";

        if($validator->fails())
        {
            foreach($validator->errors()->all() as $error)
            {
                $message .= "<div>" . $error . "</div>";
            }
        }
        else
        {
            $activation             = request("activation");
            $pin                    = request("pin");
            $check_membership_code  = MLM2::check_membership_code($shop_id, $pin, $activation);

            if(!$check_membership_code)
            {
                $message = "Invalid PIN / ACTIVATION!";
            }
            else
            {
                if($check_membership_code->mlm_slot_id_created != "")
                {
                    $message = "PIN / ACTIVATION ALREADY USED";
                }
                else
                {
                    $store["temp_pin"] = $pin;
                    $store["temp_activation"] = $activation;
                    session($store);
                }
            }
        }

        echo $message;
    }

    public function code_verification()
    {
        $shop_id                    = $this->shop_info->shop_id;
        $data["sponsor"]            = session('sponsor');
        $data["sponsor"]            = $sponsor = MLM2::verify_sponsor($shop_id, $data["sponsor"]);
        $data["sponsor_customer"]   = Customer::get_info($shop_id, $sponsor->slot_owner);
        $data["pin"]                = session('temp_pin');
        $data["activation"]         = session('temp_activation');
        $data["membership_code"]    = MLM2::check_membership_code($shop_id, $data["pin"], $data["activation"]);

        if($data["sponsor"] && $data["membership_code"])
        {
            if($data["membership_code"]->mlm_slot_id_created != "")
            {
                return false;
            }
            else
            {
                return $data;
            }
        }
        else
        {
            return false;
        }
    }
    public function postVerifySlotPlacement(Request $request)
    {
        $shop_id         = $this->shop_info->shop_id;
        $slot_id         = $request->slot_id;
        $slot_placement  = $request->slot_placement;
        $slot_position   = $request->slot_position;

        $slot_placement  = Tbl_mlm_slot::where("slot_no",$slot_placement)->where("shop_id",$shop_id)->first() ? Tbl_mlm_slot::where("slot_no",$slot_placement)->where("shop_id",$shop_id)->first()->slot_id : null;


        $data            = $this->check_placement($slot_id,$slot_placement,$slot_position);
        $procceed        = $data["procceed"];
        $message         = $data["message"];

        if($procceed == 1)
        {
            echo json_encode('success');
        }
        else
        {
            echo json_encode($message); 
        }
    }
    public function getFinalVerifyPlacement(Request $request)
    {
        $shop_id         = $this->shop_info->shop_id;
        $slot_id         = $request->slot_id;
        $slot_placement  = $request->slot_placement;
        $slot_position   = $request->slot_position;

        $slot_placement  = Tbl_mlm_slot::where("slot_no",$slot_placement)->where("shop_id",$shop_id)->first() ? Tbl_mlm_slot::where("slot_no",$slot_placement)->where("shop_id",$shop_id)->first()->slot_id : null;

        $data            = $this->check_placement($slot_id,$slot_placement,$slot_position);
        $procceed        = $data["procceed"];
        
        if($procceed == 1)
        {
            return Self::load_view_for_members('member2.final_verification_placement', $data);
        }
    }    
    public function postFinalVerifyPlacement(Request $request)
    {
        $shop_id         = $this->shop_info->shop_id;
        $slot_id         = $request->slot_id;
        $slot_placement  = $request->slot_placement;
        $slot_position   = $request->slot_position;
        $customer_id     = Self::$customer_info->customer_id;
        $data            = $this->check_placement($slot_id,$slot_placement,$slot_position);
        $procceed        = $data["procceed"];
        
        if($procceed == 1)
        {
            $return = MLM2::matrix_position($shop_id, $slot_id, $slot_placement, $slot_position);
            
            if($return == "success")
            {
                $slot_info_e = Tbl_mlm_slot::where('slot_id', $slot_id)->first();
                
                Mlm_tree::insert_tree_sponsor($slot_info_e, $slot_info_e, 1); 
           		Mlm_tree::insert_tree_placement($slot_info_e, $slot_info_e, 1);
           		MLM2::entry($shop_id,$slot_id);
                
                echo json_encode("success");
            }
            else if($return == "Placement Error")
            {
               echo json_encode("Target placement cannot be used.");
            }
            else
            {
               echo json_encode($return);  
            }
        }
        else
        {
            echo json_encode("Placement does not exists.");
        }
    }
    public function getEnterCode()
    {
        $data["page"] = "Enter Sponsor";
        $data["message"] = "Enter <b>Slot Code</b> of your <b>Sponsor</b>";
        return Self::load_view_for_members('member2.enter_code', $data);
    }
    public function getEnterSponsor()
    {
        $data["page"] = "Enter Code";
        $data["message"] = "Enter <b>Slot Code</b> of your <b>Sponsor</b>";
        $data["lock_sponsor"] = false;
        
        if(!$this->mlm_member && Self::$customer_info->customer_lead != "")
        {
            $sponsor_no = Tbl_mlm_slot::where("slot_id", Self::$customer_info->customer_lead)->value("slot_no");
            $data["lock_sponsor"] = $sponsor_no;
        }
        
        return Self::load_view_for_members('member2.enter_sponsor', $data);
    }
    public function getEnterPlacement()
    {
        $data["page"] = "Enter Code";
        $data["message"] = "Enter <b>Slot Code</b> of your <b>Sponsor</b>";
        

        $slot_id            = Crypt::decrypt(request("slot_no"));
        $key                = request("key");
        $data["slot_info"]  = $slot_info = Tbl_mlm_slot::where("slot_id", $slot_id)->customer()->first();

        if($slot_info->slot_owner == Self::$customer_info->customer_id)
        {
            $data["iamowner"] = true;
        }
        else
        {
            $data["iamowner"] = false;
        }

        if(md5($slot_info->slot_id . $slot_info->slot_no) == $key)
        {
            return Self::load_view_for_members('member2.enter_placement', $data);
        }
        else
        {
            return "ERROR OCCURRED";
        }
    }
    public function getFinalVerify()
    {
        $data = $this->code_verification();

        if($data)
        {
            return Self::load_view_for_members('member2.final_verify', $data);
        }
    }    
    public function postFinalVerify()
    {
        $data = $this->code_verification();

        if($data)
        {
            $shop_id        = $this->shop_info->shop_id;
            $customer_id    = Self::$customer_info->customer_id;
            $membership_id  = $data["membership_code"]->membership_id;
            $sponsor        = $data["sponsor"]->slot_id;
            
            $new_slot_no    = $data["pin"];
            $new_slot_no    = str_replace("MYPHONE", "BROWN", $new_slot_no);
            $new_slot_no    = str_replace("JCAWELLNESSINTCORP", "JCA", $new_slot_no);
            
            $return = Item::check_product_code($shop_id, $data["pin"], $data["activation"]);

            if($return)
            {
                $create_slot    = MLM2::create_slot($shop_id, $customer_id, $membership_id, $sponsor, $new_slot_no);

                if(is_numeric($create_slot))
                {
                    $remarks = "Code used by " . $data["sponsor_customer"]->first_name . " " . $data["sponsor_customer"]->last_name;
                    MLM2::use_membership_code($shop_id, $data["pin"], $data["activation"], $create_slot, $remarks);

                    $slot_id = $create_slot;
                    $store["get_success_mode"] = "success";
                    session($store);
                    echo json_encode("success");
                }
                else
                {
                    echo json_encode($create_slot);
                }                
            }
            else
            {
                echo json_encode('Item Code already used');
            }
        }
    }
    public function check_placement($slot_id, $slot_placement, $slot_position)
    {
        $shop_id       = $this->shop_info->shop_id;
        $check_sponsor = Tbl_mlm_slot::where("slot_id",$slot_id)->where("shop_id",$shop_id)->first();
        $this_slot_owner     = $check_sponsor->slot_owner;
        $this_slot_placement = $check_sponsor->slot_placement;
        $procceed      = 0;
        
        if($this_slot_placement == 0)
        {
            if($check_sponsor)
            {
                $check_sponsor = Tbl_mlm_slot::where("slot_id",$check_sponsor->slot_sponsor)->where("shop_id",$shop_id)->first();
                if($check_sponsor->slot_owner == Self::$customer_info->customer_id || $this_slot_owner == Self::$customer_info->customer_id)
                {
                    $check_placement = MLM2::check_placement_exist($shop_id,$slot_placement,$slot_position,1,$check_sponsor->slot_id);
                    
                    if($check_placement == 0)
                    {
                        $sponsor_have_placement = MLM2::check_sponsor_have_placement($shop_id,$check_sponsor->slot_id);
    
                        if($sponsor_have_placement == 1)
                        {
                            $data["target_slot"] = Tbl_mlm_slot::where("slot_id",$slot_id)->customer()->first();
                            $data["placement"]   = Tbl_mlm_slot::where("slot_id",$slot_placement)->customer()->first();
                            $data["position"]    = $slot_position;
                            $data["message"]     = "success";
                            $procceed            = 1;
                        }
                        else
                        {
                            $data["message"]   = "Your upline should placed you first.  (ERROR182)";
                        }
                    }
                    else
                    {
                        $data["message"]   = "Placement not available. (ERROR391)";
                    }
                }
                else
                {
                    $data["message"]   = "Some error occurred please try again. (ERROR659)";
                }
            }
            else
            {
                $data["message"]   = "Some error occurred please try again. (ERROR388)";
            }
        }
        else
        {
            $data["message"]   = "This slot is already placed. (ERROR111)";
        }
        
        $data["procceed"] = $procceed;
        return $data;
    }
    

    public function load_view_for_members($view, $data, $memberonly = true)
    {
        $agent = new Agent();

        if($agent->isMobile())
        {
            if (strpos($view, 'member2.') !== false)
            {
                $new_view = str_replace("member2.", "member2.mobile.", $view);
            }
            else
            {
                $new_view = str_replace("member.", "member.mobile.", $view);
            }

            if(view()->exists($new_view))
            {
                $view = $new_view;
            }
        }

        if ($memberonly) 
        {
            return Self::logged_in_member_only() ? Self::logged_in_member_only() : view($view, $data);
        }
        else
        {
            return view($view, $data);
        }
    }
    public function getSlotUseproductcode()
    {
        $data['action'] = '/members/slot-validate';
        $data['confirm_action'] = '/members/slot-toslot';
        return view('mlm.slots.use_product_code',$data);
    }
    public function postSlotValidate()
    {
        $mlm_pin = Request2::input('mlm_pin');
        $mlm_activation = Request2::input('mlm_activation');

        $shop_id = $this->shop_info->shop_id;

        $check = Item::check_product_code($shop_id, $mlm_pin, $mlm_activation);
        $return = [];
        if($check == true)
        {
            $return['status'] = 'success';
            $return['mlm_pin'] = $mlm_pin;
            $return['mlm_activation'] = $mlm_activation;
            $return['call_function'] = 'success_validation';
        }
        else
        {
            $return['status'] = 'error';
            $return['message'] = "Pin number and activation code doesn't exist.";
        }

        return json_encode($return);
    }
    public function getSlotToslot()
    {
        $data['mlm_pin'] = Request2::input('mlm_pin');
        $data['mlm_activation'] = Request2::input('mlm_activation');
        $data["_slot"]    = Tbl_mlm_slot::where('slot_owner', Self::$customer_info->customer_id)->membership()->get();
        $data['action'] = '/members/slot-confirmation';
        $data['confirm_action'] = '/members/slot-confirmation-submit';

        return view('mlm.slots.choose_slot',$data);
    }
    public function postSlotConfirmation()
    {
        $data['mlm_pin'] = Request2::input('mlm_pin');
        $data['mlm_activation'] = Request2::input('mlm_activation');
        $data['slot_no'] = Request2::input('slot_no');

        $data['status'] = 'success';
        $data['call_function'] = 'success_slot';

        return json_encode($data);
    }
    public function getSlotConfirmationSubmit()
    {
        $data['mlm_pin'] = Request2::input('mlm_pin');
        $data['mlm_activation'] = Request2::input('mlm_activation');
        $data['slot_no'] = Request2::input('slot_no');
        
        $data['message'] = "&nbsp; &nbsp; Are you sure you wan't to use this PIN (<b>".$data['mlm_pin']."</b>) and Activation code (<b>".$data['mlm_activation']."</b>) in your Slot No <b>".$data['slot_no']."</b> ?";

        $data['action'] = '/members/slot-use-product-code';

        return view('mlm.slots.confirm_product_code',$data);
    }
    public function postSlotUseProductCode()
    {
        $mlm_pin = Request2::input('mlm_pin');
        $mlm_activation = Request2::input('mlm_activation');
        $slot_no = Request2::input('slot_no');

        $slot_id    = Tbl_mlm_slot::where('slot_no', $slot_no)->where('slot_owner',Self::$customer_info->customer_id)->value('slot_id');

        $shop_id = $this->shop_info->shop_id;
        $consume['name'] = 'customer_product_code';
        $consume['id'] =Self::$customer_info->customer_id;
        $val = Warehouse2::consume_product_codes($shop_id, $mlm_pin, $mlm_activation, $consume);

        if(is_numeric($val))
        {
            MLM2::purchase($shop_id, $slot_id, $val);
            $return['status'] = 'success';
            $return['call_function'] = 'success_used';
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $val;
        }

        return json_encode($return);
    }
    public function getWebhook()
    {
        /* API Details */
        $shop_id = $this->shop_info->shop_id;
        $api = Tbl_online_pymnt_api::where('api_shop_id', $shop_id)
                                   ->join("tbl_online_pymnt_gateway", "tbl_online_pymnt_gateway.gateway_id", "=", "tbl_online_pymnt_api.api_gateway_id")
                                   ->where("gateway_code_name", "paymaya")
                                   ->first();
                                   
        /* Init Paymaya */
        if (get_domain() == "c9users.io" || get_domain() == "digimahouse.dev") 
        {
            $environment = "SANDBOX";
            PayMayaSDK::getInstance()->initCheckout("pk-sEt9FzRUWI2PCBI2axjZ7xdBHoPiVDEEWSulD78CW9c", "sk-cJFYCGhH4stZZTS52Z3dpNbrpRyu6a9iJaBiVlcIqZ5", $environment);
        }
        else
        {
            $environment = "PRODUCTION";
            PayMayaSDK::getInstance()->initCheckout($api->api_client_id, $api->api_secret_id, $environment);
        }

        /* Set Webhook */
        $webhook = Webhook::retrieve();

        $webhook_success = "/payment/paymaya/webhook/success";
        $webhook_failure = "/payment/paymaya/webhook/failure";
        $webhook_cancel = "/payment/paymaya/webhook/cancel";

        if (isset($webhook) && $webhook && count($webhook) > 0) 
        {
            foreach ($webhook as $value) 
            {
                if ($value->name == "CHECKOUT_SUCCESS") 
                {
                    $updateWebhook = new Webhook();
                    $updateWebhook->name = Webhook::CHECKOUT_SUCCESS;
                    $updateWebhook->id = $value->id;
                    $updateWebhook->callbackUrl = URL::to($webhook_success);
                    $updateWebhook->delete();
                }
                elseif($value->name == "CHECKOUT_FAILURE")
                {
                    $updateWebhook = new Webhook();
                    $updateWebhook->name = Webhook::CHECKOUT_FAILURE;
                    $updateWebhook->id = $value->id;
                    $updateWebhook->callbackUrl = URL::to($webhook_failure);
                    $updateWebhook->delete();
                }
                elseif($value->name == "CHECKOUT_DROPOUT")
                {
                    $updateWebhook = new Webhook();
                    $updateWebhook->name = Webhook::CHECKOUT_DROPOUT;
                    $updateWebhook->id = $value->id;
                    $updateWebhook->callbackUrl = URL::to($webhook_cancel);
                    $updateWebhook->delete();
                }
            }
        }
        
        $successWebhook = new Webhook();
        $successWebhook->name = Webhook::CHECKOUT_SUCCESS;
        $successWebhook->callbackUrl = URL::to($webhook_success);
        $successWebhook->register();
        
        $failureWebhook = new Webhook();
        $failureWebhook->name = Webhook::CHECKOUT_FAILURE;
        $failureWebhook->callbackUrl = URL::to($webhook_failure);
        $failureWebhook->register();
        
        $cancelWebhook = new Webhook();
        $cancelWebhook->name = Webhook::CHECKOUT_DROPOUT;
        $cancelWebhook->callbackUrl = URL::to($webhook_cancel);
        $cancelWebhook->register();

        dd(Webhook::retrieve());
    }
}
