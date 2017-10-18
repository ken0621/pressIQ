<?php
namespace App\Http\Controllers\Member\PayrollEmployee;
use App\Http\Controllers\Controller;
use App\Models\Tbl_payroll_employee_basic;

use App\Models\Tbl_shop;
use Request;
use Redirect;
use Validator;
use Carbon\Carbon;
use Crypt;
use Session;
use DB;
use App\Globals\AuditTrail;
use App\Http\Controllers\Member\PayrollMember;

use App\Globals\Settings;



class EmployeeController extends PayrollMember{

	public function employee_info()
	{
		return $this->employee_info;
	}

	public function employee(){

		$data['page']	= 'Home';
		
		return view('member.payroll2.employee_dashboard.employee',$data);
	}
	public function employee_profile(){

		$data['page']	= 'Profile';

	


		return view('member.payroll2.employee_dashboard.employee_profile',$data);
	}
	public function employee_leave_application(){

		$data['page']	= 'Leave Application';

		return view('member.payroll2.employee_dashboard.employee_leave_application',$data);
	}
	public function employee_summary_of_leave(){

		$data['page']	= 'Summary of Leave';

		return view('member.payroll2.employee_dashboard.employee_summary_of_leave',$data);
	}

}