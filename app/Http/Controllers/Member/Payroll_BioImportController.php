<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Request;
use Session;
use Excel;
use DB;

use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
use App\Models\Tbl_payroll_holiday_company;
use App\Models\Tbl_payroll_employee_contract;


class Payroll_BioImportController extends Controller
{

	/* SHOP ID */
	public function shop_id()
	{
		return $shop_id = $this->user_info->user_shop;
	}

	/* MODAL IMPORT OF BIOMETRICS START*/
	public function modal_biometrics()
	{
		return view('member.payroll.modal.modal_biometrics');
	}
	/* MODAL IMPORT OF BIOMETRICS END */

	/* CHECK EMPLOYEE NUMBER START */
	public function check_employee_number($payroll_employee_number = '')
	{
		$bool = true;
		$count = Tbl_payroll_employee_basic::where('payroll_employee_number', $payroll_employee_number)->where('shop_id', Self::shop_id())->count();
		if($count == 0)
		{
			$bool = false;
		}
		return $bool;
	}
	/* CHECK EMPLOYEE NUMBER END */


	/* CHECK IF HOLIDAY OR REGULAR DAY START */
	public function check_day()
	{
		
	}
	/* CHECK IF HOLIDAY OR REGULAR DAY END */


    /* DMSPH BIO METRICS START */

    public function import_dmsph()
    {
    	$file = Request::file('file');
    	$_time = Excel::selectSheetsByIndex(0)->load($file, function($reader){})->get(array('no','datetime'));
    	dd($_time);

    	$success_count = 0;
    	foreach($_time as $time)
    	{
    		
    		if(Self::check_employee_number($time['no']))
    		{
    			$emp = Tbl_payroll_employee_basic::where('payroll_employee_number', $time['no'])->where('shop_id', Self::shop_id())->first();


    			$insert_time['']
    		}
    	}
    	
    }

    public function template_dmsph()
    {

    }

    /* DMSPH BIO METRICS END */
}
