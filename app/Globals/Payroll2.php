<?php
namespace App\Globals;
use stdClass;
use App\Globals\Payroll;

class Payroll2
{
    /*
     * TITLE: CLEAN SHIFT
     * 
     * Returns a clean TIME IN and TIME OUT when cross reference with SHIFTING SCHEDULES.
     *
     * @param
     *    $_time (array)
     *		- time_in
     *		- time_out
     *
     *	  $_shift (array)
     *		- shift_in
     *		- shift_out
     *
     * @return (array)
     *    	- time_in
     *		- time_out
     *		- auto_approve
     *		- reason
     *		- status time sched
     *		- extra time
     *
     * @author (Kim Briel Oraya)
     *
     */
	public static function clean_shift($_time, $_shift, $testing = false)
	{
		$output_ctr = 0;
		$_output = null;
		if (($_time == null)) 
		{
			
		}
		else if (($_shift == null)) 
		{
			foreach ($_time as $time) 
			{
				$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 0,"NULL SCHEDULE");
			}
		}
		else
		{
			$count_time=0;
			$output_array=array();
			$one_time=true;
			foreach ($_time as $time)
			{
				$one_time=true;
				$count_shift=0;
				$time_in_minutes = explode(":", $time->time_in);
				$time_out_minutes = explode(":", $time->time_out);
				$time_in_minutes = ($time_in_minutes[0]*3600) + ($time_in_minutes[1]*60);
				$time_out_minutes = ($time_out_minutes[0]*3600) + ($time_out_minutes[1]*60);


				foreach($_shift as $shift)
				{
					echo $testing == true ?  "<hr><br><br>compare: Time (" . date("h:i A", strtotime($time->time_in)) . " - " . date("h:i A", strtotime($time->time_out)) . ") vs Shift (" . date("h:i A", strtotime($shift->shift_in)) . "-" . date("h:i A", strtotime($shift->shift_out)) . ")<br>" : "";

					$shift_in_minutes = explode(":", $shift->shift_in);
					$shift_out_minutes = explode(":", $shift->shift_out);
					$shift_in_minutes = ($shift_in_minutes[0]*3600) + ($shift_in_minutes[1]*60);
					$shift_out_minutes = ($shift_out_minutes[0]*3600) + ($shift_out_minutes[1]*60);
				
					/*START first and between early time in*/
					// if (($count_time==0)&&($count_shift==0)) 
					// {
					// 	if ($time_in_minutes<$shift_in_minutes) 
					// 	{
					// 		echo "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($shift->shift_in)." (0) - <span style='color: green;'>FIRST EARLY</span><br></b>";
					// 	}
					// }

					if (($time_in_minutes<$shift_in_minutes)&&($time_out_minutes>=$shift_in_minutes)) 
					{
						if ($one_time) 
						{
							$reason = "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ". Payroll2::convert_to_12_hour($shift->shift_in)." (0)- <span style='color: green; text-transform: uppercase'>early over time<span><br></b>";
							echo $testing == true ? $reason : ""; 
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $shift->shift_in, 0, $reason, "OVERTIME",Payroll::time_diff($time->time_in,$shift->shift_in));					
						}

						$one_time=false;
					}
					else if(($time_in_minutes>=$shift_in_minutes)&&($time_in_minutes<=$shift_out_minutes))
					{
						$one_time=false;
					}
					/*END first and between early time in */


					/*START all approve timeshift*/
					//if sandwich
					if (($time_in_minutes<=$shift_in_minutes)&&($time_out_minutes>=$shift_out_minutes)) 
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($shift->shift_in)." to ". Payroll2::convert_to_12_hour($shift->shift_out)." (1) - <span style='color: green; text-transform: uppercase'>sandwich between timein and time out</span><br></b>";
						echo $testing == true ? $reason : ""; 
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_in, $shift->shift_out, 1,$reason,"APPROVED");
					}
					//late time in but not undertime
					else if ((($time_in_minutes>$shift_in_minutes)&&($time_in_minutes<$shift_out_minutes))
						&&($time_out_minutes>$shift_out_minutes)) 
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($shift->shift_out)." (1)- <span style='color: green; text-transform: uppercase'>LATE TIME IN BUT NOT UNDERTIME<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $shift->shift_out, 1,$reason,"LATE",Payroll::time_diff($shift->shift_in,$time->time_in));
					}
					//not late time in but undertime time out
					else if(($time_in_minutes<$shift_in_minutes)&&
						(($time_out_minutes>$shift_in_minutes)&&($time_out_minutes<$shift_out_minutes)))
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($shift->shift_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (1) - <span style='color: green; text-transform: uppercase'>ONTIME BUT UNDERTIME<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_in, $time->time_out, 1,$reason,"UNDERTIME",Payroll::time_diff($time->time_out,$shift->shift_out));
					}
					//late and undertime
					else if (($time_in_minutes>$shift_in_minutes)&&($time_out_minutes<$shift_out_minutes)) 
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (1)- <span style='color: green; text-transform: uppercase'>LATE AND UNDERTIME<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 1,$reason,"LATE AND UNDERTIME",Payroll::time_diff($shift->shift_in,$time->time_in)." ".Payroll::time_diff($time->time_out,$shift->shift_out));
					}
					/*END all approve shift*/



					/*START last overtime*/
					$count_shift++;
					//last overtime out
					if ((($count_time+1)==sizeof($_time))&&($count_shift==sizeof($_shift))) 
					{
						if ($time_out_minutes>$shift_out_minutes) 
						{
							$reason = "<b>answer: ". Payroll2::convert_to_12_hour($shift->shift_out)." to ". Payroll2::convert_to_12_hour($time->time_out)." (0)- <span style='color: green; text-transform: uppercase'>LAST OVERTIME<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_out, $time->time_out, 0,$reason,"OVERTIME",Payroll::time_diff($shift->shift_out,$time->time_out));
						}
					}
					/*END last overtime*/

					
					/*START between overtime Sandwich*/
					//if there is next shift
					if (isset($_shift[$count_shift])) 
					{
						$next_shift_in_minutes = explode(":", $_shift[$count_shift]->shift_in);
						$next_shift_out_minutes = explode(":", $_shift[$count_shift]->shift_out);
						$next_shift_in_minutes = ($next_shift_in_minutes[0]*3600) + ($next_shift_in_minutes[1]*60) + $next_shift_in_minutes[2];
						$next_shift_out_minutes = ($next_shift_out_minutes[0]*3600) + ($next_shift_out_minutes[1]*60) + $next_shift_out_minutes[2];

						// if overtime
						if (($time_out_minutes>$shift_out_minutes)&&
							($time_out_minutes<$next_shift_in_minutes)) 
						{
							
							$reason = "<b>answer: ".$shift->shift_out." to ".$time->time_out." (0) - <span style='color: green; text-transform: uppercase'>BETWEEN SHIFT OUT AND NEXT SHIFT IN OVERTIME<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_out, $time->time_out, 0, $reason,"OVERTIME",Payroll::time_diff($shift->shift_out,$time->time_out));
						}

						// sandwich overtime between shift out and next shift in
						if (($time_in_minutes>$shift_out_minutes)&&($time_out_minutes<$next_shift_in_minutes)) 
						{
							$reason = "<b>answer: ".Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (0) - <span style='color: green; text-transform: uppercase'>SANDWICH BETWEEN SHIFT OUT AND NEXT SHIFT IN<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 0, $reason,"OVERTIME",Payroll::time_diff($time->time_in,$time->time_out));
						}
						
						//sandwich overtime, time out is between next shift in and out
						if (($time_in_minutes<$shift_out_minutes)&&
							($time_out_minutes>=$next_shift_in_minutes)) 
						{ 
							$reason = "<b>answer: ".Payroll2::convert_to_12_hour($shift->shift_out)." to ".Payroll2::convert_to_12_hour($_shift[$count_shift]->shift_in)." (0)- <span style='color: green; text-transform: uppercase'>sandwich overtime, time in is between next shift in and out<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_out, $_shift[$count_shift]->shift_in, 0, $reason,"OVERTIME",Payroll::time_diff($shift->shift_out, $_shift[$count_shift]->shift_in));
						}
						// //early time in next shift
						// if (($time_in_minutes>$shift_out_minutes)&&($time_in_minutes<$next_shift_in_minutes)
						// 	&&(($time_out_minutes>=$next_shift_in_minutes)&&($time_out_minutes<=$next_shift_out_minutes))) 
						// {
						// 	echo "<b>answer: ".Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($_shift[$count_shift]->shift_in)." (0)- <span style='color: green; text-transform: uppercase'>early time in next shift<span><br></b>";
						// }
					}
					/*END between overtime Sandwich*/

				}
				$one_time=true;
				$count_time++;
			}
		}
		return $_output;
	}

    /*
     * TITLE: COMPUTE TIME MODE FOR REGULAR
     * 
     * Returns breakdown of hours depending on the shift schedule.
     *
     * @param
     *    $_time (array)
     *		- time_in (time 00:00:00)
     *		- time_out (time 00:00:00)
     *		- overtime (time 00:00:00)
     *		- late (time 00:00:00)
     *		- undertime (time 00:00:00)
     *		- overtime_approved (boolean true/false)
     *	  $_shift (array)
     *		- shift_in (time 00:00:00)
     *		- shift_out (time 00:00:00)
     *	  $late_grace_time (time 00:00:00)
     *	  $day_type (string "regular", "rest_day", "extra_day")
     *    $is_holiday (string "not_holiday", "special", "regular")
     *    $leave (time 00:00:00)
     * @return (array)
     *    	- time_spent
     *		- is_absent (boolean true/false)
     *		- late (time 00:00:00)
     *		- undertime (time 00:00:00)
     *		- overtime (time 00:00:00)
     *		- regular_hours (time 00:00:00)
     *		- rest_day_hours (time 00:00:00)
     *		- extra_day_hours (time 00:00:00)
     *		- regular_holiday_hours (time 00:00:00)
     *		- special_holiday_hours (time 00:00:00)
     *		- leave_hours (time 00:00:00)
     *		- total_hours (time 00:00:00)
     *		- night_differential (time 00:00:00)
     *		- is_half_day (boolean true/false)
     *
     * @author (Kim Briel Oraya)
     *
     */
	public static function compute_time_mode_regular($_time, $_shift, $late_grace_time = "00:15:00", $day_type = "regular", $is_holiday = "not_holiday", $leave = "00:00:00")
	{
		$return["time_spent"] = "00:00:00";
		$return["is_absent"] = false;
		$return["late"] = "00:00:00";
		$return["undertime"] = "00:00:00";
		$return["overtime"] = "00:00:00";
		$return["regular_hours"] = "00:00:00";
		$return["rest_day_hours"] = "00:00:00";
		$return["extra_day_hours"] = "00:00:00";
		$return["regular_holiday_hours"] = "00:00:00";
		$return["special_holiday_hours"] = "00:00:00";
		$return["leave_hours"] = "00:00:00";
		$return["total_hours"] = "00:00:00";
		$return["night_differential"] = "00:00:00";
		$return["is_half_day"] = false;
		
		return $return;
	}
	public static function compute_time_mode_flexitime($_time, $target_hours = 0, $day_type = "regular", $is_holiday = 0, $leave = "00:00:00")
	{
	}
	//,$_time_out,$status_time_sched
	public static function time_sched_report($_output,$testing = false)
	{
		foreach ($_output as $output) 
		{
			
		}
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
		$if_check_exist=false;
		$time_exist_array = explode(":", $check_exist);
		$time_in_array = explode(":", $between_in);
		$time_out_array = explode(":",$between_out);

		$check_exist =($time_exist_array[0]*3600) + ($time_exist_array[1]*60) + $time_exist_array[2];
		$between_in = ($time_in_array[0]*3600) + ($time_in_array[1]*60) + $time_in_array[2];
		$between_out = ($time_out_array[0]*3600) + ($time_out_array[1]*60) + $time_out_array[2];

		if (($check_exist>=$between_in)&&($check_exist<=$between_out)) {
			$if_check_exist=true;
		}

		return $if_check_exist;
	}
	public static function convert_to_12_hour($strDate)
	{
		return date("h:i A", strtotime($strDate));
	}
	public static function time_shift_output($_output, $index, $time_in, $time_out, $auto_approved, $reason = "",$status_time_sched = "",$extra_time="00:00:00")
	{
		
		$_output[$index] = new stdClass();
		$_output[$index]->time_in = $time_in;
		$_output[$index]->time_out = $time_out;
		$_output[$index]->auto_approved = $auto_approved;
		$_output[$index]->reason=$reason;
		$_output[$index]->status_time_sched = $status_time_sched;
		$_output[$index]->extra_time = $extra_time;

		return $_output;
	}

	public static function time_shift_report($_output,$index,$time_spent)
	{
		$_output[$index] = new stdClass();
		$_output[$index]->time_spent = $time_spent;

		return $_output;
	}

}