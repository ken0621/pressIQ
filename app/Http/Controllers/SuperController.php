<?php
namespace App\Http\Controllers;
use App\Models\Tbl_shop;
use App\Models\Tbl_admin;
use App\Models\Tbl_user;
use App\Models\Tbl_user_position;
use Crypt;

class SuperController extends Controller
{
    public $admin_info;

    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {  
            if(session("admin_username"))
            {
                $error = "";

                $username = session("admin_username");
                $password = session("admin_password");

                $check_admin = Tbl_admin::where("username", $username)->first();

                if(!$check_admin)
                {
                    $error = "The account you are trying to login doesn't exist.";
                }
                else
                {
                    $real_password = Crypt::decrypt($check_admin->password);

                    if($real_password != $password)
                    {
                        $error = "Password is incorrect.";
                    }
                }

                if($error != "")
                {
                    dd($error);
                }
                else
                {
                    $this->admin_info = $check_admin;
                }
            }
            
            return $next($request);
        });
    }

    public function getIndex()
    {   
        if(session("admin_username"))
        {
            return view("super.super");
        }
        else
        {
            Self::seed_admin_if_there_isnt_any();
            return view("super.login");
        }
    }
    public function postLogin()
    {
        $error = "";

        $username = request("username");
        $password = request("password");

        $check_admin = Tbl_admin::where("username", $username)->first();

        if(!$check_admin)
        {
            $error = "The account you are trying to login doesn't exist.";
        }
        else
        {
            $real_password = Crypt::decrypt($check_admin->password);

            if($real_password != $password)
            {
                $error = "Password is incorrect.";
            }
        }


        if($error == "")
        {
            $store["admin_username"] = request("username");
            $store["admin_password"] = request("password");
            session($store);
            $return["status"] = "success";
        }
        else
        {
            $return["status"] = "error";
            $return["title"] = "Login Error";
            $return["message"] = $error;
        }

        
        echo json_encode($return);
    }
    public function getCustomer()
    {
        $_shop = Tbl_shop::orderBy("shop_key")->get();

        foreach($_shop as $key => $shop)
        {
            $_shop[$key]->shop_name     = strtoupper($shop->shop_key);
            $_shop[$key]->domain        = ($shop->shop_domain == "unset_yet" ? "<span style='color: gray;'>no url set yet</span>" : $shop->shop_domain);
            $user_count                 = Tbl_user::where("user_shop", $shop->shop_id)->active()->count();
            $_shop[$key]->user_count    = "<span style='color: gray;'>" . $user_count . " user(s)" . "</span>";
        }

        $data["_shop"] = $_shop;

        return view("super.customer", $data);
    }
    public function getCustomerEdit()
    {
        $data["page"]       = "Customer Edit";
        $data["shop"]       = Tbl_shop::where('shop_id', request("id"))->first();
        $data["shop_id"]    = $data["shop"]->shop_id;
        $data["created"]    = date("m/d/Y", strtotime($data["shop"]->shop_date_created));
        $data["edited"]     = date("m/d/Y", strtotime($data["shop"]->updated_at));
        $data["user_count"] = Tbl_user::where("user_shop", $data["shop"]->shop_id)->active()->count();

        return view("super.customer_edit", $data);
    }
    public function getUser()
    {
        $data["shop"]       = Tbl_shop::where('shop_id', request("shop_id"))->first();
        $data["shop_id"]    = $data["shop"]->shop_id;
        $data["page"]       =  $data["shop"]->shop_key;
        $data["_user"]      = Tbl_user::where("user_shop", request("shop_id"))->active()->position()->get();
        return view("super.user", $data);
    }
    public function getUserEdit()
    {
        $data["page"]       = "Edit";
        $data["user_id"]    = $user_id = request("id");
        $data["user"]       = Tbl_user::where("user_id", $user_id)->position()->first();
        $data["_position"]  = Tbl_user_position::where("position_shop_id", $data["user"]->user_shop)->get();
        $data["password"]   = Crypt::decrypt($data["user"]->user_password);
        return view("super.user_edit", $data);
    }
    public function getLogout()
    {
        session()->forget("admin_username");
        session()->forget("admin_password");
        return redirect()->back();
    }
    public static function seed_admin_if_there_isnt_any()
    {
        $admin = Tbl_admin::first();

        if(!$admin)
        {
            $insert_admin["first_name"]     = "Guillermo";
            $insert_admin["last_name"]      = "Tabligan";
            $insert_admin["username"]       = "gtplusnet";
            $insert_admin["mobile_number"]  = "09778049113";
            $insert_admin["password"]       = Crypt::encrypt("0SlO051O");

            Tbl_admin::insert($insert_admin);
        }
    }
}