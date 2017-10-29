<?php
namespace App\Http\Controllers;
use App\Models\Tbl_shop;
use App\Models\Tbl_admin;
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