<?php
namespace App\Http\Controllers\Core;
use App\Http\Controllers\Controller;
use App\Globals\Payroll2;

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
}