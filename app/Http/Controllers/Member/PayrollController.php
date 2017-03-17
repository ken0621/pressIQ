<?php
namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Request;
use Session;
use Carbon\Carbon;

use App\Models\Tbl_payroll_company;
use App\Models\Tbl_payroll_rdo;
use App\Models\Tbl_payroll_department;
use App\Models\Tbl_payroll_jobtitle;
use App\Models\Tbl_payroll_employment_status;
use App\Models\Tbl_payroll_civil_status;
use App\Models\Tbl_country;
use App\Models\Tbl_payroll_requirements;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_employee_salary;
use App\Models\Tbl_payroll_employee_requirements;
use App\Models\Tbl_payroll_tax_status;
use App\Models\Tbl_payroll_tax_reference;
use App\Models\Tbl_payroll_tax_period;
use App\Models\Tbl_payroll_tax_default;
use App\Models\Tbl_payroll_sss_default;
use App\Models\Tbl_payroll_sss;
use App\Models\Tbl_payroll_philhealth_default;
use App\Models\Tbl_payroll_philhealth;
use App\Models\Tbl_payroll_pagibig_default;
use App\Models\Tbl_payroll_pagibig;
use App\Models\Tbl_payroll_deduction_type;
use App\Models\Tbl_payroll_deduction;
use App\Models\Tbl_payroll_deduction_employee;
use App\Models\Tbl_payroll_deduction_payment;
use App\Models\Tbl_payroll_allowance;
use App\Models\Tbl_payroll_employee_allowance;
use App\Models\Tbl_payroll_holiday;
use App\Models\Tbl_payroll_holiday_company;

use App\Globals\Payroll;

class PayrollController extends Member
{

	public function shop_id()
	{
		return $shop_id = $this->user_info->user_shop;
	}

	/* EMPLOYEE START */

    public function employee_list()
	{	
	
		$active['shop_id'] 					= Self::shop_id();
		$active['company_id'] 				= 0;
		$active['employement_status'] 		= 0;
		$active['date'] 					= date('Y-m-d');
		$data['_active'] 					= Tbl_payroll_employee_basic::selemployee($active)->get();

		$separated['shop_id'] 				= Self::shop_id();
		$separated['company_id'] 			= 0;
		$separated['employement_status'] 	= 'separated';
		$separated['date'] 					= date('Y-m-d');

		$data['_separated'] 				= Tbl_payroll_employee_basic::selemployee($separated)->get();

		$data['_company']					= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();

		$active_status[0] 					= 1;
		$active_status[1] 					= 2;
		$active_status[2] 					= 3;
		$active_status[3] 					= 4;
		$active_status[4] 					= 5;
		$active_status[5] 					= 6;
		$active_status[7] 					= 7;
		$data['_status_active']				= Tbl_payroll_employment_status::whereIn('payroll_employment_status_id', $active_status)->orderBy('employment_status')->get();

		$separated_status[0]				= 8;
		$separated_status[1]				= 9;
		$data['_status_separated']			= Tbl_payroll_employment_status::whereIn('payroll_employment_status_id', $separated_status)->orderBy('employment_status')->get();
		// dd($data);
		return view('member.payroll.employeelist', $data);
	}   

	public function modal_create_employee()
	{
		$data['_company'] = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();
		$data['employement_status'] = Tbl_payroll_employment_status::get();
		$data['tax_status'] = Tbl_payroll_tax_status::get();
		$data['civil_status'] = Tbl_payroll_civil_status::get();
		$data['_country'] = Tbl_country::orderBy('country_name')->get();
		$data['_department'] = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();

		return view("member.payroll.modal.modal_create_employee", $data);
	}


	public function employee_updload_requirements()
	{
		$file = Request::file('file');
		// dd($file);

		$requirement_original_name 	= $file->getClientOriginalName();
		$requirement_extension_name = $file->getClientOriginalExtension();
		$requirement_mime_type		= $file->getMimeType();

		$requirement_new_name 		= value(function() use ($file){
            $filename = str_random(10). date('ymdhis') . '.' . $file->getClientOriginalExtension();
            return strtolower($filename);
        });

        $path = '/assets/payroll/employee_requirements';
        if (!file_exists($path)) {
		    mkdir($path, 0777, true);
		}
        $upload_success = $file->move(public_path($path), $requirement_new_name);

        $data = array();
        $status = 'error';
        if($upload_success)
        {

        	$insert['shop_id'] 								= Self::shop_id();
        	$insert['payroll_requirements_path']	 		= $path.'/'.$requirement_new_name;
        	$insert['payroll_requirements_original_name'] 	= $requirement_original_name;
        	$insert['payroll_requirements_extension_name'] 	= $requirement_extension_name;
        	$insert['payroll_requirements_mime_type'] 		= $requirement_mime_type;
        	$insert['payroll_requirements_date_upload'] 	= Carbon::now();

        	$payroll_requirements_id = Tbl_payroll_requirements::insertGetId($insert);

        	$data['path'] 					= $path.'/'.$requirement_new_name;
	        $data['original_name'] 			= $requirement_original_name;
	        $data['extension'] 				= $requirement_extension_name;
	        $data['mime_type'] 				= $requirement_mime_type;
	        $data['payroll_requirements_id'] = $payroll_requirements_id;
	        $status = 'success';
        }
        

        $return['status'] = $status;
        $return['data']	   = $data;

        return json_encode($return);
	}


	public function remove_employee_requirement()
	{
		$payroll_requirements_id = Request::input("content");
		$path = Tbl_payroll_requirements::where('payroll_requirements_id',$payroll_requirements_id)->pluck('payroll_requirements_path');
		Tbl_payroll_requirements::where('payroll_requirements_id',$payroll_requirements_id)->delete();
	}

	public function modal_employee_save()
	{
		/* employee basic info */
		$insert['shop_id']							= Self::shop_id();
		$insert['payroll_employee_title_name'] 		= Request::input('payroll_employee_title_name');
		$insert['payroll_employee_first_name'] 		= Request::input('payroll_employee_first_name');
		$insert['payroll_employee_middle_name'] 	= Request::input('payroll_employee_middle_name');
		$insert['payroll_employee_last_name'] 		= Request::input('payroll_employee_last_name');
		$insert['payroll_employee_suffix_name'] 	= Request::input('payroll_employee_suffix_name');
		$insert['payroll_employee_number'] 			= Request::input('payroll_employee_number');
		$insert['payroll_employee_atm_number'] 		= Request::input('payroll_employee_atm_number');
		$insert['payroll_employee_company_id'] 		= Request::input('payroll_employee_company_id');
		$insert['payroll_employee_contact'] 		= Request::input('payroll_employee_contact');
		$insert['payroll_employee_email'] 			= Request::input('payroll_employee_email');
		$insert['payroll_employee_display_name'] 	= Request::input('payroll_employee_display_name');
		$insert['payroll_employee_gender'] 			= Request::input('payroll_employee_gender');
		$insert['payroll_employee_birthdate'] 		= date('Y-m-d',strtotime(Request::input('payroll_employee_birthdate')));
		$insert['payroll_employee_street'] 			= Request::input('payroll_employee_street');
		$insert['payroll_employee_city'] 			= Request::input('payroll_employee_city');
		$insert['payroll_employee_state'] 			= Request::input('payroll_employee_state');
		$insert['payroll_employee_zipcode'] 		= Request::input('payroll_employee_zipcode');
		$insert['payroll_employee_country'] 		= Request::input('payroll_employee_country');
		$insert['payroll_employee_tax_status'] 		= Request::input('payroll_employee_tax_status');
		$insert['payroll_employee_tin'] 			= Request::input('payroll_employee_tin');
		$insert['payroll_employee_sss'] 			= Request::input('payroll_employee_sss');
		$insert['payroll_employee_philhealth'] 		= Request::input('payroll_employee_philhealth');
		$insert['payroll_employee_pagibig'] 		= Request::input('payroll_employee_pagibig');
		$insert['payroll_employee_remarks'] 		= Request::input('payroll_employee_remarks');

		$payroll_employee_id = Tbl_payroll_employee_basic::insertGetId($insert);


		/* employee contract */
		$insert_contract['payroll_employee_id']						= $payroll_employee_id;
		$insert_contract['payroll_department_id'] 					= Request::input("payroll_department_id");
		$insert_contract['payroll_jobtitle_id'] 					= Request::input("payroll_jobtitle_id");
		$insert_contract['payroll_employee_contract_date_hired'] 	= Request::input("payroll_employee_contract_date_hired");
		$insert_contract['payroll_employee_contract_date_end'] 		= Request::input("payroll_employee_contract_date_end");
		$insert_contract['payroll_employee_contract_status'] 		= Request::input("payroll_employee_contract_status");
		$insert_contract['payroll_group_id'] 						= Request::input("payroll_group_id");

		Tbl_payroll_employee_contract::insert($insert_contract);


		/* employee salary details */
		$insert_salary['payroll_employee_id'] 						= $payroll_employee_id;
		$insert_salary['payroll_employee_salary_effective_date'] 	= date('Y-m-d',strtotime(Request::input('payroll_employee_contract_date_hired')));
		$payroll_employee_salary_minimum_wage = 0;
		if(Request::has('payroll_employee_salary_minimum_wage'))
		{
			$payroll_employee_salary_minimum_wage 					= Request::input('payroll_employee_salary_minimum_wage');
		}

		$insert_salary['payroll_employee_salary_minimum_wage'] 		= $payroll_employee_salary_minimum_wage;
		$insert_salary['payroll_employee_salary_monthly'] 			= Request::input('payroll_employee_salary_monthly');
		$insert_salary['payroll_employee_salary_daily'] 			= Request::input('payroll_employee_salary_daily');
		$insert_salary['payroll_employee_salary_taxable'] 			= Request::input('payroll_employee_salary_taxable');
		$insert_salary['payroll_employee_salary_sss'] 				= Request::input('payroll_employee_salary_sss');
		$insert_salary['payroll_employee_salary_pagibig'] 			= Request::input('payroll_employee_salary_pagibig');
		$insert_salary['payroll_employee_salary_philhealth'] 		= Request::input('payroll_employee_salary_philhealth');
		$insert_salary['payroll_employee_salary_cola']				= Request::input('payroll_employee_salary_cola');

		Tbl_payroll_employee_salary::insert($insert_salary);


		
		$has_resume = 0;
		if(Request::has('has_resume'))
		{
			$has_resume = Request::input('has_resume');
		}

		$has_police_clearance = 0;
		if(Request::has('has_police_clearance'))
		{
			$has_police_clearance = Request::input('has_police_clearance');
		}

		$has_nbi = 0;
		if(Request::has('has_nbi'))
		{
			$has_nbi = Request::input('has_nbi');
		}

		$has_health_certificate = 0;
		if(Request::has('has_health_certificate'))
		{
			$has_health_certificate = Request::input('has_health_certificate');
		}

		$has_school_credentials = 0;
		if(Request::has('has_school_credentials'))
		{
			$has_school_credentials = Request::input('has_school_credentials');
		}

		$has_valid_id = 0;
		if(Request::has('has_valid_id'))
		{
			$has_valid_id = Request::input('has_valid_id');
		}

		$insert_requirements['payroll_employee_id']					= $payroll_employee_id;
		$insert_requirements['has_resume'] 							= $has_resume;
		$insert_requirements['resume_requirements_id'] 				= Request::input('resume_requirements_id');
		$insert_requirements['has_police_clearance'] 				= $has_police_clearance;
		$insert_requirements['police_clearance_requirements_id'] 	= Request::input('police_clearance_requirements_id');
		$insert_requirements['has_nbi'] 							= $has_nbi;
		$insert_requirements['nbi_payroll_requirements_id'] 		= Request::input('nbi_payroll_requirements_id');
		$insert_requirements['has_health_certificate'] 				= $has_health_certificate;
		$insert_requirements['health_certificate_requirements_id'] 	= Request::input('health_certificate_requirements_id');
		$insert_requirements['has_school_credentials'] 				= $has_school_credentials;
		$insert_requirements['school_credentials_requirements_id'] 	= Request::input('school_credentials_requirements_id');
		$insert_requirements['has_valid_id'] 						= $has_valid_id;
		$insert_requirements['valid_id_requirements_id'] 			= Request::input('valid_id_requirements_id');
		Tbl_payroll_employee_requirements::insert($insert_requirements);

		$return['data'] = '';
		$return['status'] = 'success';
		$return['function_name'] = 'employeelist.reload_employee_list';

		return json_encode($return);

	}

	public function modal_employee_view($id)
	{
		$data['_company'] 			= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();
		$data['employement_status'] = Tbl_payroll_employment_status::get();
		$data['tax_status'] 		= Tbl_payroll_tax_status::get();
		$data['civil_status'] 		= Tbl_payroll_civil_status::get();
		$data['_country'] 			= Tbl_country::orderBy('country_name')->get();
		$data['_department'] 		= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		$data['_jobtitle']			= Tbl_payroll_jobtitle::sel(Self::shop_id())->orderBy('payroll_jobtitle_name')->get();

		$data['employee'] 			= Tbl_payroll_employee_basic::where('payroll_employee_id',$id)->first();
		$data['contract'] 			= Tbl_payroll_employee_contract::selemployee($id)->first();

		$data['salary']				= Tbl_payroll_employee_salary::selemployee($id)->first();
		$data['requirement']		= Tbl_payroll_employee_requirements::selrequirements($id)->first();
		// dd($data['requirement']);

		return view("member.payroll.modal.modal_view_employee", $data);
	}

	public function modal_view_contract_list($id)
	{
		$data['_active'] = Tbl_payroll_employee_contract::contractlist($id)->get();
		return view('member.payroll.modal.modal_view_contract_list', $data);
	}
	public function modal_create_contract($id)
	{
		$data['employee_id'] = $id;
		$data['employement_status'] = Tbl_payroll_employment_status::get();
		$data['_department'] = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		return view('member.payroll.modal.modal_create_contract',$data);
	}

	public function modal_save_contract()
	{
		$insert['payroll_employee_id'] 					= Request::input('payroll_employee_id');
		$insert['payroll_department_id'] 				= Request::input('payroll_department_id');
		$insert['payroll_jobtitle_id'] 					= Request::input('payroll_jobtitle_id');
		$insert['payroll_employee_contract_date_hired'] = date('Y-m-d',strtotime(Request::input('payroll_employee_contract_date_hired')));
		$insert['payroll_employee_contract_date_end'] 	= date('Y-m-d',strtotime(Request::input('payroll_employee_contract_date_end')));
		$insert['payroll_group_id'] 					= Request::input('payroll_group_id');
		$insert['payroll_employee_contract_status'] 	= Request::input('payroll_employee_contract_status');
		Tbl_payroll_employee_contract::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}


	public function modal_salary_list($id)
	{	
		$data['_active'] = Tbl_payroll_employee_salary::salaylist($id)->get();
		return view('member.payroll.modal.modal_salary_list', $data);
	}

	public function modal_create_salary_adjustment($id)
	{
		$data['employee_id'] = $id;
		return view('member.payroll.modal.modal_create_salary', $data);
	}

	public function modal_save_salary()
	{
		$insert['payroll_employee_id'] 					= Request::input('payroll_employee_id');
		$insert['payroll_employee_salary_monthly'] 		= Request::input('payroll_employee_salary_monthly');
		$insert['payroll_employee_salary_daily'] 		= Request::input('payroll_employee_salary_daily');
		$insert['payroll_employee_salary_taxable'] 		= Request::input('payroll_employee_salary_taxable');
		$insert['payroll_employee_salary_sss'] 			= Request::input('payroll_employee_salary_sss');
		$insert['payroll_employee_salary_philhealth'] 	= Request::input('payroll_employee_salary_philhealth');
		$insert['payroll_employee_salary_pagibig'] 		= Request::input('payroll_employee_salary_pagibig');

		$payroll_employee_salary_minimum_wage = 0;
		if(Request::has('payroll_employee_salary_minimum_wage'))
		{
			$payroll_employee_salary_minimum_wage = Request::input('payroll_employee_salary_minimum_wage');
		}

		$insert['payroll_employee_salary_minimum_wage'] = $payroll_employee_salary_minimum_wage;
		$insert['payroll_employee_salary_effective_date'] = date('Y-m-d',strtotime(Request::input('payroll_employee_salary_effective_date')));
		$insert['payroll_employee_salary_cola']			= Request::input('payroll_employee_salary_cola');
		Tbl_payroll_employee_salary::insert($insert);
		$return['status'] = 'success';
		
		return json_encode($return);
	}

	public function modal_employee_update()
	{
		$payroll_employee_id 							= Request::input('payroll_employee_id');
		$update_basic['payroll_employee_title_name'] 	= Request::input('payroll_employee_title_name');
		$update_basic['payroll_employee_first_name'] 	= Request::input('payroll_employee_first_name');
		$update_basic['payroll_employee_middle_name'] 	= Request::input('payroll_employee_middle_name');
		$update_basic['payroll_employee_last_name'] 	= Request::input('payroll_employee_last_name');
		$update_basic['payroll_employee_suffix_name'] 	= Request::input('payroll_employee_suffix_name');
		$update_basic['payroll_employee_number'] 		= Request::input('payroll_employee_number');
		$update_basic['payroll_employee_atm_number'] 	= Request::input('payroll_employee_atm_number');
		$update_basic['payroll_employee_company_id'] 	= Request::input('payroll_employee_company_id');
		$update_basic['payroll_employee_contact'] 		= Request::input('payroll_employee_contact');
		$update_basic['payroll_employee_email'] 		= Request::input('payroll_employee_email');
		$update_basic['payroll_employee_display_name'] 	= Request::input('payroll_employee_display_name');
		$update_basic['payroll_employee_gender'] 		= Request::input('payroll_employee_gender');
		$update_basic['payroll_employee_street'] 		= Request::input('payroll_employee_street');
		$update_basic['payroll_employee_city'] 			= Request::input('payroll_employee_city');
		$update_basic['payroll_employee_state'] 		= Request::input('payroll_employee_state');
		$update_basic['payroll_employee_zipcode'] 		= Request::input('payroll_employee_zipcode');
		$update_basic['payroll_employee_country'] 		= Request::input('payroll_employee_country');
		$update_basic['payroll_employee_tax_status'] 	= Request::input('payroll_employee_tax_status');
		$update_basic['payroll_employee_tin'] 			= Request::input('payroll_employee_tin');
		$update_basic['payroll_employee_sss'] 			= Request::input('payroll_employee_sss');
		$update_basic['payroll_employee_philhealth'] 	= Request::input('payroll_employee_philhealth');
		$update_basic['payroll_employee_pagibig'] 		= Request::input('payroll_employee_pagibig');
		$update_basic['payroll_employee_remarks']		= Request::input('payroll_employee_remarks');

		Tbl_payroll_employee_basic::where('payroll_employee_id',$payroll_employee_id)->update($update_basic);

		$return['function_name'] = 'employeelist.reload_employee_list';
		$return['status'] = 'success';
		return json_encode($return);
	}

	public function reload_employee_list()
	{
		$company_id = 0;
		$employement_status = 0;
		if(Request::has('company_id'))
		{
			$company_id = Request::input('company_id');
		}
		if(Request::has('employement_status'))
		{
			$employement_status = Request::input('employement_status');
		}
		$parameter['date'] 					= date('Y-m-d');
		$parameter['company_id'] 			= $company_id;
		$parameter['employement_status'] 	= $employement_status;
		$parameter['shop_id'] 				= Self::shop_id();
		$data['_active'] = Tbl_payroll_employee_basic::selemployee($parameter)->get();

		return view('member.payroll.reload.employee_list_reload', $data);
	}

	/* EMPLOYEE END */

	public function payroll_configuration()
	{
		return view('member.payroll.payrollconfiguration');
	}


	/* COMPANY START */

	public function company_list()
	{
		$data['_active'] = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();
		$data['_archived'] = Tbl_payroll_company::selcompany(Self::shop_id(),1)->orderBy('tbl_payroll_company.payroll_company_name')->get();

		return view('member.payroll.companylist', $data);
	}

	public function modal_create_company()
	{
		$company_logo = '';
		if(Session::has('company_logo'))
		{
			$company_logo = Session::get('company_logo');
		}
		$data['company_logo'] = $company_logo;
		$data['_rdo'] = Tbl_payroll_rdo::orderBy('rdo_code')->get();
		$data['_company'] = Tbl_payroll_company::selcompany(Self::shop_id())->where('payroll_parent_company_id',0)->orderBy('tbl_payroll_company.payroll_company_name')->get();
		return view('member.payroll.modal.modal_create_company', $data);
	}

	public function upload_company_logo()
	{
		$file = Request::file('file');
        $ImagName = value(function() use ($file){
            $filename = str_random(10). date('ymdhis') . '.' . $file->getClientOriginalExtension();
            return strtolower($filename);
        });
        $path = '/assets/payroll/company_logo';
        if (!file_exists($path)) {
		    mkdir($path, 0777, true);
		}
        $file->move(public_path($path), $ImagName);

        $session_logo = 'company_logo';
        if(Request::input('action') == 'update')
        {
        	$session_logo = 'company_logo_update';
        }

        Session::put($session_logo,$path.'/'.$ImagName);

        return $path.'/'.$ImagName;
	}

	public function modal_save_company()
	{
		$insert['payroll_company_name'] 				= Request::input('payroll_company_name');
		$insert['payroll_company_code'] 				= Request::input('payroll_company_code');
		$insert['payroll_company_rdo'] 					= Request::input('payroll_company_rdo');
		$insert['payroll_company_address'] 				= Request::input('payroll_company_address');
		$insert['payroll_company_contact'] 				= Request::input('payroll_company_contact');
		$insert['payroll_company_email'] 				= Request::input('payroll_company_email');
		$insert['payroll_company_nature_of_business'] 	= Request::input('payroll_company_nature_of_business');
		$insert['payroll_company_date_started'] 		= Request::input('payroll_company_date_started');
		$insert['payroll_company_tin'] 					= Request::input('payroll_company_tin');
		$insert['payroll_company_sss'] 					= Request::input('payroll_company_sss');
		$insert['payroll_company_philhealth'] 			= Request::input('payroll_company_philhealth');
		$insert['payroll_company_pagibig'] 				= Request::input('payroll_company_pagibig');
		$insert['shop_id']								= Self::shop_id();
		$insert['payroll_parent_company_id']			= Request::input('payroll_parent_company_id');

		$logo = '/assets/images/no-logo.png';
		if(Session::has('company_logo'))
		{
			$logo = Session::get('company_logo');
		}
		$insert['payroll_company_logo'] = $logo;
		Tbl_payroll_company::insert($insert);
		Session::forget('company_logo');

		$return['function_name'] = 'companylist.save_company';
		$return['status'] = 'success';
		$return['data'] = '';

		return json_encode($return);
	}

	public function view_company_modal($id)
	{
		return Self::modal_company_operation($id);
	}

	public function edit_company_modal($id)
	{
		return Self::modal_company_operation($id, 'edit');
	}

	public function modal_company_operation($company_id = 0, $action = 'view')
	{
		$data['company'] = Tbl_payroll_company::where('payroll_company_id', $company_id)->first();
		$data['_rdo'] = Tbl_payroll_rdo::orderBy('rdo_code')->get();
		$data['action'] = $action;
		Session::put('company_logo_update', $data['company']->payroll_company_logo);
		$data['_company'] = Tbl_payroll_company::selcompany(Self::shop_id())->where('payroll_parent_company_id',0)->orderBy('tbl_payroll_company.payroll_company_name')->get();
		return view('member.payroll.modal.modal_view_company', $data);
	}

	public function update_company()
	{
		$payroll_company_id 							= Request::input('payroll_company_id');
		$update['payroll_company_name'] 				= Request::input('payroll_company_name');
		$update['payroll_company_code'] 				= Request::input('payroll_company_code');
		$update['payroll_company_rdo'] 					= Request::input('payroll_company_rdo');
		$update['payroll_company_address'] 				= Request::input('payroll_company_address');
		$update['payroll_company_contact'] 				= Request::input('payroll_company_contact');
		$update['payroll_company_email'] 				= Request::input('payroll_company_email');
		$update['payroll_company_nature_of_business'] 	= Request::input('payroll_company_nature_of_business');
		$update['payroll_company_date_started'] 		= Request::input('payroll_company_date_started');
		$update['payroll_company_tin'] 					= Request::input('payroll_company_tin');
		$update['payroll_company_sss'] 					= Request::input('payroll_company_sss');
		$update['payroll_company_philhealth'] 			= Request::input('payroll_company_philhealth');
		$update['payroll_company_pagibig'] 				= Request::input('payroll_company_pagibig');
		$update['payroll_parent_company_id']			= Request::input('payroll_parent_company_id');
		$logo = '/assets/images/no-logo.png';
		if(Session::has('company_logo_update'))
		{
			$logo = Session::get('company_logo_update');
			Session::forget('company_logo_update');
		}
		$update['payroll_company_logo'] 				= $logo;
		Tbl_payroll_company::where('payroll_company_id', $payroll_company_id)->update($update);

		$return['function_name'] = 'companylist.save_company';
		$return['status'] = 'success';
		$return['data'] = '';

		return json_encode($return);
	}

	public function reload_company()
	{
		$archived = Request::input('archived');
		$data['_active'] = Tbl_payroll_company::selcompany(Self::shop_id(), $archived)->orderBy('tbl_payroll_company.payroll_company_name')->get();
		return view('member.payroll.reload.companylist_reload',$data);
	}

	public function archived_company()
	{
		$archived 	= Request::input('archived');
		$content	= Request::input('content');
		$update['payroll_company_archived'] = $archived;
		Tbl_payroll_company::where('payroll_company_id', $content)->update($update);
	}

	/* COMPANY END */


	/* DEPARTMENT START */
	public function department_list()
	{
		$data['_active'] = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		$data['_archived'] = Tbl_payroll_department::sel(Self::shop_id(), 1)->orderBy('payroll_department_name')->get();
		return view('member.payroll.side_container.departmentlist', $data);
	}

	public function department_modal_create()
	{
		return view('member.payroll.modal.modal_create_department');
	}


	public function department_save()
	{
		$insert['payroll_department_name'] = Request::input('payroll_department_name');
		$insert['shop_id']				   = Self::shop_id();
		Tbl_payroll_department::insert($insert);

		$return['status'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.relaod_tbl_department';
		return json_encode($return);
	}

	public function department_reload()
	{
		$archived = Request::input('archived');
		$data['_active'] = Tbl_payroll_department::sel(Self::shop_id(), $archived)->orderBy('payroll_department_name')->get();
 		return view('member.payroll.reload.departmentlist_reload', $data);
	}

	public function archived_department()
	{
		$archived = Request::input('archived');
		$content  = Request::input('content');
		$update['payroll_department_archived'] = $archived;
		Tbl_payroll_department::where('payroll_department_id',$content)->update($update);

		$return['status'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.relaod_tbl_department';
		return json_encode($return);
	}

	public function modal_view_department($id)
	{
		return Self::modal_department_operation($id);
	}

	public function modal_edit_department($id)
	{
		$action = 'edit';
		return Self::modal_department_operation($id, $action);
	}

	public function modal_department_operation($payroll_department_id = 0, $action = 'view')
	{
		$data['deparmtent'] = Tbl_payroll_department::where('payroll_department_id', $payroll_department_id)->first();
		$data['action'] = $action;
		return view('member.payroll.modal.modal_view_department',$data);
	}


	public function modal_update_department()
	{
		
		$payroll_department_id = Request::input('payroll_department_id');
		$payroll_department_name = Request::input('payroll_department_name');

		$update['payroll_department_name'] = $payroll_department_name;
		Tbl_payroll_department::where('payroll_department_id', $payroll_department_id)->update($update);
		
		$return['status'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.relaod_tbl_department';
		return json_encode($return);
	}

	/* DEPARTMENT END */


	/* JOB TITLE START*/

	public function jobtitle_list()
	{
		$data['_active'] = Tbl_payroll_jobtitle::sel(Self::shop_id())->orderBy('payroll_jobtitle_name')->get();
		$data['_archived'] = Tbl_payroll_jobtitle::sel(Self::shop_id(), 1)->orderBy('payroll_jobtitle_name')->get();
		return view('member.payroll.side_container.jobtitlelist', $data);
	}

	public function modal_create_jobtitle()
	{
		$data['_department'] = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		return view('member.payroll.modal.modal_create_jobtitle', $data);
	}

	public function modal_save_jobtitle()
	{
		$insert['payroll_jobtitle_department_id'] 	= Request::input('payroll_jobtitle_department_id');
		$insert['payroll_jobtitle_name'] 			= Request::input('payroll_jobtitle_name');
		$insert['shop_id']							= Self::shop_id();
		Tbl_payroll_jobtitle::insert($insert);

		$return['status'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.reload_tbl_jobtitle';
		return json_encode($return);
	}


	public function archived_jobtitle()
	{
		$archived = Request::input('archived');
		$content  = Request::input("content");
		$update['payroll_jobtitle_archived'] = $archived;
		Tbl_payroll_jobtitle::where('payroll_jobtitle_id', $content)->update($update);

		$return['status'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.reload_tbl_jobtitle';
		return json_encode($return);
	}

	public function reload_tbl_jobtitle()
	{
		$archived = Request::input('archived');
		$data['_active'] = Tbl_payroll_jobtitle::sel(Self::shop_id(), $archived)->orderBy('payroll_jobtitle_name')->get();
		return view('member.payroll.reload.jobtitlelist_reload',$data);
	}

	public function modal_view_jobtitle($id)
	{

		return Self::moda_view_jobtitle_operation($id);
	}

	public function modal_edit_jobtitle($id)
	{
		return Self::moda_view_jobtitle_operation($id, 'edit');
	}

	public function moda_view_jobtitle_operation($payroll_jobtitle_id = 0, $action = "view")
	{
		$data['position'] = Tbl_payroll_jobtitle::where('payroll_jobtitle_id', $payroll_jobtitle_id)->first();
		$data['_department'] = Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();
		$data['action'] = $action;
		return view('member.payroll.modal.modal_view_jobtitlelist',$data);
	}

	public function modal_update_jobtitle()
	{
		$payroll_jobtitle_id 						= Request::input('payroll_jobtitle_id');
		$update['payroll_jobtitle_department_id'] 	= Request::input('payroll_jobtitle_department_id');
		$update['payroll_jobtitle_name'] 			= Request::input('payroll_jobtitle_name');
		Tbl_payroll_jobtitle::where('payroll_jobtitle_id', $payroll_jobtitle_id)->update($update);

		$return['status'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.reload_tbl_jobtitle';
		return json_encode($return);
	}

	/* GET JOB TITLE BY DEPARTMENT */
	public function get_job_title_by_department()
	{
		$payroll_department_id = Request::input('payroll_department_id');
		// dd($payroll_department_id);
		$job_title = Tbl_payroll_jobtitle::where('payroll_jobtitle_department_id',$payroll_department_id)->where('payroll_jobtitle_archived',0)->where('shop_id', Self::shop_id())->get();

		return json_encode($job_title);
	}

	/* JOB TITLE END*/



	/* TAX TABLE START */
	public function tax_table_list()
	{
		$data['_period'] = Payroll::tax_break(Self::shop_id());
		// dd($data);
		return view('member.payroll.side_container.tax', $data);
	}

	public function tax_table_save()
	{
		$payroll_tax_status_id 	= Request::input('payroll_tax_status_id');
		$tax_category 			= Request::input('tax_category');
		$tax_first_range 		= Request::input('tax_first_range');
		$tax_second_range 		= Request::input('tax_second_range');
		$tax_third_range 		= Request::input('tax_third_range');
		$tax_fourth_range 		= Request::input('tax_fourth_range');
		$tax_fifth_range 		= Request::input('tax_fifth_range');
		$taxt_sixth_range 		= Request::input('taxt_sixth_range');
		$tax_seventh_range 		= Request::input('tax_seventh_range');

		Tbl_payroll_tax_reference::where('shop_id', Self::shop_id())->where('payroll_tax_status_id',$payroll_tax_status_id)->delete();
		$insert = array();
		foreach($tax_category as $key => $category)
		{
			$insert[$key]['shop_id']				= Self::shop_id();
			$insert[$key]['payroll_tax_status_id'] 	= $payroll_tax_status_id;
			$insert[$key]['tax_category'] 			= $category;
			$insert[$key]['tax_first_range'] 		= $tax_first_range[$key];
			$insert[$key]['tax_second_range'] 		= $tax_second_range[$key];
			$insert[$key]['tax_third_range'] 		= $tax_third_range[$key];
			$insert[$key]['tax_fourth_range'] 		= $tax_fourth_range[$key];
			$insert[$key]['tax_fifth_range'] 		= $tax_fifth_range[$key];
			$insert[$key]['taxt_sixth_range'] 		= $taxt_sixth_range[$key];
			$insert[$key]['tax_seventh_range'] 		= $tax_seventh_range[$key];
		}

		Tbl_payroll_tax_reference::insert($insert);

		$return['status'] = 'success';
		$return['function_name'] = '';
		return json_encode($return);

	}


	/* FOR DEVELOPERS USE ONLY */
	public function tax_table_save_default()
	{
		$payroll_tax_status_id 	= Request::input('payroll_tax_status_id');
		$tax_category 			= Request::input('tax_category');
		$tax_first_range 		= Request::input('tax_first_range');
		$tax_second_range	 	= Request::input('tax_second_range');
		$tax_third_range 		= Request::input('tax_third_range');
		$tax_fourth_range 		= Request::input('tax_fourth_range');
		$tax_fifth_range 		= Request::input('tax_fifth_range');
		$taxt_sixth_range 		= Request::input('taxt_sixth_range');
		$tax_seventh_range 		= Request::input('tax_seventh_range');
		Tbl_payroll_tax_default::where('payroll_tax_status_id',$payroll_tax_status_id)->delete();
		$insert = array();
		foreach($tax_category as $key => $category)
		{
			$insert[$key]['payroll_tax_status_id'] 	= $payroll_tax_status_id;
			$insert[$key]['tax_category'] 			= $category;
			$insert[$key]['tax_first_range'] 		= $tax_first_range[$key];
			$insert[$key]['tax_second_range'] 		= $tax_second_range[$key];
			$insert[$key]['tax_third_range'] 		= $tax_third_range[$key];
			$insert[$key]['tax_fourth_range'] 		= $tax_fourth_range[$key];
			$insert[$key]['tax_fifth_range'] 		= $tax_fifth_range[$key];
			$insert[$key]['taxt_sixth_range'] 		= $taxt_sixth_range[$key];
			$insert[$key]['tax_seventh_range'] 		= $tax_seventh_range[$key];
		}

		Tbl_payroll_tax_default::insert($insert);

		$return['status'] = 'success';
		$return['function_name'] = '';
		return json_encode($return);
	}
	/* TAX TABLE END */


	/* SSS TABLE START */
	public function sss_table_list()
	{
		$data['_sss'] = Tbl_payroll_sss::where('shop_id', Self::shop_id())->orderBy('payroll_sss_min')->get();
		return view('member.payroll.side_container.ssslist', $data);
	}

	public function sss_table_save()
	{
		$payroll_sss_min 			= Request::input('payroll_sss_min');
		$payroll_sss_max 			= Request::input('payroll_sss_max');
		$payroll_sss_monthly_salary = Request::input('payroll_sss_monthly_salary');
		$payroll_sss_er 			= Request::input('payroll_sss_er');
		$payroll_sss_ee 			= Request::input('payroll_sss_ee');
		$payroll_sss_total 			= Request::input('payroll_sss_total');
		$payroll_sss_eec 			= Request::input('payroll_sss_eec');

		Tbl_payroll_sss::where('shop_id', Self::shop_id())->delete();
		$insert = array();
		foreach($payroll_sss_min as $key => $sss_min)
		{
			if($sss_min != '' && $sss_min != null)
			{	
				$insert[$key]['shop_id'] 					= Self::shop_id();
				$insert[$key]['payroll_sss_min'] 			= $sss_min;
				$insert[$key]['payroll_sss_max'] 			= $payroll_sss_max[$key];
				$insert[$key]['payroll_sss_monthly_salary'] = $payroll_sss_monthly_salary[$key];
				$insert[$key]['payroll_sss_er'] 			= $payroll_sss_er[$key];
				$insert[$key]['payroll_sss_ee'] 			= $payroll_sss_ee[$key];
				$insert[$key]['payroll_sss_total'] 			= $payroll_sss_total[$key];
				$insert[$key]['payroll_sss_eec'] 			= $payroll_sss_eec[$key];
			}
		}
		Tbl_payroll_sss::insert($insert);
		$return['status'] = 'success';
		return json_encode($return);
	}



	/* SSS DEFAULT VALUE [DEVELOPER] */
	public function sss_table_save_default()
	{
		$payroll_sss_min 			= Request::input('payroll_sss_min');
		$payroll_sss_max 			= Request::input('payroll_sss_max');
		$payroll_sss_monthly_salary = Request::input('payroll_sss_monthly_salary');
		$payroll_sss_er 			= Request::input('payroll_sss_er');
		$payroll_sss_ee 			= Request::input('payroll_sss_ee');
		$payroll_sss_total 			= Request::input('payroll_sss_total');
		$payroll_sss_eec 			= Request::input('payroll_sss_eec');

		Tbl_payroll_sss_default::truncate();
		$insert = array();
		foreach($payroll_sss_min as $key => $sss_min)
		{
			$insert[$key]['payroll_sss_min'] = $sss_min;
			$insert[$key]['payroll_sss_max'] = $payroll_sss_max[$key];
			$insert[$key]['payroll_sss_monthly_salary'] = $payroll_sss_monthly_salary[$key];
			$insert[$key]['payroll_sss_er'] = $payroll_sss_er[$key];
			$insert[$key]['payroll_sss_ee'] = $payroll_sss_ee[$key];
			$insert[$key]['payroll_sss_total'] = $payroll_sss_total[$key];
			$insert[$key]['payroll_sss_eec'] = $payroll_sss_eec[$key];
		}
		Tbl_payroll_sss_default::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);

	}
	/* SSS TABLE END */


	/* PHILHEALTH TABLE START */
	public function philhealth_table_list()
	{
		$data['_philhealth'] = Tbl_payroll_philhealth::where('shop_id', Self::shop_id())->orderBy('payroll_philhealth_min')->get();
		return view('member.payroll.side_container.philhealthlist', $data);
	}

	public function philhealth_table_save()
	{
		$payroll_philhealth_min 		= Request::input('payroll_philhealth_min');
		$payroll_philhealth_max 		= Request::input('payroll_philhealth_max');
		$payroll_philhealth_base 		= Request::input('payroll_philhealth_base');
		$payroll_philhealth_premium 	= Request::input('payroll_philhealth_premium');
		$payroll_philhealth_ee_share 	= Request::input('payroll_philhealth_ee_share');
		$payroll_philhealth_er_share 	= Request::input('payroll_philhealth_er_share');
		Tbl_payroll_philhealth::where('shop_id', Self::shop_id())->delete();
		$insert = array();
		foreach($payroll_philhealth_min as $key => $min)
		{
			if($min != "" && $min != null)
			{
				$insert[$key]['shop_id']						= Self::shop_id();
				$insert[$key]['payroll_philhealth_min'] 		= $min;
				$insert[$key]['payroll_philhealth_max'] 		= $payroll_philhealth_max[$key];
				$insert[$key]['payroll_philhealth_base'] 		= $payroll_philhealth_base[$key];
				$insert[$key]['payroll_philhealth_premium'] 	= $payroll_philhealth_premium[$key];
				$insert[$key]['payroll_philhealth_ee_share'] 	= $payroll_philhealth_ee_share[$key];
				$insert[$key]['payroll_philhealth_er_share'] 	= $payroll_philhealth_er_share[$key];
			}
			
		}
		Tbl_payroll_philhealth::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}


	/* PHILHEALTH DEFAULT VALUE [DEVELOPER] */
	public function philhealth_table_save_default()
	{
		$payroll_philhealth_min 		= Request::input('payroll_philhealth_min');
		$payroll_philhealth_max 		= Request::input('payroll_philhealth_max');
		$payroll_philhealth_base 		= Request::input('payroll_philhealth_base');
		$payroll_philhealth_premium 	= Request::input('payroll_philhealth_premium');
		$payroll_philhealth_ee_share 	= Request::input('payroll_philhealth_ee_share');
		$payroll_philhealth_er_share 	= Request::input('payroll_philhealth_er_share');

		Tbl_payroll_philhealth_default::truncate();
		$insert = array();
		foreach($payroll_philhealth_min as $key => $min)
		{
			if($min != "" && $min != null)
			{
				$insert[$key]['payroll_philhealth_min'] 		= $min;
				$insert[$key]['payroll_philhealth_max'] 		= $payroll_philhealth_max[$key];
				$insert[$key]['payroll_philhealth_base'] 		= $payroll_philhealth_base[$key];
				$insert[$key]['payroll_philhealth_premium'] 	= $payroll_philhealth_premium[$key];
				$insert[$key]['payroll_philhealth_ee_share'] 	= $payroll_philhealth_ee_share[$key];
				$insert[$key]['payroll_philhealth_er_share'] 	= $payroll_philhealth_er_share[$key];
			}
			
		}
		Tbl_payroll_philhealth_default::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}


	/* PHILHEALTH TABLE END */
	public function pagibig_formula()
	{
		$data['pagibig'] = Tbl_payroll_pagibig::where('shop_id', Self::shop_id())->first();
		return view('member.payroll.side_container.pagibig', $data);
	}

	public function pagibig_formula_save()
	{
		Tbl_payroll_pagibig::where('shop_id', Self::shop_id())->delete();

		$insert['payroll_pagibig_percent']  = Request::input('payroll_pagibig_percent');
		$insert['shop_id']					= Self::shop_id();
		Tbl_payroll_pagibig::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}



	/* PAGIBIG DEFAULT VALUE [DEVELOPER] */
	public function pagibig_formula_save_default()
	{
		Tbl_payroll_pagibig_default::truncate();
		$insert['payroll_pagibig_percent'] = Request::input('payroll_pagibig_percent');
		Tbl_payroll_pagibig_default::insert($insert);

		$return['status'] = 'success';
		return json_encode($return);
	}
	/* PAGIBIG TABLE START */


	/* DEDUCTION START */
	public function deduction()
	{
		$data['_active'] = Tbl_payroll_deduction::seldeduction(Self::shop_id())->orderBy('tbl_payroll_deduction.payroll_deduction_category','tbl_payroll_deduction.payroll_deduction_name')->get();
		$data['_archived'] = Tbl_payroll_deduction::seldeduction(Self::shop_id(), 1)->orderBy('tbl_payroll_deduction.payroll_deduction_category','tbl_payroll_deduction.payroll_deduction_name')->get();
		return view('member.payroll.side_container.deduction', $data);
	}

	public function modal_create_deduction()
	{
		$array = array();
		Session::put('employee_deduction_tag',$array);
		return view('member.payroll.modal.modal_create_deduction');
	}

	public function modal_create_deduction_type($type)
	{
		$type 				= str_replace('_', ' ', $type);
		$data['_active'] 	= Tbl_payroll_deduction_type::seltype(Self::shop_id(),$type)->get();
		$data['_archived'] 	= Tbl_payroll_deduction_type::seltype(Self::shop_id(),$type, 1)->get();
		$data['type'] 		= $type;
		return view('member.payroll.modal.modal_deduction_type',$data);
	}

	public function modal_save_deduction_type()
	{
		$insert['payroll_deduction_category'] 	= Request::input('payroll_deduction_category');
		$insert['payroll_deduction_type_name'] 	= Request::input('payroll_deduction_type_name');
		$insert['shop_id'] 						= Self::shop_id();
		$id = Tbl_payroll_deduction_type::insertGetId($insert);

		$type = Request::input('payroll_deduction_category');

		$_data = Tbl_payroll_deduction_type::seltype(Self::shop_id(),$type)->get();
		$html = '<option value="">Select Type</option>';
		foreach($_data as $data)
		{
			$html .= '<option value="'.$data->payroll_deduction_type_id.'" ';
			if($data->payroll_deduction_type_id == $id)
			{
				$html .= 'selected="selected"';
			}
			$html.= '>'.$data->payroll_deduction_type_name.'</option>';
		}
		return $html;
	}

	public function reload_deduction_type()
	{
		$payroll_deduction_category = Request::input('payroll_deduction_category');
		$archived 					= Request::input('archived');
		$data['_active'] 			= Tbl_payroll_deduction_type::seltype(Self::shop_id(),$payroll_deduction_category, $archived)->get();
		return view('member.payroll.reload.deduction_list_reload',$data);
	}

	public function update_deduction_type()
	{
		$value 		= Request::input('value');
		$content 	= Request::input('content');
		
		$update['payroll_deduction_type_name'] = $value;
		Tbl_payroll_deduction_type::where('payroll_deduction_type_id',$content)->update($update);

	}

	public function archive_deduction_type()
	{
		$content = Request::input('content');
		$update['payroll_deduction_archived'] = Request::input('archived');
		Tbl_payroll_deduction_type::where('payroll_deduction_type_id',$content)->update($update);
	}

	public function ajax_deduction_type()
	{
		$category = Request::input('category');
		$data = Tbl_payroll_deduction_type::seltype(Self::shop_id(),$category)->get();
		return json_encode($data);
	}

	public function modal_deduction_tag_employee($deduction_id)
	{
		$data['_company'] 		= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();

		$data['_department'] 	= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();

		$data['deduction_id']	=	$deduction_id;
		$data['action']			= 	'/member/payroll/deduction/set_employee_deduction_tag';

		return view('member.payroll.modal.modal_deduction_tag_employee', $data);
	}

	public function modal_save_deduction()
	{
		$insert['shop_id'] 						= Self::shop_id();
		$insert['payroll_deduction_name'] 		= Request::input('payroll_deduction_name');
		$insert['payroll_deduction_amount'] 	= Request::input('payroll_deduction_amount');
		$insert['payroll_monthly_amortization'] = Request::input('payroll_monthly_amortization');
		$insert['payroll_periodal_deduction'] 	= Request::input('payroll_periodal_deduction');
		$insert['payroll_deduction_date_filed'] = date('Y-m-d',strtotime(Request::input('payroll_deduction_date_filed')));
		$insert['payroll_deduction_date_start'] = date('Y-m-d',strtotime(Request::input('payroll_deduction_date_start')));
		$insert['payroll_deduction_period'] 	= Request::input('payroll_deduction_period');
		$insert['payroll_deduction_category'] 	= Request::input('payroll_deduction_category');
		$insert['payroll_deduction_type'] 		= Request::input('payroll_deduction_type');
		$insert['payroll_deduction_remarks'] 	= Request::input('payroll_deduction_remarks');

		$deduction_id = Tbl_payroll_deduction::insertGetId($insert);

		if(Session::has('employee_deduction_tag'))
		{
			$employee_tag = Session::get('employee_deduction_tag');
			$insert_employee = '';
			foreach($employee_tag as $key => $tag)
			{
				$insert_employee[$key]['payroll_deduction_id']  	= $deduction_id;
				$insert_employee[$key]['payroll_employee_id']		= $tag;
			}
			if($insert_employee != '')
			{
				Tbl_payroll_deduction_employee::insert($insert_employee);
			}
		}

		$return['stataus'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_deduction';
		return json_encode($return);

	}

	public function ajax_deduction_tag_employee()
	{
		$company 	= Request::input('company');
		$department = Request::input('department');
		$jobtitle 	= Request::input('jobtitle');


		$emp = Tbl_payroll_employee_contract::employeefilter($company, $department, $jobtitle)->orderBy('tbl_payroll_employee_basic.payroll_employee_first_name')->groupBy('tbl_payroll_employee_basic.payroll_employee_id')->get();
		// dd($emp);
		return json_encode($emp);
	}

	public function set_employee_deduction_tag()
	{
		$employee_tag = Request::input('employee_tag');
		$deduction_id = Request::input('deduction_id');
		// dd($deduction_id);
		$array = array();
		if(Session::has('employee_deduction_tag'))
		{
			$array = Session::get('employee_deduction_tag');
		}
		// dd($array);

		$insert_tag = array();

		foreach($employee_tag as $tag)
		{
			if(!in_array($tag, $array) && $deduction_id == 0)
			{
				array_push($array, $tag);
			}
			$count = Tbl_payroll_deduction_employee::where('payroll_deduction_id',$deduction_id)->where('payroll_employee_id', $tag)->count();

			if($count == 0)
			{
				$insert['payroll_deduction_id'] 	= $deduction_id;
				$insert['payroll_employee_id']		= $tag;
				array_push($insert_tag, $insert);
			}
			
		}
		// dd($insert_tag);
		if($deduction_id != 0 && $insert_tag != '')
		{
			Tbl_payroll_deduction_employee::insert($insert_tag);
		}
		else
		{
			Session::put('employee_deduction_tag', $array);
		}
		

		$return['status'] = 'success';
		$return['function_name'] = 'modal_create_deduction.load_tagged_employee';
		return json_encode($return);
	}

	public function get_employee_deduction_tag()
	{	
		$employee = [0 => 0];
		if(Session::has('employee_deduction_tag'))
		{
			$employee = Session::get('employee_deduction_tag');
		}
		$emp = Tbl_payroll_employee_basic::whereIn('payroll_employee_id',$employee)->get();

		$data['new_record'] = $emp;
		return json_encode($data);
	}

	public function remove_from_tag_session()
	{
		$content = Request::input('content');
		$array 	 = Session::get('employee_deduction_tag');
		if(($key = array_search($content, $array)) !== false) {
		    unset($array[$key]);
		}
		Session::put('employee_deduction_tag', $array);
	}

	public function reload_deduction_employee_tag()
	{
		$payroll_deduction_id = Request::input('payroll_deduction_id');
		$data['emp'] = Payroll::getbalance(Self::shop_id(), $payroll_deduction_id);
		return view('member.payroll.reload.deduction_employee_tag_reload', $data);
	}


	public function modal_edit_deduction($id)
	{
		$data['deduction'] = Tbl_payroll_deduction::where('payroll_deduction_id',$id)->first();
		$data['_type'] = Tbl_payroll_deduction_type::where('shop_id', Self::shop_id())->where('payroll_deduction_archived', 0)->orderBy('payroll_deduction_type_name')->get();
		$data['emp'] = Payroll::getbalance(Self::shop_id(), $id);
		// dd($data['_emp']);
		return view('member.payroll.modal.modal_edit_deduction', $data);
	}

	public function archive_deduction($archived, $id)
	{
		
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_deduction::where('payroll_deduction_id', $id)->pluck('payroll_deduction_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/deduction/archived_deduction_action';
		$data['id'] 		= $id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archived_deduction_action()
	{
		$update['payroll_deduction_archived'] 	= Request::input('archived');
		$id 									= Request::input('id');
		Tbl_payroll_deduction::where('payroll_deduction_id',$id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_deduction';
		return json_encode($return);
	}


	public function modal_update_deduction()
	{
		$payroll_deduction_id 			 		= Request::input('payroll_deduction_id');
		$update['payroll_deduction_name'] 		= Request::input('payroll_deduction_name');
		$update['payroll_deduction_amount'] 	= Request::input('payroll_deduction_amount');
		$update['payroll_monthly_amortization'] = Request::input('payroll_monthly_amortization');
		$update['payroll_periodal_deduction'] 	= Request::input('payroll_periodal_deduction');
		$update['payroll_deduction_date_filed'] = date('Y-m-d',strtotime(Request::input('payroll_deduction_date_filed')));
		$update['payroll_deduction_date_start'] = date('Y-m-d',strtotime(Request::input('payroll_deduction_date_start')));
		$update['payroll_deduction_period'] 	= Request::input('payroll_deduction_period');
		$update['payroll_deduction_category'] 	= Request::input('payroll_deduction_category');
		$update['payroll_deduction_type'] 		= Request::input('payroll_deduction_type');
		$update['payroll_deduction_remarks'] 	= Request::input('payroll_deduction_remarks');

		Tbl_payroll_deduction::where('payroll_deduction_id',$payroll_deduction_id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_deduction';
		return json_encode($return);
	}

	public function deduction_employee_tag($archive, $payroll_deduction_employee_id)
	{
		$statement = 'cancel';
		if($archive == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_deduction_employee::getemployee($payroll_deduction_employee_id)->pluck('payroll_employee_display_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/deduction/deduction_employee_tag_archive';
		$data['id'] 		= $payroll_deduction_employee_id;
		$data['archived'] 	= $archive;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function deduction_employee_tag_archive()
	{
		$id = Request::input('id');
		$update['payroll_deduction_employee_archived'] = Request::input('archived');

		Tbl_payroll_deduction_employee::where('payroll_deduction_employee_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'modal_create_deduction.reload_tag_employee';
		return json_encode($return);
	}

	/* DEDUCTION END */


	/* HOLIDAY START */
	public function holiday()
	{

		$data['_active'] = Tbl_payroll_holiday::getholiday(Self::shop_id())->orderBy('payroll_holiday_date','desc')->get();
		$data['_archived'] = Tbl_payroll_holiday::getholiday(Self::shop_id(), 1)->orderBy('payroll_holiday_date','desc')->get();

		return view('member.payroll.side_container.holiday',$data);
	}

	public function modal_create_holiday()
	{
		$data['_company'] = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('payroll_company_name')->get();
		return view('member.payroll.modal.modal_create_holiday', $data);
	}

	public function modal_save_holiday()
	{
		
		$insert['shop_id']					= Self::shop_id();
		$insert['payroll_holiday_name'] 	= Request::input('payroll_holiday_name');
		$insert['payroll_holiday_date'] 	= date('Y-m-d',strtotime(Request::input('payroll_holiday_date')));
		$insert['payroll_holiday_category'] = Request::input('payroll_holiday_category');

		$holiday_id = Tbl_payroll_holiday::insertGetId($insert);

		$_company 							= Request::input('company');

		$insert_company = array();

		foreach($_company as $company)
		{

			$temp['payroll_company_id'] = $company;
			$temp['payroll_holiday_id'] = $holiday_id;
			array_push($insert_company, $temp);
		}

		if(!empty($insert_company))
		{
			Tbl_payroll_holiday_company::insert($insert_company);
		}

		$return['status'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_holiday';
		return json_encode($return);
	}

	public function archive_holiday($archive, $id)
	{
		$statement = 'archive';
		if($archive == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_holiday::where('payroll_holiday_id', $id)->pluck('payroll_holiday_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/holiday/archive_holiday_action';
		$data['id'] 		= $id;
		$data['archived'] 	= $archive;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archive_holiday_action()
	{
		$id = Request::input('id');
		$update['payroll_holiday_archived'] = Request::input('archived');
		Tbl_payroll_holiday::where('payroll_holiday_id', $id)->update($update);


		$return['status'] = 'success';
		$return['function_name'] = 'payrollconfiguration.reload_holiday';
		return json_encode($return);
	}

	public function modal_edit_holiday($id)
	{
		// $data['']
		$_company = Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('payroll_company_name')->get();
		$company_check = array();
		foreach($_company as $company)
		{
			$count = Tbl_payroll_holiday_company::company($company->payroll_company_id, $id)->count();
			$status = '';
			if($count != 0)
			{
				$status = 'checked';
			}
			$temp['payroll_company_id'] 	= $company->payroll_company_id;
			$temp['payroll_company_name'] 	= $company->payroll_company_name;
			$temp['status']					= $status;
			array_push($company_check, $temp);
		}

		$data['_company'] = $company_check;
		$data['holiday'] = Tbl_payroll_holiday::where('payroll_holiday_id',$id)->first();
		return view('member.payroll.modal.modal_edit_holiday', $data);
	}

	public function modal_update_holiday()
	{
		$payroll_holiday_id 				= Request::input('payroll_holiday_id');
		$update['payroll_holiday_name'] 	= Request::input('payroll_holiday_name');
		$update['payroll_holiday_date'] 	= date('Y-m-d',strtotime(Request::input('payroll_holiday_date')));
		$update['payroll_holiday_category'] = Request::input('payroll_holiday_category');
		$_company 							= Request::input('company');

		Tbl_payroll_holiday::where('payroll_holiday_id',$payroll_holiday_id)->update($update);

		Tbl_payroll_holiday_company::where('payroll_holiday_id',$payroll_holiday_id)->delete();

		$insert_company = array();
		foreach($_company as $company)
		{
			$temp['payroll_company_id'] = $company;
			$temp['payroll_holiday_id'] = $payroll_holiday_id;
			array_push($insert_company, $temp);
		}
		if(!empty($insert_company))
		{
			Tbl_payroll_holiday_company::insert($insert_company);
		}

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_holiday';
		return json_encode($return);

	}

	/* HOLIDAY END */

	/* ALLOWANCE START */
	public function allowance()
	{
		$data['_active'] = Tbl_payroll_allowance::sel(Self::shop_id())->orderBy('payroll_allowance_name')->get();
		$data['_archived'] = Tbl_payroll_allowance::sel(Self::shop_id(), 1)->orderBy('payroll_allowance_name')->get();
		return view('member.payroll.side_container.allowance', $data);
	}

	public function modal_create_allowance()
	{
		Session::put('allowance_employee_tag', array());
		return view('member.payroll.modal.modal_create_allowance');
	}

	public function modal_allowance_tag_employee($allowance_id)
	{
		$data['_company'] 		= Tbl_payroll_company::selcompany(Self::shop_id())->orderBy('tbl_payroll_company.payroll_company_name')->get();

		$data['_department'] 	= Tbl_payroll_department::sel(Self::shop_id())->orderBy('payroll_department_name')->get();

		$data['deduction_id']	=	$allowance_id;
		$data['action']			= 	'/member/payroll/allowance/set_employee_allowance_tag';

		return view('member.payroll.modal.modal_deduction_tag_employee', $data);
	}

	public function set_employee_allowance_tag()
	{
		$allowance_id = Request::input('deduction_id');
		$employee_tag = Request::input('employee_tag');

		$array = array();
		if(Session::has('allowance_employee_tag'))
		{
			$array = Session::get('allowance_employee_tag');
		}

		$insert_tag = array();

		foreach($employee_tag as $tag)
		{
			array_push($array, $tag);
			if($allowance_id != 0)
			{
				$count = Tbl_payroll_employee_allowance::where('payroll_allowance_id', $allowance_id)->where('payroll_employee_id',$tag)->count();
				if($count == 0)
				{
					$insert['payroll_allowance_id'] = $allowance_id;
					$insert['payroll_employee_id']	= $tag;
					array_push($insert_tag, $insert);
				}
			}
		}

		if($allowance_id != 0 && !empty($insert_tag))
		{
			Tbl_payroll_employee_allowance::insert($insert_tag);
		}
		Session::put('allowance_employee_tag',$array);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'modal_create_allowance.load_emoloyee_tag';
		return json_encode($return);
	}

	public function get_employee_allowance_tag()
	{
		$employee = [0 => 0];
		if(Session::has('allowance_employee_tag'))
		{
			$employee = Session::get('allowance_employee_tag');
		}
		$emp = Tbl_payroll_employee_basic::whereIn('payroll_employee_id',$employee)->get();

		$data['new_record'] = $emp;
		return json_encode($data);
	}


	public function remove_allowance_tabe_employee()
	{
		$content = Request::input('content');
		$array 	 = Session::get('allowance_employee_tag');
		if(($key = array_search($content, $array)) !== false) {
		    unset($array[$key]);
		}
		Session::put('allowance_employee_tag',$array);
	}


	public function modal_save_allowances()
	{
		$insert['payroll_allowance_name'] 		= Request::input('payroll_allowance_name');
		$insert['payroll_allowance_amount'] 	= Request::input('payroll_allowance_amount');
		$insert['payroll_allowance_category'] 	= Request::input('payroll_allowance_category');
		$insert['shop_id']						= Self::shop_id();
		$allowance_id = Tbl_payroll_allowance::insertGetId($insert);

		$insert_employee = array();
		if(Session::has('allowance_employee_tag'))
		{
			foreach(Session::get('allowance_employee_tag') as $tag)
			{	
				$temp['payroll_allowance_id'] 	= $allowance_id;
				$temp['payroll_employee_id']	= $tag;
				array_push($insert_employee, $temp);
			}
			if(!empty($insert_employee))
			{
				Tbl_payroll_employee_allowance::insert($insert_employee);
			}
		}

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_allowance';
		return json_encode($return);
	}

	public function modal_archived_allwance($archived, $allowance_id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$file_name 			= Tbl_payroll_allowance::where('payroll_allowance_id', $allowance_id)->pluck('payroll_allowance_name');
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/allowance/archived_allowance';
		$data['id'] 		= $allowance_id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archived_allowance()
	{
		$id = Request::input('id');
		$update['payroll_allowance_archived'] = Request::input('archived');
		Tbl_payroll_allowance::where('payroll_allowance_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'payrollconfiguration.reload_allowance';
		return json_encode($return);
	}

	public function modal_edit_allowance($id)
	{
		$data['allowance'] = Tbl_payroll_allowance::where('payroll_allowance_id', $id)->first();
		$data['_active'] = Tbl_payroll_employee_allowance::getperallowance($id)->get();
		$data['_archived'] = Tbl_payroll_employee_allowance::getperallowance($id , 1)->get();
		// dd($data);
		return view('member.payroll.modal.modal_edit_allowance', $data);
	}

	public function modal_archived_llowance_employee($archived, $id)
	{
		$statement = 'archive';
		if($archived == 0)
		{
			$statement = 'restore';
		}
		$_query 			= Tbl_payroll_employee_allowance::employee($id)->first();
		// dd($_query);
		$file_name 			= $_query->payroll_employee_title_name.' '.$_query->payroll_employee_first_name.' '.$_query->payroll_employee_middle_name.' '.$_query->payroll_employee_last_name.' '.$_query->payroll_employee_suffix_name;
		$data['title'] 		= 'Do you really want to '.$statement.' '.$file_name.'?';
		$data['html'] 		= '';
		$data['action'] 	= '/member/payroll/allowance/archived_allowance_employee';
		$data['id'] 		= $id;
		$data['archived'] 	= $archived;

		return view('member.modal.modal_confirm_archived', $data);
	}

	public function archived_allowance_employee()
	{
		$id = Request::input('id');
		$update['payroll_employee_allowance_archived'] = Request::input('archived');
		Tbl_payroll_employee_allowance::where('payroll_employee_allowance_id', $id)->update($update);

		$return['status'] 			= 'success';
		$return['function_name'] 	= 'modal_create_allowance.load_emoloyee_tag';
		return json_encode($return);
	}

	public function reload_allowance_employee()
	{
		$payroll_allowance_id = Request::input('payroll_allowance_id');
		$data['_active'] = Tbl_payroll_employee_allowance::getperallowance($payroll_allowance_id)->get();
		$data['_archived'] = Tbl_payroll_employee_allowance::getperallowance($payroll_allowance_id , 1)->get();
		return view('member.payroll.reload.allowance_employee_reload', $data);
	}

	/* ALLOWANCE END */

	/* LEAVE START */
	public function leave()
	{
		return view('member.payroll.side_container.leave');
	}
	/* LEAVE END */


	/* PAYROLL GROUP START */
	public function payroll_group()
	{
		return view('member.payroll.side_container.payroll_group');
	}

	public function modal_create_payroll_group()
	{
		return view('member.payroll.modal.modal_create_payroll_group');
	}
	/* PAYROLL GROUP END */
}
