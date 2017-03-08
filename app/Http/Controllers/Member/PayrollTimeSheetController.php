<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Request;

class PayrollTimesheetController extends Member
{
	public function index()
	{
		return view('member.payroll.employee_timesheet');
	}
}