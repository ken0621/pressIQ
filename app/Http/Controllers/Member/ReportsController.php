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
use App\Models\Tbl_report_field;
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

    public function accounting_sale()
    {
        $data =[];

        $data['field_checker'] = $this->report_field_checker_seed();
        $data['head_title'] = 'Sales Report';
        $data['head_icon'] = 'fa fa-area-chart';
        $data['head_discription'] = 'Account Sales Report';
        $data['head'] = $this->report_header($data);
        $data['filter'] = $this->report_filter('basic');
        $data['table_header'] = Report::sales_report();
        $data['sales_report_by_customer'] = $this->accounting_sale_report_view();

        return view('member.reports.accounting.sales', $data);
    }
    public function report_header($data)
    {
        return view('member.reports.head', $data);
    }
    public function report_filter($filter = 'basic')
    {
        $data = [];

        switch ($filter) 
        {
            case 'basic':
                return view('member.reports.filter.basic', $data);
                break;
            
            default:
                return view('member.reports.filter.basic', $data);
                break;
        }
    }
    public function report_field_checker_seed()
    {
        $shop_id = $this->user_info->shop_id; 
        $table_header = Report::sales_report();
        foreach ($table_header as $key => $value) 
        {
            $count = DB::table('tbl_report_field')->where('report_field_shop', $shop_id)
            ->where('report_field_type', '=', 'accounting_sales_report')
            ->where('report_field_module', '=', $key)
            ->count();
            if($count == 0)
            {
                $insert['report_field_shop'] = $shop_id;
                $insert['report_field_module'] = $key;
                $insert['report_field_label'] = $value;
                $insert['report_field_type'] = 'accounting_sales_report';
                DB::table('tbl_report_field')->insert($insert);
            }
        }

        $data['report_field'] = Tbl_report_field::where('report_field_shop', '=', $shop_id)
        ->where('report_field_archive', '=', 0)
        ->get()->keyBy('report_field_module');
        $data['report_field_default'] = Report::sales_report();
        return view('member.reports.field.check', $data);
    }
    public function accounting_sale_filter_edit()
    {
        $shop_id = $this->user_info->shop_id; 
        $report_field_module = Request::input('report_field_module');
        if($report_field_module)
        {
            $table_header = Report::sales_report();
            foreach ($table_header as $key => $value) 
            {
                if(!isset($report_field_module[$key]))
                {
                    $update['report_field_archive'] = 1;
                    Tbl_report_field::where('report_field_shop', $shop_id)
                    ->where('report_field_module', $key)
                    ->update($update);
                }
                else
                {
                    $update['report_field_archive'] = 0;
                    Tbl_report_field::where('report_field_shop', $shop_id)
                    ->where('report_field_module', $key)
                    ->update($update);
                }
            }
        }
        $data['status'] = 'Success';
        $data['message'] = 'Nice';

        return json_encode($data);
    }
    public function accounting_sale_report_view()
    {
        $data = [];
        $shop_id = $this->user_info->shop_id; 
        $data['sales'] = Tbl_journal_entry_line::account()
        ->item()
        ->journal()
        ->selectsales()
        ->where('je_shop_id', $shop_id)
        ->customerorvendor('customer')
        // ->joinreciept()
        ->concatum()
        ->get()->keyBy('jline_id');
        $data['sales_by_customer'] = [];
        foreach($data['sales'] as $key => $value)
        {
            $data['sales_by_customer'][$value->jline_name_id][$value->jline_id] = $value ;
            $data['customer_info'][$value->jline_name_id] = $value->full_name;
        }
        $data['report_field'] = Tbl_report_field::where('report_field_shop', '=', $shop_id)
        ->where('report_field_archive', '=', 0)
        ->get()->keyBy('report_field_module');
        // dd($data['sales_by_customer'][197]);
        return view('member.reports.output.sale', $data);
    }
}