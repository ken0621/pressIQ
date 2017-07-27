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
use App\Models\Tbl_item_code_invoice;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_journal_entry_line;
use App\Globals\Category;
use App\Models\Tbl_mlm_slot_wallet_log_transfer;
use Crypt;
class MLM_ReportController extends Member
{
    public function index()
    {
        // return $this->sales_chart_account();
        $shop_id = $this->user_info->shop_id; 
        # code...
        $data = [];

        $slot = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)->customer()->get()->keyBy('slot_id')->count();

        $wallet_from = Tbl_mlm_slot_wallet_log::where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->orderBy('wallet_log_date_created', 'ASC')->pluck('wallet_log_date_created');
        $wallet_to = Tbl_mlm_slot_wallet_log::where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->orderBy('wallet_log_date_created', 'DESC')->pluck('wallet_log_date_created');
        // -----------------------------------------------------------------
        $data['report_list']['cashflow'] = 'Complan Income Report';
        $data['report_list_d']['cashflow']['from'] = $wallet_from;
        $data['report_list_d']['cashflow']['to'] = $wallet_to;
        $data['report_list_d']['cashflow']['count'] = Tbl_mlm_slot_wallet_log::slot()
        ->customer()->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)->orderBy('wallet_log_date_created', 'DESC')
        ->select(DB::raw('wallet_log_date_created as wallet_log_date_created'), DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy(DB::raw('wallet_log_plan') )->groupBy('wallet_log_date_created')->get()->count();
        // -----------------------------------------------------------------
        $data['report_list']['e_wallet'] = 'E-Wallet Report';
        $data['report_list_d']['e_wallet']['from'] = Carbon::now();
        $data['report_list_d']['e_wallet']['to'] = Carbon::now();
        $data['report_list_d']['e_wallet']['count'] = $slot;
        // -----------------------------------------------------------------
        $data['report_list']['e_wallet_transfer'] = 'E-Wallet Transfer Report';
        $data['report_list_d']['e_wallet_transfer']['from'] = Carbon::now();
        $data['report_list_d']['e_wallet_transfer']['to'] = Carbon::now();
        $data['report_list_d']['e_wallet_transfer']['count'] = 999;
        // -----------------------------------------------------------------
        $data['report_list']['e_wallet_refill'] = 'E-Wallet Refill Report';
        $data['report_list_d']['e_wallet_refill']['from'] = Carbon::now();
        $data['report_list_d']['e_wallet_refill']['to'] = Carbon::now();
        $data['report_list_d']['e_wallet_refill']['count'] = 999;
        // -----------------------------------------------------------------
        $data['report_list']['e_wallet_tour'] = 'E-Wallet -> Tour Wallet Report';
        $data['report_list_d']['e_wallet_tour']['from'] = Carbon::now();
        $data['report_list_d']['e_wallet_tour']['to'] = Carbon::now();
        $data['report_list_d']['e_wallet_tour']['count'] = 999;
        // -----------------------------------------------------------------
        $data['report_list']['slot_count'] = 'Slot Count';
        $data['report_list_d']['slot_count']['from'] = Carbon::now();
        $data['report_list_d']['slot_count']['to'] = Carbon::now();
        $data['report_list_d']['slot_count']['count'] = $slot;
        // -----------------------------------------------------------------
        $data['report_list']['binary_slot_count'] = 'Binary Slot Count';
        $data['report_list_d']['binary_slot_count']['from'] = Carbon::now();
        $data['report_list_d']['binary_slot_count']['to'] = Carbon::now();
        $data['report_list_d']['binary_slot_count']['count'] = $slot;
        // -----------------------------------------------------------------
        $data['report_list']['top_earners'] = 'Top Earners';

        $income =Tbl_mlm_slot_wallet_log::slot()
        ->customer()
        ->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->select(DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
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
        // dd($income);
        $data['report_list_d']['top_earners']['count'] = $income;
        $data['report_list_d']['top_earners']['from'] = $wallet_from;
        $data['report_list_d']['top_earners']['to'] = $wallet_to;
         // -----------------------------------------------------------------
        $customer_from = Tbl_customer::where('shop_id', $shop_id)->orderBy('created_date', 'ASC')->whereNotNull('created_date')->pluck('created_date');
        $customer_to = Tbl_customer::where('shop_id', $shop_id)->orderBy('created_date', 'DESC')->whereNotNull('created_date')->pluck('created_date');
        $customer_counts = Tbl_customer::where('shop_id', $shop_id)->count();
        $customer_from_a = Carbon::parse($customer_from);
        $customer_to_a = Carbon::parse($customer_to);
        // dd($customer_from);
        $data['report_list']['new_register'] = 'Registered Account';
        $data['report_list_d']['new_register']['from'] = $customer_from_a;
        $data['report_list_d']['new_register']['to'] = $customer_to_a;
        $data['report_list_d']['new_register']['count'] = $customer_counts;
        // -----------------------------------------------------------------

        $complan_per_day =Tbl_mlm_slot_wallet_log::slot()
        ->customer()
        ->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->select(DB::raw('encashment_process_type as encashment_process_type'), DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy('encashment_process_type')
        ->groupBy(DB::raw('wallet_log_plan') )
        
        ->groupBy('wallet_log_slot')

        ->orderBy('wallet_log_amount', 'DESC')
        ->get()->count();

        $complan_per_day_req =Tbl_mlm_slot_wallet_log::slot()
        ->customer()
        ->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->select(DB::raw('encashment_process_type as encashment_process_type'), DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy('encashment_process_type')
        ->groupBy(DB::raw('wallet_log_plan') )
        ->where('encashment_process_type', 0)
        ->where('wallet_log_plan', 'ENCASHMENT')
        ->groupBy('wallet_log_slot')
        ->orderBy('wallet_log_amount', 'DESC')
        ->get()->count();

        $complan_per_day_pro =Tbl_mlm_slot_wallet_log::slot()
        ->customer()
        ->where('tbl_mlm_slot_wallet_log.shop_id', $shop_id)
        ->select(DB::raw('encashment_process_type as encashment_process_type'), DB::raw('wallet_log_plan as wallet_log_plan'), DB::raw('sum(wallet_log_amount ) as wallet_log_amount'), DB::raw('wallet_log_slot as wallet_log_slot'))
        ->groupBy('encashment_process_type')
        ->groupBy(DB::raw('wallet_log_plan') )
        ->where('encashment_process_type', 0)
        ->where('wallet_log_plan', 'ENCASHMENT')
        ->groupBy('wallet_log_slot')
        ->orderBy('wallet_log_amount', 'DESC')
        ->get()->count();


        $data['report_list']['encashment_rep'] = 'Encashment';
        $data['report_list_d']['encashment_rep']['count'] = $slot;
        $data['report_list_d']['encashment_rep']['to'] = Carbon::now();
        $data['report_list_d']['encashment_rep']['from'] = Carbon::now();
        // -----------------------------------------------------------------

        $data['report_list']['encashment_rep_req'] = 'Encashment(Requested)';
        $data['report_list_d']['encashment_rep_req']['count'] = $slot;
        $data['report_list_d']['encashment_rep_req']['to'] = Carbon::now();
        $data['report_list_d']['encashment_rep_req']['from'] = Carbon::now();
        // -----------------------------------------------------------------

        $data['report_list']['encashment_rep_pro'] = 'Encashment(Processed)';
        $data['report_list_d']['encashment_rep_pro']['count'] =  $slot;
        $data['report_list_d']['encashment_rep_pro']['to'] = Carbon::now();
        $data['report_list_d']['encashment_rep_pro']['from'] = Carbon::now();
        // -----------------------------------------------------------------
        $invoice = Tbl_item_code_invoice::where('shop_id', $shop_id)->get()->keyBy('item_code_invoice_id')->count();
        $invoice_f = Tbl_item_code_invoice::where('shop_id', $shop_id)->orderBy('item_code_invoice_id', 'ASC')->get()->keyBy('item_code_invoice_id')->first();
        $invoice_t = Tbl_item_code_invoice::where('shop_id', $shop_id)->orderBy('item_code_invoice_id', 'DESC')->get()->keyBy('item_code_invoice_id')->first();
        $data['report_list']['product_sales_report'] = 'Product Sales Report';
        if($invoice_f)
        {
            $data['report_list_d']['product_sales_report']['from'] =  $invoice_f->item_code_date_created;
        }
        else
        {
            $data['report_list_d']['product_sales_report']['from'] = Carbon::now();
        }

        if($invoice_t)
        {
            $data['report_list_d']['product_sales_report']['to'] = $invoice_t->item_code_date_created;
        }
        else
        {
            $data['report_list_d']['product_sales_report']['to'] = Carbon::now();
        }
        $data['report_list_d']['product_sales_report']['count'] = $invoice;
        // -----------------------------------------------------------------

        $invoice_m = Tbl_membership_code_invoice::where('shop_id', $shop_id)->get()->count();
        $invoice_m_f = Tbl_membership_code_invoice::where('shop_id', $shop_id)->orderBy('membership_code_invoice_id', 'ASC')->get()->first();
        $invoice_m_t = Tbl_membership_code_invoice::where('shop_id', $shop_id)->orderBy('membership_code_invoice_id', 'DESC')->get()->first();
        $data['report_list']['membership_code_sales_report'] = 'Membership Sales Report';
        if($invoice_m)
        {
            $data['report_list_d']['membership_code_sales_report']['from'] =  $invoice_m_f->membership_code_date_created;
            $data['report_list_d']['membership_code_sales_report']['to'] =  $invoice_m_t->membership_code_date_created;
            $data['report_list_d']['membership_code_sales_report']['count'] = $invoice_m;
        }
        else
        {
            $data['report_list_d']['membership_code_sales_report']['from'] =  Carbon::now();
            $data['report_list_d']['membership_code_sales_report']['to'] =  Carbon::now();
            $data['report_list_d']['membership_code_sales_report']['count'] = 0;
        }
        

        // yyyy-MM-dd
        // createFromFormat

       
        $data['report_list']['product_sales_report_warehouse'] = 'Product Sales Report (Ware house)';
        $data['report_list_d']['product_sales_report_warehouse']['from'] = Carbon::now();
        $data['report_list_d']['product_sales_report_warehouse']['to'] = Carbon::now();
        $data['report_list_d']['product_sales_report_warehouse']['count'] = 0;

        $data['report_list']['product_sales_report_consolidated'] = 'Product Sales Report (Consiladated)';
        $data['report_list_d']['product_sales_report_consolidated']['from'] = Carbon::now();
        $data['report_list_d']['product_sales_report_consolidated']['to'] = Carbon::now();
        $data['report_list_d']['product_sales_report_consolidated']['count'] = 0;

        foreach($data['report_list_d'] as $key => $value)
        {
            $data['report_list_d'][$key]['from'] = Carbon::parse($value['from'])->format('Y-m-d');
            $data['report_list_d'][$key]['to'] = Carbon::parse($value['to'])->format('Y-m-d');
            $data['report_list_d'][$key]['cashiers'] = 'hide';
            $data['report_list_d'][$key]['warehouse'] = 'hide';

            if($key == 'product_sales_report_warehouse' || $key == 'product_sales_report')
            {
                $data['report_list_d'][$key]['cashiers'] = 'show';
                $data['report_list_d'][$key]['warehouse'] = 'show';
            }
        }
        $report_get = Request::input('report_choose');
        if($report_get != null)
        {
            return $this->get_report();
        }

        $data['users'] = Tbl_user::where('user_shop', $shop_id)->where('archived', 0)->get();
        $data['warehouse'] = Tbl_warehouse::where('warehouse_shop_id', $shop_id)->where('archived', 0)->get();
        return view('member.mlm_report.index', $data);
    }
    public function get_report()
    {

        $filter['from'] = Request::input('from');
        $filter['to'] = Request::input('to');
        $from = Carbon::parse($filter['from']);
        $to = Carbon::parse($filter['to'])->addDay(1);
        $filter['to'] = $to;
        $filter['from'] = $from;
        $filter['skip'] = Request::input('skip');
        $filter['take'] = Request::input('take');

        // return $filter;
        $report = Request::input('report_choose');
        $pdf= Request::input('pdf');
        $shop_id = $this->user_info->shop_id;
        $view =  Mlm_report::$report($shop_id, $filter);
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
    public function sales_chart_account()
    {
        $entries = Tbl_journal_entry_line::account()
        ->item()
        ->journal()
        ->selectsales()
        ->get();
        dd($entries);
        $category = Category::re_select_raw($this->user_info->shop_id, 70, array("all","services","inventory","non-inventory","bundles"));
    }


}