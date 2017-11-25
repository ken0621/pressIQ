<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Excel;
use DB;
use App\Models\Tbl_payroll_deduction_v2;
use App\Models\Tbl_payroll_deduction_employee_v2;
use App\Models\Tbl_payroll_deduction_payment_v2;
use App\Models\Tbl_payroll_company;
use App\Models\Tbl_payroll_period;
use App\Models\Tbl_payroll_time_keeping_approved;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_employment_status;
use App\Models\Tbl_payroll_employee_salary;

class PayrollAdminDashboard extends Member
{
	public function employees_approver()
	{
		return view('member.payroll2.employees_approver');
	}

	public function modal_create_approver()
	{
		return view('member.payroll2.modal_create_approver');
	}

	public function modal_approver_tag_employee($deduction_id)
	{
	     $data['_company']        = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();

	     $data['_department']     = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();

	     $data['deduction_id']    =    $deduction_id;
	     $data['action']               =    '/member/payroll/deduction/set_employee_deduction_tag';

	     return view('member.payroll.modal.modal_deduction_tag_employee', $data);
	}
}
