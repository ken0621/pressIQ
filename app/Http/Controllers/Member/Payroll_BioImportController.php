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


class Payroll_BioImportController extends Member
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


	/* GET EMPLOYEE ID START */
	public function getemployeeId($payroll_employee_number = '', $pluck = 'payroll_employee_id')
	{
		return Tbl_payroll_employee_basic::where('payroll_employee_number', $payroll_employee_number)->where('shop_id', Self::shop_id())->pluck($pluck);
	}
	/* GET EMPLOYEE ID END */


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

	public function import_global()
	{
		$file 		= Request::file('file');
		$biometric 	= Request::input('biometric');
		if($biometric == 'ZKTime 5.0')
		{
			return Self::import_ZKTime_5_0($file);
		}
		if($biometric == 'Digital Persona')
		{
			return Self::import_Digital_Persona($file);
		}
	}

    /* BIO METRICS START */

    public function import_ZKTime_5_0($file)
    {
    	// $file = Request::file('file');
    	$message = '<center><i><span class="color-red"><b>Invalid File Format</b></span></i></center>';
    	$_time = Excel::selectSheetsByIndex(0)->load($file, function($reader){})->get(array('no','datetime'));
    	// dd($_time);

    	if(isset($_time[0]['no']) && isset($_time[0]['datetime']))
    	{


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
	    	}

	    	$_date_collect = collect($time_sheet)->groupBy('employee_number','date');
	    	foreach($_date_collect as $key => $date_collect)
	    	{
	    		$_date = collect($date_collect)->groupBy('date');
	    		$temp = '';
	    		foreach($_date as $date)
	    		{
	    			$start 	= $date[0];
	    			$end 	= $date[count($date) - 1];
	    			if(Self::check_employee_number($start['employee_number']))
	    			{
	    				$count = Tbl_payroll_time_sheet::checkdata(Self::getemployeeId($start['employee_number']),$start['date'])->count();
		    			$payroll_time_sheet_id = 0;
		    			if($count == 0)
		    			{
		    				$insert_time['payroll_employee_id'] = Self::getemployeeId($start['employee_number']);
		    				$insert_time['payroll_time_date'] 	= $start['date'];
		    				$payroll_time_sheet_id = Tbl_payroll_time_sheet::insertGetId($insert_time);
		    			}
		    			else
		    			{
		    				$payroll_time_sheet_id = Tbl_payroll_time_sheet::checkdata(Self::getemployeeId($start['employee_number']),$start['date'])->pluck('payroll_time_sheet_id');
		    			}

		    			$temp_array['payroll_time_sheet_id'] 		= $payroll_time_sheet_id;
		    			$temp_array['payroll_time_sheet_in'] 		= $start['time'];
		    			$temp_array['payroll_time_sheet_out'] 		= $end['time'];
		    			$temp_array['payroll_time_sheet_origin'] 	= 'Biometrics';
		    			$temp_array['payroll_company_id']			= Self::getemployeeId($start['employee_number'],'payroll_employee_company_id');

		    			$count_record = Tbl_payroll_time_sheet_record::wherearray($temp_array)->count();
		    			if($count_record == 0)
		    			{
		    				array_push($insert_time_record, $temp_array);
		    			}
	    			}
	    			
	    		}
	    		
	    	}
	    	$message = '<center><span class="color-gray">Nothing to insert</span></center>';
	    	if(!empty($insert_time_record))
	    	{
	    		Tbl_payroll_time_sheet_record::insert($insert_time_record);
	    		$count_inserted = count($insert_time_record);
	    		$message = '<center><span class="color-green">'.$count_inserted.' new record/s inserted.</span></center>';
	    	}
	    	
	    	// return $message;
    	}
    	// else
    	// {
    	// 	return '<center><i><span class="color-red"><b>Invalid File Format</b></span></i></center>';
    	// }
    	return $message;
    	
    }

    public function import_Digital_Persona($file)
    {
    	$_time = Excel::selectSheetsByIndex(0)->load($file, function($reader){})->get(array('id_no','date','time_in','time_out'));
    	dd($_time);
    	$space = '        ';
    }

    /* TEMPLATE START */
    public function template_global()
    {
    	$biometric_name = Request::input('biometric_name');
    	if($biometric_name == 'ZKTime 5.0')
    	{
    		Self::ZKTime_template();
    	}
    }

    public function ZKTime_template()
    {
    	$excels['data'][0] = ['Department','Name', 'No.','Date/Time','Location ID','ID Number','VerifyCode','CardNo'];
        $excels['data'][1] = ['','', '','','','','',''];
        // dd($excels);
        return Excel::create('Timesheet Template (ZKTime 5.0)', function($excel) use ($excels) {

            $data = $excels['data'];
            $date = 'template';
            $excel->setTitle('Payroll');
            $excel->setCreator('Laravel')->setCompany('DIGIMA');
            $excel->setDescription('payroll file');

            $excel->sheet($date, function($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
            });

        })->download('xlsx');
    }

    /* BIO METRICS END */
}
