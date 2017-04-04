<?php
namespace App\Globals;


use Schema;
use Session;
use DB;
use Carbon\Carbon;

use App\Globals\Mlm_compute;
use App\Globals\Mlm_slot_log;
use App\Globals\Mlm_complan_manager;


use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_user;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_membership;
use App\Models\Tbl_customer_search;
use App\Models\Tbl_customer_other_info;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_mlm_matching_log;

class Mlm_report
{   
    public static function general($shop_id)
    {
    	$data['membership'] = Tbl_membership::archive(0)->where('shop_id', $shop_id)->get();
        $data['count_all_slot_active'] = Tbl_mlm_slot::where('shop_id', $shop_id)->where('slot_active', 0)->count();
        $data['count_all_slot_inactive'] =  Tbl_mlm_slot::where('shop_id', $shop_id)->where('slot_active', 1)->count();

        $data['customer_account'] = Tbl_customer::where('shop_id', $shop_id)->where('ismlm', 1)->count();
        $data['customer_account_w_slot'] = Tbl_customer::where('tbl_customer.shop_id', $shop_id)->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_owner', '=', 'tbl_customer.customer_id')->count();
        
        $data['membership_count'] = [];
        $data['chart_per_complan'] = Mlm_report::per_complan($shop_id, 'json');
        $data['chart_per_complan_raw'] =  Mlm_report::per_complan($shop_id, 'raw');
        $data['not_encashed'] = $all_log = Tbl_mlm_slot_wallet_log::where('wallet_log_status', 'released')
            ->where('wallet_log_plan','!=', 'ENCASHMENT')
            ->where('shop_id', $shop_id)
            ->whereNull('encashment_process')
            ->sum('wallet_log_amount');
        $data['not_encashed_requested'] = $all_log = Tbl_mlm_slot_wallet_log::where('wallet_log_status', 'released')
            ->where('wallet_log_plan','ENCASHMENT')
            ->where('shop_id', $shop_id)
            ->where('encashment_process_type', 0)
            ->sum('wallet_log_amount');    

         $data['not_encashed_encashed'] = $all_log = Tbl_mlm_slot_wallet_log::where('wallet_log_status', 'released')
            ->where('wallet_log_plan','ENCASHMENT')
            ->where('shop_id', $shop_id)
            ->where('encashment_process_type', 1)
            ->sum('wallet_log_amount');       

        $data['encashment_json'] = Mlm_report::encashment($shop_id);

        foreach($data['membership'] as $key => $value)
        {
            $data['membership_count'][$key] = Tbl_mlm_slot::where('slot_membership', $value->membership_id)->count();
            $data['membership_price'][$key] = $data['membership_count'][$key] * $value->membership_price;
        }
        // return $data;
        return view('member.mlm_report.report.general', $data);
    }
    public static function cashflow($shop_id)
    {

    	$complan_per_day =Tbl_mlm_slot_wallet_log::slot()
    	// ->leftjoin('tbl_mlm_plan', 'tbl_mlm_plan.marketing_plan_code', '=','tbl_mlm_slot_wallet_log.wallet_log_plan')
    	->customer()
    	->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
    	->orderBy('wallet_log_date_created', 'DESC')
    	->get();

    	$plan_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Slot Creation')
            ->get()->keyBy('marketing_plan_code');
       	$per_day = [];  
       	$per_month = []; 
       	$per_year = [];
       	// dd($complan_per_day);
        foreach($complan_per_day as $key => $value)
        {
        	// $date = Carbon::parse($value->)
        	// $date = Carbon::createFromFormat('d/m/Y', $value->wallet_log_date_created);
        	$date = Carbon::parse($value->wallet_log_date_created)->format('d/m/Y');
        	$date_m = Carbon::parse($value->wallet_log_date_created)->format('M/Y');
        	$date_y = Carbon::parse($value->wallet_log_date_created)->format('Y');
        	// $per_day[$date][$value->wallet_log_plan] += $value->wallet_log_amount;
        	if(isset($per_day[$date][$value->wallet_log_plan])) 
        	{
        		$per_day[$date][$value->wallet_log_plan] += $value->wallet_log_amount;
        	}
        	else
        	{
        		$per_day[$date][$value->wallet_log_plan] = $value->wallet_log_amount;
        	}

        	if(isset($per_month[$date_m][$value->wallet_log_plan])) 
        	{
        		$per_month[$date_m][$value->wallet_log_plan] += $value->wallet_log_amount;
        	}
        	else
        	{
        		$per_month[$date_m][$value->wallet_log_plan] = $value->wallet_log_amount;
        	}

        	if(isset($per_year[$date_y][$value->wallet_log_plan])) 
        	{
        		$per_year[$date_y][$value->wallet_log_plan] += $value->wallet_log_amount;
        	}
        	else
        	{
        		$per_year[$date_y][$value->wallet_log_plan] = $value->wallet_log_amount;
        	}

        }
        $data['per_day'] = $per_day;
        $data['per_month'] = $per_month;
        $data['per_year'] = $per_year;
        $data['plan_settings'] = $plan_settings;
    	return view('member.mlm_report.report.cashflow', $data);
    }
    public static function e_wallet($shop_id)
    {
    	$complan_per_day =Tbl_mlm_slot_wallet_log::slot()
    	->customer()
    	->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
    	->orderBy('wallet_log_date_created', 'DESC')
    	->get();
    	$plan_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        ->get()->keyBy('marketing_plan_code');
        $slot = Tbl_mlm_slot::where('shop_id', $shop_id)->get()->keyBy('slot_id');
        $per_complan = [];
        $plan = [];
        foreach($complan_per_day as $key => $value)
        {
        	$plan[$value->wallet_log_plan] = $value->wallet_log_plan;
        	if(isset($per_complan[$value->wallet_log_slot][$value->wallet_log_plan]))
        	{
        		$per_complan[$value->wallet_log_slot][$value->wallet_log_plan] += $value->wallet_log_amount;
        	}
        	else
        	{
        		$per_complan[$value->wallet_log_slot][$value->wallet_log_plan] = $value->wallet_log_amount;
        	}
        	
        }
        $data['per_complan'] = $per_complan;
        $data['plan'] = $plan;
        $data['plan_settings'] = $plan_settings;
        $data['slot'] = $slot;
        return view('member.mlm_report.report.e_wallet', $data);
    }
    public static function slot_count($shop_id)
    {
    	$slot = Tbl_mlm_slot::where('shop_id', $shop_id)->get()->keyBy('slot_id');
    	$tree = Tbl_tree_sponsor::where('shop_id', $shop_id)->orderBy('sponsor_tree_level', 'ASC')->get();

    	$tree_count = [];
    	$tree_level = [];
    	foreach($tree as $key => $value)
    	{
    		$tree_level[$value->sponsor_tree_level] = $value->sponsor_tree_level;
    		if(isset($tree_count[$value->sponsor_tree_parent_id][$value->sponsor_tree_level]))
    		{
    			$tree_count[$value->sponsor_tree_parent_id][$value->sponsor_tree_level] += 1;
    		}
    		else
    		{
    			$tree_count[$value->sponsor_tree_parent_id][$value->sponsor_tree_level] = 1;
    		}
    	}
    	$data['slot'] = $slot;
    	$data['tree'] = $tree_count;
    	$data['tree_level'] = $tree_level;
    	return view('member.mlm_report.report.slot_count', $data);
    }
    public static function top_earners($shop_id)
    {
    	$income =Tbl_mlm_slot_wallet_log::slot()
    	->customer()
    	->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
    	->orderBy('wallet_log_date_created', 'DESC');

    	$plan_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        ->get();

        $slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)->customer()->get()->keyBy('slot_id');

        // ->keyBy('marketing_plan_code')
        foreach($plan_settings as $key => $value)
        {
        	$filter[$key] = $value->marketing_plan_code;
        }
        $income = $income->whereIn('wallet_log_plan', $filter)->get();
        $income_top = [];
        foreach($income as $key => $value)
        {
        	if(isset($income_top[$value->wallet_log_slot]))
        	{
        		$income_top[$value->wallet_log_slot] += $value->wallet_log_amount;
        	}
        	else
        	{
        		$income_top[$value->wallet_log_slot] = $value->wallet_log_amount;
        	}
        }
        arsort($income_top);
        $data['income_top'] = $income_top;
        $data['slot'] = $slot;
        return view('member.mlm_report.report.top_earners', $data);

    }
    public static function new_register($shop_id)
    {
    	$customer = Tbl_customer::where('tbl_customer.shop_id', $shop_id)->whereNotNull('mlm_username')
    	->orderBy('created_date', 'DESC')
    	->get()->keyBy('customer_id');
    	$customer_per_day = [];

    	foreach($customer as $key => $value)
    	{
    		if(isset($customer_per_day[$value->created_date][$value->customer_id]))
    		{
    			$customer_per_day[$value->created_date][$value->customer_id] += 1;
    		}
    		else
    		{
    			$customer_per_day[$value->created_date][$value->customer_id] = 1;
    		}
    		
    	}
    	$data['customer'] = $customer;
    	$data['customer_per_day'] = $customer_per_day;
    	return view('member.mlm_report.report.new_accounts', $data);

    }
    public static function encashment_rep($shop_id)
    {
    	$slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)->customer()->get()->keyBy('slot_id');

    	$complan_per_day =Tbl_mlm_slot_wallet_log::slot()
    	->customer()
    	->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
    	->orderBy('wallet_log_date_created', 'DESC')
    	// ->where('wallet_log_plan','=', 'ENCASHMENT')
    	->get();

    	$request_a = [];
    	$encashment = [];
    	foreach($complan_per_day as $key => $value)
    	{
    		if($value->wallet_log_plan == 'ENCASHMENT')
    		{
    			$request = 'Requested';
	    		if($value->encashment_process_type  == 1)
	    		{
	    			$request = 'Processed';
	    		}
	    		else
	    		{
	    			$request = 'Requested';
	    		}
    		}
    		else
    		{
    			if($value->encashment_process == null)
    			{
    				$request = 'Pending';
    			}
    			else
    			{
    				$request = 'Requested';
    			}
    		}
    		$request_a[$request] = $request;
    	
    		if(isset($encashment[$value->wallet_log_slot][$request]))
    		{
    			$encashment[$value->wallet_log_slot][$request] += $value->wallet_log_amount;
    		}
    		else
    		{
    			$encashment[$value->wallet_log_slot][$request] = $value->wallet_log_amount;
    		}
    	}

    	$data['slot'] = $slot;
    	$data['encashment'] = $encashment;
    	$data['request'] = $request_a;

    	return view('member.mlm_report.report.encashment', $data);
    }


    public static function encashment($shop_id)
    {
        $data['not_encashed'] = $all_log = Tbl_mlm_slot_wallet_log::where('wallet_log_status', 'released')
            ->where('wallet_log_plan','!=', 'ENCASHMENT')
            ->where('shop_id', $shop_id)
            ->whereNull('encashment_process')
            ->sum('wallet_log_amount');
        if($data['not_encashed'] == null)
        {
            $data['not_encashed'] = 0;
        }    
        $data['not_encashed_requested'] = $all_log = Tbl_mlm_slot_wallet_log::where('wallet_log_status', 'released')
            ->where('wallet_log_plan','ENCASHMENT')
            ->where('shop_id', $shop_id)
            ->where('encashment_process_type', 0)
            ->sum('wallet_log_amount');    
        if($data['not_encashed_requested'] == null)
        {
            $data['not_encashed_requested'] = 0;
        } 
         $data['not_encashed_encashed'] = $all_log = Tbl_mlm_slot_wallet_log::where('wallet_log_status', 'released')
            ->where('wallet_log_plan','ENCASHMENT')
            ->where('shop_id', $shop_id)
            ->where('encashment_process_type', 1)
            ->sum('wallet_log_amount');  
        if($data['not_encashed_encashed'] == null)
        {
            $data['not_encashed_encashed'] = 0;
        } 
            $data['labels'][0] = 'Pending Wallet';
            $data['labels'][1] = 'Requested Wallet';
            $data['labels'][2] = 'Released Wallet';

            $data['data'][0] = $data['not_encashed'];
            $data['data'][1] = $data['not_encashed_requested'] * (-1);
            $data['data'][2] = $data['not_encashed_encashed'] * (-1);

        return json_encode($data);    
    }
    public static function per_complan($shop_id, $mode)
    {
        $plan_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Slot Creation')
            ->get();
        $data['plan'] = [];
        // $data['values'] = [];
        foreach($plan_settings as $key => $value)
        {
            $sum = Tbl_mlm_slot_wallet_log::where('shop_id', $shop_id)->where('wallet_log_plan', $value->marketing_plan_code)->sum('wallet_log_amount');
            $plan_settings[$key]->sum = $sum;
            $data['plan'][$key] = $value->marketing_plan_label;
            $data['series'][$key] = $sum;
        }    
        if($mode == 'json')
        {
            $data_a['labels'] = $data['plan'];
            $data_a['data'] = $data['series'];
            return json_encode($data_a);
        }
        else
        {
            return $data;
        }
        
        // dd($plan_settings);
    }
}