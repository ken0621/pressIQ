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
     *		- time_in (time 00:00:00)
     *		- time_out (time 00:00:00)
     *
     *	  $_shift (array)
     *		- shift_in (time 00:00:00)
     *		- shift_out (time 00:00:00)
     *
     * @return (array)
     *    	- time_in (time 00:00:00)
     *		- time_out (time 00:00:00)
     *		- auto_approve (integer 0 or 1)
     *		- reason (string 00:00:00)
     *		- status_time_sched (time 00:00:00)
     *		- late (time 00:00:00)
     *		- undertime (time 00:00:00)
     *		- overtime (time 00:00:00)
     *		- extra time (time 00:00:00)
     *
     * @author (Kim Briel Oraya)
     *
     */

	public static function clean_shift($_time, $_shift, $testing = false)
	{
		$output_ctr = 0;
		$_output = null;
		if ($_time == null) 
		{
			
		}
		else if ($_shift == null) 
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
				$time_in_minutes = ($time_in_minutes[0]*60) + ($time_in_minutes[1]);
				$time_out_minutes = ($time_out_minutes[0]*60) + ($time_out_minutes[1]);


				foreach($_shift as $shift)
				{

					if ($count_time==(sizeof($_time)-1)&&($time_in_minutes>=Payroll2::convert_time_in_minutes($_shift[sizeof($_shift)-1]->shift_out)))
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (0)- <span style='color: green; text-transform: uppercase'>OVERTIME time in and time out<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 0,$reason,"OVERTIME TIME IN AND OUT","00:00:00","00:00:00",Payroll::time_diff($time->time_in,$time->time_out));
						break;
					}
				

					echo $testing == true ?  "<hr><br><br>compare: Time (" . date("h:i A", strtotime($time->time_in)) . " - " . date("h:i A", strtotime($time->time_out)) . ") vs Shift (" . date("h:i A", strtotime($shift->shift_in)) . "-" . date("h:i A", strtotime($shift->shift_out)) . ")<br>" : "";
					//explode(":", $shift->shift_in)
					$shift_in_minutes = explode(":", $shift->shift_in);
					$shift_out_minutes = explode(":", $shift->shift_out);
					$shift_in_minutes = ($shift_in_minutes[0]*60) + ($shift_in_minutes[1]);
					$shift_out_minutes = ($shift_out_minutes[0]*60) + ($shift_out_minutes[1]);


					/*START first and between early time in*/

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
					//error: solve by adding equal sign in 2nd line condition
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
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 1,$reason,"LATE AND UNDERTIME",Payroll::time_diff($time->time_in,$time->time_out),Payroll::time_diff($time->time_out,$shift->shift_out),"00:00:00");
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
						$next_shift_in_minutes = ($next_shift_in_minutes[0]*60) + ($next_shift_in_minutes[1]);
						$next_shift_out_minutes = ($next_shift_out_minutes[0]*60) + ($next_shift_out_minutes[1]);

						// if overtime
						if (($time_out_minutes>$shift_out_minutes)&&
							($time_out_minutes<$next_shift_in_minutes)) 
						{
							$reason = "<b>answer: ".$shift->shift_out." to ".$time->time_out." (0) - <span style='color: green; text-transform: uppercase'>TIME OUT IS IN BETWEEN SHIFT OUT AND NEXT SHIFT IN OVERTIME<span><br></b>";
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
     * TITLE: CLEAN SHIFT FOR FLEXITIME
     * 
     * Returns a clean TIME IN and TIME OUT when cross reference with SHIFTING SCHEDULES.
     *
     * @param
     *    $_time (array)
     *		- time_in (time 00:00:00)
     *		- time_out (time 00:00:00)
     *
     *	  $target_hours (time 00:00:00)
     *
     * @return (array)
     *    	- time_in (time 00:00:00)
     *		- time_out (time 00:00:00)
     *		- auto_approve (integer 0 or 1)
     *		- reason (string 00:00:00)
     *
     * @author (Kim Briel Oraya)
     *
     */

	public static function clean_shift_flexi($_time, $break_hours="00:00:00" ,$target_hours="00:00:00", $testing = false)
	{
		$index=0;
		$_output=null;
		$target_hours = Payroll2::convert_time_in_minutes($target_hours) + Payroll2::convert_time_in_minutes($break_hours);
		$sum_target_hours = 0;
		foreach ($_time as $time) 
		{

			echo $testing == true ? "<hr><br><br> TIME IN - ".$time->time_in." vs TIME OUT - ".$time->time_out."<br><br>":"";
			$time_in_minutes =Payroll2::convert_time_in_minutes(Payroll::time_diff($time->time_in, $time->time_out));
	
			//sum is not yet over or equal to target hours
			if ($sum_target_hours < $target_hours) 
			{
				if (($time_in_minutes+$sum_target_hours)>$target_hours) 
				{
					echo $testing == true ? "<b>answer</b>: TIME IN = ".$time->time_in." TIME OUT = ". $time->time_out." OVER TARGET TIME<br>":"";
					$minus_minutes = ($time_in_minutes+$sum_target_hours)-$target_hours;
					$_output = Payroll2::flexi_time_shift_output($_output,$index++, $time->time_in, Payroll2::minus_time($minus_minutes,$time->time_out),1 ,"APPROVED");
					$_output = Payroll2::flexi_time_shift_output($_output,$index++, Payroll2::minus_time($minus_minutes,$time->time_out), $time->time_out,0 ,"OVERTIME",Payroll::time_diff(Payroll2::minus_time($minus_minutes,$time->time_out), $time->time_out));
				}
				else
				{
					$_output = Payroll2::flexi_time_shift_output($_output,$index++, $time->time_in, $time->time_out,1 ,"APPROVED");
					echo $testing == true ? "<b>answer</b>: TIME IN = ".$time->time_in." TIME OUT = ". $time->time_out." LESS THAN TARGET TIME<br>":"";
				}
				$sum_target_hours = $sum_target_hours + $time_in_minutes;
			}
			else
			{
				$_output = Payroll2::flexi_time_shift_output($_output,$index++, $time->time_in, $time->time_out,0 ,"OVERTIME",Payroll::time_diff($time->time_in, $time->time_out));
				echo $testing == true ? "<b>answer</b>: TIME IN = ".$time->time_in." TIME OUT = ". $time->time_out." OVERTIME<br>":"";
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
     *		- excess_leave_hours (time 00:00:00) //for undefined time (regular_hours+leave_hours)-target_hours
     *		- night_differential (time 00:00:00)
     *		- is_half_day (boolean true/false)
     *
     * @author (Kim Briel Oraya)
     *
     */
	public static function compute_time_mode_regular($_time, $_shift, $late_grace_time = "00:00:00", $grace_time_rule_late="per_shift",$overtime_grace_time = "00:00:00",$grace_time_rule_overtime="per_shift", $day_type = "regular", $is_holiday = "not_holiday", $leave = "00:00:00",$leave_fill_late=0,$leave_fill_undertime=0,$testing = false)
	{

		$time_spent="00:00";
		$late_hours = "00:00";
		$under_time = "00:00";
		$over_time = "00:00";
		$night_differential="00:00";
		$target_hours = "00:00";
		$regular_hours = "00:00";
		$rest_day_hours = "00:00:00";
		$extra_day_hours = "00:00:00";
		$regular_holiday_hours = "00:00:00";
		$special_holiday_hours = "00:00:00";
		$leave_hours = $leave;
		$excess_leave_hours = $leave;
		$is_half_day = false;
		$is_absent =false;
		$target_hours = Payroll2::target_hours($_shift);
		

		
		if (!(isset($_time[0]))) 
		{
			if (!(($day_type == "rest")||($day_type == "extra")||($is_holiday == "regular")||($is_holiday == "special")||($leave_hours!="00:00:00")))
			{
				$is_absent =true;
			}
		}
		else
		{
			$count=0;
			//compute night differential
			$night_differential=Payroll2::night_differential_computation($_time,false);
			
			foreach ($_time as $time) 
			{
				echo $testing == true ? "<hr><br><br> TIME IN - ".$time->time_in." vs TIME OUT - ".$time->time_out."<br><br>":"";                                                                                                
				//undertime computation
				$under_time = Payroll::sum_time($under_time,$time->undertime);
				
				//late hours computation and depends to time_grace_rule
				if ($grace_time_rule_late=="per_shift") 
				{
					$late_minutes = Payroll2::convert_time_in_minutes($time->late);
					//record late if late is greater than grace time
					if ($late_minutes>Payroll2::convert_time_in_minutes($late_grace_time)) 
					{
						$late_hours = Payroll::sum_time($late_hours,$time->late);
					}
					//remove late and add it to time spent
					else
					{
						$time_spent = Payroll::sum_time($time_spent,$time->late);
					}
				}
				else if ($grace_time_rule_late=="accumulative") 
				{
					$late_hours = Payroll::sum_time($time->late,$late_hours);
				}
				else if ($grace_time_rule_late=="first") 
				{
					//first approve time shift if late record it
					if ($count==0) 
					{
						$late_hours = Payroll::sum_time($time->late,$late_hours);
					}
					//all late time exempt first time shift late record
					else
					{
						$time_spent = Payroll::sum_time($time_spent,$time->late);
					}
				}
				else if ($grace_time_rule_late=="last") 
				{
					if ($count==sizeof($time)) 
					{
						$late_hours = Payroll::sum_time($time->late,$late_hours);
					}
					else
					{
						$time_spent = Payroll::sum_time($time_spent,$time->late);
					}
				}
				
				//time spent computation
				$time_spent = Payroll::sum_time($time_spent,Payroll::time_diff($time->time_in,$time->time_out));
				
				//over time computation per shift
				if($grace_time_rule_overtime=="per_shift")
				{
					if (Payroll2::convert_time_in_minutes($time->overtime)>Payroll2::convert_time_in_minutes($overtime_grace_time)) 
					{
						$over_time = Payroll::sum_time($over_time,$time->overtime);
					}
					else if (Payroll2::convert_time_in_minutes($time->overtime)<=Payroll2::convert_time_in_minutes($overtime_grace_time)) 
					{
						$time_spent = Payroll2::minus_time(Payroll2::convert_time_in_minutes($time->overtime),$time_spent);
					}
				}
				else if($grace_time_rule_overtime=="accumulative")
				{
					$over_time = Payroll::sum_time($over_time,$time->overtime);
				}
				$count++;
			}

		

			//compute regular hours
			$regular_hours = Payroll2::time_difference($time_spent,(Payroll::sum_time($over_time,$night_differential))).":00"; //(overtime+night_diff)-time_spent

			


			//grace time for late - accumulative.
			$late_minutes = Payroll2::convert_time_in_minutes($late_hours);
			if (($late_minutes<=Payroll2::convert_time_in_minutes($late_grace_time))&&($grace_time_rule_late=="accumulative")) 
			{
				$time_spent = Payroll::sum_time($time_spent,$late_hours);
				$late_hours="00:00";
			}

			//grace time for overtime - accumulative.
			$over_time_minutes = Payroll2::convert_time_in_minutes($over_time);
			if (($over_time_minutes<=Payroll2::convert_time_in_minutes($overtime_grace_time))&&($grace_time_rule_overtime=="accumulative")) 
			{
				$time_spent = Payroll2::minus_time($over_time_minutes,$time_spent);
				$over_time="00:00";
			}

			//record if undertime
			$target_minutes = Payroll2::convert_time_in_minutes($target_hours);
			$time_spent_in_minutes = Payroll2::convert_time_in_minutes($time_spent);
			if ($time_spent_in_minutes<$target_minutes) 
			{
				 
				$under_time = Payroll::sum_time($under_time,Payroll::time_diff($time_spent,$target_hours));
			}

			
			//fill late with leave hours
			if ($leave_fill_late==1) 
			{
				$late_minutes = Payroll2::convert_time_in_minutes($late_hours);
				$excess_leave_minutes = Payroll2::convert_time_in_minutes($excess_leave_hours);
				//has late record and have leave hours
				if (($late_minutes>0)&&($excess_leave_minutes>0)) 
				{
					//leave hours can fill the undertime record
					if ($late_minutes<=$excess_leave_minutes) 
					{
						$excess_leave_hours = Payroll2::minus_time($late_minutes,$excess_leave_hours);
						$time_spent = Payroll::sum_time($time_spent,$late_hours);
						$late_hours = "00:00";
					}
					//leave hours can't fill the undertime record
					else if ($late_minutes>$excess_leave_minutes) 
					{
						$late_hours = Payroll2::minus_time($excess_leave_minutes,$late_hours);
						$time_spent = Payroll::sum_time($time_spent,$excess_leave_hours);
						$excess_leave_hours="00:00";
					}
				}
			}

			//fill undertime with leave hours
			if ($leave_fill_undertime==1) 
			{
			 	$undertime_minutes = Payroll2::convert_time_in_minutes($under_time);
				$excess_leave_minutes = Payroll2::convert_time_in_minutes($excess_leave_hours);
				//has undertime record and have leave hours
				if (($undertime_minutes>0)&&($excess_leave_minutes>0)) 
				{
					//leave hours can fill the undertime record
					if ($undertime_minutes<=$excess_leave_minutes) 
					{
						$excess_leave_hours = Payroll2::minus_time($undertime_minutes,$excess_leave_hours);
						$time_spent = Payroll::sum_time($time_spent,$under_time);
						$under_time = "00:00";
					}
					//leave hours can't fill the undertime record
					else if ($undertime_minutes>$excess_leave_minutes) 
					{
						$under_time = Payroll2::minus_time($excess_leave_minutes,$under_time);
						$time_spent = Payroll::sum_time($time_spent,$excess_leave_hours);
						$excess_leave_hours="00:00";
					}
				}
			}
			//excess leave hour if not use
			if (($leave_fill_undertime==0)&&($leave_fill_late==0)) 
			{
				$excess_leave_hours=$leave;
			}

			//check if time spent is only half day
			if ((Payroll2::divide_time_in_half($target_hours.":00"))==$time_spent.":00") 
			{
				$is_half_day=true;
			}
		
			/*START day type and holiday type*/
			if ($day_type=="rest") 
			{
				$rest_day_hours = $regular_hours;
			}
			if ($day_type=="extra") 
			{
				$extra_day_hours = $regular_hours;
			}
			if ($is_holiday=="regular") 
			{
				$regular_holiday_hours = $regular_hours;
			}
			if ($is_holiday=="special") 
			{
				$special_holiday_hours = $regular_hours;
			}
			/*END day type and holiday type*/ 

		}

		$return["time_spent"] = Payroll2::convert_to_24_hour($time_spent);
		$return["is_absent"] = $is_absent;
		$return["late"] = Payroll2::convert_to_24_hour($late_hours);
		$return["undertime"] = Payroll2::convert_to_24_hour($under_time);
		$return["overtime"] = Payroll2::convert_to_24_hour($over_time);
		$return["target_hours"] = Payroll2::convert_to_24_hour($target_hours);
		$return["excess_leave_hours"] = Payroll2::convert_to_24_hour($excess_leave_hours);
		$return["regular_hours"] = Payroll2::convert_to_24_hour($regular_hours);
		$return["rest_day_hours"] = Payroll2::convert_to_24_hour($rest_day_hours);
		$return["extra_day_hours"] = Payroll2::convert_to_24_hour($extra_day_hours);
		$return["regular_holiday_hours"] = Payroll2::convert_to_24_hour($regular_holiday_hours);
		$return["special_holiday_hours"] = Payroll2::convert_to_24_hour($special_holiday_hours);
		$return["leave_hours"] = Payroll2::convert_to_24_hour($leave);
		$return["total_hours"] = Payroll2::convert_to_24_hour($time_spent);
		$return["night_differential"] = Payroll2::convert_to_24_hour($night_differential);
		$return["is_half_day"] = $is_half_day;
		$return["is_holiday"] = $is_holiday;
		
		return $return;
	}



	/*
     * TITLE: COMPUTE TIME MODE FOR FLEXI
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
     *		- excess_leave_hours (time 00:00:00) //for undefined time (regular_hours+leave_hours)-target_hours
     *		- night_differential (time 00:00:00)
     *		- is_half_day (boolean true/false)
     *
     * @author (Kim Briel Oraya)
     *
     */
	public static function compute_time_mode_flexi($_time, $target_hours="00:00:00", $break_hours="00:00:00", $overtime_grace_time = "00:00:00", $grace_time_rule_overtime="per_shift", $day_type = "regular", $is_holiday = "not_holiday", $leave = "00:00:00", $leave_fill_undertime=0, $testing = false)
	{

		$time_spent="00:00";
		$late_hours = "00:00";
		$under_time = "00:00";
		$over_time = "00:00";
		$night_differential= Payroll2::night_differential_computation($_time,false);
		$target_hours = Payroll::sum_time($target_hours,$break_hours);
		$regular_hours = "00:00";
		$rest_day_hours = "00:00:00";
		$extra_day_hours = "00:00:00";
		$regular_holiday_hours = "00:00:00";
		$special_holiday_hours = "00:00:00";
		$leave_hours = $leave;
		$excess_leave_hours = $leave;
		$is_half_day = false;
		$is_absent =false;

		if (!(isset($_time[0]))) 
		{
			if (!(($day_type == "rest")||($day_type == "extra")||($is_holiday == "regular")||($is_holiday == "special")||($leave_hours!="00:00:00")))
			{
				$is_absent =true;
			}
		}
		else
		{
			foreach ($_time as $time) 
			{
				//time spent computation
				$time_spent = Payroll::sum_time($time_spent,Payroll::time_diff($time->time_in,$time->time_out));


				//over time computation per shift
				if($grace_time_rule_overtime=="per_shift")
				{
					if (Payroll2::convert_time_in_minutes($time->overtime)>Payroll2::convert_time_in_minutes($overtime_grace_time)) 
					{
						$over_time = Payroll::sum_time($over_time,$time->overtime);
					}
					else if (Payroll2::convert_time_in_minutes($time->overtime)<=Payroll2::convert_time_in_minutes($overtime_grace_time)) 
					{
						$time_spent = Payroll2::minus_time(Payroll2::convert_time_in_minutes($time->overtime),$time_spent);
					}
				}
				else if($grace_time_rule_overtime=="accumulative")
				{
					$over_time = Payroll::sum_time($over_time,$time->overtime);
				}

			}
		}

		
		//record if undertime
		$target_minutes = Payroll2::convert_time_in_minutes($target_hours);
		$time_spent_in_minutes = Payroll2::convert_time_in_minutes($time_spent);
		if ($time_spent_in_minutes<$target_minutes) 
		{
			 
			$under_time = Payroll::sum_time($under_time,Payroll::time_diff($time_spent,$target_hours));
		}

		//fill undertime with leave hours
		if ($leave_fill_undertime==1) 
		{
		 	$undertime_minutes = Payroll2::convert_time_in_minutes($under_time);
			$excess_leave_minutes = Payroll2::convert_time_in_minutes($excess_leave_hours);
			//has undertime record and have leave hours
			if (($undertime_minutes>0)&&($excess_leave_minutes>0)) 
			{
				//leave hours can fill the undertime record
				if ($undertime_minutes<=$excess_leave_minutes) 
				{
					$excess_leave_hours = Payroll2::minus_time($undertime_minutes,$excess_leave_hours);
					$time_spent = Payroll::sum_time($time_spent,$under_time);
					$under_time = "00:00";
				}
				//leave hours can't fill the undertime record
				else if ($undertime_minutes>$excess_leave_minutes) 
				{
					$under_time = Payroll2::minus_time($excess_leave_minutes,$under_time);
					$time_spent = Payroll::sum_time($time_spent,$excess_leave_hours);
					$excess_leave_hours="00:00";
				}
			}
		}
		else
		{
			$excess_leave_minutes = $leave;
		}

		
		//grace time for overtime - accumulative.
		$over_time_minutes = Payroll2::convert_time_in_minutes($over_time);
		if (($over_time_minutes<=Payroll2::convert_time_in_minutes($overtime_grace_time))&&($grace_time_rule_overtime=="accumulative")) 
		{
				$time_spent = Payroll2::minus_time($over_time_minutes,$time_spent);
				$over_time="00:00";
		}


		//check if time spent is only half day
		if ((Payroll2::divide_time_in_half($target_hours.":00"))==$time_spent.":00") 
		{
			$is_half_day=true;
		}


		//compute regular hours
		$regular_hours = Payroll2::time_difference($time_spent,(Payroll::sum_time($over_time,$night_differential))).":00"; //(overtime+night_diff)-time_spent



		/*START day type and holiday type*/
		if ($day_type=="rest") 
		{
			$rest_day_hours = $regular_hours;
		}
		if ($day_type=="extra") 
		{
			$extra_day_hours = $regular_hours;
		}
		if ($is_holiday=="regular") 
		{
			$regular_holiday_hours = $regular_hours;
		}
		if ($is_holiday=="special") 
		{
			$special_holiday_hours = $regular_hours;
		}
		/*END day type and holiday type*/



		$return["time_spent"] = Payroll2::convert_to_24_hour($time_spent);
		$return["is_absent"] = $is_absent;
		$return["late"] = Payroll2::convert_to_24_hour($late_hours);
		$return["undertime"] = Payroll2::convert_to_24_hour($under_time);
		$return["overtime"] = Payroll2::convert_to_24_hour($over_time);
		$return["target_hours"] = Payroll2::convert_to_24_hour($target_hours);
		$return["excess_leave_hours"] = Payroll2::convert_to_24_hour($excess_leave_hours);
		$return["regular_hours"] = Payroll2::convert_to_24_hour($regular_hours);
		$return["rest_day_hours"] = Payroll2::convert_to_24_hour($rest_day_hours);
		$return["extra_day_hours"] = Payroll2::convert_to_24_hour($extra_day_hours);
		$return["regular_holiday_hours"] = Payroll2::convert_to_24_hour($regular_holiday_hours);
		$return["special_holiday_hours"] = Payroll2::convert_to_24_hour($special_holiday_hours);
		$return["leave_hours"] = Payroll2::convert_to_24_hour($leave);
		$return["total_hours"] = Payroll2::convert_to_24_hour($time_spent);
		$return["night_differential"] = Payroll2::convert_to_24_hour($night_differential);
		$return["is_half_day"] = $is_half_day;
		
		return $return;
	}


	public static function compute_income_daily()
	{

	}

	//compute target time
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
			if((2200<=$time_in_integer)&&(2400>=$time_out_integer))
			{
				echo $testing == true ? "<b>NIGTH DIFFERENTIAL</b> answer: <b>".Payroll2::time_difference($time->time_out,$time->time_in)."</b> hour night differential reason time in and out is in between 10:00pm to 12:00nn":"";
				$night_differential = Payroll::sum_time($night_differential,Payroll2::time_difference($time->time_out,$time->time_in));
			}
			//if time out was after 10:00pm
			else if (2200<$time_out_integer) 
			{

				echo $testing == true ? "<b>NIGTH DIFFERENTIAL</b> answer: <b>".Payroll2::time_difference($time->time_out,"22:00")."</b> hour night differential reason time out was after 10:00pm":"";
				$night_differential = Payroll::sum_time($night_differential,Payroll2::time_difference($time->time_out,"22:00"));
			}

			//if time in and timeout is in between 12:00nn to 6:00am
			if(((600>$time_in_integer)&&(0000<$time_out_integer))&&(!(600<$time_out_integer)))
			{
				echo $testing == true ? "<b>NIGTH DIFFERENTIAL</b> answer: <b>".Payroll2::time_difference($time->time_out,$time->time_in)."</b> hour night differential reason time in and out is in between 12:00nn to 6:00am":"";
				$night_differential = Payroll::sum_time($night_differential,Payroll2::time_difference($time->time_out,$time->time_in));
			}
			//time in start before 6:00am and time out is after 6am
			else if ((600>$time_in_integer)&&(600<=$time_out_integer)) 
			{
				echo $testing == true ? "<b>NIGTH DIFFERENTIAL</b> answer: <b>".Payroll2::time_difference("06:00",$time->time_in)."</b> hour night differential reason time in start before 06:00 am":"";
				$night_differential = Payroll::sum_time($night_differential,Payroll2::time_difference("06:00",$time->time_in));
			}
		}
		return Payroll2::convert_to_24_hour($night_differential);
	}

	public static function compute_day_pay($mode, $_time, $_shift)
	{
		switch ($mode)
		{
			case 'hourly': Self::compute_day_pay_hourly($_time, $_shift); break;
			default: Self::compute_income_day_pay($_time, $_shift); break;
		}
	}

	public static function compute_day_pay_hourly($_time, $_shift)
	{
	}

    /*
     * TITLE: COMPUTE INCOME FOR EMPLOYEE DAILY
     * 
     * Returns breakdown of hours depending on the shift schedule.
     *
     * @param
     *	  $daily_rate (double)
     *    $_overtime_rates (array)
     *		- regular_plus_overtime (double)
     *		- regular_plus_night_shift (double)
	 *		- regular_day (double)
	 *		- regular_day_plus_over_time (double)
	 * 		- regular_day_plus_night_diff (double)
	 *		- regular_day_plus_rest_day (double)
	 * 		- regular_day_plus_rest_day_plus_over_time (double)
	 * 		- regular_day_plus_rest_day_plus_night_diff (double)
	 *		- legal_holiday (double)
	 * 		- legal_holiday_plus_over_time (double)
	 *		- legal_holiday_plus_night_diff (double)
	 * 		- legal_holiday_plus_rest_day (double)
	 * 		- legal_holiday_plus_rest_day_plus_over_time (double)
	 * 		- legal_holiday_plus_rest_day_plus_night_diff (double)
	 * 		- special_holiday (double)
	 * 		- special_holiday_plus_over_time (double)
	 *		- special_holiday_plus_night_diff (double)
	 *		- special_holiday_plus_rest_day (double)
	 * 		- special_holiday_plus_rest_day_plus_over_time (double)
	 * 		- special_holiday_plus_rest_day_plus_night_diff (double)
     *    $time_spent (time 00:00:00)
     *    $is_absent (time 00:00:00)
     *    $late (time 00:00:00)
     *    $undertime (time 00:00:00)
     *    $overtime (time 00:00:00)
     *    $target_hours (time 00:00:00)
     *    $excess_leave_hours (time 00:00:00)
     *    $regular_hours (time 00:00:00)
     *    $rest_day_hours (time 00:00:00)
     *    $regular_holiday_hours (time 00:00:00)
     *    $special_holiday_hours (time 00:00:00)
     *    $leave_hours (time 00:00:00)
     *    $total_hours (time 00:00:00)
     *    $night_differential (time 00:00:00)
     *    $is_half_day (time 00:00:00)
     *    
     * @return (array)
     *    $daily_income_breakdown (array)
     *		- daily_rate (array)
     *			- hours (time 00:00:00)
     *			- income (double)
     *			- formula (string "plus" or "minus")
     *		- overtime (array)
     *			- hours (time 00:00:00)
     *			- income (double)
     *			- formula (string "plus" or "minus")
     *      - late (array)
     *			- hours (time 00:00:00)
     *			- income (double)
     *			- formula (string "plus" or "minus")
     *    $daily_income (double)
     *
     * @author (Jimar Zape)
     *
     */
	public static function compute_income_day_pay($_overtime, $time_spent)
	{
	}
	public static function compute_income_month_pay()
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

		if (($check_exist>=$between_in)&&($check_exist<=$between_out)) 
		{
			$if_check_exist=true;
		}

		return $if_check_exist;
	}

	public static function convert_to_12_hour($strDate)
	{
		return date("h:i A", strtotime($strDate));
	}
	

	public static function convert_to_24_hour($strDate)
	{
		return date("H:i:s", strtotime($strDate));
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

	public static function flexi_time_shift_output($_output, $index, $time_in, $time_out, $auto_approved, $reason = "",$over_time="00:00:00")
	{
		$_output[$index] = new stdClass();
		$_output[$index]->time_in = $time_in;
		$_output[$index]->time_out = $time_out;
		$_output[$index]->auto_approved = $auto_approved;
		$_output[$index]->reason=$reason;
		$_output[$index]->overtime = $over_time;
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


	public static function time_difference($time_1 = '00:00', $time_2 = '00:00')
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

	public static function minus_time($minus_time_minutes,$time)
	{
		$time_in_minutes="00:00:00";
		if ($minus_time_minutes<=Payroll2::convert_time_in_minutes($time)) 
		{
			$time_in_minutes = date("H:i:s", strtotime(-($minus_time_minutes)." minutes", strtotime($time)));
		}
		return $time_in_minutes;
	}

	public static function diff_time_in_minutes($time_start,$time_end)
	{
		$start_date = new DateTime('$time_start');
		$since_start = $start_date->diff(new DateTime('$time_end'));
		$minutes="";
		$minutes += $since_start->h * 60;
		$minutes += $since_start->i;
		return $minutes;
	}

	public static function convert_time_in_minutes($time)
	{
		$time = explode(":", $time);
		$time = ($time[0] * 60.0 + $time[1] * 1.0);
		return $time;
	}
}