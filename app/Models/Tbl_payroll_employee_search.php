<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_employee_search extends Model
{
    protected $table = 'tbl_payroll_employee_search';
	protected $primaryKey = "payroll_employee_search_id";
    public $timestamps = false;

    /* COLUMN NAME REFERENCE */
 	// [PRIMARY KEY] 	payroll_employee_search_id
	// [INTEGER] 		payroll_search_employee_id
	// [TEXT] 			body
}
