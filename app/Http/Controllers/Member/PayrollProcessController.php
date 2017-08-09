<?php

namespace App\Http\Controllers\Member;
use Request;
use stdClass;
use Redirect;
use Carbon\Carbon;

use App\Globals\AuditTrail;
use App\Http\Controllers\Controller;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_time_keeping_approved;

class PayrollProcessController extends Member
{

	public function index($period_company_id)
	{
		$data["period_company_id"] = $period_company_id;

		if(Request::isMethod("post"))
		{
			$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
			$data = $this->get_total($data);
			extract($data);


			$record = Tbl_payroll_period_company::where('payroll_period_company_id', $period_company_id)->first();

			$update["payroll_period_status"] = "processed";
			$update["payroll_period_total_basic"] = $total_basic;
			$update["payroll_period_total_gross"] = $total_gross;
			$update["payroll_period_total_net"] = $total_net;
			$update["payroll_period_total_sss_ee"] = $total_sss_ee;
			$update["payroll_period_total_sss_er"] = $total_sss_er;
			$update["payroll_period_total_sss_ec"] = $total_sss_ec;
			$update["payroll_period_total_philhealth_ee"] = $total_philhealth_ee;
			$update["payroll_period_total_philhealth_er"] = $total_philhealth_er;
			$update["payroll_period_total_pagibig_ee"] = $total_pagibig_ee;
			$update["payroll_period_total_pagibig_er"] = $total_pagibig_er;
			$update["payroll_period_total_grand"] = $total_grand;

			Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->update($update);

			$new_record = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->first();
			AuditTrail::record_logs("Process Payroll Period","Payroll Process Period id # " . $period_company_id, $period_company_id,$record,$new_record);
			return Redirect::to("/member/payroll/time_keeping");
		}
		else
		{
			$data["company"] = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
			return view("member.payroll2.payroll_process", $data);
		}
	}
	public function index_table($period_company_id)
	{
		$data["company"] = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
		$data = $this->get_total($data);
		return view("member.payroll2.payroll_process_table", $data);
	}


	public function modal_view_summary($period_company_id)
	{
		$data["company"] = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->company()->companyperiod()->first();
		$data["_employee"] = Tbl_payroll_time_keeping_approved::where("payroll_period_company_id", $period_company_id)->basic()->get();
		$data = $this->get_total($data);
		return view("member.payroll2.payroll_process_modal_view_summary", $data);
	}

	
	public function unprocess($period_company_id)
	{
		$old_record = Tbl_payroll_period_company::where('payroll_period_company_id', $period_company_id)->first();
        
		/* TODO: SECURE UNPROCESS */
		$update["payroll_period_status"] = "generated";
		Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->update($update);

		$new_record = Tbl_payroll_period_company::where("payroll_period_company_id", $period_company_id)->first();
		AuditTrail::record_logs("Unprocess Payroll Period","Unprocess Payroll Period id # ". $period_company_id,$period_company_id,$old_record,$new_record);

		return Redirect::to("/member/payroll/time_keeping");
	}
	public function get_total($data)
	{
		$total_basic = 0;
		$total_gross = 0;
		$total_net = 0;
		$total_tax = 0;

		$g_total_er = 0;
		$g_total_ee = 0;
		$g_total_ec = 0;

		$total_sss_ee = 0;
		$total_sss_er = 0;
		$total_sss_ec = 0;
		$total_philhealth_ee = 0;
		$total_philhealth_er = 0;
		$total_pagibig_ee = 0;
		$total_pagibig_er = 0;


		foreach($data["_employee"] as $key => $employee)
		{
			$total_basic += $employee->net_basic_pay;
			$total_gross += $employee->gross_pay;
			$total_net += $employee->net_pay;
			$total_tax += $employee->tax_ee;

			$total_er = $employee->sss_er + $employee->philhealth_er +  $employee->pagibig_er;
			$total_ee = $employee->sss_ee + $employee->philhealth_ee +  $employee->pagibig_ee;
			$total_ec = $employee->sss_ec;

			$total_sss_ee += $employee->sss_ee;
			$total_sss_er += $employee->sss_er;
			$total_sss_ec += $employee->sss_ec;
			$total_philhealth_ee += $employee->philhealth_er;
			$total_philhealth_er += $employee->philhealth_er;
			$total_pagibig_ee += $employee->pagibig_ee;
			$total_pagibig_er += $employee->pagibig_er;

			$data["_employee"][$key] = $employee;
			$data["_employee"][$key]->total_er = $total_er;
			$data["_employee"][$key]->total_ee = $total_ee;
			$data["_employee"][$key]->total_ec = $total_ec;

			$g_total_ec += $total_ec;
			$g_total_er += $total_er;
			$g_total_ee += $total_ee;
		}

		$data["total_basic"] = $total_basic;
		$data["total_gross"] = $total_gross;
		$data["total_net"] = $total_net;
		$data["total_er"] = $g_total_er;
		$data["total_ee"] = $g_total_ee;
		$data["total_ec"] = $g_total_ec;
		$data["total_tax"] = $total_tax;
		$data["total_grand"] = $total_net + $g_total_er + $g_total_ee + $g_total_ec + $total_tax;
		$data["total_sss_ee"] = $total_sss_ee;
		$data["total_sss_er"] = $total_sss_er;
		$data["total_sss_ec"] = $total_sss_ec;
		$data["total_philhealth_ee"] = $total_philhealth_ee;
		$data["total_philhealth_er"] = $total_philhealth_er;
		$data["total_pagibig_ee"] = $total_pagibig_ee;
		$data["total_pagibig_er"] = $total_pagibig_er;
		return $data;
	}

}