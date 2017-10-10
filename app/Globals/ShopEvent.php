<?php
namespace App\Globals;

use App\Models\Tbl_shop_event;
/**
 * 
 *
 * @author ARCYLEN
 */

class ShopEvent
{
	public static function create_event($ins)
	{
		return Tbl_shop_event::insertGetId($ins);
	}
	public static function get($shop_id)
	{
		return Tbl_shop_event::where('event_shop_id',$shop_id)->orderBy('event_date','ASC')->get();
	}
}