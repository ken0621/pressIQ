<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Request;
use Session;
use Excel;
use DB;
use File;

use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
use App\Models\Tbl_payroll_holiday_company;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_company;


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

	public function getTimeSheetId($payroll_employee_id = 0, $date = '0000-00-00')
	{
		$count = Tbl_payroll_time_sheet::checkdata($payroll_employee_id,$date)->count();
		$payroll_time_sheet_id = 0;
		if($count == 0)
		{
			$insert_time['payroll_employee_id'] = $payroll_employee_id;
			$insert_time['payroll_time_date'] 	= $date;
			$payroll_time_sheet_id = Tbl_payroll_time_sheet::insertGetId($insert_time);
		}
		else
		{
			$payroll_time_sheet_id = Tbl_payroll_time_sheet::checkdata($payroll_employee_id, $date)->pluck('payroll_time_sheet_id');
		}

		return $payroll_time_sheet_id;
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

		if($biometric == 'ZKTeco TX628')
		{
			return Self::import_zkteco_TX628($file);
		}

		if($biometric == 'Digital Persona')
		{
			return Self::import_Digital_Persona($file);
		}

		if($biometric == 'C7')
		{
			return Self::import_c7($file);
		}
		if($biometric == 'Manual Template')
		{
			return Self::import_manual($file);
		}

		if($biometric == 'Mustard Seed')
		{
			return Self::import_mustard_seed($file);
		}
	}

    /* BIO METRICS START */

    public function import_zkteco_TX628($file)
    {
    	$_test = file($file, FILE_IGNORE_NEW_LINES);

    	$temp = preg_split("/[\t]/", $_test[0]);
    	
    	$message = '<center><i><span class="color-red"><b>Invalid File Format</b></span></i></center>';

    	if(isset($temp[0]) && isset($temp[1]) && isset($temp[2]) && isset($temp[3]) && isset($temp[4]) && isset($temp[5]))
    	{

    		$success_count = 0;
	    	$temp_date = '';
	    	$insert_time_record = array();
	    	$time_sheet = array();


    		foreach($_test as $key => $test)
			{
				$extest 	= preg_split("/[\t]/", $test);
				$emp_no 	= $extest[0];
				$date_time 	= $extest[1];

				$temp_record['employee_number'] = (string)$emp_no;
	    		$temp_record['time']			= date('H:i:s', strtotime($date_time));
	    		$temp_record['date']			= date('Y-m-d', strtotime($date_time));
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
	    				
		    			$payroll_time_sheet_id = Self::getTimeSheetId(Self::getemployeeId($start['employee_number']), $start['date']);

		    			$temp_array['payroll_time_sheet_id'] 		= $payroll_time_sheet_id;
		    			$temp_array['payroll_time_sheet_in'] 		= $start['time'];
		    			$temp_array['payroll_time_sheet_out'] 		= $end['time'];
		    			$temp_array['payroll_time_sheet_origin'] 	= 'ZKTeco TX628';
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

    	}

    	return $message;
    }

    public function import_ZKTime_5_0($file)
    {
    	$message = '<center><i><span class="color-red"><b>Invalid File Format</b></span></i></center>';

    	$_time = Excel::selectSheetsByIndex(0)->load($file, function($reader){})->get(array('no','datetime'));
    	if(isset($_time[0]['no']) && isset($_time[0]['datetime']))
    	{


	    	$success_count = 0;
	    	$temp_date = '';
	    	$insert_time_record = array();
	    	$time_sheet = array();
	    	foreach($_time as $key => $time)
	    	{
	    		$temp_record['employee_number'] = (string)$time['no'];
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
	    				
		    			$payroll_time_sheet_id = Self::getTimeSheetId(Self::getemployeeId($start['employee_number']), $start['date']);

		    			$temp_array['payroll_time_sheet_id'] 		= $payroll_time_sheet_id;
		    			$temp_array['payroll_time_sheet_in'] 		= $start['time'];
		    			$temp_array['payroll_time_sheet_out'] 		= $end['time'];
		    			$temp_array['payroll_time_sheet_origin'] 	= 'ZKTime 5.0';
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

    	return $message;
    	
    }

    public function import_Digital_Persona($file)
    {
    	$_time = Excel::selectSheetsByIndex(0)->load($file, function($reader){})->get(array('id_no','date','time_in','time_out'))->toArray();
    	// dd($_time);
    	$space = '        ';
    	$old_id_no = 0;
    	$old_date = '';
    	$record_array = array();

    	$message = '<center><i><span class="color-red"><b>Invalid File Format</b></span></i></center>';
    	if(isset($_time[0]['id_no']) && isset($_time[0]['date']) && isset($_time[0]['time_in']) && isset($_time[0]['time_out']))
    	{
    		foreach($_time as $time)
	    	{
	    		$time['id_no'] 		= trim((string)$time['id_no'],' ');
	    		$time['date'] 		= trim((string)$time['date'], ' ');
	    		$time['time_in'] 	= trim((string)$time['time_in'], ' ');
	    		$time['time_out'] 	= trim((string)$time['time_out'], ' ');

	    		if($time['id_no'] == '')
	    		{
	    			$time['id_no'] = $old_id_no;
	    		}
	    		if(trim((string)$time['date'], ' ') == '')
	    		{
	    			$time['date'] = $old_date;
	    		}
	    		if($old_id_no != $time['id_no'] && $time['id_no'] != "")
	    		{
	    			$old_id_no = $time['id_no'];
	    		}
	    		if(trim((string)$time['date'], ' ') != '')
	    		{
	    			$old_date = trim((string)$time['date'], ' ');
	    		}
	    		array_push($record_array, $time);
	    	}
	    	$_collect = collect($record_array)->groupBy('id_no');
	    	// dd($collect);

	    	$insert_time_record = array();

	    	foreach($_collect as $key => $collect)
	    	{	
	    		if(Self::check_employee_number($key))
	    		{
	    			$_date_key = collect($collect)->groupBy('date');
	    			// dd($_date_key);
		    		foreach($_date_key as $dk => $date_key)
		    		{
		    			$date = date('Y-m-d', strtotime($dk));
		    			$payroll_time_sheet_id = Self::getTimeSheetId(Self::getemployeeId($key), $date);
		    			// dd($payroll_time_sheet_id);
		    			
		    			if($date_key[0]['time_in'] != '')
		    			{
		    				$insert_record['payroll_time_sheet_in'] 	= date('H:i:s', strtotime($date_key[0]['time_in']));
		    				$insert_record['payroll_time_sheet_id'] 	= $payroll_time_sheet_id;
		    				$insert_record['payroll_company_id']		= Self::getemployeeId($key,'payroll_employee_company_id');
		    				$insert_record['payroll_time_sheet_origin'] = 'Digital Persona';
		    				foreach($date_key as $final_date)
			    			{
			    				if(strtotime($final_date['time_out']) != '')
			    				{
			    					$insert_record['payroll_time_sheet_out'] = date('H:i:s', strtotime($final_date['time_out']));
			    				}
			    				
			    			}

			    			$count_record = Tbl_payroll_time_sheet_record::wherearray($insert_record)->count();
			    			if($count_record == 0)
			    			{
			    				array_push($insert_time_record, $insert_record);
			    			}
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
    	}
    	return $message;
    }	


    public function import_c7($file)
    {

		$_test = file($file, FILE_IGNORE_NEW_LINES);
		foreach($_test as $key => $test)
		{
			$extest = preg_split("/[\t]/", $test);
			// dd($extest);
		}

    }

    public function import_manual($file)
    {
    	$message = '<center><i><span class="color-red"><b>Invalid File Format</b></span></i></center>';

    	$_time = Excel::selectSheetsByIndex(0)->load($file, function($reader){})->get(array('employee_no','date','time_in','time_out'));
    	
    	if(isset($_time[0]['employee_no']) && isset($_time[0]['date']) && isset($_time[0]['time_in']) && isset($_time[0]['time_out']))
    	{

	    	$success_count = 0;
	    	$temp_date = '';
	    	$insert_time_record = array();
	    	$time_sheet = array();
	    	foreach($_time as $key => $time)
	    	{

	    		if(Self::check_employee_number($time['employee_no']))
    			{
    				// dd($time['date']);
	    			$payroll_time_sheet_id = Self::getTimeSheetId(Self::getemployeeId($time['employee_no']), date('Y-m-d', strtotime($time['date'])));

	    			$temp_array['payroll_time_sheet_id'] 		= $payroll_time_sheet_id;
	    			$temp_array['payroll_time_sheet_in'] 		= date('H:i:s', strtotime($time['time_in']));
	    			$temp_array['payroll_time_sheet_out'] 		= date('H:i:s', strtotime($time['time_out']));
	    			$temp_array['payroll_time_sheet_origin'] 	= 'Manual Template';
	    			$temp_array['payroll_company_id']			= Self::getemployeeId($time['employee_no'],'payroll_employee_company_id');

	    			Tbl_payroll_time_sheet_record::where('payroll_time_sheet_record_id', $payroll_time_sheet_id)->where('payroll_time_sheet_in', '00:00:00')->where('payroll_time_sheet_out','00:00:00')->delete();

	    			$count_record = Tbl_payroll_time_sheet_record::wherearray($temp_array)->count();
	    			
	    			if($count_record == 0)
	    			{

	    				array_push($insert_time_record, $temp_array);
	    			}
    			}
	    	}

	    	// dd($insert_time_record);
	    	$message = '<center><span class="color-gray">Nothing to insert</span></center>';
	    	if(!empty($insert_time_record))
	    	{
	    		Tbl_payroll_time_sheet_record::insert($insert_time_record);
	    		$count_inserted = count($insert_time_record);
	    		$message = '<center><span class="color-green">'.$count_inserted.' new record/s inserted.</span></center>';
	    	}
	    	
	    	// return $message;
    	}

    	return $message;
    }

    public function import_mustard_seed($file)
    {
    	$message = '<center><i><span class="color-red"><b>Invalid File Format</b></span></i></center>';
    	$_time = Excel::selectSheetsByIndex(0)->load($file, function($reader){})->get(array('company_code','employee_no','date','in_1','out_1','in_2','out_2','in_3','out_3','in_4','out_4','in_5','out_5','in_6','out_6'));
    	// dd($_time);
    	if(isset($_time[0]['company_code']) && isset($_time[0]['employee_no']) && isset($_time[0]['date']) && isset($_time[0]['in_1']) && isset($_time[0]['out_1']) && isset($_time[0]['in_2']) && isset($_time[0]['out_2']) && isset($_time[0]['in_3']) && isset($_time[0]['out_3']))
    	{
    		
    		$insert_time_record = array();

    		foreach($_time as $key => $time)
    		{
    			
    			// dd($time_param);
    			if(Self::check_employee_number($time['employee_no']))
    			{

    				$time_in = Self::findfirstlast_mustard($time);
    				$time_out = Self::findfirstlast_mustard($time,'last');

    				$company_id = Self::getemployeeId($time['employee_no'],'payroll_employee_company_id');

    				if($time['company_code'] != null)
    				{
    					$company_temp_id =  Tbl_payroll_company::selbycode(Self::shop_id(), $time['company_code'])->pluck('payroll_company_id');
    					if($company_temp_id != null)
    					{	
    						$company_id = $company_temp_id;
    					}
    				}


	    			$payroll_time_sheet_id = Self::getTimeSheetId(Self::getemployeeId($time['employee_no']), date('Y-m-d', strtotime($time['date'])));

	    			$temp_array['payroll_time_sheet_id'] 		= $payroll_time_sheet_id;
	    			$temp_array['payroll_time_sheet_in'] 		= date('H:i:s', strtotime($time_in));
	    			$temp_array['payroll_time_sheet_out'] 		= date('H:i:s', strtotime($time_out));
	    			$temp_array['payroll_time_sheet_origin'] 	= 'Mustard Seed';
	    			$temp_array['payroll_company_id']			= $company_id;

	    			Tbl_payroll_time_sheet_record::where('payroll_time_sheet_record_id', $payroll_time_sheet_id)->where('payroll_time_sheet_in', '00:00:00')->where('payroll_time_sheet_out','00:00:00')->delete();

	    			$count_record = Tbl_payroll_time_sheet_record::wherearray($temp_array)->count();
	    			
	    			if($count_record == 0)
	    			{
	    				array_push($insert_time_record, $temp_array);
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
    	}


    	return $message;

    }


    public function findfirstlast_mustard($_time = array(), $find = 'first')
    {
    	$time = '00:00:00';
    	$_param = ['in_1','out_1','in_2','out_2','in_3','out_3','in_4','out_4','in_5','out_5','in_6','out_6'];

    	if($find == 'last')
    	{
    		$_param = ['in_6','out_6','in_5','out_5','in_4','out_4','in_3','out_3','in_2','out_2','in_1','out_1'];
    	}
  
    	foreach($_param as $param)
    	{
    		if($_time[$param] != null)
    		{
    			$time = date('H:i:s', strtotime($_time[$param]));
    			break;
    		}
    	}
    	return $time;
    }

    /* TEMPLATE START */
    public function template_global()
    {
    	$biometric_name = Request::input('biometric_name');
    	if($biometric_name == 'ZKTime 5.0')
    	{
    		Self::ZKTime_template();
    	}
    	if($biometric_name == 'Digital Persona')
    	{
    		Self::Digital_Persona_template();
    	}

    	if($biometric_name == 'Manual Template')
    	{
    		Self::manual_template();
    	}

    	if($biometric_name == 'Mustard Seed')
    	{
    		Self::mustard_seed_template();
    	}
    }

    public function manual_template()
    {
    	$excels['data'][0] = ['Employee No.','Employee Name', 'Date','Time In','Time Out'];
        $excels['data'][1] = ['','', '','',''];
        // dd($excels);
        return Excel::create('Timesheet Template (Manual)', function($excel) use ($excels) {

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

    public function Digital_Persona_template()
    {
    	$excels['data'][0] = ['Name','Id No', 'Date','Time In','Time Out'];
        $excels['data'][1] = ['','', '','',''];

        return Excel::create('Timesheet Template (Digital Persona)', function($excel) use ($excels) {

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

    public function mustard_seed_template()
    {

    	$excels['data'][0] = ['Company Code','Employee No.', 'Employee Name','Date','In 1','Out 1','In 2','Out 2','In 3','Out 3','In 4','Out 4','In 5','Out 5','In 6','Out 6','Hrs Required','Tot Hrs Break','Hrs Worked'];

        $excels['data'][1] = ['','', '','','','','','','','','','','','','','','','',''];

        return Excel::create('Timesheet Template (Mustard Seed)', function($excel) use ($excels) {

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
