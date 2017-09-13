<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Crypt;
use Redirect;
use View;
use App\Globals\Payment;
use App\Globals\Customer;
use App\Rules\Uniqueonshop;

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
        return view("member.login", $data);
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
        return view("member.register", $data);
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

        if(Self::$customer_info->ismlm == 0)
        {
            return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.nonmember", $data));
        }
        else
        { 
            return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.dashboard", $data));
        }
    }
    public function getProfile()
    {
        $data["page"] = "Profile";
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

}