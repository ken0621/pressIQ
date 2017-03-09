<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Request;
use Carbon\Carbon;
use stdClass;

class PayrollTimesheetController extends Member
{
	public function index()
	{
		/* INITALIZE DATA */
		$from = $data["start_date"] = Carbon::parse("February 26, 2017")->format("Y-m-d");
		$to = $data["end_date"] = Carbon::parse("March 10, 2017")->format("Y-m-d");

		/* CREATE ARRAY TIMESHEET */
		while($from <= $to)
		{
			$data["_timesheet"][$from] = new stdClass();
			$data["_timesheet"][$from]->day_number = Carbon::parse($from)->format("d");
			$data["_timesheet"][$from]->day_word = Carbon::parse($from)->format("D");
			$data["_timesheet"][$from]->time_record[0]["time_in"] = "9:00AM";
			$data["_timesheet"][$from]->time_record[0]["time_out"] = "6:00PM";
			$data["_timesheet"][$from]->time_record[0]["activities"] = "";
			$from = Carbon::parse($from)->addDay()->format("Y-m-d");
		}

		return view('member.payroll.employee_timesheet', $data);
	}
}