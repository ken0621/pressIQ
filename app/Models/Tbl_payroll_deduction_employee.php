<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_deduction_employee extends Model
{
    protected $table = 'tbl_payroll_deduction_employee';
	protected $primaryKey = "payroll_deduction_employee_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */

	// [PRIMARY KEY] 	payroll_deduction_employee_id
	// [INTEGER] 		payroll_deduction_id
	// [INTEGER] 		payroll_employee_id
	// [TINY INTEGER] 	payroll_deduction_employee_archived


	public function scopeselbyemployee($query, $payroll_deduction_id = 0, $payroll_deduction_employee_archived = 0)
	{
		
		$query->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_deduction_employee.payroll_employee_id')
			 ->where('tbl_payroll_deduction_employee.payroll_deduction_id',$payroll_deduction_id)
			 ->where('payroll_deduction_employee_archived',$payroll_deduction_employee_archived);

		return $query;
	}

	public function scopegetemployee($query, $payroll_deduction_employee_id = 0)
	{
		$query->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_deduction_employee.payroll_employee_id')
			 ->where('payroll_deduction_employee_id', $payroll_deduction_employee_id);
		return $query;
	}
}
