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
	public static function update_event($id, $update)
	{
		return Tbl_shop_event::where('event_id',$id)->update($update);
	}
	public static function get($shop_id, $archived = 0)
	{
		return Tbl_shop_event::where('event_shop_id',$shop_id)->where('archived', $archived)->orderBy('event_date','ASC')->get();
	}
	public static function first($shop_id, $event_id)
	{
		return Tbl_shop_event::where('event_shop_id',$shop_id)->where('event_id', $event_id)->first();
	}
	public static function archive_event($id, $action)
	{
		$update['archived'] = 1;
		if($action == 'restore')
		{
			$update['archived'] = 0;
		}

		return ShopEvent::update_event($id, $update);
	}
}