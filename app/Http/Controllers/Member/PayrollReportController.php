<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Response;
use Excel;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Globals\Payroll;
use PDF2;
use App\Globals\Payroll2;
use DateTime;

use App\Models\Tbl_payroll_employee_basic;

use App\Http\Controllers\Member\PayrollDeductionController;


use App\Models\Tbl_payroll_deduction_v2;
use App\Models\Tbl_payroll_deduction_employee_v2;
use App\Models\Tbl_payroll_deduction_payment_v2;
use App\Models\Tbl_payroll_company;
use App\Models\Tbl_payroll_period;
use App\Models\Tbl_payroll_time_keeping_approved;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_employment_status;
use App\Models\Tbl_payroll_employee_salary;
use App\Models\Tbl_payroll_register_column;


use App\Models\Tbl_payroll_leave_temp;
use App\Models\Tbl_payroll_leave_schedule;
use App\Models\Tbl_payroll_leave_employee;

use App\Globals\AuditTrail;



class PayrollReportController extends Member
{
	public function shop_id()
	{
		return $this->user_info->shop_id;
	}
	public function government_forms()
	{ 
		$data["page"] = "Monthly Government Forms";
		$data["_month_period"] = Payroll2::get_number_of_period_per_month($this->shop_id(), 2017);
		return view("member.payrollreport.government_forms", $data);
	}
	public function government_forms_hdmf($month)
	{ 
		$data["page"] = "Monthly Government Forms";
		$year = 2017;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;
		$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

		return view("member.payrollreport.government_forms_hdmf", $data);
	}
	public function government_forms_sss($month)
	{ 
		$data["page"] = "Monthly Government Forms";
		$year = 2017;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		// dd($contri_info);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;
		$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();
		// dd($contri_info);
		return view("member.payrollreport.government_forms_sss", $data);
	}
	public function government_forms_philhealth($month)
	{ 
		$data["page"] = "Monthly Government Forms";
		$year = 2017;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;
		$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

		return view("member.payrollreport.government_forms_philhealth", $data);
	}

	public function government_forms_hdmf_iframe($month,$company_id)
	{ 
		if($company_id==0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;

			$format["title"] = "A4";
			$format["format"] = "A4";
			$format["default_font"] = "sans-serif";
			// $format["margin_top"] = "0";
			// $format["margin_bottom"] = "0";
			// $format["margin_left"] = "0";
			// $format["margin_right"] = "0";

			$pdf = PDF2::loadView('member.payrollreport.government_forms_hdmf_pdf', $data, [], $format);
			return $pdf->stream('document.pdf');
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			$data['company_id1'] = $company_id;
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			
			$format["title"] = $data['company']->payroll_company_name;
			$format["format"] = "A4";
			$format["default_font"] = "sans-serif";
			$pdf = PDF2::loadView('member.payrollreport.government_forms_hdmf_pdf', $data, [], $format);
			return $pdf->stream('document.pdf');
		}
	}

	public function government_forms_hdmf_filter()
	{
		if (Request::input("company_id") > 0) 
		{
			$company_id =	Request::input("company_id");
        	$month      =	Request::input('month');
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			$data['company_id1'] = $company_id;
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			
			if($contri_info["_employee_contribution"]==null or $contri_info["_employee_contribution"]==0)
			{
				return "<center><font size='20'><br><br>No Employee Records<br><br><br><br></font></center>";
			}
			else
			{
				return view("member.payrollreport.government_forms_hdmf_filter", $data);
			}
		}
		else
		{
            $month      =	Request::input('month');
            $company_id =	Request::input("company_id");
            $data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id,$month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data['company_id1'] = $company_id;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();
           return view("member.payrollreport.government_forms_hdmf_filter", $data);
		}
	}

	public function government_forms_sss_filter()
	{
		$company_id =	Request::input("company_id");
		$month      =	Request::input('month');
		if (Request::input("company_id") > 0) {
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			$data["contri_info"] = $contri_info; 
			$data['company_id1'] = $company_id;
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			if($contri_info["_employee_contribution"]==null or $contri_info["_employee_contribution"]==0)
			{
				return "<center><font size='20'><br><br>No Employee Records<br><br><br><br></font></center>";
			}
			else
			{
				return view("member.payrollreport.government_forms_sss_filter", $data);
			}
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data['company_id1'] = $company_id;
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

			return view("member.payrollreport.government_forms_sss_filter", $data);
		}
	}
	public function government_forms_philhealth_filter()
	{
		$company_id =	Request::input("company_id");
		$month      =	Request::input('month');
		if ($company_id != null && $month != null) {
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			$data['company_id1'] = $company_id;
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			
			if($contri_info["_employee_contribution"]==null or $contri_info["_employee_contribution"]==0)
			{
				return "<center><font size='20'><br><br>No Employee Records<br><br><br><br></font></center>";
			}
			else
			{
				return view("member.payrollreport.government_forms_philhealth_filter", $data);
			}
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data['company_id1'] = $company_id;
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

			return view("member.payrollreport.government_forms_philhealth_filter", $data);
		}
	}
    public function government_forms_hdmf_export_excel($month,$company_id)
	{
		if($company_id==0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();


			AuditTrail::record_logs("DOWNLOAD","HDMF REPORT",$this->shop_id(),"","");
            // dd(count($contri_info["_employee_contribution"]));
			Excel::create("Government Forms HDMF",function($excel) use ($data)

			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_hdmf_export_excel',$data);
				});
			})->download('xls');        
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			AuditTrail::record_logs("DOWNLOAD","HDMF REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms HDMF".$data['company']->payroll_company_name,function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_hdmf_export_excel',$data);
				});
			})->download('xls');
		}
 			
	}
	public function government_forms_sss_export_excel($month,$company_id)
	{
		if($company_id==0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

			// AuditTrail::record_logs("DOWNLOAD","SSS REPORT",$this->shop_id(),"","");
			
			Excel::create("Government Forms SSS",function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_sss_export_excel',$data);
				});
			})->download('xls');
		}
		else
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			AuditTrail::record_logs("DOWNLOAD","SSS REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms SSS-".$data['company']->payroll_company_name,function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_sss_export_excel',$data);
				});
			})->download('xls');
		}
 			
	}
	public function government_forms_philhealth_export_excel($month,$company_id)
	{
		if($company_id==0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();
			AuditTrail::record_logs("DOWNLOAD","PHILHEALTH REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms PHILHEALTH",function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_philhealth_export_excel',$data);
				});
			})->download('xls');
		}
		else
		{
			$data["page"] = "Monthly Government Forms";


			$year = 2017;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id);
			
			$data["contri_info"] = $contri_info; 
			$data["month"] 		 = $month;
			$data["month_name"]  = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] 	 	 = $year;
			$data['company'] 	 = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
			AuditTrail::record_logs("DOWNLOAD","PHILHEALTH REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms PHILHEALTH".$data['company']->payroll_company_name,function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_philhealth_export_excel',$data);
				});
			})->download('xls');
		}
 			
	}



	/*START LOAN SUMMARY*/
	public function loan_summary()
	{
		$data["page"] = "Loan Summary";
		$data["_loan_data"] = PayrollDeductionController::get_deduction($this->shop_id());
		$data["_company"] = Payroll::company_heirarchy(Self::shop_id());//Tbl_payroll_company::where("shop_id", Self::shop_id())->where('payroll_parent_company_id', 0)->get();

		return view("member.payrollreport.loan_summary", $data);
	}

	public function table_loan_summary($deduction_type='')
	{
		$data["page"] = "Loan Summary";
		$deduction_type = str_replace("_"," ",$deduction_type);
		$data["_loan_data"] = PayrollDeductionController::get_deduction_by_type($this->shop_id(),$deduction_type);
		return view("member.payrollreport.loan_summary_table", $data);
	}

	public function table_company_loan_summary()
	{
		$data['company_id'] = Request::input('company_id');
		$data['_loan_data'] = Tbl_payroll_deduction_payment_v2::getallinfo($this->shop_id(),$data['company_id'],0)->get();

		return view('member.payrollreport.table_company_loan_summary',$data);
	}

	public function modal_loan_summary($employee_id = 0,$payroll_deduction_id = 0)
	{
		$data["employee_id"]   			= $employee_id;
		$data["payroll_deduction_id"]   = $payroll_deduction_id;
		$data["_loan_data"]    			= PayrollDeductionController::get_deduction_payment(0,$employee_id,$payroll_deduction_id);
		$data["employee_info"] 			= Tbl_payroll_employee_basic::where("payroll_employee_id",$employee_id)->first();
		return view("member.payroll.modal.modal_loan_summary", $data);
	}


	public function export_loan_summary_report_to_excel($employee_id = 0,$payroll_deduction_id = 0 )
	{
		if (Request::input('employee_id')!='') 
		{
			$employee_id = Request::input('employee_id');
			$payroll_deduction_id = Request::input('payroll_deduction_id');
		}
		$data["loan_deduction"]         = Tbl_payroll_deduction_v2::where('payroll_deduction_id',$payroll_deduction_id)->first();
		$data["_loan_data"]    			= PayrollDeductionController::get_deduction_payment(0,$employee_id,$payroll_deduction_id);
		$data["employee_info"] 			= Tbl_payroll_employee_basic::where("payroll_employee_id",$employee_id)->first();
		// dd($data);
		AuditTrail::record_logs("DOWNLOAD","LOAN SUMMARY REPORT",$this->shop_id(),"","");
		Excel::create($data['employee_info']->payroll_employee_display_name,function($excel) use ($data)
		{
			$excel->sheet('clients',function($sheet) use ($data)
			{
				$sheet->loadView('member.payrollreport.loan_summary_report',$data);
			});
		})->download('xls');
	}
	/*END LOAN SUMMARY*/


	/*START PAYROLL REGISTER REPORT*/

	public function payroll_register_report()
	{
		 // dd($this->shop_id());
		 $data["_company"] = Tbl_payroll_company::where("shop_id", $this->shop_id())->where('payroll_parent_company_id', 0)->get();
	    
	     $data['_period'] = Tbl_payroll_period::sel($this->shop_id())
	                                              ->where('payroll_parent_company_id', 0)
	                                              ->where('tbl_payroll_period_company.payroll_period_status','!=','pending')
	                                              ->join('tbl_payroll_period_company','tbl_payroll_period_company.payroll_period_id','=','tbl_payroll_period.payroll_period_id')
	                                              ->join('tbl_payroll_company', 'tbl_payroll_company.payroll_company_id','=', 'tbl_payroll_period_company.payroll_company_id')
	                                              ->orderBy('tbl_payroll_period.payroll_period_start','asc')
	                                              ->get();
	     
		return view("member.payrollreport.payroll_register_report", $data);
	}

	public function modal_create_register_report($period_company_id)
	{

	}

	public function payroll_register_report_period($period_company_id)
	{
		$data["period_company_id"]  = $period_company_id; 
		$data["company"] 			= Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();

		$data["period_info"] 		= $company_period = Tbl_payroll_period_company::sel($period_company_id)->first();
		$data["show_period_start"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_start));
		$data["show_period_end"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_end));
		
		$data['filtering_company']	= $period_company_id;
		$data['_company']           = Payroll::company_heirarchy(Self::shop_id());

		return view('member.payrollreport.payroll_register_report_period',$data);
	}

	public function payroll_register_report_table()
	{
		$payroll_company_id = request::input('payroll_company_id');
		$period_company_id  = request::input('period_company_id');

		$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();

		if ($payroll_company_id != 0) 
		{
			$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->where('employee_company_id',$payroll_company_id)->basic()->get();
			if (count($data["_employee"]) == 0 )
			{
				$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basicfilter($payroll_company_id)->get();
			}
		}

		
		$data = $this->get_total_payroll_register($data);
		// dd($data);

		// dd(unserialize($data["_employee"][0]["cutoff_input"]));
		$data = $this->get_total_payroll_register($data);
		// dd($data);
		$data['columns'] = Tbl_payroll_register_column::select('*')->get();

		return view('member.payrollreport.payroll_register_report_table', $data);
	}

	public function modal_filter_register_columns($period_company_id)
	{
			$data['period_company_id'] = $period_company_id;
			$data['columns'] = Tbl_payroll_register_column::select('*')->get();
			return view('member.payrollreport.modal_filter_register_columns',$data);
	}

	public function save_payroll_register_selected_columns()
	{		
			$update['name']							= 0;			
			$update['gross_basic_pay']				= 0;
			$update['absent']						= 0;
			$update['late']							= 0;
			$update['undertime']					= 0;
			$update['basic_pay']					= 0;
			$update['rendered_days']				= 0;
			$update['cola']							= 0;
			$update['overtime_pay']					= 0;
			$update['night_differential_pay']		= 0;
			$update['regular_holiday_pay']			= 0;
			$update['special_holiday_pay']			= 0;
			$update['restday_pay']					= 0;
			$update['leave_pay']					= 0;
			$update['allowance']					= 0;
			$update['bonus']						= 0;
			$update['commision']					= 0;
			$update['incentives']					= 0;
			$update['additions']					= 0;
			$update['month_13_and_other']			= 0;
			$update['de_minimis_benefit']			= 0;
			$update['others']						= 0;
			$update['gross_pay']					= 0;
			$update['deductions']					= 0;
			$update['cash_bond']					= 0;
			$update['cash_advance']					= 0;
			$update['other_loan']					= 0;
			$update['sss_loan']						= 0;
			$update['sss_ee']						= 0;
			$update['hdmf_loan']					= 0;
			$update['hdmf_ee']						= 0;
			$update['phic_ee']						= 0;
			$update['with_holding_tax']				= 0;
			$update['total_deduction']				= 0;
			$update['take_home_pay']				= 0;
			$update['sss_er']						= 0;
			$update['sss_ec']						= 0;
			$update['hdmf_er']						= 0;
			$update['phic_er']						= 0;

			if(!empty(request::input('name')))
			{
				$update['name'] = request::input('name');
			}
			if(!empty(request::input('gross_basic_pay')))
			{
				$update['gross_basic_pay'] = request::input('gross_basic_pay');
			}
			if(!empty(request::input('absent')))
			{
				$update['absent'] = request::input('absent');
			}	
			if(!empty(request::input('late')))
			{
				$update['late'] = request::input('late');
			}
			if(!empty(request::input('undertime')))
			{
				$update['undertime'] = request::input('undertime');
			}
			if(!empty(request::input('basic_pay')))
			{
				$update['basic_pay'] = request::input('basic_pay');
			}
			if(!empty(request::input('rendered_days')))
			{
				$update['rendered_days'] = request::input('rendered_days');
			}
			if(!empty(request::input('cola')))
			{
				$update['cola'] = request::input('cola');
			}
			if(!empty(request::input('overtime_pay')))
			{
				$update['overtime_pay'] = request::input('overtime_pay');
			}
			if(!empty(request::input('night_differential_pay')))
			{
				$update['night_differential_pay'] = request::input('night_differential_pay');
			}	
			if(!empty(request::input('regular_holiday_pay')))
			{
				$update['regular_holiday_pay'] = request::input('regular_holiday_pay');
			}
			if(!empty(request::input('special_holiday_pay')))
			{
				$update['special_holiday_pay'] = request::input('special_holiday_pay');
			}
			if(!empty(request::input('restday_pay')))
			{
				$update['restday_pay'] = request::input('restday_pay');
			}
			if(!empty(request::input('leave_pay')))
			{
				$update['leave_pay'] = request::input('leave_pay');
			}
			if(!empty(request::input('allowance')))
			{
				$update['allowance'] = request::input('allowance');
			}
			if(!empty(request::input('bonus')))
			{
				$update['bonus'] = request::input('bonus');
			}		
			if(!empty(request::input('commision')))
			{
				$update['commision'] = request::input('commision');
			}
			if(!empty(request::input('incentives')))
			{
				$update['incentives'] = request::input('incentives');
			}
			if(!empty(request::input('additions')))
			{
				$update['additions'] = request::input('additions');
			}
			if(!empty(request::input('month_13_and_other')))
			{
				$update['month_13_and_other'] = request::input('month_13_and_other');
			}
			if(!empty(request::input('de_minimis_benefit')))
			{
				$update['de_minimis_benefit'] = request::input('de_minimis_benefit');
			}	
			if(!empty(request::input('others')))
			{
				$update['others'] = request::input('others');
			}
			if(!empty(request::input('gross_pay')))
			{
				$update['gross_pay'] = request::input('gross_pay');
			}
			if(!empty(request::input('deductions')))
			{
				$update['deductions'] = request::input('deductions');
			}	
			if(!empty(request::input('cash_bond')))
			{
				$update['cash_bond'] = request::input('cash_bond');
			}
			if(!empty(request::input('cash_advance')))
			{
				$update['cash_advance'] = request::input('cash_advance');
			}	
			if(!empty(request::input('other_loan')))
			{
				$update['other_loan'] = request::input('other_loan');
			}
			if(!empty(request::input('sss_loan')))
			{
				$update['sss_loan'] = request::input('sss_loan');
			}
			if(!empty(request::input('sss_ee')))
			{
				$update['sss_ee'] = request::input('sss_ee');
			}
			if(!empty(request::input('hdmf_loan')))
			{
				$update['hdmf_loan'] = request::input('hdmf_loan');
			}																							
			if(!empty(request::input('hdmf_ee')))
			{
				$update['hdmf_ee'] = request::input('hdmf_ee');
			}
			if(!empty(request::input('phic_ee')))
			{
				$update['phic_ee'] = request::input('phic_ee');
			}
			if(!empty(request::input('with_holding_tax')))
			{
				$update['with_holding_tax'] = request::input('with_holding_tax');
			}
			if(!empty(request::input('total_deduction')))
			{
				$update['total_deduction'] = request::input('total_deduction');
			}
			if(!empty(request::input('take_home_pay')))
			{
				$update['take_home_pay'] = request::input('take_home_pay');
			}
			if(!empty(request::input('sss_er')))
			{
				$update['sss_er'] = request::input('sss_er');
			}
			if(!empty(request::input('sss_ec')))
			{
				$update['sss_ec'] = request::input('sss_ec');
			}
			if(!empty(request::input('hdmf_er')))
			{
				$update['hdmf_er'] = request::input('hdmf_er');
			}
			if(!empty(request::input('phic_er')))
			{
				$update['phic_er'] = request::input('phic_er');
			}

	        Tbl_payroll_register_column::where('payroll_register_columns_id', 6)->update($update);

	      $return['status'] = 'success';
	      $return['function_name']      = 'payroll_register_columns.action_register_report_table';
          return json_encode($return);
	}

	public function payroll_register_report_export_excel($period_company_id, $payroll_company_id)
	{
        $data["company"] 			= Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		$data["_employee"] 			= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
		$data["period_info"] 		= $company_period = Tbl_payroll_period_company::sel($period_company_id)->first();
		$data["show_period_start"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_start));
		$data["show_period_end"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_end));

		if ($payroll_company_id != 0) 
		{
			$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->where('employee_company_id',$payroll_company_id)->basic()->get();
			if (count($data["_employee"]) == 0 )
			{
				$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basicfilter($payroll_company_id)->get();
			}
		}

		$data = $this->get_total_payroll_register($data);

     	Excel::create($data["company"]->payroll_company_name, function($excel) use ($data)
		{
			$excel->sheet('clients',function($sheet) use ($data)
			{
				$sheet->loadView('member.payrollreport.payroll_register_report_export_excel',$data);
			});
		})->download('xls');
    }

    

	public function get_total_payroll_register($data)
	{
		$test = array();
		$total_gross_basic 			= 0;
		$total_basic 				= 0;
		$total_gross	 			= 0;
		$total_cutoff_basic 		= 0;
		$total_net 					= 0;
		$total_tax 					= 0;

		$g_total_er 				= 0;
		$g_total_ee 				= 0;
		$g_total_ec 				= 0;

		$total_sss_ee 				= 0;
		$total_sss_er 				= 0;
		$total_sss_ec 				= 0;
		$total_philhealth_ee 		= 0;
		$total_philhealth_er 		= 0;
		$total_pagibig_ee 			= 0;
		$total_pagibig_er 			= 0;
		$total_deduction 			= 0;

		$total_deduction_employee 	= 0;

		$_other_deduction 					= null;
		$_addition 							= null;
		$_deduction 						= null;

		$deduction_total 				= 0;
		$cola_total 					= 0;
		$sss_ee_total 					= 0;
		$sss_er_total 					= 0;
		$sss_ec_total 					= 0;
		$hdmf_ee_total 					= 0;
		$hdmf_er_total 					= 0;
		$philhealth_ee_total 			= 0;
		$philhealth_er_total 			= 0;
		$witholding_tax_total 			= 0;
		$adjustment_deduction_total 	= 0;
		$adjustment_allowance_total 	= 0;
		$allowance_total 				= 0;
		$allowance_de_minimis_total 	= 0;
		$cash_bond_total 				= 0;
		$cash_advance_total				= 0;
		$hdmf_loan_total				= 0;
		$sss_loan_total					= 0;
		$other_loans_total				= 0;

		$overtime_total 		 			= 0;
		$special_holiday_total 				= 0;
		$regular_holiday_total 				= 0;
		$leave_pay_total 	     			= 0;
		$late_total 			 			= 0;
		$undertime_total 		 			= 0;
		$absent_total 		 				= 0;
		$nightdiff_total 		 			= 0;
		$restday_total 		 				= 0;
		$rendered_days_total				= 0;

		$total_adjustment_allowance					= 0;
		$total_adjustment_bonus						= 0;
		$total_adjustment_commission				= 0;
		$total_adjustment_incentives				= 0;
		$total_adjustment_cash_advance				= 0;
		$total_adjustment_cash_bond					= 0;
		$total_adjustment_additions					= 0;
		$total_adjustment_deductions				= 0;
		$total_adjustment_others					= 0;
		$total_adjustment_13th_month_and_other 		= 0;
		$total_adjustment_de_minimis_benefit 		= 0;

		$time_total_time_spent				= 0;
		$time_total_overtime				= 0;
		$time_total_night_differential		= 0;
		$time_total_leave_hours				= 0;
		$time_total_undertime				= 0;
		$time_total_late					= 0;
		$time_total_regular_holiday			= 0;
		$time_total_special_holiday			= 0;
		$time_total_absent					= 0;

		foreach($data["_employee"] as $key => $employee)
		{
			// dd(unserialize($employee["cutoff_input"]));
			$payroll_group_salary_computation = Tbl_payroll_employee_contract::Group()->where('tbl_payroll_employee_contract.payroll_employee_id',$employee->payroll_employee_id)->first();

			$total_er = $employee->sss_er + $employee->philhealth_er +  $employee->pagibig_er;
			$total_ee = $employee->sss_ee + $employee->philhealth_ee +  $employee->pagibig_ee;
			$total_ec = $employee->sss_ec;

			$total_sss_ee 			+= Payroll2::payroll_number_format($employee->sss_ee,2);
			$total_sss_er 			+= Payroll2::payroll_number_format($employee->sss_er,2);
			$total_sss_ec 			+= Payroll2::payroll_number_format($employee->sss_ec,2);
			$total_philhealth_ee 	+= Payroll2::payroll_number_format($employee->philhealth_er,2);
			$total_philhealth_er 	+= Payroll2::payroll_number_format($employee->philhealth_er,2);
			$total_pagibig_ee 		+= Payroll2::payroll_number_format($employee->pagibig_ee,2);
			$total_pagibig_er 		+= Payroll2::payroll_number_format($employee->pagibig_er,2);

			// $total_deduction_employee += $employee["total_deduction"];

			$data["_employee"][$key] 		   = $employee;
			$data["_employee"][$key]->total_er = $total_er;
			$data["_employee"][$key]->total_ee = $total_ee;
			$data["_employee"][$key]->total_ec = $total_ec;



			$g_total_ec += Payroll2::payroll_number_format($total_ec,2);
			$g_total_er += Payroll2::payroll_number_format($total_er,2);
			$g_total_ee += Payroll2::payroll_number_format($total_ee,2);

			$total_deduction += ($total_ee);

			if (isset($employee->cutoff_breakdown)) 
			{

				$time_performance = unserialize($employee->cutoff_breakdown)->_time_breakdown;
				
				$data["_employee"][$key]->time_spent 				= $time_performance["time_spent"]["time"];
				$data["_employee"][$key]->time_overtime 			= $time_performance["overtime"]["time"];
				$data["_employee"][$key]->time_night_differential 	= $time_performance["night_differential"]["time"];
				$data["_employee"][$key]->time_leave_hours 			= $time_performance["leave_hours"]["time"];
				$data["_employee"][$key]->time_regular_holiday 		= $time_performance["regular_holiday"]["float"];
				$data["_employee"][$key]->time_special_holiday 		= $time_performance["special_holiday"]["float"];

				if ($payroll_group_salary_computation->payroll_group_code != "Flat Rate") 
				{
					$data["_employee"][$key]->time_absent 			= $time_performance["absent"]["float"];
					$data["_employee"][$key]->time_undertime 		= $time_performance["undertime"]["time"];
					$data["_employee"][$key]->time_late 			= $time_performance["late"]["time"];
				}
				else
				{
					$data["_employee"][$key]->time_absent 			= 0;
					$data["_employee"][$key]->time_undertime 		= 0;
					$data["_employee"][$key]->time_late 			= 0;
				}

				$time_total_time_spent				+= $time_performance["time_spent"]["time"];
				$time_total_overtime				+= $time_performance["overtime"]["time"];
				$time_total_night_differential		+= $time_performance["night_differential"]["time"];
				$time_total_leave_hours				+= $time_performance["leave_hours"]["time"];
				$time_total_regular_holiday			+= $time_performance["regular_holiday"]["float"];
				$time_total_special_holiday			+= $time_performance["special_holiday"]["float"];
				
				if ($payroll_group_salary_computation->payroll_group_code != "Flat Rate") 
				{
					$time_total_undertime				+= $time_performance["undertime"]["time"];
					$time_total_late					+= $time_performance["late"]["time"];
					$time_total_absent					+= $time_performance["absent"]["float"];
				}	
			}


			if(isset($employee->cutoff_breakdown))
			{
				$_duction_break_down = unserialize($employee->cutoff_breakdown)->_breakdown;
				$deduction 				= 0;
				$cola 					= 0;
				$sss_ee 				= 0;
				$sss_er 				= 0;
				$sss_ec 				= 0;
				$hdmf_ee 				= 0;
				$hdmf_er 				= 0;
				$philhealth_ee 			= 0;
				$philhealth_er 			= 0;
				$witholding_tax 		= 0;
				$adjustment_deduction 	= 0;
				$adjustment_allowance 	= 0;
				$allowance 				= 0;
				$allowance_de_minimis   = 0;
				$cash_bond 				= 0;
				$cash_advance			= 0;
				$hdmf_loan				= 0;
				$sss_loan				= 0;
				$other_loans			= 0;

				$adjustment_allowance 				= 0;
				$adjustment_bonus 					= 0;
				$adjustment_commission 				= 0;
				$adjustment_incentives 				= 0;
				$adjustment_cash_advance 			= 0;
				$adjustment_cash_bond 				= 0;
				$adjustment_additions 				= 0;
				$adjustment_deductions 				= 0;
				$adjustment_others 					= 0;
				$adjustment_13th_month_and_other 	= 0;
				$adjustment_de_minimis_benefit 		= 0;


				$adj_allowance_plus_allowance				= 0;
				$adj_de_menimis_plus_allowance_de_menimis	= 0;
				$adj_cashbond_plus_cashbond					= 0;
				$adj_cash_advance_plus_cash_advance			= 0;

				foreach($_duction_break_down as $breakdown)
				{
					if($breakdown["deduct.net_pay"] == true)
					{
						$total_deduction_employee += $breakdown["amount"];
						$deduction 				  += $breakdown["amount"];
					}
					if($breakdown["deduct.gross_pay"] == true)
					{
						$total_deduction_employee += $breakdown["amount"];
						$deduction 				  += $breakdown["amount"];
					}
					if ($breakdown["label"] == "SSS EE" || $breakdown["label"] == "PHILHEALTH EE" || $breakdown["label"] == "PAGIBIG EE" ) 
					{
						$total_deduction_employee += Payroll2::payroll_number_format($breakdown["amount"], 2);
						$deduction 			      += Payroll2::payroll_number_format($breakdown["amount"], 2);
					}
					if ($breakdown["label"] == "COLA") 
					{
						$cola 					  += Payroll2::payroll_number_format($breakdown["amount"], 2);
					}
					if($breakdown["label"] == "SSS EE")
					{
						$sss_ee 				  += Payroll2::payroll_number_format($breakdown["amount"], 2);
					}
					if($breakdown["label"] == "SSS ER")
					{
						$sss_er 				  += Payroll2::payroll_number_format($breakdown["amount"], 2);
					}
					if($breakdown["label"] == "SSS EC")
					{
						$sss_ec 				  += Payroll2::payroll_number_format($breakdown["amount"], 2);
					}
					if($breakdown["label"] == "PAGIBIG EE")
					{
						$hdmf_ee 				  += $breakdown["amount"];
					}
					if($breakdown["label"] == "PAGIBIG ER")
					{
						$hdmf_er 				  += Payroll2::payroll_number_format($breakdown["amount"], 2);
					}
					if($breakdown["label"] == "PHILHEALTH EE")
					{
						$philhealth_ee 			  += Payroll2::payroll_number_format($breakdown["amount"], 2);
					}
					if($breakdown["label"] == "PHILHEALTH ER")
					{
						$philhealth_er 			  += Payroll2::payroll_number_format($breakdown["amount"], 2);
					}
					if ($breakdown["label"] == "Witholding Tax") 
					{
						$witholding_tax 		  += Payroll2::payroll_number_format($breakdown["amount"], 2);
					}
					
					if ($breakdown["type"] == "adjustment") 
					{

						if ($breakdown["deduct.net_pay"] == true) 
						{
							$adjustment_deduction += Payroll2::payroll_number_format($breakdown["amount"], 2);
						}
						else
						{
							$adjustment_allowance += Payroll2::payroll_number_format($breakdown["amount"], 2);
						}


						if (isset($breakdown["category"])) 
						{
							// dd(strcasecmp($breakdown["category"], "incentives") == 0);
							if (strcasecmp($breakdown["category"], "Allowance") == 0) 
							{
								$adjustment_allowance += Payroll2::payroll_number_format($breakdown["amount"], 2);
							}
							if (strcasecmp($breakdown["category"], "Bonus") == 0) 
							{
								$adjustment_bonus 	  += Payroll2::payroll_number_format($breakdown["amount"], 2);
							}
							if (strcasecmp($breakdown["category"], "Commission") == 0) 
							{
								$adjustment_commission 	+= Payroll2::payroll_number_format($breakdown["amount"], 2);
							}
							if (strcasecmp($breakdown["category"], "incentives") == 0) 
							{
								$adjustment_incentives 	+= Payroll2::payroll_number_format($breakdown["amount"], 2);
							}
							if ($breakdown["category"] == "cash_advance") 
							{
								$adjustment_cash_advance += Payroll2::payroll_number_format($breakdown["amount"], 2);
							}
							if (strcasecmp($breakdown["category"], "cash_bond") == 0) 
							{
								$adjustment_cash_bond 	+= Payroll2::payroll_number_format($breakdown["amount"], 2);
							}
							if (strcasecmp($breakdown["category"], "additions") == 0) 
							{
								$adjustment_additions 	+= Payroll2::payroll_number_format($breakdown["amount"], 2);
							}
							if (strcasecmp($breakdown["category"], "deductions") == 0) 
							{
								$adjustment_deductions 	+= Payroll2::payroll_number_format( $breakdown["amount"], 2);
							}
							if (strcasecmp($breakdown["category"], "other") == 0) 
							{
								$adjustment_others 		+= $breakdown["amount"];
							}
							if (strcasecmp($breakdown["category"], "13th Month and Other Non Taxable Benefits") == 0) 
							{
								$adjustment_13th_month_and_other 	+= $breakdown["amount"];
							}
							if (strcasecmp($breakdown["category"], "De Minimis Benefit") == 0) 
							{
								$adjustment_de_minimis_benefit 		+= $breakdown["amount"];
							}
						}
					}
					if (isset($breakdown["record_type"])) 
					{
						if ($breakdown["record_type"] == "allowance_de_minimis") 
						{
							$allowance_de_minimis += Payroll2::payroll_number_format($breakdown["amount"],2);
						}
						if ($breakdown["record_type"] == "allowance") 
						{
							$allowance += Payroll2::payroll_number_format($breakdown["amount"],2);
						}
						if ($breakdown["record_type"] == "Cash Bond") 
						{
							$cash_bond += Payroll2::payroll_number_format($breakdown["amount"],2);
						}
						if ($breakdown["record_type"] == "Cash Advance") 
						{
							$cash_advance += Payroll2::payroll_number_format($breakdown["amount"],2);
						}
						if ($breakdown["record_type"] == "SSS Loan") 
						{
							$sss_loan += Payroll2::payroll_number_format($breakdown["amount"],2);
						}
						if ($breakdown["record_type"] == "HDMF Loan") 
						{
							$hdmf_loan += Payroll2::payroll_number_format($breakdown["amount"],2);
						}
						if ($breakdown["record_type"] == "Others") 
						{
							$other_loans += Payroll2::payroll_number_format($breakdown["amount"],2);	
						}
					}


				}

				$data["_employee"][$key]->total_deduction_employee 	= $deduction;
				$data["_employee"][$key]->cola 						= $cola;
				$data["_employee"][$key]->sss_ee 					= $sss_ee;
				$data["_employee"][$key]->sss_er 					= $sss_er;
				$data["_employee"][$key]->sss_ec 					= $sss_ec;
				$data["_employee"][$key]->hdmf_ee 					= $hdmf_ee;
				$data["_employee"][$key]->hdmf_er 					= $hdmf_er;
				$data["_employee"][$key]->philhealth_ee 			= $philhealth_ee;
				$data["_employee"][$key]->philhealth_er 			= $philhealth_er;
				$data["_employee"][$key]->witholding_tax 			= $witholding_tax;
				$data["_employee"][$key]->adjustment_deduction 		= $adjustment_deduction;
				$data["_employee"][$key]->adjustment_allowance 		= $adjustment_allowance;
				$data["_employee"][$key]->allowance_de_minimis 		= $allowance_de_minimis;
				$data["_employee"][$key]->allowance 				= $allowance;
				$data["_employee"][$key]->cash_bond					= $cash_bond;
				$data["_employee"][$key]->cash_advance				= $cash_advance;
				$data["_employee"][$key]->sss_loan					= $sss_loan;
				$data["_employee"][$key]->hdmf_loan					= $hdmf_loan;
				$data["_employee"][$key]->other_loans				= $other_loans;

				$data["_employee"][$key]->adjustment_allowance 					= $adjustment_allowance;
				$data["_employee"][$key]->adjustment_bonus 						= $adjustment_bonus;
				$data["_employee"][$key]->adjustment_commission 				= $adjustment_commission;
				$data["_employee"][$key]->adjustment_incentives 				= $adjustment_incentives;
				$data["_employee"][$key]->adjustment_cash_advance 				= $adjustment_cash_advance;
				$data["_employee"][$key]->adjustment_cash_bond 					= $adjustment_cash_bond;
				$data["_employee"][$key]->adjustment_additions 					= $adjustment_additions;
				$data["_employee"][$key]->adjustment_deductions 				= $adjustment_deductions;
				$data["_employee"][$key]->adjustment_others 					= $adjustment_others;
				$data["_employee"][$key]->adjustment_13th_month_and_other 		= $adjustment_13th_month_and_other;
				$data["_employee"][$key]->adjustment_de_minimis_benefit 		= $adjustment_de_minimis_benefit;


				$deduction_total				+= Payroll2::payroll_number_format($deduction, 2);
				$cola_total						+= Payroll2::payroll_number_format($cola, 2);

				$sss_ee_total						+= Payroll2::payroll_number_format($sss_ee, 2);
				$sss_er_total						+= Payroll2::payroll_number_format($sss_er, 2);
				$sss_ec_total						+= Payroll2::payroll_number_format($sss_ec, 2);
				$hdmf_ee_total						+= Payroll2::payroll_number_format($hdmf_ee, 2);
				$hdmf_er_total						+= Payroll2::payroll_number_format($hdmf_er, 2);
				$philhealth_ee_total				+= Payroll2::payroll_number_format($philhealth_ee, 2);
				$philhealth_er_total				+= Payroll2::payroll_number_format($philhealth_er, 2);
				$witholding_tax_total				+= Payroll2::payroll_number_format($witholding_tax, 2);

				$adjustment_deduction_total		+= Payroll2::payroll_number_format($adjustment_deduction,2);
				$adjustment_allowance_total		+= Payroll2::payroll_number_format($adjustment_allowance,2);
				$allowance_de_minimis_total		+= Payroll2::payroll_number_format($allowance_de_minimis,2);
				$allowance_total				+= Payroll2::payroll_number_format($allowance,2);
				$cash_bond_total				+= Payroll2::payroll_number_format($cash_bond,2);
				$cash_advance_total				+= Payroll2::payroll_number_format($cash_advance,2);
				$hdmf_loan_total				+= Payroll2::payroll_number_format($hdmf_loan,2);
				$sss_loan_total					+= Payroll2::payroll_number_format($sss_loan,2);
				$other_loans_total				+= Payroll2::payroll_number_format($other_loans,2);

				$total_adjustment_allowance					+= Payroll2::payroll_number_format($adjustment_allowance,2);
				$total_adjustment_bonus						+= Payroll2::payroll_number_format($adjustment_bonus,2);
				$total_adjustment_commission				+= Payroll2::payroll_number_format($adjustment_commission,2);
				$total_adjustment_incentives				+= Payroll2::payroll_number_format($adjustment_incentives,2);
				$total_adjustment_cash_advance				+= Payroll2::payroll_number_format($adjustment_cash_advance,2);
				$total_adjustment_cash_bond					+= Payroll2::payroll_number_format($adjustment_cash_bond,2);
				$total_adjustment_additions					+= Payroll2::payroll_number_format($adjustment_additions,2);
				$total_adjustment_deductions				+= Payroll2::payroll_number_format($adjustment_deductions,2);
				$total_adjustment_others					+= Payroll2::payroll_number_format($adjustment_others,2);
				
				$total_adjustment_13th_month_and_other		+= Payroll2::payroll_number_format($adjustment_13th_month_and_other,2);
				$total_adjustment_de_minimis_benefit		+= Payroll2::payroll_number_format($adjustment_de_minimis_benefit,2);
			}


			if (isset($employee->cutoff_input)) 
			{
				$_cutoff_input_breakdown = unserialize($employee->cutoff_input);
				
				$overtime 		 = 0;
				$special_holiday = 0;
				$regular_holiday = 0;
				$leave_pay 	     = 0;
				$late 			 = 0;
				$undertime 		 = 0;
				$absent 		 = 0;
				$nightdiff 		 = 0;
				$restday 		 = 0;
				$rendered_days   = 0;

				$ot_category = array('Rest Day OT', 'Over Time', 'Legal Holiday Rest Day OT', 'Legal OT', 'Special Holiday Rest Day OT', 'Special Holiday OT');
				$nd_category = array('Legal Holiday Rest Day ND','Legal Holiday ND','Special Holiday Rest Day ND','Special Holiday ND','Rest Day ND','Night Differential');
				// $rd_category = array('Rest Day','Legal Holiday Rest Day','Special Holiday Rest Day');
				foreach ($_cutoff_input_breakdown as $value) 
				{

					if (isset($value->compute->_breakdown_addition)) 
					{
						foreach ($value->compute->_breakdown_addition as $lbl => $values) 
						{
							if (in_array($lbl, $ot_category)) 
							{
								$overtime 			+= Payroll2::payroll_number_format($values['rate'],2);
							}
							if ($lbl == 'Legal Holiday' || $lbl == 'Legal Holiday Rest Day') 
							{
								$regular_holiday 	+= Payroll2::payroll_number_format($values['rate'],2);
							}
							if ($lbl == 'Special Holiday' || $lbl == 'Special Holiday Rest Day') 
							{
								$special_holiday 	+= Payroll2::payroll_number_format($values['rate'],2);
							}
							if ($lbl == 'Leave Pay') 
							{
								$leave_pay 			+= Payroll2::payroll_number_format($values['rate'],2);
							}
							if ($lbl == 'Rest Day') 
							{
								$restday 			+= Payroll2::payroll_number_format($values['rate'],2);
							}
							if (in_array($lbl, $nd_category)) 
							{
								$nightdiff 			+= Payroll2::payroll_number_format($values['rate'],2);
							}
						}
					}

					if(isset($value->compute->rendered_days))
					{
					
							$rendered_days  		+= Payroll2::payroll_number_format($value->compute->rendered_days,2);
						
					}

					if (isset($value->compute->_breakdown_deduction)) 
					{
						foreach ($value->compute->_breakdown_deduction as $lbl => $values) 
						{
							if ($value->time_output["leave_hours"] == '00:00:00') 
							{
								if ($lbl == 'late') 
								{
									$late 			+= Payroll2::payroll_number_format($values['rate'],2);
								}
								if ($lbl == 'absent' && $payroll_group_salary_computation->payroll_group_code != "Flat Rate") 
								{
									$absent 		+= Payroll2::payroll_number_format($values['rate'],2);
								}
								if ($lbl == 'undertime') 
								{
									$undertime 		+= Payroll2::payroll_number_format($values['rate'],2);
								}
								$deduction 			+= Payroll2::payroll_number_format($values['rate'],2);
							}
						}
					}


				}

				$data["_employee"][$key]->overtime 			= $overtime;
				$data["_employee"][$key]->regular_holiday 	= $regular_holiday;
				$data["_employee"][$key]->special_holiday 	= $special_holiday;
				$data["_employee"][$key]->leave_pay 		= $leave_pay;
				$data["_employee"][$key]->absent 			= $absent;
				$data["_employee"][$key]->late 				= $late;
				$data["_employee"][$key]->undertime 		= $undertime;
				$data["_employee"][$key]->nightdiff 		= $nightdiff;
				$data["_employee"][$key]->restday 			= $restday;
				$data["_employee"][$key]->rendered_days     = $rendered_days;

				$overtime_total 		 		+=	Payroll2::payroll_number_format($overtime,2);
				$special_holiday_total 			+=	Payroll2::payroll_number_format($regular_holiday,2);
				$regular_holiday_total 			+=	Payroll2::payroll_number_format($special_holiday,2);
				$leave_pay_total 	     		+=	Payroll2::payroll_number_format($leave_pay,2);
				$late_total 			 		+=	Payroll2::payroll_number_format($late,2);
				$undertime_total 		 		+=	Payroll2::payroll_number_format($undertime,2);
				$absent_total 		 			+=	Payroll2::payroll_number_format($absent,2);
				$nightdiff_total 		 		+=	Payroll2::payroll_number_format($nightdiff,2);
				$restday_total 		 			+=	Payroll2::payroll_number_format($restday,2);
				$rendered_days_total	        +=	Payroll2::payroll_number_format($rendered_days,2);
			}

			if (isset($employee["cutoff_breakdown"]->_breakdown)) 
			{
				# code...
				foreach($employee["cutoff_breakdown"]->_breakdown as $breakdown)
				{
					if($breakdown["deduct.net_pay"] == true)
					{
						if(isset($_other_deduction[$breakdown["label"]]))
						{
							$_other_deduction[$breakdown["label"]]  += Payroll2::payroll_number_format($breakdown["amount"],2);
							$total_deduction 						+= Payroll2::payroll_number_format($breakdown["amount"],2);
						}
						else
						{
							$_other_deduction[$breakdown["label"]] = $breakdown["amount"];
							$total_deduction += Payroll2::payroll_number_format($breakdown["amount"],2);
						}
					}
				}

				foreach($employee["cutoff_breakdown"]->_breakdown as $breakdown)
				{	
					if($breakdown["add.gross_pay"] == true)
					{
						if(isset($_addition[$breakdown["label"]]))
						{
							$_addition[$breakdown["label"]] += Payroll2::payroll_number_format($breakdown["amount"],2);
						}
						else
						{
							$_addition[$breakdown["label"]] = Payroll2::payroll_number_format($breakdown["amount"],2);
						}
					}
				}

				foreach($employee["cutoff_breakdown"]->_breakdown as $breakdown)
				{

					if($breakdown["type"] == "deductions")
					{
						if(isset($_deduction[$breakdown["label"]]))
						{
							$_deduction[$breakdown["label"]] += Payroll2::payroll_number_format($breakdown["amount"],2);
						}
						else
						{
							$_deduction[$breakdown["label"]] = Payroll2::payroll_number_format($breakdown["amount"],2);
						}
					}
				}
			}
			
			$employee->net_basic_pay = $employee->net_basic_pay - $leave_pay;

			// $total_cutoff_basic 	+= Payroll2::payroll_number_format(unserialize($employee->cutoff_compute)->cutoff_basic,2);
			$total_gross_basic		+= Payroll2::payroll_number_format($employee->gross_basic_pay,2);
			$total_basic 			+= Payroll2::payroll_number_format($employee->net_basic_pay,2);
			$total_gross 			+= Payroll2::payroll_number_format($employee->gross_pay,2);
			$total_net 				+= Payroll2::payroll_number_format($employee->net_pay,2);
			$total_tax 				+= Payroll2::payroll_number_format($employee->tax_ee,2);

			/*combination*/
			$data["_employee"][$key]->adj_allowance_plus_allowance 			   = $allowance + $adjustment_allowance;
			$data["_employee"][$key]->adj_de_menimis_plus_allowance_de_menimis = $allowance_de_minimis + $adjustment_de_minimis_benefit;
			$data["_employee"][$key]->adj_cashbond_plus_cashbond 			   = $cash_bond + $adjustment_cash_bond;
			$data["_employee"][$key]->adj_cash_advance_plus_cash_advance 	   = $cash_advance + $adjustment_cash_advance;



		}

		// $data["total_cutoff_basic"]					= $total_cutoff_basic;
		$data["total_gross_basic"]					= $total_gross_basic;
		$data["total_basic"] 						= $total_basic;
		$data["total_gross"] 						= $total_gross;
		$data["total_net"] 							= $total_net;
		$data["total_er"] 							= $g_total_er;
		$data["total_ee"] 							= $g_total_ee;
		$data["total_ec"] 							= $g_total_ec;
		$data["total_tax"] 							= $total_tax;
		$data["total_grand"] 						= $total_net + $g_total_er + $g_total_ee + $g_total_ec + $total_tax;
		$data["total_sss_ee"] 						= $total_sss_ee;
		$data["total_sss_er"] 						= $total_sss_er;
		$data["total_sss_ec"] 						= $total_sss_ec;
		$data["total_philhealth_ee"] 				= $total_philhealth_ee;
		$data["total_philhealth_er"] 				= $total_philhealth_er;
		$data["total_pagibig_ee"] 					= $total_pagibig_ee;
		$data["total_pagibig_er"] 					= $total_pagibig_er;
		$data["_other_deduction"] 					= $_other_deduction;
		$data["_addition"] 							= $_addition;
		$data["_deduction"] 						= $_deduction;
		$data["total_deduction"] 					= $total_deduction;
		$data["total_deduction_of_all_employee"] 	= $total_deduction_employee;

		$data["deduction_total"] 						= $deduction_total;
		$data["cola_total"] 							= $cola_total;
		$data["sss_ee_total"] 							= $sss_ee_total;
		$data["sss_er_total"] 							= $sss_er_total;
		$data["sss_ec_total"] 							= $sss_ec_total;
		$data["hdmf_ee_total"] 							= $hdmf_ee_total;
		$data["hdmf_er_total"] 							= $hdmf_er_total;
		$data["philhealth_ee_total"] 					= $philhealth_ee_total;
		$data["philhealth_er_total"] 					= $philhealth_er_total;
		$data["witholding_tax_total"] 					= $witholding_tax_total;
		$data["adjustment_deduction_total"] 			= $adjustment_deduction_total;
		$data["adjustment_allowance_total"] 			= $adjustment_allowance_total;
		$data["allowance_de_minimis_total"]				= $allowance_de_minimis_total;
		$data["allowance_total"] 						= $allowance_total;
		$data["cash_bond_total"] 						= $cash_bond_total;
		$data["cash_advance_total"]						= $cash_advance_total;
		$data["hdmf_loan_total"]						= $hdmf_loan_total;
		$data["sss_loan_total"]							= $sss_loan_total;
		$data["other_loans_total"]						= $other_loans_total;

		$data["overtime_total"] 		 			= $overtime_total;
		$data["special_holiday_total"] 				= $special_holiday_total;
		$data["regular_holiday_total"] 				= $regular_holiday_total;
		$data["leave_pay_total"] 	     			= $leave_pay_total;
		$data["late_total"] 			 			= $late_total;
		$data["undertime_total"] 		 			= $undertime_total;
		$data["absent_total"] 		 				= $absent_total;
		$data["nightdiff_total"] 		 			= $nightdiff_total;
		$data["restday_total"] 		 				= $restday_total;
		$data["rendered_days_total"]				= $rendered_days_total;

		$data["total_adjustment_allowance"]				= $total_adjustment_allowance;	
		$data["total_adjustment_bonus"]					= $total_adjustment_bonus;		
		$data["total_adjustment_commission"]			= $total_adjustment_commission;
		$data["total_adjustment_incentives"]			= $total_adjustment_incentives;
		$data["total_adjustment_cash_advance"]			= $total_adjustment_cash_advance;
		$data["total_adjustment_cash_bond"]				= $total_adjustment_cash_bond;	
		$data["total_adjustment_additions"]				= $total_adjustment_additions;	
		$data["total_adjustment_deductions"]			= $total_adjustment_deductions;
		$data["total_adjustment_others"]				= $total_adjustment_others;	
		$data["total_adjustment_13th_month_and_other"] 	= $total_adjustment_13th_month_and_other;
		$data["total_adjustment_de_minimis_benefit"] 	= $total_adjustment_de_minimis_benefit;

		$data["time_total_time_spent"]				= $time_total_time_spent;				
		$data["time_total_overtime"]				= $time_total_overtime;				
		$data["time_total_night_differential"]		= $time_total_night_differential;		
		$data["time_total_leave_hours"]				= $time_total_leave_hours;				
		$data["time_total_undertime"]				= $time_total_undertime;				
		$data["time_total_late"]					= $time_total_late;					
		$data["time_total_regular_holiday"]			= $time_total_regular_holiday;		
		$data["time_total_special_holiday"]			= $time_total_special_holiday;
		$data["time_total_absent"]					= $time_total_absent;

		$data["total_adj_allowance_plus_allowance"]					= $total_adjustment_allowance + $allowance_total;
		$data["total_adj_de_menimis_plus_allowance_de_menimis"]		= $total_adjustment_de_minimis_benefit + $allowance_de_minimis_total;
		$data["total_adj_cashbond_plus_cashbond"]					= $total_adjustment_cash_bond + $cash_bond_total;
		$data["total_adj_cash_advance_plus_cash_advance"]			= $total_adjustment_cash_advance + $cash_advance_total;
		
		return $data;
	}

	/*END PAYROLL REGISTER REPORT*/

	public function employee_summary_report()
	{
		$active_status[0]    = 1;
	    $active_status[1]    = 2;
	    $active_status[2]    = 3;
	    $active_status[3]    = 4;
	    $active_status[4]    = 5;
	    $active_status[5]    = 6;
	    $active_status[7]    = 7;

		$data['_active']	 = Tbl_payroll_employee_contract::employeefilter(0,0,0,date('Y-m-d'), Self::shop_id(), $active_status)->orderBy('tbl_payroll_employee_basic.payroll_employee_last_name')->get();

		//dd($data['salary'][0]->payroll_employee_salary_monthly);
		foreach ($data['_active'] as $key => $active)
		{
			$data['_active'][$key]->monthly_salary    = Tbl_payroll_employee_salary::selemployee($active->payroll_employee_id)->value('payroll_employee_salary_monthly');
			$data['_active'][$key]->daily_salary    = Tbl_payroll_employee_salary::selemployee($active->payroll_employee_id)->value('payroll_employee_salary_daily');
			//dd($data['_active'][$key]->payroll_employee_salary_monthly);
		}
		$data['_company']    = Payroll::company_heirarchy(Self::shop_id());

		return view('member.payrollreport.payroll_employee_summary_report', $data);
	}

}