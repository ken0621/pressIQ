<?php
namespace App\Http\Controllers\Member\PayrollEmployee;

use App\Http\Controllers\Controller;
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
use App\Models\Tbl_payroll_leave_schedulev3;


use App\Globals\Payroll2;
use App\Globals\Payroll;
use App\Globals\Utilities;
use Request;
use Redirect;
use Validator;
use Carbon\Carbon;
use Crypt;
use Session;
use DB;
use App\Http\Controllers\Member\PayrollMember;	


use PDF2;
use App\Globals\Pdf_global;


class EmployeeController extends PayrollMember
{

	public function employee_info()
	{
		return $this->employee_info;
	}
	public function employee()
	{
		$data['page']	= 'Dashboard';
					 				  		
		return view('member.payroll2.employee_dashboard.employee',$data);
	}
	public function company_details()
	{
		$data['page']	= 'Company Details';

		$shop_id = $this->employee_info->shop_id;

		$data['company'] = Tbl_payroll_company::companydetails($shop_id)->where('payroll_parent_company_id',0)->first();
		//dd($data['company']);

		return view('member.payroll2.employee_dashboard.company_details',$data);
	}

	public function employee_profile()
	{
		$data['page']	= 'Profile';
		$parameter['date']					= date('Y-m-d');
		$parameter['company_id']			= 0;
		$parameter['employement_status']	= 0;
		$parameter['shop_id'] 				= $this->employee_info->shop_id;
		$data["employee"] = Tbl_payroll_employee_basic::selemployee($parameter)->where('tbl_payroll_employee_basic.payroll_employee_id',$this->employee_info->payroll_employee_id)->orderby("tbl_payroll_employee_basic.payroll_employee_number")->first();
		$data["company"] = Tbl_payroll_company::where("tbl_payroll_company.payroll_company_id", $this->employee_info->payroll_employee_company_id)->first();
		$data["startdate"] = Tbl_payroll_employee_contract::where("tbl_payroll_employee_contract.payroll_employee_id", $this->employee_info->payroll_employee_id)->first();
		
		return view('member.payroll2.employee_dashboard.employee_profile',$data);
	}
	public function edit_employee_profile()
	{
		$data['page']	= 'Profile';
		$parameter['date']					= date('Y-m-d');
		$parameter['company_id']			= 0;
		$parameter['employement_status']	= 0;
		$parameter['shop_id'] 				= $this->employee_info->shop_id;
		$data["employee"] = Tbl_payroll_employee_basic::selemployee($parameter)->where('tbl_payroll_employee_basic.payroll_employee_id',$this->employee_info->payroll_employee_id)->orderby("tbl_payroll_employee_basic.payroll_employee_number")->first();

		return view('member.payroll2.employee_dashboard.edit_employee_profile',$data);
	}
	public function update_employee_profile(Request $request)
	{
		$data['page']	= 'Profile';

		$update['payroll_employee_display_name'] = $request->name;
		$update['payroll_employee_gender'] = $request->gender;        
		$update['payroll_employee_birthdate'] = $request->birthdate;
        $update['payroll_employee_street'] = $request->street;
        $update['payroll_employee_city'] = $request->city;
        $update['payroll_employee_state'] = $request->state;
        $update['payroll_employee_contact'] = $request->number;
        //$update['payroll_employee_email'] = $request->email;
        //$update['payroll_employee_tin'] = $request->tin;
        $update['payroll_employee_pagibig'] = $request->pagibig;
        $update['payroll_employee_philhealth'] = $request->philhealth;
        $update['payroll_employee_sss'] = $request->sss;


      	$rules['payroll_employee_display_name'] = 'required';
        $rules['payroll_employee_gender'] = 'required';
        $rules['payroll_employee_birthdate'] = 'required|date';
        $rules['payroll_employee_street'] = 'required';
        $rules['payroll_employee_city'] = 'required';
        $rules['payroll_employee_state'] = 'required';
        //$rules['email'] = 'email';
        $rules['payroll_employee_contact'] = 'required|numeric';

        $validator = validator::make($update, $rules);

        $return_message = '';
        if($validator->fails())
        {
            foreach ($validator->messages()->all('<li style=`list-style:none`>:message</li>')as $keys => $message)
            {
                $return_message .= $message;
            }
            return Redirect::to('/edit_employee_profile')->with('error', $return_message);
        }
        else
        {
            Tbl_payroll_employee_basic::where('payroll_employee_id', $request->payroll_employee_id)->update($update);
            return Redirect::to('/employee_profile')->with('warning', 'testing');
        }
	}

	public function employee_official_business()
	{
		$data['page']	= 'Official Business Form';
		return view('member.payroll2.employee_dashboard.employee_official_business',$data);
	}
	public function employee_overtime_application()
	{
		$data['page']	= 'Overtime Application';

		//dd($data['ot']);
		return view('member.payroll2.employee_dashboard.employee_overtime_application',$data);
	}
	public function employee_overtime_view_shift()
	{
		$data['page']	= 'Shift Schedule';


		$data['employee'] = Tbl_payroll_employee_basic::EmployeeShift($this->employee_info->payroll_employee_id)->first();

		$data['shift'] = tbl_payroll_shift_day::where("shift_code_id", $data['employee']->shift_code_id)->get();

		//dd($data['shift_day'][0]->shift_day_id);

		foreach ($data['shift'] as $value) 
		{	
			$data['shift_day_id'] = $value->shift_day_id;
			//dd($data['shift_day_id'])

			$data['shift_time'] = tbl_payroll_shift_time::where('shift_day_id', $data['shift_day_id'])->get();


			//dd($data['shift']);

		}	







		//$data['shift_time'] = tbl_payroll_shift_time::get();
		//dd($data['shift_time']);

		//$data['shift_time'] = tbl_payroll_shift_time::ShiftTime("tbl_payroll_shift_day.shift_day_id", $data['shift_day']->shift_day_id)->first();

		
		//dd($data['shift_time']);

		/*foreach($day->time_shift as $x => $timeshift)
		{

		}*/

		/*$data['shift_day'] = tbl_payroll_shift_day::where("shift_code_id", $data['employee']->shift_code_id)->get();
		dd($data['shift_day'][1]->shift_day_id);

		$data['shift_time'] = Tbl_payroll_shift_time::where("shift_day_id", $data['employee']->shift_code_id)->get();
		dd($data['shift_time'][0]->shift_work_start);

		/*$data['shift_time'] = Tbl_payroll_shift_time::where("shift_day_id",$data['shift_day']->shift_day_id)->first();

		dd($data['shift_time']);

		foreach ($data['shift_time'] as $key => $value) 
		{
			dd($value);
		}
*/

		//dd($data['shift_time'][0]);



		//$data['shift'] = Tbl_payroll_shift_time::ShiftTime()->where("tbl_payroll_shift_day.shift_code_id", $data['shift']->shift_code_id)->get();
		return view('member.payroll2.employee_dashboard.employee_overtime_view_shift',$data);
	}

	public function authorized_access_over_time()
	{
		$data['page']	= 'Authorized Access Over Time';
		return view('member.payroll2.employee_dashboard.authorized_access_over_time',$data);
	}
	public function authorized_access_official_business()
	{
		$data['page']	= 'Authorized Access Official Business';
		return view('member.payroll2.employee_dashboard.authorized_access_official_business',$data);
	}
	public function authorized_access_approver()
	{
		$data['page']	= 'Authorized Access Approver';
		return view('member.payroll2.employee_dashboard.authorized_access_approver',$data);
	}
	
	public function employee_overtime_management()
	{
		$data['page']	= 'Over Time Management';
		return view('member.payroll2.employee_dashboard.employee_overtime_management',$data);
	}
	public function employee_official_business_management()
	{
		$data['page']	= 'Official Business Management';
		return view('member.payroll2.employee_dashboard.employee_official_business_management',$data);
	}

	public function employee_time_keeping()
	{

		$data['page']				= 'Time Keeping';
		$data['period_record'] 		= Tbl_payroll_time_keeping_approved::employeePeriod($this->employee_info->payroll_employee_id)->get();
		// dd($data['period_record']);
		return view('member.payroll2.employee_dashboard.employee_time_keeping',$data);
	}
	public function employee_payslip_pdf($payroll_period_id)
    { 
    	$data['page']				= 'Employee Payslip';
    	$data["employee_company"] 	= Tbl_payroll_company::where("tbl_payroll_company.payroll_company_id", $this->employee_info->payroll_employee_company_id)->first();
    	$data['period_record'] 		= Tbl_payroll_time_keeping_approved::employeePeriod($this->employee_info->payroll_employee_id)->where('tbl_payroll_period.payroll_period_id',$payroll_period_id)->first();

    	$data["period_record_start"]		= date("F d, Y", strtotime($data["period_record"]->payroll_period_start));
		$data["period_record_end"]			= date("F d, Y", strtotime($data["period_record"]->payroll_period_end));
		$data["period_record_release_date"]	= date("F d, Y", strtotime($data["period_record"]->payroll_release_date));

		//dd(unserialize($data["period_record"]->cutoff_input));
		$data["period_record"]->cutoff_breakdown =  unserialize($data["period_record"]->cutoff_breakdown);
		

		$other_deductions = 0;

		foreach($data["period_record"]->cutoff_breakdown->_breakdown as $breakdown)	
		{
			if($breakdown["deduct.net_pay"] == true)
			{
				$other_deductions += $breakdown["amount"];
			}
		}

		$data["period_record"]->other_deduction = $other_deductions;
		$data["period_record"]->total_deduction = $data["period_record"]->philhealth_ee + $data["period_record"]->sss_ee + $data["period_record"]->pagibig_ee  + $other_deductions; // + $employee->tax_ee;
		
		//YEAR-END SUMMARY - PAYROLL PERIOD
		$period_year = date("Y", strtotime($data["period_record"]->payroll_period_end));
		$period_start = $period_year.'-01-01';
		$data['total_period_record'] = Tbl_payroll_time_keeping_approved::employeePeriod($this->employee_info->payroll_employee_id)
		->whereBetween('tbl_payroll_period.payroll_period_end',[$period_start, $data['period_record']->payroll_period_end])->get();

		$data['total_net_pay'] = 0 ;
		$data['total_tax_ee'] = 0 ;
		$data['total_sss_ee'] = 0 ;
		$data['total_philhealth_ee'] = 0 ;
		$data['total_pagibig_ee'] = 0 ;


		foreach($data['total_period_record'] as $total)	
		{
			$data['total_net_pay'] += $total->net_pay;
			$data['total_tax_ee'] += $total->tax_ee;
			$data['total_sss_ee'] += $total->sss_ee;
			$data['total_philhealth_ee'] += $total->philhealth_ee;
			$data['total_pagibig_ee'] += $total->pagibig_ee;
		}

		//return view('member.payroll2.employee_dashboard.employee_payslip', $data);
		$pdf = view('member.payroll2.employee_dashboard.employee_payslip_pdf', $data);
        return Pdf_global::show_pdf($pdf);
        
    }
	public function employee_timesheet($payroll_period_id)
	{
		$data["page"] 	= "Employee Timesheet";

		$data['period_record'] 			= Tbl_payroll_time_keeping_approved::employeePeriod($this->employee_info->payroll_employee_id)->where('tbl_payroll_period.payroll_period_id',$payroll_period_id)->first();

		$data["period_record_start"]		= date('M d, Y',strtotime($data["period_record"]->payroll_period_start));
		$data["period_record_end"]			= date('M d, Y',strtotime($data["period_record"]->payroll_period_end));

		$data["_timesheet"] 			= Payroll2::timesheet_info($data["period_record"], $this->employee_info->payroll_employee_id);
		$data["access_salary_rates"]	= $access = Utilities::checkAccess('payroll-timekeeping','salary_rates');

		$data["period_record"]->cutoff_breakdown =  unserialize($data["period_record"]->cutoff_breakdown);

		$employee_contract = Tbl_payroll_employee_contract::EmployeePayrollGroup($this->employee_info->payroll_employee_id)->first();

		if ($employee_contract->payroll_group_code == 'Flate Rate')
		{
			echo "<div style='padding: 100px; text-align: center;'>FLAT RATE COMPUTATION DOES'T HAVE TIMESHEET</div>";
		}
		else
		{
			return view('member.payroll2.employee_dashboard.employee_timesheet', $data);
		}
	}   
	public function employee_timesheet_pdf($payroll_period_id)
	{
		$data["page"] 	= "Employee Timesheet";

		$data['period_record'] 			= Tbl_payroll_time_keeping_approved::employeePeriod($this->employee_info->payroll_employee_id)->where('tbl_payroll_period.payroll_period_id',$payroll_period_id)->first();

		$data["period_record_start"]		= date('M d, Y',strtotime($data["period_record"]->payroll_period_start));
		$data["period_record_end"]			= date('M d, Y',strtotime($data["period_record"]->payroll_period_end));

		$data["_timesheet"] 			= Payroll2::timesheet_info($data["period_record"], $this->employee_info->payroll_employee_id);

		$data["access_salary_rates"]	= $access = Utilities::checkAccess('payroll-timekeeping','salary_rates');

		$data["period_record"]->cutoff_breakdown =  unserialize($data["period_record"]->cutoff_breakdown);

		$employee_contract = Tbl_payroll_employee_contract::EmployeePayrollGroup($this->employee_info->payroll_employee_id)->first();

		if ($employee_contract->payroll_group_code == 'Flate Rate')
		{
			echo "<div style='padding: 100px; text-align: center;'>FLAT RATE COMPUTATION DOES'T HAVE TIMESHEET</div>";
		}
		else
		{
			$pdf = view('member.payroll2.employee_dashboard.employee_timesheet_pdf', $data);
	        return Pdf_global::show_pdf($pdf);
	    }
	}   
	public function sample()
	{
		$data['page']	= 'Official Business Management';
		return view('member.payroll2.employee_dashboard.sample',$data);
	}

    public function create_employee_overtime()
    {
		$data['page']	= 'Create Employee Overtime';
    	return view('member.payroll2.employee_dashboard.create_employee_overtime',$data);
    }
    public function create_employee_official_business()
    {
		$data['page']	= 'Create Employee OB';
    	return view('member.payroll2.employee_dashboard.create_employee_official_business',$data);
    }
    public function create_employee_approver()
    {
		$data['page']	= 'Create Employee Approver';
    	return view('member.payroll2.employee_dashboard.create_employee_approver',$data);
    }
    public function updated_layout()
    {
		$data['page']		= 'Create Employee Approver';
		$data['employee'] 	= Self::employee_profile();
    	return view('member.payroll2.employee_dashboard.updated_layout',$data);
    }

    //leave
    public function save_leave()
    {
    	$insert = array();
    	if(Request::has('single_date_only'))
        {
	    	 $temp['payroll_employee_id_reliever']		    =	Request::input('payroll_employee_id_reliever');
			 $temp['payroll_employee_id_approver']		    =	Request::input('payroll_employee_id_approver');
			 $temp['payroll_employee_id']					= 	$this->employee_info->payroll_employee_id;
			 $temp['payroll_schedule_leave']				=	Request::input('payroll_schedule_leave');
			 $temp['date_filed']							=	Request::input('date_filed');
			 $temp['shop_id']								=	$this->employee_info->shop_id;
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
					 $temp['payroll_employee_id']					= 	$this->employee_info->payroll_employee_id;
					 $temp['payroll_schedule_leave']				=	$payroll_schedule_leave;
					 $temp['date_filed']							=	Request::input('date_filed');
					 $temp['shop_id']								=	$this->employee_info->shop_id;
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

	     $return['status']             = 'success';
	     $return['function_name']      = 'employee_leave_management.ajax_all_load_leave';
	     return json_encode($return);
    	
    }
    
    public function employee_summary_of_leave()
	{
		$data['page']	= 'Summary of Leave';
		return view('member.payroll2.employee_dashboard.employee_summary_of_leave',$data);
	}

	public function authorized_access_leave()
	{
		$data['page']	= 'Authorized Access Leave';
		$data["_leave_name"] = tbl_payroll_leave_temp::where("shop_id", $this->employee_info->shop_id)->get();
		return view('member.payroll2.employee_dashboard.authorized_access_leave',$data);
	}

	public function employee_leave_management()
	{
		$data['page']			= 'Leave Management';
		// $data["_leave_info"]	= Tbl_payroll_leave_schedulev3::where("payroll_employee_id", $this->employee_info->payroll_employee_id)->get();	
	  	return view('member.payroll2.employee_dashboard.employee_leave_management',$data);
	}

	public function ajax_all_load_leave()
	{

		 $emp = Tbl_payroll_leave_schedulev3::select('tbl_payroll_leave_schedulev3.*','basicreliever.payroll_employee_display_name as payroll_employee_display_name_reliever','basicapprover.payroll_employee_display_name as payroll_employee_display_name_approver','tbl_payroll_leave_schedulev3.payroll_employee_id')
			->leftjoin('tbl_payroll_employee_basic AS basicreliever', 'basicreliever.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_reliever')
    		->leftjoin('tbl_payroll_employee_basic AS basicapprover', 'basicapprover.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_approver')
    		->where('tbl_payroll_leave_schedulev3.payroll_employee_id',$this->employee_info->payroll_employee_id)
   			 ->get();

		 return json_encode($emp);
	}

	public function ajax_load_pending_leave()
	{
		 $emp = Tbl_payroll_leave_schedulev3::select('tbl_payroll_leave_schedulev3.*','basicreliever.payroll_employee_display_name as payroll_employee_display_name_reliever','basicapprover.payroll_employee_display_name as payroll_employee_display_name_approver','tbl_payroll_leave_schedulev3.payroll_employee_id')
			->leftjoin('tbl_payroll_employee_basic AS basicreliever', 'basicreliever.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_reliever')
    		->leftjoin('tbl_payroll_employee_basic AS basicapprover', 'basicapprover.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_approver')
    		->where('tbl_payroll_leave_schedulev3.payroll_employee_id',$this->employee_info->payroll_employee_id)
    		->where('tbl_payroll_leave_schedulev3.status',"Pending")
   			 ->get();

		 return json_encode($emp);
	}

	public function ajax_load_approved_leave()
	{
		  $emp = Tbl_payroll_leave_schedulev3::select('tbl_payroll_leave_schedulev3.*','basicreliever.payroll_employee_display_name as payroll_employee_display_name_reliever','basicapprover.payroll_employee_display_name as payroll_employee_display_name_approver','tbl_payroll_leave_schedulev3.payroll_employee_id')
			->leftjoin('tbl_payroll_employee_basic AS basicreliever', 'basicreliever.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_reliever')
    		->leftjoin('tbl_payroll_employee_basic AS basicapprover', 'basicapprover.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_approver')
    		->where('tbl_payroll_leave_schedulev3.payroll_employee_id',$this->employee_info->payroll_employee_id)
    		->where('tbl_payroll_leave_schedulev3.status',"Approved")
   			 ->get();

		 return json_encode($emp);
	}

	public function ajax_load_rejected_leave()
	{
		  $emp = Tbl_payroll_leave_schedulev3::select('tbl_payroll_leave_schedulev3.*','basicreliever.payroll_employee_display_name as payroll_employee_display_name_reliever','basicapprover.payroll_employee_display_name as payroll_employee_display_name_approver','tbl_payroll_leave_schedulev3.payroll_employee_id')
			->leftjoin('tbl_payroll_employee_basic AS basicreliever', 'basicreliever.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_reliever')
    		->leftjoin('tbl_payroll_employee_basic AS basicapprover', 'basicapprover.payroll_employee_id', '=', 'tbl_payroll_leave_schedulev3.payroll_employee_id_approver')
    		->where('tbl_payroll_leave_schedulev3.payroll_employee_id',$this->employee_info->payroll_employee_id)
    		->where('tbl_payroll_leave_schedulev3.status',"Rejected")
   			 ->get();	

		 return json_encode($emp);
	}

	public function employee_leave_application()
	{

		$shop_id = $this->employee_info->shop_id;

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
}

