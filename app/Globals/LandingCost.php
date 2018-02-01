<?php
namespace App\Globals;
use App\Models\Tbl_item_default_landing_cost;
use App\Models\Tbl_item_landing_cost;

use Carbon\Carbon;
use DB;

/**
 * LANDING COST
 *
 * @author Arcylen Gutierrez
 */

class LandingCost
{
	public static function get($shop_id = '')
	{
		return Tbl_item_default_landing_cost::where("shop_id", $shop_id)->get();
	}
	public static function insert($shop_id, $insert = array())
	{
		Tbl_item_default_landing_cost::where("shop_id", $shop_id)->delete();
		Tbl_item_default_landing_cost::insert($insert);
	}
}