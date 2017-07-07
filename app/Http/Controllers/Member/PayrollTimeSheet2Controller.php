<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
use App\Models\Tbl_payroll_time_sheet_record_approved;
use App\Models\Tbl_payroll_group;
use App\Models\Tbl_payroll_leave_schedule;
use App\Models\Tbl_payroll_employee_salary;
use App\Models\Tbl_payroll_shift_day;
use App\Models\Tbl_payroll_holiday_company;

use App\Globals\Payroll2;

class PayrollTimeSheet2Controller extends Member
{
	public function index($period_id)
	{
		$data["page"] = "Employee List Summary";
		$this->index_redirect_if_time_keeping_does_not_exist($period_id);
		$data["company"] = $this->db_get_company_period_information($period_id);
		$data["_employee"] = $this->db_get_list_of_employees_by_company($data["company"]->payroll_company_id);
		return view('member.payroll2.employee_summary', $data);
	}
	public function index_redirect_if_time_keeping_does_not_exist($period_id)
	{
		$count = Tbl_payroll_period_company::check($period_id, $this->user_info->shop_id)->count();

		if($count == 0)
		{
			return Redirect::to('/member/payroll/time_keeping')->send();
		}
	}
	public function timesheet($period_id, $employee_id)
	{
		$data["page"] = "Employee Timesheet";
		$data["employee_id"] = $this->$employee_id = $employee_id;
		$data["employee_info"] = $this->db_get_employee_information($employee_id); 
		$data["company_period"] = $this->db_get_company_period_information($period_id);
		$data["show_period_start"] = date("F d, Y", strtotime($data["company_period"]->payroll_period_start));
		$data["show_period_end"] = date("F d, Y", strtotime($data["company_period"]->payroll_period_end));
		$data["_timesheet"] = $this->timesheet_info($data["company_period"], $employee_id);
		$data["period_id"] = $period_id;
		return view('member.payroll2.employee_timesheet', $data);
	}
	public function time_change($period_id, $employee_id)
	{
		$data["period"] = $period = $this->db_get_company_period_information($period_id);
		$data["request"] = Request::input();

		/* GET CURRENT TIMESHEET FOR THE DAY */
		$data["timesheet_db"] = $timesheet_db = $this->timesheet_info_db($employee_id, Request::input("date"));
		
		/* DELETE TIME SHEET RECORD */
		Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $timesheet_db->payroll_time_sheet_id)->delete();
		Tbl_payroll_time_sheet_record_approved::where("payroll_time_sheet_id", $timesheet_db->payroll_time_sheet_id)->delete();
		
		/* INSERT NEW TIME SHEET RECORD */
		$insert = null;
		
		foreach(Request::input("time-in") as $key => $time_in)
		{
			$time_out = Request::input("time-out")[$key];
			$remarks = Request::input("remarks")[$key];
			
			if($time_in != "" || $time_out != "")
			{
				$insert[$key]["payroll_time_sheet_id"] = $timesheet_db->payroll_time_sheet_id;
				$insert[$key]["payroll_company_id"] = $period->payroll_company_id;
				$insert[$key]["payroll_time_sheet_in"] = date("H:i:s", strtotime($time_in));
				$insert[$key]["payroll_time_sheet_out"] = date("H:i:s ", strtotime($time_out));
				$insert[$key]["payroll_time_shee_activity"] = $remarks;
				$insert[$key]["payroll_time_sheet_origin"] = "Manually Encoded";
			}
		}
		
		if($insert)
		{
			Tbl_payroll_time_sheet_record::insert($insert);
		}
		
		/* RETURN DATA TO SERVER */
		$data["daily_info"] = $this->timesheet_process_daily_info($employee_id, Request::input("date"), $timesheet_db);
		$daily_income = $data["daily_info"]->compute->total_day_income;
		
		$return["income"] = $daily_income;
		$return["string_income"] = $this->timesheet_daily_income_to_string($timesheet_db->payroll_time_sheet_id, $return["income"], $data["daily_info"]->shift_approved);
		echo json_encode($return);
	}
	public function timesheet_daily_income_to_string($timesheet_id, $income, $approved)
	{
		if($approved == true)
		{
			$string = '<a onclick="action_load_link_to_modal(\'/member/payroll/company_timesheet_day_summary/' . $timesheet_id . '\', \'lg\')" href="javascript:" class="daily-salary" amount="' . $income . '">PHP ' . number_format($income, 2) . '</a>';	
		}
		else
		{
			$string = '<a style="color: red;" onclick="action_load_link_to_modal(\'/member/payroll/company_timesheet_day_summary/' . $timesheet_id . '\', \'lg\')" href="javascript:" class="daily-salary" amount="' . $income . '">PHP ' . number_format($income, 2) . '</a>';
		}
		
		return $string;
	}
	public function timesheet_info($company_period, $employee_id) 
	{
		$_timesheet = null;
		$from = $data["start_date"] = $company_period->payroll_period_start;
		$to = $data["end_date"] = $company_period->payroll_period_end;

		while($from <= $to)
		{
			$timesheet_db = $this->timesheet_info_db($employee_id, $from);
			
			/* CREATE TIMESHEET DB IF EMPTY */
			if(!$timesheet_db)
			{
				$insert = null;
				$insert["payroll_employee_id"] = $employee_id;
				$insert["payroll_time_date"] = $from;
				Tbl_payroll_time_sheet::insert($insert);
				$timesheet_db =$this->timesheet_info_db($employee_id, $from);
			}
			
			$_timesheet[$from] = new stdClass();
			$_timesheet[$from]->payroll_time_sheet_id = $timesheet_db->payroll_time_sheet_id;
			$_timesheet[$from]->date = Carbon::parse($from)->format("Y-m-d");
			$_timesheet[$from]->day_number = Carbon::parse($from)->format("d");
			$_timesheet[$from]->day_word = Carbon::parse($from)->format("D");
			$_timesheet[$from]->record = $this->timesheet_process_in_out($timesheet_db);
			$_timesheet[$from]->is_holiday = $this->timesheet_get_is_holiday($employee_id, $from);
			$_timesheet[$from]->day_type = $day_type = $this->timesheet_get_day_type($employee_id, $from);
			$_timesheet[$from]->default_remarks = $this->timesheet_default_remarks($_timesheet[$from]);
			$_timesheet[$from]->daily_info = $this->timesheet_process_daily_info($employee_id, $from, $timesheet_db);
			$from = Carbon::parse($from)->addDay()->format("Y-m-d");
		}
		
		//dd($_timesheet);
		return $_timesheet;
	}

	public function timesheet_process_in_out($timesheet_db)
	{
		$_timesheet_record = null;
		if($timesheet_db)
		{
			$_timesheet_record_db = $this->db_get_time_sheet_record_of_in_and_out($timesheet_db->payroll_time_sheet_id);
			$_timesheet_record = $this->timesheet_process_in_out_record($_timesheet_record_db);
		}
		else
		{
			$_timesheet_record = $this->timesheet_process_in_out_default();
		}

		return $_timesheet_record;
	}
	public function timesheet_process_daily_info($employee_id, $date, $timesheet_db)
	{
		$return = new stdClass();

		if($timesheet_db)
		{
			$approved_record = $this->db_get_time_sheet_record_of_in_and_out_approved($timesheet_db->payroll_time_sheet_id);
			$approved = false;

			if(count($approved_record) > 0)
			{
				$_record = $approved_record;
				$approved = true;
			}
			else
			{
				$_record = $this->db_get_time_sheet_record_of_in_and_out($timesheet_db->payroll_time_sheet_id);
			}

			$return = $this->timesheet_process_daily_info_record($employee_id, $date, $approved, $_record, $timesheet_db->payroll_time_sheet_id);
		}
		else
		{
			$return->for_approval = 0;
			$return->daily_salary = 0;
		}

		return $return;
	}
	public function timesheet_process_daily_info_record($employee_id, $date, $approved, $_time, $payroll_time_sheet_id)
	{
		$return = new stdClass();
		$return->for_approval	= ($approved == true ? 0 : 1);
		$return->daily_salary	= 0;
		$employee_contract		= $this->db_get_current_employee_contract($employee_id, $date);
		$_shift 				= $this->db_get_shift_of_employee($employee_id, $date);
		$_shift_raw 			= $this->shift_raw($_shift);
		$_time_raw				= $this->time_raw($_time);
		$mode					= "daily";

		$return->_time	= $_time_raw;
		$return->_shift = $_shift_raw;

		if($return->for_approval == 1) //PENDING
		{
			$return->clean_shift	= Payroll2::clean_shift($_time_raw, $_shift_raw);
			$this->save_clean_shift_to_approved_table($payroll_time_sheet_id, $return->clean_shift);
			$return->compute_shift = $return->clean_shift;
		}
		else //APPROVED
		{
			$return->clean_shift	= $this->convert_to_serialize_row_from_approved_clean_shift($_time);
			$return->shift_approved = true;
			$return->compute_shift = $return->clean_shift;
		}
		
// <<<<<<< HEAD
// 		$late_grace_time = "00:00:00";
// 		$grace_time_rule_late = "per_shift";
// 		$overtime_grace_time = "00:00:00";
// 		$grace_time_rule_overtime = "per_shift";
// 		$day_type = "regular";
// 		$is_holiday = "not_holiday";
// 		$leave = "00:00:00";
// 		$leave_fill_late = 0;
// 		$leave_fill_undertime = 0;
// 		$return->time_output = Payroll2::compute_time_mode_regular($return->clean_shift, $_shift_raw, $late_grace_time, $grace_time_rule_late, $overtime_grace_time, $grace_time_rule_overtime, $day_type, $is_holiday , $leave, $leave_fill_late, $leave_fill_undertime, false);
// 		$return->compute = Payroll2::compute_income_day_pay($return->time_output, 800, 1);
		
// =======
// 		$return->shift_approved = $this->check_if_shift_approved($return->clean_shift);
// 		$return->compute_shift = $this->remove_not_auto_approve($return->clean_shift);
		
// 		$daily_rate = $this->getdaily_rate($employee_id, $date, $employee_contract->payroll_group_working_day_month);
		
// 		$return->late_grace_time = $late_grace_time = $employee_contract->late_grace_time;
// 		$return->grace_time_rule_late = $grace_time_rule_late = $employee_contract->grace_time_rule_late;
// 		$return->overtime_grace_time = $overtime_grace_time = $employee_contract->overtime_grace_time;
// 		$return->grace_time_rule_overtime = $grace_time_rule_overtime = $employee_contract->grace_time_rule_overtime;
// 		$return->day_type = $day_type = $this->timesheet_get_day_type($employee_id, $date);
// 		$return->is_holiday = $is_holiday = $this->timesheet_get_is_holiday($employee_id, $date);
// 		//$return->leave = $leave = $this->timesheet_get_leave_hours($employee_id, $date, $_shift_raw);
// 		$return->leave = $leave = "00:00:00";
// 		$return->leave_fill_date = $leave_fill_late = 0;
// 		$return->leave_fill_undertime = $leave_fill_undertime = 0;
// 		$return->default_remarks = $this->timesheet_default_remarks($return);
// 		$return->time_output = Payroll2::compute_time_mode_regular($return->compute_shift, $_shift_raw, $late_grace_time, $grace_time_rule_late, $overtime_grace_time, $grace_time_rule_overtime, $day_type, $is_holiday , $leave, $leave_fill_late, $leave_fill_undertime, false);
// 		$return->compute = Payroll2::compute_income_day_pay($return->time_output, $daily_rate, $employee_contract->payroll_group_id);
// 		// dd($return);
// >>>>>>> 83246abb5c30a7b5c44595cdf8209e4063b9ff71
		return $return;
	}
	public function timesheet_get_day_type($employee_id, $date)
	{
		$day_type		= 'regular';
		$shift_code_id	= Tbl_payroll_employee_basic::where('payroll_employee_id', $employee_id)->pluck('shift_code_id');
		$shift			= Tbl_payroll_shift_day::where('shift_code_id', $shift_code_id)->where('shift_day', date('D', strtotime($date)))->first();
		
		if($shift != null)
		{
			if($shift->shift_rest_day == 1)
			{
				$day_type	= 'rest_day';
			}
			
			if($shift->shift_extra_day == 1)
			{
				$day_type	= 'extra_day';
			}
		}
		
		
		return $day_type;
	}
	public function timesheet_get_is_holiday($employee_id, $date)
	{
		$day_type	= 'not_holiday';
		$company_id	= Tbl_payroll_employee_basic::where('payroll_employee_id', $employee_id)->pluck('payroll_employee_company_id');
		$holiday	= Tbl_payroll_holiday_company::getholiday($company_id, $date)->first();
		
		if($holiday != null)
		{
			$day_type = strtolower($holiday->payroll_holiday_category);
		}
		
		return $day_type;
	}
	public function timesheet_default_remarks($data)
	{
		$remarks = null;
		if($data->day_type == "rest_day")
		{
			$remarks[] = "REST DAY";
		}
		
		if($data->day_type == "extra_day")
		{
			$remarks[] = "EXTRA DAY";
		}
		
		if($data->is_holiday != "not_holiday")
		{
			$remarks[] = "HOLIDAY";
		}
		if($remarks)
		{
			return implode(",", $remarks);
		}
		else
		{
			return "";
		}
		
	}
	public function timesheet_process_in_out_default()
	{
		$_timesheet_record[0] = new stdClass();
		$_timesheet_record[0]->time_sheet_in = "";
		$_timesheet_record[0]->time_sheet_out = "";
		$_timesheet_record[0]->time_sheet_activity = "";
		return $_timesheet_record;
	}
	public function timesheet_get_leave_hours($employee_id, $date, $shift)
	{
		$target = Payroll2::target_hours($shift);
		$schedule = Tbl_payroll_leave_schedule::where('payroll_leave_employee_id', $employee_id)->where('payroll_schedule_leave', $date)->first();
		
		if($schedule != null)
		{
			if($schedule->leave_whole_day == 0)
			{
				$target = $schedule->leave_hours;
			}
		}
		
		
		return $target;
	}
	public function getdaily_rate($employee_id, $date, $target_days)
	{
		$salary = Tbl_payroll_employee_salary::selemployee($employee_id, $date)->first();
		return $salary->payroll_employee_salary_monthly / $target_days;
	}
	
	public function timesheet_process_in_out_record($_timesheet_record_db)
	{
		$_timesheet_record = null;

		foreach($_timesheet_record_db as $key => $record)
		{
			$_timesheet_record[$key] = new stdClass();
			$_timesheet_record[$key]->time_sheet_in = $this->gb_convert_time_from_db_to_timesheet($record->payroll_time_sheet_in);
			$_timesheet_record[$key]->time_sheet_out = $this->gb_convert_time_from_db_to_timesheet($record->payroll_time_sheet_out);
			$_timesheet_record[$key]->time_sheet_activity = $record->payroll_time_shee_activity;
		}

		return $_timesheet_record;
	}

	public function day_summary($timesheet_id)
	{
		$data["timesheet_db"] = $timesheet_db = $this->timesheet_info_db_by_id($timesheet_id);
		$data["payroll_time_sheet_id"] = $timesheet_db->payroll_time_sheet_id;
		$data["employee_id"] = $timesheet_db->payroll_employee_id;
		$data["employee_info"] = $this->db_get_employee_information($timesheet_db->payroll_employee_id); 
		$data["timesheet_info"] = $timesheet_info =$this->timesheet_process_daily_info($timesheet_db->payroll_employee_id, $timesheet_db->payroll_time_date, $timesheet_db);
		$data["compute_html"] = view('member.payroll2.employee_day_summary_compute', $data);
		return view('member.payroll2.employee_day_summary', $data);
	}
	
	public function day_summary_info($timesheet_id)
	{
		$data["timesheet_db"] = $timesheet_db = $this->timesheet_info_db_by_id($timesheet_id);
		$data["payroll_time_sheet_id"] = $timesheet_db->payroll_time_sheet_id;
		$data["employee_id"] = $timesheet_db->payroll_employee_id;
		$data["employee_info"] = $this->db_get_employee_information($timesheet_db->payroll_employee_id); 
		$data["timesheet_info"] = $timesheet_info =$this->timesheet_process_daily_info($timesheet_db->payroll_employee_id, $timesheet_db->payroll_time_date, $timesheet_db);
		return view('member.payroll2.employee_day_summary_compute', $data);
	}
	public function day_summary_change()
	{
		$data["request"] = $request = Request::input();
		$time_sheet_id = Request::input("payroll_time_sheet_id");
		
		foreach(Request::input("time-in") as $key => $time_in)
		{
			/* GET INITIAL INFORMATION NEEDED */
			$payroll_time_sheet_record_id = Request::input("payroll_time_sheet_record_id")[$key];
			$record = Tbl_payroll_time_sheet_record_approved::where("payroll_time_sheet_id", Request::input("payroll_time_sheet_id"))->where("payroll_time_sheet_record_id", Request::input("payroll_time_sheet_record_id")[$key])->first();
			$payroll_time_serialize = unserialize($record->payroll_time_serialize);
			$time_out = Request::input("time-out")[$key];
			$approve_checkbox = isset($request["approve-checkbox"][$key]) ? 1 : 0;
			$overtime_checkbox = isset($request["overtime-checkbox"][$key]) ? 1 : 0;
			
			/* UPDATE INFORMATION */
			$update = null;
			$update["payroll_time_sheet_in"] = $payroll_time_serialize->time_in = $this->c_24_hour_format($time_in);
			$update["payroll_time_sheet_out"] = $payroll_time_serialize->time_out = $this->c_24_hour_format($time_out);
			$update["payroll_time_sheet_auto_approved"] = $payroll_time_serialize->auto_approved = $approve_checkbox;
			$update["payroll_time_serialize"] = serialize($payroll_time_serialize);
			Tbl_payroll_time_sheet_record_approved::where("payroll_time_sheet_id", Request::input("payroll_time_sheet_id"))->where("payroll_time_sheet_record_id", Request::input("payroll_time_sheet_record_id")[$key])->update($update);
		}
		
		echo json_encode("success");
	}
	/* GLOBAL FUNCTION FOR THIS CONTROLLER */
	public function c_24_hour_format($time)
	{
	    return date("H:i:s", strtotime($time));
	}
	public function convert_to_serialize_row_from_approved_clean_shift($_time)
	{
		$return = null;
		
		if($_time)
		{
			foreach($_time as $key => $time)
			{
				$return[$key] = unserialize($time->payroll_time_serialize);
				$return[$key]->payroll_time_sheet_record_id = $time->payroll_time_sheet_record_id;
			}
		}
		
		return $return;

	}
	public function shift_raw($_shift)
	{
		$_shift_raw = null;

		foreach($_shift as $key => $shift)
		{
			if($shift->shift_work_start != null && $shift->shift_work_end != null)
			{
				$_shift_raw[$key] = new stdClass();
				$_shift_raw[$key]->shift_in = $shift->shift_work_start;
				$_shift_raw[$key]->shift_out = $shift->shift_work_end;
			}
		}

		return $_shift_raw;
	}
	/* GLOBAL FUNCTION FOR THIS CONTROLLER */
	public function remove_not_auto_approve($_time)
	{
		if($_time)
		{
			$return = null;
			
			foreach($_time as $key => $time)
			{
				if($time->auto_approved == 1)
				{
					$return[$key] = $time;
				}
			}
			
			return $return;
		}
		else
		{
			$return = null;
		}
		
		return $return;

	}
	public function time_raw($_time)
	{
		$_time_raw = null;

		foreach($_time as $key => $time)
		{
			if($time->payroll_time_sheet_in)
			{
				$_time_raw[$key] = new stdClass();
				$_time_raw[$key]->time_in = $time->payroll_time_sheet_in;
				$_time_raw[$key]->time_out = $time->payroll_time_sheet_out;
			}
		}

		return $_time_raw;
	}
	public function gb_convert_time_from_db_to_timesheet($db_time)
	{
		if($db_time == "00:00:00")
		{
			$return = "";
		}
		else
		{
			$return = $db_time;
		}

		return $return;
	}
	public function check_if_shift_approved($_time)
	{
		$auto_approve = true;

		if($_time == null)
		{
			$auto_approve = true;
		}
		else
		{
			foreach($_time as $time)
			{
				if($time->auto_approved == 0)
				{
					$auto_approve = false;
				}
			}
		}

		return $auto_approve;
	}

	/* DB CONNECT FUNCTIONS */
	public function save_clean_shift_to_approved_table($time_sheet_id, $_clean_shift)
	{
		if($_clean_shift)
		{
			foreach($_clean_shift as $key => $clean_shift)
			{
				$insert[$key]["payroll_time_sheet_id"] = $time_sheet_id;
				$insert[$key]["payroll_time_sheet_in"] = $clean_shift->time_in;
				$insert[$key]["payroll_time_sheet_out"] = $clean_shift->time_out;
				$insert[$key]["payroll_time_shee_activity"] = "";
				$insert[$key]["payroll_time_sheet_origin"] = "";
				$insert[$key]["payroll_time_sheet_auto_approved"] = $clean_shift->auto_approved;
				$insert[$key]["payroll_time_serialize"] = serialize($clean_shift);
			}
			
			Tbl_payroll_time_sheet_record_approved::insert($insert);
		}
	}
	public function db_get_employee_information($employee_id)
	{
		return Tbl_payroll_employee_basic::where("shop_id", $this->user_info->shop_id)->where("payroll_employee_id", $employee_id)->first();
	}
	public function db_get_list_of_employees_by_company($company_id)
	{
		return Tbl_payroll_employee_basic::where("shop_id", $this->user_info->shop_id)->where("payroll_employee_company_id", $company_id)->orderBy("payroll_employee_number")->get();
	}
	public function db_get_company_period_information($period_id)
	{
		return Tbl_payroll_period_company::sel($period_id)->select('tbl_payroll_company.*','tbl_payroll_period.*','tbl_payroll_period_company.*')->first();
	}
	public function db_get_time_sheet_record_of_in_and_out($time_sheet_id)
	{
		return Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $time_sheet_id)->get();
	}
	public function db_get_time_sheet_record_of_in_and_out_approved($time_sheet_id)
	{
		return Tbl_payroll_time_sheet_record_approved::where("payroll_time_sheet_id", $time_sheet_id)->get();
	}
	public function db_get_current_employee_contract($employee_id, $date = '0000-00-00')
	{
		// return Tbl_payroll_employee_contract::where("payroll_employee_id", $employee_id)->orderBy("payroll_employee_contract_id", "desc")->first();
	
		return Tbl_payroll_employee_contract::selemployee($employee_id, $date)
											->join('tbl_payroll_group','tbl_payroll_group.payroll_group_id','=','tbl_payroll_employee_contract.payroll_group_id')
											->first();
	}
	public function db_get_shift_of_employee($employee_id, $date)
	{
		return Tbl_payroll_employee_basic::where('payroll_employee_id', $employee_id)->shift()->day()->where("shift_day", date("D", strtotime($date)))->time()->get();
	}

	public function timesheet_info_db($employee_id, $date)
	{
		return Tbl_payroll_time_sheet::where("payroll_time_date", Carbon::parse($date)->format("Y-m-d"))->where("payroll_employee_id", $employee_id)->first();
	}
	public function timesheet_info_db_by_id($timesheet_id)
	{
		return Tbl_payroll_time_sheet::where("payroll_time_sheet_id", $timesheet_id)->first();
	}
}