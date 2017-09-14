<?php
namespace App\Globals;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_slot;


class MLM2
{
	public static function verify_sponsor($shop_id, $sponsor_key)
	{
		$slot_info = Tbl_mlm_slot::shop($shop_id)->where("slot_nick_name", $sponsor_key)->where("slot_defaul", 1)->first();

		if(!$slot_info)
		{
			$slot_info = Tbl_mlm_slot::shop($shop_id)->where("slot_no", $sponsor_key)->first();
		}

		return $slot_info;
	}
	public static function membership($shop_id)
	{
		$return = Tbl_membership::where("membership_archive", 0)->where("shop_id", $shop_id)->get();
		return $return;
	}
	public static function membership_info($shop_id, $membership_id)
	{
		$return = Tbl_membership::where("membership_archive", 0)->where("shop_id", $shop_id)->where("membership_id", $membership_id)->first();
		return $return;
	}
}