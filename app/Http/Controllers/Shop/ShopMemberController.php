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
        Self::guest_only();

        $data["page"] = "Register";
        return view("member.register", $data);
    }
    public function postRegister(Request $request)
    {
        Self::guest_only();

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

    /* LOGIN AND REGISTRATION - END */
    public function getIndex()
    {
        $data["page"] = "Dashboard";
        return (Self::logged_in_member_only() ? Self::logged_in_member_only() : view("member.dashboard", $data));
    }

    public function getNonMember()
    {
        $data["page"] = "Dashboard";
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
}