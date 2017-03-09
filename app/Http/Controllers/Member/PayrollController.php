<?php
namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Request;
use Session;

use App\Models\Tbl_payroll_company;
use App\Models\Tbl_payroll_rdo;
use App\Models\Tbl_payroll_department;
use App\Models\Tbl_payroll_jobtitle;

class PayrollController extends Member
{

	public function shop_id()
	{
		return $shop_id = $this->user_info->user_shop;
	}

    public function employee_list()
	{
		return view('member.payroll.employeelist');
	}   


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
        // $cover_image_filename = $file->getClientOriginalName();
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
		$return['message'] = 'success';
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
		$return['message'] = 'success';
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

		$return['message'] 			= 'success';
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

		$return['message'] 			= 'success';
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
		
		$return['message'] 			= 'success';
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

		$return['message'] 			= 'success';
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

		$return['message'] 			= 'success';
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

		$return['message'] 			= 'success';
		$return['data']	   			= '';
		$return['function_name'] 	= 'payrollconfiguration.reload_tbl_jobtitle';
		return json_encode($return);
	}

	/* JOB TITLE END*/

}
