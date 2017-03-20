<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_employee_allowance extends Model
{
    protected $table = 'tbl_payroll_employee_allowance';
	protected $primaryKey = "payroll_employee_allowance_id";
    public $timestamps = false;

    /* COLUMN NAME REFERENCE */
	// [PRIMARY KEY] 	payroll_employee_allowance_id
	// [INTEGER] 		payroll_allowance_id
	// [INTEGER] 		payroll_employee_id
	// [TINY INTEGER] 	payroll_employee_allowance_archived

	public function scopegetperallowance($query, $payroll_allowance_id = 0, $payroll_employee_allowance_archived = 0)
	{
		$query->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_employee_allowance.payroll_employee_id')
			 ->where('tbl_payroll_employee_allowance.payroll_allowance_id',$payroll_allowance_id)
			 ->where('tbl_payroll_employee_allowance.payroll_employee_allowance_archived',$payroll_employee_allowance_archived);
		
		return $query;
	}

	public function scopeemployee($query, $payroll_employee_allowance_id = 0)
	{
		$query->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_employee_allowance.payroll_employee_id')
			 ->where('tbl_payroll_employee_allowance.payroll_employee_allowance_id',$payroll_employee_allowance_id);

		return $query;
	}
}
