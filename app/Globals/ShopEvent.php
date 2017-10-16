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
	public static function get($shop_id, $archived = 0, $get = 0, $date = null, $customer_id = null, $type = array())
	{
		$data = Tbl_shop_event::where('event_shop_id',$shop_id)->where('archived', $archived);
		if($get != 0)
		{
			$data->take($get);
		}
		if($date)
		{
			$date_now = date('Y-m-d', strtotime($date));
			$data->where('event_date','>=',$date_now);
		}
		if(count($type) > 0)
		{
			$data->whereIn('event_attendee',$type);
		}

		$return = $data->orderBy('event_date','ASC')->get();

		if($customer_id)
		{
			foreach ($return as $key => $value) 
			{
				$return[$key]->is_reserved = 0;
				$check = Tbl_shop_event_reserved::where('customer_id',$customer_id)->where('event_id',$value->event_id)->first();
				if($check)
				{
					$return[$key]->is_reserved = 1;
				}
			}
		}

		foreach ($return as $key => $value) 
		{
			$total_count = Tbl_shop_event_reserved::where('event_id',$value->event_id)->count();
			$customer_count = Tbl_shop_event_reserved::where('customer_id', '!=', null)->where('event_id',$value->event_id)->count();
			$guest_count = Tbl_shop_event_reserved::where('customer_id', '=', null)->where('event_id',$value->event_id)->count();

			$return[$key]->reservee_total_count = $total_count;
			$return[$key]->reservee_guest_count = $guest_count;
			$return[$key]->reservee_customer_count = $customer_count;
		}

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
	public static function get_all_reservee($event_id)
	{
		return Tbl_shop_event_reserved::where('event_id',$event_id)->get();
	}
	public static function reserved_seat($event_id, $customer_id = 0, $data)
	{
		$return = null;
		$event_number_attendee = Tbl_shop_event::where('event_id', $event_id)->value('event_number_attendee');
		$count = Tbl_shop_event_reserved::where('event_id', $event_id)->count();
		
		if($count < $event_number_attendee)
		{
			$check_code = Tbl_shop_event_reserved::where('event_id', $event_id)->where("reservee_enrollers_code",$data['reservee_enrollers_code'])->count();
			if(!$check_code)
			{
				if($customer_id != 0)
				{
					$check = Tbl_shop_event_reserved::where('customer_id',$customer_id)->where('event_id',$event_id)->first();

					if($check)
					{
						$return .= "Already reserved a seat"; 
					}
					else
					{
						$data['event_id'] = $event_id;
						$data['customer_id'] = $customer_id;
						$return = Tbl_shop_event_reserved::insertGetId($data);
					}
				}
				else
				{
					$data['event_id'] = $event_id;
					$return = Tbl_shop_event_reserved::insertGetId($data);
				}
			}
			else
			{
				$return .= "Enrollers code already used";
			}
		}
		else
		{
			$return .= "All seats are already reserved";
		}

		return $return;
	}
}