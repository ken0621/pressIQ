<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Request;
use Image;
use Validator;
use Redirect;
use File;
use URL;
use App\Models\Tbl_shipping;
use App\Models\Tbl_user;
use App\Models\Tbl_customer;
use App\Models\Tbl_order;
use App\Models\Tbl_order_item;
use App\Models\Tbl_journal_entry_line;
use App\Globals\SalesReport;
use App\Globals\Report;
use Session;
use App;
use PDF;
use View;
use DB;
use Excel;
use App\Models\Tbl_report_field;
use App\Models\Tbl_category;
use App\Models\Tbl_chart_account_type;
use App\Globals\Pdf_global;

class ReportsController extends Member
{
	public function checkuser($str = '')
    {
        $user_info = Tbl_user::where("user_email", Session('user_email'))->shop()->first();
        switch ($str) {
            case 'user_id':
                return $user_info->user_id;
                break;
            case 'user_shop':
                return $user_info->user_shop;
                break;
            default:
                return '';
                break;
        }
    }
	public function index()
    {
		$shop_id = $this->checkuser('user_shop');
		
		$data = SalesReport::reportcount($shop_id);
		
	    return view('member.reports.index',$data);
	}
	
	public function endDate()
    {
        return date('Y-m-d');
    }
    
    public function startDate()
    {
        $year = date('Y') - 1;
        $month = date('m') + 1;
        if($month > 12){
            $month = 1;
        }
        $day = date('d');
        $start = $year.'-'.$month.'-'.$day;
        
        return $start;
    }

    /**
     * Check Date Period fro showing the date range
     *
     * @return json  $data    data['start_date'], data['end_date'], date['period']     
     * @author BKA  
     */
    public function get_date_period_covered()
    {
        $date['start']      = Request::input('from');
        $date['end']        = Request::input('to');
        $data['period']     = Request::input('report_period');
        $data['start_date'] = dateFormat(Report::checkDatePeriod($data['period'], $date)['start_date']);
        $data['end_date']   = dateFormat(Report::checkDatePeriod($data['period'], $date)['end_date']);
        
            
        return json_encode($data);
    }

    /* 
    *
    *--------- PRODUCTS REPORTS --------------- 
    *
    *
    */
	
    public function monthlysale()
    {
    	$end    = $this->endDate();
        $start  = $this->startDate();
        $shop_id = $this->checkuser('user_shop');
        $data['_sales'] = SalesReport::monthreport($shop_id, $start, $end);
        // dd($data);
    	return view('member.reports.sale.month',$data);
    }
    
    public function monthlysaleAjax()
    {
    	$start = date('Y-m-d', strtotime(Request::input("start")));
    	$end = date('Y-m-d', strtotime(Request::input("end")));
    	$shop_id = $this->checkuser('user_shop');
    	$data['_sales'] = SalesReport::SalesReportBy("month",$shop_id,$start, $end);
    	
    	return view('member.reports.sale.month_table',$data);
    }
    
    public function saleProduct()
    {
        $end        = $this->endDate();
        $start      = $this->startDate();
        $shop_id    = $this->checkuser('user_shop');
        $data       = SalesReport::productreport($shop_id,$start, $end);
        // if($data)
        $data['start'] = date('m/d/Y', strtotime($start));
        $data['end']   = date('m/d/Y', strtotime($end));
    	return view("member.reports.sale.product",$data);
    }
    
    public function variantProduct()
    {
    	$end    = $this->endDate();
        $start  = $this->startDate();
        $shop_id= $this->checkuser('user_shop');
        $data   = SalesReport::variantreport($shop_id, $start, $end);
        $data['start'] = date('m/d/Y', strtotime($start));
        $data['end'] = date('m/d/Y', strtotime($end));
        
    	return view("member.reports.sale.product_variant",$data);
    }
    
    public function saleCustomer()
    {
        $end    = $this->endDate();
        $start  = $this->startDate();
        $shop_id= $this->checkuser('user_shop');
        
        $data   = SalesReport::SalesReportBy('customer',$shop_id, $start, $end);
        $data['start'] = date('m/d/Y', strtotime($start));
        $data['end'] = date('m/d/Y', strtotime($end));
    	return view("member.reports.sale.customer",$data);
    }
    
    public function saleByAjax($name)
    {
        $start      = date('Y-m-d', strtotime(Request::input("start")));
    	$end        = date('Y-m-d', strtotime(Request::input("end")));
    	$shop_id    = $this->checkuser('user_shop');
    	$data       = SalesReport::SalesReportBy($name, $shop_id, $start, $end);
    	
    	if($data == 'no data')
        {
    	    return $data;
    	}
    	else
        {
    	    
    	    return view('member.reports.sale.' .$name .'_table',$data);
    	}
    	
    }
    
    public function customerOverTime()
    {
        $end    = $this->endDate();
        $start  = $this->startDate();
        $shop_id= $this->checkuser('user_shop');
        $data['_sales'] = SalesReport::monthlysale($shop_id, $start, $end);
        // dd($data);
        
        return view('member.reports.customer.customerOverTime',$data);
    }
    
    public function customerOTajax()
    {
        $start = date('Y-m-d', strtotime(Request::input("start")));
    	$end = date('Y-m-d', strtotime(Request::input("end")));
    	$shop_id = $this->checkuser('user_shop');
    	$data['_sales'] = SalesReport::monthlysale($shop_id, $start, $end);
    	return view('member.reports.customer.customerOTTable',$data);
    }
    public function pdfreport($name = '', $start = '00/00/0000', $end = '00/00/0000'){
        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));
        $shop_id = $this->checkuser('user_shop');
        $blade = '';
        $data = array();
        switch($name){
            case 'month':
                $blade = 'pdfmonth';
                $data = SalesReport::monthlysale($shop_id, $start, $end);
                break;
        }
        $view = 'member.reports.'.$blade;
        // dd($data);
        
        $pdf = PDF::loadView($view,$data);
        return $pdf->stream('Paycheque.pdf');
    }

    /* 
    *
    *--------- ACCOUNTING REPORTS --------------- 
    *
    *
    */

    public function accounting_sale()
    {
        $data =[];

        $report_code = 'accounting_sales_report';
        $data['field_checker'] = $this->report_field_checker_seed($report_code);
        $data['head_title'] = 'Sales Report';
        $data['head_icon'] = 'fa fa-area-chart';
        $data['head_discription'] = 'Account Sales Report';
        $data['head'] = $this->report_header($data);
        $data['action'] = '/member/report/accounting/sale/get/report';
        $data['report_code'] = $report_code;
        $data['table_header'] = Report::sales_report();

        return view('member.reports.accounting.sales', $data);
    }
    public function report_header($data)
    {
        return view('member.reports.head', $data);
    }

    public function report_field_checker_seed($filter = 'accounting_sales_report')
    {
        $shop_id = $this->user_info->shop_id; 
        $table_header = Report::sales_report($filter);
        foreach ($table_header as $key => $value) 
        {
            $count = DB::table('tbl_report_field')->where('report_field_shop', $shop_id)
            ->where('report_field_type', '=', $filter)
            ->where('report_field_module', '=', $key)
            ->count();
            if($count == 0)
            {
                $insert['report_field_shop'] = $shop_id;
                $insert['report_field_module'] = $key;
                $insert['report_field_label'] = $value;
                $insert['report_field_type'] = $filter;
                DB::table('tbl_report_field')->insert($insert);
            }
        }

        $data['report_field'] = Tbl_report_field::where('report_field_shop', '=', $shop_id)
        ->orderBy('report_field_position', 'ASC')
        ->where('report_field_archive', '=', 0)
        ->where('report_field_type', $filter)
        ->get()
        ->keyBy('report_field_module');
        $data['filter'] = $filter;
        $data['report_field_default'] = Report::sales_report($filter);
        return view('member.reports.field.check', $data);
    }

    public function accounting_sale_filter_edit()
    {
        $shop_id = $this->user_info->shop_id; 
        $report_field_module = Request::input('report_field_module');
        $report_field_position = Request::input('report_field_position');
        $report_field_type = Request::input('report_field_type');
        if($report_field_module)
        {
            $table_header = Report::sales_report();
            foreach ($table_header as $key => $value) 
            {
                if(!isset($report_field_module[$key]))
                {
                    $update['report_field_archive'] = 1;
                }
                else
                {
                    $update['report_field_archive'] = 0;
                }

                $update['report_field_position'] = $report_field_position[$key];
                Tbl_report_field::where('report_field_shop', $shop_id)
                ->where('report_field_module', $key)
                ->where('report_field_type', $report_field_type)
                ->update($update);
            }
        }
        $data['status'] = 'Success';
        $data['message'] = 'Nice';

        return json_encode($data);
    }

    public function accounting_sale_report_view()
    {
        $period         = Request::input('report_period');
        $date['start']  = Request::input('from');
        $date['end']    = Request::input('to');
        $from           = Report::checkDatePeriod($period, $date)['start_date'];
        $to             = Report::checkDatePeriod($period, $date)['end_date'];

        $report_type = Request::input('report_type');
        $report_field_type = Request::input('report_field_type');
        $data = [];
        $data['report_type'] = $report_type;
        $shop_id = $this->user_info->shop_id; 

        $data['sales'] = Tbl_journal_entry_line::account()
        ->item()
        ->journal()
        ->selectsales()
        ->where('je_shop_id', $shop_id)
        ->customerorvendor()
        // ->joinreciept()
        ->whereRaw("DATE(je_entry_date) >= '$from'")
        ->whereRaw("DATE(je_entry_date) <= '$to'")
        ->concatum()
        ->get()
        ->keyBy('jline_id');

        $data['sales_by_customer'] = [];
        foreach($data['sales'] as $key => $value)
        {
            $data['sales_by_customer'][$value->jline_name_id][$value->jline_id] = $value ;
            $data['customer_info'][$value->jline_name_id] = $value->full_name;
        }

        $data['sales_by_item'] = [];
        $data['category'] = [];
        $data['category_w'] = [];
        foreach($data['sales'] as $key => $value)
        {
            $data['sales_by_item'][$value->jline_item_id][$value->jline_id] = $value;
            $data['item_info'][$value->jline_item_id] = $value->item_name;
            $data['category'][$value->item_category_id][$value->jline_item_id][$value->jline_id] = $value;
            $data['category_w'][$value->item_category_id] = $value->item_category_id;
        }
        $data['category_data'] = Tbl_category::whereIn('type_id', $data['category_w'])
        ->get()
        ->keyBy('type_id');

        $data['report_field'] = Tbl_report_field::where('report_field_shop', '=', $shop_id)
        ->orderBy('report_field_position', 'ASC')
        ->where('report_field_archive', '=', 0)
        ->where('report_field_type', '=', $report_field_type)
        ->get()
        ->keyBy('report_field_module');

        if($report_field_type == 'accounting_sales_report')
        {
            $view =  'member.reports.output.sale';
            $type = 'Sale';
        }
        else if($report_field_type == 'accounting_sales_report_item')
        {
            $view =  'member.reports.output.item';
            $type = 'Item';
        }

        return Report::check_report_type($report_type, $view, $data, 'Sales_Report_By_'.$type.Carbon::now());
    }

    public function accounting_sale_items()
    {
        $data =[];
        $report_code = 'accounting_sales_report_item';
        $data['field_checker'] = $this->report_field_checker_seed($report_code );
        $data['head_title'] = 'Sales Report - Item ';
        $data['head_icon'] = 'fa fa-area-chart';
        $data['head_discription'] = 'Account Sales Report';
        $data['head'] = $this->report_header($data);
        $data['action'] = '/member/report/accounting/sale/get/report';
        $data['report_code'] = $report_code;
        $data['table_header'] = Report::sales_report($report_code );

        return view('member.reports.accounting.sales', $data);
    }
    public function profit_loss()
    {
        $data = [];

        $data['head_title'] = 'Profit and Loss Report';
        $data['head_icon'] = 'fa fa-area-chart';
        $data['head_discription'] = '';
        $data['head'] = $this->report_header($data);
        $data['action'] = '/member/report/accounting/profit/loss/get';
        $shop_id = $this->user_info->shop_id; 

        return view('member.reports.accounting.profit', $data);

    }
    public function profit_loss_get()
    {
        $period         = Request::input('report_period');
        $date['start']  = Request::input('from');
        $date['end']    = Request::input('to');
        $from           = Report::checkDatePeriod($period, $date)['start_date'];
        $to             = Report::checkDatePeriod($period, $date)['end_date'];

        $report_type = Request::input('report_type');
        $report_field_type = Request::input('report_field_type');
        $shop_id = $this->user_info->shop_id; 

        $filter[11] = 'Income';
        $filter[12] = 'Cost of Goods Sold';
        $filter[13] = 'Expense';
        $filter[14] = 'Other Expense';
        $filter[15] = 'Other Income';

        $data['account_income'] = Tbl_chart_account_type::whereIn('chart_type_name', $filter)
        ->get()->keyBy('chart_type_id');
        foreach($data['account_income'] as $key => $value)
        {

            $data['sum'][$key] = Tbl_journal_entry_line::account()
            ->where('chart_type_id', $value->chart_type_id)
            ->journal()
            ->select(DB::raw('*, sum(jline_amount ) as sum'))
            ->groupBy('jline_type')
            ->groupBy('jline_account_id')
            ->where('account_shop_id', $shop_id)
            ->whereRaw("DATE(je_entry_date) >= '$from'")
            ->whereRaw("DATE(je_entry_date) <= '$to'")
            ->get();

        }

        $view =  'member.reports.output.profit_loss'; 
        return Report::check_report_type($report_type, $view, $data, 'Profit_and_Loss'.Carbon::now());

        return view('member.reports.output.profit_loss', $data);
    }

    public function general_ledger()
    {
        $data = [];

        $data['head_title'] = 'General Ledger';
        $data['head_icon'] = 'fa fa-area-chart';
        $data['head_discription'] = '';
        $data['head'] = $this->report_header($data);
        $data['action'] = '/member/report/accounting/general/ledger/get';
        $shop_id = $this->user_info->shop_id; 
        
        return view('member.reports.accounting.general_ledger', $data);
    }

    public function general_ledger_get()
    {
        $period         = Request::input('report_period');
        $date['start']  = Request::input('from');
        $date['end']    = Request::input('to');
        $from           = Report::checkDatePeriod($period, $date)['start_date'];
        $to             = Report::checkDatePeriod($period, $date)['end_date'];
        
        $report_type = Request::input('report_type');
        $report_field_type = Request::input('report_field_type');
        $shop_id = $this->user_info->shop_id; 

        $data['entry_line'] = Tbl_journal_entry_line::account()
            ->where('account_shop_id', $shop_id)
            ->customerorvendorv2()
            ->groupBy('jline_account_id')
            ->groupBy('jline_je_id')
            ->journal()
            ->whereRaw("DATE(je_entry_date) >= '$from'")
            ->whereRaw("DATE(je_entry_date) <= '$to'")
            ->get();
        $data['chart_of_account'] = [];
        $data['chart_of_account_data'] = [];
        foreach($data['entry_line'] as $key => $value)
        {
            $data['chart_of_account'][$value->chart_type_id] = $value->account_name; 
            $data['chart_of_account_data'][$value->chart_type_id][$value->jline_id] = $value;
        }

        $view =  'member.reports.output.general_ledger'; 
        return Report::check_report_type($report_type, $view, $data, 'General-Ledger'.Carbon::now());
    }

    public function customer_list()
    {

    }

    public function vendor_list()
    {

    }

    public function item_list()
    {

    }

    public function account_list()
    {
        
    }

}