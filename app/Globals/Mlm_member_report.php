<?php
namespace App\Globals;

use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_shop;
use App\Models\Tbl_customer;

use App\Http\Controllers\Member\MLM_MembershipController;
use App\Http\Controllers\Member\MLM_ProductController;

use Schema;
use Session;
use DB;
use Carbon\Carbon;
use Request;

use App\Globals\Mlm_compute;
use App\Globals\Mlm_slot_log;

class Mlm_member_report
{   
	public static function header($plan)
	{
		$data['plan'] = $plan;
		return view("mlm.report.report_header", $data);
	}
	public static function get_wallet($complan, $slot)
	{
		$search_slot = Request::input('search_slot');
		
		if($search_slot)
		{
			$report = Tbl_mlm_slot_wallet_log::where('wallet_log_plan', $complan)
	        ->where('wallet_log_slot', $slot)
	        ->sponsorslot()
	        ->customer()
	        ->where(DB::raw("CONCAT(tbl_customer.first_name, ' ', tbl_customer.middle_name, ' ', tbl_customer.last_name, ' ', tbl_mlm_slot.slot_no )"), 'LIKE', "%".$search_slot."%")
	        ->paginate(10);
			
		}
		else
		{
			$report = Tbl_mlm_slot_wallet_log::where('wallet_log_plan', $complan)
	        ->where('wallet_log_slot', $slot)
	        ->sponsorslot()
	        ->customer()
	        ->paginate(10);
		}
        foreach($report as $key => $value)
        {
            $report[$key]->level = Tbl_tree_sponsor::where('sponsor_tree_parent_id', $slot)
            ->where('sponsor_tree_child_id', $value->wallet_log_slot_sponsor)->pluck('sponsor_tree_level');
            $report[$key]->placement_level = Tbl_tree_placement::where('placement_tree_parent_id', $slot)
            ->where('placement_tree_child_id', $value->wallet_log_slot_sponsor)->pluck('placement_tree_level');
        }
        return $report;
	}
	public static function get_plan($complan, $shop_id)
	{
		$plan = Tbl_mlm_plan::where('shop_id', $shop_id)
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_code', $complan)
            ->first();
            
        return $plan;    
	}
}