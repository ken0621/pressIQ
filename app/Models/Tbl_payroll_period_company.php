<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_period_company extends Model
{
    protected $table = 'tbl_payroll_period_company';
	protected $primaryKey = "payroll_period_company_id";
    public $timestamps = false;

    /* COLUMN NAME REFERENCE */
	// [PRIMARY KEY] 	payroll_period_company_id
	// [INTEGER] 		payroll_period_id
	// [INTEGER] 		payroll_company_id
	// [VARCHAR] 		payroll_period_status

	/* STATUS */
	/*
	• pending
	• processed
	• registered
	• posted
	• approved
	*/
}
