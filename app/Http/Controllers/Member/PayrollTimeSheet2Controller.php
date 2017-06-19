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
use App\Models\Tbl_payroll_time_sheet_record_approved;
use App\Models\Tbl_payroll_group;
use App\Globals\Payroll2;

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
		$data["employee_id"] = $this->$employee_id = $employee_id;
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
			$_timesheet[$from]->payroll_time_sheet_id = $timesheet_db->payroll_time_sheet_id;
			$_timesheet[$from]->date = Carbon::parse($from)->format("Y-m-d");
			$_timesheet[$from]->day_number = Carbon::parse($from)->format("d");
			$_timesheet[$from]->day_word = Carbon::parse($from)->format("D");
			$_timesheet[$from]->record = $this->timesheet_process_in_out($timesheet_db);
			$_timesheet[$from]->daily_info = $this->timesheet_process_daily_info($employee_id, $from, $timesheet_db);
			$from = Carbon::parse($from)->addDay()->format("Y-m-d");
		}

		return $_timesheet;
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
	public function timesheet_process_daily_info($employee_id, $date, $timesheet_db)
	{
		$return = new stdClass();

		if($timesheet_db)
		{
			$approved_record = $this->db_get_time_sheet_record_of_in_and_out_approved($timesheet_db->payroll_time_sheet_id);
			$approved = false;

			if(count($approved_record) > 0)
			{
				$_record = $approved_record;
				$approved = true;
			}
			else
			{
				$_record = $this->db_get_time_sheet_record_of_in_and_out($timesheet_db->payroll_time_sheet_id);
			}


			$return = $this->timesheet_process_daily_info_record($employee_id, $date, $approved, $_record);
		}
		else
		{
			$return->for_approval = 0;
			$return->daily_salary = 0;
		}

		return $return;
	}
	public function timesheet_process_daily_info_record($employee_id, $date, $approved, $_time)
	{
		$return = new stdClass();
		$return->for_approval = ($approved == true ? 0 : 1);
		$return->daily_salary = 0;
		$employee_contract = $this->db_get_current_employee_contract($employee_id);
		$_shift = $this->db_get_shift_based_on_payroll_group($employee_contract->payroll_group_id, $date);
		$_shift_raw = $this->shift_raw($_shift);
		$_time_raw = $this->time_raw($_time);
		$mode = "daily";

		$return->_time = $_time_raw;
		$return->_shift = $_shift_raw;

		if($return->for_approval == 1) //PENDING
		{
			$return->clean_shift = Payroll2::clean_shift($_time_raw, $_shift_raw);
			$return->shift_approved = $this->check_if_shift_approved($return->clean_shift);
		}
		else //APPROVED
		{
			$return->clean_shift = $_time;
			$return->shift_approved = true;
		}
		
		$return->compute = Payroll2::compute_day_pay($mode, $_time, $_shift);
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
		$_timesheet_record = null;

		foreach($_timesheet_record_db as $key => $record)
		{
			$_timesheet_record[$key] = new stdClass();
			$_timesheet_record[$key]->time_sheet_in = $this->gb_convert_time_from_db_to_timesheet($record->payroll_time_sheet_in);
			$_timesheet_record[$key]->time_sheet_out = $this->gb_convert_time_from_db_to_timesheet($record->payroll_time_sheet_out);
			$_timesheet_record[$key]->time_sheet_activity = $record->payroll_time_shee_activity;
		}

		return $_timesheet_record;
	}
	public function day_summary($timesheet_id)
	{
		$data["timesheet_db"] = $timesheet_db = $this->timesheet_info_db_by_id($timesheet_id);
		$data["employee_info"] = $this->db_get_employee_information($timesheet_db->payroll_employee_id); 
		$data["timesheet_info"] = $timesheet_info =$this->timesheet_process_daily_info($timesheet_db->payroll_employee_id, $timesheet_db->payroll_time_date, $timesheet_db);
		return view('member.payroll2.employee_day_summary', $data);
	}
	/* GLOBAL FUNCTION FOR THIS CONTROLLER */
	public function shift_raw($_shift)
	{
		$_shift_raw = null;

		foreach($_shift as $key => $shift)
		{
			if($shift->shift_work_start != null && $shift->shift_work_end != null)
			{
				$_shift_raw[$key] = new stdClass();
				$_shift_raw[$key]->shift_in = $shift->shift_work_start;
				$_shift_raw[$key]->shift_out = $shift->shift_work_end;
			}
		}

		return $_shift_raw;
	}
	/* GLOBAL FUNCTION FOR THIS CONTROLLER */
	public function time_raw($_time)
	{
		$_time_raw = null;

		foreach($_time as $key => $time)
		{
			if($time->payroll_time_sheet_in)
			{
				$_time_raw[$key] = new stdClass();
				$_time_raw[$key]->time_in = $time->payroll_time_sheet_in;
				$_time_raw[$key]->time_out = $time->payroll_time_sheet_out;
			}
		}

		return $_time_raw;
	}
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
	public function check_if_shift_approved($_time)
	{
		$auto_approve = true;

		if($_time == null)
		{
			$auto_approve = true;
		}
		else
		{
			foreach($_time as $time)
			{
				if($time->auto_approved == 0)
				{
					$auto_approve = false;
				}
			}
		}

		return $auto_approve;
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
	public function db_get_time_sheet_record_of_in_and_out_approved($time_sheet_id)
	{
		return Tbl_payroll_time_sheet_record_approved::where("payroll_time_sheet_id", $time_sheet_id)->get();
	}
	public function db_get_current_employee_contract($employee_id)
	{
		return Tbl_payroll_employee_contract::where("payroll_employee_id", $employee_id)->orderBy("payroll_employee_contract_id", "desc")->first();
	}
	public function db_get_shift_based_on_payroll_group($payroll_group_id, $date)
	{
		return Tbl_payroll_group::where("payroll_group_id", $payroll_group_id)->shift()->day()->where("shift_day", date("D", strtotime($date)))->time()->get();
	}
	public function timesheet_info_db($employee_id, $date)
	{
		return Tbl_payroll_time_sheet::where("payroll_time_date", Carbon::parse($date)->format("Y-m-d"))->where("payroll_employee_id", $employee_id)->first();
	}
	public function timesheet_info_db_by_id($timesheet_id)
	{
		return Tbl_payroll_time_sheet::where("payroll_time_sheet_id", $timesheet_id)->first();
	}
}