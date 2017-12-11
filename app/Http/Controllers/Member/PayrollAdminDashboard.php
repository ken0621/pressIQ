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
use App\Models\Tbl_payroll_department;

class PayrollAdminDashboard extends Member
{
	public function employee_approver()
	{
		return view('member.payroll2.employees_approver');
	}

	public function modal_create_approver()
	{
		return view('member.payroll2.modal_create_approver');
	}

	public function modal_approver_tag_employee()
	{
	     $data['_company']        = Tbl_payroll_company::selcompany($this->user_info->shop_id)->orderBy('tbl_payroll_company.payroll_company_name')->get();

	     $data['_department']     = Tbl_payroll_department::sel($this->user_info->shop_id)->orderBy('payroll_department_name')->get();

	     $data['action']          =  '/member/payroll/payroll_admin_dashboard/set_employee_approver_tag';

	     return view('member.payroll.modal.modal_approver_tag_employee', $data);
	}

	public function ajax_deduction_tag_employee()
	{
	     $company  = Request::input('company');
	     $department = Request::input('department');
	     $jobtitle      = Request::input('jobtitle');
	     $emp = Tbl_payroll_employee_contract::employeefilter($company, $department, $jobtitle, date('Y-m-d'), $this->user_info->shop_id)->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->groupBy('tbl_payroll_employee_basic.payroll_employee_id')->get();
	     // dd($emp);
	     return json_encode($emp);
	}

	public function set_employee_approver_tag()
	{
		dd(Request::all());
		return json_encode('');
	}
}
