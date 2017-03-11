<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_employee_contract extends Model
{
    protected $table = 'tbl_payroll_employee_contract';
	protected $primaryKey = "payroll_employee_contract_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */
	// [PRIMARY KEY] 	payroll_employee_contract_id
	// [INTEGER] 		payroll_employee_id
	// [INTEGER] 		payroll_department_id
	// [INTEGER] 		payroll_jobtitle_id
	// [DATE] 			payroll_employee_contract_date_hired
	// [DATE] 			payroll_employee_contract_date_end
	// [INTEGER] 		payroll_employee_contract_status
	// [INTEGER] 		payroll_group_id
}
