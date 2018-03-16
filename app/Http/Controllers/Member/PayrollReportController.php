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
use App\Models\Tbl_payroll_manpower_report;
use App\Models\Tbl_payroll_department;
use App\Models\Tbl_payroll_branch_location;

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
		$date = date("Y-m-d");
		$year = explode("-", $date);

		$data["_month_period"] = Payroll2::get_number_of_period_per_month($this->shop_id(), $year[0]);
		$data["_year_period"] = Tbl_payroll_period::select('year_contribution')->where("shop_id", Self::shop_id())->distinct()->get();
		$data["year_today"] = $year[0];

		return view("member.payrollreport.government_forms", $data);
	}
	public function government_forms_year_filter()
	{
		$year = Request::input('year');
		$data["page"] = "Monthly Government Forms";
		$data["_month_period"] = Payroll2::get_number_of_period_per_month($this->shop_id(), $year);
		$data["_year_period"] = Tbl_payroll_period::select('year_contribution')->where("shop_id", Self::shop_id())->distinct()->get();
		$data["year_today"] = $year;

		return view("member.payrollreport.government_forms_year_filter", $data);
	}
	public function government_forms_hdmf($month,$year)
	{ 
		$data['_branch'] = Tbl_payroll_branch_location::getdata(Self::shop_id())->orderBy('branch_location_name')->get();
		$data["page"] = "Monthly Government Forms";
		$year = $year;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;
		$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->where('payroll_company_archived',0)->get();
		return view("member.payrollreport.government_forms_hdmf", $data);
	}
	public function government_forms_sss($month,$year)
	{ 
		$data['_branch'] = Tbl_payroll_branch_location::getdata(Self::shop_id())->orderBy('branch_location_name')->get();
		$data["page"] = "Monthly Government Forms";
		$year = $year;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;
		$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->where('payroll_company_archived',0)->get();
		return view("member.payrollreport.government_forms_sss", $data);
	}
	public function government_forms_philhealth($month,$year)
	{ 
		$data['_branch'] = Tbl_payroll_branch_location::getdata(Self::shop_id())->orderBy('branch_location_name')->get();
		$data["page"] = "Monthly Government Forms";
		$year = $year;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;
		$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->where('payroll_company_archived',0)->get();

		return view("member.payrollreport.government_forms_philhealth", $data);
	}

	public function government_forms_hdmf_iframe($month,$company_id,$year,$branch_id)
	{ 
		if($company_id > 0 || $branch_id > 0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = $year;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id,$branch_id);
			$data['company_id1'] = $company_id;
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			if($company_id == 0)
			{
				$companyname = 'ALL Company';
			}
			else
			{
				$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
				$companyname = $data['company']->payroll_company_name;
			}
			$format["title"] = $companyname;
			$format["format"] = "A4";
			$format["default_font"] = "sans-serif";
			$pdf = PDF2::loadView('member.payrollreport.government_forms_hdmf_pdf', $data, [], $format);
			return $pdf->stream('document.pdf');

		}
		else
		{

			$data["page"] = "Monthly Government Forms";
			$year = $year;
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
	}

	public function government_forms_hdmf_filter()
	{

			$branch_id =	Request::input("branch_id");
			$company_id =	Request::input("company_id");
        	$month      =	Request::input('month');
        	$year 		= 	Request::input('year');
			$data["page"] = "Monthly Government Forms";
			$year = $year;
			$shop_id = $this->shop_id();

		if (Request::input("company_id") > 0 || Request::input("branch_id") > 0) 
		{
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id,$branch_id);
			$data['company_id1'] = $company_id;
			$data['branch_id'] = $branch_id;
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
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id,$month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data['branch_id'] = $branch_id;
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
		$year 		= 	Request::input('year');
		$branch_id =	Request::input("branch_id");
		$data["page"] = "Monthly Government Forms";
		$year = $year;
		$shop_id = $this->shop_id();
		if (Request::input("company_id") > 0 || Request::input("branch_id") > 0)  
		{
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id,$branch_id);
			$data["contri_info"] = $contri_info; 
			$data['company_id1'] = $company_id;
			$data["month"] = $month;
			$data['branch_id'] = $branch_id;
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
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data['company_id1'] = $company_id;
			$data['branch_id'] = $branch_id;
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
		$year 		= 	Request::input('year');
		$branch_id =	Request::input("branch_id");
		$data["page"] = "Monthly Government Forms";
		$year = $year;
		$shop_id = $this->shop_id();
		if (Request::input("company_id") > 0 || Request::input("branch_id") > 0)  
		{

			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id,$branch_id);
			$data['company_id1'] = $company_id;
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data['branch_id'] = $branch_id;
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
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data['company_id1'] = $company_id;
			$data["month"] = $month;
			$data['branch_id'] = $branch_id;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

			return view("member.payrollreport.government_forms_philhealth_filter", $data);
		}
	}
    public function government_forms_hdmf_export_excel($month,$company_id,$year,$branch_id)
	{
		if($company_id > 0 || $branch_id > 0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = $year;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id,$branch_id);
			
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;

			if($company_id == 0)
			{
				$companyname = 'ALL Company';
			}
			else
			{
				$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
				$companyname = $data['company']->payroll_company_name;
			}
			// AuditTrail::record_logs("DOWNLOAD","HDMF REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms HDMF".$companyname,function($excel) use ($data)
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
			$year = $year;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();

			// AuditTrail::record_logs("DOWNLOAD","HDMF REPORT",$this->shop_id(),"","");
            // dd(count($contri_info["_employee_contribution"]));
			Excel::create("Government Forms HDMF",function($excel) use ($data)
			{
				$excel->sheet('clients',function($sheet) use ($data)
				{
					$sheet->loadView('member.payrollreport.government_forms_hdmf_export_excel',$data);
				});
			})->download('xls');   
		}
 			
	}
	public function government_forms_sss_export_excel($month,$company_id,$year,$branch_id)
	{
		if($company_id > 0 || $branch_id > 0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = $year;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id,$branch_id);
			
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			if($company_id == 0)
			{
				$companyname = 'ALL Company';
			}
			else
			{
				$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
				$companyname = $data['company']->payroll_company_name;
			}
			// AuditTrail::record_logs("DOWNLOAD","SSS REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms SSS-".$companyname,function($excel) use ($data)
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
			$year = $year;
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
 			
	}
	public function government_forms_philhealth_export_excel($month,$company_id,$year,$branch_id)
	{
		if($company_id > 0 || $branch_id > 0)
		{
			$data["page"] = "Monthly Government Forms";
			$year = $year;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month_filter($shop_id, $month, $year,$company_id,$branch_id);
			$data["contri_info"] = $contri_info; 
			$data["month"] 		 = $month;
			$data["month_name"]  = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] 	 	 = $year;
			if($company_id == 0)
			{
				$companyname = 'ALL Company';
			}
			else
			{
				$data['company'] = Tbl_payroll_company::where('payroll_company_id',$company_id)->first();
				$companyname = $data['company']->payroll_company_name;
			}
			// AuditTrail::record_logs("DOWNLOAD","PHILHEALTH REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms PHILHEALTH".$companyname,function($excel) use ($data)
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
			$year = $year;
			$shop_id = $this->shop_id();
			$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
			$data["contri_info"] = $contri_info; 
			$data["month"] = $month;
			$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
			$data["year"] = $year;
			$data['_company'] = Tbl_payroll_company::where('shop_id',$shop_id)->get();
			// AuditTrail::record_logs("DOWNLOAD","PHILHEALTH REPORT",$this->shop_id(),"","");
			Excel::create("Government Forms PHILHEALTH",function($excel) use ($data)
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
		$data['totals']	= $this->get_totals_loan_summary($data);
		$data['_branch'] = Tbl_payroll_branch_location::getdata(Self::shop_id())->orderBy('branch_location_name')->get();
		// dd($data['$totals']);
		return view("member.payrollreport.loan_summary", $data);
	}

	public function table_loan_summary($deduction_type='',$company=0,$branch=0)
	{
		$data["page"] = "Loan Summary";
		$deduction_type = str_replace("_"," ",$deduction_type);

		$data["_loan_data"] = PayrollDeductionController::get_deduction_by_type($this->shop_id(),$deduction_type,$company,$branch);

		if($company == 0)
		{
			$data['company']	= Tbl_payroll_company::selcompany($this->shop_id())->get();
		}
		else
		{
			$data['company']	= Tbl_payroll_company::selcompanybyid($company)->get();
		}
		
		$data['totals']	= $this->get_totals_loan_summary($data);

		return view("member.payrollreport.loan_summary_table", $data);
	}

	public function table_company_loan_summary()
	{
		$data['company_id'] = Request::input('company_id');
		$data['branch_id']  = Request::input('branch');

		$data['_loan_data'] = Tbl_payroll_deduction_payment_v2::getallinfo($this->shop_id(),$data['company_id'],0,$data['branch_id'])->get();

		if($data['company_id'] == 0)
		{
			$data['company']	= Tbl_payroll_company::selcompany($this->shop_id())->get();
		}
		else
		{
			$data['company']	= Tbl_payroll_company::selcompanybyid($data['company_id'])->get();
			
		}

		
		$data['totals']	= $this->get_totals_loan_summary($data);

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

	public function loan_summary_report_excel($company = 0, $deduction_type='', $branch = 0)
	{

		$data["_loan_data"] = PayrollDeductionController::get_deduction($this->shop_id());
		$data["_company"] = Payroll::company_heirarchy(Self::shop_id());
		$data['company']	= Tbl_payroll_company::selcompany($this->shop_id())->get();

		
		if($company != 0 && $deduction_type == 'noval' || $branch != 0)
		{
			$data['_loan_data'] = Tbl_payroll_deduction_payment_v2::getallinfo($this->shop_id(),$company,0,$branch)->get();

			if($company == 0)
			{
				$data['company']	= Tbl_payroll_company::selcompany($this->shop_id())->get();
			}
			else
			{

				$data['company']	= Tbl_payroll_company::selcompanybyid($company)->get();
			
				
			}

		}	
		else if($deduction_type != 'noval')
		{
			$deduction_type = str_replace("_"," ",$deduction_type);
			$data["_loan_data"] = PayrollDeductionController::get_deduction_by_type($this->shop_id(),$deduction_type,$company,$branch);
			if($company == 0)
			{
				$data['company']	= Tbl_payroll_company::selcompany($this->shop_id())->get();
			}
			else
			{
				$data['company']	= Tbl_payroll_company::selcompanybyid($company)->get();
				
			}
		}

		$data['totals']	= $this->get_totals_loan_summary($data);

          Excel::create("Loan Summary Reports",function($excel) use ($data)
          {
               $excel->sheet('clients',function($sheet) use ($data)
               {
                    $sheet->loadView('member.payrollreport.loan_summary_export_excel',$data);
               });
          })->download('xls');
	}

	public function get_totals_loan_summary($data)
	{
		$temp['loan_total'] 		        	 	  = 0;
		$temp['total_total_payment']        		  = 0;
		$temp['total_remaining_balance']    		  = 0;
		$temp['payroll_employee_company_id'] 		  = -1;

		$lastvalue['loan_total'] 		        	 	  = 0;
		$lastvalue['total_total_payment']        		  = 0;
		$lastvalue['total_remaining_balance']    		  = 0;

		$totals = array();
		foreach($data['_loan_data'] as $key => $loan_data)
		{	
			if($temp['payroll_employee_company_id'] == -1)
			{
				$temp['payroll_employee_company_id']      = $loan_data['payroll_employee_company_id'];
				$lastvalue['loan_total']          		 += $loan_data['payroll_deduction_amount'];
				$lastvalue['total_total_payment'] 		 += $loan_data['total_payment'];
				$lastvalue['total_remaining_balance']	 += $loan_data['payroll_deduction_amount'] - $loan_data['total_payment'];
			}

			if($temp['payroll_employee_company_id'] == $loan_data['payroll_employee_company_id'])
			{
				$temp['loan_total']          		 += $loan_data['payroll_deduction_amount'];
				$temp['total_total_payment'] 		 += $loan_data['total_payment'];
				$temp['total_remaining_balance']	 += $loan_data['payroll_deduction_amount'] - $loan_data['total_payment'];

				if($temp['loan_total'] > $lastvalue['loan_total'])
				{
					array_pop($totals);
				}

			}
			else
			{
						$temp['loan_total'] 		        	 	  = 0;
						$temp['total_total_payment']        		  = 0;
						$temp['total_remaining_balance']    		  = 0;

						$lastvalue['loan_total'] 		        	 	  = 0;
						$lastvalue['total_total_payment']        		  = 0;
						$lastvalue['total_remaining_balance']    		  = 0;

						$temp['loan_total']          		 += $loan_data['payroll_deduction_amount'];
						$temp['total_total_payment'] 		 += $loan_data['total_payment'];
						$temp['total_remaining_balance']	 += $loan_data['payroll_deduction_amount'] - $loan_data['total_payment'];

						$lastvalue['loan_total']          		 += $loan_data['payroll_deduction_amount'];
						$lastvalue['total_total_payment'] 		 += $loan_data['total_payment'];
						$lastvalue['total_remaining_balance']	 += $loan_data['payroll_deduction_amount'] - $loan_data['total_payment'];

			}
			$temp['payroll_employee_company_id']  = $loan_data['payroll_employee_company_id'];
			array_push($totals,$temp);
		}
		
		$data['totals']	= $totals;

		return $data;
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
		$data['_branch'] = Tbl_payroll_branch_location::getdata(Self::shop_id())->orderBy('branch_location_name')->get();
		$data["period_company_id"]  = $period_company_id; 
		$data["company"] 			= Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();

		$data["period_info"] 		= $company_period = Tbl_payroll_period_company::sel($period_company_id)->first();
		$data["show_period_start"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_start));
		$data["show_period_end"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_end));
		
		$data['filtering_company']	= $period_company_id;
		$data['_company']           = Payroll::company_heirarchy(Self::shop_id());
		$data['_department']		= Tbl_payroll_department::where('shop_id',Self::shop_id())->where('payroll_department_archived',0)->get();

		return view('member.payrollreport.payroll_register_report_period',$data);
	}

	public function payroll_register_report_table()
	{
		$period_company_id      = request::input('period_company_id');
		$payroll_department_id  = request::input('payroll_department_id');
		$branch_id 				= request::input('branch_id');

		$data["_employee"] 	= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();

		if ($payroll_department_id != 0 || $branch_id != 0) 
		{
			$data["_employee"] 	= Tbl_payroll_time_keeping_approved::basic()->FilterbyDept($branch_id,$payroll_department_id,$period_company_id)->get();
		}

		$data = Payroll2::get_total_payroll_register($data);
		$data['columns'] = Tbl_payroll_register_column::select('*')->where('shop_id',Self::shop_id())->get();
		return view('member.payrollreport.payroll_register_report_table', $data);
	}

	public function modal_filter_register_columns($period_company_id)
	{
			$data['period_company_id'] = $period_company_id;
			$data['columns'] = Tbl_payroll_register_column::select('*')->where('shop_id',Self::shop_id())->get();
			if(count($data['columns']) == 0)
			{
				$insert['name']							= 1;
				$insert['position']						= 1;
				$insert['taxstatus']					= 1;
				$insert['dailyrate']					= 1;
				$insert['monthlybasic']					= 1;
				$insert['semimonthlybasic']				= 1;			
				$insert['gross_basic_pay']				= 1;
				$insert['absent']						= 1;
				$insert['late']							= 1;
				$insert['undertime']					= 1;
				$insert['basic_pay']					= 1;
				$insert['cola']							= 1;
				$insert['overtime_pay']					= 1;
				$insert['night_differential_pay']		= 1;
				$insert['regular_holiday_pay']			= 1;
				$insert['special_holiday_pay']			= 1;
				$insert['restday_pay']					= 1;
				$insert['leave_pay']					= 1;
				$insert['allowance']					= 1;
				$insert['bonus']						= 1;
				$insert['commision']					= 1;
				$insert['incentives']					= 1;
				$insert['additions']					= 1;
				$insert['de_minimis_benefit']			= 1;
				$insert['others']						= 1;
				$insert['gross_pay']					= 1;
				$insert['deductions']					= 1;
				$insert['cash_bond']					= 1;
				$insert['cash_advance']					= 1;
				$insert['other_loan']					= 1;
				$insert['sss_loan']						= 1;
				$insert['sss_ee']						= 1;
				$insert['hdmf_loan']					= 1;
				$insert['hdmf_ee']						= 1;
				$insert['phic_ee']						= 1;
				$insert['with_holding_tax']				= 1;
				$insert['total_deduction']				= 1;
				$insert['take_home_pay']				= 1;
				$insert['sss_er']						= 1;
				$insert['sss_ec']						= 1;
				$insert['hdmf_er']						= 1;
				$insert['phic_er']						= 1;
				$insert['month_13_and_other']			= 1;
				$insert['rendered_days']				= 1;
				$insert['shop_id']						= Self::shop_id();
				Tbl_payroll_register_column::insert($insert);
			}

			$data['columnn'] = Tbl_payroll_register_column::select('*')->where('shop_id',Self::shop_id())->get();
			return view('member.payrollreport.modal_filter_register_columns',$data);
	}

	public function save_payroll_register_selected_columns()
	{		
			/*END SET THE VALUES TO 0*/
			foreach(request::input('columnname') as $column)
			{
				$update[$column] = 0;
			}

			/*CHECK IF ITS CHECK IF IT'S CHECKED ASSIGN THE VALUE TO $UPDATE*/
			foreach(request::input('columnname') as $columnname)
			{
				if(!empty(request::input($columnname)))
				{
					$update[$columnname] = request::input($columnname);
				}
			}

	        Tbl_payroll_register_column::where('shop_id',Self::shop_id())->update($update);
  		
	  		$response['call_function'] = 'reload';
			$response['status'] = 'success';

			return $response;
	}

	public function payroll_register_report_export_excel($period_company_id,$payroll_department_id,$branch_id)
	{
        $data["company"] 			= Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		$data["_employee"] 			= Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
		$data["period_info"] 		= $company_period = Tbl_payroll_period_company::sel($period_company_id)->first();
		$data["show_period_start"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_start));
		$data["show_period_end"]	= date("F d, Y", strtotime($data["period_info"]->payroll_period_end));

		if ($branch_id != 0 || $payroll_department_id != 0) 
		{
			$data["_employee"] 	= Tbl_payroll_time_keeping_approved::basic()->FilterbyDept($branch_id,$payroll_department_id,$period_company_id)->get();
		}

		$data = Payroll2::get_total_payroll_register($data);
		$data['columns'] = Tbl_payroll_register_column::select('*')->where('shop_id',Self::shop_id())->get();

     	Excel::create($data["company"]->payroll_company_name, function($excel) use ($data)
		{
			$excel->sheet('clients',function($sheet) use ($data)
			{
				$sheet->loadView('member.payrollreport.payroll_register_report_export_excel',$data);
			});
		})->download('xls');
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

	/* start man power report */
  	public function manpower_report()
    {
    	  $data["_company"] = Payroll::company_heirarchy(Self::shop_id());
    	  $data['manpower_info'] = Tbl_payroll_manpower_report::selmanpower(Self::shop_id(),0)->get();
          return view("member.payrollreport.manpower_report",$data);
    }

    public function manpower_report_export_excel($company_id)
    {


		if($company_id == 0)
		{
			$data['company'] = 'All Company';
			$data['manpower_info'] = Tbl_payroll_manpower_report::selmanpower(Self::shop_id(),$company_id)->get();
		}
		else
		{
			$data['company'] = Tbl_payroll_company::where('shop_id',Self::shop_id())->where('payroll_company_id',$company_id)->value('payroll_company_name');
			 $data['manpower_info'] = Tbl_payroll_manpower_report::selmanpower(Self::shop_id(),$company_id)->get();
		}



    	Excel::create("Manpower Report",function($excel) use ($data)
		{
			$excel->sheet('clients',function($sheet) use ($data)
			{
				$sheet->loadView('member.payrollreport.manpower_report_excel',$data);
			});
		})->download('xls'); 

    }

    public function manpower_report_filter()
    {
    	$company_id = Request::input("company_id");
		if($company_id == 0)
		{
			$data['company'] = Tbl_payroll_company::where('shop_id',Self::shop_id())->where('payroll_parent_company_id',0)->value('payroll_company_name');
			 $data['manpower_info'] = Tbl_payroll_manpower_report::selmanpower(Self::shop_id(),$company_id)->get();
		}
		else
		{    	 
			$data["_company"] = Payroll::company_heirarchy(Self::shop_id());
    	    $data['manpower_info'] = Tbl_payroll_manpower_report::selmanpower(Self::shop_id(),$company_id)->get();
		}

          return view("member.payrollreport.manpower_report_filter",$data);
    }

	/* start bir report */

	public function bir_form()
	{ 
		$data["page"] = "BIR Forms";
		$date = date("Y-m-d");
		$year = explode("-", $date);
		$data["_company"] = Payroll::company_heirarchy(Self::shop_id());
	    $_month = array();

		for($ctr = 1; $ctr <= 12; $ctr++)
		{
			$_month[$ctr]["month_name"] = DateTime::createFromFormat('!m', $ctr)->format('F');
			$_month[$ctr]["month_value"] = $ctr;
		}
		$data['_month'] = $_month;

		$data["_year_period"] = Tbl_payroll_period::select('year_contribution')->where("shop_id", Self::shop_id())->distinct()->get();
		$data["year_today"] = $year[0];
		return view("member.payrollreport.bir_form",$data);
	}

	public function bir_forms_filter()
	{
			$company_id =	Request::input("company_id");
        	$year 		= 	Request::input('year');
        	$_month = array();
        	for($ctr = 1; $ctr <= 12; $ctr++)
			{
				$_month[$ctr]["month_name"] = DateTime::createFromFormat('!m', $ctr)->format('F');
				$_month[$ctr]["month_value"] = $ctr;
			}
			$data['_month'] = $_month;
        	$data["year_today"] = $year;
        	$data["company"]	 = $company_id;
        return view("member.payrollreport.bir_form_filter",$data);
	}

	public function bir_export_excel($year,$month,$company)
	{
		$data['company_name'] = Tbl_payroll_company::where('payroll_company_id',$company)->value('payroll_company_name');
		$data['year']         = $year;
		$data['month']		  = $month;
	    $data['company']	  = $company;
	    $data["month_name"]   = DateTime::createFromFormat('!m', $month)->format('F');
	    $data['date_today']   = date("m/d/Y H:i");

	    $shop_id = $this->shop_id();
	    $data['bir_report'] = $this->compute_bir($year,$month,$company,$shop_id);

		Excel::create("BIR Report -".$data["month_name"].' '.$year,function($excel) use ($data)
		{
			$excel->sheet('clients',function($sheet) use ($data)
			{
				$sheet->loadView('member.payrollreport.bir_form_export_excel',$data);
			});
		})->download('xls'); 

	}

	public function view_bir_forms($year,$month,$company)
	{	

		$date = date('Y-m-d');
	    $data['year']         = $year;
	    $data['company_name'] = Tbl_payroll_company::where('payroll_company_id',$company)->value('payroll_company_name');
	    $data['month']		  = $month;
	    $data['company']	  = $company;
		$data["month_name"]   = DateTime::createFromFormat('!m', $month)->format('F');
		$shop_id = $this->shop_id();
		$data['bir_report'] = $this->compute_bir($year,$month,$company,$shop_id);

		return view("member.payrollreport.view_bir_forms",$data);
	}

	public function coe_report()
	{
		$parameter['date']					= date('Y-m-d');
		$parameter['company_id']			= 0;
		$parameter['employement_status']	= 0;
		$parameter['shop_id'] 				= $this->shop_id();
		$data["_employee"] = Tbl_payroll_employee_basic::selemployee($parameter)->orderby("tbl_payroll_employee_basic.payroll_employee_number")->get();
		// dd($data["_employee"]);
		return view("member.payrollreport.coe_report",$data);
	}

	public function coe_export_pdf()
	{
		if (isJson(Request::input("employee"))) 
        {
            $employee = json_decode(Request::input("employee"));
        }
        else
        {
            $employee = [];
        }

        $data["_employee"] = Tbl_payroll_employee_basic::GetEmployee($employee,Self::shop_id())->get();
        $data['date_today'] = date("F j, Y");
		$format["format"] = "A4";
		$format["default_font"] = "sans-serif";
		$pdf = PDF2::loadView('member.payrollreport.coe_pdf', $data, [], $format);
		return $pdf->stream('document.pdf');

	}

	public static function compute_bir($year,$month,$company,$shop_id)
	{
		$bir_report           = array();
		$date = date('Y-m-d');
		$data["month_name"]   = DateTime::createFromFormat('!m', $month)->format('F');

 		$data['first_period'] = Tbl_payroll_period::sel($shop_id)->GetFirstPeriod($company,$year,$data["month_name"])->get();

	    $data['last_period'] = Tbl_payroll_period::sel($shop_id)->GetLastPeriod($company,$year,$data["month_name"])->get();
	                                            
	                                             
	     if(count($data['last_period']) != 0 && count($data['first_period']) != 0 && $company != 0)
	     {
			  //get minimun earnes
			    $data['employee_minimum'] = Tbl_payroll_employee_basic::join('tbl_payroll_employee_salary','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_employee_salary.payroll_employee_id')
			    											->where('shop_id',$shop_id)
			    											->where('tbl_payroll_employee_salary.payroll_employee_salary_minimum_wage',1)
			    											->where('tbl_payroll_employee_salary.payroll_employee_salary_effective_date','<=', $date)
			    											->orderBy('payroll_employee_salary_id', 'desc')
			    											->select('tbl_payroll_employee_basic.payroll_employee_id')
			    											->distinct()
			    											->get();

			     if(count($data['employee_minimum']) == 0)
			     {
			     	$temp['first_period_total_minimum']   = 0;
			     	$temp['last_period_total_minimum']    = 0;
			     	$temp['total_for_1601c_minimum']	  = 0;
			     	$temp['first_minimum_16_b']	          = 0;
			     	$temp['last_minimum_16_b']            = 0;
			     	$temp['total_minimum_1601c']          = 0;

			     }
			     else
			     {
			 	//get data first_period minimum earners
				    $data["_employee"]                    	 = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $data['first_period'][0]->payroll_period_company_id)->whereIn('employee_id',$data['employee_minimum'])->basic()->get();
				//total minimun first period
				    $data['total_minimum_first']             = Payroll2::get_total_payroll_register($data);

				//get data last_period minimum earners
				    $data["_employee"]             	         = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $data['last_period'][0]->payroll_period_company_id)->whereIn('employee_id',$data['employee_minimum'])->basic()->get();
			  	//total minimun last period
				    $data['total_minimum_last']              = Payroll2::get_total_payroll_register($data);


				    $temp['first_period_total_minimum']      = Payroll2::payroll_number_format($data['total_minimum_first']['total_gross'],2);
				    $temp['last_period_total_minimum']       = Payroll2::payroll_number_format($data['total_minimum_last']['total_gross'],2);
				    $temp['total_for_1601c_minimum']		 =  Payroll2::payroll_number_format(($data['total_minimum_first']['total_gross'] + $data['total_minimum_last']['total_gross']),2);

				    //add first and last minimum
					$temp['first_minimum_16_b']	             = $data['total_minimum_first']['nightdiff_total'
					] + $data['total_minimum_first']['leave_pay_total'] + $data['total_minimum_first']['special_holiday_total'] + $data['total_minimum_first']['regular_holiday_total'] + $data['total_minimum_first']['overtime_total'];
					$temp['last_minimum_16_b']           	 = $data['total_minimum_last']['nightdiff_total'
					] + $data['total_minimum_last']['leave_pay_total'] + $data['total_minimum_last']['special_holiday_total'] + $data['total_minimum_last']['regular_holiday_total'] + $data['total_minimum_last']['overtime_total'];

					//first + last minimum
					$temp['total_minimum_1601c']             = $temp['first_minimum_16_b'] + $temp['last_minimum_16_b'];
			     }

			     	//get nontaxable first and last
			   	     $data["_employee"]                    	 = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $data['first_period'][0]->payroll_period_company_id)->basic()->get();

			         $data['non_taxable_total_first']        = Payroll2::get_total_payroll_register($data);

			         $data["_employee"]                    	 = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $data['last_period'][0]->payroll_period_company_id)->basic()->get();

			         $data['non_taxable_total_last']          = Payroll2::get_total_payroll_register($data);


			         //compute first and last non taxable
			         $temp['first_period_total_compensation'] = Payroll2::payroll_number_format($data['first_period'][0]->payroll_period_total_gross, 2);
			         $temp['last_period_total_compensation']  = Payroll2::payroll_number_format($data['last_period'][0]->payroll_period_total_gross, 2);
			         $temp['total_for_1601c']                 =  Payroll2::payroll_number_format(($data['last_period'][0]->payroll_period_total_gross + $data['first_period'][0]->payroll_period_total_gross), 2);

			         //add allowances first period
			         $allowances_first                        = $data['non_taxable_total_first']['total_adjustment_allowance'] + $data['non_taxable_total_first']['total_adjustment_bonus'] + $data['non_taxable_total_first']['total_adjustment_commission'] + $data['non_taxable_total_first']['total_adjustment_incentives'] + $data['non_taxable_total_first']['total_adjustment_additions']  + $data['non_taxable_total_first']['total_adjustment_13th_month_and_other']  + $data['non_taxable_total_first']['total_adjustment_de_minimis_benefit']  + $data['non_taxable_total_first']['total_adjustment_others'];

				     $temp['non_tax_compensation_first']      = $data['non_taxable_total_first']['total_er'] + $data['non_taxable_total_first']['total_ee'] + $data['non_taxable_total_first']['total_ec'] + $allowances_first; 


				     //add allowances last period
				     $allowances_last                         = $data['non_taxable_total_last']['total_adjustment_allowance'] + $data['non_taxable_total_last']['total_adjustment_bonus'] + $data['non_taxable_total_last']['total_adjustment_commission'] + $data['non_taxable_total_last']['total_adjustment_incentives'] + $data['non_taxable_total_last']['total_adjustment_additions']  + $data['non_taxable_total_last']['total_adjustment_13th_month_and_other']  + $data['non_taxable_total_last']['total_adjustment_de_minimis_benefit']  + $data['non_taxable_total_last']['total_adjustment_others'];

				     $temp['non_tax_compensation_last']       = $data['non_taxable_total_last']['total_er'] + $data['non_taxable_total_last']['total_ee'] + $data['non_taxable_total_last']['total_ec'] + $allowances_last; 



				     $temp['total_non_tax_compensation']	  = $temp['non_tax_compensation_first'] + $temp['non_tax_compensation_last'];

				     $temp['total_taxable_first'] 			  = $temp['first_period_total_compensation'] - ($temp['non_tax_compensation_first'] + $temp['first_minimum_16_b'] + $temp['first_period_total_minimum']);

				     $temp['total_taxable_last'] 			  = $temp['last_period_total_compensation'] - ($temp['non_tax_compensation_last'] + $temp['last_minimum_16_b'] + $temp['last_period_total_minimum']);

				     $temp['total_taxable']		              = $temp['total_taxable_first'] + $temp['total_taxable_last'];

			         $temp['tax_with_held_first']			  = $data['non_taxable_total_first']['witholding_tax_total'];
			         $temp['tax_with_held_last']		      = $data['non_taxable_total_last']['witholding_tax_total'];
			         $temp['tax_total']						  = $temp['tax_with_held_first'] + $temp['tax_with_held_last'];

			         array_push($bir_report,$temp);

			         return $bir_report;
	     }
	}



}