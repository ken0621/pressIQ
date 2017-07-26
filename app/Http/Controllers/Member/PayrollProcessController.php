<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_time_keeping_approved;

class PayrollProcessController extends Member
{
	public function index($period_company_id)
	{
		$data["period_company_id"] = $period_company_id;
		$data["company"] = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		return view("member.payroll2.payroll_process", $data);
	}
	public function index_table($period_company_id)
	{
		$data["company"] = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
		return view("member.payroll2.payroll_process_table", $data);
	}

}