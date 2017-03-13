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
	// [INTEGER] 						payroll_company_id  
	// [DATE TIME] 						payroll_time_in
	// [DATE TIME] 						payroll_time_out
	// [TEXT] 							payroll_time_sheet_activities
	// [VARCHAR (DEFAULT : Regular) ] 	payroll_time_sheet_type
	// [VARCHAR] 						payroll_time_sheet_origin

	/* REASONING */
	/* [payroll_company_id]  
		• REASON: THERE ARE SOME CASE WHERE EMPLOYEES NEED TO LOG IN DIFFERENT COMPANY/BRANCH AND THE CLIENT WANT TO SEE THE BREAK DOWN OF COMPUTATION PER COMPANY/BRANCH THEY VISITED
	*/

	/* [payroll_time_in / payroll_time_out] [DATE TIME]
		• REASON: TO GET THE PROPER SUM OF TOTAL RENDER HOURS IF THE EMPLOYEE IS IN THE NIGHT SHIFT E.G. 
		 TIME IN 	= 06:00 PM (MARCH 1, 2017)
		 TIME OUT 	= 02:00 AM (MARCH 2, 2017)
	*/

	/* [payroll_time_sheet_origin] 
		• REASON : DETEMINE IF THE TIME SHEET CAME FROM BIO METRICS OR IN ANY OTHER SOURCE
	*/

}
