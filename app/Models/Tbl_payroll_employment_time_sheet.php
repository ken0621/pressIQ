<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_time_sheet extends Model
{
    protected $table = 'Tbl_payroll_time_sheet';
	protected $primaryKey = "payroll_time_sheet_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */
	// [PRIMARY KEY] 	payroll_employment_status_id
	// [VARCHAR] 		employment_status
}
