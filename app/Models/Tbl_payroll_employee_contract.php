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
	// [TINY INTEGER] 	payroll_employee_contract_archived

	public function scopeselemployee($query, $payroll_employee_id = 0, $date = '0000-00-00')
	{
		if($date == '0000-00-00')
		{
			$date = date('Y-m-d');
		}
		$query->where('payroll_employee_id',$payroll_employee_id)
			  ->where('payroll_employee_contract_archived',0)
			  ->where('payroll_employee_contract_date_end','<=',$date);
		return $query;
	}

	public function scopecontractlist($query, $payroll_employee_id = 0, $payroll_employee_contract_archived = 0)
	{
		$query->leftjoin('tbl_payroll_department','tbl_payroll_department.payroll_department_id','=','tbl_payroll_employee_contract.payroll_department_id')
			  ->leftjoin('tbl_payroll_jobtitle','tbl_payroll_jobtitle.payroll_jobtitle_id','=','tbl_payroll_employee_contract.payroll_jobtitle_id')
			  ->leftjoin('tbl_payroll_employment_status','tbl_payroll_employment_status.payroll_employment_status_id','=','tbl_payroll_employee_contract.payroll_employee_contract_status')
			  ->where('payroll_employee_id',$payroll_employee_id)
			  ->where('payroll_employee_contract_archived', $payroll_employee_contract_archived);

		return $query;
	}
}
