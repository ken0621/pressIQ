<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_deduction_payment extends Model
{
    protected $table = 'tbl_payroll_deduction_payment';
	protected $primaryKey = "payroll_deduction_payment_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */
	// [PRIMARY KEY] 	payroll_deduction_payment_id
	// [INTEGER]		shop_id
	// [INTEGER] 		payroll_deduction_id
	// [INTEGER] 		payroll_employee_id
	// [INTEGER] 		payroll_record_id
	// [DOUBLE] 		payroll_payment_amount

	public function scopeselbyemployee($query, $payroll_deduction_id = 0, $payroll_employee_id = 0)
	{
		$query->where('payroll_deduction_id',$payroll_deduction_id)->where('payroll_employee_id', $payroll_employee_id);

		return $query;
	}
}
