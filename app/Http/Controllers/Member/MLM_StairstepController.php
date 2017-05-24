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
use App\Globals\Mlm_slot_log;
use App\Globals\Mlm_complan_manager;
use Crypt;
use Redirect;
use Request;
use Carbon\Carbon;
use View;


class MLM_StairstepController extends Member
{
	public function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
	}

    public function index()
    {
        return view("member.mlm_stairstep.stairstep");
    }

    public function start()
    {
    	$start  		= Request::input("start_date");
    	$end    		= Request::input("end_date");
    	if($start && $end)
    	{
    		$start   = date("Y-m-d H:i:s", strtotime($start));
    		$end     = date("Y-m-d H:i:s", strtotime($end));
    		$shop_id = $this->getShopId();

    		$distribute = Tbl_stairstep_distribute::where("stairstep_distribute_start_date",$start)
    											  ->where("stairstep_distribute_end_date",$end)
    											  ->where("shop_id",$shop_id)
    											  ->where("complete",0)
    											  ->first();

    		if(!$distribute)
    		{
    			$insert["stairstep_distribute_start_date"]	= $start;
    			$insert["stairstep_distribute_end_date"]	= $end;
    			$insert["shop_id"]							= $shop_id;				
    			$insert["date_created"]						= Carbon::now();	
    			$distribute_id                              = Tbl_stairstep_distribute::insertGetId($insert);
    		}	
    		else
    		{
    			$distribute_id = $distribute->stairstep_distribute_id;
    		}								  

	        $get_new_slot     = $this->get_new_slot($distribute_id);
            
            if(!$get_new_slot)
            {
				$insert["stairstep_distribute_start_date"]	= $start;
    			$insert["stairstep_distribute_end_date"]	= $end;
    			$insert["shop_id"]							= $shop_id;				
    			$insert["date_created"]						= Carbon::now();	
    			$distribute_id                              = Tbl_stairstep_distribute::insertGetId($insert);
    			
		        $get_new_slot     							= $this->get_new_slot($distribute_id);
            }	
   

            if($get_new_slot)
            {
            	$data["status"]		   = "Success";
            	$data["slot_id"] 	   = $get_new_slot->slot_id;
            	$data["start_date"]    = $start;
            	$data["end_date"] 	   = $end;
            	$data["distribute_id"] = $distribute_id;
            }
            else
            {
            	$data["status"]		   = "Failed";
            	$data["message"]	   = "No slot to convert";
            }
    	}
    	else
    	{
    		$data["status"] = "Error";
    		$data["error"]  = "Please fill the start date and end date.";
    	}

    	return json_encode($data);
    }

    public function compute()
    {
    	$shop_id 		= $this->getShopId();

    	$start  		= Request::input("start_date");
    	$end    		= Request::input("end_date");
		$start 			= Carbon::parse($start);
		$end   			= Carbon::parse($end);

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
	               	    $reduced_percent = $slot_stairstep->stairstep_bonus;    
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

	        	if($check_if_change == 0)
	        	{
                	$update_slot["stairstep_rank"] = 0;
            		Tbl_mlm_slot::where("slot_id",$slot_id)->update($update_slot);
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

    public function get_new_slot($distribute_id)
    {
    	$shop_id = $shop_id = $this->getShopId();
    	$slot 	 = Tbl_stairstep_distribute_slot::where("stairstep_distribute_id",$distribute_id)->orderBy("slot_id","ASC")->first();

    	if(!$slot)
    	{	
    		$returned_slot = Tbl_mlm_slot::where("shop_id",$shop_id)->orderBy("slot_id","DESC")->first();
    	}
    	else
    	{
    		$returned_slot = Tbl_mlm_slot::where("shop_id",$shop_id)->where("slot_id","<",$slot->slot_id)->orderBy("slot_id","DESC")->first();
    	}

		return $returned_slot;
    }
}