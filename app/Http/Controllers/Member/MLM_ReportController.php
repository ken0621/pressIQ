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
use App\Globals\Mlm_report;
use App\Globals\Pdf_global;
use App\Models\Tbl_membership_code_invoice;
use Crypt;
class MLM_ReportController extends Member
{
    public function index()
    {
        $shop_id = $this->user_info->shop_id; 
        # code...
        $data = [];


        // -----------------------------------------------------------------
        $data['report_list']['cashflow'] = 'Complan Income Report';
        $data['report_list_d']['cashflow']['from'] = Tbl_mlm_slot_wallet_log::where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->orderBy('wallet_log_date_created', 'ASC')->pluck('wallet_log_date_created');
        $data['report_list_d']['cashflow']['to'] = Tbl_mlm_slot_wallet_log::where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->orderBy('wallet_log_date_created', 'DESC')->pluck('wallet_log_date_created');
        $data['report_list_d']['cashflow']['count'] = Tbl_mlm_slot_wallet_log::slot()
        ->customer()->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)->orderBy('wallet_log_date_created', 'DESC')
        ->select(DB::raw('wallet_log_date_created as wallet_log_date_created'), DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy(DB::raw('wallet_log_plan') )->groupBy('wallet_log_date_created')->get()->count();
        // -----------------------------------------------------------------
        $data['report_list']['e_wallet'] = 'E-Wallet Report';
        $data['report_list_d']['e_wallet']['from'] = Tbl_mlm_slot_wallet_log::where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->orderBy('wallet_log_date_created', 'ASC')->pluck('wallet_log_date_created');
        $data['report_list_d']['e_wallet']['to'] = Tbl_mlm_slot_wallet_log::where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->orderBy('wallet_log_date_created', 'DESC')->pluck('wallet_log_date_created');
        $data['report_list_d']['e_wallet']['count'] = Tbl_mlm_slot_wallet_log::slot()
        ->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->orderBy('wallet_log_slot', 'ASC')
        ->where('wallet_log_amount', '!=', 0)
        ->select(DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy(DB::raw('wallet_log_plan') )
        ->groupBy('wallet_log_slot')
        ->get()->count();
        // -----------------------------------------------------------------
        $data['report_list']['slot_count'] = 'Slot Count';
        $data['report_list_d']['slot_count']['from'] = Tbl_tree_sponsor::where('tbl_tree_sponsor.shop_id', $shop_id)->orderBy('sponsor_tree_level', 'ASC')
        ->parent_info()->select(DB::raw('count(sponsor_tree_level) as count_slot'), DB::raw('tbl_tree_sponsor.*'), 'tbl_mlm_slot.*')
        ->groupBy(DB::raw('sponsor_tree_level') )
        ->groupBy('sponsor_tree_parent_id')
        ->orderBy('slot_created_date', 'ASC')
        ->pluck('slot_created_date');
        $data['report_list_d']['slot_count']['to'] = Tbl_tree_sponsor::where('tbl_tree_sponsor.shop_id', $shop_id)->orderBy('sponsor_tree_level', 'ASC')
        ->parent_info()->select(DB::raw('count(sponsor_tree_level) as count_slot'), DB::raw('tbl_tree_sponsor.*'), 'tbl_mlm_slot.*')
        ->groupBy(DB::raw('sponsor_tree_level') )
        ->groupBy('sponsor_tree_parent_id')
        ->orderBy('slot_created_date', 'DESC')
        ->pluck('slot_created_date');
        $data['report_list_d']['slot_count']['count'] = Tbl_tree_sponsor::where('tbl_tree_sponsor.shop_id', $shop_id)->orderBy('sponsor_tree_level', 'ASC')
        ->parent_info()
        ->select(DB::raw('count(sponsor_tree_level) as count_slot'), DB::raw('tbl_tree_sponsor.*'), 'tbl_mlm_slot.*')
        ->groupBy(DB::raw('sponsor_tree_level') )
        ->groupBy('sponsor_tree_parent_id')
        ->get()->count();
        // -----------------------------------------------------------------
        $data['report_list']['binary_slot_count'] = 'Binary Slot Count';
        $data['report_list_d']['binary_slot_count']['from'] =Tbl_tree_placement::where('tbl_tree_placement.shop_id', $shop_id)
        ->parent_info()
        ->where('placement_tree_position', 'left')
        ->select(DB::raw('count(placement_tree_level ) as count_slot'), DB::raw('tbl_tree_placement.*'), 'tbl_mlm_slot.*')
        ->groupBy(DB::raw('placement_tree_level') )
        ->groupBy('placement_tree_parent_id')
        ->orderBy('slot_created_date', 'ASC')
        ->pluck('slot_created_date');
        $data['report_list_d']['binary_slot_count']['to'] = Tbl_tree_placement::where('tbl_tree_placement.shop_id', $shop_id)
        ->parent_info()
        ->where('placement_tree_position', 'left')
        ->select(DB::raw('count(placement_tree_level ) as count_slot'), DB::raw('tbl_tree_placement.*'), 'tbl_mlm_slot.*')
        ->groupBy(DB::raw('placement_tree_level') )
        ->groupBy('placement_tree_parent_id')
        ->orderBy('slot_created_date', 'DESC')
        ->pluck('slot_created_date');
        $tree = Tbl_tree_placement::where('tbl_tree_placement.shop_id', $shop_id)
        ->parent_info()
        ->where('placement_tree_position', 'left')
        ->select(DB::raw('count(placement_tree_level ) as count_slot'), DB::raw('tbl_tree_placement.*'), 'tbl_mlm_slot.*')
        ->groupBy(DB::raw('placement_tree_level') )
        ->groupBy('placement_tree_parent_id')
        ->orderBy('placement_tree_level', 'ASC')->get()->count();
        $tree_r = Tbl_tree_placement::where('tbl_tree_placement.shop_id', $shop_id)
        ->parent_info()
        ->where('placement_tree_position', 'right')
        ->select(DB::raw('count(placement_tree_level ) as count_slot'), DB::raw('tbl_tree_placement.*'), 'tbl_mlm_slot.*')
        ->groupBy(DB::raw('placement_tree_level') )
        ->groupBy('placement_tree_parent_id')
        ->orderBy('placement_tree_level', 'ASC')->get()->count();
        if($tree >= $tree_r)
        {
            $data['report_list_d']['binary_slot_count']['count'] = $tree;
        }
        else
        {
            $data['report_list_d']['binary_slot_count']['count'] = $tree_r;
        }
        // -----------------------------------------------------------------
        $data['report_list']['top_earners'] = 'Top Earners';
        
        

        $income =Tbl_mlm_slot_wallet_log::slot()
        ->customer()
        ->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->select(DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy(DB::raw('wallet_log_plan') )
        ->groupBy('wallet_log_slot')
        ->orderBy('wallet_log_amount', 'DESC');

        $plan_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_enable', 1)
        ->get();

        foreach($plan_settings as $key => $value)
        {
            $filter[$key] = $value->marketing_plan_code;
        }
        $income = $income->whereIn('wallet_log_plan', $filter)->get()->count();
        $data['report_list_d']['top_earners']['count'] = $income;
        $data['report_list_d']['top_earners']['from'] = 0;
        $data['report_list_d']['top_earners']['to'] = 0;

        // dd($data); 
        $data['report_list']['new_register'] = 'Registered Account';
        $data['report_list_d']['new_register']['from'] = 0;
        $data['report_list_d']['new_register']['to'] = 0;
        $data['report_list_d']['new_register']['count'] = 0;

        $data['report_list']['encashment_rep'] = 'Encashment';
        $data['report_list_d']['encashment_rep']['from'] = 0;
        $data['report_list_d']['encashment_rep']['to'] = 0;
        $data['report_list_d']['encashment_rep']['count'] = 0;

        $data['report_list']['encashment_rep_req'] = 'Encashment(Requested)';
        $data['report_list_d']['encashment_rep_req']['from'] = 0;
        $data['report_list_d']['encashment_rep_req']['to'] = 0;
        $data['report_list_d']['encashment_rep_req']['count'] = 0;

        $data['report_list']['encashment_rep_pro'] = 'Encashment(Processed)';
        $data['report_list_d']['encashment_rep_pro']['from'] = 0;
        $data['report_list_d']['encashment_rep_pro']['to'] = 0;
        $data['report_list_d']['encashment_rep_pro']['count'] = 0;

        $data['report_list']['product_sales_report'] = 'Product Sales Report';
        $data['report_list_d']['product_sales_report']['from'] = 0;
        $data['report_list_d']['product_sales_report']['to'] = 0;
        $data['report_list_d']['product_sales_report']['count'] = 0;

        $data['report_list']['membership_code_sales_report'] = 'Membership Sales Report';
        $data['report_list_d']['membership_code_sales_report']['from'] = 0;
        $data['report_list_d']['membership_code_sales_report']['to'] = 0;
        $data['report_list_d']['membership_code_sales_report']['count'] = 0;
        
        $report_get = Request::input('report_choose');
        if($report_get != null)
        {
            return $this->get_report();
        }
        return view('member.mlm_report.index', $data);
    }
    public function get_report()
    {
        // return $_POST;
        $report = Request::input('report_choose');
        $pdf= Request::input('pdf');
        $shop_id = $this->user_info->shop_id;
        $view =  Mlm_report::$report($shop_id);
        $data['status'] = 'success';
        
        // return $view;
        $from = Request::input('from');
        if($from == 'paginate')
        {
            $data['view'] = $view->render();
            return $data['view'];
        }
        if($pdf == 'true')
        {

            $data['view'] = $view->render();
            return Pdf_global::show_pdf($data['view'], 'landscape');
        }
        else if($pdf == 'excel')
        {
            Excel::create('New file', function($excel) use($view) {

                $excel->sheet('New sheet', function($sheet) use($view) {

                    $sheet->loadView('member.mlm_report.report.' . $view['page'], $view);

                });

            })->export('xls');
        }
        else
        {
            $data['view'] = $view->render();
            return json_encode($data);
        }
        
    }



}