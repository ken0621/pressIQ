<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Carbon\Carbon;

use DateTime;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\PayrollDeductionController;


use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_biometric_time_sheet;
use App\Models\Tbl_payroll_biometric_record;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
use App\Models\Tbl_payroll_time_sheet_record_approved;
use App\Models\Tbl_payroll_time_keeping_approved_daily_breakdown;
use App\Models\Tbl_payroll_time_keeping_approved_breakdown;
use App\Models\Tbl_payroll_time_keeping_approved_performance;
use App\Models\Tbl_payroll_group;
use App\Models\Tbl_payroll_leave_schedule;
use App\Models\Tbl_payroll_employee_salary;
use App\Models\Tbl_payroll_shift_day;
use App\Models\Tbl_payroll_holiday_company;
use App\Models\Tbl_payroll_time_keeping_approved;
use App\Models\Tbl_payroll_shift_code;
use App\Models\Tbl_payroll_shift_time;
use App\Models\Tbl_payroll_adjustment;
use App\Models\Tbl_payroll_period;
use App\Globals\Payroll2;
use App\Globals\Payroll;
use App\Globals\PayrollLeave;
use App\Globals\Utilities;
use App\Models\Tbl_payroll_company;



use App\Models\Tbl_payroll_deduction_v2;
use App\Models\Tbl_payroll_deduction_employee_v2;
use App\Models\Tbl_payroll_deduction_payment_v2;

use DB;

class PayrollBiometricSystemController extends Member
{

	public function index()
	{
		$data["_biometric_record"] = Tbl_payroll_biometric_record::getalldata($this->user_info->shop_id)->get();
		
		return view('member.payroll2.payroll_biometric_record');
	}

	public function biometric_record_table()
	{
		$date["date_from"] 	= Carbon::parse(Request::input('date_from'))->format("Y-m-d");
		$date["date_to"] 	= Carbon::parse(Request::input('date_to'))->format("Y-m-d");
		$shop_id = $this->user_info->shop_id;
	
		$data["_biometric_record"] = Tbl_payroll_biometric_record::getalldata($this->user_info->shop_id)
		->whereBetween('tbl_payroll_biometric_record.payroll_time_date',array($date["date_from"],$date["date_to"]))
		->orderBy('tbl_payroll_employee_basic.payroll_employee_number','asc')
		->get();

		return view('member.payroll2.payroll_biometric_record_table',$data);
	}

	public function biometric_import_record()
	{
		$date["date_from"] 	= Carbon::parse(Request::input('date_from'))->format("Y-m-d");
		$date["date_to"] 	= Carbon::parse(Request::input('date_to'))->format("Y-m-d");
		$shop_id = $this->user_info->shop_id;

		$data["_biometric_record"] = Tbl_payroll_biometric_record::getalldata($this->user_info->shop_id)
		->whereBetween('tbl_payroll_biometric_record.payroll_time_date',array($date["date_from"],$date["date_to"]))
		->orderBy('tbl_payroll_employee_basic.payroll_employee_number','asc')
		->get();

		$_insert = null;
		$_update = null;

		foreach ($data["_biometric_record"] as $biometric_record) 
		{
			
			$date 				= $biometric_record->payroll_time_date;
			$employee_id 		= $biometric_record->payroll_employee_id;
			$payroll_company_id = $biometric_record->payroll_company_id;

			/* Get Tbl payroll time sheet data  */
			$timesheet_db 	= Payroll2::timesheet_info_db($employee_id, $date);
			
			/*Get Shift Code id*/
			$shift_code_id 	= Tbl_payroll_employee_basic::where("payroll_employee_id", $date)->value("shift_code_id");

			/* CREATE TIMESHEET DB IF EMPTY */
			if(!$timesheet_db)
			{
				$_shift_real 	=  Payroll2::db_get_shift_of_employee_by_code($shift_code_id, $date);
				$_shift 		=  Payroll2::shift_raw(Payroll2::db_get_shift_of_employee_by_code($shift_code_id, $date));
				
				$insert = null;
				$insert["payroll_employee_id"] 			= $employee_id;
				$insert["payroll_time_date"] 			= $date;
				$insert["payroll_time_shift_raw"] 		= serialize($_shift);

				$payroll_time_sheet_id = Tbl_payroll_time_sheet::insertGetId($insert);

				$insert = null;
				$insert_time['payroll_time_sheet_id'] 	= $payroll_time_sheet_id;
				$insert_time['payroll_company_id'] 		= $payroll_company_id;
				$insert_time['payroll_time_sheet_in'] 	= $biometric_record->payroll_time_in;
				$insert_time['payroll_time_sheet_out'] 	= $biometric_record->payroll_time_out;
				$insert_time['payroll_time_sheet_origin'] = "ZKTeco TX628";

				Tbl_payroll_time_sheet_record::insert($insert_time);
			}
			else
			{
				Tbl_payroll_time_sheet_record::where('payroll_time_sheet_id',$timesheet_db->payroll_time_sheet_id)->delete();
				
				$update = null;
				$update['payroll_time_sheet_id'] 	= $timesheet_db->payroll_time_sheet_id;
				$update['payroll_company_id'] 		= $payroll_company_id;
				$update['payroll_time_sheet_in'] 	= $biometric_record->payroll_time_in;
				$update['payroll_time_sheet_out'] 	= $biometric_record->payroll_time_out;
				$update['payroll_time_sheet_origin'] = "ZKTeco TX628";

				Tbl_payroll_time_sheet_record::insert($update);
				$_update = $update;
			}
		}


	}
}
