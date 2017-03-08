<?php
namespace App\Globals;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use DB;

class account
{
    public static function put_default_account($shop)
    {
        
        $is_account_has_data = Tbl_chart_of_account::accountInfo($shop)->first();
        $shop_id             = Tbl_shop::where("shop_id", $shop)->orWhere("shop_key")->pluck("shop_id");
        
        if(!$is_account_has_data)
        {
            $default_account = Tbl_default_chart_account::get();
            
            foreach($default_account as $default)
            {
                $insert["account_shop_id"]          = $shop_id;
                $insert["account_type_id"]          = $default->default_type_id;
                $insert["account_number"]           = $default->default_number;
                $insert["account_name"]             = $default->default_name;
                $insert["account_description"]      = $default->default_description;
                
                Tbl_chart_of_account::insert($insert);
            }
        }
    }
}