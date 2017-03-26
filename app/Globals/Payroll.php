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
use App\Models\Tbl_payroll_group_rest_day;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
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

	/* RETURN IF INPUT IS CHECKED [FROm REST DAY AND EXTRA DAY ONLY (PAYROLL GROUPD)] */
	public static function restday_checked($payroll_group_id = 0)
	{
		$data = array();
		$_day = ['Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday'];
		foreach($_day as $day)
		{
			$temp['rest_day'] = $day;
			$rest_checked = '';
			$rest_count = Tbl_payroll_group_rest_day::selcheck($payroll_group_id, $day)->count();
			if($rest_count >= 1)
			{
				$rest_checked = 'checked';
			}
			$temp['rest_day_checked'] = $rest_checked;
			$temp['extra_day'] = $day;
			$extra_checked = '';
			$extra_count = Tbl_payroll_group_rest_day::selcheck($payroll_group_id, $day,'extra day')->count();
			if($extra_count >= 1)
			{
				$extra_checked = 'checked';
			}
			$temp['extra_day_checked'] = $extra_checked;
			array_push($data, $temp);
		}
		return $data;
	}

	public static function adjust_payroll_approved_in_and_out($employee_id, $date)
	{
		/* GET INITIAL INFORMATION AND DATABASE */
		$employee_information = Tbl_payroll_employee_contract::selemployee($employee_id)->leftJoin("tbl_payroll_group", "tbl_payroll_group.payroll_group_id", "=","tbl_payroll_employee_contract.payroll_group_id")->first();
		$time_sheet_info = Tbl_payroll_time_sheet::where("payroll_time_date", Carbon::parse($date)->format("Y-m-d"))->where("payroll_employee_id", $employee_id)->first();
		$_rest_day = Tbl_payroll_group_rest_day::where("payroll_group_id", $employee_information->payroll_group_id)->get();


		if($time_sheet_info->payroll_time_sheet_approved == 0) //ONLY UPDATE THOSE WHO ARE NOT APPROVED
		{
			$_time_record = Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $time_sheet_info->payroll_time_sheet_id)->get();

			foreach($_time_record as $time_record)
			{
				$payroll_time_sheet_approved_in = $time_record->payroll_time_sheet_in;
				$payroll_time_sheet_approved_out = $time_record->payroll_time_sheet_out;
				$payroll_time_sheet_in = false;
				$payroll_time_sheet_out = false;


				/* IF TIME IN HAPPENS LATER AFTER TIME OUT - LOL - SET TO ZERO */
				if(c_time_to_int($time_record->payroll_time_sheet_in) > c_time_to_int($time_record->payroll_time_sheet_out))
				{
					$payroll_time_sheet_approved_in = "00:00";
					$payroll_time_sheet_approved_out = "00:00";
					$payroll_time_sheet_in = "00:00";
					$payroll_time_sheet_out = "00:00";
				}

				if($employee_information->payroll_group_is_flexi_time == 0)
				{
					/* OVERTIME RULE */
					if(c_time_to_int($time_record->payroll_time_sheet_in) < c_time_to_int($employee_information->payroll_group_start))
					{
						$payroll_time_sheet_approved_in = $employee_information->payroll_group_start;
					}
					else
					{
						$payroll_time_sheet_approved_in = $time_record->payroll_time_sheet_in;
					}

					if(c_time_to_int($time_record->payroll_time_sheet_out) > c_time_to_int($employee_information->payroll_group_end))
					{
						$payroll_time_sheet_approved_out = $employee_information->payroll_group_end;
					}
					else
					{
						$payroll_time_sheet_approved_out = $time_record->payroll_time_sheet_out;
					}

					/* IF ONE OF THE TIME IS ZERO */
					if($time_record->payroll_time_sheet_in == "00:00:00" || $time_record->payroll_time_sheet_out == "00:00:00")
					{
						$payroll_time_sheet_approved_in = "00:00";
						$payroll_time_sheet_approved_out = "00:00";
					}

					/* IF TIME IN IS LATER THAN DEFAULT TIME OUT */
					if($time_record->payroll_time_sheet_in > $employee_information->payroll_group_end)
					{
						$payroll_time_sheet_approved_in = "00:00";
						$payroll_time_sheet_approved_out = "00:00";
					}

					/* IF TIME OUT IS EARLIER THAN DEFAULT TIME IN */
					if($time_record->payroll_time_sheet_out < $employee_information->payroll_group_start)
					{
						$payroll_time_sheet_approved_in = "00:00";
						$payroll_time_sheet_approved_out = "00:00";
					}
				}

				/* REST DAY NEEDS APPROVAL */
				foreach($_rest_day as $rest_day)
				{
					if($rest_day->payroll_group_rest_day == Carbon::parse($time_sheet_info->payroll_time_date)->format("l"))
					{
						$payroll_time_sheet_approved_in = "00:00";
						$payroll_time_sheet_approved_out = "00:00";
					}
				}

				$update["payroll_time_sheet_approved_in"] = Carbon::parse($payroll_time_sheet_approved_in)->format("H:i");
				$update["payroll_time_sheet_approved_out"] = Carbon::parse($payroll_time_sheet_approved_out)->format("H:i");

				if($payroll_time_sheet_in || $payroll_time_sheet_out)
				{
					$update["payroll_time_sheet_in"] = Carbon::parse($payroll_time_sheet_in)->format("H:i");
					$update["payroll_time_sheet_out"] = Carbon::parse($payroll_time_sheet_out)->format("H:i");
				}

				Tbl_payroll_time_sheet_record::where("payroll_time_sheet_record_id", $time_record->payroll_time_sheet_record_id)->update($update);
			}
		}
	}

	/* Returns normal hours rendered and overtime (Guillermo Tabligan) */
	public static function process_time($employee_id, $date)
	{
		$data["time_sheet_info"] = $time_sheet_info = Tbl_payroll_time_sheet::where("payroll_time_date", Carbon::parse($date)->format("Y-m-d"))->where("payroll_employee_id", $employee_id)->first();
		$data["employee_information"] = $employee_information = Tbl_payroll_employee_contract::selemployee($employee_id)->leftJoin("tbl_payroll_group", "tbl_payroll_group.payroll_group_id", "=","tbl_payroll_employee_contract.payroll_group_id")->first();
		/* EMPLOYEE COMPUTATION SETTINGS */
		if($employee_information->payroll_group_is_flexi_time == 1)
		{
			$data["time_rule"] = "flexitime";
		}
		else
		{
			$data["time_rule"] = "regulartime";
		}

		/* EMPLOYEE COMPUTATION SETTINGS */
		$data["default_time_in"] = $employee_information->payroll_group_start;
		$data["default_time_out"] = $employee_information->payroll_group_end;
		$data["default_working_hours"] = $employee_information->payroll_group_target_hour;
		$approved = $time_sheet_info->payroll_time_sheet_approved;
		$data["_time_record"] = Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $time_sheet_info->payroll_time_sheet_id)->get();
		

		$return = new stdClass();
		/* GET OTHER DETAILS BASED ON RECORD */
		switch($data["time_rule"])
		{
			case "flexitime": 
				//$return = Payroll::process_time_flexitime($time_rule, $default_time_in, $default_time_out, $_time_record, $break, $default_working_hours);
			break;
			case "regulartime":
				$data["compute_approved"] = 0;
				$return->pending_timesheet = Payroll::process_time_regulartime($data);
				$data["compute_approved"] = 1;
				$return->approved_timesheet = Payroll::process_time_regulartime($data);
			break;
		}

		$return->payroll_time_sheet_id = $time_sheet_info->payroll_time_sheet_id;
		$return->date = $time_sheet_info->payroll_time_date;
		$return->payroll_time_sheet_approved = $time_sheet_info->payroll_time_sheet_approved;

		return $return;
	}
	public static function process_time_flexitime($time_rule, $default_time_in, $default_time_out, $_time_record, $break, $default_working_hours)
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

		$return->time_spent = convert_seconds_to_hours_minutes("H:i", $total_time_spent);
		$return->regular_hours = convert_seconds_to_hours_minutes("H:i", $total_regular_hours);
		$return->late_overtime = convert_seconds_to_hours_minutes("H:i", $total_late_overtime);
		$return->early_overtime = convert_seconds_to_hours_minutes("H:i", $total_early_overtime);
		
		return $return;
	}

	public static function process_time_regulartime($data)
	{
		$time_rule = $data["time_rule"];
		$default_time_in = $data["default_time_in"];
		$default_time_out = $data["default_time_out"];
		$_time_record = $data["_time_record"];
		$default_working_hours = $data["default_working_hours"];
		$late_grace_time = $data["employee_information"]->payroll_group_grace_time * 60;
		$compute_approved = $data["compute_approved"];


		$return = new stdClass();
		$data["default_working_hours"] = $default_working_hours = c_time_to_int($default_working_hours);

		$total_time_spent = 0;
		$total_early_overtime = 0;
		$total_late_overtime = 0;
		$total_regular_hours = 0;
		$total_late_hours = 0;
		$total_hours = 0;
		$total_night_differential = 0;
		$earliest_time_in = 86340;
		$latest_time_out = 0;
		$special_holiday_hours = 0;
		$regular_holiday_hours = 0;
		$break = 0;
		$total_under_time = 0;

		$default_time_in = c_time_to_int($default_time_in);
		$default_time_out = c_time_to_int($default_time_out);
		$time_rec = null;


		$night_differential_pm = c_time_to_int("11:00 PM");
		$night_differential_am = c_time_to_int("6:00 AM");

		/* BREAK COMPUTATION */
		if($data["employee_information"]->payroll_group_is_flexi_break == 1)
		{
			$break = $data["employee_information"]->payroll_group_flexi_break * 60;
		}

		/* CHECK EACH TIME */
		foreach($_time_record as $key => $time_record)
		{
			/* CHECK IF COMPUTE APPROVED OR THE PENDING */
			if($compute_approved == 1)
			{
				$time_in = c_time_to_int($time_record->payroll_time_sheet_approved_in);
				$time_out = c_time_to_int($time_record->payroll_time_sheet_approved_out);
			}
			else
			{
				$time_in = c_time_to_int($time_record->payroll_time_sheet_in);
				$time_out = c_time_to_int($time_record->payroll_time_sheet_out);
			}


			if($time_in == 0) //SET BOTH TO BLANK IF TIME IN HAS NO INPUT
			{
				$time_rec[$key]["time_in"] = "";
				$time_rec[$key]["time_out"] = "";
			}
			else
			{
				$time_rec[$key]["time_in"] = convert_seconds_to_hours_minutes("h:i A", $time_in);
				$time_rec[$key]["time_out"] = convert_seconds_to_hours_minutes("h:i A", $time_out);
			}


			/* BREAK COMPUTATION - IF BREAK IS IN STRICT MODE */
			if($data["employee_information"]->payroll_group_is_flexi_break == 0) //IF BREAK IS STRICT 
			{
				$start_break = c_time_to_int($data["employee_information"]->payroll_group_break_start);
				$end_break = c_time_to_int($data["employee_information"]->payroll_group_break_end);

				/* CHECK IF BREAK IS WITHIN TIME RANGE */
				if(($time_in <= $start_break) && ($start_break <= $time_out))
				{
					if(($time_in <= $end_break) && ($end_break <= $time_out)) //BOTH TIME IN AND TIME OUT IS WITHIN RANGE
					{
						$break += $end_break - $start_break;
					}
					else
					{
						$break += $time_out - $start_break;
					}
				}
				elseif(($time_in <= $end_break) && ($end_break <= $time_out)) //CHECK IF BREAK OUT IS WITHIN TIME RANGE
				{
					$break += $end_break - $time_in;
				}
			}


			$early_overtime = 0;
			$late_overtime = 0;
			$night_differential = 0;

			/* GET EARLIEST TIME IN - USE FOR LATE */
			if($earliest_time_in > $time_in)
			{
				$earliest_time_in = $time_in;
			}

			/* GET LATEST TIME OUT - USE FOR UNDER TIME */
			if($latest_time_out < $time_out)
			{
				$latest_time_out = $time_out;
			}

			/* IF TIMEOUT HAPPENS BEFORE TIME IN - SET TIME SPENT TO ZERO */
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
			if($time_in < $default_time_in && $time_out != 0)
			{
				if($time_out < $default_time_in)
				{
					$early_overtime = $time_out - $time_in;
					$regular_hours = 0;
				}
				else
				{
					$early_overtime = $default_time_in - $time_in;
					$regular_hours = $regular_hours - $early_overtime;
				}
			}

			/* CHECK IF LATE OVERTIME */
			if($time_out > $default_time_out && $time_out != 0)
			{
				if($time_in > $default_time_out)
				{
					$late_overtime = $time_out - $time_in;
					$regular_hours = 0;
				}
				else
				{
					$late_overtime = $time_out - $default_time_out;
					$regular_hours = $regular_hours - $late_overtime;
				}
			}

			/* CHECK IF NIGHT DIFFERENTIAL SCENARIO 1 (Later than 11:00 PM) */
			if($time_out > $night_differential_pm)
			{
				
				if($time_in > $night_differential_pm)
				{
					$night_differential = $time_out - $time_in;
				}
				else
				{
					$night_differential = $time_out - $night_differential_pm;
				}
			}

			/* CHECK IF NIGHT DIFFERENTIAL SCENARIO 1 (Earlier than 06:00 AM) */
			if($time_in < $night_differential_am)
			{
				if($time_out < $night_differential_am)
				{
					$night_differential = $time_out - $time_in;
				}
				else
				{
					$night_differential = $night_differential_am - $time_in;
				}
			}


			$total_night_differential += $night_differential;
			$total_early_overtime += $early_overtime;
			$total_late_overtime += $late_overtime;
			$total_regular_hours += $regular_hours;
			$total_time_spent += $time_spent;
		}

		/* CLEARLY EARLIEST TIME IN IF TIME RECORD IS NULL */
		if($time_rec == null)
		{
			$earliest_time_in = 0;
		}

		/* IF TOTAL TIME SPENT IS LESS THAN ZERO - SET IT TO ZERO */
		if($total_time_spent <= 0)
		{
			$total_time_spent = 0;
		}
		else
		{
			//IF BREAK IS GREATER THAN REGULAR HOURS - SET REGULAR HOURS TO ZERO
			if($break > $total_regular_hours)
			{
				$total_regular_hours = 0;
			}
			else
			{
				$total_regular_hours = $total_regular_hours - $break;
			}
		}

		/* COMPUTE LATE BASED ON EARLIEST TIME IN */
		if($default_time_in < $earliest_time_in)
		{
			$total_late_hours = $earliest_time_in - $default_time_in;

			if($total_late_hours <= $late_grace_time)
			{
				$total_late_hours = 0;
			}
		}
		else
		{
			$total_late_hours = 0;
		}

		/* COMPUTE UNDER TIME BASED ON OLDEST TIME */
		if($default_time_out > $latest_time_out && $latest_time_out != 0)
		{
			$total_under_time = $default_time_out - $latest_time_out;
		}
		else
		{
			$total_under_time = 0;
		}

		$total_hours = $total_regular_hours + $total_early_overtime + $total_early_overtime;

		/* COMPUTE EXTRA DAY AND REST DAY */
		$total_rest_day_hours = 0;
		$total_extra_day_hours = 0;
		$_rest_day = Tbl_payroll_group_rest_day::where("payroll_group_id", $data["employee_information"]->payroll_group_id)->get();

		foreach($_rest_day as $rest_day)
		{
			if($rest_day->payroll_group_rest_day == Carbon::parse($data["time_sheet_info"]->payroll_time_date)->format("l"))
			{
				if($rest_day->payroll_group_rest_day_category == "rest day")
				{
					$total_rest_day_hours = $total_hours;
				}
				else
				{
					$total_extra_day_hours = $total_hours;
				}
			}
		}


		$return->time_spent = convert_seconds_to_hours_minutes("H:i", $total_time_spent);
		$return->regular_hours = convert_seconds_to_hours_minutes("H:i", $total_regular_hours);
		$return->late_overtime = convert_seconds_to_hours_minutes("H:i", $total_late_overtime);
		$return->early_overtime = convert_seconds_to_hours_minutes("H:i", $total_early_overtime);
		$return->late_hours = convert_seconds_to_hours_minutes("H:i", $total_late_hours);
		$return->under_time = convert_seconds_to_hours_minutes("H:i", $total_under_time);
		$return->rest_day_hours = convert_seconds_to_hours_minutes("H:i", $total_rest_day_hours);
		$return->extra_day_hours = convert_seconds_to_hours_minutes("H:i", $total_extra_day_hours);
		$return->total_hours = convert_seconds_to_hours_minutes("H:i", $total_hours);
		$return->night_differential = convert_seconds_to_hours_minutes("H:i", $total_night_differential);
		$return->special_holiday_hours = convert_seconds_to_hours_minutes("H:i", $special_holiday_hours);
		$return->regular_holiday_hours = convert_seconds_to_hours_minutes("H:i", $regular_holiday_hours);
		$return->break = convert_seconds_to_hours_minutes("H:i", $break);
		$return->time_record = $time_rec;
		return $return;
	}
}
