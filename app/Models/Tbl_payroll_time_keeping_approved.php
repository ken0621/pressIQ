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
	
}