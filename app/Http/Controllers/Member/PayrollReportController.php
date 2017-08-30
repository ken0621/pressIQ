<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
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

		return view("member.payrollreport.government_forms_philhealth", $data);
	}
	public function government_forms_hdmf_iframe($month)
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
	                                         
	                                              ->join('tbl_payroll_period_company','tbl_payroll_period_company.payroll_period_id','=','tbl_payroll_period.payroll_period_id')
	                                              ->join('tbl_payroll_company', 'tbl_payroll_company.payroll_company_id','=', 'tbl_payroll_period_company.payroll_company_id')
	                                              ->orderBy('tbl_payroll_period.payroll_period_start','asc')
	                                              ->get();

	    
		return view("member.payrollreport.payroll_register_report", $data);
	} 

	/*END PAYROLL REGISTER REPORT*/



}