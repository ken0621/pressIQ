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
use Carbon\Carbon;
use App\Globals\Payment;
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
use App\Models\Tbl_customer;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_customer_other_info;
use App\Models\Tbl_email_template;
use App\Models\Tbl_transaction_list;
use App\Models\Tbl_transaction_item;
use App\Models\Tbl_country;
use App\Models\Tbl_locale;
use App\Globals\Currency;
use App\Globals\Cart2;
use App\Globals\Item;
use Jenssegers\Agent\Agent;
use Validator;
use Google_Client; 
use Google_Service_Drive;
use Google_Service_Plus;

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
            }
        }
        $data["item_kit_id"] = Item::get_first_assembled_kit($this->shop_info->shop_id);

        return Self::load_view_for_members('member.dashboard', $data);
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

        // if(request("pass") != "456")
        // {
        //     return view("member.coming");
        // }

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

        return Redirect::to("/members")->send();
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
            $content_key = "front_forgot_password";
            dd(EmailContent::checkIfexisting($content_key, $shop_id));
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

                $email_content["content"] = EmailContent::email_txt_replace($content_key, $change_content);

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
        $data["allowed_change_pass"] = isset(Self::$customer_info->signup_with) ? (Self::$customer_info->signup_with == "member_register" ? true : false) : false;

        if(Self::$customer_info)
        {
            $data["customer_summary"]   = MLM2::customer_income_summary($this->shop_info->shop_id, Self::$customer_info->customer_id);
            $data["wallet"]             = $data["customer_summary"]["_wallet"];
        }


        // $data["allowed_change_pass"] = true;

        return (Self::load_view_for_members("member.profile", $data));
    }
    public function postProfileUpdateInfo(Request $request)
    {
        $form = $request->all();
        $validate['first_name'] = 'required';
        $validate['middle_name'] = 'required';
        $validate['last_name'] = 'required';
        $validate['b_month'] = 'required';
        $validate['b_day'] = 'required';
        $validate['b_year'] = 'required';
        $validate['country_id'] = 'required';
        $validate['customer_state'] = 'required';
        $validate['customer_city'] = 'required';
        $validate['customer_zipcode'] = 'required';
        $validate['customer_street'] = 'required';

        $validator = Validator::make($form, $validate);
        
        if (!$validator->fails()) 
        {           
            /* Birthday Fix */
            $birthday = date("Y-m-d", strtotime($request->b_month . "/" . $request->b_day . "/" . $request->b_year));
            
            /* Customer Data */
            $insert_customer["first_name"]  = $request->first_name;
            $insert_customer["middle_name"] = $request->middle_name;
            $insert_customer["last_name"]   = $request->last_name;
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
                   if ($exist->profile) 
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
        $data["_locale"]    = Tbl_locale::where("locale_parent", 0)->get();
        $data["cart"]       = Cart2::get_cart_info();
        return (Self::load_view_for_members("member.checkout", $data));
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
    public function getFinalVerify()
    {
        $data = $this->code_verification();

        if($data)
        {
            return view('member.final_verification', $data);
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
            $create_slot    = MLM2::create_slot($shop_id, $customer_id, $membership_id, $sponsor, $data["pin"]);

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
            return view('member.final_verification_placement', $data);
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
    public function check_placement($slot_id,$slot_placement,$slot_position)
    {
        $shop_id       = $this->shop_info->shop_id;
        $check_sponsor = Tbl_mlm_slot::where("slot_id",$slot_id)->where("shop_id",$shop_id)->first();
        $procceed      = 0;
        if($check_sponsor)
        {
            $check_sponsor = Tbl_mlm_slot::where("slot_id",$check_sponsor->slot_sponsor)->where("shop_id",$shop_id)->first();
            if($check_sponsor->slot_owner == Self::$customer_info->customer_id)
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
                        $data["message"]   = "Your upline should placed your first.";
                    }
                }
                else
                {
                    $data["message"]   = "Placement not available.";
                }
            }
            else
            {
                $data["message"]   = "Some error occurred please try again.";
            }
        }
        else
        {
            $data["message"]   = "Some error occurred please try again.";
        }


        $data["procceed"] = $procceed;
        return $data;
    }

    public function load_view_for_members($view, $data, $memberonly = true)
    {
        $agent = new Agent();

        if($agent->isMobile())
        {
            $new_view = str_replace("member.", "member.mobile.", $view);
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
}
