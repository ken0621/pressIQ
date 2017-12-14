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
use App\Models\Tbl_payroll_approver_employee;

class PayrollAdminDashboard extends Member
{
	public function employee_approver()
	{
		$data['overtime_approver'] = Tbl_payroll_approver_employee::where('tbl_payroll_approver_employee.shop_id', $this->user_info->shop_id)->where('payroll_approver_employee_type','overtime')->EmployeeInfo()->get();
		$data['rfp_approver'] = Tbl_payroll_approver_employee::where('tbl_payroll_approver_employee.shop_id', $this->user_info->shop_id)->where('payroll_approver_employee_type','rfp')->EmployeeInfo()->get();
		$data['leave_approver'] = Tbl_payroll_approver_employee::where('tbl_payroll_approver_employee.shop_id', $this->user_info->shop_id)->where('payroll_approver_employee_type','leave')->EmployeeInfo()->get();
		
		return view('member.payroll2.employees_approver', $data);
	}

	public function modal_create_approver()
	{
		return view('member.payroll2.modal_create_approver');
	}

	public function create_approver()
	{
		$data['_company']        = Tbl_payroll_company::selcompany($this->user_info->shop_id)->orderBy('tbl_payroll_company.payroll_company_name')->get();

		$data['_department']     = Tbl_payroll_department::sel($this->user_info->shop_id)->orderBy('payroll_department_name')->get();

		return view('member.payroll2.create_approver', $data);
	}

	public function create_approver_table()
	{
		$company  				= Request::input('company');
		$department 			= Request::input('department');
		$jobtitle      			= Request::input('jobtitle');

		$data['_employee'] 		= Tbl_payroll_employee_contract::employeefilter($company, $department, $jobtitle, date('Y-m-d'), $this->user_info->shop_id)->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->groupBy('tbl_payroll_employee_basic.payroll_employee_id')->get();

		return view('member.payroll2.create_approver_table', $data);
	}

	public function save_approver()
	{
		// die(var_dump(Request::all()));

		$_approver_type 	= Request::input('approver_type');
		$_selected_employee = Request::input('selected_employee');
		$approver_level 	= Request::input('approver_level');
		$insert = array();

		foreach ($_approver_type as $key => $approver_type) 
		{
			foreach ($_selected_employee as $key => $selected_employee) 
			{
				$approver_employee = Tbl_payroll_approver_employee::where('payroll_employee_id',$selected_employee)->where('payroll_approver_employee_type',$approver_type)->first();
				
				//if not exist
				if (!$approver_employee) 
				{
					$temp = null;
					$temp['payroll_employee_id'] = $selected_employee;
					$temp['shop_id'] = $this->user_info->shop_id;
					$temp['payroll_approver_employee_type'] = $approver_type;
					$temp['payroll_approver_employee_level'] = $approver_level;
					$temp['archived'] = 0;
					array_push($insert, $temp);
				}
			}
		}

		Tbl_payroll_approver_employee::insert($insert);
		$response["response_status"] = "success";
		$response['call_function'] = 'success_saving_import';

		return $response;
	}

	public function modal_edit_approver($approver_id)
	{
		$data['approver_type'] = Request::input('approver_type');
		$data['approver_info'] = Tbl_payroll_approver_employee::where('payroll_approver_employee_id',$approver_id)->EmployeeInfo()->first();
		$data['approver_id']   = $approver_id;
		
		return view('member.modal.modal_edit_approver', $data);
	}

	public function save_edit_approver()
	{
		$update['payroll_approver_employee_level'] = Request::input('approver_level');
		Tbl_payroll_approver_employee::where('payroll_approver_employee_id',Request::input('approver_id'))->update($update);
		$response['response_status']  = 'success';
		$response['call_function']	= 'submit_done';
		$response['function_name'] = 'payroll_employee_approver.reload';
		
		return json_encode($response);
 	}

	public function modal_delete_approver($approver_id)
	{
		

		if (Request::isMethod('post')) 
		{
			$response['response_status']  = 'success';
			$response['call_function']	= 'submit_done';
			$response['function_name'] = 'payroll_employee_approver.reload';
			Tbl_payroll_approver_employee::where('payroll_approver_employee_id',$approver_id)->delete();

			return json_encode($response);
		}
		else
		{
			$data['approver_type'] = Request::input('approver_type');
			$data['approver_info'] = Tbl_payroll_approver_employee::where('payroll_approver_employee_id',$approver_id)->EmployeeInfo()->first();
			$data['action'] = '/member/payroll/payroll_admin_dashboard/delete_approver/'.$approver_id;
			$data['id']   = $approver_id;
			$data['message'] = 'do you really want to delete approver employee approver '. $data['approver_info']['payroll_employee_display_name'] . '?';
			$data['btn'] = ' <button type="submit" class="btn btn-custom-white">confirm</button>';

			return view('member.modal.confirm', $data);
		}
		// 
	}

	public function create_approver_tag_employee()
	{
	     $data['_company']        = Tbl_payroll_company::selcompany($this->user_info->shop_id)->orderBy('tbl_payroll_company.payroll_company_name')->get();
	     $data['_department']     = Tbl_payroll_department::sel($this->user_info->shop_id)->orderBy('payroll_department_name')->get();
	     $data['action']          =  '/member/payroll/payroll_admin_dashboard/set_employee_approver_tag';

	     $company  		= Request::input('company');
	     $department 	= Request::input('department');
	     $jobtitle      = Request::input('jobtitle');
	     $emp 			= Tbl_payroll_employee_contract::employeefilter($company, $department, $jobtitle, date('Y-m-d'), $this->user_info->shop_id)->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->groupBy('tbl_payroll_employee_basic.payroll_employee_id')->get();

	     return view('member.payroll.modal.modal_approver_tag_employee', $data);
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
	     
	     return json_encode($emp);
	}

	public function set_employee_approver_tag()
	{
	
		return json_encode('');
	}

	/*start group approver*/
	public function group_approver()
	{
		return view('member.payroll2.group_approver');
	}

	public function modal_create_group_approver()
	{
		return view('member.payroll2.modal_create_group_approver');
	}



}
