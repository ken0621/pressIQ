<?php
namespace App\Globals;

use App\Models\Tbl_variant;
use App\Models\Tbl_user;
use App\Models\Tbl_mlm_item_discount;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_category;
use App\Models\Tbl_item;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_sir_item;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_audit_trail;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Purchasing_inventory_system;
use App\Globals\Tablet_global;
use App\Globals\Currency;
use App\Models\Tbl_price_level;
use App\Models\Tbl_price_level_item;
use App\Models\Tbl_item_type;
use App\Models\Tbl_columns;
use Session;
use DB;
use Carbon\carbon;
use App\Globals\Merchant;
use Validator;

class Columns
{
    public static function getColumns($shop_id, $user_id, $from, $default)
    {
       $columns = Tbl_columns::user($user_id)->shop($shop_id)->get();
       if (!count($columns) > 0) 
       {
           foreach ($default as $key => $value) 
           {
              $temp_value               = $value;
              $default[$key]            = [];
              $default[$key]["value"]   = $temp_value;
              $default[$key]["checked"] = true;
           }

           $columns = $default;
       }

       return $columns;
    }

    public static function submitColumns($shop_id, $user_id, $from, $column)
    {   
        foreach ($column as $key => $value) 
        {
            $submit[$key]["value"] = $value["value"];
            $submit[$key]["checked"] = $value["checked"] == "yes" ? true : false;
        }

        $insert["columns_data"] = serialize($submit);
        $insert["columns_from"] = $from;

        $columns                  = Tbl_columns::user($user_id)->shop($shop_id)->first();

        if (!count($columns) > 0) 
        {
            
        }

        return true;
    }
}