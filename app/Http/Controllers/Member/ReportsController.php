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
use App\Globals\SalesReport;
use Session;
use App;
use PDF;
use View;

class ReportsController extends Member
{
	public function checkuser($str = ''){
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
	public function index(){
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
	
    public function monthlysale(){
    	$end    = $this->endDate();
        $start  = $this->startDate();
        $shop_id = $this->checkuser('user_shop');
        $data['_sales'] = SalesReport::monthlysale($shop_id, $start, $end);
        // dd($data);
    	return view('member.reports.sale.month',$data);
    }
    
    public function monthlysaleAjax(){
    	$start = date('Y-m-d', strtotime(Request::input("start")));
    	$end = date('Y-m-d', strtotime(Request::input("end")));
    	$shop_id = $this->checkuser('user_shop');
    	$data['_sales'] = SalesReport::monthlysale($shop_id, $start, $end);
    	
    	return view('member.reports.sale.month_table',$data);
    }
    
    public function saleProduct()
    {
        $end        = $this->endDate();
        $start      = $this->startDate();
        $shop_id    = $this->checkuser('user_shop');
        $data       = SalesReport::SalesReportBy('product',$shop_id, $start, $end);
        $data['start'] = date('m/d/Y', strtotime($start));
        $data['end'] = date('m/d/Y', strtotime($end));
    	return view("member.reports.sale.product",$data);
    }
    
    public function variantProduct(){
    	$end    = $this->endDate();
        $start  = $this->startDate();
        $shop_id= $this->checkuser('user_shop');
        $data   = SalesReport::SalesReportBy('product_variant',$shop_id, $start, $end);
        $data['start'] = date('m/d/Y', strtotime($start));
        $data['end'] = date('m/d/Y', strtotime($end));
        // dd($data);
        
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
    	
    	if($data == 'no data'){
    	    return $data;
    	}
    	else{
    	    
    	    return view('member.reports.sale.' .$name .'_table',$data);
    	}
    	
    }
    
    public function customerOverTime(){
        $end    = $this->endDate();
        $start  = $this->startDate();
        $shop_id= $this->checkuser('user_shop');
        $data['_sales'] = SalesReport::monthlysale($shop_id, $start, $end);
        // dd($data);
        
        return view('member.reports.customer.customerOverTime',$data);
    }
    
    public function customerOTajax(){
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
}