<?php
namespace App\Globals;
use App\Models\Tbl_membership;

class MLM2
{
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