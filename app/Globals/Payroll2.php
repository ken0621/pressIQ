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
		if (($_time == "00:00:00")) 
		{
			
		}
		else if (($_shift == "00:00:00")) 
		{
			foreach ($_time as $time) 
			{
				$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 0,"NO SCHEDULE","00:00:00","00:00:00","00:00:");
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
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $shift->shift_in, 0, $reason, "OVERTIME","00:00:00","00:00:00",Payroll::time_diff($time->time_in,$shift->shift_in));					
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
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_in, $shift->shift_out, 1,$reason,"APPROVED","00:00:00","00:00:00","00:00:00");
					}
					//late time in but not undertime
					//error: solve by adding equal sing in 2nd line condition
					else if ((($time_in_minutes>$shift_in_minutes)&&($time_in_minutes<$shift_out_minutes))
						&&($time_out_minutes>=$shift_out_minutes)) 
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($shift->shift_out)." (1)- <span style='color: green; text-transform: uppercase'>LATE TIME IN BUT NOT UNDERTIME<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $shift->shift_out, 1,$reason,"LATE",Payroll::time_diff($shift->shift_in,$time->time_in),"00:00:00","00:00:00");
					}
					//not late time in but undertime time out
					//error: solve by adding equal sign in first condition
					else if(($time_in_minutes<=$shift_in_minutes)&&
						(($time_out_minutes>$shift_in_minutes)&&($time_out_minutes<$shift_out_minutes)))
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($shift->shift_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (1) - <span style='color: green; text-transform: uppercase'>ONTIME BUT UNDERTIME<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_in, $time->time_out, 1,$reason,"UNDERTIME","00:00:00",Payroll::time_diff($time->time_out,$shift->shift_out),"00:00:00");
					}
					//late and undertime
					else if (($time_in_minutes>$shift_in_minutes)&&($time_out_minutes<$shift_out_minutes)) 
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (1)- <span style='color: green; text-transform: uppercase'>LATE AND UNDERTIME<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 1,$reason,"LATE AND UNDERTIME",Payroll::time_diff($shift->shift_in,$time->time_in),Payroll::time_diff($time->time_out,$shift->shift_out),"00:00:00");
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
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_out, $time->time_out, 0,$reason,"OVERTIME","00:00:00","00:00:00",Payroll::time_diff($shift->shift_out,$time->time_out));
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
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_out, $time->time_out, 0, $reason,"OVERTIME","00:00:00","00:00:00",Payroll::time_diff($shift->shift_out,$time->time_out));
						}

						// sandwich overtime between shift out and next shift in
						if (($time_in_minutes>$shift_out_minutes)&&($time_out_minutes<$next_shift_in_minutes)) 
						{
							$reason = "<b>answer: ".Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (0) - <span style='color: green; text-transform: uppercase'>SANDWICH BETWEEN SHIFT OUT AND NEXT SHIFT IN<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 0, $reason,"OVERTIME","00:00:00","00:00:00",Payroll::time_diff($time->time_in,$time->time_out));
						}
						
						//sandwich overtime, time out is between next shift in and out
						if (($time_in_minutes<$shift_out_minutes)&&
							($time_out_minutes>=$next_shift_in_minutes)) 
						{ 
							$reason = "<b>answer: ".Payroll2::convert_to_12_hour($shift->shift_out)." to ".Payroll2::convert_to_12_hour($_shift[$count_shift]->shift_in)." (0)- <span style='color: green; text-transform: uppercase'>sandwich overtime, time in is between next shift in and out<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_out, $_shift[$count_shift]->shift_in, 0, $reason,"OVERTIME","00:00:00","00:00:00",Payroll::time_diff($shift->shift_out, $_shift[$count_shift]->shift_in));
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
     *    	- time_spent (time 00:00:00)
     *		- is_absent (boolean true/false)
     *		- late (time 00:00:00)
     *		- undertime (time 00:00:00)
     *		- overtime (time 00:00:00)
     *		- target_hours (time 00:00:00)
     *		- regular_hours (time 00:00:00) (overtime+night_diff)-time_spent
     *		- rest_day_hours (time 00:00:00)
     *		- extra_day_hours (time 00:00:00)
     *		- regular_holiday_hours (time 00:00:00)
     *		- special_holiday_hours (time 00:00:00)
     *		- leave_hours (time 00:00:00)
     *		- excess_hours (time 00:00:00) //for undefined time (regular_hours+leave_hours)-target_hours
     *		- night_differential (time 00:00:00)
     *		- is_half_day (boolean true/false)
     *
     * @author (Kim Briel Oraya)
     *
     */
	public static function compute_time_mode_regular($_time, $_shift, $late_grace_time = "00:15:00", $day_type = "regular", $is_holiday = "not_holiday", $leave = "00:00:00",$testing = false)
	{

		$time_spent="00:00";
		$late_hours = "00:00";
		$under_time = "00:00";
		$over_time = "00:00";
		$night_differential=Payroll2::night_differential_computation($_time);
		$target_hours = "00:00";
		$regular_hours = "00:00";
		$rest_day_hours = "00:00:00";
		$extra_day_hours = "00:00:00";
		$regular_holiday_hours = "00:00";
		$special_holiday_hours = "00:00";
		$leave_hours = $leave;
		$excess_hours = "00:00";
		$is_half_day = false;


		$count=0;
		$_output = $_time;

		
		$target_hours = Payroll2::target_hours($_shift);
		
		
		foreach ($_time as $time) 
		{
			echo $testing == true ? "<hr><br><br> TIME IN - ".$time->time_in." vs TIME OUT - ".$time->time_out."<br><br>":"";                                                                                                
			$time_in = explode(":", $time->time_in);
			$time_in = $time_in[0].":".$time_in[1];
			$time_out = explode(":", $time->time_out);
			$time_out = $time_out[0].":".$time_out[1];
			//undertime computation
			$under_time = Payroll::sum_time($under_time,$time->undertime);
			//late hours computation
			$late_hours = Payroll::sum_time($late_hours,$time->late);
			//time spent computation
			$time_spent = Payroll::sum_time($time_spent,Payroll::time_diff($time_in,$time_out));
			//over time computation
			$over_time = Payroll::sum_time($over_time,$time->overtime);
		}

		$regular_hours = Payroll2::minus_times($time_spent,(Payroll::sum_time($over_time,$night_differential))).":00";               //(overtime+night_diff)-time_spent

		if ($day_type == "rest_day") 
		{
			$rest_day_hours = $regular_hours.":00";
		}
		else if ($day_type == "extra_day") 
		{
			$extra_day_hours = $regular_hours.":00";
		}

		if ($is_holiday == "regular_holiday") 
		{
			$regular_holiday_hours = $regular_hours.":00";
		}
		else if ($is_holiday == "special_holiday") 
		{
			$special_holiday_hours = $regular_hours.":00";
		}
		if ((Payroll2::divide_time_in_half($target_hours.":00"))==$time_spent.":00") 
		{
			$is_half_day=true;
		}

		$return["time_spent"] = $time_spent.":00";
		$return["is_absent"] = false;
		$return["late"] = $late_hours.":00";
		$return["undertime"] = $under_time.":00";
		$return["overtime"] = $over_time.":00";
		$return["target_hours"] = $target_hours.":00";
		$return["regular_hours"] = $regular_hours;
		$return["rest_day_hours"] = $rest_day_hours;
		$return["extra_day_hours"] = $extra_day_hours;
		$return["regular_holiday_hours"] = $regular_holiday_hours;
		$return["special_holiday_hours"] = $special_holiday_hours;
		$return["leave_hours"] = $leave;
		$return["total_hours"] = $time_spent.":00";
		$return["night_differential"] = $night_differential;
		$return["is_half_day"] = $is_half_day;
		
		return $return;
	}
	public static function compute_time_mode_flexitime($_time, $target_hours = 0, $day_type = "regular", $is_holiday = 0, $leave = "00:00:00")
	{

	}


	//night differential 10pm to 6am militiary time
	public static function night_differential_computation($_time,$testing=false)
	{
		$night_differential = "00:00";
		foreach ($_time as $time) 
		{
			echo $testing == true ? "<hr><br><br> TIME IN - ".$time->time_in." vs TIME OUT - ".$time->time_out."<br><br>":"";
			$time_in_integer = explode(":", $time->time_in);
			$time_out_integer = explode(":", $time->time_out);
			$time_in_integer = (int)$time_in_integer[0]."".$time_in_integer[1];
			$time_out_integer = (int)$time_out_integer[0]."".$time_out_integer[1];

			/*START night differential computation*/
			if((2200<$time_in_integer)&&(2400>=$time_out_integer))
			{
				echo $testing == true ? "<b>NIGTH DIFFERENTIAL</b> answer: <b>".Payroll2::minus_times($time->time_out,$time->time_in)."</b> hour night differential reason time in and out is in between 10:00pm to 12:00nn":"";
				$night_differential = Payroll::sum_time($night_differential,Payroll2::minus_times($time->time_out,$time->time_in));
			}
			//if time out was after 10:00pm
			else if (2200<$time_out_integer) 
			{

				echo $testing == true ? "<b>NIGTH DIFFERENTIAL</b> answer: <b>".Payroll2::minus_times($time->time_out,"22:00")."</b> hour night differential reason time out was after 10:00pm":"";
				$night_differential = Payroll::sum_time($night_differential,Payroll2::minus_times($time->time_out,"22:00"));
			}

			//if time in and timeout is in between 12:00nn to 6:00am
			if(((600>$time_in_integer)&&(0000<$time_out_integer))&&(!(600<$time_out_integer)))
			{
				echo $testing == true ? "<b>NIGTH DIFFERENTIAL</b> answer: <b>".Payroll2::minus_times($time->time_out,$time->time_in)."</b> hour night differential reason time in and out is in between 12:00nn to 6:00am":"";
				$night_differential = Payroll::sum_time($night_differential,Payroll2::minus_times($time->time_out,$time->time_in));
			}
			//time in start before 6:00am and time out is after 6am
			else if ((600>$time_in_integer)&&(600<=700)) 
			{
				echo $testing == true ? "<b>NIGTH DIFFERENTIAL</b> answer: <b>".Payroll2::minus_times("06:00",$time->time_in)."</b> hour night differential reason time in start before 06:00 am":"";
				$night_differential = Payroll::sum_time($night_differential,Payroll2::minus_times("06:00",$time->time_in));
			}
		}
		return $night_differential.":00";
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


	public static function time_shift_output($_output, $index, $time_in, $time_out, $auto_approved, $reason = "",$status_time_sched = "",$late="00:00:00",$undertime="00:00:00",$overtime="00:00:00")
	{
		
		$_output[$index] = new stdClass();
		$_output[$index]->time_in = $time_in;
		$_output[$index]->time_out = $time_out;
		$_output[$index]->auto_approved = $auto_approved;
		$_output[$index]->reason=$reason;
		$_output[$index]->status_time_sched = $status_time_sched;
		$_output[$index]->late = $late;
		$_output[$index]->undertime = $undertime;
		$_output[$index]->overtime = $overtime;

		return $_output;
	}

	public static function sum_time($time_1 = '00:00', $time_2 = '00:00')
	{
		$extime1 = explode(':', $time_1);
		$extime2 = explode(':', $time_2);

		$hour = $extime1[0] + $extime2[0];
		$min = 0;
		if(isset($extime1[1]) && isset($extime2[1]))
		{
			$min = $extime1[1] + $extime2[1];
		}

		return Payroll::return_time($hour, $min);
	}

	public static function sum_two_time($time_one,$time_two)
	{
		$time_one = explode(":", $time_one);
		$time_two = explode(":", $time_two);
		$time_one = ($time_one[0]*60) + $time_one[1];
		$time_two = ($time_two[0]*60) + $time_two[1];

		$sum_time = $time_one+$time_two;
		$sum_time = ($sum_time/60) .":".($sum_time%60);
		return $sum_time;
	}


	public static function minus_times($time_1 = '00:00', $time_2 = '00:00')
	{
		$extime1 = explode(':', $time_1);
		$extime2 = explode(':', $time_2);

		$hour = $extime1[0] - $extime2[0];
		$min = 0;
		if(isset($extime1[1]) && isset($extime2[1]))
		{
			$min = $extime1[1] - $extime2[1];
		}
		return Payroll::return_time($hour, $min);
	}

	public static function divide_time_in_half($time_1 = '00:00:00')
	{
		$extime1 = explode(':', $time_1);
		$hour;
		$min = 0;
		if (($extime1[0] %2)==1) 
		{
			$hour = (int)($extime1[0] /2) ;
			$min+=30;
		}
		else
		{
			$hour = ($extime1[0] /2);
		}

		if(isset($extime1[1]))
		{
			$min = $min+((int)$extime1[1] / 2);
		}

		return Payroll::return_time($hour, $min).":00";
	}


	public static function target_hours($_shift)
	{
		$target_hours = "00:00";
		foreach ($_shift as $shift) 
		{
			//target time computation
			$target_hours=Payroll::sum_time($target_hours,Payroll::time_diff($shift->shift_in,$shift->shift_out));
		}
		return $target_hours;
	} 




}