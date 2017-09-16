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
	public static function check_membership_code($shop_id, $pin, $activation)
	{
		return Tbl_membership::shop($shop_id)->codes($pin, $activation)->first();
	}
	public static function create_slot($shop_id, $customer_id, $membership_id, $sponsor, $slot_no = null)
	{
		// slot_id	int(10) unsigned Auto Increment	 
		// slot_no	varchar(255) [0]	 
		// shop_id	int(10) unsigned NULL	 
		// slot_owner	int(10) unsigned NULL	 
		// slot_membership	int(10) unsigned NULL	 
		// slot_sponsor	int(10) unsigned NULL	 
		// slot_created_date	datetime	 
		// slot_status	varchar(255) []	 
		// slot_rank	int(11) [0]	 
		// slot_placement	int(10) unsigned NULL [0]	 
		// slot_position	varchar(255) [left]	 
		// slot_binary_left	int(11) [0]	 
		// slot_binary_right	int(11) [0]	 
		// slot_wallet_all	int(11) [0]	 
		// slot_wallet_withdraw	int(11) [0]	 
		// slot_wallet_current	int(11) [0]	 
		// slot_pairs_per_day_date	timestamp [CURRENT_TIMESTAMP]	 
		// slot_pairs_current	double [0]	 
		// slot_pairs_gc	double [0]	 
		// slot_personal_points	double	 
		// slot_group_points	double	 
		// slot_upgrade_points	double	 
		// slot_active	tinyint(4) [0]	 
		// slot_card_printed	int(11) [0]	 
		// slot_nick_name	varchar(255) NULL	 
		// slot_defaul	int(11) [0]	 
		// slot_card_issued	datetime	 
		// current_level	int(11) [0]	 
		// auto_balance_position	int(11) [1]	 
		// slot_matched_membership	int(11) [0]	 
		// stairstep_rank	int(10) unsigned [0]	 
		// upgraded	tinyint(4) [0]	 
		// upgrade_from_membership	int(11)	 
		// brown_rank_id	int(11) NULL

		if($slot_no)
		{
			$insert["slot_no"] = $slot_no;
		}

		$insert["shop_id"] = $shop_id;
		
		

		return "May Problema ata?";
	}
}