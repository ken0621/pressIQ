<?php
namespace App\Globals;


use Schema;
use Session;
use DB;
use Carbon\Carbon;
use Request;

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
use App\Models\Tbl_item_code_invoice;
use App\Models\Tbl_item_code_item;
use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership_code_invoice;
use App\Models\Tbl_voucher_item;
use App\Models\Tbl_warehouse;
class Mlm_report
{   
    public static function general($shop_id, $filter)
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
        $data['page'] = 'general';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }
        // return $data;
        return view('member.mlm_report.report.general', $data);
    }
    public static function cashflow($shop_id, $filter)
    {

    	$complan_per_day =Tbl_mlm_slot_wallet_log::slot()
    	// ->leftjoin('tbl_mlm_plan', 'tbl_mlm_plan.marketing_plan_code', '=','tbl_mlm_slot_wallet_log.wallet_log_plan')
    	->customer()
    	->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
    	->orderBy('wallet_log_date_created', 'DESC')

        ->select(DB::raw('wallet_log_date_created as wallet_log_date_created'), DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy(DB::raw('wallet_log_plan') )
        ->groupBy('wallet_log_date_created')
        // -----------------------------------Filter
        ->where('wallet_log_date_created', '>=', $filter['from'])
        ->where('wallet_log_date_created', '<=', $filter['to'])
        ->skip($filter['skip'])
        ->take($filter['take'])
        // -----------------------------------End
    	->get();

    	$plan_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Slot Creation')
            ->get()->keyBy('marketing_plan_code');
       	$per_day = [];  
       	$per_month = []; 
       	$per_year = [];

        $filter = [];
       	// dd($complan_per_day);
        foreach($complan_per_day as $key => $value)
        {
        	// $date = Carbon::parse($value->)
        	// $date = Carbon::createFromFormat('d/m/Y', $value->wallet_log_date_created);
            $filter[$value->wallet_log_plan] = $value->wallet_log_plan;
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
        $data['filter'] = $filter;
        $data['per_day'] = $per_day;
        $data['per_month'] = $per_month;
        $data['per_year'] = $per_year;
        $data['plan_settings'] = $plan_settings;
        $data['page'] = 'cashflow';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }
        else
        {
            return view('member.mlm_report.report.cashflow', $data);
        }
    	
    }
    public static function e_wallet($shop_id, $filter)
    {
        $slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)

        // -----------------------------------Filter
        ->skip($filter['skip'])
        ->take($filter['take'])
        // -----------------------------------End

        ->customer()->get()->keyBy('slot_id');
        $wherein = [];
        foreach($slot as $key => $value)
        {
            $wherein[$key] = $key;
        }


    	$complan_per_day =Tbl_mlm_slot_wallet_log::slot()
    	->customer()
    	->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
    	->orderBy('wallet_log_slot', 'ASC')
        // ->where('wallet_log_amount', '!=', 0)
        ->select(DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy(DB::raw('wallet_log_plan') )
        ->groupBy('wallet_log_slot')

        ->whereIn('wallet_log_slot', $wherein)


    	->get();
        // dd($complan_per_day);
    	$plan_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        ->get()->keyBy('marketing_plan_code');
        
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
        $data['complan_per_day'] = $complan_per_day;
        $data['per_complan'] = $per_complan;
        $data['plan'] = $plan;
        $data['plan_settings'] = $plan_settings;
        $data['slot'] = $slot;

        $data['page'] = 'e_wallet';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }

        return view('member.mlm_report.report.e_wallet', $data);
    }
    public static function slot_count($shop_id, $filter)
    {
    	$slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)
        // -----------------------------------Filter
        ->skip($filter['skip'])
        ->take($filter['take'])
        // -----------------------------------End
        ->customer()->get()->keyBy('slot_id');

        $wherein = [];
        foreach($slot as $key => $value)
        {
            $wherein[$key] = $key;
        }


    	$tree = Tbl_tree_sponsor::where('shop_id', $shop_id)->orderBy('sponsor_tree_level', 'ASC')

        ->select(DB::raw('count(sponsor_tree_level) as count_slot'), DB::raw('tbl_tree_sponsor.*'))
        ->groupBy(DB::raw('sponsor_tree_level') )
        ->groupBy('sponsor_tree_parent_id')

        ->whereIn('sponsor_tree_parent_id', $wherein)
        ->get();

    	$tree_count = [];
    	$tree_level = [];
    	foreach($tree as $key => $value)
    	{
    		$tree_level[$value->sponsor_tree_level] = $value->sponsor_tree_level;
    		if(isset($tree_count[$value->sponsor_tree_parent_id][$value->sponsor_tree_level]))
    		{
    			$tree_count[$value->sponsor_tree_parent_id][$value->sponsor_tree_level] += $value->count_slot;
    		}
    		else
    		{
    			$tree_count[$value->sponsor_tree_parent_id][$value->sponsor_tree_level] = $value->count_slot;
    		}
    	}
    	$data['slot'] = $slot;
    	$data['tree'] = $tree_count;
    	$data['tree_level'] = $tree_level;

        $data['page'] = 'slot_count';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }
    	return view('member.mlm_report.report.slot_count', $data);
    }
    public static function binary_slot_count($shop_id, $filter)
    {
        $slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)
        // -----------------------------------Filter
        ->skip($filter['skip'])
        ->take($filter['take'])
        // -----------------------------------End
        ->customer()->get()->keyBy('slot_id');

        $wherein = [];
        foreach($slot as $key => $value)
        {
            $wherein[$key] = $key;
        }



        // ------------------------------------------------------------------------
        $tree = Tbl_tree_placement::where('shop_id', $shop_id)
        ->where('placement_tree_position', 'left')

        ->select(DB::raw('count(placement_tree_level ) as count_slot'), DB::raw('tbl_tree_placement.*'))
        ->groupBy(DB::raw('placement_tree_level') )
        ->groupBy('placement_tree_parent_id')

        ->whereIn('placement_tree_parent_id', $wherein)

        ->orderBy('placement_tree_level', 'ASC')->get();
        $tree_count = [];
        $tree_level = [];

        foreach($tree as $key => $value)
        {
            $tree_level[$value->placement_tree_level] = $value->placement_tree_level;
            if(isset($tree_count[$value->placement_tree_parent_id][$value->placement_tree_level]))
            {
                $tree_count[$value->placement_tree_parent_id][$value->placement_tree_level] += $value->count_slot;
            }
            else
            {
                $tree_count[$value->placement_tree_parent_id][$value->placement_tree_level] = $value->count_slot;
            }
        }
        // ------------------------------------------------------------------------
        $tree_r = Tbl_tree_placement::where('shop_id', $shop_id)
        ->where('placement_tree_position', 'right')

        ->select(DB::raw('count(placement_tree_level ) as count_slot'), DB::raw('tbl_tree_placement.*'))
        ->groupBy(DB::raw('placement_tree_level') )
        ->groupBy('placement_tree_parent_id')
        ->whereIn('placement_tree_parent_id', $wherein)
        ->orderBy('placement_tree_level', 'ASC')->get();

        $tree_count_r = [];
        $tree_level_r = [];

        foreach($tree_r as $key => $value)
        {
            $tree_level_r[$value->placement_tree_level] = $value->placement_tree_level;
            if(isset($tree_count_r[$value->placement_tree_parent_id][$value->placement_tree_level]))
            {
                $tree_count_r[$value->placement_tree_parent_id][$value->placement_tree_level] += $value->count_slot;
            }
            else
            {
                $tree_count_r[$value->placement_tree_parent_id][$value->placement_tree_level] = $value->count_slot;
            }
        }
        // ------------------------------------------------------------------------

        $data['slot'] = $slot;
        $data['tree'] = $tree_count;
        $data['tree_level'] = $tree_level;
        $data['tree_r'] = $tree_count_r;
        $data['tree_level_r'] = $tree_level_r;

        $data['page'] = 'binary_slot_count';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }

        return view('member.mlm_report.report.binary_slot_count', $data);
    }
    public static function top_earners($shop_id, $filters)
    {

    	$income =Tbl_mlm_slot_wallet_log::slot()
    	->customer()
    	->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->select(DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy('wallet_log_slot')
        ->orderBy('wallet_log_amount', 'DESC');
    	$plan_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        ->get();
        $filter = [];
        $slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)->customer()->get()->keyBy('slot_id');

        // ->keyBy('marketing_plan_code')
        foreach($plan_settings as $key => $value)
        {
        	$filter[$key] = $value->marketing_plan_code;
        }
        $income = $income->whereIn('wallet_log_plan', $filter)
        // -------------filter
        ->skip($filters['skip'])
        ->take($filters['take'])->get();
        //--------------end

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
        $data['page'] = 'top_earners';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }
        


        return view('member.mlm_report.report.top_earners', $data);

    }
    public static function new_register($shop_id, $filters)
    {
    	$customer = Tbl_customer::where('tbl_customer.shop_id', $shop_id)->whereNotNull('mlm_username')
        ->leftjoin('tbl_mlm_slot', 'tbl_mlm_slot.slot_owner', '=', 'tbl_customer.customer_id')
        ->select(DB::raw('count(slot_owner ) as count_slot'), 'tbl_customer.*')
        ->groupBy(DB::raw('tbl_customer.customer_id') )

        // -----------------------------------Filter
        ->where('created_date', '>=', $filters['from'])
        ->where('created_date', '<=', $filters['to'])
        ->skip($filters['skip'])
        ->take($filters['take'])
        // -----------------------------------End
        ->orderBy('created_date', 'ASC')
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

        $data['page'] = 'new_accounts';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }

    	return view('member.mlm_report.report.new_accounts', $data);

    }
    public static function encashment_rep($shop_id, $filters)
    {
    	$slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)->customer()
        // -----------------------------------Filter
        ->skip($filters['skip'])
        ->take($filters['take'])
        // -----------------------------------End
        ->get()->keyBy('slot_id');

        $wherein = [];
        foreach($slot as $key => $value)
        {
            $wherein[$key] = $key;
        }

    	$complan_per_day =Tbl_mlm_slot_wallet_log::slot()
    	->customer()
    	->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->select(DB::raw('encashment_process_type as encashment_process_type'), DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy('encashment_process_type')
        ->groupBy(DB::raw('wallet_log_plan') )
        
        ->groupBy('wallet_log_slot')

        ->whereIn('wallet_log_slot', $wherein)

        ->orderBy('wallet_log_amount', 'DESC')
    	->get();
    	$request_a = [];
    	$encashment = [];
    	foreach($complan_per_day as $key => $value)
    	{
    		if($value->wallet_log_plan == 'ENCASHMENT')
    		{
    			$request = 'Wallet';
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
    				$request = 'Wallet';
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

        $data['page'] = 'encashment';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }
    	return view('member.mlm_report.report.encashment', $data);
    }
    public static function encashment_rep_req($shop_id, $filters, $select= null)
    {
        $slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)->customer()
        // -----------------------------------Filter
        ->skip($filters['skip'])
        ->take($filters['take'])
        // -----------------------------------End
        ->get()->keyBy('slot_id');

        $wherein = [];
        foreach($slot as $key => $value)
        {
            $wherein[$key] = $key;
        }


        $encashment_req =Tbl_mlm_slot_wallet_log::slot()
        ->customer()
        ->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->join('tbl_mlm_encashment_process', 'tbl_mlm_encashment_process.encashment_process', '=', 'tbl_mlm_slot_wallet_log.encashment_process')
        ->join('tbl_mlm_encashment_process_details', 'tbl_mlm_encashment_process_details.encashment_process','=', 'tbl_mlm_slot_wallet_log.encashment_process')
        ->where('wallet_log_plan', 'ENCASHMENT')
        ->where('encashment_process_type', 0)
        ->orderBy('wallet_log_id', 'DESC')

        ->whereIn('wallet_log_slot', $wherein)

        ->orderBy('bank_name', 'DESC');

        if($select == null)
        {
            $encashment_req = $encashment_req->get()->keyBy('wallet_log_id');
        }
        else
        {
            $encashment_req = $encashment_req->where('wallet_log_selected', 1)->get()->keyBy('wallet_log_id');
        }
        
        $request_by_day = [];
        $request_by_month = [];
        foreach($encashment_req as $key => $value)
        {
            $date = Carbon::parse($value->wallet_log_date_created)->format('d-M-Y');
            $date_m = Carbon::parse($value->wallet_log_date_created)->format('M/Y');
            $date_y = Carbon::parse($value->wallet_log_date_created)->format('Y');
            $request_by_day[$date][$key] = $value;
            $request_by_month[$date_m][$key] = $value;
        }

        $data['by_day'] = $request_by_day;
        $data['by_month'] = $request_by_month;

        $data['page'] = 'encashment_requested';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }

        return view('member.mlm_report.report.encashment_requested', $data);
    }
    public static function encashment_rep_pro($shop_id, $filters)
    {
        $slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)->customer()
        // -----------------------------------Filter
        ->skip($filters['skip'])
        ->take($filters['take'])
        // -----------------------------------End
        ->get()->keyBy('slot_id');

        $wherein = [];
        foreach($slot as $key => $value)
        {
            $wherein[$key] = $key;
        }

        $encashment_req =Tbl_mlm_slot_wallet_log::slot()
        ->customer()
        ->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->join('tbl_mlm_encashment_process', 'tbl_mlm_encashment_process.encashment_process', '=', 'tbl_mlm_slot_wallet_log.encashment_process')
        ->join('tbl_mlm_encashment_process_details', 'tbl_mlm_encashment_process_details.encashment_process','=', 'tbl_mlm_slot_wallet_log.encashment_process')
        ->where('wallet_log_plan', 'ENCASHMENT')
        ->where('encashment_process_type', 1)
        ->orderBy('wallet_log_id', 'DESC')
        ->orderBy('bank_name', 'DESC')

        ->whereIn('wallet_log_slot', $wherein)

        ->get()->keyBy('wallet_log_id');
        $request_by_day = [];
        $request_by_month = [];
        foreach($encashment_req as $key => $value)
        {
            $date = Carbon::parse($value->wallet_log_date_created)->format('d-M-Y');
            $date_m = Carbon::parse($value->wallet_log_date_created)->format('M/Y');
            $date_y = Carbon::parse($value->wallet_log_date_created)->format('Y');
            $request_by_day[$date][$key] = $value;
            $request_by_month[$date_m][$key] = $value;
        }

        $data['by_day'] = $request_by_day;
        $data['by_month'] = $request_by_month;

        $data['page'] = 'encashment_processed';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }

        return view('member.mlm_report.report.encashment_processed', $data);
    }

    public static function product_sales_report($shop_id, $filters)
    {
        $data['filteru'] = $filters;
        $user_id = Request::input('user_id');
        $warehouse_id = Request::input('warehouse_id');
        $invoice = Tbl_item_code_invoice::where('tbl_item_code_invoice.shop_id', $shop_id)

        ->skip($filters['skip'])
        ->take($filters['take'])
        ->where('item_code_date_created', '>=', $filters['from'])
        ->where('item_code_date_created', '<=', $filters['to'])
        ->customer()
        ->leftjoin('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_item_code_invoice.slot_id')
        ->leftjoin('tbl_membership', 'tbl_membership.membership_id', '=', 'tbl_mlm_slot.slot_membership');
        
        if($user_id != null)
        {
           $invoice = $invoice->where('user_id', $user_id); 
           $data['user_a'] = Tbl_user::where('user_id', $user_id)->first();
        }
        if($warehouse_id != null)
        {
            $invoice = $invoice->where('warehouse_id', $warehouse_id);
            $data['warehouse'] = Tbl_warehouse::where('warehouse_id', $warehouse_id)->first();
        }

        $invoice = $invoice->get()->keyBy('item_code_invoice_id');
        // $item_code_item = Tbl_item_code_item::
        $where_in = [];
        foreach ($invoice as $key => $value) {
            # code...
            $where_in[$key] = $key;
        }
        $items = Tbl_item_code_item::whereIn('item_code_invoice_id', $where_in)->get();
        $inventory = [];
        $filter = [];
        $items_unfiltered = [];
        $data['payment'] = [];
        foreach($items as $key => $value)
        {
            if(isset($inventory[$value->item_name]['Price']))
            {
                $inventory[$value->item_name]['Quantity'] += $value->item_quantity;
                $inventory[$value->item_name]['Price'] += ($value->item_price * $value->item_quantity);
                $inventory[$value->item_name]['Membership Discount'] += $value->item_membership_discount * $value->item_quantity;
                $inventory[$value->item_name]['Membership Discounted'] += $value->item_membership_discounted * $value->item_quantity;
                // $inventory[$value->item_name]['Membership Discounted'] .= $value->item_membership_discounted * $value->item_quantity;
            }
            else
            {
                $inventory[$value->item_name]['Quantity'] = $value->item_quantity;
                $inventory[$value->item_name]['Price'] = $value->item_price * $value->item_quantity;
                $inventory[$value->item_name]['Membership Discount'] = $value->item_membership_discount * $value->item_quantity;
                $inventory[$value->item_name]['Membership Discounted'] = $value->item_membership_discounted * $value->item_quantity;
            }
            $items_unfiltered[$value->item_code_invoice_id][$key] = $value;
            

            switch ($value->item_code_payment_type) 
            {
                case 1:
                    $payment_a = 'CASH';
                    break;
                case 2:
                    $payment_a =  'GC';
                    break;
                case 3:
                    $payment_a =  'Wallet';
                    break;
                
                default:
                    $payment_a =  'CASH';
                    break;
            }
            if(isset($data['payment'][$payment_a]))
            {
                $data['payment'][$payment_a] += $value->item_membership_discounted * $value->item_quantity;
            }
            else
            {
                $data['payment'][$payment_a] = $value->item_membership_discounted * $value->item_quantity;
            }
            

        }

        $filter['Quantity'] = 'Quantity';
        $filter['Price'] = 'Price';
        $filter['Membership Discount'] = 'Membership Discount';
        $filter['Membership Discounted'] = 'Membership Discounted';

        $data['inventory'] = $inventory;
        $data['items'] = $items;
        $data['invoice'] = $invoice;
        $data['filter'] = $filter;
        $data['page'] = 'inventory';
        $data['items_unfiltered'] = $items_unfiltered;
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }


        return view('member.mlm_report.report.inventory', $data);
    }
    public static function membership_code_sales_report($shop_id, $filters)
    {
        $invoice = Tbl_membership_code_invoice::where('shop_id', $shop_id)

        ->skip($filters['skip'])
        ->take($filters['take'])
        ->where('membership_code_date_created', '>=', $filters['from'])
        ->where('membership_code_date_created', '<=', $filters['to'])

        ->get();

        $membership_code = Tbl_membership_code::where('tbl_membership_code.shop_id', $shop_id)
        ->join('tbl_membership_code_invoice', 'tbl_membership_code_invoice.membership_code_invoice_id', '=', 'tbl_membership_code.membership_code_invoice_id')
        
        ->skip($filters['skip'])
        ->take($filters['take'])
        ->where('membership_code_date_created', '>=', $filters['from'])
        ->where('membership_code_date_created', '<=', $filters['to'])

        ->get();

        $package = Tbl_membership_package::get()->keyBy('membership_package_id');
        $by_membership = [];
        foreach($membership_code as $key => $value)
        {
            if(isset($by_membership[$value->membership_package_id]))
            {
                $by_membership[$value->membership_package_id] += $value->membership_code_price;
            }
            else
            {
                $by_membership[$value->membership_package_id] = $value->membership_code_price;
            }
            
        }
        $per_package_item = Tbl_voucher_item::join('tbl_voucher', 'tbl_voucher.voucher_id', '=', 'tbl_voucher_item.voucher_id')
        ->join('tbl_membership_code_invoice', 'tbl_membership_code_invoice.membership_code_invoice_id', '=','tbl_voucher.voucher_invoice_membership_id')
        ->where('voucher_is_bundle', 0)
        ->get();

        $per_package_item_bundle = Tbl_voucher_item::join('tbl_voucher', 'tbl_voucher.voucher_id', '=', 'tbl_voucher_item.voucher_id')
        ->join('tbl_membership_code_invoice', 'tbl_membership_code_invoice.membership_code_invoice_id', '=','tbl_voucher.voucher_invoice_membership_id')
        ->where('voucher_is_bundle', 1)
        ->get()->keyBy('voucher_id');
        // dd($per_package_item_bundle);
        $item_package = [];
        foreach($per_package_item as $key => $value)
        {
            if(isset($item_package[$value->item_name]['item_price']))
            {
                $item_package[$value->item_name]['item_price'] += $value->item_price;
                $item_package[$value->item_name]['item_quantity'] +=  $value->item_quantity;
                if(isset($per_package_item_bundle[$value->voucher_id]))
                {
                    $item_package[$value->item_name]['item_bundle_quantity'] += $value->item_quantity * $per_package_item_bundle[$value->voucher_id]->item_quantity;
                }
                else
                {
                    $item_package[$value->item_name]['item_bundle_quantity'] += $value->item_quantity;
                }
                
            }
            else
            {
                $item_package[$value->item_name]['item_price'] = $value->item_price;
                $item_package[$value->item_name]['item_quantity'] =  $value->item_quantity;
                if(isset($per_package_item_bundle[$value->voucher_id]))
                {
                    $item_package[$value->item_name]['item_bundle_quantity'] = $value->item_quantity * $per_package_item_bundle[$value->voucher_id]->item_quantity;
                }
                else
                {
                    $item_package[$value->item_name]['item_bundle_quantity'] = $value->item_quantity;
                }
            }
            
        }
        $data['package_item'] = $item_package;
        $data['invoice'] = $invoice;
        $data['package'] = $package;
        $data['by_membership'] = $by_membership;

        $data['page'] = 'membership_code';
        if(Request::input('pdf') == 'excel')
        {
            return $data;
        }

        return view('member.mlm_report.report.membership_code', $data);
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