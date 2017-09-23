<?php
namespace App\Globals;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_warehouse_inventory_record_log;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_customer;
use App\Models\Tbl_brown_rank;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_item;
use App\Models\Tbl_mlm_item_points;
use App\Globals\Mlm_tree;
use App\Globals\Mlm_complan_manager;
use App\Globals\Mlm_complan_manager_cd;
use App\Globals\Mlm_compute;

use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Validator;
use stdClass;
use DB;

class MLM2
{
	
	public static $shop_id;

	public static function get_sponsor_network($shop_id, $slot_no)
	{
		$slot_id = Tbl_mlm_slot::where("shop_id", $shop_id)->where("slot_no", $slot_no)->value("slot_id");
		$_tree = Tbl_tree_sponsor::where("sponsor_tree_parent_id", $slot_id)->orderBy("sponsor_tree_level")->child_info()->customer()->get();
	
		foreach($_tree as $key => $tree)
		{
			$_tree[$key]->ordinal_level = ordinal($tree->sponsor_tree_level) . " Level";
			$_tree[$key]->display_slot_date_created = date("F d, Y", strtotime($tree->slot_created_date));
		}

		return $_tree;
	}	
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


			if($slot->brown_rank_id == null)
			{
				$slot->brown_rank_id = Tbl_brown_rank::where("rank_shop_id", $shop_id)->orderBy("required_slot", "asc")->value("rank_id");
			}

			/* BROWN RANKING - TODO: FOR MYPHONE ONLY */
            if($slot->brown_rank_id)
            {
                $brown_next_rank = Tbl_brown_rank::where("rank_id",">", $slot->brown_rank_id)->orderBy("rank_id")->first();
            }
            else
            {
                $brown_next_rank = null;
            }

            if($brown_next_rank)
            {
                $_slot[$key]->brown_next_rank = strtoupper($brown_next_rank->rank_name);
                $brown_rank_required_slots = $brown_next_rank->required_slot;
                $brown_count_required = Tbl_tree_sponsor::where("sponsor_tree_parent_id", $slot->slot_id)->where("sponsor_tree_level", "<=", $brown_next_rank->required_uptolevel)->count();
                
                $_slot[$key]->brown_next_rank_requirements = $brown_rank_required_slots;
                $_slot[$key]->brown_next_rank_current = $brown_count_required;

                $_slot[$key]->required_direct = $brown_next_rank->required_direct;
                $_slot[$key]->current_direct = Tbl_tree_sponsor::where("sponsor_tree_parent_id", $slot->slot_id)->where("sponsor_tree_level", "=", 1)->count();;


                $_slot[$key]->brown_direct_rank_percentage = ($_slot[$key]->current_direct / $_slot[$key]->required_direct) * 100;
                $_slot[$key]->brown_rank_rank_percentage = ($brown_count_required / $brown_rank_required_slots) * 100;
            }
            else
            {
                $_slot[$key]->brown_next_rank = strtoupper("NO NEXT RANK");
                $brown_rank_required_slots = "NO NEXT RANK";
                $brown_count_required = "NO NEXT RANK";
                $_slot[$key]->brown_next_rank_requirements = "NO NEXT RANK";
            }

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
		$return["_wallet"]->complan_triangle = 0;
		
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
	public static function customer_direct($shop_id, $customer_id, $limit = 10)
	{
		$_slot = Tbl_mlm_slot::where("slot_owner", $customer_id)->get();

		$query = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id", $shop_id)->customer();

		$query->where(function($q) use ($_slot)
		{
			foreach($_slot as $slot)
			{
				$q->orWhere("slot_sponsor", $slot->slot_id);
			}
		});

		$query->limit($limit);

		$_direct = $query->orderBy("slot_id", "desc")->get();

		foreach($_direct as $key => $direct)
		{
			$_direct[$key]->time_ago = time_ago($direct->slot_created_date);
		}

		return $_direct;

	}
	public static function customer_rewards($shop_id, $customer_id, $limit = 10)
	{
		$_slot = Tbl_mlm_slot::where("slot_owner", $customer_id)->get();
		$query = Tbl_mlm_slot_wallet_log::where("shop_id", $shop_id);

		$query->where(function($q) use ($_slot)
		{
			foreach($_slot as $slot)
			{
				$q->orWhere("wallet_log_slot", $slot->slot_id);
			}
		});

		$query->where("wallet_log_amount", ">", 0);

		

		if($limit == 0)
		{
			$_reward = $query->orderBy("wallet_log_id", "desc")->paginate(10);
			$store_pagine["notification_paginate"] = $_reward->render();
			session($store_pagine);
		}
		else
		{
			$query->limit($limit);
			$_reward = $query->orderBy("wallet_log_id", "desc")->get();
		}
		

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
				$message = "You earned <b>" . Currency::format($reward->wallet_log_amount) . "</b> from <b><a href='javascript:'>pairing bonus</a></b> because of pairing under <a href='javascript:'><b>" . $sponsor_sponsor->slot_no . "</b></a>.";
			break;

			case 'BINARY':
				$sponsor = Tbl_mlm_slot::where("slot_id", $reward->wallet_log_slot_sponsor)->first();
				$sponsor_sponsor = Tbl_mlm_slot::where("slot_id", $sponsor->slot_placement)->first();
				$message = "You earned <b>" . Currency::format($reward->wallet_log_amount) . "</b> from <b><a href='javascript:'>pairing bonus</a></b> because of pairing under <a href='javascript:'><b>" . $sponsor_sponsor->slot_no . "</b></a>.";
			break;

			default:
				$message = $reward->wallet_log_plan;
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
		$insert["distributed"]			= 0;

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
			$slot_id    	  = Tbl_mlm_slot::insertGetId($insert);
			$sponsor_slot 	  = Tbl_mlm_slot::where("slot_id",$sponsor)->where("shop_id",$shop_id)->first();
			$customer_sponsor = Tbl_customer::where("shop_id",$shop_id)->where("customer_id",$sponsor_slot->slot_owner)->first();

			if($customer_sponsor->downline_rule == "auto")
			{
				$rules    = $customer_sponsor->autoplacement_rule;
				MLM2::matrix_auto($shop_id,$slot_id,$rules);
			}

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

	        Mlm_tree::insert_tree_sponsor($slot_info_e, $slot_info_e, 1); 
       		Mlm_tree::insert_tree_placement($slot_info_e, $slot_info_e, 1);
       		MLM2::entry($shop_id,$slot_id);
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
    					MLM2::entry($shop_id,$slot_id);
    	}
		else if($rule == "autofill")
		{
			$response = MLM2::matrix_position_auto_balance($shop_id,$slot_id);
						MLM2::entry($shop_id,$slot_id);
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
        Mlm_tree::insert_tree_sponsor($slot_info_e, $slot_info_e, 1);
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
                    Mlm_tree::insert_tree_sponsor($slot_info_e, $slot_info_e, 1);
                    Mlm_tree::insert_tree_placement($slot_info_e, $slot_info_e, 1);
                }
            }
        }

        return "success";
    }
    public static function check_placement_exist($shop_id,$placement,$position,$self_downline = 0,$self_owner = null)
    {
        $count_tree_if_exist 		= Tbl_tree_placement::where('placement_tree_position', $position)
                        								->where('placement_tree_parent_id', $placement)
                        								->where('shop_id', $shop_id)
                        								->count();

	    if($count_tree_if_exist != 0 || !$placement ||  !$position)
	    {
	    	return 1;
	    } 
	    else if ($self_downline == 1)
	    {
	    	/* IF DOWNLINE ONLY OF $SELF_OWNER*/
		    $check_shop_slot            = Tbl_mlm_slot::where("slot_id",$placement)->where("shop_id",$shop_id)->where("slot_placement","!=",0)->first();
		    if($check_shop_slot)
		    {	
		    	if($check_shop_slot->slot_sponsor == $self_owner)
		    	{
		    		return 0;
		    	}
		    	else
		    	{
		    		$owned = Tbl_tree_placement::where('placement_tree_parent_id', $self_owner)
		    								   ->where('placement_tree_child_id',$placement)
                							   ->where('shop_id', $shop_id)
                							   ->first();
                    if($owned)
                    {
                    	return 0;
                    }            
                    else
                    {
                    	return 1;
                    }    							   
		    	}
		    }
		    else
		    {	
	    		return 1;
		    }
	    }  
	    else
	    {
		    $check_shop_slot            = Tbl_mlm_slot::where("slot_id",$placement)->where("shop_id",$shop_id)->where("slot_placement","!=",0)->first();
		    if($check_shop_slot)
		    {	
		    	return 0;
		    }
		    else
		    {	
	    		return 1;
		    }
	    }                  								
    }
	public static function entry($shop_id,$slot_id)
	{
        $slot_info = Tbl_mlm_slot::where('slot_id', $slot_id)->where("tbl_mlm_slot.shop_id",$shop_id)
        						 ->membership()
        						 ->membership_points()
        						 ->customer()
        						 ->first();
            // Mlm Computation Plan
            $plan_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Slot Creation')
            ->get();

            if($slot_info->slot_status == 'PS')
            {
                foreach($plan_settings as $key => $value)
                {
                    $plan = strtolower($value->marketing_plan_code);
                    $a = Mlm_complan_manager::$plan($slot_info);
                }
            }
            else if($slot_info->slot_status == 'CD')
            {
                $a = Mlm_complan_manager_cd::enter_cd($slot_info);

            }
            else if($slot_info->slot_status == 'FS')
            {
                // no income for fs.
            }



            // check if there are cd graduate
            $b = Mlm_complan_manager_cd::graduate_check($slot_info);
            // $c = Mlm_gc::slot_gc($slot_id);

            Mlm_compute::set_slot_nick_name_2($slot_info);

            $update_slot["distributed"] = 1;
            Tbl_mlm_slot::where("slot_id",$slot_id)->where("shop_id",$shop_id)->update($update_slot);
            // End Computation Plan
	}
	public static function purchase($shop_id, $slot_id, $item_id)
	{
		$data = MLM2::item_points($shop_id,$item_id);
		if($data)
		{
			MLM_compute::repurchasev2($slot_id,$shop_id,$data);
		}
	}	
	public static function item_points($shop_id,$item_id)
	{
        $item          = Tbl_item::where("item_id",$item_id)->where("shop_id",$shop_id)->first();  
        $item_points   = Tbl_mlm_item_points::where("item_id",$item_id)->first();     
        if($item)
        {
	        $data["UNILEVEL"]					= $item_points->UNILEVEL;
			$data["REPURCHASE_POINTS"]			= $item_points->REPURCHASE_POINTS;
			$data["UNILEVEL_REPURCHASE_POINTS"]	= $item_points->UNILEVEL_REPURCHASE_POINTS;
			$data["REPURCHASE_CASHBACK"]		= $item_points->REPURCHASE_CASHBACK;
			$data["DISCOUNT_CARD_REPURCHASE"]	= $item_points->DISCOUNT_CARD_REPURCHASE;
			$data["STAIRSTEP"]					= $item_points->STAIRSTEP;
			$data["BINARY_REPURCHASE"]			= $item_points->BINARY_REPURCHASE;
			$data["STAIRSTEP_GROUP"]			= $item_points->STAIRSTEP_GROUP;
			$data["RANK"]						= $item_points->RANK;
			$data["RANK_GROUP"]					= $item_points->RANK_GROUP;
			$data["price"]						= $item->item_price;

			return $data;
        }
        else
        {
        	return null;
        }
	}
}