<?php
namespace App\Http\Controllers\Member\PayrollEmployee;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\PayrollEmployee\EmployeeController;
use App\Http\Controllers\Member\PayrollEmployee\RequestForPaymentController;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_period;
use App\Models\Tbl_payroll_company;
use App\Models\Tbl_payroll_time_keeping_approved;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_leave_temp;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
use App\Models\Tbl_payroll_time_sheet_record_approved;
use App\Models\Tbl_payroll_rdo;
use App\Models\Tbl_payroll_overtime_rate;
use App\Models\Tbl_payroll_shift_code;
use App\Models\Tbl_payroll_shift_time;
use App\Models\Tbl_payroll_shift_day;
use App\Models\Tbl_payroll_approver_group;
use App\Models\Tbl_payroll_request_overtime;
use App\Models\Tbl_payroll_approver_employee;
use App\Models\Tbl_payroll_request_payment;
use App\Models\Tbl_payroll_request_payment_sub;
use App\Models\Tbl_payroll_leave_schedulev3;
use App\Globals\Payroll2;
use App\Globals\Payroll;
use App\Globals\Utilities;
use Redirect;
use Validator;
use Carbon\Carbon;
use Crypt;
use Session;
use DB;
use Request;
use App\Http\Controllers\Member\PayrollMember;

use PDF2;
use App\Globals\Pdf_global;


class LeaveController extends PayrollMember
{
	public function employee_info()
	{
		return $this->employee_info;
	}

	public function employee_id()
	{
		return $this->employee_info->payroll_employee_id;
	}

	public function employee_shop_id()
	{
		return $this->employee_info->shop_id;
	}

	public function employee_summary_of_leave()
	{
		$data['page']	= 'Summary of Leave';
		return view('member.payroll2.employee_dashboard.employee_summary_of_leave',$data);
	}

	public function authorized_access_leave()
	{
		$data['page']					= 'Authorized Access Leave';
		$data["_leave_name"] 			= Tbl_payroll_leave_temp::where("shop_id", Self::employee_shop_id())->get();
		
		return view('member.payroll2.employee_dashboard.authorized_access_leave',$data);
	}

	public function employee_leave_application()
	{

		$shop_id = Self::employee_shop_id();

		$data['page']		= 'Employee Leave Application';
        $data["company"] 	= Tbl_payroll_company::where("tbl_payroll_company.payroll_company_id", $this->employee_info->payroll_employee_company_id)->first();

	      $data["employees_info"] = Tbl_payroll_employee_contract::employeefilter($company = 0, $department = 0, $jobtitle = 0, date('Y-m-d'), $shop_id)->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->groupBy('tbl_payroll_employee_basic.payroll_employee_id')->get();
	      
    	return view('member.payroll2.employee_dashboard.employee_leave_application',$data);
    }

    public function create_employee_leave()
    {
		$data['page']	= 'Create Employee Leave';
    	return view('member.payroll2.employee_dashboard.create_employee_leave',$data);
    }

	public function employee_leave_management()
	{
		$data['page']			= 'Leave Management';
	  	return view('member.payroll2.employee_dashboard.employee_leave_management',$data);
	}

	public function ajax_all_load_leave()
	{

		 $emp = Tbl_payroll_leave_schedulev3::select('tbl_payroll_leave_schedulev3.*','basicreliever.payroll_employee_display_name as payroll_employee_display_name_reliever','basicapprover.payroll_employee_display_name as payroll_employee_display_name_approver','tbl_payroll_leave_schedulev3.payroll_employee_id')
			->leftjoin('tbl_payroll_employee_basic AS basicreliever', 'basicreliever.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_reliever')
    		->leftjoin('tbl_payroll_employee_basic AS basicapprover', 'basicapprover.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_approver')
    		->where('tbl_payroll_leave_schedulev3.payroll_employee_id',Self::employee_id())
   			 ->get();

		 return json_encode($emp);
	}

	public function ajax_load_pending_leave()
	{
		 $emp = Tbl_payroll_leave_schedulev3::select('tbl_payroll_leave_schedulev3.*','basicreliever.payroll_employee_display_name as payroll_employee_display_name_reliever','basicapprover.payroll_employee_display_name as payroll_employee_display_name_approver','tbl_payroll_leave_schedulev3.payroll_employee_id')
			->leftjoin('tbl_payroll_employee_basic AS basicreliever', 'basicreliever.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_reliever')
    		->leftjoin('tbl_payroll_employee_basic AS basicapprover', 'basicapprover.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_approver')
    		->where('tbl_payroll_leave_schedulev3.payroll_employee_id',Self::employee_id())
    		->where('tbl_payroll_leave_schedulev3.status',"Pending")
   			 ->get();

		 return json_encode($emp);
	}

	public function ajax_load_approved_leave()
	{
		  $emp = Tbl_payroll_leave_schedulev3::select('tbl_payroll_leave_schedulev3.*','basicreliever.payroll_employee_display_name as payroll_employee_display_name_reliever','basicapprover.payroll_employee_display_name as payroll_employee_display_name_approver','tbl_payroll_leave_schedulev3.payroll_employee_id')
			->leftjoin('tbl_payroll_employee_basic AS basicreliever', 'basicreliever.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_reliever')
    		->leftjoin('tbl_payroll_employee_basic AS basicapprover', 'basicapprover.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_approver')
    		->where('tbl_payroll_leave_schedulev3.payroll_employee_id',Self::employee_id())
    		->where('tbl_payroll_leave_schedulev3.status',"Approved")
   			 ->get();

		 return json_encode($emp);
	}

	public function ajax_load_rejected_leave()
	{
		  $emp = Tbl_payroll_leave_schedulev3::select('tbl_payroll_leave_schedulev3.*','basicreliever.payroll_employee_display_name as payroll_employee_display_name_reliever','basicapprover.payroll_employee_display_name as payroll_employee_display_name_approver','tbl_payroll_leave_schedulev3.payroll_employee_id')
			->leftjoin('tbl_payroll_employee_basic AS basicreliever', 'basicreliever.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_reliever')
    		->leftjoin('tbl_payroll_employee_basic AS basicapprover', 'basicapprover.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_approver')
    		->where('tbl_payroll_leave_schedulev3.payroll_employee_id',Self::employee_id())
    		->where('tbl_payroll_leave_schedulev3.status',"Rejected")
   			 ->get();	

		 return json_encode($emp);
	}

	public function save_leave()
    {
    	$insert = array();
    	if(Request::has('single_date_only'))
        {
	    	 $temp['payroll_employee_id_reliever']		    =	Request::input('payroll_employee_id_reliever');
			 $temp['payroll_employee_id_approver']		    =	Request::input('payroll_employee_id_approver');
			 $temp['payroll_employee_id']					= 	Self::employee_id();
			 $temp['payroll_schedule_leave']				=	Request::input('payroll_schedule_leave');
			 $temp['date_filed']							=	Request::input('date_filed');
			 $temp['shop_id']								=	Self::employee_shop_id();
			 $temp['leave_hours']							=	Request::input('leave_hours');
			 $temp['consume']								=	Payroll::time_float(Request::input('leave_hours'));
			 $temp['remarks']								=	"Used ".Request::input('leave_hours')." hours in ".Request::input('leave_type');
			 $temp['status']								=	"Pending";
			 $temp['payroll_leave_name']					=	Request::input('leave_type');

			 array_push($insert, $temp);
		}
		else
		{
			  $end = datepicker_input(Request::input('payroll_schedule_leave_end'));
              $payroll_schedule_leave = datepicker_input(Request::input('payroll_schedule_leave'));
			   while($payroll_schedule_leave <= $end)
               {
               		 $temp['payroll_employee_id_reliever']		    =	Request::input('payroll_employee_id_reliever');
					 $temp['payroll_employee_id_approver']		    =	Request::input('payroll_employee_id_approver');
					 $temp['payroll_employee_id']					= 	Self::employee_id();
					 $temp['payroll_schedule_leave']				=	$payroll_schedule_leave;
					 $temp['date_filed']							=	Request::input('date_filed');
					 $temp['shop_id']								=	Self::employee_shop_id();
					 $temp['leave_hours']							=	Request::input('leave_hours');
					 $temp['consume']								=	Payroll::time_float(Request::input('leave_hours'));
					 $temp['remarks']								=	"Used ".Request::input('leave_hours')." hours in ".Request::input('leave_type');
					 $temp['status']								=	"Pending";
					 $temp['payroll_leave_name']					=	Request::input('leave_type');

     				 array_push($insert, $temp);
     				 $payroll_schedule_leave = Carbon::parse($payroll_schedule_leave)->addDay()->format("Y-m-d");
               }
		}
		if(!empty($insert)) 
        {  
            Tbl_payroll_leave_schedulev3::insert($insert);
        }

	   	$response['call_function'] = 'reload';
		$response['status'] = 'success';

		return $response;
    	
    }



}
