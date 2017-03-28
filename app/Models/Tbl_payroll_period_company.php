<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_period_company extends Model
{
    protected $table = 'tbl_payroll_period_company';
	protected $primaryKey = "payroll_period_company_id";
    public $timestamps = false;

    /* COLUMN NAME REFERENCE */
	// [PRIMARY KEY] 	payroll_period_company_id
	// [INTEGER] 		payroll_period_id
	// [INTEGER] 		payroll_company_id
	// [VARCHAR] 		payroll_period_status

	/* STATUS */
	/*
	• pending
	• processed
	• registered
	• posted
	• approved
	*/
	public function scopeselperiod($query, $payroll_period_id = 0)
	{
		$query->join('tbl_payroll_company','tbl_payroll_company.payroll_company_id','=','tbl_payroll_period_company.payroll_company_id')
			
			  ->where('payroll_period_id', $payroll_period_id);
		return $query;
	}

	public function scopesel($query, $payroll_period_company_id = 0)
	{
		$query->join('tbl_payroll_company','tbl_payroll_company.payroll_company_id','=','tbl_payroll_period_company.payroll_company_id')
			  ->join('tbl_payroll_period','tbl_payroll_period.payroll_period_id','=','tbl_payroll_period_company.payroll_period_id')
			  ->where('payroll_period_company_id', $payroll_period_company_id);
		return $query;
	}

	public function scopecheck($query, $payroll_period_company_id = 0, $shop_id = 0)
	{
		$query->join('tbl_payroll_period','tbl_payroll_period.payroll_period_id','=','tbl_payroll_period_company.payroll_period_id')
			 ->where('tbl_payroll_period_company.payroll_period_company_id', $payroll_period_company_id)
			 ->where('tbl_payroll_period.shop_id', $shop_id);

		return $query;
	}
}
