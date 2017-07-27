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

}
