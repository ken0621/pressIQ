<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use PDF2;
use App\Globals\Payroll2;
use DateTime;


class PayrollReportController extends Member
{
	public function shop_id()
	{
		return $this->user_info->shop_id;
	}
	public function government_forms()
	{ 
		$data["page"] = "Monthly Government Forms";
		$data["_month_period"] = Payroll2::get_number_of_period_per_month($this->shop_id(), 2017);
		return view("member.payrollreport.government_forms", $data);
	}
	public function government_forms_hdmf($month)
	{ 
		$data["page"] = "Monthly Government Forms";
		$year = 2017;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;

		return view("member.payrollreport.government_forms_hdmf", $data);
	}
	public function government_forms_sss($month)
	{ 
		$data["page"] = "Monthly Government Forms";
		$year = 2017;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;

		return view("member.payrollreport.government_forms_sss", $data);
	}
	public function government_forms_philhealth($month)
	{ 
		$data["page"] = "Monthly Government Forms";
		$year = 2017;
		$shop_id = $this->shop_id();
		$contri_info = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);
		$data["contri_info"] = $contri_info; 
		$data["month"] = $month;
		$data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
		$data["year"] = $year;

		return view("member.payrollreport.government_forms_philhealth", $data);
	}
	public function government_forms_hdmf_iframe($month)
	{ 
		$data["page"] = "Monthly Government Forms";

		$year = 2017;
		$shop_id = $this->shop_id();
		$data["_contribution"] = Payroll2::get_contribution_information_for_a_month($shop_id, $month, $year);

		$format["title"] = "A4";
		$format["format"] = "A4";
		$format["default_font"] = "sans-serif";
		// $format["margin_top"] = "0";
		// $format["margin_bottom"] = "0";
		// $format["margin_left"] = "0";
		// $format["margin_right"] = "0";

		$pdf = PDF2::loadView('member.payrollreport.government_forms_hdmf_iframe', $data, [], $format);
		return $pdf->stream('document.pdf');
	}
}