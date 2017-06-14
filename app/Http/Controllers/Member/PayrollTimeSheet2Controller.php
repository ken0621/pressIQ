<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_employee_contract;
use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;
use App\Globals\Payroll;

class PayrollTimeSheet2Controller extends Member
{
	public function index($period_id)
	{
		$data["page"] = "Employee List Summary";
		$this->index_redirect_if_time_keeping_does_not_exist($period_id);
		$data["company"] = $this->db_get_company_period_information($period_id);
		$data["_employee"] = $this->db_get_list_of_employees_by_company($data["company"]->payroll_company_id);
		return view('member.payroll2.employee_summary', $data);
	}
	public function index_redirect_if_time_keeping_does_not_exist($period_id)
	{
		$count = Tbl_payroll_period_company::check($period_id, $this->user_info->shop_id)->count();

		if($count == 0)
		{
			return Redirect::to('/member/payroll/time_keeping')->send();
		}
	}
	public function timesheet($period_id, $employee_id)
	{
		$data["page"] = "Employee Timesheet";
		$data["employee_id"] = $employee_id;
		$data["employee_info"] = $this->db_get_employee_information($employee_id); 
		$data["company_period"] = $this->db_get_company_period_information($period_id);
		$data["show_period_start"] = date("F d, Y", strtotime($data["company_period"]->payroll_period_start));
		$data["show_period_end"] = date("F d, Y", strtotime($data["company_period"]->payroll_period_end));
		$data["_timesheet"] = $this->timesheet_info($data["company_period"], $employee_id);
		return view('member.payroll2.employee_timesheet', $data);
	}
	public function timesheet_info($company_period, $employee_id) 
	{
		$_timesheet = null;

		$from = $data["start_date"] = $company_period->payroll_period_start;
		$to = $data["end_date"] = $company_period->payroll_period_end;

		while($from <= $to)
		{
			$timesheet_db = $this->timesheet_info_db($employee_id, $from);
			$_timesheet[$from] = new stdClass();
			$_timesheet[$from]->date = Carbon::parse($from)->format("Y-m-d");
			$_timesheet[$from]->day_number = Carbon::parse($from)->format("d");
			$_timesheet[$from]->day_word = Carbon::parse($from)->format("D");
			$_timesheet[$from]->record = $this->timesheet_process_in_out($timesheet_db);
			$_timesheet[$from]->daily_info = $this->timesheet_process_daily_info($timesheet_db);
			$from = Carbon::parse($from)->addDay()->format("Y-m-d");
		}

		return $_timesheet;
	}
	public function timesheet_info_db($employee_id, $date)
	{
		return Tbl_payroll_time_sheet::where("payroll_time_date", Carbon::parse($date)->format("Y-m-d"))->where("payroll_employee_id", $employee_id)->first();
	}
	public function timesheet_process_in_out($timesheet_db)
	{
		$_timesheet_record = null;
		if($timesheet_db)
		{
			$_timesheet_record_db = $this->db_get_time_sheet_record_of_in_and_out($timesheet_db->payroll_time_sheet_id);
			$_timesheet_record = $this->timesheet_process_in_out_record($_timesheet_record_db);
		}
		else
		{
			$_timesheet_record = $this->timesheet_process_in_out_default();
		}

		return $_timesheet_record;
	}
	public function timesheet_process_daily_info($timesheet_db)
	{
		$return = new stdClass();

		if($timesheet_db)
		{
			$return->for_approval = 0;
			$return->daily_salary = 500;
		}
		else
		{
			$return->for_approval = 0;
			$return->daily_salary = 0;
		}

		return $return;
	}
	public function timesheet_process_in_out_default()
	{
		$_timesheet_record[0] = new stdClass();
		$_timesheet_record[0]->time_sheet_in = "";
		$_timesheet_record[0]->time_sheet_out = "";
		$_timesheet_record[0]->time_sheet_activity = "";
		return $_timesheet_record;
	}
	public function timesheet_process_in_out_record($_timesheet_record_db)
	{
		foreach($_timesheet_record_db as $key => $record)
		{
			$_timesheet_record[$key] = new stdClass();
			$_timesheet_record[$key]->time_sheet_in = $this->gb_convert_time_from_db_to_timesheet($record->payroll_time_sheet_in);
			$_timesheet_record[$key]->time_sheet_out = $this->gb_convert_time_from_db_to_timesheet($record->payroll_time_sheet_out);
			$_timesheet_record[$key]->time_sheet_activity = $record->payroll_time_shee_activity;
		}

		return $_timesheet_record;
	}
	/* GLOBAL FUNCTION FOR THIS CONTROLLER */
	public function gb_convert_time_from_db_to_timesheet($db_time)
	{
		if($db_time == "00:00:00")
		{
			$return = "";
		}
		else
		{
			$return = $db_time;
		}

		return $return;
	}

	/* DB CONNECT FUNCTIONS */
	public function db_get_employee_information($employee_id)
	{
		return Tbl_payroll_employee_basic::where("shop_id", $this->user_info->shop_id)->where("payroll_employee_id", $employee_id)->first();
	}
	public function db_get_list_of_employees_by_company($company_id)
	{
		return Tbl_payroll_employee_basic::where("shop_id", $this->user_info->shop_id)->where("payroll_employee_company_id", $company_id)->orderBy("payroll_employee_number")->get();
	}
	public function db_get_company_period_information($period_id)
	{
		return Tbl_payroll_period_company::sel($period_id)->select('tbl_payroll_company.*','tbl_payroll_period.*','tbl_payroll_period_company.*')->first();
	}
	public function db_get_time_sheet_record_of_in_and_out($time_sheet_id)
	{
		return Tbl_payroll_time_sheet_record::where("payroll_time_sheet_id", $time_sheet_id)->get();
	}
}