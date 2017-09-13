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
use App\Globals\Mlm_slot_log;
use App\Globals\Mlm_complan_manager;
use Crypt;
use Redirect;
use Request;
use Carbon\Carbon;
use View;
use DB;

class MLM_StairstepController extends Member
{
	public function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
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
    		$end     = date("Y-m-d 23:59:59", strtotime($end));
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

    public function stairstep_view()
    {
    	$shop_id 		  = $this->getShopId();
		$data["_history"] = Tbl_stairstep_distribute::where("tbl_stairstep_distribute.shop_id",$shop_id)
													->leftJoin("tbl_stairstep_distribute_slot","tbl_stairstep_distribute_slot.stairstep_distribute_id","=","tbl_stairstep_distribute.stairstep_distribute_id")
								  				    ->leftJoin("tbl_mlm_slot","tbl_mlm_slot.slot_id","=","tbl_stairstep_distribute_slot.slot_id")
											        ->leftJoin("tbl_customer","tbl_customer.customer_id","=","tbl_mlm_slot.slot_owner")  
    								  				->groupBy("tbl_stairstep_distribute_slot.stairstep_distribute_id")
    								  				->select("tbl_stairstep_distribute.*",DB::raw("COUNT('tbl_stairstep_distribute_slot.slot_id') as total_processed_slot"))
													->get();		

    	$start  = Request::input("start");
    	$end    = Request::input("end");
    		
    	if(!$start)	
    	{
    		$start = $this->get_start_date();
    	}

    	if(!$end)
    	{
    		$end   = $this->get_end_date($start);
    	}

    	$data["_slot"]    = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id",$shop_id)
    								  	->customer()
    								  	->leftjoin("tbl_mlm_stairstep_settings","tbl_mlm_stairstep_settings.stairstep_id","=","tbl_mlm_slot.stairstep_rank")
    								  	->leftJoin("tbl_mlm_slot_points_log","tbl_mlm_slot_points_log.points_log_slot","=","tbl_mlm_slot.slot_id")
    								  	->select("*",DB::raw("SUM( ( CASE WHEN points_log_type = 'SGPV' AND points_log_date_claimed >= '".Carbon::parse($start)->format("Y-m-d 00:00:00")."' AND points_log_date_claimed <= '".Carbon::parse($end)->format("Y-m-d 23:59:59")."' THEN points_log_points ELSE 0 END ) ) AS stairstep_points")
    								  				,DB::raw("SUM( ( CASE WHEN points_log_type = 'SPV' AND points_log_date_claimed >= '".Carbon::parse($start)->format("Y-m-d 00:00:00")."' AND points_log_date_claimed <= '".Carbon::parse($end)->format("Y-m-d 23:59:59")."' THEN points_log_points ELSE 0 END ) ) AS personal_stairstep"))
    								  	->groupBy("slot_id")
								  	  	->get();
    								  	// ->where("points_log_date_claimed",">=",Carbon::parse($start)->format("Y-m-d 00:00:00"))
    								  	// ->where("points_log_date_claimed","<=",Carbon::parse($end)->format("Y-m-d 23:59:59"))


	

		
    	$data["start"] = $start;
    	$data["end"]   = $end;
    	// dd($start,$end);
    	return view("member.mlm_stairstep.stairstep_distribution",$data);
    }

    public function distribution_submit()
    {
    	$start  	= Carbon::parse(Request::input("start_date"))->format("Y-m-d 00:00:00");
    	$end    	= Carbon::parse(Request::input("end_date"))->format("Y-m-d 23:59:59");
    	$shop_id	= $this->getShopId();

    	if($start && $end)
    	{
    		$distribute = Tbl_stairstep_distribute::where("stairstep_distribute_start_date",$start)
    											  ->where("stairstep_distribute_end_date",$end)
    											  ->where("shop_id",$shop_id)
    											  ->where("complete",0)
    											  ->first();

	    	$slot 		= Tbl_mlm_slot::where("shop_id",$shop_id)->get();
	    	$first_slot = Tbl_mlm_slot::where("shop_id",$shop_id)->orderBy("slot_id","ASC")->first();
	    	$last_slot  = Tbl_mlm_slot::where("shop_id",$shop_id)->orderBy("slot_id","DESC")->first();

    		if(!$distribute)
    		{
    			$first                                      = $first_slot ? $first_slot->slot_id : 0;
    			$last                                       = $last_slot ? $last_slot->slot_id : 0;

    			$insert["stairstep_distribute_start_date"]	= $start;
    			$insert["stairstep_distribute_end_date"]	= $end;
    			$insert["shop_id"]							= $shop_id;				
				$insert["from_slot_id"]						= $first;				
				$insert["to_slot_id"]						= $last;				
				$insert["total_slot"]						= count($slot);
    			$insert["date_created"]						= Carbon::now();	
    			$distribute_id                              = Tbl_stairstep_distribute::insertGetId($insert);
    		}	
    		else
    		{
    			$first                                      = $distribute->from_slot_id;
    			$last                                       = $distribute->to_slot_id;
    			$distribute_id 								= $distribute->stairstep_distribute_id;
    		}		

			$slot 	 		= Tbl_stairstep_distribute_slot::where("stairstep_distribute_id",$distribute_id)->orderBy("slot_id","ASC")->first();
    		$slot_lists 	= Tbl_mlm_slot::where("slot_id",">=",$first)
    								  	  ->where("slot_id","<=",$last);  

			if($slot)
			{
				$slot_lists = $slot_lists->where("slot_id","<",$slot);
			}
			else
			{
				$slot_lists = $slot_lists->where("slot_id","<=",$last);
			}

    		$slot_lists     = $slot_lists->where("shop_id",$shop_id)
    								  	 ->orderBy("slot_id","DESC")
    								  	 ->get();

    		// dd($slot_lists);						  	  
            if($slot_lists)
            {
            	$data["status"]		   = "Success";
            }
            else
            {
            	$update_distribute["complete"]     = 1;
            	$data["status"]		   			   = "Error";
            	$data["message"]	   			   = "No slot to convert, please try again";

				Tbl_stairstep_distribute::where("distribute_id",$distribute_id)->update($update_distribute);
            }
    	}
    	else
    	{
    		$data["status"]   = "Error";
    		$data["message"]  = "Please fill the start date and end date.";
    	}


		if($data["status"] == "Error")
		{
			return Redirect::to("/member/mlm/stairstep/distribution")->with('Error',$data["message"]);
		}
		else if($data["status"] == "Success")
		{
			foreach($slot_lists as $list)
			{
				$sgpv =  Tbl_mlm_slot_points_log::where("points_log_slot",$list->slot_id)
						   					    ->where('points_log_date_claimed',">=",$start)
						   					    ->where('points_log_date_claimed',"<=",$end)
						   					    ->where("points_log_complan","STAIRSTEP")
						   					    ->where("points_log_type","SGPV")
						   					    ->where("points_log_converted","0")
						   					    ->sum("points_log_points");		

		    	$spv  =  Tbl_mlm_slot_points_log::where("points_log_slot",$list->slot_id)
						   					    ->where('points_log_date_claimed',">=",$start)
						   					    ->where('points_log_date_claimed',"<=",$end)
						   					    ->where("points_log_complan","STAIRSTEP")
						   					    ->where("points_log_type","SPV")
						   					    ->where("points_log_converted","0")
						   					    ->sum("points_log_points");

				$settings         = Tbl_mlm_stairstep_settings::where("stairstep_id",$list->stairstep_rank)->first();
				$give_wallet      = 0;
				if($settings)
				{
					if($settings->commission_multiplier != 0)
					{
						$maintenance 	  = $settings->stairstep_pv_maintenance;
						if($spv >= $maintenance)
						{
							$give_wallet = $settings->commission_multiplier * $sgpv;
							if($give_wallet != 0)
							{
		   						$wallet_log_details = "Your slot ".$list->slot_no." earned ".$give_wallet." from Stairstep Bonus";    				   
		   						Mlm_slot_log::slot($list->slot_id, $list->slot_id, $wallet_log_details, $give_wallet, "STAIRSTEP", "released",Carbon::now());   				   
							}
						}
					}
				}	

				$update_log["points_log_converted"] = 1; 
		    	Tbl_mlm_slot_points_log::where("points_log_slot",$list->slot_id)
					    				   ->whereBetween('points_log_date_claimed', array($start, $end))
					    				   ->where("points_log_complan","STAIRSTEP")
					    				   ->where("points_log_type","SGPV")
					    				   ->where("points_log_converted","0")
					    				   ->update($update_log);

				$insert_distribute_slot["slot_id"]  				= $list->slot_id;
				$insert_distribute_slot["stairstep_distribute_id"]  = $distribute_id;
				$insert_distribute_slot["processed_current_rank"]   = $list->stairstep_rank;
				$insert_distribute_slot["processed_personal_pv"]    = $spv;
				$insert_distribute_slot["processed_required_pv"]    = $settings ? $settings->stairstep_pv_maintenance : 0;
				$insert_distribute_slot["processed_multiplier"]     = $settings ? $settings->commission_multiplier : 0;
				$insert_distribute_slot["processed_earned"]  	    = $give_wallet ? $give_wallet : 0;
				$insert_distribute_slot["processed_status"]  	    = 1;


				Tbl_stairstep_distribute_slot::insert($insert_distribute_slot);					    
			}

        	$update_distribute["complete"]     = 1;
			Tbl_stairstep_distribute::where("stairstep_distribute_id",$distribute_id)->update($update_distribute);


			return Redirect::to("/member/mlm/stairstep/distribution")->with('Success','Distribution success');
		}  	
    }

    public function view_summary()
    {
    	$id 		= Request::input("id");
    	$shop_id 	= $this->getShopId();

        $distribute         = Tbl_stairstep_distribute::where("stairstep_distribute_id",$id)->first();    													   
    	$data["_stairstep"] = Tbl_mlm_slot::join("tbl_customer","tbl_customer.customer_id","=","tbl_mlm_slot.slot_owner")
							              ->leftJoin('tbl_stairstep_distribute_slot', function($join) use ($id)
								          {
								              $join->on('tbl_stairstep_distribute_slot.slot_id', '=', 'tbl_mlm_slot.slot_id')->where("stairstep_distribute_id",$id);
							              	  $join->leftJoin('tbl_mlm_stairstep_settings.stairstep_id', '=', 'tbl_stairstep_distribute_slot.processed_current_rank');
    									  })
							              ->where("tbl_mlm_slot.shop_id",$shop_id)
							              ->where("tbl_mlm_slot.slot_id",">=",$distribute->from_slot_id)
							              ->where("tbl_mlm_slot.slot_id","<=",$distribute->to_slot_id)
    									  ->get();
        // dd($data);
    	return view("member.mlm_stairstep.view_summary",$data);
    }

    public function get_start_date()
    {
    	$shop_id 		   = $this->getShopId();
    	$last_distribute   = Tbl_stairstep_distribute::where("shop_id",$shop_id)->orderBy("stairstep_distribute_end_date","DESC")->first();
    	
    	$first_slot_points = Tbl_mlm_slot_points_log::where("shop_id",$shop_id)
    												->join("tbl_mlm_slot","tbl_mlm_slot.slot_id","=","tbl_mlm_slot_points_log.points_log_slot")
    												->orderBy("points_log_date_claimed","")
    												->first();

    	$shop_date_created = Tbl_shop::where("shop_id",$shop_id)->first(); 

    	if($last_distribute)
    	{
    		$returned_date = $last_distribute->stairstep_distribute_end_date;
    	}
    	else if($first_slot_points)
    	{
    		$returned_date = $shop_date_created->shop_date_created;
    	}	
    	else
    	{
    		$returned_date = $shop_date_created->shop_date_created;
    	}

    	$returned_date = Carbon::parse($returned_date)->format("m/d/Y");

    	return $returned_date;
    }

    public function get_end_date($start)
    {
    	return Carbon::parse($start)->addDays(15)->format("m/d/Y");
    }

    public function rank_stairstep_view()
    {
    	
    	return view("member.mlm_stairstep.rank_update_stairstep");
    }
}