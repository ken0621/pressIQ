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

class Payroll13thMonthPayController extends Member
{

	public function shop_id($return = 'shop_id')
	{
	      switch ($return) {
	           case 'shop_id':
	                return $shop_id = $this->user_info->user_shop;
	                break;

	           case 'user_id':
	                return $shop_id = $this->user_info->user_id;
	                break;
	           
	           default:
	               
	                break;
	      }
	}

	public function index()
	{
		$parameter['date']					= date('Y-m-d');
		$parameter['company_id']			= 0;
		$parameter['employement_status']	= 0;
		$parameter['shop_id'] 				= $this->shop_id();
		$data["_employee"] = Tbl_payroll_employee_basic::selemployee($parameter)->orderby("tbl_payroll_employee_basic.payroll_employee_number")->get();
		return view("member.payrollreport.payroll_13th_month_pay_v2", $data );
	}

	public function employee_13_month_pay_report($employee_id)
	{
		$data["employee"] = Tbl_payroll_employee_basic::where("tbl_payroll_employee_basic.payroll_employee_id",$employee_id)->first();
		$data["_period"]  = Tbl_payroll_period::GetEmployeeAllPeriodRecords($employee_id)
		->where("tbl_payroll_period_company.payroll_period_status","!=","pending")
		->get();
		// dd($data["_period"]);
		return view('member.payrollreport.payroll_13th_month_pay_report_v2',$data);
	}


	public function employee_13_month_pay_report_table()
	{
		$data["basis"] = unserialize(Request::input('employee_13_month_basis'));
		
		$data["employee"] = Tbl_payroll_employee_basic::where("tbl_payroll_employee_basic.payroll_employee_id",$data["basis"]['payroll_employee_id'])->first();
		$data["_period"]  = Tbl_payroll_period::GetEmployeeAllPeriodRecords($data["basis"]['payroll_employee_id'])
		->where("tbl_payroll_period_company.payroll_period_status","!=","pending")
		->get();
		// dd($data["_period"]);
		$data = $this->compute_13th_month_pay($data);
		
		return view('member.payrollreport.payroll_13th_month_pay_report_table_v2',$data);
	}

	public function modal_employee_13_month_pay_report($employee_id)
	{
		$data['employee_id'] = $employee_id;
		return view('member.modal.modal_employee_13_month_pay_report',$data);
	}


	public function employee_13_month_pay_basis_submit()
	{

		$response["status"] 				 	= "success";
		$response["function"] 				 	= "load_13th_month_pay_table";
		$response["employee_id"]			 	= Request::input('employee_id');
		$response["employee_13_month_basis"]	= serialize(Request::input());
		$response["_token"]			 			= Request::input('_token');
		
		return json_encode($response);
	}

	public function compute_13th_month_pay($data)
	{
		$basis = $data["basis"]["payroll_13th_month_pay_basis"];

		foreach ($data["_period"] as $key_period => $period) 
		{
			$payroll_13th_month_basis = 0;

			$payroll_13th_month_basis += $period[$basis];
			// dd($period);
			// dd(unserialize($period['cutoff_breakdown']));
			// dd($period->cutoff_breakdown);
			if (isset($period->cutoff_breakdown)) 
			{
				$period_cutoff_breakdown = unserialize($period->cutoff_breakdown);

				foreach ($period_cutoff_breakdown->_breakdown as $key_cutoff_breakdown => $breakdown) 
				{

					if (isset($data["basis"]["payroll_cola"])) 
					{
						if ($breakdown["label"] == "COLA") 
						{
							$payroll_13th_month_basis += $breakdown["amount"];
						}
					}

					if (isset($data["basis"]["payroll_allowance"]))
					{
						if (isset($breakdown["record_type"])) 
						{
							if ($breakdown["record_type"] == "allowance") 
							{
								$payroll_13th_month_basis += $breakdown["amount"];
							}
						}
					}
				}
			}

			if (isset($employee->cutoff_input)) 
			{
				$_cutoff_input_breakdown = unserialize($employee->cutoff_input);
				
		
				$special_holiday = 0;
				$regular_holiday = 0;
				

				// $ot_category = array('Rest Day OT', 'Over Time', 'Legal Holiday Rest Day OT', 'Legal OT', 'Special Holiday Rest Day OT', 'Special Holiday OT');
				// $nd_category = array('Legal Holiday Rest Day ND','Legal Holiday ND','Special Holiday Rest Day ND','Special Holiday ND','Rest Day ND','Night Differential');
				// $rd_category = array('Rest Day','Legal Holiday Rest Day','Special Holiday Rest Day');
				foreach ($_cutoff_input_breakdown as $value) 
				{
					if (isset($employee->cutoff_input)) 
					{

						if (isset($data["basis"]["special_holiday"]))
						{
							if ($lbl == 'Special Holiday' || $lbl == 'Special Holiday Rest Day') 
							{
								$payroll_13th_month_basis += $values['rate'];
							}
						}

						if (isset($data["basis"]["regular_holiday"]))
						{
							
							if ($lbl == 'Legal Holiday' || $lbl == 'Legal Holiday Rest Day') 
							{
								$payroll_13th_month_basis += $values['rate'];
							}
						}

					}
				}
			}

			$data['_period'][$key_period]->payroll_13th_month_basis 		= $payroll_13th_month_basis;
			$data['_period'][$key_period]->payroll_13th_month_contribution 	= @( $payroll_13th_month_basis / 12);
	
		}

		return $data;
	}
}