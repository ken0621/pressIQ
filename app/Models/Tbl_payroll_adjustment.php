<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_adjustment extends Model
{
    protected $table = 'tbl_payroll_adjustment';
	protected $primaryKey = "payroll_adjustment_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */
	// [INTEGER] payroll_adjustment_id
	// [INTEGER] payroll_employee_id
	// [INTEGER] payroll_period_company_id
	// [VARCHAR] payroll_adjustment_name
	// [VARCHAR] payroll_adjustment_category
	// [DOUBLE]  payroll_adjustment_amount
}
