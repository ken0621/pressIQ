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
	// [VARCHAR]		payroll_period_status [DEFAULT {pending}]

	public function scopesel($query, $shop_id = 0, $payroll_period_archived = 0)
	{
		return $query->where('shop_id', $shop_id)->where('payroll_period_archived', $payroll_period_archived);
	}

	public function scopecheck($query, $_param = array())
	{
		foreach($_param as $key => $param)
		{
			$query->where($key, $param);
		}
		return $query;
	}

}
