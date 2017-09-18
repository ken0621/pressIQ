<?php
namespace App\Globals;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_tree_placement;
use App\Globals\Mlm_tree;
use App\Models\Tbl_warehouse_inventory_record_log;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_points_log;
use Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;
use stdClass;
use DB;

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
			$_slot[$key]->display_total_earnings = Currency::format($slot->total_earnings);

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