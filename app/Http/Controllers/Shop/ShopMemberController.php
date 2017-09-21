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
use Carbon\Carbon;
use App\Globals\Payment;
use App\Globals\Customer;
use App\Globals\MemberSlotGenealogy;
use App\Rules\Uniqueonshop;
use App\Globals\MLM2;
use App\Globals\FacebookGlobals;
use App\Globals\SocialNetwork;
use App\Globals\GoogleGlobals;
use App\Models\Tbl_customer;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_customer_other_info;
use App\Models\Tbl_country;
use App\Models\Tbl_locale;
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
        session()->forget("get_success_mode");

        if(Self::$customer_info)
        {
            $data["customer_summary"]   = MLM2::customer_income_summary($this->shop_info->shop_id, Self::$customer_info->customer_id);
            $data["wallet"]             = $data["customer_summary"]["_wallet"];
            $data["points"]             = $data["customer_summary"]["_points"];
            $data["_slot"]              = MLM2::customer_slots($this->shop_info->shop_id, Self::$customer_info->customer_id);
            $data["_recent_rewards"]    = MLM2::customer_rewards($this->shop_info->shop_id, Self::$customer_info->customer_id, 5);
            $data["_direct"]            = MLM2::customer_direct($this->shop_info->shop_id, Self::$customer_info->customer_id, 5);
        }

        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.dashboard", $data));
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

        return view("member.login", $data);
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
        $email = isset($user_profile) ? $user_profile['email'] : null;
        $check = Tbl_customer::where('email',$email)->first();
        if(count($user_profile) > 0 && $check)
        {
            $data = collect($user_profile)->toArray();

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
        $validate["email"]      = ["required","email"];
        $validate["password"]   = ["required"];
        $data                   = $this->validate(request(), $validate);

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

        return view("member.register", $data);
    }
    public function getRegisterSubmit()
    {
        $user_profile = FacebookGlobals::user_profile($this->shop_info->shop_id);

        if(count($user_profile) > 0)
        {
            $data = collect($user_profile)->toArray();
            $check = Tbl_customer::where('email',$data['email'])->where('shop_id',$this->shop_info->shop_id)->first();
            $email = $data['email'];
            $pass = $data['id'];
            if(!$check)
            {
                $ins['email']           = $data['email'];
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
            }

            return Redirect::to("/members")->send();
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
    /* LOGIN AND REGISTRATION - END */
    public function getProfile()
    {
        $data["page"]                = "Profile";
        $data["mlm"]                 = isset(Self::$customer_info->ismlm) ? Self::$customer_info->ismlm : 0;
        $data["profile"]             = Tbl_customer::shop(Self::$customer_info->shop_id)->where("tbl_customer.customer_id", Self::$customer_info->customer_id)->first();
        $data["profile_address"]     = Tbl_customer_address::where("customer_id", Self::$customer_info->customer_id)->where("purpose", "permanent")->first();
        $data["profile_info"]        = Tbl_customer_other_info::where("customer_id", Self::$customer_info->customer_id)->first();
        $data["_country"]            = Tbl_country::get();
        // $data["allowed_change_pass"] = isset(Self::$customer_info->signup_with) ? (Self::$customer_info->signup_with == "member_register" ? true : false) : false;
      

        if(Self::$customer_info)
        {
            $data["customer_summary"]   = MLM2::customer_income_summary($this->shop_info->shop_id, Self::$customer_info->customer_id);
            $data["wallet"]             = $data["customer_summary"]["_wallet"];
        }


        $data["allowed_change_pass"] = true;

        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.profile", $data));
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
            $birthday = date("YY-MM-DD", strtotime($request->b_month . "/" . $request->b_day . "/" . $request->b_year));

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

                $upload_success    = Input::file('profile_image')->move($destinationPath, $filename);

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
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.notification", $data));
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

        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.genealogy", $data));
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
            return view('member.genealogy_tree', $data);            
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

        if(request()->input("slot_no") == "")
        {
            $slot_no = Tbl_mlm_slot::where("slot_owner", Self::$customer_info->customer_id)->value("slot_no");
            return Redirect::to("/members/network?slot_no=" . $slot_no);
        }
        else
        {
            $data["_tree"] = MLM2::get_sponsor_network($this->shop_info->shop_id, request()->input("slot_no"));
            return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.network", $data));
        }
    }
    public function getReport()
    {
        $data["page"] = "Report";
        $data["_rewards"]    = MLM2::customer_rewards($this->shop_info->shop_id, Self::$customer_info->customer_id, 0);
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.report", $data));
    }
    public function getWalletLogs()
    {
        $data["page"] = "Wallet Logs";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.wallet_logs", $data));
    }
    public function getWalletEncashment()
    {
        $data["page"] = "Wallet Encashment";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.wallet_encashment", $data));
    }
    public function getSlot()
    {
        $data["page"] = "Slot";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.slot", $data));
    }
    public function getEonCard()
    {
        $data["page"] = "Eon Card";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.eon_card", $data));
    }
    public function getOrder()
    {
        $data["page"] = "Orders";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.order", $data));
    }
    public function getWishlist()
    {
        $data["page"] = "Wishlist";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.wishlist", $data));
    }

    public function getNonMember()
    {
        $data["page"] = "NonMember";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.nonmember", $data));
    }

    public function getTest()
    {
        $shop_id    = $this->shop_info->shop_id; //tbl_shop
        $key        = "paymaya"; //link reference name
        $success    = "/checkout/finish/success"; //redirect if payment success
        $failed     = "/checkout/finish/error"; //redirect if payment failed
        $debug      = false;

        $error = Payment::payment_redirect($shop_id, $key, $success, $failed, $debug);
        dd($error);
    }


    public function getCheckout()
    {
        $data["page"] = "Checkout";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.checkout", $data));
    }

    /* AJAX */
    public function postVerifySponsor(Request $request)
    {
        $shop_id = $this->shop_info->shop_id;
        $sponsor = MLM2::verify_sponsor($shop_id, $request->verify_sponsor);

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
            $data["page"] = "CARD";
            $data["sponsor"] = $sponsor; 
            $data["sponsor_customer"] = Customer::get_info($shop_id, $sponsor->slot_owner);
            $data["sponsor_profile_image"] = $data["sponsor_customer"]->profile == "" ? "/themes/brown/img/user-placeholder.png" : $data["sponsor_customer"]->profile;

            $store["sponsor"] = $sponsor->slot_no;
            session($store);

            $return = (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.card", $data));
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
        $data            = $this->check_placement($slot_id,$slot_placement,$slot_position);
        $procceed        = $data["procceed"];
        if($procceed == 1)
        {
            $return = MLM2::matrix_position($shop_id, $slot_id, $slot_placement, $slot_position);
            if($return == "success")
            {
               echo json_encode("success");
            }
            else
            {
               echo json_encode("SOME ERROR OCCURRED");  
            }
            
        }
        else
        {
            echo json_encode("SOME ERROR OCCURRED");
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
                    $data["target_slot"] = Tbl_mlm_slot::where("slot_id",$slot_id)->customer()->first();
                    $data["placement"]   = Tbl_mlm_slot::where("slot_id",$slot_placement)->customer()->first();
                    $data["position"]    = $slot_position;
                    $data["message"]     = "success";
                    $procceed            = 1;
                }
                else
                {
                    $data["message"]   = "Placement not available";
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
}