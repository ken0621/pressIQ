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
use App\Models\Tbl_inventory_serial_number;
use App\Models\Tbl_settings;
use App\Models\Tbl_inventory_slip;
use App\Models\Tbl_warehouse_inventory;

use Carbon\Carbon;
use App\Globals\Item;
use Session;

class ItemSerial
{
	public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public static function getItemSerial($item_id)
    {
    	$return = Tbl_inventory_serial_number::item()->where("tbl_item.item_id",$item_id)->get();
    	return $return;
    }
    public static function check_setting()
    {
    	return Tbl_settings::where("settings_key","item_serial")->where("settings_value",'enable')->where("shop_id",ItemSerial::getShopId())->first();
    }
    public static function insert_item_serial($item_serial = array(), $inventory_id = 0)
    {
    	if($inventory_id)
    	{
    		$serials = explode(",", $item_serial["serials"]);
    		if(count($serials) <= $item_serial["quantity"])
    		{
	    		foreach ($serials as $key => $value) 
	    		{
	    			if($value)
	    			{
	    				$ins["serial_inventory_id"] = $inventory_id;
	    				$ins["item_id"] = $item_serial["item_id"];
	    				$ins["serial_number"] = $value;
	    				$ins["serial_created"] = Carbon::now();
	    				$ins["item_count"] = $key + 1;

	    				Tbl_inventory_serial_number::insert($ins);
	    			}
	    		}    			
    		}
    	}
    }
    public static function get_serial($soure_reason = "", $soure_id = 0, $item_id = 0)
    {
    	$slip = Tbl_inventory_slip::where("inventroy_source_reason",$soure_reason)->where("inventory_source_id",$soure_id)->first();

    	$return = "";
    	if($slip)
    	{
    		$w_inventory = Tbl_warehouse_inventory::where("inventory_slip_id",$slip->inventory_slip_id)->where("inventory_item_id",$item_id)->first();
    		if($w_inventory)
    		{
    			$serials = Tbl_inventory_serial_number::where("serial_inventory_id",$w_inventory->inventory_id)->where("item_id",$item_id)->get();

    			foreach ($serials as $key => $value) 
    			{
    				$return .= $value->serial_number .",";
    			}
    		}
    	}

    	return $return;
    }
    public static function check_item_serial($item_serial)
    {
    	$return = null;
    	$serials = explode(",", $item_serial["serials"]);

    	foreach ($serials as $key => $value) 
    	{
    		if($value == "" || $value == null)
    		{
    			unset($serials[$key]);
    		}
    	}

    	if(count($serials) > $item_serial["quantity"])
		{
			$return = "serial_are_more_than_quantity";
		}
		return $return;
    }

}
