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

		// /* INPUT TIME */
		// $_time[0] = new stdClass();
		// $_time[0]->time_in = "6:30:00";
		// $_time[0]->time_out = "8:00:00"; 
		// $_time[1] = new stdClass();
		// $_time[1]->time_in = "9:30:00";
		// $_time[1]->time_out = "12:15:00"; 
		// $_time[2] = new stdClass();
		// $_time[2]->time_in = "12:45:00";
		// $_time[2]->time_out = "16:00:00"; 
		

		// /* INPUT SHIFT */
		// $_shift[0] = new stdClass();
		// $_shift[0]->shift_in = "7:00:00"; 
		// $_shift[0]->shift_out = "9:00:00"; 
		// $_shift[1] = new stdClass();
		// $_shift[1]->shift_in = "10:00:00"; 
		// $_shift[1]->shift_out = "12:00:00"; 
		// $_shift[2] = new stdClass();
		// $_shift[2]->shift_in = "13:00:00"; 
		// $_shift[2]->shift_out = "15:00:00"; 


		// /* INPUT TIME */
		// $_time[0] = new stdClass();
		// $_time[0]->time_in = "7:30:00";
		// $_time[0]->time_out = "21:30:00"; 
		

		// /* INPUT SHIFT */
		// $_shift[0] = new stdClass();
		// $_shift[0]->shift_in = "7:00:00"; 
		// $_shift[0]->shift_out = "10:00:00"; 
		// $_shift[1] = new stdClass();
		// $_shift[1]->shift_in = "13:00:00"; 
		// $_shift[1]->shift_out = "16:00:00"; 
		// $_shift[2] = new stdClass();
		// $_shift[2]->shift_in = "18:00:00"; 
		// $_shift[2]->shift_out = "21:00:00"; 


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
		// $_shift[1]->shift_out = "18:00:00"; //4:00 PM
			



		/* INPUT TIME */
		$_time[0] = new stdClass();
		$_time[0]->time_in = "6:30:00"; //6:00 AM
		$_time[0]->time_out = "10:30:00"; //10:30 AM
		$_time[1] = new stdClass();
		$_time[1]->time_in = "10:45:00"; //2:00 PM
		$_time[1]->time_out = "13:00:00"; //8:00 PM
		$_time[2] = new stdClass();
		$_time[2]->time_in = "14:00:00"; //2:00 PM
		$_time[2]->time_out = "20:00:00"; //8:00 PM

		//INPUT SHIFT 
		$_shift[0] = new stdClass();
		$_shift[0]->shift_in = "7:00:00"; //7:00 AM
		$_shift[0]->shift_out = "10:00:00"; //10:00 AM
		$_shift[1] = new stdClass();
		$_shift[1]->shift_in = "13:00:00"; //1:00 PM
		$_shift[1]->shift_out = "16:00:00"; //4:00 PM
		$_shift[2] = new stdClass();
		$_shift[2]->shift_in = "18:00:00"; //6:00 PM
		$_shift[2]->shift_out = "21:00:00"; //9:00 PM

		/*
			Output Should Be
			6:30 to 7:00  (0)
			7:00 to 10:00  (1)
			10:00 to 10:30 (0)
			14:00 PM to 16:00  (1)
			16:00 PM to 18:00  (0)
			18:00 PM to 21:00  (1)
		*/

		$_output = Payroll2::time_shift_create_format_based_on_conflict($_time, null, false);
	
		dd($_output);
	}
}
