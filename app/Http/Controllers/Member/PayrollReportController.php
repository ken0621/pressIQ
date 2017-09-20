<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Response;
use Excel;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
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
		if (Request::input("company_id") > 0) {
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
			// dd($data);
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
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();

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
		return view("member.payrollreport.loan_summary", $data);

	}

	public function table_loan_summary($deduction_type='')
	{
		$data["page"] = "Loan Summary";
		$deduction_type = str_replace("_"," ",$deduction_type);
		$data["_loan_data"] = PayrollDeductionController::get_deduction_by_type($this->shop_id(),$deduction_type);
		return view("member.payrollreport.loan_summary_table", $data);
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
		if (Request::input('employee_id')!='') {
			$employee_id = Request::input('employee_id');
			$payroll_deduction_id = Request::input('payroll_deduction_id');
		}
		$data["loan_deduction"]        = Tbl_payroll_deduction_v2::where('payroll_deduction_id',$payroll_deduction_id)->first();
		$data["_loan_data"]    			= PayrollDeductionController::get_deduction_payment(0,$employee_id,$payroll_deduction_id);
		$data["employee_info"] 			= Tbl_payroll_employee_basic::where("payroll_employee_id",$employee_id)->first();
		// dd($data);
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
		$data["company"] = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
		$data["period_info"] = $company_period = Tbl_payroll_period_company::sel($period_company_id)->first();
		$data["show_period_start"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_start));
		$data["show_period_end"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_end));
		$data = $this->get_total_payroll_register($data);
		// dd($data["_employee"]);
		return view('member.payrollreport.payroll_register_report_period',$data);
	}

	public function payroll_register_report_export_excel($period_company_id)
	{
		// dd($period_company_id);
        $data["company"] = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
		$data["period_info"] = $company_period = Tbl_payroll_period_company::sel($period_company_id)->first();
		$data["show_period_start"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_start));
		$data["show_period_end"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_end));
		/*dd($data["show_period_start"]);*/
		$data = $this->get_total_payroll_register($data);
     	Excel::create($data["company"]->payroll_company_name,function($excel) use ($data)
		{
			$excel->sheet('clients',function($sheet) use ($data)
			{
				$sheet->loadView('member.payrollreport.payroll_register_report_export_excel',$data);
			});
		})->download('xls');
		
    }

	public function get_total_payroll_register($data)
	{
		$total_basic 				= 0;
		$total_gross	 			= 0;
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

		$_other_deduction 			= null;
		$_addition 					= null;
		$_deduction 				= null;

		$deduction_total 					= 0;
		$cola_total 						= 0;
		$sss_ee_total 						= 0;
		$sss_er_total 						= 0;
		$sss_ec_total 						= 0;
		$hdmf_ee_total 						= 0;
		$hdmf_er_total 						= 0;
		$philhealth_ee_total 				= 0;
		$philhealth_er_total 				= 0;
		$witholding_tax_total 				= 0;
		$adjustment_deduction_total 		= 0;
		$adjustment_allowance_total 		= 0;
		$allowance_total 					= 0;
		$cash_bond_total 					= 0;
		$cash_advance_total					= 0;
		$hdmf_loan_total					= 0;
		$sss_loan_total						= 0;
		$other_loans_total					= 0;

		$overtime_total 		 			= 0;
		$special_holiday_total 				= 0;
		$regular_holiday_total 				= 0;
		$leave_pay_total 	     			= 0;
		$late_total 			 			= 0;
		$undertime_total 		 			= 0;
		$absent_total 		 				= 0;
		$nightdiff_total 		 			= 0;
		$restday_total 		 				= 0;

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
			
			
			$total_basic 	+= $employee->net_basic_pay;
			$total_gross 	+= $employee->gross_pay;
			$total_net 		+= $employee->net_pay;
			$total_tax 		+= $employee->tax_ee;


			$total_er = $employee->sss_er + $employee->philhealth_er +  $employee->pagibig_er;
			$total_ee = $employee->sss_ee + $employee->philhealth_ee +  $employee->pagibig_ee;
			$total_ec = $employee->sss_ec;

			$total_sss_ee 			+= $employee->sss_ee;
			$total_sss_er 			+= $employee->sss_er;
			$total_sss_ec 			+= $employee->sss_ec;
			$total_philhealth_ee 	+= $employee->philhealth_er;
			$total_philhealth_er 	+= $employee->philhealth_er;
			$total_pagibig_ee 		+= $employee->pagibig_ee;
			$total_pagibig_er 		+= $employee->pagibig_er;

			// $total_deduction_employee += $employee["total_deduction"];

			$data["_employee"][$key] = $employee;
			$data["_employee"][$key]->total_er = $total_er;
			$data["_employee"][$key]->total_ee = $total_ee;
			$data["_employee"][$key]->total_ec = $total_ec;



			$g_total_ec += $total_ec;
			$g_total_er += $total_er;
			$g_total_ee += $total_ee;

			$total_deduction += ($total_ee);

			if (isset($employee->cutoff_breakdown)) 
			{

				$time_performance = unserialize($employee->cutoff_breakdown)->_time_breakdown;

				$data["_employee"][$key]->time_spent 				= $time_performance["time_spent"]["time"];
				$data["_employee"][$key]->time_overtime 			= $time_performance["overtime"]["time"];
				$data["_employee"][$key]->time_night_differential 	= $time_performance["night_differential"]["time"];
				$data["_employee"][$key]->time_leave_hours 			= $time_performance["leave_hours"]["time"];
				$data["_employee"][$key]->time_undertime 			= $time_performance["undertime"]["time"];
				$data["_employee"][$key]->time_late 				= $time_performance["late"]["time"];
				$data["_employee"][$key]->time_regular_holiday 		= $time_performance["regular_holiday"]["float"];
				$data["_employee"][$key]->time_special_holiday 		= $time_performance["special_holiday"]["float"];
				$data["_employee"][$key]->time_absent 				= $time_performance["absent"]["float"];

				

				$time_total_time_spent				+= $time_performance["time_spent"]["time"];
				$time_total_overtime				+= $time_performance["overtime"]["time"];
				$time_total_night_differential		+= $time_performance["night_differential"]["time"];
				$time_total_leave_hours				+= $time_performance["leave_hours"]["time"];
				$time_total_undertime				+= $time_performance["undertime"]["time"];
				$time_total_late					+= $time_performance["late"]["time"];
				$time_total_regular_holiday			+= $time_performance["regular_holiday"]["float"];
				$time_total_special_holiday			+= $time_performance["special_holiday"]["float"];
				$time_total_absent					+= $time_performance["absent"]["float"];
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
				$cash_bond 				= 0;
				$cash_advance			= 0;
				$hdmf_loan				= 0;
				$sss_loan				= 0;
				$other_loans			= 0;

				foreach($_duction_break_down as $breakdown)
				{
					if($breakdown["deduct.net_pay"] == true)
					{
						$total_deduction_employee += $breakdown["amount"];
						$deduction += $breakdown["amount"];
					}
					if($breakdown["deduct.gross_pay"] == true)
					{
						$total_deduction_employee += $breakdown["amount"];
						$deduction += $breakdown["amount"];
					}
					if ($breakdown["label"] == "SSS EE" || $breakdown["label"] == "PHILHEALTH EE" || $breakdown["label"] == "PAGIBIG EE" ) 
					{
						$total_deduction_employee += $breakdown["amount"];
						$deduction += $breakdown["amount"];
					}
					if ($breakdown["label"] == "COLA") 
					{
						$cola += $breakdown["amount"];
					}
					if($breakdown["label"] == "SSS EE")
					{
						$sss_ee += $breakdown["amount"];
					}
					if($breakdown["label"] == "SSS ER")
					{
						$sss_er += $breakdown["amount"];
					}
					if($breakdown["label"] == "SSS EC")
					{
						$sss_ec += $breakdown["amount"];
					}
					if($breakdown["label"] == "PAGIBIG EE")
					{
						$hdmf_ee += $breakdown["amount"];
					}
					if($breakdown["label"] == "PAGIBIG ER")
					{
						$hdmf_er += $breakdown["amount"];
					}
					if($breakdown["label"] == "PHILHEALTH EE")
					{
						$philhealth_ee += $breakdown["amount"];
					}
					if($breakdown["label"] == "PHILHEALTH ER")
					{
						$philhealth_er += $breakdown["amount"];
					}
					if ($breakdown["label"] == "Witholding Tax") 
					{
						$witholding_tax += $breakdown["amount"];
					}
					
					if ($breakdown["type"] == "adjustment") 
					{
						if ($breakdown["deduct.net_pay"] == true) 
						{
							$adjustment_deduction += $breakdown["amount"];
						}
						else
						{
							$adjustment_allowance += $breakdown["amount"];
						}
					}
					if (isset($breakdown["record_type"])) 
					{
						if ($breakdown["record_type"] == "allowance") 
						{
							$allowance = $breakdown["amount"];
						}
						if ($breakdown["record_type"] == "Cash Bond") 
						{
							$cash_bond = $breakdown["amount"];
						}
						if ($breakdown["record_type"] == "Cash Advance") 
						{
							$cash_advance = $breakdown["amount"];
						}
						if ($breakdown["record_type"] == "SSS Loan") 
						{
							$sss_loan = $breakdown["amount"];
						}
						if ($breakdown["record_type"] == "HDMF Loan") 
						{
							$hdmf_loan = $breakdown["amount"];
						}
						if ($breakdown["record_type"] == "Others") 
						{
							$other_loans = $breakdown["amount"];	
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
				$data["_employee"][$key]->allowance 				= $allowance;
				$data["_employee"][$key]->cash_bond					= $cash_bond;
				$data["_employee"][$key]->cash_advance				= $cash_advance;
				$data["_employee"][$key]->sss_loan					= $sss_loan;
				$data["_employee"][$key]->hdmf_loan					= $hdmf_loan;
				$data["_employee"][$key]->other_loans				= $other_loans;

				$deduction_total				+= $deduction;
				$cola_total						+= $cola;
				$sss_ee_total					+= $sss_ee;
				$sss_er_total					+= $sss_er;
				$sss_ec_total					+= $sss_ec;
				$hdmf_ee_total					+= $hdmf_ee;
				$hdmf_er_total					+= $hdmf_er;
				$philhealth_ee_total			+= $philhealth_ee;
				$philhealth_er_total			+= $philhealth_er;
				$witholding_tax_total			+= $witholding_tax;
				$adjustment_deduction_total		+= $adjustment_deduction;
				$adjustment_allowance_total		+= $adjustment_allowance;
				$allowance_total				+= $allowance;
				$cash_bond_total				+= $cash_bond;
				$cash_advance_total				+= $cash_advance;
				$hdmf_loan_total				+= $sss_loan;
				$sss_loan_total					+= $hdmf_loan;
				$other_loans_total				+= $other_loans;

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
								$overtime += $values['rate'];
							}
							if ($lbl == 'Legal Holiday' || $lbl == 'Legal Holiday Rest Day') 
							{
								$regular_holiday += $values['rate'];
							}
							if ($lbl == 'Special Holiday' || $lbl == 'Special Holiday Rest Day') 
							{
								$special_holiday += $values['rate'];
							}
							if ($lbl == 'Leave Pay') 
							{
								$leave_pay += $values['rate'];
							}
							if ($lbl == 'Rest Day') 
							{
								$restday += $values['rate'];
							}
							if (in_array($lbl, $nd_category)) 
							{
								$nightdiff += $values['rate'];
							}
						}
					}

					if (isset($value->compute->_breakdown_deduction)) 
					{
						foreach ($value->compute->_breakdown_deduction as $lbl => $values) 
						{
							if ($value->time_output["leave_hours"] == '00:00:00') 
							{
								if ($lbl == 'late') 
								{
									$late += $values['rate'];
								}
								if ($lbl == 'absent') 
								{
									$absent += $values['rate'];
								}
								if ($lbl == 'undertime') 
								{
									$undertime += $values['rate'];
								}
								$deduction += $values['rate'];
							}
						}
					}
				}


				$data["_employee"][$key]->overtime = $overtime;
				$data["_employee"][$key]->regular_holiday = $regular_holiday;
				$data["_employee"][$key]->special_holiday = $special_holiday;
				$data["_employee"][$key]->leave_pay = $leave_pay;
				$data["_employee"][$key]->absent = $absent;
				$data["_employee"][$key]->late = $late;
				$data["_employee"][$key]->undertime = $undertime;
				$data["_employee"][$key]->nightdiff = $nightdiff;
				$data["_employee"][$key]->restday = $restday;

				$overtime_total 		 		+=	$overtime;
				$special_holiday_total 			+=	$regular_holiday;
				$regular_holiday_total 			+=	$special_holiday;
				$leave_pay_total 	     		+=	$leave_pay;
				$late_total 			 		+=	$late;
				$undertime_total 		 		+=	$undertime;
				$absent_total 		 			+=	$absent;
				$nightdiff_total 		 		+=	$nightdiff;
				$restday_total 		 			+=	$restday;
			}



			if (isset($employee["cutoff_breakdown"]->_breakdown )) 
			{
				# code...
				foreach($employee["cutoff_breakdown"]->_breakdown as $breakdown)
				{
					if($breakdown["deduct.net_pay"] == true)
					{
						if(isset($_other_deduction[$breakdown["label"]]))
						{
							$_other_deduction[$breakdown["label"]] += $breakdown["amount"];
							$total_deduction += $breakdown["amount"];
						}
						else
						{
							$_other_deduction[$breakdown["label"]] = $breakdown["amount"];
							$total_deduction += $breakdown["amount"];
						}
					}
				}

				foreach($employee["cutoff_breakdown"]->_breakdown as $breakdown)
				{	
					if($breakdown["add.gross_pay"] == true)
					{
						if(isset($_addition[$breakdown["label"]]))
						{
							$_addition[$breakdown["label"]] += $breakdown["amount"];
						}
						else
						{
							$_addition[$breakdown["label"]] = $breakdown["amount"];
						}
					}
				}

				foreach($employee["cutoff_breakdown"]->_breakdown as $breakdown)
				{

					if($breakdown["type"] == "deductions")
					{
						if(isset($_deduction[$breakdown["label"]]))
						{
							$_deduction[$breakdown["label"]] += $breakdown["amount"];
						}
						else
						{
							$_deduction[$breakdown["label"]] = $breakdown["amount"];
						}
					}
				}
			}
		}

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


		$data["deduction_total"] 					= $deduction_total;
		$data["cola_total"] 						= $cola_total;
		$data["sss_ee_total"] 						= $sss_ee_total;
		$data["sss_er_total"] 						= $sss_er_total;
		$data["sss_ec_total"] 						= $sss_ec_total;
		$data["hdmf_ee_total"] 						= $hdmf_ee_total;
		$data["hdmf_er_total"] 						= $hdmf_er_total;
		$data["philhealth_ee_total"] 				= $philhealth_ee_total;
		$data["philhealth_er_total"] 				= $philhealth_er_total;
		$data["witholding_tax_total"] 				= $witholding_tax_total;
		$data["adjustment_deduction_total"] 		= $adjustment_deduction_total;
		$data["adjustment_allowance_total"] 		= $adjustment_allowance_total;
		$data["allowance_total"] 					= $allowance_total;
		$data["cash_bond_total"] 					= $cash_bond_total;
		$data["cash_advance_total"]					= $cash_advance_total;
		$data["hdmf_loan_total"]					= $hdmf_loan_total;
		$data["sss_loan_total"]						= $sss_loan_total;
		$data["other_loans_total"]					= $other_loans_total;

		$data["overtime_total"] 		 			= $overtime_total;
		$data["special_holiday_total"] 				= $special_holiday_total;
		$data["regular_holiday_total"] 				= $regular_holiday_total;
		$data["leave_pay_total"] 	     			= $leave_pay_total;
		$data["late_total"] 			 			= $late_total;
		$data["undertime_total"] 		 			= $undertime_total;
		$data["absent_total"] 		 				= $absent_total;
		$data["nightdiff_total"] 		 			= $nightdiff_total;
		$data["restday_total"] 		 				= $restday_total;


		$data["time_total_time_spent"]				=	$time_total_time_spent;				
		$data["time_total_overtime"]				=	$time_total_overtime;				
		$data["time_total_night_differential"]		=	$time_total_night_differential;		
		$data["time_total_leave_hours"]				=	$time_total_leave_hours;				
		$data["time_total_undertime"]				=	$time_total_undertime;				
		$data["time_total_late"]					=	$time_total_late;					
		$data["time_total_regular_holiday"]			=	$time_total_regular_holiday;		
		$data["time_total_special_holiday"]			=	$time_total_special_holiday;
		$data["time_total_absent"]					=	$time_total_absent;		
		
		// dd($data["total_deduction_of_all_employee"]);
		return $data;
	}
			

	/*END PAYROLL REGISTER REPORT*/



}