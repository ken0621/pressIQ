<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_record extends Model
{
    protected $table = 'tbl_payroll_record';
	protected $primaryKey = "payroll_record_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */

	// payroll_record_id
	// shop_id
	// payroll_employee_id
	// payroll_period_company_id
	// salary_monthly
	// salary_daily
	// regular_salary
	// regular_early_overtime
	// regular_reg_overtime
	// regular_night_diff
	// extra_salary
	// extra_early_overtime
	// extra_reg_overtime
	// extra_night_diff
	// rest_day_salary
	// rest_day_early_overtime
	// rest_day_reg_overtime
	// rest_day_night_diff
	// rest_day_sh
	// rest_day_sh_early_overtime
	// rest_day_sh_reg_overtime
	// rest_day_sh_night_diff
	// rest_day_rh
	// rest_day_rh_early_overtime
	// rest_day_rh_reg_overtime
	// rest_day_rh_night_diff
	// rh_salary
	// rh_early_overtime
	// rh_reg_overtime
	// rh_night_diff
	// sh_salary
	// sh_early_overtime
	// sh_reg_overtime
	// sh_night_diff
	// 13_month
	// 13_month_computed
	// minimum_wage
	// tax_status
	// salary_taxable
	// salary_sss
	// salary_pagibig
	// salary_philhealth
	// tax_contribution
	// sss_contribution_ee
	// sss_contribution_er
	// sss_contribution_ec
	// philhealth_contribution_ee
	// philhealth_contribution_er
	// pagibig_contribution

	public function scopegetperiod($query, $shop_id = 0, $payroll_period_category = '', $status = 'approved')
	{
		$query->join('tbl_payroll_period_company','tbl_payroll_period_company.payroll_period_company_id','=','tbl_payroll_record.payroll_period_company_id')
			  ->join('tbl_payroll_period','tbl_payroll_period.payroll_period_id','=','tbl_payroll_period_company.payroll_period_id')
			  ->where('tbl_payroll_period.payroll_period_category', $payroll_period_category)
			  ->where('tbl_payroll_record.shop_id', $shop_id)
			  ->where('tbl_payroll_period_company.payroll_period_status', $status);

		return $query;
	}	

	public function scope
}
