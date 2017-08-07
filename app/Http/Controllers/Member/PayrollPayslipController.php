<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_time_keeping_approved;
use App\Models\Tbl_payroll_time_keeping_approved_breakdown;
use App\Models\Tbl_payroll_time_keeping_approved_performance;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_payslip;
use App\Models\Tbl_payroll_record;
use PDF2;


class PayrollPayslipController extends Member
{
     public function shop_id()
     {
     	return $this->user_info->shop_id;
     }
     public function index($period_company_id)
     { 
		$data["company"] = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
		$data["show_period_start"]	= date("F d, Y", strtotime($data["company"]->payroll_period_start));
		$data["show_period_end"]	= date("F d, Y", strtotime($data["company"]->payroll_period_end));

		foreach($data["_employee"] as $key => $employee)
		{
			if($data["_employee"][$key]->cutoff_input == "")
			{
				$employee_id = $employee->payroll_employee_id;
				$period_id = $period_company_id;
				app('App\Http\Controllers\Member\PayrollTimeSheet2Controller')->approve_timesheets($period_id, $employee_id);
				app('App\Http\Controllers\Member\PayrollTimeSheet2Controller')->approve_timesheets($period_id, $employee_id);
			}
		}

		$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();

		foreach($data["_employee"] as $key => $employee)
		{
			$data["_employee"][$key] = $employee;
			$data["_employee"][$key]->cutoff_compute = unserialize($employee->cutoff_compute);
			$data["_employee"][$key]->cutoff_input =  unserialize($employee->cutoff_input);
			$data["_employee"][$key]->cutoff_breakdown =  unserialize($employee->cutoff_breakdown);

			$other_deductions = 0;

			foreach($data["_employee"][$key]->cutoff_breakdown->_breakdown as $breakdown)
			{
				if($breakdown["deduct.net_pay"] == true)
				{
					$other_deductions += $breakdown["amount"];
				}
			}

			$data["_employee"][$key]->other_deduction = $other_deductions;
			$data["_employee"][$key]->total_deduction = $employee->philhealth_ee + $employee->sss_ee + $employee->pagibig_ee + $employee->tax_ee + $other_deductions;
		
		
		}

		$pdf = PDF2::loadView('member.payroll.payroll_payslipv1', $data);
		return $pdf->stream('document.pdf');
     }
}