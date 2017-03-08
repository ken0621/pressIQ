<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Request;

class PayrollController extends Member
{

	public function company_list()
	{
		return view('member.payroll.companylist');
	}

    public function employee_list()
	{
		return view('member.payroll.employeelist');
	}   


	public function payroll_configuration()
	{
		return view('member.payroll.payrollconfiguration');
	}

}
