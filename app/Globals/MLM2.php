<?php
namespace App\Globals;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_tree_placement;
use App\Globals\Mlm_tree;
use DB;
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
	public static function matrix_position($shop_id, $slot_id, $placement, $position)
	{
		if($position == "left" || $position == "right")
		{	
			$update["slot_placement"]  = $placement;
			$update["slot_position"]   = strtolower($position);
			Tbl_mlm_slot::where("shop_id",$shop_id)->where("slot_id",$slot_id)->update($update);

	        $slot_info_e = Tbl_mlm_slot::where('slot_id', $slot_id)->first();
       		Mlm_tree::insert_tree_placement($slot_info_e, $slot_info_e, 1);
			return "success";
		}
		else
		{
			return "Wrong position";
		}
    }
    public static function matrix_auto($shop_id, $slot_id, $rule)
    {
    	if($rule == "random")
    	{
    		$response = MLM2::matrix_position_random($shop_id,$slot_id);
    	}
		else if($rule == "auto_balance")
		{
			$response = MLM2::matrix_position_auto_balance($shop_id,$slot_id);
		}
		else
		{
			$response = "Rule does not exists";
		}
		
		// else if($rule == "extreme_left")
		// {

		// }
		// else if($rule == "extreme_right")
		// {

		// }


		return $response;
    }
    public static function matrix_position_random($shop_id,$slot_id)
    {
        $array_position             = array("left", "right");

        /* INITIALIZE AND CAPTURE DATA */
        $random_placement           = Tbl_mlm_slot::where("shop_id", $shop_id)->orderBy(DB::raw("rand()"))->value("slot_id");  
        $random_position            = $array_position[array_rand($array_position)];

        /* POSITIONING DATA */
        $slot_placement             = $random_placement;
        $slot_position              = $random_position;
        $placement_exist            = MLM2::check_placement_exist($shop_id,$random_placement,$random_position);

        /* RANDOM WHILE PLACEMENT IS STILL TAKEN */
        while($placement_exist == 1)
        {
        	$random_position   = $array_position[array_rand($array_position)];
            $random_placement  = Tbl_mlm_slot::where("shop_id", $shop_id)->orderBy(DB::raw("rand()"))->value("slot_id"); 
            $placement_exist   = MLM2::check_placement_exist($shop_id,$random_placement,$random_position);
        }


        $update["slot_placement"] = $random_placement;
        $update["slot_position"]  = $random_position;
        Tbl_mlm_slot::where("slot_id",$slot_id)->where("shop_id",$shop_id)->update($update);

        $slot_info_e = Tbl_mlm_slot::where('slot_id', $slot_id)->first();
        Mlm_tree::insert_tree_placement($slot_info_e, $slot_info_e, 1);

        return "success";
    }
    public static function matrix_position_auto_balance($shop_id,$slot_id)
    {
    	$slot_info = Tbl_mlm_slot::where("shop_id",$shop_id)->where("slot_id",$slot_id)->first();

        if($slot_info->slot_sponsor != 0 && $slot_info->slot_sponsor != null)
        {
            $sponsor = Tbl_mlm_slot::where("slot_id",$slot_info->slot_sponsor)->first();
            if($sponsor)
            {
                $condition_update = false;
                $current_level = $sponsor->current_level;
                while($condition_update == false)
                {                 
                    if($current_level == 0)
                    {
                        $check_placement = Tbl_mlm_slot::where("slot_placement",$slot_info->slot_sponsor)->where("slot_position","left")->first();
                        if(!$check_placement)
                        {
                            $slot_placement   = $slot_info->slot_sponsor;
                            $slot_position    = "left";
                            $slot_level       = 0;
                            $condition_update = true;
                            break;
                        }
                        else
                        {
                           $check_placement = Tbl_mlm_slot::where("slot_placement",$slot_info->slot_sponsor)->where("slot_position","right")->first();
                           if(!$check_placement)
                           {
                             $slot_placement   = $slot_info->slot_sponsor;
                             $slot_position    = "right";
                             $slot_level       = 1;
                             $condition_update = true;
                             break;
                           }
                        }
                    }
                    else
                    {
                        $placement_tree = Tbl_tree_placement::where("placement_tree_parent_id",$sponsor->slot_id)->where("placement_tree_level",$current_level)->childslot()->orderBy("tbl_mlm_slot.auto_balance_position","ASC")->get();
                        $current_count  = Tbl_tree_placement::where("placement_tree_parent_id",$sponsor->slot_id)->where("placement_tree_level",$current_level + 1)->childslot()->orderBy("tbl_mlm_slot.auto_balance_position","ASC")->count();
                        $max_count      = pow(2, $current_level + 1);
                        if($current_count < $max_count)
                        {   
                            $condition_right = true;

                            foreach($placement_tree as $placement)
                            {
                                $check_placement = Tbl_mlm_slot::where("slot_placement",$placement->placement_tree_child_id)->where("slot_position","left")->first();
                                if(!$check_placement)
                                {
                                    $slot_placement   = $placement->placement_tree_child_id;
                                    $slot_position    = "left";
                                    $condition_update = true;
                                    $condition_right  = false;
                                    if(($current_count + 1) >= $max_count)
                                    {
                                        $slot_level = $current_level + 1;
                                    }
                                    else
                                    {
                                        $slot_level = $current_level;
                                    }
                                    break;
                                }
                            }


                            if($condition_right == true)
                            {
                                foreach($placement_tree as $placement)
                                {
                                    $check_placement = Tbl_mlm_slot::where("slot_placement",$placement->placement_tree_child_id)->where("slot_position","right")->first();
                                    if(!$check_placement)
                                    {
                                        $slot_placement   = $placement->placement_tree_child_id;
                                        $slot_position    = "right";
                                        $condition_update = true;
                                        $condition_right  = false;
                                        if(($current_count + 1) >= $max_count)
                                        {
                                            $slot_level = $current_level + 1;
                                        }
                                        else
                                        {
                                            $slot_level = $current_level;
                                        }
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    $current_level++;
                }



                if($condition_update == true)
                {
                    $update_sponsor['current_level']  = $slot_level;
                    Tbl_mlm_slot::where('slot_id', $slot_info->slot_sponsor)->update($update_sponsor);

                    // got the slot
                    $update['slot_placement'] = $slot_placement;
                    $update['slot_position']  = $slot_position;

                    Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->update($update);

                    $slot_info_e = Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->first();
                    Mlm_tree::insert_tree_placement($slot_info_e, $slot_info_e, 1);
                }
            }
        }

        return "success";
    }
    public static function check_placement_exist($shop_id,$placement,$position)
    {
        $count_tree_if_exist 		= Tbl_tree_placement::where('placement_tree_position', $position)
                        								->where('placement_tree_parent_id', $placement)
                        								->where('shop_id', $shop_id)
                        								->count();
	    
	    if($count_tree_if_exist != 0)
	    {
	    	return 1;
	    }   
	    else
	    {
	    	return 0;
	    }                  								
    }
}