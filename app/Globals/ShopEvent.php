<?php
namespace App\Globals;

use App\Models\Tbl_shop_event;
use App\Models\Tbl_shop_event_reserved;
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
	public static function get($shop_id, $archived = 0, $get = 0)
	{
		$data = Tbl_shop_event::where('event_shop_id',$shop_id)->where('archived', $archived);
		if($get != 0)
		{
			$data->take($get);
		}

		$return = $data->orderBy('event_date','ASC')->get();

		return $return;
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
	public static function reserved_seat($event_id, $customer_id = 0, $data)
	{
		$return = null;
		if($customer_id != 0)
		{
			$check = Tbl_shop_event_reserved::where('customer_id',$customer_id)->where('event_id',$event_id)->first();

			if($check)
			{
				$return .= "Already reserved a seat"; 
			}
			else
			{
				$data['customer_id'] = $customer_id;
				$return = Tbl_shop_event_reserved::insertGetId($data);
			}
		}
		else
		{
			$return = Tbl_shop_event_reserved::insertGetId($data);
		}

		return $return;
	}
}