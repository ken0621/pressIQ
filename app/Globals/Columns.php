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
       $columns = Tbl_columns::user($user_id)->shop($shop_id)->from($from)->first();

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
       else
       {
            if (isset($columns->columns_data) && is_serialized($columns->columns_data)) 
            {
                $temp_columns = unserialize($columns->columns_data);
                if (count($temp_columns) != count($default)) 
                {
                    foreach ($default as $key => $value) 
                   {
                      $temp_value               = $value;
                      $default[$key]            = [];
                      $default[$key]["value"]   = $temp_value;
                      $default[$key]["checked"] = true;
                   }
                   
                    $temp_columns = $default;
                }
            }
            else
            {
                $temp_columns = [];
            }
            
            $columns = $temp_columns;
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
        $columns                = Tbl_columns::user($user_id)->shop($shop_id)->from($from)->first();

        if (count($columns) > 0) 
        {
            Tbl_columns::user($user_id)->shop($shop_id)->from($from)->update($insert);
        }
        else
        {
            $insert["shop_id"]      = $shop_id;
            $insert["user_id"]      = $user_id;
            $insert["columns_from"] = $from;
            Tbl_columns::insert($insert);
        }

        return true;
    }

    public static function checkColumns($shop_id, $user_id, $from)
    {
        $columns = Tbl_columns::user($user_id)->shop($shop_id)->from($from)->first();
        if (isset($columns->columns_data) && is_serialized($columns->columns_data)) 
        {
            $temp_columns = unserialize($columns->columns_data);
        }
        else
        {
            $temp_columns = [];
        }

        $css = '<style type="text/css">';

        foreach ($temp_columns as $key => $value) 
        {
            if ($value["checked"] == false) 
            {
                $css .= '.table tr > *:nth-child('.($key+1).'){display: none;}';
            }
        }

        $css .= '</style>';

        return $css;
    }
}