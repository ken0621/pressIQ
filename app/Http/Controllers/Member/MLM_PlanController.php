<?php

namespace App\Http\Controllers\Member;

use Request;
use Carbon\Carbon;
use Session;
use Schema;
use DB;
use Validator;
use App\Globals\Mlm_plan;
use App\Globals\AuditTrail;

use App\Models\Tbl_mlm_indirect_setting;
use App\Models\Tbl_mlm_stairstep_settings;
use App\Models\Tbl_mlm_binary_pairing;
use App\Models\Tbl_mlm_unilevel_settings;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_membership;
use App\Models\Tbl_product;
use App\Models\Tbl_membership_points;
use App\Models\Tbl_user;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_mlm_slot_wallet_type;
use App\Models\Tbl_mlm_matching;
use App\Models\Tbl_mlm_complan_executive_settings;
use App\Models\Tbl_mlm_leadership_settings;
use App\Models\Tbl_mlm_indirect_points_settings;
use App\Models\Tbl_mlm_unilevel_points_settings;
use App\Models\Tbl_mlm_discount_card_settings;

use App\Http\Controllers\Member\MLM_ProductController;
use App\Http\Controllers\Member\MLM_PlanController;

use App\Globals\Utilities;
class MLM_PlanController extends Member
{
    public function index()
    {
        $access = Utilities::checkAccess('mlm-plan', 'access_page');
        if($access == 0)
        {
            return $this->show_no_access(); 
        }

    	// insert basic settings per shop/ prerequisite
        $this->setup($this->user_info->shop_id);
        // end
        
        // datas
        $data["page"] = "Membership";
        $data['mlm_plan'] = Tbl_mlm_plan::where('shop_id', $this->user_info->shop_id)->orderBy('marketing_plan_trigger', 'DESC')->orderBy('marketing_plan_enable', 'ASC')->get();
        $data['plan_settings'] = Tbl_mlm_plan_setting::where('shop_id', $this->user_info->shop_id)->first();
        // end datas
        
        return view('member.mlm_plan.mlm_plan_list', $data);
    }
    public function save_settings()
    {
        // asd
    	// Input from form 
    	$validate['plan_settings_prefix_count'] = Request::input('plan_settings_prefix_count');
    	$validate['plan_settings_enable_mlm'] = Request::input('plan_settings_enable_mlm');
    	$validate['plan_settings_enable_replicated'] = Request::input('plan_settings_enable_replicated');
    	$validate['plan_settings_slot_id_format'] = Request::input('plan_settings_slot_id_format');
    	$validate['plan_settings_format'] = Request::input('plan_settings_format');
    	$validate['plan_settings_prefix_count'] = Request::input('plan_settings_prefix_count');
        $validate['plan_settings_use_item_code'] = Request::input('plan_settings_use_item_code');
    	// end input from form
    	
    	// Validator rules
    	$rules['plan_settings_prefix_count'] = "required";
		$rules['plan_settings_enable_mlm'] = "required";
		$rules['plan_settings_enable_replicated'] = "required";
		$rules['plan_settings_slot_id_format'] = "required";
		$rules['plan_settings_format'] = "required";
		$rules['plan_settings_prefix_count'] = "required";
        $rules['plan_settings_use_item_code'] = "required";
		// end validator rules
		
		// validate
		$validator = Validator::make($validate,$rules);
	    // end validate
	    
	    // check if validation passes
	    if ($validator->passes())
    	{
    		// shop id needed for foreign key
    		$shop_id = $this->user_info->shop_id;
    		// end

            $old_marketing_plan = Tbl_mlm_plan_setting::where("shop_id",$shop_id)->first()->toArray();

    		// update column
    		$update['plan_settings_prefix_count'] = Request::input('plan_settings_prefix_count');
    		$update['plan_settings_enable_mlm'] = Request::input('plan_settings_enable_mlm');
    		$update['plan_settings_enable_replicated'] = Request::input('plan_settings_enable_replicated');
    		$update['plan_settings_slot_id_format'] = Request::input('plan_settings_slot_id_format');
    		$update['plan_settings_format'] = Request::input('plan_settings_format');
    		$update['plan_settings_prefix_count'] = Request::input('plan_settings_prefix_count');
            $update['plan_settings_use_item_code'] = Request::input('plan_settings_use_item_code');
    		// end
    		
    		// update settings
    		Tbl_mlm_plan_setting::where('shop_id', $shop_id)->update($update);
    		// end

            $new_marketing_plan = Tbl_mlm_plan_setting::where("shop_id",$shop_id)->first()->toArray();
            AuditTrail::record_logs("Edited","mlm_plan_setting",$shop_id,serialize($old_marketing_plan),serialize($new_marketing_plan));
    		
    		// response to return
    		$data['response_status'] = 'success';
    		// end
    	}
    	// if validation failed
		else
    	{
    		// send error message / warning
    		$data['response_status'] = "warning";
    		// errors from validator
    	    $data['warning_validator'] = $validator->messages();
    	    //end
    	}
    	
    	// return json encoded response
    	echo json_encode($data);
    }
    public function wallet_type()
    {
        $data['wallet_type'] = Tbl_mlm_slot_wallet_type::get();
        return view('member.mlm_plan.mlm_plan_wallet_type', $data);
    }
    public function add_wallet_type()
    {
        $validate['wallet_type_enable_encash'] = Request::input('wallet_type_enable_encash');
        $validate['wallet_type_enable_product_repurchase'] = Request::input('wallet_type_enable_product_repurchase');
        $validate['wallet_type_key'] = Request::input('wallet_type_key');
        $validate['wallet_type_other'] = Request::input('wallet_type_other');

        $rules['wallet_type_enable_encash'] = 'required';
        $rules['wallet_type_enable_product_repurchase'] = 'required';
        $rules['wallet_type_key'] = 'required';
        $rules['wallet_type_other'] = 'required';

        $validator = Validator::make($validate,$rules);
        if ($validator->passes())
        {
            $submit_button = Request::input('submit_type');
            if($submit_button  == "add")
            {
                $insert['wallet_type_enable_encash'] = Request::input('wallet_type_enable_encash');
                $insert['wallet_type_enable_product_repurchase'] = Request::input('wallet_type_enable_product_repurchase');
                $insert['wallet_type_key'] = Request::input('wallet_type_key');
                $insert['wallet_type_other'] = Request::input('wallet_type_other');
                $wallet_type_id = Tbl_mlm_slot_wallet_type::insertGetId($insert);

                $wallet_type_data = Tbl_mlm_slot_wallet_type::where("wallet_type_id",$wallet_type_id)->first()->toArray();
                AuditTrail::record_logs("Added","mlm_wallet_type",$wallet_type_id,"",serialize($wallet_type_data));
            }
            else if($submit_button == 'edit')
            {                
                $old_wallet_type_data = Tbl_mlm_slot_wallet_type::where("wallet_type_id",Request::input('wallet_type_id'))->first()->toArray();

                $update['wallet_type_enable_encash'] = Request::input('wallet_type_enable_encash');
                $update['wallet_type_enable_product_repurchase'] = Request::input('wallet_type_enable_product_repurchase');
                $update['wallet_type_key'] = Request::input('wallet_type_key');
                $update['wallet_type_other'] = Request::input('wallet_type_other');
                $update['wallet_type_archive'] = Request::input('wallet_type_archive');
                $data['form'] = $update;
                Tbl_mlm_slot_wallet_type::where('wallet_type_id', Request::input('wallet_type_id'))->update($update);

                $new_wallet_type_data = Tbl_mlm_slot_wallet_type::where("wallet_type_id",Request::input('wallet_type_id'))->first()->toArray();
                AuditTrail::record_logs("Edited","mlm_wallet_type",Request::input('wallet_type_id'),serialize($old_wallet_type_data),serialize($new_wallet_type_data));
            }
            
            $data['response_status'] = "success_wallet_type";
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
        echo json_encode($data);
    }
    public function wallet_type_submit()
    {
    }
    public function configure_plan($plan = null)
    {
        $access = Utilities::checkAccess('mlm-plan', 'configure_plan');
        if($access == 0)
        {
            return $this->show_no_access(); 
        }
        //call function of mlm_plan 
        if($plan != null)
        {
        	//get shop id
            $shop_id = $this->user_info->shop_id;
            // end
            
            //lower case plan name code
            $plan = strtolower($plan);
            // end
            
            // call plan code function
            // E. G.  $plan = BINARY; $plan($shop_id) = binary($shop_id)
            return $this->$plan($shop_id);
            // end
            
        }
    }
    public static function setup($shop_id)
    {
    	// count current settings
        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        // end
        
        // add basic complan if settings = 0, per shop id
        if($count == 0)
        {
        	
        	// start binary complan settings insert
        	$insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "BINARY";
            $insert['marketing_plan_name'] = "Binary";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Matching Bonus";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            // end
            
            // start DIRECT complan settings insert
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "DIRECT";
            $insert['marketing_plan_name'] = "Direct Referral";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Direct Referral Bonus";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 2;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            // end
            
            // start INDIRECT complan settings insert
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "INDIRECT";
            $insert['marketing_plan_name'] = "Indirect Referral";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Indirect Referral Bonus";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 3;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            // end
            
            // start STAIRSTEP complan settings insert
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "STAIRSTEP";
            $insert['marketing_plan_name'] = "Stair Step";
            $insert['marketing_plan_trigger'] = "Product Repurchase";
            $insert['marketing_plan_label'] = "Rank Bonus";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 4;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            // end
            
            // start UNILEVEL complan settings insert
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "UNILEVEL";
            $insert['marketing_plan_name'] = "Unilevel";
            $insert['marketing_plan_trigger'] = "Product Repurchase";
            $insert['marketing_plan_label'] = "Unilevel Bonus";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 4;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            // end
        }
        // new settings count for new complan
        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        // end
        if($count == 5)
        {
        	// start BINARY_REPURCHASE complan settings insert
        	$insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "BINARY_REPURCHASE";
            $insert['marketing_plan_name'] = "Binary Repurchase";
            $insert['marketing_plan_trigger'] = "Product Repurchase";
            $insert['marketing_plan_label'] = "Binary Repurchase";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            //end
        }

        // new settings count for new complan
        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        // end
        if($count == 6)
        {
            // start BINARY_REPURCHASE complan settings insert
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "MEMBERSHIP_MATCHING";
            $insert['marketing_plan_name'] = "Matching Points";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Matching Points";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            //end
        }
        // end basic complan

        // new settings count for new complan
        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        // end
        if($count == 7)
        {
            // start BINARY_REPURCHASE complan settings insert
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "EXECUTIVE_BONUS";
            $insert['marketing_plan_name'] = "Executive Bonus";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Executive Bonus";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            //end
        }
        // end basic complan

        // new settings count for new complan
        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        // end
        if($count == 8)
        {
            // start BINARY_REPURCHASE complan settings insert
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "LEADERSHIP_BONUS";
            $insert['marketing_plan_name'] = "Leadership Bonus";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Leadership Bonus";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            //end
        }

        // new settings count for new complan
        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        // end
        if($count == 9)
        {
            // start DIRECT_POINTS complan settings insert
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "DIRECT_POINTS";
            $insert['marketing_plan_name'] = "Direct Points";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Direct Points";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            //end

            // start INDIRECT_POINTS complan settings insert
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "INDIRECT_POINTS";
            $insert['marketing_plan_name'] = "Indirect Points";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Indirect Points";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
            //end
        }

        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        if($count == 11)
        {
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "REPURCHASE_POINTS";
            $insert['marketing_plan_name'] = "Repurchase Points";
            $insert['marketing_plan_trigger'] = "Product Repurchase";
            $insert['marketing_plan_label'] = "Repurchase Points";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
        }

        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        if($count == 12)
        {
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "INITIAL_POINTS";
            $insert['marketing_plan_name'] = "Initial Points";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Initial Points";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
        }

        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        if($count == 13)
        {
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "REPURCHASE_CASHBACK";
            $insert['marketing_plan_name'] = "Repuchase Cashback";
            $insert['marketing_plan_trigger'] = "Product Repurchase";
            $insert['marketing_plan_label'] = "Repurchase Cashback";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
        }
        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        if($count == 14)
        {
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "UNILEVEL_REPURCHASE_POINTS";
            $insert['marketing_plan_name'] = "Unilevel Repurchase Points";
            $insert['marketing_plan_trigger'] = "Product Repurchase";
            $insert['marketing_plan_label'] = "Unilevel Repurchase Points";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
        }
        $count = Tbl_mlm_plan::where('shop_id', $shop_id)->count();
        if($count == 15)
        {
            $insert['shop_id'] = $shop_id;
            $insert['marketing_plan_code'] = "DISCOUNT_CARD";
            $insert['marketing_plan_name'] = "Discount Card";
            $insert['marketing_plan_trigger'] = "Slot Creation";
            $insert['marketing_plan_label'] = "Discount Card";
            $insert['marketing_plan_enable'] = 0;
            $insert['marketing_plan_release_schedule'] = 1;
            $insert['marketing_plan_release_schedule_date'] = Carbon::now();
            Tbl_mlm_plan::insert($insert);
        }

        // end basic complan
        
        
        // get all active complan for repurchase
        $data['active_plan_product_repurchase'] = Mlm_plan::get_all_active_plan_repurchase($shop_id);
        // end
        
        // add column for repurchase dynamic
        foreach($data['active_plan_product_repurchase'] as $key => $value)
        {
        	// if column does not exist add new table
        	if(!Schema::hasColumn('tbl_mlm_product_points', $value->marketing_plan_code))
	        {
	        	// execute query
	            DB::statement('ALTER TABLE `tbl_mlm_product_points` ADD '.$value->marketing_plan_code.' double DEFAULT 0');
	            // end
	        }
	        // end
        }
        // end add column
        
        // end mlm plan settings

        // basic plan settings
		$c = Tbl_mlm_plan_setting::where('shop_id', $shop_id)->count();
		if($c == 0)
		{
			// add mlm plan settings / per shop 
			$insert_2['shop_id'] = $shop_id;
			Tbl_mlm_plan_setting::insert($insert_2);
			//end
		}
        // end basic

        // binary settings 
        $count_binary_settings = Tbl_mlm_binary_setttings::where('shop_id', $shop_id)->count();
        if($count_binary_settings == 0)
        {
            $insert_binary_settings['shop_id'] = $shop_id;
            $insert_binary_settings['binary_settings_gc_title'] = 'GC';
            $insert_binary_settings['binary_settings_time_of_cycle'] = '01:00:00';
            Tbl_mlm_binary_setttings::insert($insert_binary_settings);
        }
        // end binary settings


        // wallet type
        $count_wallet_type = Tbl_mlm_slot_wallet_type::where('wallet_type_archive', 0)->count();
        if($count_wallet_type == 0)
        {
            $insert_wallet_type['wallet_type_key'] = 'cash';
            $insert_wallet_type['wallet_type_enable_encash'] = 1; 
            $insert_wallet_type['wallet_type_enable_product_repurchase'] = 1; 
            $insert_wallet_type['wallet_type_other'] = 0;
            Tbl_mlm_slot_wallet_type::insert($insert_wallet_type);

            $insert_wallet_type['wallet_type_key'] = 'gc';
            $insert_wallet_type['wallet_type_enable_encash'] = 0; 
            $insert_wallet_type['wallet_type_enable_product_repurchase'] = 0; 
            $insert_wallet_type['wallet_type_other'] = 1;
            Tbl_mlm_slot_wallet_type::insert($insert_wallet_type);

            $insert_wallet_type['wallet_type_key'] = 'log';
            $insert_wallet_type['wallet_type_enable_encash'] = 0; 
            $insert_wallet_type['wallet_type_enable_product_repurchase'] = 0; 
            $insert_wallet_type['wallet_type_other'] = 0;
            Tbl_mlm_slot_wallet_type::insert($insert_wallet_type);

            $insert_wallet_type['wallet_type_key'] = 'repurchase';
            $insert_wallet_type['wallet_type_enable_encash'] = 0; 
            $insert_wallet_type['wallet_type_enable_product_repurchase'] = 1; 
            $insert_wallet_type['wallet_type_other'] = 0;
            Tbl_mlm_slot_wallet_type::insert($insert_wallet_type);
        }

        // end wallet type

        if(!Schema::hasColumn('tbl_membership_points', 'membership_points_repurchase'))
        {
            // execute query
            DB::statement('ALTER TABLE `tbl_membership_points` ADD `membership_points_repurchase` double DEFAULT 0');
            // end
        }

        if(!Schema::hasColumn('tbl_membership_points', 'membership_points_initial_points'))
        {
            // execute query
            DB::statement('ALTER TABLE `tbl_membership_points` ADD membership_points_initial_points double DEFAULT 0');
            // end
        }
        if(!Schema::hasColumn('tbl_membership_points', 'membership_points_repurchase_cashback'))
        {
            // execute query
            DB::statement('ALTER TABLE `tbl_membership_points` ADD membership_points_repurchase_cashback double DEFAULT 0');
            // end
        }


    }
    public function configure_plan_submit()
    {
    	//initialize validation
        $validate['marketing_plan_code'] = Request::input("marketing_plan_code");
        $validate['marketing_plan_trigger'] = Request::input("marketing_plan_trigger");
        $validate['marketing_plan_label'] = Request::input("marketing_plan_label");
        $validate['marketing_plan_enable'] = Request::input("marketing_plan_enable");
        $validate['marketing_plan_release_schedule'] = Request::input("marketing_plan_release_schedule");
        // $validate['marketing_plan_enable_product_repurchase'] = Request::input("marketing_plan_enable_product_repurchase");
        // $validate['marketing_plan_enable_encash'] = Request::input('marketing_plan_enable_encash');
        //initialize rules
        $rules['marketing_plan_code']   = "required";
        $rules['marketing_plan_trigger']    = "required";
        $rules['marketing_plan_label']  = "required";
        $rules['marketing_plan_enable'] = "required";
        $rules['marketing_plan_release_schedule']   = "required";
        // $rules['marketing_plan_enable_product_repurchase'] = "required";
        // $rules['marketing_plan_enable_encash'] = "required";
        
        // initialize response status, to avoid error
        $data['response_status'] = "success";
        
        // validate
        $validator = Validator::make($validate,$rules);
    	if ($validator->passes())
    	{            
    		// update plan
            $update['marketing_plan_trigger'] = Request::input("marketing_plan_trigger");
            $update['marketing_plan_label'] = Request::input("marketing_plan_label");
            $update['marketing_plan_enable'] = Request::input("marketing_plan_enable");
            $update['marketing_plan_release_schedule'] = Request::input("marketing_plan_release_schedule");
            $update['marketing_plan_release_monthly'] = Request::input("month_day");
            $update['marketing_plan_release_weekly'] = Request::input("week_days");
            $update['marketing_plan_release_time'] = Request::input("hours");
            // $update['marketing_plan_enable_product_repurchase'] =Request::input('marketing_plan_enable_product_repurchase');
            // $update['marketing_plan_enable_encash'] =Request::input('marketing_plan_enable_encash');
            $shop_id = $this->user_info->shop_id;
            Tbl_mlm_plan::where('shop_id', $shop_id)->where('marketing_plan_code', $validate['marketing_plan_code'])->update($update);
            // end update
            
            $marketing_plan = Tbl_mlm_plan::where("shop_id",$shop_id)->where('marketing_plan_code', $validate['marketing_plan_code'])->first()->toArray();
            AuditTrail::record_logs("configure ".$validate['marketing_plan_code'],"mlm_plan",$marketing_plan["marketing_plan_code_id"],"",serialize($marketing_plan));

            $data['response_status'] = "success";
    	}
    	else
    	{
    	    $data['response_status'] = "warning";
    	    $data['warning_validator'] = $validator->messages();
    	}
    	echo json_encode($data);
    }
    public static function binary($shop_id)
	{
		// data needed
	    $data[] = null;
	    $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();
	    $data['products'] = Tbl_product::variant()->where('product_shop', $shop_id)->where('tbl_variant.archived', 0)->paginate(10);
	    $data['basic_settings'] = MLM_PlanController::basic_settings('BINARY');
	    // end
	    
	    foreach($data['membership'] as $value)
	    {
	    	// add pairing count, cant resolve using join.
	    	$c = Tbl_mlm_binary_pairing::where('membership_id', $value->membership_id)->where('pairing_archive', 0)->count();
	    	$value->paring_count = $c;
	    	// end
	    }
	    // end
	    
	    // advance binary settings 
            $data['advance_binary'] = Tbl_mlm_binary_setttings::where('shop_id', $shop_id)->first();
        // end
	    return view('member.mlm_plan.configure.binary', $data);
	}
    public function submit_binary_advance()
    {

        $validate['binary_settings_gc_enable'] = Request::input('binary_settings_gc_enable');
        $validate['binary_settings_gc_every_pair'] = Request::input('binary_settings_gc_every_pair');
        $validate['binary_settings_gc_title'] = Request::input('binary_settings_gc_title');
        $validate['binary_settings_gc_amount'] = Request::input('binary_settings_gc_amount');
        $validate['binary_settings_no_of_cycle'] = Request::input('binary_settings_no_of_cycle');
        $validate['binary_settings_strong_leg'] = Request::input('binary_settings_strong_leg');
        $validate['binary_settings_max_tree_level'] = Request::input('binary_settings_max_tree_level');
        $validate['binary_settings_placement'] = Request::input('binary_settings_placement');
        $validate['binary_settings_auto_placement'] = Request::input('binary_settings_auto_placement');
        $validate['hours'] = Request::input('hours');

        $rules['binary_settings_gc_enable'] = 'required';
        $rules['binary_settings_gc_every_pair'] = 'required';
        $rules['binary_settings_gc_title'] = 'required';
        $rules['binary_settings_gc_amount'] = 'required';
        $rules['binary_settings_no_of_cycle'] = 'required';
        $rules['binary_settings_strong_leg'] = 'required';
        $rules['binary_settings_max_tree_level'] = 'required';
        $rules['binary_settings_placement'] = 'required';
        $rules['binary_settings_auto_placement'] = 'required';
        $rules['hours'] = 'required';

        $validator = Validator::make($validate,$rules);
        if ($validator->passes())
        {
            $data['response_status'] = "success_binary_advance_settings";
            $insert['binary_settings_gc_enable'] = $validate['binary_settings_gc_enable'];
            $insert['binary_settings_gc_every_pair'] = $validate['binary_settings_gc_every_pair'];
            $insert['binary_settings_gc_title'] = $validate['binary_settings_gc_title'];
            $insert['binary_settings_gc_amount'] = $validate['binary_settings_gc_amount'];
            $insert['binary_settings_no_of_cycle'] = $validate['binary_settings_no_of_cycle'];
            $insert['binary_settings_strong_leg'] = $validate['binary_settings_strong_leg'];
            $insert['binary_settings_time_of_cycle'] = $validate['hours'];
            $insert['binary_settings_max_tree_level'] = $validate['binary_settings_max_tree_level'];
            $insert['binary_settings_placement'] = $validate['binary_settings_placement'];
            $insert['binary_settings_auto_placement'] = $validate['binary_settings_auto_placement'];
            Tbl_mlm_binary_setttings::where('shop_id', $this->user_info->shop_id)->update($insert);
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }

        echo json_encode($data);
    }
	public function get_binary_pairing_combination($membership_id)
	{
		$shop_id = $this->user_info->shop_id;
		
		// data needed
		$data['membership'] = Tbl_membership::getactive(0, $shop_id)->where('tbl_membership.membership_id', $membership_id)->membership_points()->first();
		$data['membership_pairing'] = Tbl_mlm_binary_pairing::where('membership_id', $membership_id)->where('pairing_archive', 0)->get();
		$data['membership_pairing_count'] = Tbl_mlm_binary_pairing::where('membership_id', $membership_id)->where('pairing_archive', 0)->count();
		// end 
		
		return view('member.mlm_plan.configure.binary_pairing_get', $data);
	}
	public function edit_binary_membership_points()
	{
		/**
		 * use for editing binary points and direct referal bonus
		 */
		 
		// response for submit_done
	    $data['response_status'] = "successd";
		// end 

		// check if for direct or binary
	    if(isset($_POST['membership_points_binary']))
	    {
	    	// validate
	        $validate['membership_id'] = Request::input("membership_id");
            $validate['membership_points_binary'] = Request::input("membership_points_binary");
            // end
            
            //rules for validation
            $rules['membership_id']   = "required";
            $rules['membership_points_binary']    = "required";
            // end
    	    
    	    // validate
    	    $validator = Validator::make($validate,$rules);
    	    // end
    	    
        	if ($validator->passes())
        	{
        		// count membership points settings
        	    $count = Tbl_membership_points::where('membership_id', $validate['membership_id'])->count();
        	    //end
        	    
        	    // if count == 0 insert
        	    if($count == 0)
        	    {
        	    	// insert
        	        $insert['membership_id'] = $validate['membership_id'];
            	    $insert['membership_points_binary'] = $validate['membership_points_binary'];
            	    Tbl_membership_points::insert($insert);
            	    // end
        	    }
        	    //	else update
        	    else
        	    {
        	    	// update
        	        $update['membership_points_binary'] = $validate['membership_points_binary'];
            	    Tbl_membership_points::where('membership_id', $validate['membership_id'])->update($update);
            	    // end
        	    }
        	    // end
        	}
        	else
        	{
        	    $data['response_status'] = "warning";
        	    $data['warning_validator'] = $validator->messages();
        	}
        	
	    }
	    elseif(isset($_POST['membership_points_direct']))
	    {
	    	
	        $validate['membership_id'] = Request::input("membership_id");
            $validate['membership_points_direct'] = Request::input("membership_points_direct");
            
            $rules['membership_id']   = "required";
            $rules['membership_points_direct']    = "required";
            
    	    
    	    $validator = Validator::make($validate,$rules);
        	if ($validator->passes())
        	{
        	    $count = Tbl_membership_points::where('membership_id', $validate['membership_id'])->count();
        	    if($count == 0)
        	    {
        	        $insert['membership_id'] = $validate['membership_id'];
            	    $insert['membership_points_direct'] = $validate['membership_points_direct'];
            	    Tbl_membership_points::insert($insert);
        	    }
        	    else
        	    {
        	        $update['membership_points_direct'] = $validate['membership_points_direct'];
            	    Tbl_membership_points::where('membership_id', $validate['membership_id'])->update($update);
        	    }
        	}
        	else
        	{
        	    $data['response_status'] = "warning";
        	    $data['warning_validator'] = $validator->messages();
        	}
	    }
    	
	   echo json_encode($data);
	}
	public function save_binary_pairing_combinartion()
	{
		// return $_POST;
		$validate['membership_id'] = Request::input('membership_id');
		$validate['membership_pairing_count'] = Request::input('membership_pairing_count');
		$validate['max_pair_cycle'] = Request::input('max_pair_cycle');
		$validate['pairing_bonus'] = Request::input('pairing_bonus');
		$validate['pairing_point_left'] = Request::input('pairing_point_left');
		$validate['pairing_point_right'] = Request::input('pairing_point_right');
		$validate['pairing_id'] = Request::input('pairing_id');
		
		$rules['membership_id'] = 'required';
		$rules['membership_pairing_count'] = 'required';
		$rules['max_pair_cycle'] = 'required';
		$rules['pairing_bonus'] = 'required';
		$rules['pairing_point_left'] = 'required';
		$rules['pairing_point_right'] = 'required';
		$rules['pairing_id'] = 'required';
		
		$validator = Validator::make($validate,$rules);
		if ($validator->passes())
    	{
    		$membership_id = $validate['membership_id'];
    		
    		
    		// update max pairs per cycle
    		$count_max = Tbl_membership_points::where('membership_id', $membership_id)->count();
    		if($count_max == 0)
    		{
    			$insert_max_pair['membership_points_binary_max_pair'] = $validate['max_pair_cycle'];
    			$insert_max_pair['membership_id'] = $membership_id;
    			Tbl_membership_points::insert($insert_max_pair);
    		}
    		else
    		{
    			$update_max['membership_points_binary_max_pair'] = $validate['max_pair_cycle'];
    			Tbl_membership_points::where('membership_id', $membership_id)->update($update_max);
    		}
    		// end update
    		
    		$membership_pairing_count_old = Tbl_mlm_binary_pairing::where('membership_id', $membership_id)->count();
    		if($membership_pairing_count_old == 0)
    		{
    			
    			foreach($validate['pairing_point_left'] as $key => $value)
	    		{
					$insert['pairing_bonus'] = $validate['pairing_bonus'][$key];
					$insert['pairing_point_left'] = $value;
					$insert['pairing_point_right'] = $validate['pairing_point_right'][$key];
					$insert['membership_id'] = $membership_id;
					Tbl_mlm_binary_pairing::insert($insert);
	    		}	
    		}
    		else if($validate['membership_pairing_count'] == $membership_pairing_count_old)
			{
				$data['membership_pairing'] = Tbl_mlm_binary_pairing::where('membership_id', $membership_id)->get();
	    		foreach($data['membership_pairing'] as $key => $value)
	    		{
    				$update['pairing_bonus'] = $validate['pairing_bonus'][$key];
					$update['pairing_point_left'] = $validate['pairing_point_left'][$key];
					$update['pairing_point_right'] = $validate['pairing_point_right'][$key];
					$update['membership_id'] = $membership_id;
					Tbl_mlm_binary_pairing::where('pairing_id', $value->pairing_id)->update($update);	
	    		}
			}
			else if($validate['membership_pairing_count'] >= $membership_pairing_count_old)
			{
				$data['membership_pairing'] = Tbl_mlm_binary_pairing::where('membership_id', $membership_id)->get();
				$stop = intval($membership_pairing_count_old) - 1;
	    		foreach($data['membership_pairing'] as $key => $value)
	    		{
	    			
	    			if($key < $stop)
	    			{
	    				$update['pairing_bonus'] = $validate['pairing_bonus'][$key];
						$update['pairing_point_left'] = $validate['pairing_point_left'][$key];
						$update['pairing_point_right'] = $validate['pairing_point_right'][$key];
						$update['membership_id'] = $membership_id;
						$update['pairing_archive'] = 0;
						Tbl_mlm_binary_pairing::where('pairing_id', $value->pairing_id)->update($update);
	    			}
	    			else
	    			{
	    				// pairing_archive
	    				$insert['pairing_bonus'] = $validate['pairing_bonus'][$key];
						$insert['pairing_point_left'] = $validate['pairing_point_left'][$key];
						$insert['pairing_point_right'] = $validate['pairing_point_right'][$key];
						$insert['membership_id'] = $membership_id;
						$insert['pairing_archive'] = 0;
						Tbl_mlm_binary_pairing::insert($insert);
	    			}
    					
	    		}
			}
			else if($validate['membership_pairing_count'] <= $membership_pairing_count_old)
			{
				$data['membership_pairing'] = Tbl_mlm_binary_pairing::where('membership_id', $membership_id)->get();
				$stop = intval($validate['membership_pairing_count']);
	    		foreach($data['membership_pairing'] as $key => $value)
	    		{
					if($key < $stop)
	    			{
	    				$update['pairing_bonus'] = $validate['pairing_bonus'][$key];
						$update['pairing_point_left'] = $validate['pairing_point_left'][$key];
						$update['pairing_point_right'] = $validate['pairing_point_right'][$key];
						$update['membership_id'] = $membership_id;
						$update['pairing_archive'] = 0;
						Tbl_mlm_binary_pairing::where('pairing_id', $value->pairing_id)->update($update);
	    			}
	    			else
	    			{
	    				$update['pairing_archive'] = 1;
						Tbl_mlm_binary_pairing::where('pairing_id', $value->pairing_id)->update($update);
	    			}
	    		}
			}
			
    		
    		$data['response_status'] = "success_submit_pairing_bonus";
    	}
		else
    	{
    	    $data['response_status'] = "warning";
    	    $data['warning_validator'] = $validator->messages();
    	}
    	echo json_encode($data);
	}
	public static function direct($shop_id)
	{
	    $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();
	    // dd($data);
	    $data['basic_settings'] = MLM_PlanController::basic_settings('DIRECT');
	    return view('member.mlm_plan.configure.direct', $data);
	}
	public static function indirect($shop_id)
	{
	    $data['membership'] = Tbl_membership::getactive(0, $shop_id)->get();
	    foreach($data['membership'] as $value)
	    {
	    	$c =Tbl_mlm_indirect_setting::where('membership_id', $value->membership_id)->where('indirect_setting_archive', 0)->count();
	    	$value->indirect_count = $c;
	    }
	    $data['basic_settings'] = MLM_PlanController::basic_settings('INDIRECT');
	    return view('member.mlm_plan.configure.indirect', $data);
	}
	public function edit_indirect_setting($membership_id)
	{
	    $data[] = null;
	    $data['membership'] = Tbl_membership::where('membership_id', $membership_id)->first();
	    $data['membership_count'] = Tbl_membership::where('membership_id', $membership_id)->count();
	    $data['indirect_settings'] = Tbl_mlm_indirect_setting::where('membership_id', $membership_id)->get();
	    $data['indirect_settings_count'] = Tbl_mlm_indirect_setting::where('membership_id', $membership_id)->count();
	   // dd($data);
	    return view('member.mlm_plan.configure.indirect_settings', $data);
	}
	public function edit_indirect_setting_add_level()
	{
		// return $_POST;
	    $data['response_status'] = "successd";
	    $validate['indirect_seting_value'] = Request::input('amount_indirect');
	    $validate['indirect_seting_level'] = Request::input('level_indirect');
	    $validate['indirect_seting_percent'] =Request::input('percentage_indirect');
	    $rules['indirect_seting_value'] = 'required';
	    $rules['indirect_seting_level'] = 'required';
	    $rules['indirect_seting_percent'] ='required';
	    
	    $validator = Validator::make($validate,$rules);
    	if ($validator->passes())
    	{
    	    $membership_id = Request::input('membership_id');   
    	    $count = Tbl_mlm_indirect_setting::where('membership_id', $membership_id)->count();
    	    $count_new = Request::input('indirect_level');
    	    if($count == 0)
    	    {
        	    foreach($validate['indirect_seting_level'] as $key => $value)
        	    {
        	        $insert['indirect_seting_level'] = $validate['indirect_seting_level'][$key];
        	        $insert['indirect_seting_value'] = $validate['indirect_seting_value'][$key];
        	        $insert['indirect_seting_percent'] = $validate['indirect_seting_percent'][$key];
        	        $insert['indirect_setting_archive'] = 0;
        	        $insert['membership_id'] = $membership_id;
        	        Tbl_mlm_indirect_setting::insert($insert);
        	    }
    	    }
    	    // indirect_setting_archive
    	    elseif ($count == $count_new) 
    		{
    			$old_data = Tbl_mlm_indirect_setting::where('membership_id', $membership_id)->get();
    			foreach($old_data as $key => $value)
    			{
    				$update = null;
    				$update['indirect_seting_level'] = $validate['indirect_seting_level'][$key];
        	        $update['indirect_seting_value'] =	$validate['indirect_seting_value'][$key];
        	        $update['indirect_seting_percent'] = $validate['indirect_seting_percent'][$key];
    	    		$update['indirect_setting_archive'] = 0;
    	    		$update['membership_id'] = $membership_id;
    	    		Tbl_mlm_indirect_setting::where('indirect_seting_id', $value->indirect_seting_id)->update($update);
    			}
    		}
    		elseif($count < $count_new)
    		{
				$stop = $count;
	    		$old_data = Tbl_mlm_indirect_setting::where('membership_id', $membership_id)->get();
    			foreach($old_data as $key => $value)
    			{
	    			if($key < $stop)
	    			{
	    				$update = null;
	    				$update['indirect_seting_level'] = $validate['indirect_seting_level'][$key];
        	        	$update['indirect_seting_value'] =	$validate['indirect_seting_value'][$key];
        	        	$update['indirect_seting_percent'] = $validate['indirect_seting_percent'][$key];
    	    			$update['indirect_setting_archive'] = 0;
    	    			$update['membership_id'] = $membership_id;
    	    			Tbl_mlm_indirect_setting::where('indirect_seting_id', $value->indirect_seting_id)->update($update);
	    			}
	    			$lastkey = $key;	
	    		}
	    		foreach($validate['indirect_seting_level'] as $key => $value)
	    		{
	    			if($key > $lastkey)
	    			{
	    				$insert['indirect_seting_level'] = $validate['indirect_seting_level'][$key]; 
		    	    	$insert['indirect_seting_value'] = $validate['indirect_seting_value'][$key];
		    	    	$insert['indirect_seting_percent'] = $validate['indirect_seting_percent'][$key];
		    	    	$insert['indirect_setting_archive'] = 0;
		    	    	$insert['membership_id'] = $membership_id;
		    	    	Tbl_mlm_indirect_setting::insert($insert);
	    			}
	    		}
    		}
    		elseif($count > $count_new)
    		{
    			$stop = $count_new;
    			$old_data = Tbl_mlm_indirect_setting::where('membership_id', $membership_id)->get();
    			foreach($old_data as $key => $value)
    			{
    				if($key < $stop)
	    			{
	    				$update = null;
	    				$update['indirect_seting_level'] = $validate['indirect_seting_level'][$key]; 
    	    			$update['indirect_seting_value'] = $validate['indirect_seting_value'][$key];
    	    			$update['indirect_seting_percent'] = $validate['indirect_seting_percent'][$key];
    	    			$update['indirect_setting_archive'] = 0;
    	    			$update['membership_id'] = $membership_id;
    	    			Tbl_mlm_indirect_setting::where('indirect_seting_id', $value->indirect_seting_id)->update($update);
	    			}
	    			else
	    			{
	    				$update = null;
		    	    	$update['indirect_setting_archive'] = 1;
		    	    	Tbl_mlm_indirect_setting::where('indirect_seting_id', $value->indirect_seting_id)->update($update);
	    			}
    			}
    		}
    	    $data['response_status'] = "successd";
    	}
    	else
    	{
    	    $data['response_status'] = "warning";
    	    $data['warning_validator'] = $validator->messages();
    	}
    	echo json_encode($data);
	}
	public static function stairstep($shop_id)
	{
	    $data['membership'] = Tbl_membership::getactive(0, $shop_id)->get();
	    $data['basic_settings'] = MLM_PlanController::basic_settings('STAIRSTEP');
	    $data['stair_get'] = MLM_PlanController::get_stairstep($shop_id);
	    return view('member.mlm_plan.configure.stairstep', $data);
	}
	public static function get_stairstep($shop_id = null)
	{
	    if($shop_id == null)
	    {
	        $user_info = Tbl_user::where("user_email", session('user_email'))->shop()->first();
	        $shop_id =$user_info->shop_id;
	       // $shop_id =  Member::$user_info->shop_id;
	    }
	    $data['rank'] = Tbl_mlm_stairstep_settings::where('shop_id', $shop_id)->get();
	    $data['rank_count'] = Tbl_mlm_stairstep_settings::count() + 1;
	    $data['rank_count_new'] = Tbl_mlm_stairstep_settings::count() + 2;
	    return view('member.mlm_plan.configure.stairstep_get', $data);
	}
	public  function save_stairstep()
	{
	    $validate['stairstep_level'] = Request::input('stairstep_level');
	    $validate['stairstep_name'] = Request::input('stairstep_name');
	    $validate['stairstep_required_gv'] = Request::input('stairstep_required_gv');
	    $validate['stairstep_required_pv'] = Request::input('stairstep_required_pv');
	    $validate['stairstep_bonus'] = Request::input('stairstep_bonus');
	   
	    $rules['stairstep_level'] ="required";
	    $rules['stairstep_name'] = "required";
	    $rules['stairstep_required_gv'] = "required";
	    $rules['stairstep_required_pv'] = "required";
	    $rules['stairstep_bonus'] = "required";
	    
	    $validator = Validator::make($validate,$rules);
    	if ($validator->passes())
    	{
    	    $insert['stairstep_level'] = Request::input('stairstep_level');
    	    $insert['stairstep_name'] = Request::input('stairstep_name');
    	    $insert['stairstep_required_gv'] = Request::input('stairstep_required_gv');
    	    $insert['stairstep_required_pv'] = Request::input('stairstep_required_pv');
    	    $insert['stairstep_bonus'] = Request::input('stairstep_bonus');
    	    $insert['shop_id'] = $this->user_info->shop_id;
    	    Tbl_mlm_stairstep_settings::insert($insert);
    	    $data['response_status'] = "success_add_stairstep";
    	}
    	else
    	{
    	    $data['response_status'] = "warning";
    	    $data['warning_validator'] = $validator->messages();
    	}
    	echo json_encode($data);
	}
	public function edit_save_stairstep()
	{
		// return $_POST;
		
		$validate['stairstep_id'] = Request::input('stairstep_id');
		$validate['stairstep_level'] = Request::input('stairstep_level');
	    $validate['stairstep_name'] = Request::input('stairstep_name');
	    $validate['stairstep_required_gv'] = Request::input('stairstep_required_gv');
	    $validate['stairstep_required_pv'] = Request::input('stairstep_required_pv');
	    $validate['stairstep_bonus'] = Request::input('stairstep_bonus');
	   
		$rules['stairstep_id'] ="required";
	    $rules['stairstep_level'] ="required";
	    $rules['stairstep_name'] = "required";
	    $rules['stairstep_required_gv'] = "required";
	    $rules['stairstep_required_pv'] = "required";
	    $rules['stairstep_bonus'] = "required";
	    
	    $validator = Validator::make($validate,$rules);
	    if ($validator->passes())
    	{
    	    $update['stairstep_level'] = Request::input('stairstep_level');
    	    $update['stairstep_name'] = Request::input('stairstep_name');
    	    $update['stairstep_required_gv'] = Request::input('stairstep_required_gv');
    	    $update['stairstep_required_pv'] = Request::input('stairstep_required_pv');
    	    $update['stairstep_bonus'] = Request::input('stairstep_bonus');
    	    $update['shop_id'] = $this->user_info->shop_id;
    	    Tbl_mlm_stairstep_settings::where('stairstep_id', Request::input('stairstep_id'))->update($update);
    	    $data['response_status'] = "success_edit_stairstep";
    	}
    	else
    	{
    	    $data['response_status'] = "warning";
    	    $data['warning_validator'] = $validator->messages();
    	}
    	echo json_encode($data);
	}
	public function get_basicsettings($marketing_plan_code)
	{
	    $data['plan'] = Tbl_mlm_plan::where('marketing_plan_code', $marketing_plan_code)->first();
	    return view('member.mlm_plan.mlm_plan_basic', $data);
	}
	public static function basic_settings($marketing_plan_code)
	{
	    $data[''] = null;
	    $shop_id = MLM_ProductController::checkuser('user_shop');
	    $data['plan'] = Tbl_mlm_plan::where('marketing_plan_code', $marketing_plan_code)->where('shop_id', $shop_id)->first();
        // dd($data);
	    return view('member.mlm_plan.mlm_plan_basic', $data);
	}
	public static function unilevel($shop_id)
	{
	    $data['membership'] = Tbl_membership::getactive(0, $shop_id)->get();
	    $data['basic_settings'] = MLM_PlanController::basic_settings('UNILEVEL');
	    return view('member.mlm_plan.configure.unilevel', $data);
	}
	public function get_all_unilevel()
	{
		$shop_id = $this->user_info->shop_id;
		$data['membership'] = Tbl_membership::getactive(0, $shop_id)->get();
		foreach($data['membership'] as $key => $value)
		{
			$data['uni_count'][$key] = Tbl_mlm_unilevel_settings::where('membership_id', $value->membership_id)->where('unilevel_settings_archive', 0)->count();
		}
		return view('member.mlm_plan.configure.unilevel_get_all', $data);
	}
	public function get_single_unilevel($membership_id)
	{
		$shop_id = $this->user_info->shop_id;
		$data['membership_count'] = Tbl_membership::where('membership_id', $membership_id)->count();
		$data['membership'] = Tbl_membership::where('membership_id', $membership_id)->first();
		$data['uni_count'] = Tbl_mlm_unilevel_settings::where('membership_id', $membership_id)->where('unilevel_settings_archive', 0)->count();
		$data['uni_settings'] = Tbl_mlm_unilevel_settings::where('membership_id', $membership_id)->where('unilevel_settings_archive', 0)->get();
		return view('member.mlm_plan.configure.unilevel_get_single', $data);
	}
	public function save_settings_unilevel()
	{
		// initialize response to avoid error
		$data['response_status'] = "success_unilevel_settings";
		
		// list input for validation
	    $validate['unilevel_settings_level'] = Request::input('unilevel_settings_level');
	    $validate['unilevel_settings_amount'] = Request::input('unilevel_settings_amount');
	    $validate['unilevel_settings_percent'] =Request::input('unilevel_settings_percent');
	    $validate['unilevel_level_count'] = Request::input('unilevel_level_count');
	    $validate['unilevel_settings_type'] = Request::input('unilevel_settings_type');
	    // validation rules
	    $rules['unilevel_settings_level'] = 'required';
	    $rules['unilevel_settings_amount'] = 'required';
	    $rules['unilevel_settings_percent'] ='required';
	    $rules['unilevel_level_count'] ='required';
        $rules['unilevel_settings_type'] ='required';

	    $validator = Validator::make($validate,$rules);
	    
	    // check if validation passes
	    if ($validator->passes())
    	{
    		$membership_id = Request::input('membership_id');   
    	    $count = Tbl_mlm_unilevel_settings::where('membership_id', $membership_id)->count();
    	    $count_new = $validate['unilevel_level_count'];
    	    
    	    // if unilevel settings has no data. insert all
    	    if($count == 0)
    	    {
    	    	foreach($validate['unilevel_settings_level'] as $key => $value)
    	    	{
    	    		$insert['unilevel_settings_level'] = $validate['unilevel_settings_level'][$key]; 
	    	    	$insert['unilevel_settings_amount'] = $validate['unilevel_settings_amount'][$key];
	    	    	$insert['unilevel_settings_percent'] = $validate['unilevel_settings_percent'][$key];
	    	    	$insert['unilevel_settings_archive'] = 0;
	    	    	$insert['membership_id'] = $membership_id;
                    $insert['unilevel_settings_type'] = $validate['unilevel_settings_type'][$key];
	    	    	Tbl_mlm_unilevel_settings::insert($insert);
    	    	}
    	    }
    	    // if old settings count = new settings count. update all
    		elseif ($count == $count_new) 
    		{
    			$old_data = Tbl_mlm_unilevel_settings::where('membership_id', $membership_id)->get();
    			foreach($old_data as $key => $value)
    			{
    				$update = null;
    				$update['unilevel_settings_level'] = $validate['unilevel_settings_level'][$key]; 
    	    		$update['unilevel_settings_amount'] = $validate['unilevel_settings_amount'][$key];
    	    		$update['unilevel_settings_percent'] = $validate['unilevel_settings_percent'][$key];
    	    		$update['unilevel_settings_archive'] = 0;
    	    		$update['membership_id'] = $membership_id;
                    $update['unilevel_settings_type'] = $validate['unilevel_settings_type'][$key];
    	    		Tbl_mlm_unilevel_settings::where('unilevel_settings_id', $value->unilevel_settings_id)->update($update);
    			}
    		}
    		// if old settings count < new settings count. update same level/insert sobrang level
    		elseif($count < $count_new)
    		{
				$stop = $count;
	    		$old_data = Tbl_mlm_unilevel_settings::where('membership_id', $membership_id)->get();
    			foreach($old_data as $key => $value)
    			{
	    			if($key < $stop)
	    			{
	    				$update = null;
	    				$update['unilevel_settings_level'] = $validate['unilevel_settings_level'][$key]; 
    	    			$update['unilevel_settings_amount'] = $validate['unilevel_settings_amount'][$key];
    	    			$update['unilevel_settings_percent'] = $validate['unilevel_settings_percent'][$key];
    	    			$update['unilevel_settings_archive'] = 0;
    	    			$update['membership_id'] = $membership_id;
                        $update['unilevel_settings_type'] = $validate['unilevel_settings_type'][$key];
    	    			Tbl_mlm_unilevel_settings::where('unilevel_settings_id', $value->unilevel_settings_id)->update($update);
    	    			
	    			}
	    			$lastkey = $key;	
	    			
	    		}
	    		foreach($validate['unilevel_settings_level'] as $key => $value)
	    		{
	    			if($key > $lastkey)
	    			{
	    				$insert['unilevel_settings_level'] = $validate['unilevel_settings_level'][$key]; 
		    	    	$insert['unilevel_settings_amount'] = $validate['unilevel_settings_amount'][$key];
		    	    	$insert['unilevel_settings_percent'] = $validate['unilevel_settings_percent'][$key];
		    	    	$insert['unilevel_settings_archive'] = 0;
		    	    	$insert['membership_id'] = $membership_id;
                        $insert['unilevel_settings_type'] = $validate['unilevel_settings_type'][$key];
		    	    	Tbl_mlm_unilevel_settings::insert($insert);
	    			}
	    		}
    		}
    		// if old settings count > new settings count. update equal level, archive ibang level
    		elseif($count > $count_new)
    		{
    			$data['sd'] = 4;
    			$stop = $count_new;
    			$old_data = Tbl_mlm_unilevel_settings::where('membership_id', $membership_id)->get();
    			foreach($old_data as $key => $value)
    			{
    				if($key < $stop)
	    			{
	    				$update = null;
	    				$update['unilevel_settings_level'] = $validate['unilevel_settings_level'][$key]; 
    	    			$update['unilevel_settings_amount'] = $validate['unilevel_settings_amount'][$key];
    	    			$update['unilevel_settings_percent'] = $validate['unilevel_settings_percent'][$key];
    	    			$update['unilevel_settings_archive'] = 0;
    	    			$update['membership_id'] = $membership_id;
                        $update['unilevel_settings_type'] = $validate['unilevel_settings_type'][$key];
    	    			Tbl_mlm_unilevel_settings::where('unilevel_settings_id', $value->unilevel_settings_id)->update($update);
	    			}
	    			else
	    			{
	    				$update = null;
		    	    	$update['unilevel_settings_archive'] = 1;
		    	    	Tbl_mlm_unilevel_settings::where('unilevel_settings_id', $value->unilevel_settings_id)->update($update);
	    			}
    			}
    		}
    	}
    	else
    	{
    		$data['response_status'] = "warning";
    	    $data['warning_validator'] = $validator->messages();
    	}
    	echo json_encode($data);
	}
	public static function binary_repurchase($shop_id)
	{
		$data['membership'] = Tbl_membership::getactive(0, $shop_id)->get();
	    $data['basic_settings'] = MLM_PlanController::basic_settings('BINARY_REPURCHASE');
	    return view('member.mlm_plan.configure.binary_repurchase', $data);
	}
    public static function membership_matching($shop_id)
    {
        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->get();
        foreach($data['membership'] as $key => $value)
        {
            $data['membership_matching_count'][$key] = Tbl_mlm_matching::where('membership_id', $value->membership_id)->count();
            $data['membership_matching'][$key] = Tbl_mlm_matching::where('membership_id', $value->membership_id)->get();
        }
        // dd($data);
        $data['basic_settings'] = MLM_PlanController::basic_settings('MEMBERSHIP_MATCHING');
        return view('member.mlm_plan.configure.membership_matching', $data);
    }
    public function matching_add_new()
    {
        // return $_POST;
        $insert['membership_id'] = Request::input('membership_id');
        $earn = Request::input('earn');
        $start = Request::input('start');
        $end = Request::input('end');
        $shop_id = $this->user_info->shop_id;
        $insertion = [];

        Tbl_mlm_matching::where('membership_id',  Request::input('membership_id') )->where('shop_id', $shop_id)->delete();
        foreach($earn as $key => $value)
        {
            $insertion[$key]['membership_id'] = Request::input('membership_id');
            $insertion[$key]['matching_settings_start'] = $start[$key];
            $insertion[$key]['matching_settings_end']    = $end[$key];
            $insertion[$key]['matching_settings_earnings'] = $earn[$key];
            $insertion[$key]['shop_id'] = $shop_id;
        }
        Tbl_mlm_matching::insert($insertion);

        $data['response_status'] = "success_matching";
        echo json_encode($data);
    }
    public static function executive_bonus($shop_id)
    {
        // return 1;
        $data['basic_settings'] = MLM_PlanController::basic_settings('executive_bonus');
        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();

        foreach($data['membership'] as $key => $value)
        {
            $count = Tbl_mlm_complan_executive_settings::where('membership_id', $value->membership_id)->count();
            if($count == 0)
            {
                $insert['membership_id'] = $value->membership_id;
                $insert['executive_settings_required_points'] = 0;
                $insert['executive_settings_bonus'] = 0;

                Tbl_mlm_complan_executive_settings::insert($insert);
            }
        }

        $data['executive_settings'] = Tbl_membership::where('tbl_membership.membership_archive', 0)
                                        ->where('tbl_membership.shop_id', $shop_id)->executive_settings()->get();
        return view('member.mlm_plan.configure.executive_bonus', $data);
    }
    public function edit_executive_points()
    {
        /**
         * use for executive points
         */
        // return $_POST;
        // response for submit_done
        $data['response_status'] = "successd";
        // end 

        // validate
        $validate['membership_id'] = Request::input("membership_id");
        $validate['membership_points_executive'] = Request::input("membership_points_direct");
        // end
        
        //rules for validation
        $rules['membership_id']   = "required";
        $rules['membership_points_executive']    = "required";
        // end
        
        // validate
        $validator = Validator::make($validate,$rules);
        // end
        
        if ($validator->passes())
        {
            // count membership points settings
            $count = Tbl_membership_points::where('membership_id', $validate['membership_id'])->count();
            //end
            
            // if count == 0 insert
            if($count == 0)
            {
                // insert
                $insert['membership_id'] = $validate['membership_id'];
                $insert['membership_points_executive'] = $validate['membership_points_executive'];
                Tbl_membership_points::insert($insert);
                // end
            }
            //  else update
            else
            {
                // update
                $update['membership_points_executive'] = $validate['membership_points_executive'];
                Tbl_membership_points::where('membership_id', $validate['membership_id'])->update($update);
                // end
            }
            // end
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
            
        
       echo json_encode($data);
    }
    public function set_settings_executive_points()
    {
        // return $_POST;
        $membership_id = Request::input('membership_id');
        $executive_settings_required_points = Request::input('executive_settings_required_points');
        $executive_settings_bonus           = Request::input('executive_settings_bonus');

        $count = Tbl_mlm_complan_executive_settings::where('membership_id', $membership_id)->count();
        if($count == 0)
        {
            $insert['membership_id'] = $value->membership_id;
            $insert['executive_settings_required_points'] = $executive_settings_required_points;
            $insert['executive_settings_bonus'] = $executive_settings_bonus;

            Tbl_mlm_complan_executive_settings::insert($insert);
        }
        else
        {
            $update['executive_settings_required_points'] = $executive_settings_required_points;
            $update['executive_settings_bonus'] = $executive_settings_bonus;

            Tbl_mlm_complan_executive_settings::where('membership_id', $membership_id)->update($update);
        }

        $data['response_status'] = "success_edit_executive";

        echo json_encode($data);
    }
    public static function leadership_bonus($shop_id)
    {
        $data['basic_settings'] = MLM_PlanController::basic_settings('leadership_bonus');
        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();

        foreach($data['membership'] as $key => $value)
        {
            $data['leadership_bonus_settings_count'][$key] = Tbl_mlm_leadership_settings::where('membership_id',  $value->membership_id )->where('shop_id', $shop_id)->count();
            $data['leadership_bonus_settings_get'][$key] = Tbl_mlm_leadership_settings::where('membership_id',  $value->membership_id )->where('shop_id', $shop_id)->get();
        }
        return view('member.mlm_plan.configure.leadership_bonus', $data);
    }
    public function leadership_bonus_edit()
    {
        // return $_POST;
        // validate
        $validate['membership_id'] = Request::input("membership_id");
        $validate['membership_points_leadership'] = Request::input("membership_points_leadership");
        // end
        
        //rules for validation
        $rules['membership_id']   = "required";
        $rules['membership_points_leadership']    = "required";
        // end
        
        // validate
        $validator = Validator::make($validate,$rules);
        // end
        
        if ($validator->passes())
        {
            // count membership points settings
            $count = Tbl_membership_points::where('membership_id', $validate['membership_id'])->count();
            //end
            
            // if count == 0 insert
            if($count == 0)
            {
                // insert
                $insert['membership_id'] = $validate['membership_id'];
                $insert['membership_points_leadership'] = $validate['membership_points_leadership'];
                Tbl_membership_points::insert($insert);
                // end
            }
            //  else update
            else
            {
                // update
                $update['membership_points_leadership'] = $validate['membership_points_leadership'];
                Tbl_membership_points::where('membership_id', $validate['membership_id'])->update($update);
                // end
            }
            // end
            $data['response_status'] = "success_leadership";
            $data['warning_validator'] = "success";
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
        
        echo json_encode($data);
    }
    public function leadership_bonus_matching()
    {
        // return $_POST;
        $shop_id = $this->user_info->shop_id;   

        // validate
        $validate['membership_id'] = Request::input("membership_id");
        // end
        
        //rules for validation
        $rules['membership_id']   = "required";
        // end
        
        // validate
        $earnings = Request::input('earnings');
        $start = Request::input('start');
        $end = Request::input('end');
        $earnings = Request::input('earnings');
        $required = Request::input('required');

        $validator = Validator::make($validate,$rules);
        if ($validator->passes())
        {
            Tbl_mlm_leadership_settings::where('membership_id',  $validate['membership_id'] )->where('shop_id', $shop_id)->delete();
            if($earnings != null)
            {
                foreach($earnings as $key => $value)
                {
                    $insertion[$key]['membership_id'] = Request::input('membership_id');
                    $insertion[$key]['leadership_settings_start'] = $start[$key];
                    $insertion[$key]['leadership_settings_end']    = $end[$key];
                    $insertion[$key]['leadership_settings_earnings'] = $earnings[$key];
                    $insertion[$key]['leadership_settings_required_points'] = $required[$key];
                    $insertion[$key]['shop_id'] = $shop_id;
                }
                Tbl_mlm_leadership_settings::insert($insertion);
            }
            

            $data['response_status'] = "success";
            $data['message'] = 'Success';
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
        
        echo json_encode($data);
    }
    public static function direct_points($shop_id)
    {
        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();
        // dd($data);
        $data['basic_settings'] = MLM_PlanController::basic_settings('DIRECT_POINTS');
        return view('member.mlm_plan.configure.direct_points', $data);
    }
    public static function direct_points_edit_v2()
    {
         // validate
        $validate['membership_id'] = Request::input("membership_id");
        $validate['membership_points_direct_not_bonus'] = Request::input("membership_points_direct");
        // end
        
        //rules for validation
        $rules['membership_id']   = "required";
        $rules['membership_points_direct_not_bonus']    = "required";
        // end
        
        // validate
        $validator = Validator::make($validate,$rules);
        // end
        
        if ($validator->passes())
        {
            // count membership points settings
            $count = Tbl_membership_points::where('membership_id', $validate['membership_id'])->count();
            //end
            
            // if count == 0 insert
            if($count == 0)
            {
                // insert
                $insert['membership_id'] = $validate['membership_id'];
                $insert['membership_points_direct_not_bonus'] = $validate['membership_points_direct_not_bonus'];
                Tbl_membership_points::insert($insert);
                // end
            }
            //  else update
            else
            {
                // update
                $update['membership_points_direct_not_bonus'] = $validate['membership_points_direct_not_bonus'];
                Tbl_membership_points::where('membership_id', $validate['membership_id'])->update($update);
                // end
            }
            // end
            $data['response_status'] = "success_leadership";
            $data['warning_validator'] = "success";
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
        
        echo json_encode($data);
    }
    public static function indirect_points($shop_id)
    {
        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->get();
        foreach($data['membership'] as $key => $value)
        {
            $data['membership_indirect_settings'][$key] = Tbl_mlm_indirect_points_settings::where('membership_id', $value->membership_id)->where('indirect_points_archive', 0)->get();
            $data['membership_indirect_settings_count'][$key] = Tbl_mlm_indirect_points_settings::where('membership_id', $value->membership_id)->where('indirect_points_archive', 0)->count();
        }
        
        $data['basic_settings'] = MLM_PlanController::basic_settings('INDIRECT_POINTS');
        return view('member.mlm_plan.configure.indirect_points', $data);
    }
    public static function indirect_points_edit_v2()
    {
        // return $_POST;

        $validate['membership_id'] = Request::input("membership_id");
        $validate['level_count'] = Request::input("level_count");
        // end
        
        //rules for validation
        $rules['membership_id']   = "required";
        $rules['level_count']    = "required";

        $level = Request::input('level');
        $points = Request::input('points');

        $validator = Validator::make($validate,$rules);

        if ($validator->passes())
        {
            
            $count = Tbl_mlm_indirect_points_settings::where('membership_id', $validate['membership_id'])->count();
            if($count == 0)
            {
                foreach($level as $key => $value)
                {
                    $insert[$key]['indirect_points_level'] = $value;
                    $insert[$key]['indirect_points_value'] = $points[$key];
                    $insert[$key]['membership_id'] = $validate['membership_id'];
                }
                Tbl_mlm_indirect_points_settings::insert($insert);
            }
            else if($count <= $validate['level_count'])
            {
                $get_settings = Tbl_mlm_indirect_points_settings::where('membership_id', $validate['membership_id'])->get();
                foreach($level as $key => $value)
                {
                    if(isset($get_settings[$key]))
                    {
                        $update['indirect_points_level'] = $value;
                        $update['indirect_points_value'] = $points[$key];
                        $update['membership_id'] = $validate['membership_id'];
                        $update['indirect_points_archive'] = 0;
                        Tbl_mlm_indirect_points_settings::where('indirect_points_id', $get_settings[$key]->indirect_points_id)->update($update);
                    }
                    else
                    {
                        $insert['indirect_points_level'] = $value;
                        $insert['indirect_points_value'] = $points[$key];
                        $insert['membership_id'] = $validate['membership_id'];
                        Tbl_mlm_indirect_points_settings::insert($insert);
                    }
                }
            }
            else if($count >= $validate['level_count'])
            {
                $get_settings = Tbl_mlm_indirect_points_settings::where('membership_id', $validate['membership_id'])->get();
                foreach($get_settings as $key => $value)
                {
                    if(isset($level[$key]))
                    {
                        $update['indirect_points_level'] = $level[$key];
                        $update['indirect_points_value'] = $points[$key];
                        $update['membership_id'] = $validate['membership_id'];
                        $update['indirect_points_archive'] = 0;
                        Tbl_mlm_indirect_points_settings::where('indirect_points_id', $value->indirect_points_id)->update($update);
                    }
                    else
                    {
                        $update['indirect_points_archive'] = 1;
                        Tbl_mlm_indirect_points_settings::where('indirect_points_id', $value->indirect_points_id)->update($update);
                    }
                }
            }
            $data['response_status'] = "success";
            $data['message'] = 'success!';
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
        
        echo json_encode($data);
    }
    public static function repurchase_points($shop_id)
    {

        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();        
        $data['basic_settings'] = MLM_PlanController::basic_settings('REPURCHASE_POINTS');
        // dd($data);
        return view('member.mlm_plan.configure.repurchase_points', $data);
    }
    public static function repurchase_add()
    {
        // return $_POST;

        $validate['membership_id'] = Request::input("membership_id");
        $validate['membership_points_repurchase'] = Request::input("membership_points_repurchase");
        
        $rules['membership_id']   = "required";
        $rules['membership_points_repurchase']    = "required";
        
        
        $validator = Validator::make($validate,$rules);
        if ($validator->passes())
        {
            $count = Tbl_membership_points::where('membership_id', $validate['membership_id'])->count();
            if($count == 0)
            {
                $insert['membership_id'] = $validate['membership_id'];
                $insert['membership_points_repurchase'] = $validate['membership_points_repurchase'];
                Tbl_membership_points::insert($insert);
            }
            else
            {
                $update['membership_points_repurchase'] = $validate['membership_points_repurchase'];
                Tbl_membership_points::where('membership_id', $validate['membership_id'])->update($update);
            }
            $data['response_status'] = "success";
            $data['message'] = "success";
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
        
       echo json_encode($data);
    }
    public static function initial_points($shop_id)
    {
        

        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();
        // dd($data);
        $data['basic_settings'] = MLM_PlanController::basic_settings('INITIAL_POINTS');
        return view('member.mlm_plan.configure.initial_points', $data);
    }
    public static function initial_points_add()
    {
        $validate['membership_id'] = Request::input("membership_id");
        $validate['membership_points_initial_points'] = Request::input("membership_points_initial_points");

        $rules['membership_id']   = "required";
        $rules['membership_points_initial_points']    = "required";
        
        
        $validator = Validator::make($validate,$rules);
        if ($validator->passes())
        {
            $count = Tbl_membership_points::where('membership_id', $validate['membership_id'])->count();
            if($count == 0)
            {
                $insert['membership_id'] = $validate['membership_id'];
                $insert['membership_points_initial_points'] = $validate['membership_points_initial_points'];
                Tbl_membership_points::insert($insert);
            }
            else
            {
                $update['membership_points_initial_points'] = $validate['membership_points_initial_points'];
                Tbl_membership_points::where('membership_id', $validate['membership_id'])->update($update);
            }
            $data['response_status'] = "success";
            $data['message'] = "success";
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
        
       echo json_encode($data);
    }
    public static function repurchase_cashback($shop_id)
    {
        

        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();
        // dd($data);
        $data['basic_settings'] = MLM_PlanController::basic_settings('REPURCHASE_CASHBACK');
        return view('member.mlm_plan.configure.repurchase_cashback', $data);
    }
    public static function repurchase_cashback_add()
    {
        $validate['membership_id'] = Request::input("membership_id");
        $validate['membership_points_repurchase_cashback'] = Request::input("membership_points_repurchase_cashback");

        $rules['membership_id']   = "required";
        $rules['membership_points_repurchase_cashback']    = "required";
        
        
        $validator = Validator::make($validate,$rules);
        if ($validator->passes())
        {
            $count = Tbl_membership_points::where('membership_id', $validate['membership_id'])->count();
            if($count == 0)
            {
                $insert['membership_id'] = $validate['membership_id'];
                $insert['membership_points_repurchase_cashback'] = $validate['membership_points_repurchase_cashback'];
                Tbl_membership_points::insert($insert);
            }
            else
            {
                $update['membership_points_repurchase_cashback'] = $validate['membership_points_repurchase_cashback'];
                Tbl_membership_points::where('membership_id', $validate['membership_id'])->update($update);
            }
            $data['response_status'] = "success";
            $data['message'] = "success";
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
        
       echo json_encode($data);
    }
    public static function unilevel_repurchase_points($shop_id)
    {
        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();
        foreach($data['membership'] as $key => $value)
        {
            $data['unilevel_settings_count'][$key] =  Tbl_mlm_unilevel_points_settings::where('membership_id', $value->membership_id)
            ->where('unilevel_points_archive', 0)
            ->count();
            $data['unilevel_settings'][$key] = Tbl_mlm_unilevel_points_settings::where('membership_id', $value->membership_id)
            ->where('unilevel_points_archive', 0)
            ->get();
        }
        // dd($data);
        $data['basic_settings'] = MLM_PlanController::basic_settings('UNILEVEL_REPURCHASE_POINTS');
        return view('member.mlm_plan.configure.unilevel_repurchase_points', $data);
    }
    public static function unilevel_repurchase_points_add()
    {
        // return $_POST;
        $i['membership_id'] = Request::input('membership_id');
        $i['level'] = Request::input('level');
        $i['amount'] = Request::input('amount');
        $i['type'] = Request::input('type');
        $count = Tbl_mlm_unilevel_points_settings::where('membership_id', $i['membership_id'])->where('unilevel_points_archive', 0)->count();
        // return $count;
        $count_new = count($i['level']);
        if($count == 0)
        {
            foreach($i['level'] as $key => $value)
            {
                $insert['unilevel_points_level'] = $value;
                $insert['unilevel_points_amount'] = $i['amount'][$key] ;
                $insert['unilevel_points_percentage'] = $i['type'][$key] ;
                $insert['membership_id'] = $i['membership_id'];

                Tbl_mlm_unilevel_points_settings::insert($insert);
            }
        }
        elseif($count == $count_new)
        {
            $old_settings = Tbl_mlm_unilevel_points_settings::where('membership_id', $i['membership_id'])->get();
            foreach($old_settings as $key => $value)
            {
                $update['unilevel_points_level'] = $i['level'][$key];
                $update['unilevel_points_amount'] = $i['amount'][$key] ;
                $update['unilevel_points_percentage'] = $i['type'][$key] ;
                $update['membership_id'] = $i['membership_id'];
                Tbl_mlm_unilevel_points_settings::where('membership_id', $i['membership_id'])
                ->where('unilevel_points_id', $value->unilevel_points_id)
                ->update($update);
            }
        }
        // pag masmalaki yung new settings sa luma
        elseif($count <= $count_new)
        {
            $old_settings = Tbl_mlm_unilevel_points_settings::where('membership_id', $i['membership_id'])->get();
            foreach($i['level'] as $key => $value)
            {
                if(isset($old_settings[$key]))
                {
                    $update['unilevel_points_level'] = $i['level'][$key];
                    $update['unilevel_points_amount'] = $i['amount'][$key] ;
                    $update['unilevel_points_percentage'] = $i['type'][$key] ;
                    $update['membership_id'] = $i['membership_id'];
                    Tbl_mlm_unilevel_points_settings::where('membership_id', $i['membership_id'])
                    ->where('unilevel_points_id', $old_settings[$key]->unilevel_points_id)
                    ->update($update);
                }
                else
                {
                    $insert['unilevel_points_level'] = $value;
                    $insert['unilevel_points_amount'] = $i['amount'][$key] ;
                    $insert['unilevel_points_percentage'] = $i['type'][$key] ;
                    $insert['membership_id'] = $i['membership_id'];
                    Tbl_mlm_unilevel_points_settings::insert($insert); 
                }
            }
        }
        // pag mas malaki yung luma
        elseif($count >= $count_new)
        {
            $old_settings = Tbl_mlm_unilevel_points_settings::where('membership_id', $i['membership_id'])->get();
            foreach($old_settings as $key => $value)
            {
                if(isset($i['level'][$key]))
                {
                    $update['unilevel_points_level'] = $i['level'][$key];
                    $update['unilevel_points_amount'] = $i['amount'][$key] ;
                    $update['unilevel_points_percentage'] = $i['type'][$key] ;
                    $update['membership_id'] = $i['membership_id'];
                    Tbl_mlm_unilevel_points_settings::where('membership_id', $i['membership_id'])
                    ->where('unilevel_points_id', $value->unilevel_points_id)
                    ->update($update);
                }
                else
                {
                    $update['unilevel_points_archive'] = 1;
                    Tbl_mlm_unilevel_points_settings::where('membership_id', $i['membership_id'])
                    ->where('unilevel_points_id', $value->unilevel_points_id)
                    ->update($update);
                }
            }
        }
        $data['response_status'] = "success";
        $data['message'] = "success";

        return json_encode($data);
    }
    public static function discount_card($shop_id)
    {
        $data['membership'] = Tbl_membership::getactive(0, $shop_id)->membership_points()->get();
        foreach($data['membership'] as $key => $value)
        {
            $data['discount_card_settings'][$key] = Tbl_mlm_discount_card_settings::where('membership_id', $value->membership_id)->first();
        }
        // dd($data);
        $data['basic_settings'] = MLM_PlanController::basic_settings('DISCOUNT_CARD');
        return view('member.mlm_plan.configure.discount_card', $data);
    }
    public function discount_card_add()
    {
        // return $_POST;
        $discount_card_count_membership         = Request::input('discount_card_count_membership');
        $discount_card_membership           = Request::input('discount_card_membership');
        $membership_id          = Request::input('membership_id');
        $count_settings = Tbl_mlm_discount_card_settings::where('membership_id', $membership_id)->count();
        if($count_settings == 0)
        {
            // insert
            // $insert['']
            $insert['discount_card_count_membership'] = $discount_card_count_membership;
            $insert['discount_card_membership'] = $discount_card_membership;
            $insert['membership_id'] = $membership_id;
            Tbl_mlm_discount_card_settings::insert($insert);
        }
        else
        {
            $update['discount_card_count_membership'] = $discount_card_count_membership;
            $update['discount_card_membership'] = $discount_card_membership;
            Tbl_mlm_discount_card_settings::where('membership_id', $membership_id)->update($update);
            // update
        }
        $data['response_status'] = "success";
        $data['message'] = "success";

        return json_encode($data);
    }
}