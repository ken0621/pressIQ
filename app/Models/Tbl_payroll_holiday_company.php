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

	public function scopegetholiday($query, $payroll_company_id = 0, $date = '0000-00-00')
	{
		$query->join('tbl_payroll_holiday','tbl_payroll_holiday.payroll_holiday_id','=','tbl_payroll_holiday_company.payroll_holiday_id')
			  ->where('tbl_payroll_holiday_company.payroll_company_id',$payroll_company_id)
			  ->where('tbl_payroll_holiday.payroll_holiday_date',$date)
			  ->where('tbl_payroll_holiday.payroll_holiday_archived',0);

		return $query;
	}
}
