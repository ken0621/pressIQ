<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Carbon\Carbon;

use DateTime;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\PayrollDeductionController;


use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
use App\Models\Tbl_payroll_time_sheet_record_approved;
use App\Models\Tbl_payroll_time_keeping_approved_daily_breakdown;
use App\Models\Tbl_payroll_time_keeping_approved_breakdown;
use App\Models\Tbl_payroll_time_keeping_approved_performance;
use App\Models\Tbl_payroll_group;
use App\Models\Tbl_payroll_leave_schedule;
use App\Models\Tbl_payroll_employee_salary;
use App\Models\Tbl_payroll_shift_day;
use App\Models\Tbl_payroll_holiday_company;
use App\Models\Tbl_payroll_time_keeping_approved;
use App\Models\Tbl_payroll_shift_code;
use App\Models\Tbl_payroll_shift_time;
use App\Models\Tbl_payroll_adjustment;
use App\Models\Tbl_payroll_period;
use App\Globals\Payroll2;
use App\Globals\Payroll;
use App\Globals\PayrollLeave;
use App\Globals\Utilities;
use App\Models\Tbl_payroll_company;



use App\Models\Tbl_payroll_deduction_v2;
use App\Models\Tbl_payroll_deduction_employee_v2;
use App\Models\Tbl_payroll_deduction_payment_v2;


use DB;

class PayrollLedger extends Member
{

	public function shop_id()
	{
		return $this->user_info->shop_id;
	}

	public function index()
	{
		$parameter['date']					= date('Y-m-d');
		$parameter['company_id']			= 0;
		$parameter['employement_status']	= 0;
		$parameter['shop_id'] 				= $this->shop_id();
		$data["_employee"] = Tbl_payroll_employee_basic::selemployee($parameter)->orderby("tbl_payroll_employee_basic.payroll_employee_number")->get();

		// dd($data["_employee"]);
		return view("member.payrollreport.payroll_ledger",$data);
	}

	public function modal_ledger($employee_id)
	{
		$data["employee"] = Tbl_payroll_employee_basic::where("tbl_payroll_employee_basic.payroll_employee_id",$employee_id)->first();
		$data["_period"]  = Tbl_payroll_period::where("tbl_payroll_employee_basic.payroll_employee_id",$employee_id)
		->where("tbl_payroll_period_company.payroll_period_status","!=","pending")
		->join("tbl_payroll_period_company","tbl_payroll_period_company.payroll_period_id","=","tbl_payroll_period.payroll_period_id")
		->join("tbl_payroll_time_keeping_approved","tbl_payroll_time_keeping_approved.payroll_period_company_id","=","tbl_payroll_period_company.payroll_period_company_id")
		->join("tbl_payroll_employee_basic","tbl_payroll_employee_basic.payroll_employee_id","=","tbl_payroll_time_keeping_approved.employee_id")
		->get();

		$data = $this->get_grand_total_whole_year($data);
		$data = $this->get_total_per_period($data);

		// dd($data);
		return view("member.payrollreport.payroll_employee_ledger",$data);
	}

	public function get_grand_total_whole_year($data)
	{
		$data["total_basic"] 						= 0;
		$data["total_gross"] 						= 0;
		$data["total_net"] 							= 0;
		$data["total_er"] 							= 0;
		$data["total_ee"] 							= 0;
		$data["total_ec"] 							= 0;
		$data["total_tax"] 							= 0;
		$data["total_grand"] 						= 0; 
		$data["total_sss_ee"] 						= 0;
		$data["total_sss_er"] 						= 0;
		$data["total_sss_ec"] 						= 0;
		$data["total_philhealth_ee"] 				= 0;
		$data["total_philhealth_er"] 				= 0;
		$data["total_pagibig_ee"] 					= 0;
		$data["total_pagibig_er"] 					= 0;
		$data["_other_deduction"] 					= 0;
		$data["_addition"] 							= 0;
		$data["_deduction"] 						= 0;
		$data["total_deduction"] 					= 0;
		$data["total_deduction_of_all_employee"] 	= 0;


		$data["deduction_total"] 					= 0;
		$data["cola_total"] 						= 0;
		$data["sss_ee_total"] 						= 0;
		$data["sss_er_total"] 						= 0;
		$data["sss_ec_total"] 						= 0;
		$data["hdmf_ee_total"] 						= 0;
		$data["hdmf_er_total"] 						= 0;
		$data["philhealth_ee_total"] 				= 0;
		$data["philhealth_er_total"] 				= 0;
		$data["witholding_tax_total"] 				= 0;
		$data["adjustment_deduction_total"] 		= 0;
		$data["adjustment_allowance_total"] 		= 0;
		$data["allowance_total"] 					= 0;
		$data["cash_bond_total"] 					= 0;
		$data["cash_advance_total"]					= 0;
		$data["hdmf_loan_total"]					= 0;
		$data["sss_loan_total"]						= 0;
		$data["other_loans_total"]					= 0;

		$data["overtime_total"] 		 			= 0;
		$data["special_holiday_total"] 				= 0;
		$data["regular_holiday_total"] 				= 0;
		$data["leave_pay_total"] 	     			= 0;
		$data["late_total"] 			 			= 0;
		$data["undertime_total"] 		 			= 0;
		$data["absent_total"] 		 				= 0;
		$data["nightdiff_total"] 		 			= 0;
		$data["restday_total"] 		 				= 0;

		return $data;
	}

	public function get_total_per_period($data)
	{

		// dd($data);
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

		$total_deduction_employee = 0;

		$_other_deduction = null;
		$_addition 		  = null;
		$_deduction 	  = null;

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

	



		foreach($data["_period"] as $key => $employee)
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

			$data["_period"][$key] = $employee;
			$data["_period"][$key]->total_er = $total_er;
			$data["_period"][$key]->total_ee = $total_ee;
			$data["_period"][$key]->total_ec = $total_ec;



			$g_total_ec += $total_ec;
			$g_total_er += $total_er;
			$g_total_ee += $total_ee;

			$total_deduction += ($total_ee);


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

				$data["_period"][$key]->total_deduction_employee 	= $deduction;
				$data["_period"][$key]->cola 						= $cola;
				$data["_period"][$key]->sss_ee 					= $sss_ee;
				$data["_period"][$key]->sss_er 					= $sss_er;
				$data["_period"][$key]->sss_ec 					= $sss_ec;
				$data["_period"][$key]->hdmf_ee 					= $hdmf_ee;
				$data["_period"][$key]->hdmf_er 					= $hdmf_er;
				$data["_period"][$key]->philhealth_ee 			= $philhealth_ee;
				$data["_period"][$key]->philhealth_er 			= $philhealth_er;
				$data["_period"][$key]->witholding_tax 			= $witholding_tax;
				$data["_period"][$key]->adjustment_deduction 		= $adjustment_deduction;
				$data["_period"][$key]->adjustment_allowance 		= $adjustment_allowance;
				$data["_period"][$key]->allowance 				= $allowance;
				$data["_period"][$key]->cash_bond					= $cash_bond;
				$data["_period"][$key]->cash_advance				= $cash_advance;
				$data["_period"][$key]->sss_loan					= $sss_loan;
				$data["_period"][$key]->hdmf_loan					= $hdmf_loan;
				$data["_period"][$key]->other_loans				= $other_loans;

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

			// dd(unserialize($employee->cutoff_input));
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

				$data["_period"][$key]->overtime = $overtime;
				$data["_period"][$key]->regular_holiday = $regular_holiday;
				$data["_period"][$key]->special_holiday = $special_holiday;
				$data["_period"][$key]->leave_pay = $leave_pay;
				$data["_period"][$key]->absent = $absent;
				$data["_period"][$key]->late = $late;
				$data["_period"][$key]->undertime = $undertime;
				$data["_period"][$key]->nightdiff = $nightdiff;
				$data["_period"][$key]->restday = $restday;

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

		$data["total_basic"] 						+= $total_basic;
		$data["total_gross"] 						+= $total_gross;
		$data["total_net"] 							+= $total_net;
		$data["total_er"] 							+= $g_total_er;
		$data["total_ee"] 							+= $g_total_ee;
		$data["total_ec"] 							+= $g_total_ec;
		$data["total_tax"] 							+= $total_tax;
		$data["total_grand"] 						+= $total_net + $g_total_er + $g_total_ee + $g_total_ec + $total_tax;
		$data["total_sss_ee"] 						+= $total_sss_ee;
		$data["total_sss_er"] 						+= $total_sss_er;
		$data["total_sss_ec"] 						+= $total_sss_ec;
		$data["total_philhealth_ee"] 				+= $total_philhealth_ee;
		$data["total_philhealth_er"] 				+= $total_philhealth_er;
		$data["total_pagibig_ee"] 					+= $total_pagibig_ee;
		$data["total_pagibig_er"] 					+= $total_pagibig_er;
		$data["_other_deduction"] 					+= $_other_deduction;
		$data["_addition"] 							+= $_addition;
		$data["_deduction"] 						+= $_deduction;
		$data["total_deduction"] 					+= $total_deduction;
		$data["total_deduction_of_all_employee"] 	+= $total_deduction_employee;

		$data["deduction_total"] 					+= $deduction_total;
		$data["cola_total"] 						+= $cola_total;
		$data["sss_ee_total"] 						+= $sss_ee_total;
		$data["sss_er_total"] 						+= $sss_er_total;
		$data["sss_ec_total"] 						+= $sss_ec_total;
		$data["hdmf_ee_total"] 						+= $hdmf_ee_total;
		$data["hdmf_er_total"] 						+= $hdmf_er_total;
		$data["philhealth_ee_total"] 				+= $philhealth_ee_total;
		$data["philhealth_er_total"] 				+= $philhealth_er_total;
		$data["witholding_tax_total"] 				+= $witholding_tax_total;
		$data["adjustment_deduction_total"] 		+= $adjustment_deduction_total;
		$data["adjustment_allowance_total"] 		+= $adjustment_allowance_total;
		$data["allowance_total"] 					+= $allowance_total;
		$data["cash_bond_total"] 					+= $cash_bond_total;
		$data["cash_advance_total"]					+= $cash_advance_total;
		$data["hdmf_loan_total"]					+= $hdmf_loan_total;
		$data["sss_loan_total"]						+= $sss_loan_total;
		$data["other_loans_total"]					+= $other_loans_total;

		$data["overtime_total"] 		 			+= $overtime_total;
		$data["special_holiday_total"] 				+= $special_holiday_total;
		$data["regular_holiday_total"] 				+= $regular_holiday_total;
		$data["leave_pay_total"] 	     			+= $leave_pay_total;
		$data["late_total"] 			 			+= $late_total;
		$data["undertime_total"] 		 			+= $undertime_total;
		$data["absent_total"] 		 				+= $absent_total;
		$data["nightdiff_total"] 		 			+= $nightdiff_total;
		$data["restday_total"] 		 				+= $restday_total;
		
		// dd($data["total_deduction_of_all_employee"]);
		return $data;
	}
}
