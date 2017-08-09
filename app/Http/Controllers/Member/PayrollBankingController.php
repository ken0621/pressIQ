<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use App\Models\Tbl_payroll_time_keeping_approved;
use App\Models\Tbl_payroll_period_company;

class PayrollBankingController extends Member
{
     public function shop_id()
     {
     	return $this->user_info->shop_id;
     }
     public function index($payroll_period_company_id)
     {
     	$data["payroll_period_company_id"] = $payroll_period_company_id;
     	$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $payroll_period_company_id)->basic()->get();
 		$data = Self::clean($data);
    	return view("member.payroll2.payroll_banking", $data);
     }
     public static function clean($data)
     {
    	foreach($data["_employee"] as $key => $employee)
    	{
    		/* REMOVE EMPLOYEE WITH NO INCOME */
    		if($employee->net_pay < 0)
    		{
    			unset($data["_employee"][$key]);
    		}

    		if($employee->payroll_employee_atm_number == "")
    		{
    			unset($data["_employee"][$key]);
    		}
    	}
     	return $data;
     }
     public function download($payroll_period_company_id)
     {
     	$data["payroll_period_company_id"] = $payroll_period_company_id;
     	$data["payroll_period"] = Tbl_payroll_period_company::getcompanydetails($payroll_period_company_id)->first();

     	switch ($data["payroll_period"]->payroll_bank_convertion_id)
     	{
     		case 1: //BDO
     			Self::download_bdo($data);
     		break;
     		case 2: //METROBANK
     			Self::download_metrobank($data);
     		break;
     		case 3: //EQUICOM
     			Self::download_equicom($data);
     		break;
     	}
     }
     public static function download_bdo($data)
     {
     	$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $data["payroll_period_company_id"])->orderBy("net_pay", "desc")->basic()->get();
     	$data = Self::clean($data);

     	$filename = 'S3N07281701.txt';

		$content = "";

		foreach($data["_employee"] as $employee)
		{
			$content .=  $employee->payroll_employee_atm_number . "\t" . number_format($employee->net_pay, 2) . "\r\n";
		}

		$f = fopen($filename, 'w');
		fwrite($f, $content);
		fclose($f);

	    header("Cache-Control: public");
	    header("Content-Description: File Transfer");
	    header("Content-Length: ". filesize("$filename").";");
	    header("Content-Disposition: attachment; filename=$filename");
	    header("Content-Type: application/octet-stream; "); 
	    header("Content-Transfer-Encoding: binary");

	    readfile($filename);
	   
     }
     public static function download_metrobank($data)
     {
     }
     public static function download_equicom($data)
     {
     }
}