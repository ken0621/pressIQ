<?php
namespace App\Globals;
use stdClass;

class Payroll2
{
	public static function time_shift_create_format_based_on_conflict($_time, $_shift, $testing = false)
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

				$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 0);
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
				$time_in_seconds = explode(":", $time->time_in);
				$time_out_seconds = explode(":", $time->time_out);
				$time_in_seconds = ($time_in_seconds[0]*3600) + ($time_in_seconds[1]*60) + $time_in_seconds[2];
				$time_out_seconds = ($time_out_seconds[0]*3600) + ($time_out_seconds[1]*60) + $time_out_seconds[2];


				foreach($_shift as $shift)
				{
					echo $testing == true ?  "<hr><br><br>compare: Time (" . date("h:i A", strtotime($time->time_in)) . " - " . date("h:i A", strtotime($time->time_out)) . ") vs Shift (" . date("h:i A", strtotime($shift->shift_in)) . "-" . date("h:i A", strtotime($shift->shift_out)) . ")<br>" : "";

					$shift_in_seconds = explode(":", $shift->shift_in);
					$shift_out_seconds = explode(":", $shift->shift_out);
					$shift_in_seconds = ($shift_in_seconds[0]*3600) + ($shift_in_seconds[1]*60) + $shift_in_seconds[2];
					$shift_out_seconds = ($shift_out_seconds[0]*3600) + ($shift_out_seconds[1]*60) + $shift_out_seconds[2];
				
					/*START first and between early time in*/
					// if (($count_time==0)&&($count_shift==0)) 
					// {
					// 	if ($time_in_seconds<$shift_in_seconds) 
					// 	{
					// 		echo "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($shift->shift_in)." (0) - <span style='color: green;'>FIRST EARLY</span><br></b>";
					// 	}
					// }
					if (($time_in_seconds<$shift_in_seconds)&&($time_out_seconds>=$shift_in_seconds)) 
					{
						if ($one_time) 
						{
							$reason = "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ". Payroll2::convert_to_12_hour($shift->shift_in)." (0)- <span style='color: green; text-transform: uppercase'>early over time<span><br></b>";
							echo $testing == true ? $reason : ""; 
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $shift->shift_in, 0, $reason);					
						}

						$one_time=false;
					}
					else if(($time_in_seconds>=$shift_in_seconds)&&($time_in_seconds<=$shift_out_seconds))
					{
						$one_time=false;
					}
					/*END first and between early time in */


					/*START all approve timeshift*/
					//if sandwich
					if (($time_in_seconds<=$shift_in_seconds)&&($time_out_seconds>=$shift_out_seconds)) 
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($shift->shift_in)." to ". Payroll2::convert_to_12_hour($shift->shift_out)." (1) - <span style='color: green; text-transform: uppercase'>sandwich between timein and time out</span><br></b>";
						echo $testing == true ? $reason : ""; 
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_in, $shift->shift_out, 1,$reason);
					}
					//late time in but not undertime
					else if ((($time_in_seconds>$shift_in_seconds)&&($time_in_seconds<$shift_out_seconds))
						&&($time_out_seconds>$shift_out_seconds)) 
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($shift->shift_out)." (1)- <span style='color: green; text-transform: uppercase'>LATE TIME IN BUT NOT UNDERTIME<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $shift->shift_out, 1,$reason);
					}
					//not late time in but undertime time out
					else if(($time_in_seconds<$shift_in_seconds)&&
						(($time_out_seconds>$shift_in_seconds)&&($time_out_seconds<$shift_out_seconds)))
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($shift->shift_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (1) - <span style='color: green; text-transform: uppercase'>ONTIME BUT UNDERTIME<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_in, $time->time_out, 1,$reason);
					}
					//late and undertime
					else if (($time_in_seconds>$shift_in_seconds)&&($time_out_seconds<$shift_out_seconds)) 
					{
						$reason = "<b>answer: ". Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (1)- <span style='color: green; text-transform: uppercase'>LATE AND UNDERTIME<span><br></b>";
						echo $testing == true ? $reason : "";
						$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 1,$reason);
					}
					/*END all approve shift*/



					/*START last overtime*/
					$count_shift++;
					//last overtime out
					if ((($count_time+1)==sizeof($_time))&&($count_shift==sizeof($_shift))) 
					{
						if ($time_out_seconds>$shift_out_seconds) 
						{
							$reason = "<b>answer: ". Payroll2::convert_to_12_hour($shift->shift_out)." to ". Payroll2::convert_to_12_hour($time->time_out)." (0)- <span style='color: green; text-transform: uppercase'>LAST OVERTIME<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_out, $time->time_out, 0,$reason);
						}
					}
					/*END last overtime*/

					
					/*START between overtime Sandwich*/
					//if there is next shift
					if (isset($_shift[$count_shift])) 
					{
						$next_shift_in_seconds = explode(":", $_shift[$count_shift]->shift_in);
						$next_shift_out_seconds = explode(":", $_shift[$count_shift]->shift_out);
						$next_shift_in_seconds = ($next_shift_in_seconds[0]*3600) + ($next_shift_in_seconds[1]*60) + $next_shift_in_seconds[2];
						$next_shift_out_seconds = ($next_shift_out_seconds[0]*3600) + ($next_shift_out_seconds[1]*60) + $next_shift_out_seconds[2];

						// if overtime
						if (($time_out_seconds>$shift_out_seconds)&&
							($time_out_seconds<$next_shift_in_seconds)) 
						{
							
							$reason = "<b>answer: ".$shift->shift_out." to ".$time->time_out." (0) - <span style='color: green; text-transform: uppercase'>BETWEEN SHIFT OUT AND NEXT SHIFT IN OVERTIME<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_out, $time->time_out, 0, $reason);
						}

						// sandwich overtime between shift out and next shift in
						if (($time_in_seconds>$shift_out_seconds)&&($time_out_seconds<$next_shift_in_seconds)) 
						{
							$reason = "<b>answer: ".Payroll2::convert_to_12_hour($time->time_in)." to ".Payroll2::convert_to_12_hour($time->time_out)." (0) - <span style='color: green; text-transform: uppercase'>SANDWICH BETWEEN SHIFT OUT AND NEXT SHIFT IN<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $time->time_in, $time->time_out, 0, $reason);
						}
						
						//sandwich overtime, time out is between next shift in and out
						if (($time_in_seconds<$shift_out_seconds)&&
							($time_out_seconds>=$next_shift_in_seconds)) 
						{ 
							$reason = "<b>answer: ".Payroll2::convert_to_12_hour($shift->shift_out)." to ".Payroll2::convert_to_12_hour($_shift[$count_shift]->shift_in)." (0)- <span style='color: green; text-transform: uppercase'>sandwich overtime, time in is between next shift in and out<span><br></b>";
							echo $testing == true ? $reason : "";
							$_output = Payroll2::time_shift_output($_output, $output_ctr++, $shift->shift_out, $_shift[$count_shift]->shift_in, 0, $reason);
						}
						// //early time in next shift
						// if (($time_in_seconds>$shift_out_seconds)&&($time_in_seconds<$next_shift_in_seconds)
						// 	&&(($time_out_seconds>=$next_shift_in_seconds)&&($time_out_seconds<=$next_shift_out_seconds))) 
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
	public static function time_shift_output($_output, $index, $time_in, $time_out, $auto_approved, $reason = "",$late,$undertime,$overtime)
	{
		$_output[$index] = new stdClass();
		$_output[$index]->time_in = $time_in;
		$_output[$index]->time_out = $time_out;
		$_output[$index]->auto_approved = $auto_approved;
		$_output[$index]->reason=$reason;

		return $_output;
	}

}