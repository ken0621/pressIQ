<?php
namespace App\Globals;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_warehouse_inventory_record_log;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_points_log;
use Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;
use stdClass;


class MLM2
{
	
	public static $shop_id;
	public static function verify_sponsor($shop_id, $sponsor_key)
	{
		$slot_info = Tbl_mlm_slot::shop($shop_id)->where("slot_nick_name", $sponsor_key)->where("slot_defaul", 1)->first();

		if(!$slot_info)
		{
			$slot_info = Tbl_mlm_slot::shop($shop_id)->where("slot_no", $sponsor_key)->first();
		}

		return $slot_info;
	}
	public static function customer_slots($shop_id, $customer_id)
	{
		$_slot = Tbl_mlm_slot::where("slot_owner", $customer_id)->currentWallet()->get();

		foreach($_slot as $key =>  $slot)
		{
			$_slot[$key]->display_total_earnings = Currency::format($slot->total_earnings);
		}

		return $_slot;
	}
	public static function customer_income_summary($shop_id, $customer_id)
	{
		$_slot = Tbl_mlm_slot::where("slot_owner", $customer_id)->currentWallet()->get();

		$return["_wallet"] = new stdClass();
		$return["_wallet"]->current_wallet = 0;
		$return["_wallet"]->total_earnings = 0;
		$return["_wallet"]->total_payout = 0;
		$return["_wallet"]->complan_direct = 0;
		$return["_wallet"]->complan_binary = 0;
		$return["_wallet"]->complan_builder = 0;
		$return["_wallet"]->complan_leader = 0;

		$return["_points"] = new stdClass();
		$return["_points"]->brown_leader_points = 0;
		$return["_points"]->brown_builder_points = 0;

		$return["slot_count"] = 0;

		foreach($_slot as $key =>  $slot)
		{
			$return["_wallet"]->current_wallet += $slot->current_wallet;
			$return["_wallet"]->total_earnings += $slot->total_earnings;
			$return["_wallet"]->total_payout += $slot->total_payout;
			$return["slot_count"]++;	

			$_slot_wallet = Tbl_mlm_slot_wallet_log::where("wallet_log_slot", $slot->slot_id)->get();

			foreach($_slot_wallet as $slot_wallet)
			{
				$wallet_plan = strtolower("complan_" .$slot_wallet->wallet_log_plan);

				if(!isset($return["_wallet"]->$wallet_plan))
				{
					$return["_wallet"]->$wallet_plan = $slot_wallet->wallet_log_amount;
				}
				else
				{
					$return["_wallet"]->$wallet_plan += $slot_wallet->wallet_log_amount;
				}
				
			}

			$_slot_points = Tbl_mlm_slot_points_log::where("points_log_slot", $slot->slot_id)->get();

			foreach($_slot_points as $slot_points)
			{
				$wallet_plan = strtolower($slot_points->points_log_complan);
				if(!isset($return["_points"]->$wallet_plan))
				{
					$return["_points"]->$wallet_plan = $slot_points->points_log_points;
				}
				else
				{
					$return["_points"]->$wallet_plan += $slot_points->points_log_points;
				}
			}
		}

		$_wallet = json_encode($return["_wallet"]);
		$_points = json_encode($return["_points"]);

		/* DISPLAY FORMAT */
		foreach(json_decode($_wallet) as $key => $wallet)
		{
			$display_string = "display_" . $key;
			$return["_wallet"]->$display_string = Currency::format($wallet);
		}

		/* DISPLAY FORMAT */
		foreach(json_decode($_points) as $key => $points)
		{
			$display_string = "display_" . $key;
			$return["_points"]->$display_string = number_format($points, 2) . " POINT(S)";
		}

		$return["_slot"] = $_slot;
		$return["display_slot_count"] = number_format($return["slot_count"], 0) . " SLOT(S)";

		return $return;
	}
	public static function customer_rewards($shop_id, $customer_id, $limit = 10)
	{
		$_slot = Tbl_mlm_slot::where("slot_owner", $customer_id)->currentWallet()->get();
		$query = Tbl_mlm_slot_wallet_log::where("shop_id", $shop_id);

		$query->where(function($q) use ($_slot)
		{
			foreach($_slot as $slot)
			{
				$q->orWhere("wallet_log_slot", $slot->slot_id);
			}
		});

		$query->limit($limit);

		$_reward = $query->orderBy("wallet_log_id", "desc")->get();

		foreach($_reward as $key => $reward)
		{
			$reward_slot = Tbl_mlm_slot::where("slot_id", $reward->wallet_log_slot)->first();
			$_reward[$key]->display_wallet_log_amount = Currency::format($reward->wallet_log_amount);
			$_reward[$key]->time_ago = time_ago($reward->wallet_log_date_created);
			$_reward[$key]->log = Self::customer_rewards_contructor($reward);
			$_reward[$key]->slot_no = $reward_slot->slot_no;
		}

		return $_reward;
	}
	public static function customer_rewards_contructor($reward)
	{
		switch ($reward->wallet_log_plan)
		{
			case 'DIRECT':
				$sponsor = Tbl_mlm_slot::where("slot_id", $reward->wallet_log_slot_sponsor)->first();
				$message = "You earned <b>" . Currency::format($reward->wallet_log_amount) . "</b> from <b><a href='javascript:'>direct referral bonus</a></b> because of <a href='javascript:'><b>" . $sponsor->slot_no . "</b></a>.";
			break;
			
			case 'TRIANGLE':
				$sponsor = Tbl_mlm_slot::where("slot_id", $reward->wallet_log_slot_sponsor)->first();
				$sponsor_sponsor = Tbl_mlm_slot::where("slot_id", $sponsor->slot_placement)->first();
				$message = "You earned <b>" . Currency::format($reward->wallet_log_amount) . "</b> from <b><a href='javascript:'>matrix bonus</a></b> because of pairing under <a href='javascript:'><b>" . $sponsor_sponsor->slot_no . "</b></a>.";
			break;

			default:
				$message = "NOTIFICATION UNKNOWN";
			break;
		}

		return $message;
	}
	public static function membership($shop_id)
	{
		$return = Tbl_membership::where("membership_archive", 0)->where("shop_id", $shop_id)->get();
		return $return;
	}
	public static function is_mlm_member($shop_id, $customer_id)
	{
 		$count_slots 	= Tbl_mlm_slot::where("slot_owner", $customer_id)->where("shop_id", $shop_id)->count();
 		$mlm_member     = ($count_slots > 0 ? true : false);
 		return $mlm_member;
	}
	public static function membership_info($shop_id, $membership_id)
	{
		$return = Tbl_membership::where("membership_archive", 0)->where("shop_id", $shop_id)->where("membership_id", $membership_id)->first();
		return $return;
	}
	public static function check_membership_code($shop_id, $pin, $activation)
	{
		return Tbl_membership::shop($shop_id)->codes($pin, $activation)->first();
	}
	public static function use_membership_code($shop_id, $pin, $activation, $slot_id_created, $remarks = null)
	{
		$update["mlm_slot_id_created"] 		= $slot_id_created;
		$update["record_consume_ref_name"] 	= "used";

		if($remarks)
		{
			$initial_record 					= Tbl_warehouse_inventory_record_log::codes($shop_id, $pin, $activation)->first();
			$update["record_item_remarks"]	 	= $initial_record->record_item_remarks . "\r\n" . $remarks;
		}

		Tbl_warehouse_inventory_record_log::codes($shop_id, $pin, $activation)->update($update);
	}
	public static function create_slot($shop_id, $customer_id, $membership_id, $sponsor, $slot_no = null, $slot_type = "PS")
	{
		if($slot_no)
		{
			$insert["slot_no"] = $slot_no;
		}

		$insert["shop_id"] 				= $shop_id;
		$insert["slot_owner"] 			= $customer_id;
		$insert["slot_membership"] 		= $membership_id;
		$insert["slot_sponsor"]			= $sponsor;
		$insert["slot_created_date"]	= Carbon::now();
		$insert["slot_status"]			= $slot_type;
		$insert["slot_placement"]		= 0;
		$insert["slot_position"]		= "";

		$rules["shop_id"] 				= ["required","exists:tbl_shop"];
		$rules["slot_owner"] 			= ["required","exists:tbl_customer,customer_id"];
		$rules["slot_membership"] 		= ["required","exists:tbl_membership,membership_id"];
		$rules["slot_sponsor"]			= ["required","exists:tbl_mlm_slot,slot_id"];
		$rules["slot_created_date"]		= ["required"];
		$rules["slot_status"]			= ["required"];


		Self::$shop_id					= $shop_id;
		$rules["slot_no"]				= 	Rule::unique('tbl_mlm_slot')->where(function ($query)
											{
    											$query->where('shop_id', Self::$shop_id);
											});

        $validator = Validator::make($insert, $rules);

		if ($validator->fails())
		{
			$errors = $validator->errors();
			foreach ($errors->all() as $message)
			{
				return $message;
			}
		}
		else
		{
			$slot_id = Tbl_mlm_slot::insertGetId($insert);
			return $slot_id;
		}
	}
}