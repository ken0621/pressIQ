<?php
namespace App\Http\Controllers\Core;
use App\Http\Controllers\Controller;
use App\Globals\Payroll2;
use stdClass;

class Times2 extends Controller
{
	public function time_exist()
	{

		$if_check_exist = Payroll2::time_check_if_exist_between("11:00:00","11:00:00","13:00:00");

		if ($if_check_exist) {
			echo "Time is in Between!";
		}
		else
		{
			echo "Time is not in Between!";
		}
		
	}

	public function time_shift()
	{
		/*
			Output Should Be
			6:30 to 7:00  (0)
			7:00 to 10:00  (1)
			10:00 to 10:30 (0)
			14:00 PM to 16:00  (1)
			16:00 PM to 18:00  (0)
			18:00 PM to 21:00  (1)
		*/





		/* INPUT TIME */
		$_time[0] = new stdClass();
		$_time[0]->time_in = "7:30:00";
		$_time[0]->time_out = "21:30:00"; 
		

		/* INPUT SHIFT */
		$_shift[0] = new stdClass();
		$_shift[0]->shift_in = "7:00:00"; 
		$_shift[0]->shift_out = "10:00:00"; 
		$_shift[1] = new stdClass();
		$_shift[1]->shift_in = "13:00:00"; 
		$_shift[1]->shift_out = "16:00:00"; 
		$_shift[2] = new stdClass();
		$_shift[2]->shift_in = "18:00:00"; 
		$_shift[2]->shift_out = "21:00:00"; 


		// /* INPUT TIME */
		// $_time[0] = new stdClass();
		// $_time[0]->time_in = "9:00:00"; //6:00 AM
		// $_time[0]->time_out = "18:15:00"; //10:30 AM
		

		// /* INPUT SHIFT */
		// $_shift[0] = new stdClass();
		// $_shift[0]->shift_in = "9:00:00"; //7:00 AM
		// $_shift[0]->shift_out = "12:00:00"; //10:00 AM
		// $_shift[1] = new stdClass();
		// $_shift[1]->shift_in = "13:00:00"; //1:00 PM
		// $_shift[1]->shift_out = "18:30:00"; //4:00 PM



		// /* INPUT TIME */
		// $_time[0] = new stdClass();
		// $_time[0]->time_in = "6:30:00"; //6:00 AM
		// $_time[0]->time_out = "10:30:00"; //10:30 AM
		// $_time[1] = new stdClass();
		// $_time[1]->time_in = "14:00:00"; //2:00 PM
		// $_time[1]->time_out = "20:00:00"; //8:00 PM

		// /* INPUT SHIFT */
		// $_shift[0] = new stdClass();
		// $_shift[0]->shift_in = "7:00:00"; //7:00 AM
		// $_shift[0]->shift_out = "10:00:00"; //10:00 AM
		// $_shift[1] = new stdClass();
		// $_shift[1]->shift_in = "13:00:00"; //1:00 PM
		// $_shift[1]->shift_out = "16:00:00"; //4:00 PM
		// $_shift[2] = new stdClass();
		// $_shift[2]->shift_in = "18:00:00"; //6:00 PM
		// $_shift[2]->shift_out = "21:00:00"; //9:00 PM



		$output_array=array();
		$count =0;
		foreach ($_time as $time)
		{
			$count_time_over_time_in=0;
			$time_in_seconds = explode(":", $time->time_in);
			$time_out_seconds = explode(":", $time->time_out);
			$time_in_seconds = ($time_in_seconds[0]*3600) + ($time_in_seconds[1]*60) + $time_in_seconds[2];
			$time_out_seconds = ($time_out_seconds[0]*3600) + ($time_out_seconds[1]*60) + $time_out_seconds[2];;
			foreach($_shift as $shift)
			{
				$shift_in_seconds = explode(":", $shift->shift_in);
				$shift_out_seconds = explode(":", $shift->shift_out);
				$shift_in_seconds = ($shift_in_seconds[0]*3600) + ($shift_in_seconds[1]*60) + $shift_in_seconds[2];
				$shift_out_seconds = ($shift_out_seconds[0]*3600) + ($shift_out_seconds[1]*60) + $shift_out_seconds[2];

				$count_time_over_time_in++;
				/* input all approved shift */
				// if time in is less than or equal shift in and time out is greater than shift out
				// if time in is between shift in and shift out
				if ((($time_in_seconds<=$shift_in_seconds) && ($time_out_seconds>=$shift_out_seconds)) 
					|| (Payroll2::time_check_if_exist_between($time->time_in,$shift->shift_in,$shift->shift_out)))
				{

					//check if employee get the full time sched
					$str_output="".$shift->shift_in;
					if($shift_in_seconds>=$time_in_seconds)
					{
						$str_output=$shift->shift_in;
						
					}
					else
					{
						$str_output=$time->time_in;
					}

					if ($shift_out_seconds<=$time_out_seconds) 
					{
						$str_output= $str_output." to ".$shift->shift_out." (1)";
					}
					else
					{
						$str_output= $str_output." to ".$time->time_in." (1)";
					}
					$check_if_output_exist=false;
					//add first value in array
					if ($count==0) 
					{
						array_push($output_array, $str_output);
						$count++;
					}
					else
					{
						//check if output is duplicate before adding to an array
						foreach ($output_array as $output) 
						{

							//mali yung condition na to
							if($output == $str_output)
							{
								$check_if_output_exist=true;
								break;
							}
							if(!($check_if_output_exist))
							{

								array_push($output_array, $str_output);
						 		break;
							}
						}

					}
				}
				if (isset($_shift[$count_time_over_time_in])) 
				{
					// if time out is between time shift in and shift out add to the output
					if((Payroll2::time_check_if_exist_between($time->time_out,
					$_shift[$count_time_over_time_in]->shift_in,
					$_shift[$count_time_over_time_in]->shift_out)))
					{
						array_push($output_array, $shift->shift_in." to ".$time->time_out." (1)");
					}
				}
			}
		}
		dd($output_array);





		// /*early overtime*/
		// $count_time=0;
		// foreach ($_time as $time)
		// {
		// 	$count_shift=0;
		// 	$time_in_seconds = explode(":", $_time[$count_time]->time_in);
		// 	$time_out_seconds = explode(":", $_time[$count_time]->time_out);
		// 	$time_in_seconds = ($time_in_seconds[0]*3600) + ($time_in_seconds[1]*60) + $time_in_seconds[2];
		// 	$time_out_seconds = ($time_out_seconds[0]*3600) + ($time_out_seconds[1]*60) + $time_out_seconds[2];
		// 	foreach($_shift as $shift)
		// 	{
		// 		$shift_in_seconds = explode(":", $_shift[$count_shift]->shift_in);
		// 		$shift_out_seconds = explode(":", $_shift[$count_shift]->shift_out);
		// 		$shift_in_seconds = ($shift_in_seconds[0]*3600) + ($shift_in_seconds[1]*60) + $shift_in_seconds[2];
		// 		$shift_out_seconds = ($shift_out_seconds[0]*3600) + ($shift_out_seconds[1]*60) + $shift_out_seconds[2];
				
		// 		/*check if time in is between shift in and shift out so it wont continue to next shift schedule*/
		// 		if (($time_in_seconds>=$shift_in_seconds) 
		// 			&& ($time_in_seconds<=$shift_out_seconds)) 
		// 		{
		// 				break;
		// 		}
		// 		/*if time in is early to shift in*/
		// 		if (($time_in_seconds<$shift_in_seconds))
		// 		{
		// 			echo $time->time_in." to ".$shift->shift_in." (0)"."<br>";
		// 			if (isset($_shift[$count_shift+1]) ) 
		// 			{
		// 				break;
		// 			}
		// 		}
				
		// 		$count_shift++;
		// 	}
		// 	$count_time++;
		// }



		// /*overtime between*/
		// $count_time=0;
		// foreach ($_time as $time)
		// {
		// 	$count_shift=0;
		// 	$time_in_seconds = explode(":", $_time[$count_time]->time_in);
		// 	$time_out_seconds = explode(":", $_time[$count_time]->time_out);
		// 	$time_in_seconds = ($time_in_seconds[0]*3600) + ($time_in_seconds[1]*60) + $time_in_seconds[2];
		// 	$time_out_seconds = ($time_out_seconds[0]*3600) + ($time_out_seconds[1]*60) + $time_out_seconds[2];
		// 	foreach($_shift as $shift)
		// 	{
		// 		$shift_in_seconds = explode(":", $_shift[$count_shift]->shift_in);
		// 		$shift_out_seconds = explode(":", $_shift[$count_shift]->shift_out);
		// 		$shift_in_seconds = ($shift_in_seconds[0]*3600) + ($shift_in_seconds[1]*60) + $shift_in_seconds[2];
		// 		$shift_out_seconds = ($shift_out_seconds[0]*3600) + ($shift_out_seconds[1]*60) + $shift_out_seconds[2];
		// 		if (isset($_shift[$count_shift+1]) ) 
		// 		{
		// 			$shift_in_advance_seconds = explode(":", $_shift[$count_shift+1]->shift_out);
		// 			$shift_in_advance_seconds = ($shift_in_advance_seconds[0]*3600) + ($shift_in_advance_seconds[1]*60) + $shift_in_advance_seconds[2];
		// 			if (($time_in_seconds<$shift_out_seconds)&&($time_out_seconds>$shift_in_advance_seconds)) 
		// 			{
						
		// 				echo $shift->shift_out." to ".$_shift[$count_shift+1]->shift_in." (0)"."<br>";
		// 			}
		// 		}
		// 		$count_shift++;
		// 	}
		// 	$count_time++;
		// }
	}

}