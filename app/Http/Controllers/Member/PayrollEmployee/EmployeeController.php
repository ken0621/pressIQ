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

	public function employee(){

		$data['page']	= 'Dashboard';

		return view('member.payroll2.employee_dashboard.employee',$data);
	}
	public function company_details(){

		$data['page']	= 'Company Details';

		return view('member.payroll2.employee_dashboard.company_details',$data);
	}
	public function employee_profile(){

		$data['page']	= 'Profile';
		/*$data['employee_info'] = Tbl_payroll_employee_basic::where('payroll_employee_id',$id)->get();
		dd($data['employee_info']);*/

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
	public function employee_official_business(){

		$data['page']	= 'Official Business Form';

		return view('member.payroll2.employee_dashboard.employee_official_business',$data);
	}
	public function employee_overtime_application(){

		$data['page']	= 'Over Time Application';

		return view('member.payroll2.employee_dashboard.employee_overtime_application',$data);
	}
	public function authorization_access_leave(){

		$data['page']	= 'Authorization Access Leave';

		return view('member.payroll2.employee_dashboard.authorization_access_leave',$data);
	}
	public function authorization_access_over_time(){

		$data['page']	= 'Authorization Access Over Time';

		return view('member.payroll2.employee_dashboard.authorization_access_over_time',$data);
	}
	public function authorization_access_official_business(){

		$data['page']	= 'Authorization Access Official Business';

		return view('member.payroll2.employee_dashboard.authorization_access_official_business',$data);
	}
	public function employee_leave_management(){

		$data['page']	= 'Leave Management';

		return view('member.payroll2.employee_dashboard.employee_leave_management',$data);
	}
	public function employee_overtime_management(){

		$data['page']	= 'Over Time Management';

		return view('member.payroll2.employee_dashboard.employee_overtime_management',$data);
	}
	public function employee_official_business_management(){

		$data['page']	= 'Official Business Management';

		return view('member.payroll2.employee_dashboard.employee_official_business_management',$data);
	}
	public function employee_time_keeping(){

		$data['page']	= 'Time Keeping';
		
		return view('member.payroll2.employee_dashboard.employee_time_keeping',$data);
	}
}