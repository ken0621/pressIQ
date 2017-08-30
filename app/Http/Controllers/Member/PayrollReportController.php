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
	                                              // ->where('tbl_payroll_period.payroll_period_status','!=','pending')
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


		foreach ($data['_employee'] as $lbl => $breakdown) 
		{
			$unserialize_breakdown = unserialize($breakdown->cutoff_breakdown);

			$data['_employee'][$lbl]->hello = 'asdsada';
		}

		$data = $this->get_total($data);
		// dd($data['company']);
		return view('member.payrollreport.payroll_register_report_period',$data);
	}



	public function get_total($data)
	{
		$total_basic = 0;
		$total_gross = 0;
		$total_net = 0;
		$total_tax = 0;

		$g_total_er = 0;
		$g_total_ee = 0;
		$g_total_ec = 0;

		$total_sss_ee = 0;
		$total_sss_er = 0;
		$total_sss_ec = 0;
		$total_philhealth_ee = 0;
		$total_philhealth_er = 0;
		$total_pagibig_ee = 0;
		$total_pagibig_er = 0;
		$total_deduction = 0;

		$total_deduction_employee=0;

		$_other_deduction = null;
		$_addition = null;
		$_deduction = null;

			
		foreach($data["_employee"] as $key => $employee)
		{
			
			$deduction = 0;
			$total_basic += $employee->net_basic_pay;
			$total_gross += $employee->gross_pay;
			$total_net += $employee->net_pay;
			$total_tax += $employee->tax_ee;

			$total_er = $employee->sss_er + $employee->philhealth_er +  $employee->pagibig_er;
			$total_ee = $employee->sss_ee + $employee->philhealth_ee +  $employee->pagibig_ee;
			$total_ec = $employee->sss_ec;

			$total_sss_ee += $employee->sss_ee;
			$total_sss_er += $employee->sss_er;
			$total_sss_ec += $employee->sss_ec;
			$total_philhealth_ee += $employee->philhealth_er;
			$total_philhealth_er += $employee->philhealth_er;
			$total_pagibig_ee += $employee->pagibig_ee;
			$total_pagibig_er += $employee->pagibig_er;

			// $total_deduction_employee += $employee["total_deduction"];
			

			$data["_employee"][$key] = $employee;
			$data["_employee"][$key]->total_er = $total_er;
			$data["_employee"][$key]->total_ee = $total_ee;
			$data["_employee"][$key]->total_ec = $total_ec;

			$g_total_ec += $total_ec;
			$g_total_er += $total_er;
			$g_total_ee += $total_ee;

			$total_deduction += ($total_ee);

			if(isset($employee->cutoff_breakdown))
			{

				$_duction_break_down = unserialize($employee->cutoff_breakdown)->_breakdown;

					// dd($_duction_break_down);
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
					}

					$data["_employee"][$key]->total_deduction_employee = $deduction;
					
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

		$data["total_basic"] = $total_basic;
		$data["total_gross"] = $total_gross;
		$data["total_net"] = $total_net;
		$data["total_er"] = $g_total_er;
		$data["total_ee"] = $g_total_ee;
		$data["total_ec"] = $g_total_ec;
		$data["total_tax"] = $total_tax;
		$data["total_grand"] = $total_net + $g_total_er + $g_total_ee + $g_total_ec + $total_tax;
		$data["total_sss_ee"] = $total_sss_ee;
		$data["total_sss_er"] = $total_sss_er;
		$data["total_sss_ec"] = $total_sss_ec;
		$data["total_philhealth_ee"] = $total_philhealth_ee;
		$data["total_philhealth_er"] = $total_philhealth_er;
		$data["total_pagibig_ee"] = $total_pagibig_ee;
		$data["total_pagibig_er"] = $total_pagibig_er;
		$data["_other_deduction"] = $_other_deduction;
		$data["_addition"] = $_addition;
		$data["_deduction"] = $_deduction;
		$data["total_deduction"] = $total_deduction;
		$data["total_deduction_of_all_employee"] = $total_deduction_employee;
		
		// dd($data["total_deduction_of_all_employee"]);
		return $data;
	}

	/*END PAYROLL REGISTER REPORT*/



}