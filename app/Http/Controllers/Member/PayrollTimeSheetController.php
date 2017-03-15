<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Request;
use Carbon\Carbon;
use stdClass;
use App\Globals\Payroll;

class PayrollTimesheetController extends Member
{
	public function index()
	{
		/* INITALIZE DATA */
		$from = $data["start_date"] = Carbon::parse("February 26, 2017")->format("Y-m-d");
		$to = $data["end_date"] = Carbon::parse("March 10, 2017")->format("Y-m-d");
		$time_rule = $data["time_rule"] = "flexitime"; //flexitime, timestrict, flexistrict
		$data["default_time_in"] = $default_time_in = "9:00 AM";
		$data["default_time_out"] = $default_time_out = "6:00 PM";
		$data["default_working_hours"] = $default_working_hours = "08:00";

		/* CREATE ARRAY TIMESHEET */
		while($from <= $to)
		{
			$data["_timesheet"][$from] = new stdClass();
			$data["_timesheet"][$from]->date = Carbon::parse($from)->format("Y-m-d");
			$data["_timesheet"][$from]->day_number = Carbon::parse($from)->format("d");
			$data["_timesheet"][$from]->day_word = Carbon::parse($from)->format("D");
			$data["_timesheet"][$from]->break = "01:00:00";
			
			/* CHECK IF MULTIPLE TIME IN */
			if($from == Carbon::parse("February 28, 2017")->format("Y-m-d")) //MULTIPLE TIME IN
			{
				$data["_timesheet"][$from]->time_record_count = 2;
				$data["_timesheet"][$from]->time_record[0] = new stdClass();
				$data["_timesheet"][$from]->time_record[0]->time_in = "9:00AM";
				$data["_timesheet"][$from]->time_record[0]->time_out = "3:00PM";
				$data["_timesheet"][$from]->time_record[0]->activities = "";
				$data["_timesheet"][$from]->time_record[1] = new stdClass();
				$data["_timesheet"][$from]->time_record[1]->time_in = "4:00PM";
				$data["_timesheet"][$from]->time_record[1]->time_out = "6:30PM";
				$data["_timesheet"][$from]->time_record[1]->activities = "";
			}
			else //SINGLE TIME IN
			{
				$data["_timesheet"][$from]->time_record_count = 1;
				$data["_timesheet"][$from]->time_record[0] = new stdClass();
				$data["_timesheet"][$from]->time_record[0]->time_in = "9:00AM";
				$data["_timesheet"][$from]->time_record[0]->time_out = "6:00PM";
				$data["_timesheet"][$from]->time_record[0]->activities = "";
			}

			
			$from = Carbon::parse($from)->addDay()->format("Y-m-d");
		}

		return view('member.payroll.employee_timesheet', $data);
	}
	public function json_process_time()
	{
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
		}

		return json_encode($_timesheet);
	}
}