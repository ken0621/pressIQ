<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Crypt;
use Redirect;
use View;
use Carbon\Carbon;
use App\Globals\Payment;
use App\Globals\Customer;
use App\Rules\Uniqueonshop;
use App\Globals\MLM2;
use App\Globals\FacebookGlobals;
use App\Globals\SocialNetwork;
use App\Globals\GoogleGlobals;
use App\Models\Tbl_customer;

class ShopMemberController extends Shop
{
    public static function store_login_session($email, $password)
    {
        $store["email"]         = $email;
        $store["auth"]          = $password;
        $sess["mlm_member"]     = $store;

        session($sess);
    }
    /* LOGIN AND REGISTRATION - START */
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
    public function postLoginGoogleSubmit(Request $request)
    {
        $pass = isset($request->id) ? $request->id : null;
        $email = isset($request->email) ? $request->email : null;
        $check = Tbl_customer::where('email',$email)->first();
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
            $check = Tbl_customer::where('email',$data['email'])->first();
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
    public function getIndex()
    {
        $data["page"] = "Dashboard";
        $view = "member.dashboard";

        if(Self::$customer_info)
        {
            if(!Self::$customer_info->ismlm)
            {
                $view = "member.nonmember";
            }     
        }

        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view($view, $data));
    }
    public function getProfile()
    {
        $data["page"] = "Profile";
        $data["mlm"] = isset(Self::$customer_info->ismlm) ? Self::$customer_info->ismlm : 0;
        
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.profile", $data));
    }
    public function getNotification()
    {
        $data["page"] = "Notification";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.notification", $data));
    }
    public function getGenealogy()
    {
        $data["page"] = "Genealogy";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.genealogy", $data));
    }
    public function getReport()
    {
        $data["page"] = "Report";
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

    /*BROWN CHECKOUT PAGE*/
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
            $return = (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.card", $data));
        }


        return $return;
    }

    /* GLOBALS */
}