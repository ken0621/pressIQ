<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Request;
use Carbon\Carbon;
use stdClass;
use App\Globals\Payroll;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
use App\Models\Tbl_payroll_employee_contract;
use Redirect;

class PayrollTimeSheetController extends Member
{
	public function index()
	{
		$data["_employee"] = Tbl_payroll_employee_basic::where("shop_id", $this->user_info->shop_id)->get();
		$data["current_employee"] = $current_employee = Tbl_payroll_employee_basic::where("shop_id", $this->user_info->shop_id)->where("payroll_employee_id", Request::input("employee_id"))->first();
		
		/* REDIRECT IF NO DEFAULT */
		if(empty($data["current_employee"]))
		{
			return Redirect::to("/member/payroll/employee_timesheet?employee_id=" . $data["_employee"][0]->payroll_employee_id)->send();
		}

		return view('member.payroll.employee_timesheet', $data);
	}
	public function timesheet($employee_id)
	{
		$data["employee_id"] = $employee_id;
		$data["page"] = "Timesheet Table";
		/* GET PAYROLL PERIOD */
		$from = $data["start_date"] = Carbon::parse("February 26, 2017")->format("Y-m-d");
		$to = $data["end_date"] = Carbon::parse("March 10, 2017")->format("Y-m-d");

		/* GET EMPLOYEE INFORMATION */
		$data["employee_info"] = Tbl_payroll_employee_basic::where("payroll_employee_id", $employee_id)->first();

		/* INITALIZE SETTINGS FOR EMPLOYEE */
		$time_rule = $data["time_rule"] = "regulartime"; //flexitime, regulartime
		$data["default_time_in"] = $default_time_in = "09:00 AM";
		$data["default_time_out"] = $default_time_out = "06:00 PM";
		$data["default_working_hours"] = $default_working_hours = "08:00";

		/* CREATE ARRAY TIMESHEET */
		while($from <= $to)
		{
			/* INITITAL DATA */
			$data["_timesheet"][$from] = new stdClass();
			$data["_timesheet"][$from]->date = Carbon::parse($from)->format("Y-m-d");
			$data["_timesheet"][$from]->day_number = Carbon::parse($from)->format("d");
			$data["_timesheet"][$from]->day_word = Carbon::parse($from)->format("D");

			/* GET DATA FOR SPECIFIC DATE */
			$data["timesheet_info"] = Tbl_payroll_time_sheet::where("payroll_time_date", Carbon::parse($from)->format("Y-m-d"))->where("payroll_employee_id", $employee_id)->first();
			
			if(!empty($data["timesheet_info"])) //IF TIME SHEET RECORD EXIST GET RECORD
			{
				$data["_timesheet"][$from]->break = "01:00";
				$data["_timesheet"][$from]->time_record_count = 1;
				$data["_timesheet"][$from]->payroll_time_sheet_approved = $data["timesheet_info"]->payroll_time_sheet_approved;
				$_timesheet_record = Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $data["timesheet_info"]->payroll_time_sheet_id)->get();
				if($_timesheet_record->isEmpty())
				{
					$data["_timesheet"][$from]->time_record[0] = new stdClass();
					$data["_timesheet"][$from]->time_record[0]->time_in = "";
					$data["_timesheet"][$from]->time_record[0]->time_out = "";
				}
				else
				{
					foreach($_timesheet_record as $key => $timesheet_record)
					{
						$data["_timesheet"][$from]->time_record[$key] = new stdClass();

						if($timesheet_record->payroll_time_sheet_out == "00:00:00")
						{
							$data["_timesheet"][$from]->time_record[$key]->time_in = "";
							$data["_timesheet"][$from]->time_record[$key]->time_out = "";
						}
						else
						{
							$data["_timesheet"][$from]->time_record[$key]->time_in =  Carbon::parse($timesheet_record->payroll_time_sheet_in)->format("h:i A");
							$data["_timesheet"][$from]->time_record[$key]->time_out = Carbon::parse($timesheet_record->payroll_time_sheet_out)->format("h:i A");
						}

						$data["_timesheet"][$from]->time_record[$key]->activities =  $timesheet_record->payroll_time_shee_activity;
					}
				}

			}
			else //DEFAULT IF EMPTY RECORD
			{
				$data["_timesheet"][$from]->break = "01:00";
				$data["_timesheet"][$from]->time_record_count = 1;
				$data["_timesheet"][$from]->time_record[0] = new stdClass();
				$data["_timesheet"][$from]->time_record[0]->time_in = "";
				$data["_timesheet"][$from]->time_record[0]->time_out = "";
				$data["_timesheet"][$from]->time_record[0]->activities = "";
				$data["_timesheet"][$from]->payroll_time_sheet_approved = 0;
			}

			$from = Carbon::parse($from)->addDay()->format("Y-m-d");
		}

		return view('member.payroll.employee_timesheet_table', $data);
	}
	public function json_process_time()
	{
		$employee_id = Request::input("employee_id");

		/* SAVE REQUEST INPUT */
		foreach(Request::input('date') as $key => $_time)
		{
			$date = Carbon::parse($key)->format("Y-m-d");
			
			$check_time_sheet = Tbl_payroll_time_sheet::where("payroll_time_date", $date)->where("payroll_employee_id", $employee_id)->first();
			$payroll_time_sheet_approved = 0;

			if(empty($check_time_sheet)) //TIMESHEET RECORD NOT EXIST
			{
				$insert_timesheet["payroll_employee_id"] = $employee_id;
				$insert_timesheet["payroll_time_sheet_type"] = "Regular";
				$insert_timesheet["payroll_time_date"] = $date;
				$insert_timesheet["payroll_time_approve_regular_overtime"] = 0;
				$insert_timesheet["payroll_time_approve_extra_day"] = 0;
				$insert_timesheet["payroll_time_approve_rest_day"] = 0;
				$insert_timesheet["payroll_time_sheet_break"] = Request::input("break")[$key];
				$payroll_time_sheet_id = Tbl_payroll_time_sheet::insert($insert_timesheet);
			}
			else //TIMESHEET RECORD EXIST
			{
				$payroll_time_sheet_approved = $check_time_sheet->payroll_time_sheet_approved;
				$update_timesheet["payroll_time_sheet_type"] = "Regular";
				$update_timesheet["payroll_time_approve_regular_overtime"] = 0;
				$update_timesheet["payroll_time_approve_extra_day"] = 0;
				$update_timesheet["payroll_time_approve_rest_day"] = 0;
				$update_timesheet["payroll_time_sheet_break"] = Request::input("break")[$key];
				Tbl_payroll_time_sheet::where("payroll_time_date", $date)->where("payroll_employee_id", $employee_id)->update($update_timesheet);
				$payroll_time_sheet_id = $check_time_sheet->payroll_time_sheet_id;
			}

			if($payroll_time_sheet_approved == 0) //overwrite timesheet record only if not yet approved
			{
				Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $payroll_time_sheet_id)->delete();
				$_insert_time_record = null;

				foreach(Request::input('date')[$key] as $i => $time)
				{
					$_insert_time_record[$i]["payroll_time_sheet_id"] = $payroll_time_sheet_id;
					$_insert_time_record[$i]["payroll_company_id"] = 0;

					if(Request::input("time_in")[$key][$i] == "")
					{
						$_insert_time_record[$i]["payroll_time_sheet_in"] = "";
						$_insert_time_record[$i]["payroll_time_sheet_out"] = "";
						$_insert_time_record[$i]["payroll_time_sheet_approved_in"] = "";
						$_insert_time_record[$i]["payroll_time_sheet_approved_out"] = "";
					}
					else
					{
						$_insert_time_record[$i]["payroll_time_sheet_approved_in"] = Carbon::parse(Request::input("time_in")[$key][$i])->format("H:i");;
						$_insert_time_record[$i]["payroll_time_sheet_approved_out"] = Carbon::parse(Request::input("time_out")[$key][$i])->format("H:i");					
						$_insert_time_record[$i]["payroll_time_sheet_in"] = Carbon::parse(Request::input("time_in")[$key][$i])->format("H:i");
						$_insert_time_record[$i]["payroll_time_sheet_out"] = Carbon::parse(Request::input("time_out")[$key][$i])->format("H:i");
					}

					$_insert_time_record[$i]["payroll_time_shee_activity"] = "";
					$_insert_time_record[$i]["payroll_time_sheet_origin"] = "Payroll Time Sheet";
					$_insert_time_record[$i]["payroll_time_sheet_status"] = "pending";
				}

				Tbl_payroll_time_sheet_record::insert($_insert_time_record);
			}


		}

		/* COMPUTE TIME FOR EACH DATE */
		foreach(Request::input('date') as $key => $_time)
		{
			$_timesheet[$key] = new stdClass();
			$_timesheet[$key]->date = $key;

			$default_working_hours = Request::input("default_working_hours");
			$processed_timesheet = Payroll::process_time($employee_id, $key);
			$_timesheet[$key]->payroll_time_sheet_id = $processed_timesheet->payroll_time_sheet_id;
			$_timesheet[$key]->payroll_time_sheet_approved = $processed_timesheet->payroll_time_sheet_approved;
			$_timesheet[$key]->time_spent = $processed_timesheet->pending_timesheet->time_spent;
			$_timesheet[$key]->regular_hours = $processed_timesheet->pending_timesheet->regular_hours;
			$_timesheet[$key]->late_overtime = $processed_timesheet->pending_timesheet->late_overtime;
			$_timesheet[$key]->early_overtime = $processed_timesheet->pending_timesheet->early_overtime;
			$_timesheet[$key]->total_hours = $processed_timesheet->pending_timesheet->total_hours;
			$_timesheet[$key]->extra_day_hours = $processed_timesheet->pending_timesheet->extra_day_hours;
			$_timesheet[$key]->rest_day_hours = $processed_timesheet->pending_timesheet->rest_day_hours;
			$_timesheet[$key]->late_hours = $processed_timesheet->pending_timesheet->late_hours;
			$_timesheet[$key]->night_differential = $processed_timesheet->pending_timesheet->night_differential;
 		}

		return json_encode($_timesheet);
	}
	public function json_process_time_single($date, $employee_id, $return_type = "json")
	{
		$_timesheet = new stdClass();
		$processed_timesheet = Payroll::process_time($employee_id, $date);
		return json_encode($processed_timesheet);
	}
	public function adjustment_form()
	{
		$data["page"] = "Adjustment Form";

		$data["timesheet_info"] = $timesheet_info = Tbl_payroll_time_sheet::where("payroll_time_sheet_id", Request::input("payroll_time_sheet_id"))->first();
		$employee_information = Tbl_payroll_employee_contract::selemployee($timesheet_info->payroll_employee_id)->leftJoin("tbl_payroll_group", "tbl_payroll_group.payroll_group_id", "=","tbl_payroll_employee_contract.payroll_group_id")->first();

		/* SETTINGS FOR EMPLOYEE PAYROLL GROUP */
		$data["default_time_in"] = $default_time_in = Carbon::parse($employee_information->payroll_group_start)->format("h:i A");
		$data["default_time_out"] = $default_time_out = Carbon::parse($employee_information->payroll_group_end)->format("h:i A");
		/* TIMESHEET  */
		$_time_record = Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $timesheet_info->payroll_time_sheet_id)->get();
	
		foreach($_time_record as $key => $time_record)
		{
			$data["_time_record"][$key] = $time_record;
			$data["_time_record"][$key]->time_in = Carbon::parse($time_record->payroll_time_sheet_in)->format("h:i A"); 
			$data["_time_record"][$key]->time_out = Carbon::parse($time_record->payroll_time_sheet_out)->format("h:i A"); 

			/* CHECK TIME IN */
			if(c_time_to_int($data["_time_record"][$key]->time_in) < c_time_to_int($default_time_in))
			{
				if(c_time_to_int($data["_time_record"][$key]->time_out) < c_time_to_int($default_time_in))
				{
					$max_time_in = $data["_time_record"][$key]->time_out;
				}
				else
				{
					$max_time_in = $default_time_in;
				}

				$min_time_in =  $time_record->payroll_time_sheet_in;

				$data["_time_record"][$key]->time_in_enabled = true;
				$data["_time_record"][$key]->time_in_max = Carbon::parse($max_time_in)->format("h:i A");
				$data["_time_record"][$key]->time_in_min = Carbon::parse($min_time_in)->format("h:i A");
			}
			else //DISABLE TIME-IN
			{
				$data["_time_record"][$key]->time_in_enabled = false;
				$data["_time_record"][$key]->time_in_max = "";
				$data["_time_record"][$key]->time_in_min = "";
			}

			/* CHECK TIME OUT */
			if(c_time_to_int($data["_time_record"][$key]->time_out) > c_time_to_int($default_time_out))
			{
				$data["_time_record"][$key]->time_out_enabled = true;
				
				if(c_time_to_int($data["_time_record"][$key]->time_in) > c_time_to_int($default_time_out))
				{
					$min_time_out = $data["_time_record"][$key]->time_in;
				}
				else
				{
					$min_time_out = $default_time_out;
				}

				$data["_time_record"][$key]->time_out_max = Carbon::parse($time_record->payroll_time_sheet_out)->format("h:i A");
				$data["_time_record"][$key]->time_out_min = Carbon::parse($min_time_out)->format("h:i A");

			}
			else //DISABLED TIME-OUT
			{
				$data["_time_record"][$key]->time_out_enabled = false;
				$data["_time_record"][$key]->time_out_max = "";
				$data["_time_record"][$key]->time_out_min = "";

			}
		}

		return view('member.payroll.employee_timesheet_adjustment', $data);
	}
}