<?php
namespace App\Globals;
use stdClass;

class Payroll2
{
	public static function time_shift_create_format_based_on_conflict($_time, $_shift)
	{
		$_approved_time = null;
		$key = 0;
		foreach($_time as $time)
		{
			if(count($_shift) > 0)
			{
				foreach($_shift as $shift)
				{
					$_approved_time[$key] = new stdClass();
					$_approved_time[$key]->payroll_time_sheet_in = $time->payroll_time_sheet_in;
					$_approved_time[$key]->payroll_time_sheet_out = $time->payroll_time_sheet_out;
					$_approved_time[$key]->payroll_time_sheet_approved = 0;
					$key++;	
				}
			}
			else
			{	
				if($time->payroll_time_sheet_in != "00:00:00")
				{
					$_approved_time[$key] = new stdClass();
					$_approved_time[$key]->payroll_time_sheet_in = $time->payroll_time_sheet_in;
					$_approved_time[$key]->payroll_time_sheet_out = $time->payroll_time_sheet_out;
					$_approved_time[$key]->payroll_time_sheet_approved = 0;
					$key++;					
				}
			}
		}

		return $_approved_time;
	}
	public static function compute_day_pay($mode, $_time, $_shift)
	{
		switch ($mode)
		{
			case 'hourly': Self::compute_day_pay_hourly($_time, $_shift); break;
			default: Self::compute_day_pay_daily($_time, $_shift); break;
		}
	}
	public static function compute_day_pay_hourly($_time, $_shift)
	{

	}
	public static function compute_day_pay_daily($_time, $_shift)
	{
	}
	/* GLOBALS */
	public static function time_check_if_exist_between($check_exist, $between_in, $between_out)
	{
		$ifCheckExist=false;
		$time_exist_array = explode(":", $check_exist);
		$time_in_array = explode(":", $between_in);
		$time_out_array = explode(":",$between_out);

		$check_exist =($time_exist_array[0]*3600) + ($time_exist_array[1]*60) + $time_exist_array[2]."<br>";
		$between_in = ($time_in_array[0]*3600) + ($time_in_array[1]*60) + $time_in_array[2]."<br>";
		$between_out = ($time_out_array[0]*3600) + ($time_out_array[1]*60) + $time_out_array[2]."<br>";

		if (($check_exist>=$between_in)&&($check_exist<=$between_out)) {
			$ifCheckExist=true;
		}

		return $ifCheckExist;
	}


}