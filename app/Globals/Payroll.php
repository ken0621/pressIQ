<?php
namespace App\Globals;
use App\Models\Tbl_payroll_tax_default;
use App\Models\Tbl_payroll_tax_reference;
use App\Models\Tbl_payroll_copy_log_requirements;
use App\Models\Tbl_payroll_tax_period;
use App\Models\Tbl_payroll_sss;
use App\Models\Tbl_payroll_sss_default;
use App\Models\Tbl_payroll_philhealth_default;
use App\Models\Tbl_payroll_philhealth;
use App\Models\Tbl_payroll_pagibig_default;
use App\Models\Tbl_payroll_pagibig;
use App\Models\Tbl_payroll_employee_search;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_deduction;
use App\Models\Tbl_payroll_deduction_employee;
use App\Models\Tbl_payroll_deduction_payment;

use Carbon\Carbon;
use stdClass;

class Payroll
{
	public static function tax_reference($shop_id = 0)
	{
		$count = Tbl_payroll_copy_log_requirements::where('shop_id',$shop_id)->where('requirements_category','tax')->count();
		if($count == 0)
		{
			$_tax = Tbl_payroll_tax_default::get();

			$insert = array();

			foreach($_tax as $key => $tax)
			{
				$insert[$key]['shop_id'] 				= $shop_id;
				$insert[$key]['payroll_tax_status_id'] 	= $tax->payroll_tax_status_id;
				$insert[$key]['tax_category'] 			= $tax->tax_category;
				$insert[$key]['tax_first_range'] 		= $tax->tax_first_range;
				$insert[$key]['tax_second_range'] 		= $tax->tax_second_range;
				$insert[$key]['tax_third_range'] 		= $tax->tax_third_range;
				$insert[$key]['tax_fourth_range'] 		= $tax->tax_fourth_range;
				$insert[$key]['tax_fifth_range'] 		= $tax->tax_fifth_range;
				$insert[$key]['taxt_sixth_range'] 		= $tax->taxt_sixth_range;
				$insert[$key]['tax_seventh_range'] 		= $tax->tax_seventh_range;
			}

			Tbl_payroll_tax_reference::insert($insert);

			$insertlog['shop_id'] 					= $shop_id;
			$insertlog['requirements_category']	 	= 'tax';
			$insertlog['requirements_copy_date']	= Carbon::now();
			Tbl_payroll_copy_log_requirements::insert($insertlog);
		}
	}

	public static function tax_break($shop_id = 0)
	{
		$data = array();
		$_period = Tbl_payroll_tax_period::get();
		$count = 1;
		foreach($_period as $key => $period)
		{
			$data[$key]['category'] 				= $period->payroll_tax_period;
			$data[$key]['payroll_tax_period_id'] 	= $period->payroll_tax_period_id;
			$data[$key]['data']						= Tbl_payroll_tax_reference::where('shop_id', $shop_id)->where('payroll_tax_status_id', $period->payroll_tax_period_id)->get();
			$status = '';
			if($count == 1)
			{
				$status = 'active';
			}	
			$data[$key]['status'] = $status;
			$count++;
		}

		return $data;
	}

	public static function generate_sss($shop_id = 0)
	{
		$count = Tbl_payroll_copy_log_requirements::where('shop_id',$shop_id)->where('requirements_category','sss')->count();
		if($count == 0)
		{
			$_sss = Tbl_payroll_sss_default::get();
			$insert = array();
			foreach($_sss as $key => $sss)
			{
				$insert[$key]['shop_id'] 			= $shop_id;
				$insert[$key]['payroll_sss_min'] 	= $sss->payroll_sss_min;
				$insert[$key]['payroll_sss_max'] 	= $sss->payroll_sss_max;
				$insert[$key]['payroll_sss_monthly_salary'] = $sss->payroll_sss_monthly_salary;
				$insert[$key]['payroll_sss_er'] 	= $sss->payroll_sss_er;
				$insert[$key]['payroll_sss_ee'] 	= $sss->payroll_sss_ee;
				$insert[$key]['payroll_sss_total'] 	= $sss->payroll_sss_total;
				$insert[$key]['payroll_sss_eec'] 	= $sss->payroll_sss_eec;
			}
			Tbl_payroll_sss::insert($insert);
			$insertlog['shop_id'] 					= $shop_id;
			$insertlog['requirements_category']	 	= 'sss';
			$insertlog['requirements_copy_date']	= Carbon::now();
			Tbl_payroll_copy_log_requirements::insert($insertlog);
		}
	}

	public static function generate_philhealth($shop_id = 0)
	{
		$count = Tbl_payroll_copy_log_requirements::where('shop_id',$shop_id)->where('requirements_category','philhealth')->count();

		if($count == 0)
		{
			$_philhealth = Tbl_payroll_philhealth_default::get();
			$insert = array();
			foreach($_philhealth as $key => $philhealth)
			{
				$insert[$key]['shop_id']					= $shop_id;
				$insert[$key]['payroll_philhealth_min'] 	= $philhealth->payroll_philhealth_min;
				$insert[$key]['payroll_philhealth_max'] 	= $philhealth->payroll_philhealth_max;
				$insert[$key]['payroll_philhealth_base'] 	= $philhealth->payroll_philhealth_base;
				$insert[$key]['payroll_philhealth_premium'] = $philhealth->payroll_philhealth_premium;
				$insert[$key]['payroll_philhealth_ee_share'] = $philhealth->payroll_philhealth_ee_share;
				$insert[$key]['payroll_philhealth_er_share'] = $philhealth->payroll_philhealth_er_share;
			}
			Tbl_payroll_philhealth::insert($insert);

			$insertlog['shop_id'] 					= $shop_id;
			$insertlog['requirements_category']	 	= 'philhealth';
			$insertlog['requirements_copy_date']	= Carbon::now();
			Tbl_payroll_copy_log_requirements::insert($insertlog);
		}
	}

	public static function generate_pagibig($shop_id = 0)
	{

		$count = Tbl_payroll_copy_log_requirements::where('shop_id',$shop_id)->where('requirements_category','pagibig')->count();
		if($count == 0)
		{
			$pagibig = Tbl_payroll_pagibig_default::pluck('payroll_pagibig_percent');
			$insert['payroll_pagibig_percent']  = $pagibig;
			$insert['shop_id']					= $shop_id;
			Tbl_payroll_pagibig::insert($insert);

			$insertlog['shop_id'] 					= $shop_id;
			$insertlog['requirements_category']	 	= 'pagibig';
			$insertlog['requirements_copy_date']	= Carbon::now();
			Tbl_payroll_copy_log_requirements::insert($insertlog);
		}
	}


	/* TABLE FOR EMPLOYEE SEARCH INSERT OR UPDATE */
	public static function generate_emplyoee_search($employee_id = 0)
	{

		if($employee_id == 0)
		{
			// $_emp 	= Tbl_payroll_employee_basic::get();
			// $insert = array();
			// foreach($_emp as $key => $emp)
			// {
			// 	$insert[$key]['payroll_search_employee_id'] = $emp->payroll_employee_id;
			// 	$insert[$key]['body'] = $emp->payroll_employee_title_name.' '.$emp->payroll_employee_first_name.' '.$emp->payroll_employee_middle_name.' '.$emp->payroll_employee_last_name.' '.$emp->payroll_employee_suffix_name.' '.$emp->payroll_employee_display_name.' '.$emp->payroll_employee_email;

			// }
			// Tbl_payroll_employee_search::insert($insert);
		}
		else
		{
			$count = Tbl_payroll_employee_search::where('payroll_search_employee_id', $employee_id)->count();
			$employee = Tbl_payroll_employee_basic::where('payroll_search_employee_id', $employee_id)->first();

			$search['body'] = $employee->payroll_employee_title_name.' '.$employee->payroll_employee_first_name.' '.$employee->payroll_employee_middle_name.' '.$employee->payroll_employee_last_name.' '.$employee->payroll_employee_suffix_name.' '.$employee->payroll_employee_display_name.' '.$employee->payroll_employee_email;
			if($count == 0)
			{
				$search['payroll_search_employee_id'] = $employee_id;
				Tbl_payroll_employee_search::insert($search);
			}
			else
			{
				Tbl_payroll_employee_search::where('payroll_search_employee_id',$employee_id)->update($search);
			}
		}
		

	}
	
	/* GET EMPLOYEE DEDUCTION BALANCE */
	public static function getbalance($shop_id = 0, $deduction_id = 0)
	{
		$data = array();

		$total_amount = Tbl_payroll_deduction::where('payroll_deduction_id',$deduction_id)->pluck('payroll_deduction_amount');


		$_deduction = Tbl_payroll_deduction_employee::selbyemployee($deduction_id)->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->get();
		// dd($_deduction);
		$data['active'] = array();
		$data['zero']	= array();
		$data['cancel']	= array();
		foreach($_deduction as $key => $deduction)
		{
			$balance = $total_amount - Tbl_payroll_deduction_payment::selbyemployee($deduction->payroll_employee_id, $deduction_id)->sum('payroll_payment_amount');
			$index = 'active';
			if($balance <= 0)
			{
				$index = 'zero';
			}
			$data[$index][$key]['deduction'] 	= $deduction;
			$data[$index][$key]['balance'] 		= $balance;
		}
		
		$_canceled = Tbl_payroll_deduction_employee::selbyemployee($deduction_id,1)->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->get();
		foreach($_canceled as $key => $cancel)
		{
			$balance = $total_amount - Tbl_payroll_deduction_payment::selbyemployee($cancel->payroll_employee_id, $deduction_id)->sum('payroll_payment_amount');

			$data['cancel'][$key]['deduction'] 	= $cancel;
			$data['cancel'][$key]['balance'] 		= $balance;
		}
		
		return $data;
	}

	/* 	 Returns normal hours rendered and overtime (Guillermo Tabligan) */
	public static function process_time($time_rule, $default_time_in, $default_time_out, $_time_record, $break = "01:00", $default_working_hours = "08:00")
	{
		$return = new stdClass();

		switch($time_rule)
		{
			case "flexitime": 
				return Payroll::process_time_flexitime($return, $time_rule, $default_time_in, $default_time_out, $_time_record, $break, $default_working_hours);
			break;
			case "regulartime": 
				return Payroll::process_time_regulartime($return, $time_rule, $default_time_in, $default_time_out, $_time_record, $break, $default_working_hours);
			break;
		}
	}
	public static function process_time_flexitime($return, $time_rule, $default_time_in, $default_time_out, $_time_record, $break, $default_working_hours)
	{
		$data["break"] = $break = c_time_to_int($break);
		$data["default_working_hours"] = $default_working_hours = c_time_to_int($default_working_hours);

		
		$total_time_spent = 0;
		$total_early_overtime = 0;
		$total_late_overtime = 0;
		$total_regular_hours = 0;

		foreach($_time_record as $time_record)
		{
			$time_in = c_time_to_int($time_record->time_in);
			$time_out = c_time_to_int($time_record->time_out);

			if($time_out > $time_in)
			{
				$time_spent = ($time_out - $time_in);
			}
			else
			{
				$time_spent = 0;
			}
			
			$total_time_spent += $time_spent;
		}

		if($total_time_spent <= 0)
		{
			$total_time_spent = 0;
		}
		else
		{
			if($break > $total_time_spent)
			{
				$total_time_spent = 0;
			}
			else
			{
				$total_time_spent = $total_time_spent - $break;
			}
			
		}


		/* COMPUTE OVERTIME */
		$total_time_spent = c_time_to_int(date("H:i", $total_time_spent));
		$default_working_hours = c_time_to_int(date("H:i", $default_working_hours));
		if($total_time_spent > $default_working_hours)
		{
			$total_late_overtime = $total_time_spent - $default_working_hours;
			$total_regular_hours = $default_working_hours;
		}
		else
		{
			$total_regular_hours = $total_time_spent;
		}

		$return->time_spent = date("H:i", $total_time_spent);
		$return->regular_hours = date("H:i", $total_regular_hours);
		$return->late_overtime = date("H:i", $total_late_overtime);
		$return->early_overtime = date("H:i", $total_early_overtime);
		
		return $return;
	}

	public static function process_time_regulartime($return, $time_rule, $default_time_in, $default_time_out, $_time_record, $break, $default_working_hours)
	{
		$data["break"] = $break = c_time_to_int($break);
		$data["default_working_hours"] = $default_working_hours = c_time_to_int($default_working_hours);

		$total_time_spent = 0;
		$total_early_overtime = 0;
		$total_late_overtime = 0;
		$total_regular_hours = 0;

		$default_time_in = c_time_to_int($default_time_in);
		$default_time_out = c_time_to_int($default_time_out);

		/* CHECK EACH TIME */
		foreach($_time_record as $time_record)
		{
			$time_in = c_time_to_int($time_record->time_in);
			$time_out = c_time_to_int($time_record->time_out);
			$early_overtime = 0;
			$late_overtime = 0;

			if($time_out > $time_in)
			{
				$time_spent = ($time_out - $time_in);
			}
			else
			{
				$time_spent = 0;
			}

			$regular_hours = $time_spent;

			/* CHECK IF EARLY OVERTIME */
			if($time_in < $default_time_in)
			{
				$early_overtime = $default_time_in - $time_in;
				$regular_hours = $regular_hours - $early_overtime;
			}

			/* CHECK IF EARLY OVERTIME */
			if($time_out > $default_time_out)
			{
				$late_overtime = $time_out - $default_time_out;
				$regular_hours = $regular_hours - $late_overtime;
			}

			$total_early_overtime += $early_overtime;
			$total_late_overtime += $late_overtime;
			$total_regular_hours += $regular_hours;
			$total_time_spent += $time_spent;

		}


		if($total_time_spent <= 0)
		{
			$total_time_spent = 0;
		}
		else
		{
			if($break > $total_regular_hours)
			{
				$total_regular_hours = 0;
			}
			else
			{
				$total_regular_hours = $total_regular_hours - $break;
			}
		}


		$return->time_spent = date("H:i", $total_time_spent);
		$return->regular_hours = date("H:i", $total_regular_hours);
		$return->late_overtime = date("H:i", $total_late_overtime);
		$return->early_overtime = date("H:i", $total_early_overtime);
		
		return $return;
	}
}
