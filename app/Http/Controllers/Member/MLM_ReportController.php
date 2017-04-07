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
        // return Mlm_report::top_earners($shop_id);
        



        // $data['report_list']['general'] = 'General Report';
        $data['report_list']['cashflow'] = 'Complan Income Report';
        $data['report_list']['e_wallet'] = 'E-Wallet Report';
        $data['report_list']['slot_count'] = 'Slot Count';
        $data['report_list']['binary_slot_count'] = 'Binary Slot Count';
        $data['report_list']['top_earners'] = 'Top Earners';
        $data['report_list']['new_register'] = 'Registered Account';
        $data['report_list']['encashment_rep'] = 'Encashment';
        $data['report_list']['product_sales_report'] = 'Product Sales Report';
        $data['report_list']['membership_code_sales_report'] = 'Membership Sales Report';
        

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
        $data['view'] = $view->render();
        // return $view;
        $from = Request::input('from');
        if($from == 'paginate')
        {
            return $data['view'];
        }
        if($pdf == true)
        {
            return Pdf_global::show_pdf($data['view'], 'landscape');
        }
        else
        {
            return json_encode($data);
        }
        
    }



}