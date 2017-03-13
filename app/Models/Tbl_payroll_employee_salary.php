<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_employee_salary extends Model
{
    protected $table = 'tbl_payroll_employee_salary';
	protected $primaryKey = "payroll_employee_salary_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */
	// [PRIMARY KEY] payroll_employee_salary_id
	// [INTEGER] 	 payroll_employee_id
	// [DATE] 		 payroll_employee_salary_effective_date
	// [TINYINTEGER] payroll_employee_salary_minimum_wage
	// [DOUBLE 18,2] payroll_employee_salary_monthly
	// [DOUBLE 18,2] payroll_employee_salary_daily
	// [DOUBLE 18,2] payroll_employee_salary_taxable
	// [DOUBLE 18,2] payroll_employee_salary_sss
	// [DOUBLE 18,2] payroll_employee_salary_pagibig
	// [DOUBLE 18,2] payroll_employee_salary_philhealth 
}
