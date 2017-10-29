<?php
namespace App\Http\Controllers;
use App\Models\Tbl_shop;
use App\Models\Tbl_admin;
class SuperController extends Controller
{
    public function getIndex()
    {   
        Self::seed_admin_if_there_isnt_any();
        return view("super.login");
    }
    public static function seed_admin_if_there_isnt_any()
    {
        $admin = Tbl_admin::first();

        if(!$admin)
        {
            $insert_admin["first_name"]     = "Guillermo";
            $insert_admin["last_name"]      = "Tabligan";
            $insert_admin["username"]       = "gtplusnet";
            $insert_admin["password"]       = "0SlO051O";

            Tbl_admin::insert($insert_admin);
        }
    }
}