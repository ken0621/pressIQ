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
	public function check_holiday($company_id = 0,$date = '0000-00-00')
	{
		$day = 'RG';
		$holiday = Tbl_payroll_holiday_company::getholiday($company_id, $date)->pluck('payroll_holiday_category');
	
		if($holiday == 'Regular')
		{
			$day = 'RH';
		}
		if($holiday == 'Special')
		{
			$day = 'SH';
		}
		return $day;
	}
	/* CHECK IF HOLIDAY OR REGULAR DAY END */


	/* CHECK IF REST DAY, EXTRA DAY OR REGULAR DAY START */
	public function check_day($employee_id = 0, $date = '0000-00-00', $daystr = 'RG')
	{	
		$day = $daystr;
		$target = date('l', strtotime($date));
		$_day = Tbl_payroll_employee_contract::selemployee($employee_id, $date)
											->join('tbl_payroll_group_rest_day','tbl_payroll_group_rest_day.payroll_group_id','=','tbl_payroll_employee_contract.payroll_group_id')
											->where('payroll_group_rest_day', $target)
											->pluck('tbl_payroll_group_rest_day.payroll_group_rest_day_category');
		if($_day == 'rest day')
		{
			$day = 'RD';
			if($daystr != 'RG')
			{
				$day = $daystr.',RD';
			}
		}
		if($_day == 'extra day')
		{
			$day = 'ED';
			if($daystr != 'RG')
			{
				$day = $daystr.',ED';
			}
		}

		return $day;
	}	
	/* CHECK IF REST DAY, EXTRA DAY OR REGULAR DAY END */


    /* DMSPH BIO METRICS START */

    public function import_dmsph()
    {
    	$file = Request::file('file');
    	$_time = Excel::selectSheetsByIndex(0)->load($file, function($reader){})->get(array('no','datetime'));
    	if(isset($_time[0]['no']) && isset($_time[0]['datetime']))
    	{
    		// dd($_time);

	    	$success_count = 0;
	    	$temp_date = '';
	    	$insert_time_record = array();
	    	$time_sheet = array();
	    	foreach($_time as $key => $time)
	    	{
	    		
	    		$temp_record['employee_number'] = $time['no'];
	    		$temp_record['time']			= date('H:i:s', strtotime($time['datetime']));
	    		$temp_record['date']			= date('Y-m-d', strtotime($time['datetime']));
	    		array_push($time_sheet, $temp_record);
	    		// if(Self::check_employee_number($time['no']))
	    		// {
	    		// 	$emp = Tbl_payroll_employee_basic::where('payroll_employee_number', $time['no'])->where('shop_id', Self::shop_id())->first();
	    		// 	$date = date('Y-m-d', strtotime($time['datetime']));

	    		// 	/* CHECK IF DATA EXIST */
	    		// 	$count_time = Tbl_payroll_time_sheet::checkdata($emp->payroll_employee_id, $date)->count();
	    		// 	$payroll_time_sheet_id = 0;
	    		// 	if($count_time == 0)
	    		// 	{
	    		// 		$insert_time['payroll_employee_id'] = $emp->payroll_employee_id;
	    		// 		$insert_time['payroll_time_date'] 	= $date;
	    		// 		$payroll_time_sheet_id = Tbl_payroll_time_sheet::insertGetId($insert_time);
	    		// 	}
	    		// 	else
	    		// 	{
	    		// 		$payroll_time_sheet_id = Tbl_payroll_time_sheet::checkdata($emp->payroll_employee_id, $date)->pluck('payroll_time_sheet_id');
	    		// 	}

	    		// 	/*  */

	    		// 	if($temp_date != $date && $temp_date != '')
	    		// 	{
	    		// 		if($key > 0)
	    		// 		{

	    		// 		}
	    		// 	}
	    			
	    		// 	$temp_date = $date;
	    		// }
	    	}
	    	// dd($time_sheet);

	    	$_date = collect($time_sheet)->groupBy('employee_number','date');
	    	dd($_date);
    	}
    	else
    	{
    		return '<center><i><span class="color-red"><b>Invalid File Format</b></span></i></center>';
    	}
    	
    	
    }

    public function template_dmsph()
    {

    }

    /* DMSPH BIO METRICS END */
}
