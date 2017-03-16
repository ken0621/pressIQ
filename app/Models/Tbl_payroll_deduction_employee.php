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
}
