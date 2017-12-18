<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_approver_group extends Model
{
    protected $table = 'tbl_payroll_approver_group';
	protected $primaryKey = "payroll_approver_group_id";
    public $timestamps = false;

    public function scopeEmployeeApproverInfo($query)
    {
    	$query->join('tbl_payroll_approver_group_employee','tbl_payroll_approver_group_employee.payroll_approver_group_id','=','tbl_payroll_approver_group.payroll_approver_group_id')
              ->join('tbl_payroll_approver_employee','tbl_payroll_approver_employee.payroll_approver_employee_id', '=', 'tbl_payroll_approver_group_employee.payroll_approver_employee_id')
              ->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_approver_employee.payroll_employee_id');
    	return $query;
    }
}
