<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_time_keeping_approved extends Model
{
    protected $table = 'tbl_payroll_time_keeping_approved';
	protected $primaryKey = "time_keeping_approve_id";
    public $timestamps = false;

    /* REFERECE COLUMN NAME */
	// [PRIMARY KEY] 	payroll_tax_status_id
	// [VARCHAR] 		payroll_tax_status_name
}