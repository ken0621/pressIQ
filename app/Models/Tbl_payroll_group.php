<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_group extends Model
{
    protected $table = 'tbl_payroll_group';
	protected $primaryKey = "payroll_group_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */

	// [PRIMARY KEY] 	payroll_group_id
	// [INTEGER] 		shop_id
	// [VARCHAR] 		payroll_group_code
	// [VARCHAR] 		payroll_group_salary_computation
	// [VARCHAR] 		payroll_group_period
	// [VARCHAR] 		payroll_group_13month_basis
	// [TINY INTEGER] 	payroll_group_deduct_before_absences
	// [VARCHAR] 		payroll_group_tax
	// [VARCHAR] 		payroll_group_sss
	// [VARCHAR] 		payroll_group_philhealth
	// [VARCHAR] 		payroll_group_pagibig
	// [VARCHAR] 		payroll_group_agency
	// [DOUBLE 18, 2] 	payroll_group_agency_fee
	// [TINY INTEGER] 	payroll_group_is_flexi_time
	// [DOUBLE 18, 2] 	payroll_group_working_day_month
	// [VARCHAR] 		payroll_group_target_hour_parameter
	// [DOUBLE 18, 2] 	payroll_group_target_hour
	// [TIME] 			payroll_group_start
	// [TIME] 			payroll_group_end
	// [TINY INTEGER] 	payroll_group_archived
	// [TIME] 			payroll_group_break_start
	// [TIME] 			payroll_group_break_end
	// [TINY INTEGER] 	payroll_group_is_flexi_break
	// [INTEGER] 		payroll_group_flexi_break
	// [VARCHAR] 		payroll_late_category
	// [INTEGER] 		payroll_late_interval
	// [VARCHAR] 		payroll_late_parameter
	// [DOUBLE 18, 2] 	payroll_late_deduction
	// [TINY INTEGER]	payroll_group_before_tax
	// [VARCHAR] 		payroll_under_time_category
	// [INTEGER] 		payroll_under_time_interval
	// [VARCHAR] 		payroll_under_time_parameter
	// [DOUBLE] 		payroll_under_time_deduction
	// [VARCHAR] 		payroll_break_category
	// [DOUBLE]			break_deduction
	// [VARCHAR]		break_time
	// [DOUBLE]			taxable_salary

	public function scopesel($query, $shop_id = 0, $payroll_group_archived = 0)
	{
		$query->where('shop_id',$shop_id)->where('payroll_group_archived',$payroll_group_archived);
		return $query;
	}		
}
