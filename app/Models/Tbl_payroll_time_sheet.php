<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_time_sheet extends Model
{
    protected $table = 'tbl_payroll_time_sheet';
	protected $primaryKey = "payroll_time_sheet_id";
    public $timestamps = false;

    /* COLUMN NAME REFERENCES */

    // ['PRIMARY KEY']					payroll_time_sheet_id
	// [INTEGER] 						payroll_employee_id
	// [VARCHAR (DEFAULT : Regular) ] 	payroll_time_sheet_type
	// [DATE]							payroll_time_date

	/* REASONING */
	/* [payroll_company_id]  
		• REASON: THERE ARE SOME CASE WHERE EMPLOYEES NEED TO LOG IN DIFFERENT COMPANY/BRANCH AND THE CLIENT WANT TO SEE THE BREAK DOWN OF COMPUTATION PER COMPANY/BRANCH THEY VISITED
	*/


	/* [payroll_time_sheet_origin] 
		• REASON : DETEMINE IF THE TIME SHEET CAME FROM BIO METRICS OR IN ANY OTHER SOURCE
	*/

	public function scopecheckdata($query, $payroll_employee_id = 0, $payroll_time_date = '0000-00-00')
	{
		return $query->where('payroll_employee_id', $payroll_employee_id)->where('payroll_time_date',$payroll_time_date);
	}

}
