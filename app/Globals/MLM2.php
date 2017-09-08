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
}