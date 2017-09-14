<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_stairstep_distribute;
use App\Models\Tbl_stairstep_distribute_slot;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_user;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_stairstep_settings;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_shop;
use App\Models\Tbl_rank_update;
use App\Models\Tbl_rank_update_slot;
use App\Globals\Mlm_slot_log;
use App\Globals\Mlm_complan_manager;
use App\Globals\Mlm_member;
use Crypt;
use Redirect;
use Request;
use Carbon\Carbon;
use View;
use DB;

class MLM_RankController extends Member
{
	public function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
	}

    public function rank_stairstep_view()
    {
    	$shop_id = $this->getShopId();
    	$data["shop_id"] = $shop_id;
    	$data["_slot"]   = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id",$shop_id)
								  	   ->customer()
								  	   ->leftjoin("tbl_mlm_stairstep_settings","tbl_mlm_stairstep_settings.stairstep_id","=","tbl_mlm_slot.stairstep_rank")
								  	   ->leftJoin("tbl_mlm_slot_points_log","tbl_mlm_slot_points_log.points_log_slot","=","tbl_mlm_slot.slot_id")
								  	   ->select("*",DB::raw("SUM(CASE WHEN points_log_type = 'RPV' THEN points_log_points ELSE 0 END) AS rank_personal_points"),DB::raw("SUM(CASE WHEN points_log_type = 'RGPV' THEN points_log_points ELSE 0 END) AS rank_group_points"))
								  	   ->groupBy("slot_id")
								  	   ->take(1)
							  	  	   ->get();

    	

    	return view("member.mlm_stairstep.rank_update_stairstep",$data);
    }
    
    public function start()
    {
		$shop_id = $this->getShopId();

		$insert["total_slots"]						= Tbl_mlm_slot::where("shop_id",$shop_id)->count();
		$insert["shop_id"]							= $shop_id;				
		$insert["date_created"]						= Carbon::now();	
		$rank_update_id                             = Tbl_rank_update::insertGetId($insert);
		$data["slot_id"]							= Tbl_mlm_slot::where("shop_id",$shop_id)->orderBy()->first();
		$data["rank_update_id"]						= $rank_update_id;						  

    	return json_encode($data);
    }

    public function compute()
    {
    	$shop_id 		= $this->getShopId();

    	$start  		= Request::input("start_date");
    	$end    		= Request::input("end_date");
		$start 			= Carbon::parse($start);
		$end   			= Carbon::parse($end);
		$end            = $end->format("Y-m-d 23:59:59");

    	$distribute_id  = Request::input("distribute_id");
    	$slot_id 		= Request::input("slot_id");
    	

    	$distribute     = Tbl_stairstep_distribute::where("stairstep_distribute_start_date",$start)
    											  ->where("stairstep_distribute_end_date",$end)
    											  ->where("shop_id",$shop_id)
    											  ->where("complete",0)
    											  ->where("stairstep_distribute_id",$distribute_id)
    											  ->first();
		$slot_info      = Tbl_mlm_slot::where("slot_id",$slot_id)->first();
		if($slot_info)
		{		
	    	if($distribute)
	    	{
	    		$rpv                   = Tbl_mlm_slot_points_log::where("points_log_slot",$slot_id)
	    							   							->whereBetween('points_log_date_claimed', array($start, $end))
	    							   							->where("points_log_complan","STAIRSTEP")
	    							   							->where("points_log_type","RPV")
	    							   							->sum("points_log_points");

	    		$grpv                  = Tbl_mlm_slot_points_log::where("points_log_slot",$slot_id)
	    							   							->whereBetween('points_log_date_claimed', array($start, $end))
	    							   							->where("points_log_complan","STAIRSTEP")
	    							   							->where("points_log_type","RGPV")
	    							   							->sum("points_log_points");	

				$converted_pv          = Tbl_mlm_slot_points_log::where("points_log_slot",$slot_id)
	    							   							->whereBetween('points_log_date_claimed', array($start, $end))
	    							   							->where("points_log_complan","STAIRSTEP")
	    							   							->where("points_log_type","RPV")
	    							   							->where("points_log_converted","0")
	    							   							->sum("points_log_points");  
				// if($slot_id == 680)
				// {
				// 	dd($rpv,$grpv,$converted_pv,$start,$end);
				// }	
				    							   							
				if(!$rpv)
				{
					$rpv = 0;
				}  	
				if(!$grpv)
				{
					$grpv = 0;
				}  	
				if(!$converted_pv)
				{
					$converted_pv = 0;
				}                                                               
				$slot_stairstep        = Tbl_mlm_stairstep_settings::where("stairstep_id",$slot_info->stairstep_rank)->first();
	            $slot_stairstep_get    = Tbl_mlm_stairstep_settings::where("shop_id",$shop_id)
	                                                               ->where("stairstep_required_pv","<=",$rpv)
	                                                               ->where("stairstep_required_gv","<=",$grpv)
	                                                               ->orderBy("stairstep_level","DESC")
	                                                               ->get();

			    $sponsor_tree    = Tbl_tree_sponsor::where("sponsor_tree_child_id",$slot_id)->orderBy("sponsor_tree_level","ASC")->get();
		        $percentage      = null;
		        $check_stairstep = Tbl_mlm_stairstep_settings::where("shop_id",$shop_id)->first();
		        $slot_pv         = $converted_pv;

                if($slot_stairstep)
                {   
                	$computed_points = 0;
                	$append_info 	 = " (Rebates)"; 

                    if($slot_stairstep->stairstep_bonus != 0)
                    {
                        $computed_points = ($slot_stairstep->stairstep_bonus/100) * $slot_pv;
	                    $percentage = $slot_stairstep->stairstep_bonus;
                    }  
                    

	                if($computed_points > 0)
	                {         
	               	    $reduced_percent 						= $slot_stairstep->stairstep_bonus;    
	                    $log                                    = "You earned ".$reduced_percent."% of ".$converted_pv."(".$computed_points.") from slot #".$slot_info->slot_id."(Current Rank:".$slot_stairstep->stairstep_name.").";
	                    $arry_log['wallet_log_slot']            = $slot_id;
	                    $arry_log['shop_id']                    = $slot_info->shop_id;
	                    $arry_log['wallet_log_slot_sponsor']    = $slot_id;
	                    $arry_log['wallet_log_details']         = $log;
	                    $arry_log['wallet_log_amount']          = $computed_points;
	                    $arry_log['wallet_log_plan']            = "STAIRSTEP".$append_info;
	                    $arry_log['wallet_log_status']          = "n_ready";   
	                    $arry_log['wallet_log_claimbale_on']    = Mlm_complan_manager::cutoff_date_claimable('STAIRSTEP', $slot_info->shop_id); 
	                    Mlm_slot_log::slot_array($arry_log);    
	                }
                }

	            $check_if_change = 0;
	        	foreach($slot_stairstep_get as $slot_stairstep_new)
	        	{
	        		if(!$slot_stairstep)
	        		{
	        			$check_stair_level = 0;
	        		}
	        		else
	        		{
	        			$check_stair_level = $slot_stairstep->stairstep_level;
	        		}

	        		if($slot_stairstep_new->stairstep_level > $check_stair_level)
	        		{
		            	if($slot_stairstep_new->stairstep_leg_id != 0)
		            	{
		                	$leg_count = Tbl_tree_sponsor::where("sponsor_tree_parent_id",$slot_id)->child_info()->where("stairstep_rank",$slot_stairstep_new->stairstep_leg_id)->count();
		                	if($leg_count >= $slot_stairstep_new->stairstep_leg_count)
		                	{
			                	$update_slot["stairstep_rank"] = $slot_stairstep_new->stairstep_id;
			                	Tbl_mlm_slot::where("slot_id",$slot_id)->update($update_slot);
			                	$check_if_change = 1;
			                	break;
		                	}
		            	}
		            	else
		            	{
		                	$update_slot["stairstep_rank"] = $slot_stairstep_new->stairstep_id;
		            		Tbl_mlm_slot::where("slot_id",$slot_id)->update($update_slot);
		            		$check_if_change = 1;
		            		break;
		            	}
	        		}
	        	}

	        	if($check_if_change == 0)
	        	{
              //   	$update_slot["stairstep_rank"] = 0;
            		// Tbl_mlm_slot::where("slot_id",$slot_id)->update($update_slot);
	        	}



		        if($check_stairstep)
		        {
		            foreach($sponsor_tree as $placement)
		            {
		                $reduced_percent = 0;
		                $computed_points = 0;

	        	    	$slot_info      = Tbl_mlm_slot::where("slot_id",$placement->sponsor_tree_parent_id)->first();
	        	    	$slot_stairstep = Tbl_mlm_stairstep_settings::where("shop_id",$shop_id)->where("stairstep_id",$slot_info->stairstep_rank)->first();
	        	    	
	        	    	if($slot_stairstep)
	        	    	{
			                if(!$percentage)
			                {

			                	// $append_info = " (Over-ride)"; 
			                 //    if($slot_stairstep->stairstep_bonus != 0)
			                 //    {
			                 //        $computed_points = ($slot_stairstep->stairstep_bonus/100) * $slot_pv;
			                 //    }         

			                 //    $percentage      = $slot_stairstep->stairstep_bonus;
			                 //    $reduced_percent = $slot_stairstep->stairstep_bonus;
			                }
			                else
			                {           
			                    $append_info = " (Over-ride)";                            
			                    if($slot_stairstep->stairstep_bonus > $percentage)
			                    { 
			                        if($slot_stairstep->stairstep_bonus != 0)
			                        {
			                            $reduced_percent = $slot_stairstep->stairstep_bonus - $percentage;
			                            if($reduced_percent > 0)
			                            {
			                                $computed_points = (($reduced_percent)/100) * $slot_pv;
			                                $percentage      = $slot_stairstep->stairstep_bonus;
			                            }
			                        }    
			                    }
			                }
	        	    	}

		                if($computed_points > 0)
		                {             
		                    $log                                    = "You earned ".$reduced_percent."% of ".$converted_pv."(".$computed_points.") from slot #".$slot_id."(Current Rank:".$slot_stairstep->stairstep_name.").";
		                    $arry_log['wallet_log_slot']            = $placement->sponsor_tree_parent_id;
		                    $arry_log['shop_id']                    = $slot_info->shop_id;
		                    $arry_log['wallet_log_slot_sponsor']    = $placement->sponsor_tree_parent_id;
		                    $arry_log['wallet_log_details']         = $log;
		                    $arry_log['wallet_log_amount']          = $computed_points;
		                    $arry_log['wallet_log_plan']            = "STAIRSTEP".$append_info;
		                    $arry_log['wallet_log_status']          = "n_ready";   
		                    $arry_log['wallet_log_claimbale_on']    = Mlm_complan_manager::cutoff_date_claimable('STAIRSTEP', $slot_info->shop_id); 
		                    Mlm_slot_log::slot_array($arry_log);    
		                }
		            }
		        }

                $update_points["points_log_converted"] 		= 1;
                $update_points["points_log_converted_date"] = Carbon::now();

                Tbl_mlm_slot_points_log::where("points_log_slot",$slot_id)
						   							->whereBetween('points_log_date_claimed', array($start, $end))
						   							->where("points_log_complan","STAIRSTEP")
						   							->where("points_log_type","RPV")
						   							->where("points_log_converted","0")
						   							->update($update_points); 

                Tbl_mlm_slot_points_log::where("points_log_slot",$slot_id)
						   							->whereBetween('points_log_date_claimed', array($start, $end))
						   							->where("points_log_complan","STAIRSTEP")
						   							->where("points_log_type","RGPV")
						   							->where("points_log_converted","0")
						   							->update($update_points); 

		        $insert_distri["stairstep_distribute_id"] = $distribute_id;
		        $insert_distri["slot_id"] 				  = $slot_id;
		        Tbl_stairstep_distribute_slot::insert($insert_distri);

		        $get_new_slot     = $this->get_new_slot($distribute_id);

		        if($get_new_slot)
		        {
		    		$data["status"]   = "Success";
		    		$data["slot_id"]  = $get_new_slot->slot_id;
		        }	
		        else
		        {
		        	$update_distri["complete"] = 1;
		        	Tbl_stairstep_distribute::where("stairstep_distribute_id")->update($update_distri);

		    		$data["status"]   = "Complete";
		    		$data["message"]  = "Complete";
		        }							
	    	}
	    	else
	    	{
	    		$data["status"]   = "Error";
	    		$data["message"]  = "Please try it again.";
	    	}
		}
		else
		{
    		$data["status"]   = "Error";
    		$data["message"]  = "No slot error.";		
		}

		return json_encode($data);
    }
}