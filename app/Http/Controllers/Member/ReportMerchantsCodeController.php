<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use App\Globals\Warehouse2;



use App\Globals\SalesReport;
use App\Globals\Report;
use App\Globals\Pdf_global;
use App\Globals\Accounting;
use App\Globals\Item;

use App\Models\Tbl_shipping;
use App\Models\Tbl_user;
use App\Models\Tbl_customer;
use App\Models\Tbl_vendor;
use App\Models\Tbl_item;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_order;
use App\Models\Tbl_order_item;
use App\Models\Tbl_journal_entry_line;
use App\Models\Tbl_report_field;
use App\Models\Tbl_category;
use App\Models\Tbl_chart_account_type;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_warehouse_inventory_record_log;

use Carbon\Carbon;
use Request;
use Image;
use Validator;
use Redirect;
use File;
use URL;
use Session;
use App;
use PDF;
use View;
use DB;
use Excel;


class ReportMerchantsCodeController extends Member
{
    public function index()
    {
        $data['shop_name']  = $this->user_info->shop_key; 
        $data['head_title'] = 'Activated Sheet';
        $data['head_icon']  = 'fa fa-area-chart';
        $data['head_discription'] = 'Report';
        $data['head']       = $this->report_header($data);
        $data['action']     = '/member/report/merchants/code';
        $data['now']        = Carbon::now()->format('l F j, Y h:i:s A');

        $report_type    = Request::input('report_type');
        $load_view      = Request::input('load_view');
        $period         = Request::input('report_period') ? Request::input('report_period') : 'all';
        $date['start']  = Request::input('from');
        $date['end']    = Request::input('to');
        $data['from']   = Report::checkDatePeriod($period, $date)['start_date'];
        $data['to']     = Report::checkDatePeriod($period, $date)['end_date'];

        $shop_id = $this->user_info->shop_id;
        $data['_warehouse'] = Warehouse2::get_all_warehouse_user_id($shop_id, $this->user_info->user_id);

        $data['warehouse_id'] = Warehouse2::get_current_warehouse($shop_id);
        if(Request::input('warehouse_id') != null)
        {
            $data['warehouse_id'] = Request::input('warehouse_id');
        }
        $data['warehouse_name']= Warehouse2::get_warehouse_name($shop_id, $data['warehouse_id']);
        $data['_from'] = $data['from']." "."00:00:00";
        $data['_to'] = $data['to']." "."11:59:59";
        $data['_item_product_code'] = Item::get_all_item_record_log('', "distributed", null, null, null, null, $data['from'], $data['to'], $data['warehouse_id']);
        $return = Item::print_codes_report($data['_from'], $data['_to'], $data['warehouse_id']);

        /* IF REPORT TYPE IS EXIST AND NOT RETURNING VIEW */
        if($report_type && !$load_view)
        {
            $view =  'member.reports.output.merchants_code'; 
            $data["filter_type"] = Request::input("filter_type");
            return Report::check_report_type($report_type, $view, $data, 'Merchants Code-'.Carbon::now(), null, null, $return);
        }
        else
        {
            return view('member.reports.merchants.merchants_code', $data);
        }
    }
    public function report_header($data)
    {
        return view('member.reports.head', $data);
    }
    public function print_pdf()
    {
        return view('member.reports.pdf_selection');
    }
}