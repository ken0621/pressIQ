<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_manpower_report extends Model
{
    //
    protected $table = 'tbl_payroll_manpower_report';
	protected $primaryKey = "payroll_manpower_report_id";
    public $timestamps = false;

   	public function scopeselmanpower($query, $shop_id = 0,$company = 0)
	{
		 $query->join('tbl_payroll_employee_basic','tbl_payroll_manpower_report.payroll_employee_id','=','tbl_payroll_employee_basic.payroll_employee_id') ->leftjoin('tbl_payroll_employee_contract as contract','contract.payroll_employee_id','=','tbl_payroll_employee_basic.payroll_employee_id')
		 ->leftjoin('tbl_payroll_department as department','department.payroll_department_id','=','contract.payroll_department_id')
		 ->leftjoin('tbl_payroll_jobtitle as jobtitle','jobtitle.payroll_jobtitle_id','=','contract.payroll_jobtitle_id')->where('tbl_payroll_manpower_report.shop_id',$shop_id);

		if($company != 0)
		{
			$query->where('tbl_payroll_employee_basic.payroll_employee_company_id',$company);
		}
	}
}
