<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_group_rest_day extends Model
{
    protected $table = 'tbl_payroll_group_rest_day';
	protected $primaryKey = "payroll_group_rest_day_id";
    public $timestamps = false;

    /* COLUMN NAME REFERENCE */
	// [PRIMARY KEY] 	payroll_group_rest_day_id
	// [INTEGER] 		payroll_group_id
	// [VARCHAR] 		payroll_group_rest_day
	// [VARCHAR] 		payroll_group_rest_day_category
}
