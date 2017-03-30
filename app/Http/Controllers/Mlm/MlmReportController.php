<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DB;
use App\Globals\Mlm_member_report;

use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_matching_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_mlm_leadership_settings;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_matching;
class MlmReportController extends Mlm
{
    public function index($complan)
    {
    	if(Self::$slot_id != null)
        {
        	return $this->$complan();
        }
        else
        {
            return Self::show_no_access();
        }
    }
    public static function direct()
    {
        $data['report']     = Mlm_member_report::get_wallet('DIRECT', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('DIRECT', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        return view("mlm.report.report_direct", $data);
    }
    public static function indirect()
    {
        $data['report']     = Mlm_member_report::get_wallet('INDIRECT', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('INDIRECT', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        foreach($data['report'] as $key => $value)
        {
            $data['level'][$key] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
            ->where('sponsor_tree_child_id', $value->wallet_log_slot_sponsor)->pluck('sponsor_tree_level');
        }
        return view("mlm.report.report_indirect", $data);
    }
    public static function binary()
    {
        // return Self::show_maintenance();
        $data['report']     = Mlm_member_report::get_wallet('BINARY', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('BINARY', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        foreach($data['report'] as $key => $value)
        {
            $data['level'][$key] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
            ->where('sponsor_tree_child_id', $value->wallet_log_slot_sponsor)->pluck('sponsor_tree_level');
        }
        $data["page"] = "Report - Binary";
        return view("mlm.report.report_binary", $data);
    }
    public static function membership_matching()
    {
        $data['report']     = Mlm_member_report::get_wallet('MEMBERSHIP_MATCHING', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('MEMBERSHIP_MATCHING', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['report_matching'] = Tbl_mlm_matching_log::where('matching_log_earner', Self::$slot_id)->orderBy('matching_log', 'DESC')->paginate(10);
        $data['slot_1']  = [];
        $data['slot_2'] = [];
        foreach($data['report_matching'] as $key => $value)
        {
            $data['slot_1'][$key] = Tbl_mlm_slot::where('slot_id', $value->matching_log_slot_1)->customer()->first();
            $data['slot_2'][$key] = Tbl_mlm_slot::where('slot_id', $value->matching_log_slot_2)->customer()->first();
        }
        $data['matching_count'] = Tbl_mlm_matching_log::where('matching_log_earner', Self::$slot_id)->count();
        $data['count'] = Tbl_mlm_matching_log::where('matching_log_earner', Self::$slot_id)->get();


        $settings = 
        Tbl_mlm_matching::where('shop_id', Self::$shop_id)
        ->where('membership_id', Self::$slot_now->slot_membership)
        ->get()
        ->toArray();
        foreach($settings as $key => $value)
        {
        	$slot_per_level[$key] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
        	->where('sponsor_tree_level', '>=', $value['matching_settings_start'])
        	->where('sponsor_tree_level', '<=', $value['matching_settings_end'])
        	->join('tbl_mlm_slot', 'Tbl_mlm_slot.slot_id', '=', 'tbl_tree_sponsor.sponsor_tree_child_id')
        	->where('slot_matched_membership', 0)
        	->get()->keyBy('slot_id');
        	$matched_list[$key] = [];
        	$un_matched_list[$key] = [];
        	foreach($slot_per_level[$key] as $key2 => $value2)
        	{
        		$matched = Tbl_mlm_matching_log::where('matching_log_earner', Self::$slot_id)
        		->where('matching_log_slot_1', $key2)
        		// ->orWhere('matching_log_slot_2', $key2)
        		->count();
        		$matched_2 = Tbl_mlm_matching_log::where('matching_log_earner', Self::$slot_id)
        		->where('matching_log_slot_2', $key2)
        		// ->orWhere('matching_log_slot_2', $key2)
        		->count();

        		if($key2 == 344)
        		{
        			// dd($matched_2);
        		}
        		if($matched >= 1 || $matched_2 >= 1)
        		{
        			$matched_list[$key][$key2] = $value2;
        		}
        		else
        		{
        			$un_matched_list[$key][$key2] = $value2;
        		}
        	}
        }

        return view("mlm.report.report_membership_matching", $data);
    }
    public static function executive_bonus()
    {
        $data['report']     = Mlm_member_report::get_wallet('EXECUTIVE_BONUS', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('EXECUTIVE_BONUS', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['points_log'] = Tbl_mlm_slot_points_log::where('points_log_complan', 'EXECUTIVE_BONUS')
        ->orderby('points_log_id', 'DESC')
        ->where('points_log_slot', Self::$slot_id)
        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_mlm_slot_points_log.points_log_Sponsor')
        ->get();
        return view("mlm.report.report_executive_bonus", $data);
    }
    public static function leadership_bonus()
    {
        if(Self::$slot_id != null)
        {
            $slot = Self::$slot_now;
            // dd($slot->membership_id);   
            $data['report']     = Mlm_member_report::get_wallet('LEADERSHIP_BONUS', Self::$slot_id); 
            $data['plan']       = Mlm_member_report::get_plan('LEADERSHIP_BONUS', Self::$shop_id); 
            
            // dd($data);
            $data['header'] = Mlm_member_report::header($data['plan']);
            $data['points_log'] = Tbl_mlm_slot_points_log::where('points_log_complan', 'LEADERSHIP_BONUS')
            ->orderby('points_log_id', 'DESC')
            ->where('points_log_slot', Self::$slot_id)
            ->paginate(10);
            // dd($data);
            return view("mlm.report.report_leadership_bonus", $data);
        }
        else
        {
            return Self::show_no_access();
        }
        
    }
    public static function direct_points()
    {
        // return Self::show_maintenance();
        $data['plan']       = Mlm_member_report::get_plan('DIRECT_POINTS', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['points_log'] = Tbl_mlm_slot_points_log::where('points_log_complan', 'DIRECT_POINTS')
        ->orderby('points_log_id', 'DESC')
        ->where('points_log_slot', Self::$slot_id)
        ->paginate(10);
        return view("mlm.report.report_direct_points", $data);
    }
    public static function indirect_points()
    {
        $data['plan']       = Mlm_member_report::get_plan('INDIRECT_POINTS', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['points_log'] = Tbl_mlm_slot_points_log::where('points_log_complan', 'INDIRECT_POINTS')
        ->orderby('points_log_id', 'DESC')
        ->where('points_log_slot', Self::$slot_id)
        ->paginate(10);
        foreach($data['points_log'] as $key => $value)
        {
            $data['level'][$key] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
            ->where('sponsor_tree_child_id', $value->points_log_Sponsor)->pluck('sponsor_tree_level');
      
        }
        return view("mlm.report.report_indirect_points", $data);
    }
    public static function unilevel()
    {
        $data['report']     = Mlm_member_report::get_wallet('UNILEVEL', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('UNILEVEL', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        return view("mlm.report.report_unilevel", $data);
    }
    public static function repurchase_points()
    {
        $data['report']     = Mlm_member_report::get_wallet('REPURCHASE_POINTS', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('REPURCHASE_POINTS', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['points_log'] = Tbl_mlm_slot_points_log::where('points_log_complan', 'REPURCHASE_POINTS')
        ->orderby('points_log_id', 'DESC')
        ->where('points_log_slot', Self::$slot_id)
        ->paginate(10);
        return view("mlm.report.repurchase_points", $data);
    }
    public static function repurchase_cashback()
    {
        $data['report']     = Mlm_member_report::get_wallet('REPURCHASE_CASHBACK', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('REPURCHASE_CASHBACK', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        return view("mlm.report.report_repurchase_cashback", $data);
    }
    public static function unilevel_repurchase_points()
    {
        $data['report']     = Mlm_member_report::get_wallet('UNILEVEL_REPURCHASE_POINTS', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('UNILEVEL_REPURCHASE_POINTS', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['points_log'] = Tbl_mlm_slot_points_log::where('points_log_complan', 'UNILEVEL_REPURCHASE_POINTS')
        ->orderby('points_log_id', 'DESC')
        ->where('points_log_slot', Self::$slot_id)
        ->paginate(10);
        foreach($data['points_log'] as $key => $value)
        {
            $data['level'][$key] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
            ->where('sponsor_tree_child_id', $value->points_log_Sponsor)->pluck('sponsor_tree_level');
      
        }
        return view("mlm.report.report_unilevel_repurchase_points", $data);
    }
    public static function initial_points()
    {
        $data['report']     = Mlm_member_report::get_wallet('INITIAL_POINTS', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('INITIAL_POINTS', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['points_log'] = Tbl_mlm_slot_points_log::where('points_log_complan', 'INITIAL_POINTS')
        ->orderby('points_log_id', 'DESC')
        ->where('points_log_slot', Self::$slot_id)
        ->paginate(10);
        foreach($data['points_log'] as $key => $value)
        {
            $data['level'][$key] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
            ->where('sponsor_tree_child_id', $value->points_log_Sponsor)->pluck('sponsor_tree_level');
      
        }
        return view("mlm.report.report_initial_points", $data);
    }
    public static function discount_card()
    {
        $data['plan']       = Mlm_member_report::get_plan('DISCOUNT_CARD', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);

        $data['unused_discount_car'] = Tbl_mlm_discount_card_log::whereNull('discount_card_customer_holder')
        ->where('discount_card_slot_sponsor', Self::$slot_id)
        ->membership()->get();
        $data['used_discount_card'] = Tbl_mlm_discount_card_log::whereNotNull('discount_card_customer_holder')
        ->where('discount_card_slot_sponsor', Self::$slot_id)
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_discount_card_log.discount_card_customer_holder')
        ->membership()->get();
        // dd($data);
        return view("mlm.report.report_discount_card", $data);
    }
    public function direct_promotions()
    {
        // $data['report']     = Mlm_member_report::get_wallet('DIRECT_PROMOTIONS', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('DIRECT_PROMOTIONS', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['membership'] = Tbl_membership::where('shop_id', Self::$shop_id) 
        ->where('membership_id', '!=', 1)
        ->where('membership_archive', 0)->get();

        foreach($data['membership'] as $key => $value)
        {
            $data['direct_promotion'][$key] =   DB::table('tbl_mlm_plan_settings_direct_promotions')->where('shop_id', Self::$shop_id)->where('membership_id', $value->membership_id)->first();
            $data['count_direct'][$key] = Tbl_mlm_slot::where('slot_sponsor', Self::$shop_id)
                    ->where('slot_membership', $value->membership_id)
                    ->where('slot_matched_membership', 0)
                    ->count();
            $data['count_matched'][$key] = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)->where('wallet_log_plan', 'DIRECT_PROMOTIONS')
                        ->where('wallet_log_membership_filter', $value->membership_id)
                        ->count();
        }
        // dd($data);
        return view("mlm.report.report_direct_promotion", $data);
    }
}