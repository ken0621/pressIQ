<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Validator;
use DB;
use App\Globals\Mlm_member;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_post;
use App\Models\Tbl_mlm_stairstep_settings;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_mlm_lead;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_country;
use App\Models\Tbl_ec_product;
use App\Models\Tbl_ec_variant;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_ec_order;
use Carbon\Carbon;
use App\Globals\Mlm_slot_log;
class MlmDashboardController extends Mlm
{
    public function index()
    {
        $data["page"] = "Dashboard";
        if(Self::$slot_id != null)
        {
            $data['income'] = Self::income_v2();
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
        if(Self::$shop_info->member_layout == 'myphone')
        {
            $data['slot_start_status'] = $this->slot_start_status();
            $data['direct']      = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)->where('wallet_log_plan', 'DIRECT')->sum('wallet_log_amount');
            $data['binary']      = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)->where('wallet_log_plan', 'BINARY')->sum('wallet_log_amount');

            $data['income_per_complan'] = Tbl_mlm_slot_wallet_log::slot()
            ->leftjoin('tbl_mlm_plan', 'tbl_mlm_plan.marketing_plan_code', '=','tbl_mlm_slot_wallet_log.wallet_log_plan')
            ->customer()
            ->where('tbl_mlm_slot.slot_id', Self::$slot_id)
            ->select(DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
            ->groupBy(DB::raw('wallet_log_plan') )
            ->get();

            foreach ($data['income_per_complan'] as $key => $value) 
            {
                # code...
                if($value->wallet_log_plan == 'DIRECT')
                {
                    // $data['income_per_complan'][$key]->wallet_log_plan = 'Referral';
                    $data['income_per_complan'][$key]->wallet_log_amount = $data['direct'];
                }
                if($value->wallet_log_plan == 'BINARY')
                {
                    // $data['income_per_complan'][$key]->wallet_log_plan = 'Matrix Bonus';
                    $data['income_per_complan'][$key]->wallet_log_amount = $data['binary'];
                }
            }
            $data['complan'] = Tbl_mlm_plan::where('shop_id', Self::$shop_id)->where('marketing_plan_enable', 1)->get()->keyBy('marketing_plan_code');

            $data['count_per_level'][1] = 2;
            $data['count_per_level'][2] = 4;
            $data['count_per_level'][3] = 8;
            $data['count_per_level'][4] = 16;
            $data['count_per_level'][5] = 32;
            $data['count_per_level'][6] = 64;
            $data['count_per_level'][7] = 128;
            $data['count_per_level'][8] = 256;
            $data['count_per_level'][9] = 512;
            $data['count_per_level'][10] = 1024;
            $data['count_per_level'][11] = 2048;

            $data['new_member'] = Tbl_mlm_slot::where('slot_sponsor', Self::$slot_id)
            ->customer()
            ->orderBy('slot_id', 'DESC')
            ->take(6)
            ->get();

        
            $data['tree_count'] = Tbl_tree_placement::where('placement_tree_parent_id', Self::$slot_id)
            // ->where('placement_tree_position', 'left')
            ->select(DB::raw('count(placement_tree_level ) as count_slot'), DB::raw('tbl_tree_placement.*'))
            ->groupBy(DB::raw('placement_tree_level') )
            ->groupBy('placement_tree_parent_id')
            ->orderBy('placement_tree_level', 'ASC')->get()->keyBy('placement_tree_level');

            $data['count_downline'] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)->count();
            
            $data['count_downline_per_countr_data'] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
            ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_tree_sponsor.sponsor_tree_child_id')
            ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
            ->join('tbl_country', 'tbl_country.country_id', '=','tbl_customer.country_id')
            ->get();

            $data['country_name'] = [];

            foreach($data['count_downline_per_countr_data'] as $key => $value)
            {
                if(isset($data['country_name'][$value->country_name]))
                {
                    $data['country_name'][$value->country_name] += 1;
                }
                else
                {
                    $data['country_name'][$value->country_name] = 1;
                }
                
            }

            foreach($data['country_name'] as $key => $value)
            {
                $data['country_name'][$key] = ($value/$data['count_downline']) * 100;
            }

            $data['recent_activity'] = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)->orderBy('wallet_log_id', 'DESC')->paginate(5);

            foreach($data['recent_activity'] as $key => $value)
            {
                $data['recent_activity'][$key]->ago =Carbon::createFromTimeStamp(strtotime($value->wallet_log_date_created))->diffForHumans();
            }
        }
        $data['news'] = Self::news();

        return view("mlm.dashboard", $data);
    }
    public function slot_start_status()
    {
        $return = null;
        if(isset(Self::$slot_now->slot_start_status))
        {
            $slot = Tbl_mlm_slot::where('slot_id', Self::$slot_id)->first();
            if(isset($slot)){
                if($slot->slot_start_status == 0)
                {
                    $update['slot_start_status'] = 1;
                    Tbl_mlm_slot::where('slot_id', Self::$slot_id)->update($update);
                    $data = [];
                    return view('mlm.dashboard.myphone_start');
                }
            }
        }
    }
    public function lead()
    {
        $data['page'] = 'Lead';
        $data['leads'] = Tbl_mlm_lead::where('lead_customer_id_sponsor', Self::$customer_id)
            ->customer()
            ->customer_address()
            ->customer_other_info()
            ->mlm_slot()
            ->get();
        
        return view("mlm.dashboard.lead", $data);
    }
    public function charts()
    {
        
    }
    public function tree_view()
    {
        $slot_tree = Tbl_tree_placement::child(4098)->orderby("placement_tree_level", "asc")->distinct_level()->parentslot()->membership()->get();
        foreach ($slot_tree as $key => $value) {
            $key2 = $key + 1;
            if(isset($slot_tree[$key2]))
            {
                $slot[$key][$key2] = $slot_tree[$key2];
            }
        }
        $data['slotss'] = $slot;
        $data['slot_tree'] = $slot_tree;
        return view('mlm.new_tree.index', $data);
    }
    public static function income_discount()
    {
        $data = [];
        $data['sample'] = Tbl_mlm_discount_card_log::whereNotNull('discount_card_customer_holder')->count();
        $data['all_discount'] = Tbl_mlm_discount_card_log::where('discount_card_customer_holder', Self::$customer_id)
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_discount_card_log.discount_card_customer_holder')
        ->get();
        return view('mlm.dashboard.income_discount', $data);
    }
    public static function income()
    {
    	$data = [];
    	$slot_id = Self::$slot_id;
    	$shop_id = Self::$shop_id;

    	$data['plan_settings'] = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        // ->where('marketing_plan_trigger', 'Slot Creation')
        ->where('marketing_plan_code', '!=', 'INDIRECT_POINTS')
        ->where('marketing_plan_code', '!=', 'DIRECT_POINTS')
        ->where('marketing_plan_code', '!=', 'INITIAL_POINTS')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD')
        ->where('marketing_plan_code', '!=', 'REPURCHASE_POINTS')
        ->where('marketing_plan_code', '!=', 'UNILEVEL_REPURCHASE_POINTS')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD_REPURCHASE')
        ->get();

        $data['plan_settings_2'] = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        // ->where('marketing_plan_trigger', 'Slot Creation')
        ->where('marketing_plan_code', '!=', 'DIRECT')
        ->where('marketing_plan_code', '!=', 'INDIRECT')
        ->where('marketing_plan_code', '!=', 'MEMBERSHIP_MATCHING')
        ->where('marketing_plan_code', '!=', 'LEADERSHIP_BONUS')
        ->where('marketing_plan_code', '!=', 'EXECUTIVE_BONUS')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD')
        ->where('marketing_plan_code', '!=', 'UNILEVEL')
        ->where('marketing_plan_code', '!=', 'REPURCHASE_CASHBACK')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD_REPURCHASE')
        ->where('marketing_plan_code', '!=', 'BINARY')
        ->get();

        foreach($data['plan_settings_2'] as $key => $value)
        {
            $data['earning_2'][$key] = Tbl_mlm_slot_points_log::where('points_log_complan', $value->marketing_plan_code)
            ->where('points_log_slot', $slot_id)
            ->sum('points_log_points');
            if($data['earning_2'][$key] == null)
            {
                $data['earning_2'][$key] = 0;
            }
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
        $data['repurchase_cash'] = Tbl_mlm_slot_wallet_log::where('wallet_log_plan', 'REPURCHASE')
            ->where('wallet_log_slot', $slot_id)
            ->sum('wallet_log_amount');

        $data['single_leg_income'] = Tbl_mlm_slot_wallet_log::where('wallet_log_plan', 'BINARY_SINGLE_LINE')
            ->where('wallet_log_slot', $slot_id)
            ->sum('wallet_log_amount');    
        $data['binary'] = $binary;
        $data['left'] = Self::$slot_now->slot_binary_left;
        $data['right'] = Self::$slot_now->slot_binary_right;

        $stairstep_plan = Tbl_mlm_plan::where("marketing_plan_code","STAIRSTEP")->where("shop_id",Self::$shop_id)->where("marketing_plan_enable",1)->first();

        if($stairstep_plan)
        {
            $stairstep_rank         = Tbl_mlm_slot::where("slot_id",Self::$slot_id)->first();
            $stairstep_rank         = Tbl_mlm_stairstep_settings::where("stairstep_id",$stairstep_rank->stairstep_rank)->first();
            if($stairstep_rank)
            {
                $data["slot_stairstep"] = $stairstep_rank->stairstep_name;
            }
            else
            {
                $data["slot_stairstep"] = "None";
            }
            
            $data["rebates"]        = Tbl_mlm_slot_wallet_log::where("wallet_log_plan","STAIRSTEP (Rebates)")->where("wallet_log_slot",Self::$slot_id)->where("shop_id",Self::$shop_id)->sum("wallet_log_amount");
            $data["override"]       = Tbl_mlm_slot_wallet_log::where("wallet_log_plan","STAIRSTEP (Over-ride)")->where("wallet_log_slot",Self::$slot_id)->where("shop_id",Self::$shop_id)->sum("wallet_log_amount");
        }
        else
        {
            $data["slot_stairstep"] = null;
            $data["rebates"]        = Tbl_mlm_slot_wallet_log::where("wallet_log_plan","STAIRSTEP (Rebates)")->where("wallet_log_slot",Self::$slot_id)->where("shop_id",Self::$shop_id)->sum("wallet_log_amount");
            $data["override"]       = Tbl_mlm_slot_wallet_log::where("wallet_log_plan","STAIRSTEP (Over-ride)")->where("wallet_log_slot",Self::$slot_id)->where("shop_id",Self::$shop_id)->sum("wallet_log_amount");
        }
    	return view('mlm.dashboard.income', $data);
    }

    public static function income_v2()
    {
        $data = [];
        $slot_id = Self::$slot_id;
        $shop_id = Self::$shop_id;
        $data['count_direct'] = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
        ->where('sponsor_tree_level', 1)
        ->count();
        $data['current_wallet'] = Mlm_slot_log::get_sum_wallet(Self::$slot_id);


        $data['plan_settings'] = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        // ->where('marketing_plan_trigger', 'Slot Creation')
        ->where('marketing_plan_code', '!=', 'INDIRECT_POINTS')
        ->where('marketing_plan_code', '!=', 'DIRECT_POINTS')
        ->where('marketing_plan_code', '!=', 'INITIAL_POINTS')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD')
        ->where('marketing_plan_code', '!=', 'REPURCHASE_POINTS')
        ->where('marketing_plan_code', '!=', 'UNILEVEL_REPURCHASE_POINTS')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD_REPURCHASE')
        ->get();

        $data['plan_settings_2'] = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        // ->where('marketing_plan_trigger', 'Slot Creation')
        ->where('marketing_plan_code', '!=', 'DIRECT')
        ->where('marketing_plan_code', '!=', 'INDIRECT')
        ->where('marketing_plan_code', '!=', 'MEMBERSHIP_MATCHING')
        ->where('marketing_plan_code', '!=', 'LEADERSHIP_BONUS')
        ->where('marketing_plan_code', '!=', 'EXECUTIVE_BONUS')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD')
        ->where('marketing_plan_code', '!=', 'UNILEVEL')
        ->where('marketing_plan_code', '!=', 'REPURCHASE_CASHBACK')
        ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD_REPURCHASE')
        ->where('marketing_plan_code', '!=', 'BINARY')
        ->get();

        foreach($data['plan_settings_2'] as $key => $value)
        {
            $data['earning_2'][$key] = Tbl_mlm_slot_points_log::where('points_log_complan', $value->marketing_plan_code)
            ->where('points_log_slot', $slot_id)
            ->sum('points_log_points');
            if($data['earning_2'][$key] == null)
            {
                $data['earning_2'][$key] = 0;
            }
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
        $data['repurchase_cash'] = Tbl_mlm_slot_wallet_log::where('wallet_log_plan', 'REPURCHASE')
            ->where('wallet_log_slot', $slot_id)
            ->sum('wallet_log_amount');

        $data['single_leg_income'] = Tbl_mlm_slot_wallet_log::where('wallet_log_plan', 'BINARY_SINGLE_LINE')
            ->where('wallet_log_slot', $slot_id)
            ->sum('wallet_log_amount');    
        $data['binary'] = $binary;
        $data['left'] = Self::$slot_now->slot_binary_left;
        $data['right'] = Self::$slot_now->slot_binary_right;

        $stairstep_plan = Tbl_mlm_plan::where("marketing_plan_code","STAIRSTEP")->where("shop_id",Self::$shop_id)->where("marketing_plan_enable",1)->first();

        if($stairstep_plan)
        {
            $stairstep_rank         = Tbl_mlm_slot::where("slot_id",Self::$slot_id)->first();
            $stairstep_rank         = Tbl_mlm_stairstep_settings::where("stairstep_id",$stairstep_rank->stairstep_rank)->first();
            if($stairstep_rank)
            {
                $data["slot_stairstep"] = $stairstep_rank->stairstep_name;
            }
            else
            {
                $data["slot_stairstep"] = "None";
            }
            
            $data["rebates"]        = Tbl_mlm_slot_wallet_log::where("wallet_log_plan","STAIRSTEP (Rebates)")->where("wallet_log_slot",Self::$slot_id)->where("shop_id",Self::$shop_id)->sum("wallet_log_amount");
            $data["override"]       = Tbl_mlm_slot_wallet_log::where("wallet_log_plan","STAIRSTEP (Over-ride)")->where("wallet_log_slot",Self::$slot_id)->where("shop_id",Self::$shop_id)->sum("wallet_log_amount");
        }
        else
        {
            $data["slot_stairstep"] = null;
            $data["rebates"]        = Tbl_mlm_slot_wallet_log::where("wallet_log_plan","STAIRSTEP (Rebates)")->where("wallet_log_slot",Self::$slot_id)->where("shop_id",Self::$shop_id)->sum("wallet_log_amount");
            $data["override"]       = Tbl_mlm_slot_wallet_log::where("wallet_log_plan","STAIRSTEP (Over-ride)")->where("wallet_log_slot",Self::$slot_id)->where("shop_id",Self::$shop_id)->sum("wallet_log_amount");
        }

        
        return view('mlm.dashboard.income_summary', $data);
    }
    public static function no_slot($shop_id)
    {
        return Mlm_member::add_slot_form(Self::$customer_id);
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
            if(Request::input("type") == "manual")
            {
                return Mlm_member::manual_add_slot(Self::$shop_id, Self::$customer_id);
            }
            else
            {
                return Mlm_member::add_slot(Self::$shop_id, Self::$customer_id);
            }
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
    public function news_content($id)
    {
        $data["post"] = Tbl_post::where("post_id", $id)->first();

        return view('mlm.dashboard.news_content', $data);
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
    public static function process_order_queue()
    {
        $data["slot_count"]  = Tbl_mlm_slot::where("slot_owner",Self::$customer_id)->count();
        $data['first_orders'] = Tbl_ec_order::where("customer_id",Self::$customer_id)->orderBy("ec_order_id","ASC")->get();

        $orders = [];
        $data['first_orders_item'] = [];
        foreach ($data['first_orders'] as $key => $value) {
            $data['first_orders_item'][$key] = Tbl_ec_variant::product()
            ->join('tbl_ec_order_item', 'tbl_ec_order_item.item_id', '=', 'tbl_ec_variant.evariant_id')
            ->where('ec_order_id', $value->ec_order_id)
            ->get();
        }
        
        // if($data["slot_count"] != 0)
        // {
        //     return Redirect::to("/mlm");
        // }
        return view("mlm.processing_order", $data);
    }
}