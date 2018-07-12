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
        $data['head_title'] = 'Merchant Codes';
        $data['head_icon']  = 'fa fa-area-chart';
        $data['head_discription'] = '';
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
        $data['_warehouse'] = Warehouse2::get_all_warehouse($shop_id);
        //$warehouse_id = Request::input('warehouse_id');
        $warehouse_id = Warehouse2::get_current_warehouse($shop_id);

        $data['_from'] = $data['from']." "."00:00:00";
        $data['_to'] = $data['to']." "."11:59:59";
        $data['_item_product_code'] = Tbl_warehouse_inventory_record_log::slotinfo()->item()->membership()->where('record_shop_id',$shop_id)->where('record_warehouse_id',$warehouse_id)->where('item_type_id','!=',5)->groupBy('tbl_warehouse_inventory_record_log.record_log_id')->orderBy('tbl_warehouse_inventory_record_log.record_log_id')->where('record_inventory_status',0)->where('record_consume_ref_name',null)->where('item_in_use','unused')->whereBetween('record_log_date_updated', [$data['_from'], $data['_to']])->get();
        //dd(count($data['_item_product_code']));
        /* IF REPORT TYPE IS EXIST AND NOT RETURNING VIEW */
        if($report_type && !$load_view)
        {
            $view =  'member.reports.output.merchants_code'; 
            return Report::check_report_type($report_type, $view, $data, 'Merchants Code-'.Carbon::now());
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
    public function print_codes_report($from, $to)
    {
        //$search_keyword = '', $status = '', $paginate = 0, $item_id = 0, $get_to = 0, $take = 0, $from = "", $to = ""
        $data['_released'] = Item::get_all_item_record_log('', "released", null, null, null, null, $from, $to);
        $data['_reserved'] = Item::get_all_item_record_log('', "reserved", null, null, null, null, $from, $to);
        $data['_blocked'] = Item::get_all_item_record_log('', "block", null, null, null, null, $from, $to);
        $data['_used'] = Item::get_all_item_record_log('', "used", null, null, null, null, $from, $to);
        $data['_sold'] = Item::get_all_item_record_log('', "sold", null, null, null, null, $from, $to);
        $data['_printed'] = Item::get_all_item_record_log('', "printed", null, null, null, null, $from, $to);
        
        $data['_distributed'] = Item::get_all_item_record_log('', "distributed", null, null, null, null, $from, $to);
        $data['_unused'] = Item::get_all_item_record_log('','',null, null, null, null, $from, $to);

        Excel::create('Codes Report', function($excel) use ($data)
        {
            foreach($data as $key => $value)
            {
                $data_container["data"] = $value;
                $excel->sheet( str_replace('_', " ", $key) .' codes', function($sheet) use ($data_container)
                {
                    $sheet->setOrientation('landscape');
                    $sheet->loadView('member.mlm_code_v2.product_code_excel_table', $data_container);
                   
                });
            }
        })->download('xlsx');

        return view('member.reports.output.merchants_code');
    }
}