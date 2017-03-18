<?php

namespace App\Http\Controllers\Member;

use Request;
use Carbon\Carbon;
use Session;
use Validator;
use Redirect;
use Response;
use View;
use Excel;
use DB;

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
use App\Globals\Item;
use App\Globals\AuditTrail;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_complan_manager;
use App\Globals\Mlm_complan_manager_cd;
use App\Globals\Mlm_tree;
use App\Globals\Membership_code;
use App\Globals\Settings;
use App\Globals\Mlm_voucher;
use App\Globals\Mlm_slot_log;
use App\Globals\Item_code;
use App\Globals\Mlm_gc;
use App\Globals\Mlm_complan_manager_repurchase;
use App\Globals\Utilities;
use App\Globals\Mlm_compute;
use Crypt;
class MLM_ReportController extends Member
{
    public function index()
    {
        # code...
        $data = [];
        $shop_id = $this->user_info->shop_id;


        $data['membership'] = Tbl_membership::archive(0)->where('shop_id', $shop_id)->get();
        $data['count_all_slot_active'] = Tbl_mlm_slot::where('shop_id', $shop_id)->where('slot_active', 0)->count();
        $data['count_all_slot_inactive'] =  Tbl_mlm_slot::where('shop_id', $shop_id)->where('slot_active', 1)->count();

        $data['customer_account'] = Tbl_customer::where('shop_id', $shop_id)->where('ismlm', 1)->count();
        $data['customer_account_w_slot'] = Tbl_customer::where('tbl_customer.shop_id', $shop_id)->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_owner', '=', 'tbl_customer.customer_id')->count();
        
        $data['membership_count'] = [];
        $data['chart_per_complan'] = $this->per_complan($shop_id, 'json');
        $data['chart_per_complan_raw'] =  $this->per_complan($shop_id, 'raw');
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

        $data['encashment_json'] = $this->encashment($shop_id);

        foreach($data['membership'] as $key => $value)
        {
            $data['membership_count'][$key] = Tbl_mlm_slot::where('slot_membership', $value->membership_id)->count();
            $data['membership_price'][$key] = $data['membership_count'][$key] * $value->membership_price;
        }

        return view('member.mlm_report.index', $data);
    }
    public function per_complan($shop_id, $mode)
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
    public function encashment($shop_id)
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
}