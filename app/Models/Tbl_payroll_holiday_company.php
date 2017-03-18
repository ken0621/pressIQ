<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_holiday_company extends Model
{
    protected $table = 'tbl_payroll_holiday_company';
	protected $primaryKey = "payroll_holiday_company_id";
    public $timestamps = false;


    /* COLUMN NAME REFERENCE */
	// [PRIMARY KEY] 	payroll_holiday_company_id
	// [INTEGER] 		payroll_company_id
	// [INTEGER] 		payroll_holiday_id

	public function scopecompany($query, $payroll_company_id = 0, $payroll_holiday_id = 0)
	{
		$query->where('payroll_company_id', $payroll_company_id)->where('payroll_holiday_id', $payroll_holiday_id);
		return $query;
	}
}
