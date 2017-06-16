<?php
namespace App\Http\Controllers\Core;
use App\Http\Controllers\Controller;
use App\Globals\Payroll2;

class Times2 extends Controller
{
	public function time_exist(){

		$if_check_exist = Payroll2::time_check_if_exist_between("11:00:00","11:00:00","13:00:00");

		if ($if_check_exist) {
			echo "Time is in Between!";
		}
		else
		{
			echo "Time is not in Between!";
		}
		
	}
}