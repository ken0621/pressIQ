<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_period extends Model
{
    protected $table = 'tbl_payroll_period';
	protected $primaryKey = "payroll_period_id";
    public $timestamps = false;

    /* COLUMN NAME REFERENCE */ 

	// [PRIMARY KEY] 	payroll_period_id
	// [INTEGER] 		shop_id
	// [DATE] 			payroll_period_start
	// [DATE] 			payroll_period_end
	// [VARCHAR] 		payroll_period_category
	// [TINY INTEGER] 	payroll_period_archived
}
