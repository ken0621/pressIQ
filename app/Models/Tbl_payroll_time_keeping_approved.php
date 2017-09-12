<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_time_keeping_approved extends Model
{
    protected $table = 'tbl_payroll_time_keeping_approved';
	protected $primaryKey = "time_keeping_approve_id";
    public $timestamps = false;

    /* REFERECE COLUMN NAME */
	// [PRIMARY KEY] 	payroll_tax_status_id
	// [VARCHAR] 		payroll_tax_status_name
	public function scopeInsertRecord($query, $employee_id, $payroll_period_company_id, $cutoff_breakdown, $compute_cutoff)
	{
		$insert["employee_id"] = $employee_id;
		$insert["payroll_period_company_id"] = $payroll_period_company_id;
		$insert["net_basic_pay"] = $cutoff_breakdown->basic_pay_total;
		$insert["gross_pay"] =  $cutoff_breakdown->gross_pay_total;
		$insert["net_pay"] =  $cutoff_breakdown->net_pay_total;
		$insert["taxable_salary"] =  $cutoff_breakdown->taxable_salary_total;
		$insert["sss_salary"] = $cutoff_breakdown->sss_contribution["salary"];
		$insert["sss_ee"] = $cutoff_breakdown->sss_contribution["ee"];
		$insert["sss_er"] = $cutoff_breakdown->sss_contribution["er"];
		$insert["sss_ec"] = $cutoff_breakdown->sss_contribution["ec"];
		$insert["phihealth_salary"] = $cutoff_breakdown->philhealth_contribution["salary"];
		$insert["philhealth_ee"] = $cutoff_breakdown->philhealth_contribution["ee"];
		$insert["philhealth_er"] = $cutoff_breakdown->philhealth_contribution["er"];
		$insert["pagibig_salary"] = $cutoff_breakdown->pagibig_contribution["salary"];
		$insert["pagibig_ee"] = $cutoff_breakdown->pagibig_contribution["ee"];
		$insert["pagibig_er"] = $cutoff_breakdown->pagibig_contribution["er"];
		$insert["tax_ee"] = $cutoff_breakdown->tax_total;
		$insert["cutoff_input"] = serialize($compute_cutoff["cutoff_input"]);
		$insert["cutoff_compute"] =	serialize($compute_cutoff["cutoff_compute"]);
		$insert["cutoff_breakdown"] = serialize($compute_cutoff["cutoff_breakdown"]);
		
		$time_keeping_approve_id = Tbl_payroll_time_keeping_approved::insertGetId($insert);

		return $time_keeping_approve_id;
	}
	public function scopemonthrecord($query, $employee_id = 0, $payroll_period_category, $month_contribution, $year_contribution, $isfirst = false, $islast = false)
	{
	    $query->join('tbl_payroll_period_company','tbl_payroll_period_company.payroll_period_company_id','=','tbl_payroll_time_keeping_approved.payroll_period_company_id')
	          ->join('tbl_payroll_period','tbl_payroll_period.payroll_period_id','=','tbl_payroll_period_company.payroll_period_id')
	          ->where('tbl_payroll_time_keeping_approved.employee_id', $employee_id)
	          ->where('tbl_payroll_period.payroll_period_category',$payroll_period_category)
	          ->where('tbl_payroll_period.month_contribution', $month_contribution)
	          ->where('tbl_payroll_period.year_contribution', $year_contribution);
	          
	    if($isfirst)
		{
			$query->where('tbl_payroll_period.period_count','!=','first_period');
		}
		if($islast)
		{
			$query->where('tbl_payroll_period.period_count','!=','last_period');
		}
	   
	   return $query;
	}
	public function scopePeriodCompany($query, $payroll_company_id)
	{
		$query->join('tbl_payroll_period_company','tbl_payroll_period_company.payroll_period_company_id','=','tbl_payroll_time_keeping_approved.payroll_period_company_id');
		$query->join('tbl_payroll_period','tbl_payroll_period.payroll_period_id','=','tbl_payroll_period_company.payroll_period_id');
		$query->where('tbl_payroll_period_company.payroll_company_id', $payroll_company_id);
		return $query;
	}
	public function scopeBasic($query)
	{
		$query->join("tbl_payroll_employee_basic", "tbl_payroll_employee_basic.payroll_employee_id", "=", "tbl_payroll_time_keeping_approved.employee_id");
		return $query;
	}
}