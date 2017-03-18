<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Validator;

use App\Globals\Mlm_member;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_post;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_mlm_lead;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_mlm_discount_card_log;
class MlmDashboardController extends Mlm
{
    public function index()
    {
        // return Mlm_member::add_to_session_edit(5, 301, 1);
    	// return Self::show_maintenance();
        $data["page"] = "Dashboard";
        if(Self::$slot_id != null)
        {
            $data['income'] = Self::income();
        }
        else
        {
            if(Self::$discount_card_log != null)
            {
                $data['income'] = Self::income_discount();
            }
            else
            {
                $data['income'] = Self::no_slot(Self::$shop_id);
            }
        }
        
        $data['news'] = Self::news();
        
        return view("mlm.dashboard", $data);
    }
    public static function income_discount()
    {
        $data = [];
        $data['sample'] = Tbl_mlm_discount_card_log::whereNotNull('discount_card_customer_holder')->count();
        // dd($data);
        // dd(Self::$discount_card_log);
        $data['all_discount'] = Tbl_mlm_discount_card_log::where('discount_card_customer_holder', Self::$customer_id)
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_discount_card_log.discount_card_customer_holder')
        ->get();
        // dd($data);
        return view('mlm.dashboard.income_discount', $data);
    }
    public static function income()
    {
    	$data = [];
    	$slot_id = Self::$slot_id;
    	$shop_id = Self::$shop_id;

    	$data['plan_settings'] = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        ->where('marketing_plan_trigger', 'Slot Creation')
        ->where('marketing_plan_code', '!=', 'INDIRECT_POINTS')
        ->where('marketing_plan_code', '!=', 'DIRECT_POINTS')
        ->where('marketing_plan_code', '!=', 'INITIAL_POINTS')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD')
        ->get();

        $data['plan_settings_2'] = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        ->where('marketing_plan_trigger', 'Slot Creation')
        ->where('marketing_plan_code', '!=', 'DIRECT')
        ->where('marketing_plan_code', '!=', 'INDIRECT')
        ->where('marketing_plan_code', '!=', 'MEMBERSHIP_MATCHING')
        ->where('marketing_plan_code', '!=', 'LEADERSHIP_BONUS')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD')
        ->where('marketing_plan_code', '!=', 'BINARY')
        ->get();
        // dd($data['plan_settings']);
        foreach($data['plan_settings_2'] as $key => $value)
        {
            $data['earning_2'][$key] = Tbl_mlm_slot_points_log::where('points_log_complan', $value->marketing_plan_code)
            ->where('points_log_slot', $slot_id)
            ->sum('points_log_points');
            if($data['earning_2'][$key] == null)
            {
                $data['earning_2'][$key] = 0;
            }
            // if()
        }

        $binary = 0;
        foreach($data['plan_settings'] as $key => $value)
        {
            if($value->marketing_plan_code == 'BINARY')
            {
                $binary = 1;
            }
        	$data['earning'][$key] = Tbl_mlm_slot_wallet_log::where('wallet_log_plan', $value->marketing_plan_code)
        	->where('wallet_log_slot', $slot_id)
        	->sum('wallet_log_amount');
        	if($data['earning'][$key] == null)
        	{
        		$data['earning'][$key] = 0;
        	}
        }
        $data['binary'] = $binary;
        $data['left'] = Self::$slot_now->slot_binary_left;
        $data['right'] = Self::$slot_now->slot_binary_right;
        // dd($binary);
    	return view('mlm.dashboard.income', $data);
    }
    public static function no_slot($shop_id)
    {
    	$data = [];
        $data['binary_settings'] = Tbl_mlm_plan::where('shop_id', $shop_id)
            ->where('marketing_plan_code', 'BINARY')
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Slot Creation')
            ->first();
        $data['binary_advance'] = Tbl_mlm_binary_setttings::where('shop_id', Self::$shop_id)->first();
        
        $data['lead'] = Tbl_mlm_lead::where('lead_customer_id_lead', Self::$customer_id)
        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=','tbl_mlm_lead.lead_slot_id_sponsor')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
        ->join('tbl_membership_code', 'tbl_membership_code.slot_id', '=', 'tbl_membership_code.slot_id')
        ->where('tbl_mlm_lead.lead_used', 0)
        ->first();

        $data['_slots'] = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', Self::$shop_id)->customer()->get();
        // dd($shop_id);
    	return view('mlm.dashboard.no_slot_v2', $data);
    }
    public static function claim_slot()
    {
        foreach($_POST as $key => $value)
        {
            $v[$key] = $value;
            $r[$key] = 'required';
        }
        $validator = Validator::make($v,$r);
        if ($validator->passes())
        {

            return Mlm_member::add_slot(Self::$shop_id, Self::$customer_id);
        }
        else
        {
            $data['response_status'] = "warning";
            $data['warning_validator'] = $validator->messages();
        }
        return json_encode($data);
    }
    public static function news()
    {
    	$data["_post"] = Tbl_post::where("archived", 0)->where('shop_id', Self::$shop_id)->get();

    	return view('mlm.dashboard.news', $data);
    }
    public static function profile()
    {
    	$data = [];
    	return view('mlm.dashboard.profile');
    }
    public static function password()
    {
    	$data = [];
    	return view('mlm.dashboard.password');
    }
}