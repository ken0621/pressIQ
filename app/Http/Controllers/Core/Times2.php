<?php
namespace App\Http\Controllers\Core;
use App\Http\Controllers\Controller;
use App\Globals\Payroll2;
use stdClass;

class Times2 extends Controller
{
	public function TimeExist(){

		$ifTimeExist = Payroll2::time_check_if_exist_between("01:00:12","11:00:00","13:00:00");

		if ($ifTimeExist) {
			echo "Time is in Between!";
		}
		else
		{
			echo "Time is not in Between!";
		}
		
	}
	public function time_shift()
	{
		/* INPUT SHIFT */
		$_shift[0] = new stdClass();
		$_shift[0]->shift_in = "7:00:00"; //7:00 AM
		$_shift[0]->shift_out = "10:00:00"; //10:00 AM
		$_shift[1] = new stdClass();
		$_shift[1]->shift_in = "13:00:00"; //1:00 PM
		$_shift[1]->shift_out = "16:00:00"; //4:00 PM
		$_shift[2] = new stdClass();
		$_shift[2]->shift_in = "18:00:00"; //6:00 PM
		$_shift[2]->shift_out = "21:00:00"; //9:00 PM

		/* INPUT TIME */
		$_time[0] = new stdClass();
		$_time[0]->time_in = "6:30:00"; //6:00 AM
		$_time[0]->time_out = "10:30:00"; //10:30 AM
		$_time[1] = new stdClass();
		$_time[1]->time_in = "14:00:00"; //2:00 PM
		$_time[1]->time_out = "20:00:00"; //8:00 PM


		dd($_shift);
		/*
			Output Should Be
			6:30 to 7:00 AM (0)
			7:00 to 10:00 AM (1)
			10:00 to 10:30 AM (0)
			2:00 PM to 4:00 PM (1)
			4:00 PM to 6:00 PM (0)
			6:00 PM to 8:00 PM (1)
		*/

	}

}