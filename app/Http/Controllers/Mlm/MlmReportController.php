<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

use App\Globals\Mlm_member_report;

use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_matching_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_mlm_discount_card_log;
class MlmReportController extends Mlm
{
    public function index($complan)
    {
        return $this->$complan();
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
        return Self::show_maintenance();

        $data["page"] = "Report - Binary";
        return view("mlm.report.report_binary", $data);
    }
    public static function membership_matching()
    {
        $data['report']     = Mlm_member_report::get_wallet('MEMBERSHIP_MATCHING', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('MEMBERSHIP_MATCHING', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['report_matching'] = Tbl_mlm_matching_log::where('matching_log_earner', Self::$slot_id)->get();
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
        $data['report']     = Mlm_member_report::get_wallet('LEADERSHIP_BONUS', Self::$slot_id); 
        $data['plan']       = Mlm_member_report::get_plan('LEADERSHIP_BONUS', Self::$shop_id); 
        $data['header'] = Mlm_member_report::header($data['plan']);
        $data['points_log'] = Tbl_mlm_slot_points_log::where('points_log_complan', 'LEADERSHIP_BONUS')
        ->orderby('points_log_id', 'DESC')
        ->where('points_log_slot', Self::$slot_id)
        ->paginate(10);
        foreach($data['points_log'] as $key => $value)
        {
            $data['level'][$key] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
            ->where('sponsor_tree_child_id', $value->points_log_Sponsor)->pluck('sponsor_tree_level');
      
        }
        // $data = [];
        $tree = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_tree_sponsor.sponsor_tree_child_id')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
        ->join('tbl_membership', 'tbl_membership.membership_id', '=', 'tbl_mlm_slot.slot_membership')
        ->join('tbl_membership_code', 'tbl_membership_code.slot_id', '=', 'tbl_mlm_slot.slot_id')
        ->orderBy('tbl_tree_sponsor.sponsor_tree_level', 'ASC')
        ->get();
        $data['tree'] = [];
        $data['sum_all'] = 0;
        foreach($tree as $key => $value)
        {
            $sum = Tbl_mlm_slot_points_log::where('points_log_slot', $value->slot_id)->where('points_log_complan', 'LEADERSHIP_BONUS')->sum('points_log_points');
            $value->points = $sum;
            $data['tree'][$value->sponsor_tree_level][$value->slot_id] = $value;

        }
        // dd($data['tree'][1]);
        return view("mlm.report.report_leadership_bonus", $data);
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
}