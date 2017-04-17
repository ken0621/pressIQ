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
use App\Models\Tbl_payroll_tax_period_default;
use App\Models\Tbl_payroll_company;
use App\Models\Tbl_payroll_holiday;
use App\Models\Tbl_payroll_holiday_company;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_overtime_rate;
use App\Models\Tbl_payroll_employee_salary;
use App\Models\Tbl_payroll_employee_allowance;
use App\Models\Tbl_payroll_period;
use App\Models\Tbl_payroll_record;
use App\Models\Tbl_payroll_adjustment;
use App\Models\Tbl_payroll_allowance_record;
use App\Models\Tbl_chart_account_type;
use App\Models\Tbl_payroll_entity;

use Carbon\Carbon;
use stdClass;
use DB;

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

				$payroll_tax_status_id = Tbl_payroll_tax_period::getperiod($shop_id,$tax->payroll_tax_status_id)->pluck('payroll_tax_period_id');

				$insert[$key]['shop_id'] 				= $shop_id;
				$insert[$key]['payroll_tax_status_id'] 	= $payroll_tax_status_id;
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
		$_period = Tbl_payroll_tax_period::check($shop_id)->get();
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

	public static function generate_tax_period($shop_id = 0)
	{
		$_default = Tbl_payroll_tax_period_default::get();
		$insert = array();
		foreach($_default as $default)
		{
			$count = Tbl_payroll_tax_period::where('shop_id', $shop_id)->where('payroll_tax_period',$default->payroll_tax_period)->count();

			if($count == 0)
			{
				$temp['payroll_tax_period'] = $default->payroll_tax_period;
				$temp['shop_id']			= $shop_id;
				array_push($insert, $temp);
			}
		}
		if(!empty($insert))
		{
			Tbl_payroll_tax_period::insert($insert);
		}
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

	/* GET HEIRARCHICAL COMPANY */
	public static function company_heirarchy($shop_id = 0)
	{
		$data = array();
		$_parent = Tbl_payroll_company::selcompany($shop_id)->where('payroll_parent_company_id',0)->orderBy('payroll_company_name')->get();

		foreach($_parent as $parent)
		{
			$temp['company'] = $parent;
			$temp['branch'] = Tbl_payroll_company::selcompany($shop_id)->where('payroll_parent_company_id', $parent->payroll_company_id)->orderBy('payroll_company_name')->get();
			array_push($data, $temp);
		}

		return $data;

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

		$data["time_sheet_info"] = array();
		$time_sheet_info = Tbl_payroll_time_sheet::where("payroll_time_date", Carbon::parse($date)->format("Y-m-d"))->where("payroll_employee_id", $employee_id)->first();

		if(!empty($time_sheet_info))
		{
			$data["time_sheet_info"] = $time_sheet_info;
		}

		// else  {
		// 	$data["time_sheet_info"] = new stdClass();
		// 	$data["time_sheet_info"]->payroll_time_date;
		// }

		$data["employee_information"] = $employee_information = Tbl_payroll_employee_contract::selemployee($employee_id)->leftJoin("tbl_payroll_group", "tbl_payroll_group.payroll_group_id", "=","tbl_payroll_employee_contract.payroll_group_id")->first();
		// dd($time_sheet_info);
		/* GET HOLIDAY PER COMPANY */
		$payroll_company_id = Tbl_payroll_employee_basic::where('payroll_employee_id', $employee_id)->pluck('payroll_employee_company_id');

		$data['holiday']	= Tbl_payroll_holiday_company::getholiday($payroll_company_id, $date)->select('tbl_payroll_holiday.*')->first();

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

		$payroll_time_sheet_approved = 0;
		if(isset($time_sheet_info->payroll_time_sheet_approved))
		{
			$payroll_time_sheet_approved = $time_sheet_info->payroll_time_sheet_approved;
		}


		
		$payroll_time_sheet_id = 0;
		if(isset($time_sheet_info->payroll_time_sheet_id))
		{
			$payroll_time_sheet_id = $time_sheet_info->payroll_time_sheet_id;
		}

		$data["_time_record"] = Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $payroll_time_sheet_id)->get();
		

		$return = new stdClass();
		/* GET OTHER DETAILS BASED ON RECORD */
		switch($data["time_rule"])
		{
			case "flexitime": 
				//$return = Payroll::process_time_flexitime($time_rule, $default_time_in, $default_time_out, $_time_record, $break, $default_working_hours);
			break;
			case "regulartime":
				$data["compute_approved"] = 0;
				$return->pending_timesheet = Payroll::process_time_regulartime($data, $date);
				$data["compute_approved"] = 1;
				$return->approved_timesheet = Payroll::process_time_regulartime($data, $date);
			break;
		}

		$payroll_time_date = '0000-00-00';
		if(isset($time_sheet_info->payroll_time_date))
		{
			$payroll_time_date = $time_sheet_info->payroll_time_date;
		}

		$return->payroll_time_sheet_id = $payroll_time_sheet_id;
		$return->date = $payroll_time_date;
		$return->payroll_time_sheet_approved = $payroll_time_sheet_approved;

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

	public static function process_time_regulartime($data, $date = '0000-00-00')
	{
		$time_rule 				= $data["time_rule"];
		$default_time_in 		= $data["default_time_in"];
		$default_time_out 		= $data["default_time_out"];
		$_time_record 			= $data["_time_record"];
		$default_working_hours 	= $data["default_working_hours"];
		$late_grace_time 		= $data["employee_information"]->payroll_group_grace_time * 60;
		$compute_approved 		= $data["compute_approved"];
		$holiday 				= $data['holiday'];

		$return = new stdClass();
		$data["default_working_hours"] = $default_working_hours = c_time_to_int($default_working_hours);

		$total_time_spent 			= 0;
		$total_early_overtime 		= 0;
		$total_late_overtime 		= 0;
		$total_regular_hours 		= 0;
		$total_late_hours 			= 0;
		$total_hours 				= 0;
		$total_night_differential 	= 0;
		$earliest_time_in 			= 86340;
		$latest_time_out 			= 0;
		$special_holiday_hours 		= 0;
		$regular_holiday_hours 		= 0;
		$break 						= 0;
		$total_under_time 			= 0;

		$default_time_in 	= c_time_to_int($default_time_in);
		$default_time_out 	= c_time_to_int($default_time_out);
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
			elseif($time_in == $time_out)
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
				$total_regular_hours = $total_regular_hours + $total_late_hours;
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

		// dd($data["time_sheet_info"]);date
		if(isset($data["time_sheet_info"]->payroll_time_date))
		{	
			$date = $data["time_sheet_info"]->payroll_time_date;
		}
		foreach($_rest_day as $rest_day)
		{
			if($rest_day->payroll_group_rest_day == Carbon::parse($date)->format("l"))
			{
				if($rest_day->payroll_group_rest_day_category == "rest day")
				{
					$total_rest_day_hours = $total_hours;
				}
				else
				{
					$total_extra_day_hours = $total_hours;
				}
				$total_regular_hours = 0;
			}
		}

		if($holiday != null || !empty($holiday))
		{
			$total_regular_hours = 0;
			if($holiday->payroll_holiday_category == 'Regular')
			{
				$regular_holiday_hours = $total_hours;
			}
			else
			{
				$special_holiday_hours = $total_hours;
			}
		}


		$return->time_spent 		= convert_seconds_to_hours_minutes("H:i", $total_time_spent);
		$return->regular_hours 		= convert_seconds_to_hours_minutes("H:i", $total_regular_hours);
		$return->late_overtime 		= convert_seconds_to_hours_minutes("H:i", $total_late_overtime);
		$return->early_overtime 	= convert_seconds_to_hours_minutes("H:i", $total_early_overtime);
		$return->late_hours 		= convert_seconds_to_hours_minutes("H:i", $total_late_hours);
		$return->under_time 		= convert_seconds_to_hours_minutes("H:i", $total_under_time);
		$return->rest_day_hours 	= convert_seconds_to_hours_minutes("H:i", $total_rest_day_hours);
		$return->extra_day_hours 	= convert_seconds_to_hours_minutes("H:i", $total_extra_day_hours);
		$return->total_hours 		= convert_seconds_to_hours_minutes("H:i", $total_hours);
		$return->night_differential = convert_seconds_to_hours_minutes("H:i", $total_night_differential);
		$return->special_holiday_hours = convert_seconds_to_hours_minutes("H:i", $special_holiday_hours);
		$return->regular_holiday_hours = convert_seconds_to_hours_minutes("H:i", $regular_holiday_hours);
		$return->break 				= convert_seconds_to_hours_minutes("H:i", $break);
		$return->time_record 		= $time_rec;

		return $return;
	}

	public static function sum_time($time_1 = '00:00', $time_2 = '00:00')
	{
		$extime1 = explode(':', $time_1);
		$extime2 = explode(':', $time_2);

		$hour = $extime1[0] + $extime2[0];
		$min = 0;
		if(isset($extime1[1]) && isset($extime2[1]))
		{
			$min = $extime1[1] + $extime2[1];
		}

		return Payroll::return_time($hour, $min);
	}

	public static function return_time($hour = 0, $min = 0)
	{

		if($min >= 60)
		{	
			$min = $min - 60;
			$hour++;
		}

		if($min <= 9)
		{
			$min = '0'.$min;
		}
		if($hour <= 9)
		{
			$hour = '0'.$hour;
		}

		return $hour.':'.$min;
	}

	public static function if_zero_time($time = '00:00')
	{
		if($time == '00:00')
		{
			$time = '--:--';
		}
		return $time;
	}

	public static function if_zero($value = 0)
	{
		if($value <= 0)
		{
			$value = '--';
		}
		else
		{
			$value = number_format($value,2);
		}
		return $value;
	}

	public static function time_float($time = '00:00')
	{
		$extime = explode(':', $time);
		$hour = $extime[0];
		$min = $extime[1] / 60;
		return $hour + $min;
	}

	public static function float_time($float = 0)
	{
		// if(is_numeric($float))
		// {
		// 	$hour = intval($float);
		// 	$min = round(($float - $hour) * 60);
		// 	return Payroll::return_time($hour, $min);
		// }
		// else
		// {
		// 	return $float;
		// }
		$hour = intval($float);
		$min = round(($float - $hour) * 60);
		return Payroll::return_time($hour, $min);
		
	}

	public static function process_compute($shop_id = 0, $status = 'processed')
	{
		$data = array();

		$_period = Tbl_payroll_period_company::period($shop_id, $status)
                                                       ->orderBy('.tbl_payroll_period.payroll_period_category')
                                                       ->orderBy('tbl_payroll_period.payroll_period_start')
                                                       ->get();
        foreach($_period as $period)
        {
        	
			array_push($data, Payroll::company_period($period, $shop_id));
        }

        return $data;
	}

	public static function company_period($period = array(), $shop_id = 0)
	{
		$payroll_period_category = $period->payroll_period_category;
    	$payroll_company_id = $period->payroll_company_id;
    	// dd($period);
    	$_employee = Tbl_payroll_employee_contract::employeefilter($payroll_company_id, 0, 0, $period->payroll_period_end, $shop_id)
						->join('tbl_payroll_group','tbl_payroll_group.payroll_group_id','=','tbl_payroll_employee_contract.payroll_group_id')
						->where('tbl_payroll_group.payroll_group_period', $payroll_period_category)
						->get();
		$start 	= $period->payroll_period_start;
		$end 	= $period->payroll_period_end;

		$temp_period['period'] 			= $period;
		$temp_period['total_gross'] 	= 0;
		$temp_period['total_deduction'] = 0;
		$temp_period['total_net'] 		= 0;
		$temp_period['_list']			= array();

		foreach($_employee as $employee)
		{

			$compute = Payroll::compute_per_employee($employee->payroll_employee_id, $start, $end, $shop_id, $payroll_period_category, $period->payroll_period_company_id);

			$temp['compute']						= $compute;
			$temp['payroll_employee_id'] 			= $employee->payroll_employee_id;
			$temp['payroll_employee_first_name'] 	= $employee->payroll_employee_first_name;
			$temp['payroll_employee_middle_name'] 	= $employee->payroll_employee_middle_name;
			$temp['payroll_employee_last_name'] 	= $employee->payroll_employee_last_name;
			$temp['payroll_employee_suffix_name'] 	= $employee->payroll_employee_suffix_name;
			$temp['payroll_employee_display_name'] 	= $employee->payroll_employee_display_name;
			$temp['total_gross'] 					= $compute['total_gross'];
			$temp['total_deduction'] 				= $compute['total_deduction'];
			$temp['total_net'] 						= $compute['total_net'];

			$temp_period['total_gross'] 			+= $compute['total_gross'];
			$temp_period['total_deduction'] 		+= $compute['total_deduction'];
			$temp_period['total_net'] 				+= $compute['total_net'];

			array_push($temp_period['_list'], $temp);
		}	


		return $temp_period;
	}

	public static function compute_per_employee($employee_id, $start = '0000-00-00', $end = '0000-00-00', $shop_id = 0, $payroll_period_category = '', $payroll_period_company_id = 0)
	{
		$period_category_arr = Payroll::getperiodcount($shop_id, $end, $payroll_period_category);

		$period_category = $period_category_arr['period_category'];

		$basic_employee  = Tbl_payroll_employee_basic::where('payroll_employee_id',$employee_id)->first();

		$total_hours_render					= 0;

		$data['payroll_employee_id']		= $employee_id;
		$data['payroll_period_company_id']	= $payroll_period_company_id;
		$data['tax_status']					= $basic_employee->payroll_employee_tax_status;
		$data['salary_taxable'] 			= 0;
		$data['salary_sss'] 				= 0;
		$data['salary_pagibig'] 			= 0;
		$data['salary_philhealth'] 			= 0;

		$data['tax_contribution']			= 0;
		$data['sss_contribution_ee']		= 0;
		$data['sss_contribution_er']		= 0;
		$data['sss_contribution_ec']		= 0;
		$data['pagibig_contribution']		= 0;
		$data['philhealth_contribution_ee']	= 0;
		$data['philhealth_contribution_er']	= 0;

		$data['payroll_cola']				= 0;

		$data['extra_salary']				= 0;
		$data['extra_early_overtime'] 		= 0;
		$data['extra_reg_overtime'] 		= 0;
		$data['extra_night_diff'] 			= 0;

		$data['regular_salary'] 			= 0;
		$data['regular_early_overtime'] 	= 0;
		$data['regular_reg_overtime'] 		= 0;
		$data['regular_night_diff'] 		= 0;

		$data['rest_day_salary'] 			= 0;
		$data['rest_day_early_overtime']	= 0;
		$data['rest_day_reg_overtime'] 		= 0;
		$data['rest_day_night_diff'] 		= 0;

		$data['rest_day_sh'] 				= 0;
		$data['rest_day_sh_early_overtime'] = 0;
		$data['rest_day_sh_reg_overtime'] 	= 0;
		$data['rest_day_sh_night_diff'] 	= 0;

		$data['rest_day_rh'] 				= 0;
		$data['rest_day_rh_early_overtime'] = 0;
		$data['rest_day_rh_reg_overtime'] 	= 0;
		$data['rest_day_rh_night_diff'] 	= 0;

		$data['rh_salary'] 					= 0;
		$data['rh_early_overtime'] 			= 0;
		$data['rh_reg_overtime'] 			= 0;
		$data['rh_night_diff'] 				= 0;

		$data['sh_salary'] 					= 0;
		$data['sh_early_overtime'] 			= 0;
		$data['sh_reg_overtime'] 			= 0;
		$data['sh_night_diff'] 				= 0;

		$data['13_month']					= 0;
		$data['13_month_computed'] 			= 1;
		
		$data['total_allowance']			= 0;
		$data['allowance']					= array();

		$data['deduction']					= array();
		
		$data['late_deduction'] 			= 0;
		$data['under_time']					= 0;
		$data['agency_deduction'] 			= 0;

		$data['total_net']					= 0;
		$data['total_gross']				= 0;
		$data['total_deduction']			= 0;

		$data['regular_hours']				= 0;
		$data['late_overtime']				= 0;
		$data['early_overtime']				= 0;
		$data['late_hours']					= 0;
		$data['under_time_hours']			= 0;
		$data['rest_day_hours']				= 0;
		$data['extra_day_hours']			= 0;
		$data['total_hours']				= 0;
		$data['night_differential']			= 0;
		$data['special_holiday_hours']		= 0;
		$data['regular_holiday_hours']		= 0;

		$data['total_regular_days']			= 0;
		$data['total_rest_days']			= 0;
		$data['total_extra_days']			= 0;
		$data['total_rh']					= 0;
		$data['total_sh']					= 0;
		$data['total_worked_days']			= 0;

		$data['adjustment']					= array();


		$tax_status 	= Tbl_payroll_employee_basic::where('payroll_employee_id', $employee_id)->pluck('payroll_employee_tax_status');

		$group = array();

		/* fixed allowances */
		$_allowance_fixed = Tbl_payroll_employee_allowance::employee_allowance($employee_id,'fixed')
														->orderBy('tbl_payroll_allowance.payroll_allowance_name')
														->select('tbl_payroll_allowance.*')
														->get();

		/* daily allowances */	
		$_allowance_daily = Tbl_payroll_employee_allowance::employee_allowance($employee_id,'daily')
														->orderBy('tbl_payroll_allowance.payroll_allowance_name')
														->select('tbl_payroll_allowance.*')
														->get();


		while($start <= $end)
		{
			$date = Carbon::parse($start)->format("Y-m-d"); 

			$time = Payroll::process_time($employee_id, $date);

			$count_rh = Tbl_payroll_holiday_company::getholiday($basic_employee->payroll_employee_company_id, $date)
													->where('tbl_payroll_holiday.payroll_holiday_category','Regular')
													->count();

			$approved = $time->approved_timesheet;

			$temp_hour 					= 0;

			$regular_hours 				= Payroll::time_float($approved->regular_hours);
			$late_overtime 				= Payroll::time_float($approved->late_overtime);
			$early_overtime 			= Payroll::time_float($approved->early_overtime);
			$late_hours 				= Payroll::time_float($approved->late_hours);
			$under_time 				= Payroll::time_float($approved->under_time);
			$rest_day_hours 			= Payroll::time_float($approved->rest_day_hours);
			$extra_day_hours 			= Payroll::time_float($approved->extra_day_hours);
			$total_hours 				= Payroll::time_float($approved->total_hours);
			$night_differential 		= Payroll::time_float($approved->night_differential);
			$special_holiday_hours 		= Payroll::time_float($approved->special_holiday_hours);
			$regular_holiday_hours 		= Payroll::time_float($approved->regular_holiday_hours);


			$data['regular_hours']				+= $regular_hours;
			$data['late_overtime']				+= $late_overtime;
			$data['early_overtime']				+= $early_overtime;
			$data['late_hours']					+= $late_hours;
			$data['under_time_hours']			+= $under_time;
			$data['rest_day_hours']				+= $rest_day_hours;
			$data['extra_day_hours']			+= $extra_day_hours;
			$data['total_hours']				+= $total_hours;
			$data['night_differential']			+= $night_differential;
			$data['special_holiday_hours']		+= $special_holiday_hours;
			$data['regular_holiday_hours']		+= $regular_holiday_hours;



			/* EMPLOYEE SALARY */
			$salary = Tbl_payroll_employee_salary::selemployee($employee_id, $date)->where('payroll_employee_salary_archived',0)->first();

			$data['minimum_wage'] 			= 0;
			$data['salary_monthly'] 		= 0;
			$data['salary_daily'] 			= 0;
			$data['salary_taxable'] 		= 0;
			$data['salary_sss'] 			= 0;
			$data['salary_pagibig'] 		= 0;
			$data['salary_philhealth'] 		= 0;

			$cola 							= 0;

			if(isset($salary->payroll_employee_salary_minimum_wage))
			{
				$data['minimum_wage'] 		= $salary->payroll_employee_salary_minimum_wage;
				$data['salary_monthly'] 	= $salary->payroll_employee_salary_monthly;
				$data['salary_daily'] 		= $salary->payroll_employee_salary_daily;
				$data['salary_taxable'] 	= $salary->payroll_employee_salary_taxable;
				$data['salary_sss'] 		= $salary->payroll_employee_salary_sss;
				$data['salary_pagibig'] 	= $salary->payroll_employee_salary_pagibig;
				$data['salary_philhealth'] 	= $salary->payroll_employee_salary_philhealth;
				$cola 						= $salary->payroll_employee_salary_cola;
			}

			
			$group = Tbl_payroll_employee_contract::selemployee($employee_id, $date)
												   ->join('tbl_payroll_group','tbl_payroll_group.payroll_group_id','=','tbl_payroll_employee_contract.payroll_group_id')
												   ->select('tbl_payroll_group.*')
												   ->first();


			$working_day_month = $group->payroll_group_working_day_month;

			$target_hour = $group->payroll_group_target_hour;

			if($group->payroll_group_is_flexi_time == 1 && $group->payroll_group_target_hour_parameter == 'Per Period')
			{
				$target_hour = $group->payroll_group_target_hour / $group->payroll_group_working_day_month;
			}

			$data['total_regular_days']			+= divide($regular_hours, $target_hour);
			$data['total_rest_days']			+= divide($rest_day_hours, $target_hour);
			$data['total_extra_days']			+= divide($extra_day_hours, $target_hour);
			$data['total_rh']					+= divide($special_holiday_hours, $target_hour);
			$data['total_sh']					+= divide($regular_holiday_hours, $target_hour);

			$daily_rate = $data['salary_monthly'] / $working_day_month;

			/* PAYROLL OVER TIME RATES */
			$query_arr['payroll_group_id'] 				= $group->payroll_group_id;
			$query_arr['payroll_overtime_name'] 		= 'Regular';

			/* REGULAR DAYS */
			$regular_hour['regular'] 					= 0;
			$regular_hour['late_overtime'] 				= 0;
			$regular_hour['early_overtime'] 			= 0;
			$regular_hour['night_differential']  		= 0;

			$rest_reg_hour['regular']					= 0;
			$rest_reg_hour['late_overtime'] 			= 0;
			$rest_reg_hour['early_overtime'] 			= 0;
			$rest_reg_hour['night_differential']  		= 0;

			$extra_hour['regular'] 						= 0;
			$extra_hour['late_overtime'] 				= 0;
			$extra_hour['early_overtime'] 				= 0;
			$extra_hour['night_differential']  			= 0;

			$sh_hour['regular'] 						= 0;
			$sh_hour['late_overtime'] 					= 0;
			$sh_hour['early_overtime'] 					= 0;
			$sh_hour['night_differential']  			= 0;

			$sh_rest_hour['regular'] 					= 0;
			$sh_rest_hour['late_overtime'] 				= 0;
			$sh_rest_hour['early_overtime'] 			= 0;
			$sh_rest_hour['night_differential'] 		= 0;

			$rh_hour['regular'] 						= 0;
			$rh_hour['late_overtime'] 					= 0;
			$rh_hour['early_overtime'] 					= 0;
			$rh_hour['night_differential'] 				= 0;

			$rh_rest_hour['regular'] 					= 0;
			$rh_rest_hour['late_overtime'] 				= 0;
			$rh_rest_hour['early_overtime'] 			= 0;
			$rh_rest_hour['night_differential'] 		= 0;


			/* for legal holiday if not rest day */
			if($rest_day_hours <= 0 && $count_rh > 0)
			{
				$rh_hour['regular'] = $count_rh;
			}

			/* EXTRA DAYS */
			if($extra_day_hours > 0 && $regular_hour <= 0 && $special_holiday_hours <= 0 && $regular_holiday_hours <= 0)
			{
				$temp_hour								= $extra_day_hours;
				$extra_hour['regular'] 					= divide($extra_day_hours, $target_hour);
				$extra_hour['late_overtime'] 			= divide($late_overtime, $target_hour);
				$extra_hour['early_overtime'] 			= divide($early_overtime, $target_hour);
				$extra_hour['night_differential']  		= divide($night_differential, $target_hour);
				// $extra_hour['cola']						= $cola;
				$query_arr['payroll_overtime_name'] 	= 'Regular';
			}

			/* REGULAR DAYS */
			if($regular_hours > 0 && $rest_day_hours <= 0 && $special_holiday_hours <= 0 && $regular_holiday_hours <= 0)
			{
				$temp_hour								= $regular_hours;
				$regular_hour['regular'] 				= divide($regular_hours, $target_hour);
				$regular_hour['late_overtime'] 			= divide($late_overtime, $target_hour);
				$regular_hour['early_overtime'] 		= divide($early_overtime, $target_hour);
				$regular_hour['night_differential']  	= divide($night_differential, $target_hour);
				// $regular_hour['cola']					= $cola;
				$query_arr['payroll_overtime_name'] 	= 'Regular';
			}

			/* SPECIAL HOLIDAY */

			if($regular_hours <= 0 && $rest_day_hours > 0 && $special_holiday_hours <= 0 && $regular_holiday_hours <= 0)
			{
				$rest_reg_hour['regular']				= divide($rest_day_hours, $target_hour);
				$rest_reg_hour['late_overtime']			= divide($late_overtime, $target_hour);
				$rest_reg_hour['early_overtime'] 		= divide($early_overtime, $target_hour);
				$rest_reg_hour['night_differential']  	= divide($night_differential, $target_hour);
				// $rest_reg_hour['cola']					= $cola;

				$query_arr['payroll_overtime_name'] 	= 'Regular';
				
				$temp_hour								= $rest_day_hours;
			}
			
			/* LEGAL HOLIDAY */
			if($regular_hours <= 0 && $rest_day_hours <= 0 && $special_holiday_hours > 0 && $regular_holiday_hours <= 0)
			{
				$sh_hour['regular'] 					= divide($special_holiday_hours, $target_hour);
				$sh_hour['late_overtime'] 				= divide($late_overtime, $target_hour);
				$sh_hour['early_overtime'] 				= divide($early_overtime, $target_hour);
				$sh_hour['night_differential']  		= divide($night_differential, $target_hour);
				// $sh_hour['cola']						= $cola;
				$query_arr['payroll_overtime_name'] 	= 'Special Holiday';
				$temp_hour								= $special_holiday_hours;

			}


			if($regular_hours <= 0 && $rest_day_hours > 0 && $special_holiday_hours > 0 && $regular_holiday_hours <= 0)
			{
				$sh_rest_hour['regular'] 				= divide($rest_day_hours, $target_hour);
				$sh_rest_hour['late_overtime'] 			= divide($late_overtime, $target_hour);
				$sh_rest_hour['early_overtime'] 		= divide($early_overtime, $target_hour);
				$sh_rest_hour['night_differential'] 	= divide($night_differential, $target_hour);
				// $sh_rest_hour['cola']					= $cola;
				$query_arr['payroll_overtime_name'] 	= 'Special Holiday';
				$temp_hour								= $rest_day_hours;
			}
			
			if($regular_hours <= 0 && $rest_day_hours <= 0 && $special_holiday_hours <= 0 && $regular_holiday_hours > 0)
			{
				$rh_hour['regular'] 					= divide($regular_holiday_hours, $target_hour);
				$rh_hour['late_overtime'] 				= divide($late_overtime, $target_hour);
				$rh_hour['early_overtime'] 				= divide($early_overtime, $target_hour);
				$rh_hour['night_differential'] 			= divide($night_differential, $target_hour);
				// $rh_hour['cola']						= $cola;
				$query_arr['payroll_overtime_name'] 	= 'Legal Holiday';
				$temp_hour								= $regular_holiday_hours;

			}

			if($regular_hours <= 0 && $rest_day_hours > 0 && $special_holiday_hours <= 0 && $regular_holiday_hours > 0)
			{

				$rh_rest_hour['regular'] 				= divide($rest_day_hours, $target_hour);
				$rh_rest_hour['late_overtime'] 			= divide($late_overtime, $target_hour);
				$rh_rest_hour['early_overtime'] 		= divide($early_overtime, $target_hour);
				$rh_rest_hour['night_differential'] 	= divide($night_differential, $target_hour);
				// $rh_rest_hour['cola']					= $cola;
				$query_arr['payroll_overtime_name'] 	= 'Legal Holiday';
				$temp_hour								= $rest_day_hours;

			}
			// dd($rh_hour);
			$regular_day = Payroll::compute_overtime($query_arr, $regular_hour, $daily_rate, 'Regular', $cola);

			$regular_day_rest = Payroll::compute_overtime($query_arr, $rest_reg_hour, $daily_rate, 'Rest Regular', $cola);

			$extra_day = Payroll::compute_overtime($query_arr, $extra_hour, $daily_rate, 'Extra', $cola);

			$legal_holiday = Payroll::compute_overtime($query_arr, $rh_hour, $daily_rate, 'Legal Holiday', $cola);
			$legal_holiday_rest = Payroll::compute_overtime($query_arr, $rh_rest_hour, $daily_rate, 'Rest Legal Holiday', $cola);
			$special_holiday = Payroll::compute_overtime($query_arr, $sh_hour, $daily_rate, 'Special Holiday', $cola);
			$special_holiday_rest = Payroll::compute_overtime($query_arr, $sh_rest_hour, $daily_rate, 'Rest Special Holiday', $cola);
			// dd($legal_holiday);

			/* ALLOWANCE DAILY START */
			$total_hours_render += $regular_hours + $rest_day_hours + $extra_day_hours + $special_holiday_hours + $regular_holiday_hours;

			if(($regular_hours + $rest_day_hours + $extra_day_hours + $special_holiday_hours + $regular_holiday_hours) > 0)
			{
				foreach($_allowance_daily as $key => $daily_allowance)
				{
					$data['allowance'] = Payroll::push_allowance($data['allowance'], $daily_allowance, $payroll_period_category, $period_category);
				}
			}

			/* ALLOWANCE DAILY END */

			$data['extra_salary']				+= $extra_day['regular'];
			$data['extra_early_overtime'] 		+= $extra_day['early_overtime'];
			$data['extra_reg_overtime'] 		+= $extra_day['late_overtime'];
			$data['extra_night_diff'] 			+= $extra_day['night_differential'];

			$data['regular_salary'] 			+= $regular_day['regular'];
			$data['regular_early_overtime'] 	+= $regular_day['early_overtime'];
			$data['regular_reg_overtime'] 		+= $regular_day['late_overtime'];
			$data['regular_night_diff'] 		+= $regular_day['night_differential'];

			$data['rest_day_salary'] 			+= $regular_day_rest['regular'];
			$data['rest_day_early_overtime']	+= $regular_day_rest['early_overtime'];
			$data['rest_day_reg_overtime'] 		+= $regular_day_rest['late_overtime'];
			$data['rest_day_night_diff'] 		+= $regular_day_rest['night_differential'];

			$data['rest_day_sh'] 				+= $special_holiday_rest['regular'];
			$data['rest_day_sh_early_overtime'] += $special_holiday_rest['early_overtime'];
			$data['rest_day_sh_reg_overtime'] 	+= $special_holiday_rest['late_overtime'];
			$data['rest_day_sh_night_diff'] 	+= $special_holiday_rest['night_differential'];

			$data['rest_day_rh'] 				+= $legal_holiday_rest['regular'];
			$data['rest_day_rh_early_overtime'] += $legal_holiday_rest['early_overtime'];
			$data['rest_day_rh_reg_overtime'] 	+= $legal_holiday_rest['late_overtime'];
			$data['rest_day_rh_night_diff'] 	+= $legal_holiday_rest['night_differential'];

			$data['rh_salary'] 					+= $legal_holiday['regular'];
			$data['rh_early_overtime'] 			+= $legal_holiday['early_overtime'];
			$data['rh_reg_overtime'] 			+= $legal_holiday['late_overtime'];
			$data['rh_night_diff'] 				+= $legal_holiday['night_differential'];

			$data['sh_salary'] 					+= $special_holiday['regular'];
			$data['sh_early_overtime'] 			+= $special_holiday['early_overtime'];
			$data['sh_reg_overtime'] 			+= $special_holiday['late_overtime'];
			$data['sh_night_diff'] 				+= $special_holiday['night_differential'];


			$data['payroll_cola']				+= $extra_day['cola'] + $regular_day['cola'] + $regular_day_rest['cola'] + $special_holiday_rest['cola'] + $legal_holiday_rest['cola'] + $legal_holiday['cola'] + $special_holiday['cola'];


			/* LATE COMPUTATION START */

			$late_deduction = 0;

			if($group->payroll_late_category == 'Custom')
			{	
				$interval 				= $group->payroll_late_interval;
				$parameter 				= $group->payroll_late_parameter;
				$payroll_late_deduction = $group->payroll_late_deduction;

				if($parameter == 'Second')
				{
					$late_hours = ($late_hours * 60) * 60;
				}
				else if($parameter == 'Minute')
				{
					$late_hours = $late_hours * 60;
				}

				$interval = intval(divide($late_hours, $intval));

				$late_deduction = $interval * $payroll_late_deduction;
			}
			else if($group->payroll_late_category == 'Base on Salary')
			{
				$late_deduction = $late_hours * $daily_rate;
			}

			$data['under_time'] = $under_time * $daily_rate;

			$data['late_deduction']	+= round($late_deduction, 2);

			$start = Carbon::parse($start)->addDay()->format("Y-m-d");

		}

		$data['total_gross'] += ($data['extra_salary'] + $data['extra_early_overtime'] + $data['extra_reg_overtime'] + $data['extra_night_diff'] + $data['regular_salary'] + $data['regular_early_overtime'] + $data['regular_reg_overtime'] + $data['regular_night_diff'] + $data['rest_day_salary'] + $data['rest_day_early_overtime'] + $data['rest_day_reg_overtime'] + $data['rest_day_night_diff'] + $data['rest_day_sh'] + $data['rest_day_sh_early_overtime'] + $data['rest_day_sh_reg_overtime'] + $data['rest_day_sh_night_diff'] + $data['rest_day_rh'] + $data['rest_day_rh_early_overtime'] + $data['rest_day_rh_reg_overtime'] + $data['rest_day_rh_night_diff'] + $data['rh_salary'] + $data['rh_early_overtime'] + $data['rh_reg_overtime'] + $data['rh_night_diff'] + $data['sh_salary'] + $data['sh_early_overtime'] + $data['sh_reg_overtime'] + $data['sh_night_diff']);

		$data['total_gross'] += $data['payroll_cola'];
// 		employee_id
// payroll_period_company_id
		/* PAYROLL ADJUSTMEMT START */
		/* bonus */
		$adjustment_bonus = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id, 'Bonus')->get();

		$adjustment_bonus_total = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id , 'Bonus')->sum('payroll_adjustment_amount');
		
		/* commission */
		$adjustment_commission = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id, 'Commissions')->get();

		$adjustment_commission_total = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id , 'Commissions')->sum('payroll_adjustment_amount');

		/* incentives */
		$adjustment_incentives = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id, 'Incentives')->get();

		$adjustment_incentives_total = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id , 'Incentives')->sum('payroll_adjustment_amount');

		/* deductions */
		$adjustment_deductions = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id, 'Deductions')->get();

		$adjustment_deductions_total = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id , 'Deductions')->sum('payroll_adjustment_amount');

		$data['adjustment']['bonus'] 				= $adjustment_bonus;
		$data['adjustment']['total_bonus'] 			= $adjustment_bonus_total;

		$data['adjustment']['incentives'] 			= $adjustment_incentives;
		$data['adjustment']['total_incentives'] 	= $adjustment_incentives_total;

		$data['adjustment']['commission'] 			= $adjustment_commission;
		$data['adjustment']['total_commission'] 	= $adjustment_commission_total;

		$data['adjustment']['deductions'] 			= $adjustment_deductions;
		$data['adjustment']['total_deductions'] 	= $adjustment_deductions_total;

		/* PAYROLL ADJUSTMENT END */


		

		if(isset($group->payroll_group_13month_basis))
		{
			if($group->payroll_group_13month_basis == 'Periodically')
			{
				$data['13_month'] = round(($data['regular_salary'] / 12), 2);
				$data['13_month_computed'] = 1;
			}
		}

		$data['total_gross'] += $data['13_month'];

		if($total_hours_render > 0)
		{	
			foreach($_allowance_fixed as $key => $fixed_allowance)
			{
				$data['allowance'] = Payroll::push_allowance($data['allowance'], $fixed_allowance, $payroll_period_category, $period_category);
			}
		}

		if(!empty($data['allowance']))
		{
			$_collection = collect($data['allowance'])->groupBy('payroll_allowance_id');

			$data['allowance'] 	= array();
			$temp_allowance 	= array();

			foreach($_collection as $collection)
			{
				$temp_allowance['payroll_allowance_id'] 	= $collection[0]['payroll_allowance_id'];
				$temp_allowance['payroll_allowance_name'] 	= $collection[0]['payroll_allowance_name'];
				$temp_allowance['payroll_allowance_amount'] = collect($collection)->sum('payroll_allowance_amount');

				$data['total_allowance']					+= collect($collection)->sum('payroll_allowance_amount');

				array_push($data['allowance'], $temp_allowance);
			}
		}


		$total_deminimis = collect($data['allowance'])->sum('payroll_allowance_amount') + $adjustment_bonus_total + $adjustment_commission_total + $adjustment_incentives_total;


		$data['total_deminimis'] = $total_deminimis;

		$data['total_gross'] += $total_deminimis;

		/* GET SSS CONTRIBUTION */
		$sss_contribution	= Payroll::sss_contribution($shop_id, $data['salary_sss']);
		if($group->payroll_group_sss == 'Every Period')
		{
			
			$data['sss_contribution_ee'] = divide($sss_contribution['ee'], $period_category_arr['period_count']);
			$data['sss_contribution_er'] = divide($sss_contribution['er'], $period_category_arr['period_count']);
			$data['sss_contribution_ec'] = divide($sss_contribution['ec'], $period_category_arr['period_count']);
		}
		else if($group->payroll_group_sss == Payroll::return_ave($period_category))
		{

			if(Payroll::return_ave($period_category) == '1st Period')
			{
				$data['sss_contribution_ee'] = $sss_contribution['ee'];
				$data['sss_contribution_er'] = $sss_contribution['er'];
				$data['sss_contribution_ec'] = $sss_contribution['ec'];
			}
			else if(Payroll::return_ave($period_category) == '2nd Period')
			{
				$data['sss_contribution_ee'] = divide($sss_contribution['ee'], $period_category_arr['period_count']) * 2;
				$data['sss_contribution_er'] = divide($sss_contribution['er'], $period_category_arr['period_count']) * 2;
				$data['sss_contribution_ec'] = divide($sss_contribution['ec'], $period_category_arr['period_count']) * 2;
			}
		}

		/* GET PHILHEALTH CONTRIBUTION */
		$philhealth_contribution = Payroll::philhealth_contribution($shop_id, $data['salary_philhealth']);
		if($group->payroll_group_philhealth == 'Every Period')
		{
			// philhealth_contribution
			$data['philhealth_contribution_ee'] = divide($philhealth_contribution['ee'], $period_category_arr['period_count']);
			$data['philhealth_contribution_er'] = divide($philhealth_contribution['er'] , $period_category_arr['period_count']);
			
		}
		else if($group->payroll_group_philhealth == Payroll::return_ave($period_category))
		{
			if(Payroll::return_ave($period_category) == '1st Period')
			{
				$data['philhealth_contribution_ee'] = $philhealth_contribution['ee'];
				$data['philhealth_contribution_er'] = $philhealth_contribution['er'];
			}
			else if(Payroll::return_ave($period_category) == '2nd Period')
			{
				$data['philhealth_contribution_ee'] = divide($philhealth_contribution['ee'], $period_category_arr['period_count']) * 2;
				$data['philhealth_contribution_er'] = divide($philhealth_contribution['er'], $period_category_arr['period_count']) * 2;
			}
		}


		// GET PAGIBIG CONTRIBUTION
		$pagibig_contribution = Payroll::pagibig_contribution($shop_id, $data['salary_pagibig']);
		if($group->payroll_group_pagibig == 'Every Period')
		{
			// philhealth_contribution
			$data['pagibig_contribution'] = divide($pagibig_contribution, $period_category_arr['period_count']);
		}
		else if($group->payroll_group_pagibig == Payroll::return_ave($period_category))
		{
			if(Payroll::return_ave($period_category) == '1st Period')
			{
				$data['pagibig_contribution'] = $pagibig_contribution;
				
			}
			else if(Payroll::return_ave($period_category) == '2nd Period')
			{
				$data['pagibig_contribution'] = divide($philhealth_contribution, $period_category_arr['period_count']) * 2;
			}
		}

		/* GET TAX CONTRIBUTION */
		if($data['minimum_wage'] == 1)
		{
			if($group->payroll_group_tax == 'Every Period' || $group->payroll_group_tax == $period_category)
			{
				$salary_taxable = $data['salary_taxable'] - ($data['sss_contribution_ee'] + $data['philhealth_contribution_ee'] + $data['pagibig_contribution']);
				if($salary_taxable <= 0)
				{
					$salary_taxable = 0;
				}

				$data['tax_contribution'] = divide(Payroll::tax_contribution($shop_id, $salary_taxable, $data['tax_status'], $payroll_period_category), $period_category_arr['period_count']);
				if($group->payroll_group_tax == 'Last Period')
				{
					$data['tax_contribution'] = $data['tax_contribution'] * $period_category_arr['period_count'];
				}	
			}
			
		}
		if($group->payroll_group_agency == Payroll::return_ave($period_category))
		{
			$data['agency_deduction'] = $group->payroll_group_agency_fee;
		}

		$data['total_deduction']	+= $data['tax_contribution'];
		$data['total_deduction']	+= $data['sss_contribution_ee'];
		$data['total_deduction']	+= $data['pagibig_contribution'];
		$data['total_deduction']	+= $data['philhealth_contribution_ee'];
		$data['total_deduction']	+= $data['late_deduction'];
		$data['total_deduction']	+= $data['under_time'];
		$data['total_deduction']	+= $data['agency_deduction'];
		$data['total_deduction']	+= $data['agency_deduction'];
		$data['total_deduction']	+= $data['agency_deduction'];

		// DEDUCTION START [LOANS, CASH ADVANCE, CASH BOND AND OTHER DEDUCTION]
		$deduction = Payroll::getdeduction($employee_id, $date,$period_category, $payroll_period_category, $shop_id);

		$data['deduction'] 			= $deduction['deduction'];
		$data['total_deduction'] 	+= $deduction['total_deduction'] + $adjustment_deductions_total;
		

		if($data['total_deduction'] > $data['total_gross'])
		{
			$data['total_deduction']			= 0;
			$data['tax_contribution'] 			= 0;
			$data['sss_contribution_ee'] 		= 0;
			$data['pagibig_contribution'] 		= 0;
			$data['philhealth_contribution_ee'] = 0;
			$data['late_deduction'] 			= 0;
			$data['under_time'] 				= 0;
			$data['agency_deduction'] 			= 0;
			$data['agency_deduction'] 			= 0;
			$data['agency_deduction'] 			= 0;
		}
		$data['total_net'] 			= $data['total_gross'] - $data['total_deduction'];

		$data['total_regular_days']			= round($data['total_regular_days'], 2);
		$data['total_rest_days']			= round($data['total_rest_days'], 2);
		$data['total_extra_days']			= round($data['total_extra_days'], 2);
		$data['total_rh']					= round($data['total_rh'], 2);
		$data['total_sh']					= round($data['total_sh'], 2);

		$data['total_worked_days'] = $data['total_regular_days'] + $data['total_rest_days'] + $data['total_extra_days'] + $data['total_rh'] + $data['total_sh'];
		// dd($data['allowance']);
		// dd($data);
		return $data;
	}

	public static function getperiodcount($shop_id = 0, $date = '0000-00-00', $payroll_period_category = '')
	{
		$datearr[0] 	= date('Y-m-01', strtotime($date));
		$datearr[1] 	= date('Y-m-t', strtotime($date));

		$period_category = 'None';

		$_period = Tbl_payroll_period::sel($shop_id, 0)
									->where('payroll_period_category', $payroll_period_category)
									->whereBetween('payroll_period_end', $datearr)
									->orderBy('payroll_period_end')
									->get()
									->toArray();
		$period_count = count($_period);
		$index_count = 1;
		foreach($_period as $period)
		{
			if($period['payroll_period_end'] == $date)
			{
				break;
			}
			$index_count++;
		}

		if($payroll_period_category == 'Weekly')
		{
			if($index_count  == 1)
			{
				$period_category = 'First Period';
			}
			else if($index_count == 2)
			{
				$period_category = 'Second Period';
			}
			else if($index_count == $period_count)
			{
				$period_category = 'Last Period';
			}
		}
		else if($payroll_period_category == 'Semi-monthly')
		{
			if($index_count == 1)
			{
				$period_category = 'First Period';
			}
			else if($index_count == $period_count || $index_count == 2)
			{
				$period_category = 'Last Period';
			}
		}
		else if($payroll_period_category == 'Monthly')
		{
			$period_category = 'Last Period';
		}

		$data['period_category'] = $period_category;
		$data['period_count']	 = $period_count;

		return $data;

	}

	public static function return_ave($str = '')
	{
		if($str == 'First Period')
		{
			$str = '1st Period';
		}
		else if($str == 'Second Period')
		{
			$str = '2nd Period';
		}
		return $str;
	}

	/* PUSH TO ARRAY ALLOWANCES */
	public static function push_allowance($allowance_data = array(), $allowance = array(), $payroll_period_category = '', $period_category = '')
	{
		$temp_allowance['payroll_allowance_id']		= $allowance->payroll_allowance_id;
		$temp_allowance['payroll_allowance_name'] 	= $allowance->payroll_allowance_name;
		$temp_allowance['payroll_allowance_amount'] = $allowance->payroll_allowance_amount;

		if($payroll_period_category == 'Weekly')
		{
			if($period_category == $allowance->payroll_allowance_add_period)
			{
				array_push($allowance_data, $temp_allowance);
			}
		}
		else if($payroll_period_category == 'Semi-monthly')
		{
			if(($period_category == 'First Period') && ($allowance->payroll_allowance_add_period == 'First Period'))
			{
				array_push($allowance_data, $temp_allowance);
			}
			else if((($period_category == 'Second Period') && ($allowance->payroll_allowance_add_period == 'Second Period')) || (($period_category == 'Last Period') && ($allowance->payroll_allowance_add_period == 'Last Period')))
			{
				array_push($allowance_data, $temp_allowance);
			}	
		}

		else if($payroll_period_category == 'Monthly')
		{
			if($period_category != 'None')
			{
				array_push($allowance_data, $temp_allowance);
			}
		}

		return $allowance_data;

	}

	public static function compute_overtime($query = array(), $hours = array(), $rate = 0, $day_type = 'Regular', $cola)
	{
		// dd($hours);
		$param = Tbl_payroll_overtime_rate::getrate($query['payroll_group_id'], $query['payroll_overtime_name'])->first();

		$regular 			= 0;
		$late_overtime 		= 0;
		$early_overtime 	= 0;
		$night_differential = 0;

		if($day_type == 'Regular' || $day_type == 'Extra' || $day_type == 'Legal Holiday' || $day_type == 'Special Holiday')
		{
			$regular 			= $param->payroll_overtime_regular;
			$late_overtime 		= $param->payroll_overtime_overtime;
			$early_overtime 	= $param->payroll_overtime_overtime;
			$night_differential = $param->payroll_overtime_nigth_diff;
		}

		else if($day_type == 'Rest Regular' || $day_type == 'Rest Legal Holiday' || $day_type == 'Rest Special Holiday')
		{
			$regular 			= $param->payroll_overtime_rest_day;
			$late_overtime 		= $param->payroll_overtime_rest_overtime;
			$early_overtime 	= $param->payroll_overtime_rest_overtime;
			$night_differential = $param->payroll_overtime_rest_night;
		}

		$cola 				= $regular * $cola;

		$regular 			= $regular * $rate;
		$late_overtime 		= $late_overtime * $rate;
		$early_overtime 	= $early_overtime * $rate;
		$night_differential = $night_differential * $rate;
		

		if($hours['regular'] <= 0)
		{
			$regular = 0;
		}
		if($hours['late_overtime'] <= 0)
		{
			$late_overtime = 0;
		}
		if($hours['early_overtime'] <= 0)
		{
			$early_overtime = 0;
		}
		if($hours['night_differential'] <= 0)
		{
			$night_differential = 0;
		}	

		$data['regular']			= round(($regular + ( $hours['regular'] * $rate )), 2);
		$data['late_overtime']		= round(($late_overtime + ( $hours['late_overtime'] * $rate )), 2);
		$data['early_overtime']		= round(($early_overtime + ( $hours['early_overtime'] * $rate )), 2);
		$data['night_differential']	= round(($night_differential + ( $hours['night_differential'] * $rate )), 2);

		$data['cola'] 				= round($cola, 2);

		return $data;
		
	}
	

	/* GET TAX VALUE */
	public static function tax_contribution($shop_id = 0, $rate = 0, $tax_category = '', $payroll_tax_period = '')
	{
		$tax 		= Tbl_payroll_tax_reference::sel($shop_id, $tax_category, $payroll_tax_period)->first();
		
		$exemption 	= Tbl_payroll_tax_reference::sel($shop_id, 'Excemption', $payroll_tax_period)->first();

		$status 	= Tbl_payroll_tax_reference::sel($shop_id, 'Status', $payroll_tax_period)->first();

		$tax_index 	= '';

		$tax_contribution = 0;

		// dd($tax);

		if($tax->tax_first_range >= $rate && $tax->tax_second_range < $rate)
		{
			$tax_index = 'tax_first_range';
		}

		if($tax->tax_second_range >= $rate && $tax->tax_third_range < $rate)
		{
			$tax_index = 'tax_second_range';
		}

		if($tax->tax_second_range >= $rate && $tax->tax_third_range < $rate)
		{
			$tax_index = 'tax_second_range';
		}

		if($tax->tax_third_range >= $rate && $tax->tax_fourth_range < $rate)
		{
			$tax_index = 'tax_third_range';
		}

		if($tax->tax_fourth_range >= $rate && $tax->tax_fifth_range < $rate)
		{
			$tax_index = 'tax_fourth_range';
		}

		if($tax->tax_fifth_range >= $rate && $tax->taxt_sixth_range < $rate)
		{
			$tax_index = 'tax_fifth_range';
		}

		if($rate >= $tax->taxt_sixth_range&&  $rate < $tax->tax_seventh_range)
		{
			$tax_index = 'taxt_sixth_range';
		}

		if($tax->tax_seventh_range < $rate)
		{
			$tax_index = 'tax_seventh_range';
		}


		if($tax_index != '')
		{
			$exemption_num = $exemption->$tax_index;
			$status_num = $status->$tax_index;
			// dd($status_num);

			$tax_contribution = (($rate - $tax->$tax_index) * ($status_num / 100)) + $exemption_num;
		}
		return round($tax_contribution, 2);
	}

	/* GET SSS VALUE */
	public static function sss_contribution($shop_id = 0, $rate = 0)
	{
		$data['ee'] = 0;
		$data['er'] = 0;
		$data['ec'] = 0;

		$max_sss = Tbl_payroll_sss::where('shop_id', $shop_id)->orderBy('payroll_sss_min','desc')->first();
		$sss = Tbl_payroll_sss::where('shop_id', $shop_id)->where('payroll_sss_min','<=',$rate)->where('payroll_sss_max','>=',$rate)->first();

		if($sss == null)
		{	
			if($max_sss->payroll_sss_min <= $rate)
			{
				$data['ee'] = $max_sss->payroll_sss_ee;
				$data['er'] = $max_sss->payroll_sss_er;
				$data['ec'] = $max_sss->payroll_sss_eec;

			}
		}
		else if($sss != null)
		{
			$data['ee'] = $sss->payroll_sss_ee;
			$data['er'] = $sss->payroll_sss_er;
			$data['ec'] = $sss->payroll_sss_eec;
		}

		return $data;
	}

	/* GET PHILHEALTH VALUE */
	public static function philhealth_contribution($shop_id = 0, $rate = 0)
	{
		$data['ee'] = 0;
		$data['er'] = 0;

		$_philhealth_max = Tbl_payroll_philhealth::where('shop_id', $shop_id)->orderBy('payroll_philhealth_min','desc')->first();

		$philhealth = Tbl_payroll_philhealth::where('shop_id', $shop_id)
											->where('payroll_philhealth_min','<=', $rate)
											->where('payroll_philhealth_max','>=', $rate)
											->first();


		if($philhealth != null)
		{
			$data['ee'] = $philhealth->payroll_philhealth_ee_share;
			$data['er'] = $philhealth->payroll_philhealth_er_share;

		}
		else if($_philhealth_max->payroll_philhealth_min >= $rate)
		{	
			$data['ee'] = $_philhealth_max->payroll_philhealth_ee_share;
			$data['er'] = $_philhealth_max->payroll_philhealth_er_share;
		}

		return $data;
	}

	public static function pagibig_contribution($shop_id = 0, $rate)
	{
		$data = 0;
		$pagibig = Tbl_payroll_pagibig::where('shop_id', $shop_id)->first();
		
		if($pagibig != null)
		{
			$data = ($pagibig->payroll_pagibig_percent / 100 ) * $rate;
		}

		return round($data, 2);
	}


	public static function getdeduction($employee_id = 0, $date = '0000-00-00', $period = '', $payroll_period_category = '', $shop_id = 0)
	{


		$month[0] = date('Y-m-01', strtotime($date));
		$month[1] = date('Y-m-t', strtotime($date));

		$_deduction = Tbl_payroll_deduction_employee::getdeduction($employee_id, $date, $period, $month)->get();
		
		$payroll_record_id = Tbl_payroll_record::getperiod($shop_id, $payroll_period_category)->lists('payroll_record_id');

		

		$data['deduction'] 			= array();
		$data['total_deduction'] 	= 0;

		

		foreach($_deduction as $deduction)
		{
			$temp['deduction_name'] 		= $deduction->payroll_deduction_name;
			$temp['deduction_category'] 	= $deduction->payroll_deduction_category;
			$temp['payroll_deduction_id'] 	= $deduction->payroll_deduction_id;
			$temp['payroll_periodal_deduction'] = $deduction->payroll_periodal_deduction;
			/* get total payment deduction per month */
			$total_payment = Tbl_payroll_deduction_payment::getpayment($employee_id, $payroll_record_id, $deduction->payroll_deduction_id)->select(DB::raw('IFNULL(sum(payroll_payment_amount), 0) as total_payment'))->pluck('total_payment');

			if($temp == 'Last Period')
			{
				$temp['payroll_periodal_deduction'] = $deduction->payroll_monthly_amortization - $total_payment;
			}
			$data['total_deduction'] += $temp['payroll_periodal_deduction'];
			array_push($data['deduction'], $temp);
		}
		// dd($data);
		return $data;
	}

	public static function getrecord_breakdown($record = array())
	{
		
		$data = $record->toArray();
		// dd($data);

		$employee_id 				= $data['payroll_employee_id'];
		$payroll_period_company_id 	= $data['payroll_period_company_id'];

		$_deduction = Tbl_payroll_deduction_payment::where('payroll_record_id', $data['payroll_record_id'])
												  ->orderBy('deduction_name')
												  ->get();

		$_allowance = Tbl_payroll_allowance_record::where('payroll_record_id', $data['payroll_record_id'])
												 ->orderBy('payroll_allowance_name')
												 ->get();

		$data['allowance']					= array();
		$data['deduction']					= array();

		$total_allowance = 0;
		$total_deduction = 0;

		foreach ($_allowance as $key => $allowance) {
			$temp_allowance['payroll_allowance_id'] 	= $allowance->payroll_allowance_id;
			$temp_allowance['payroll_allowance_name'] 	= $allowance->payroll_allowance_name;
			$temp_allowance['payroll_allowance_amount'] = $allowance->payroll_record_allowance_amount;

			$total_allowance += $allowance->payroll_record_allowance_amount;

			array_push($data['allowance'], $temp_allowance);	
		}

		foreach($_deduction as $deduction)
		{
			$temp_deduction['deduction_name'] 				= $deduction->deduction_name;
			$temp_deduction['deduction_category'] 			= $deduction->deduction_category;
			$temp_deduction['payroll_deduction_id'] 		= $deduction->payroll_deduction_id;
			$temp_deduction['payroll_periodal_deduction'] 	= $deduction->payroll_payment_amount;

			$total_deduction += $deduction->payroll_payment_amount;

			array_push($data['deduction'], $temp_deduction);
		}

		$adjustment_bonus = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id, 'Bonus')->get();

		$adjustment_bonus_total = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id , 'Bonus')->sum('payroll_adjustment_amount');
		
		/* commission */
		$adjustment_commission = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id, 'Commissions')->get();

		$adjustment_commission_total = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id , 'Commissions')->sum('payroll_adjustment_amount');

		/* incentives */
		$adjustment_incentives = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id, 'Incentives')->get();

		$adjustment_incentives_total = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id , 'Incentives')->sum('payroll_adjustment_amount');

		/* deductions */
		$adjustment_deductions = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id, 'Deductions')->get();

		$adjustment_deductions_total = Tbl_payroll_adjustment::getadjustment($employee_id, $payroll_period_company_id , 'Deductions')->sum('payroll_adjustment_amount');



		$data['adjustment']['bonus'] 				= $adjustment_bonus;
		$data['adjustment']['total_bonus'] 			= $adjustment_bonus_total;

		$data['adjustment']['incentives'] 			= $adjustment_incentives;
		$data['adjustment']['total_incentives'] 	= $adjustment_incentives_total;

		$data['adjustment']['commission'] 			= $adjustment_commission;
		$data['adjustment']['total_commission'] 	= $adjustment_commission_total;

		$data['adjustment']['deductions'] 			= $adjustment_deductions;
		$data['adjustment']['total_deductions'] 	= $adjustment_deductions_total;
		// $total_contribution 				= $data['']
		$data['total_gross'] = 0;
		$data['total_gross'] += ($data['extra_salary'] + $data['extra_early_overtime'] + $data['extra_reg_overtime'] + $data['extra_night_diff'] + $data['regular_salary'] + $data['regular_early_overtime'] + $data['regular_reg_overtime'] + $data['regular_night_diff'] + $data['rest_day_salary'] + $data['rest_day_early_overtime'] + $data['rest_day_reg_overtime'] + $data['rest_day_night_diff'] + $data['rest_day_sh'] + $data['rest_day_sh_early_overtime'] + $data['rest_day_sh_reg_overtime'] + $data['rest_day_sh_night_diff'] + $data['rest_day_rh'] + $data['rest_day_rh_early_overtime'] + $data['rest_day_rh_reg_overtime'] + $data['rest_day_rh_night_diff'] + $data['rh_salary'] + $data['rh_early_overtime'] + $data['rh_reg_overtime'] + $data['rh_night_diff'] + $data['sh_salary'] + $data['sh_early_overtime'] + $data['sh_reg_overtime'] + $data['sh_night_diff'] + $data['payroll_cola'] + $data['13_month'] + $total_allowance + $adjustment_bonus_total + $adjustment_commission_total + $adjustment_incentives_total);




		$data['total_deminimis'] = $total_allowance + $adjustment_bonus_total + $adjustment_commission_total + $adjustment_incentives_total;


		$total_deduction += $data['tax_contribution'] + $data['sss_contribution_ee'] + $data['philhealth_contribution_ee'] + $data['pagibig_contribution'] + $data['late_deduction'] + $data['under_time'] + $data['agency_deduction'] + $data['adjustment']['total_deductions'];


		// dd($total_deduction);

		$data['total_net']					= $data['total_gross'] - $total_deduction;
		$data['total_deduction']			= $total_deduction;
		$data['total_allowance']			= $total_allowance;
		return $data;
	}

	public static function record_by_date($shop_id = 0, $date_start = '0000-00-00', $date_end = '0000-00-00')
	{
		$date[0] = date('Y-m-d',strtotime($date_start));
		$date[1] = date('Y-m-d',strtotime($date_end));
		$_record = Tbl_payroll_record::getdate($shop_id, $date)->get();

		$data = array();

		foreach($_record as $record)
		{
			array_push($data, Payroll::getrecord_breakdown($record));
		}

		// dd($data);

		return $data;
	}

}
