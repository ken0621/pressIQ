<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Request;
use Carbon\Carbon;
use stdClass;
use App\Globals\Payroll;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
use Redirect;

class PayrollTimeSheetController extends Member
{
	public function index()
	{

		$data["_employee"] = Tbl_payroll_employee_basic::where("shop_id", $this->user_info->shop_id)->get();
		$data["current_employee"] = $current_employee = Tbl_payroll_employee_basic::where("shop_id", $this->user_info->shop_id)->where("payroll_employee_id", Request::input("employee_id"))->first();
		
		/* REDIRECT IF NO DEFAULT */
		if(empty($data["current_employee"]))
		{
			return Redirect::to("/member/payroll/employee_timesheet?employee_id=" . $data["_employee"][0]->payroll_employee_id)->send();
		}

		return view('member.payroll.employee_timesheet', $data);
	}
	public function timesheet($employee_id)
	{
		$data["employee_id"] = $employee_id;
		$data["page"] = "Timesheet Table";
		/* GET PAYROLL PERIOD */
		$from = $data["start_date"] = Carbon::parse("February 26, 2017")->format("Y-m-d");
		$to = $data["end_date"] = Carbon::parse("March 10, 2017")->format("Y-m-d");

		/* GET EMPLOYEE INFORMATION */
		$data["employee_info"] = Tbl_payroll_employee_basic::where("payroll_employee_id", $employee_id)->first();

		/* INITALIZE SETTINGS FOR EMPLOYEE */
		$time_rule = $data["time_rule"] = "regulartime"; //flexitime, regulartime
		$data["default_time_in"] = $default_time_in = "09:00 AM";
		$data["default_time_out"] = $default_time_out = "06:00 PM";
		$data["default_working_hours"] = $default_working_hours = "08:00";

		/* CREATE ARRAY TIMESHEET */
		while($from <= $to)
		{
			/* INITITAL DATA */
			$data["_timesheet"][$from] = new stdClass();
			$data["_timesheet"][$from]->date = Carbon::parse($from)->format("Y-m-d");
			$data["_timesheet"][$from]->day_number = Carbon::parse($from)->format("d");
			$data["_timesheet"][$from]->day_word = Carbon::parse($from)->format("D");

			/* GET DATA FOR SPECIFIC DATE */
			$data["timesheet_info"] = Tbl_payroll_time_sheet::where("payroll_time_date", Carbon::parse($from)->format("Y-m-d"))->where("payroll_employee_id", $employee_id)->first();
			
			if(!empty($data["timesheet_info"])) //IF TIME SHEET RECORD EXIST GET RECORD
			{
				$data["_timesheet"][$from]->break = "01:00";
				$data["_timesheet"][$from]->time_record_count = 1;
				
				$_timesheet_record = Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $data["timesheet_info"]->payroll_time_sheet_id)->get();
				foreach($_timesheet_record as $key => $timesheet_record)
				{
					$data["_timesheet"][$from]->time_record[$key] = new stdClass();

					if($timesheet_record->payroll_time_sheet_out == "00:00:00")
					{
						$data["_timesheet"][$from]->time_record[$key]->time_in = "";
						$data["_timesheet"][$from]->time_record[$key]->time_out = "";
					}
					else
					{
						$data["_timesheet"][$from]->time_record[$key]->time_in =  Carbon::parse($timesheet_record->payroll_time_sheet_in)->format("h:i A");
						$data["_timesheet"][$from]->time_record[$key]->time_out = Carbon::parse($timesheet_record->payroll_time_sheet_out)->format("h:i A");
					}

					$data["_timesheet"][$from]->time_record[$key]->activities =  $timesheet_record->payroll_time_shee_activity;
				}
			}
			else //DEFAULT IF EMPTY RECORD
			{
				$data["_timesheet"][$from]->break = "01:00";
				$data["_timesheet"][$from]->time_record_count = 1;
				$data["_timesheet"][$from]->time_record[0] = new stdClass();
				$data["_timesheet"][$from]->time_record[0]->time_in = "";
				$data["_timesheet"][$from]->time_record[0]->time_out = "";
				$data["_timesheet"][$from]->time_record[0]->activities = "";
			}

			$from = Carbon::parse($from)->addDay()->format("Y-m-d");
		}

		return view('member.payroll.employee_timesheet_table', $data);
	}
	public function json_process_time()
	{
		/* SAVE REQUEST INPUT */
		foreach(Request::input('date') as $key => $_time)
		{
			$date = Carbon::parse($key)->format("Y-m-d");
			$employee_id = Request::input("employee_id");
			$check_time_sheet = Tbl_payroll_time_sheet::where("payroll_time_date", $date)->where("payroll_employee_id", $employee_id)->first();

			if(empty($check_time_sheet)) //TIMESHEET RECORD NOT EXIST
			{
				$insert_timesheet["payroll_employee_id"] = $employee_id;
				$insert_timesheet["payroll_time_sheet_type"] = "Regular";
				$insert_timesheet["payroll_time_date"] = $date;
				$insert_timesheet["payroll_time_approve_regular_overtime"] = 0;
				$insert_timesheet["payroll_time_approve_extra_day"] = 0;
				$insert_timesheet["payroll_time_approve_rest_day"] = 0;
				$insert_timesheet["payroll_time_sheet_break"] = "01:00";
				$payroll_time_sheet_id = Tbl_payroll_time_sheet::insert($insert_timesheet);
			}
			else //TIMESHEET RECORD EXIST
			{
				$update_timesheet["payroll_time_sheet_type"] = "Regular";
				$update_timesheet["payroll_time_approve_regular_overtime"] = 0;
				$update_timesheet["payroll_time_approve_extra_day"] = 0;
				$update_timesheet["payroll_time_approve_rest_day"] = 0;
				$update_timesheet["payroll_time_sheet_break"] = "01:00";
				Tbl_payroll_time_sheet::where("payroll_time_date", $date)->where("payroll_employee_id", $employee_id)->update($update_timesheet);
				$payroll_time_sheet_id = $check_time_sheet->payroll_time_sheet_id;
			}

			Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $payroll_time_sheet_id)->delete();
			$_insert_time_record = null;

			foreach(Request::input('date')[$key] as $i => $time)
			{
				$_insert_time_record[$i]["payroll_time_sheet_id"] = $payroll_time_sheet_id;
				$_insert_time_record[$i]["payroll_company_id"] = 0;
				if(Request::input("time_in")[$key][$i] == "")
				{
					$_insert_time_record[$i]["payroll_time_sheet_in"] = "";
					$_insert_time_record[$i]["payroll_time_sheet_out"] = "";
				}
				else
				{
					$_insert_time_record[$i]["payroll_time_sheet_in"] = Carbon::parse(Request::input("time_in")[$key][$i])->format("H:i");
					$_insert_time_record[$i]["payroll_time_sheet_out"] = Carbon::parse(Request::input("time_out")[$key][$i])->format("H:i");
				}

				$_insert_time_record[$i]["payroll_time_shee_activity"] = "";
				$_insert_time_record[$i]["payroll_time_sheet_origin"] = "Payroll Time Sheet";
				$_insert_time_record[$i]["payroll_time_sheet_status"] = "pending";
			}

			Tbl_payroll_time_sheet_record::insert($_insert_time_record);
		}

		/* DECODE REQUEST INPUT */
		foreach(Request::input('date') as $key => $_time)
		{
			$_timesheet[$key] = new stdClass();
			$_timesheet[$key]->date = $key;
			$_timesheet[$key]->break = Request::input("break")[$key];
			$_timesheet[$key]->approved_ot = Request::input("approved_ot")[$key];
			foreach(Request::input('date')[$key] as $i => $time)
			{
				$_timesheet[$key]->time_record[$i] = new stdClass();
				$_timesheet[$key]->time_record[$i]->time_in = Request::input("time_in")[$key][$i];
				$_timesheet[$key]->time_record[$i]->time_out = Request::input("time_out")[$key][$i];
			}
		}

		/* COMPUTE TIME FOR EACH DATE */
		foreach($_timesheet as $key => $timesheet)
		{
			$time_rule = Request::input("time_rule");
			$default_time_in = Request::input("default_time_in");
			$default_time_out = Request::input("default_time_out");
			$default_working_hours = Request::input("default_working_hours");
			$break = $timesheet->break;
			$processed_timesheet = Payroll::process_time($time_rule, $default_time_in, $default_time_out, $timesheet->time_record, $break, $default_working_hours);
			$_timesheet[$key]->time_spent = $processed_timesheet->time_spent;
			$_timesheet[$key]->regular_hours = $processed_timesheet->regular_hours;
			$_timesheet[$key]->late_overtime = $processed_timesheet->late_overtime;
			$_timesheet[$key]->early_overtime = $processed_timesheet->early_overtime;
			$_timesheet[$key]->total_hours = $processed_timesheet->total_hours;
			$_timesheet[$key]->extra_day_hours = $processed_timesheet->extra_day_hours;
			$_timesheet[$key]->rest_day_hours = $processed_timesheet->rest_day_hours;
			$_timesheet[$key]->late_hours = $processed_timesheet->late_hours;
			$_timesheet[$key]->night_differential = $processed_timesheet->night_differential;
		}

		return json_encode($_timesheet);
	}
	public function overtime_form()
	{
		$data["page"] = "Overtime Form";
		return view('member.payroll.employee_timesheet_overtime', $data);
	}
}