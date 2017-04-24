<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_leave_schedule extends Model
{
    protected $table = 'tbl_payroll_leave_schedule';
	protected $primaryKey = "payroll_leave_schedule_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */
	// [integer] 	payroll_leave_schedule_id
	// [integer] 	payroll_leave_employee_id
	// [date] 		payroll_schedule_leave
}
