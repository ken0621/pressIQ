<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_time_sheet_record extends Model
{
    protected $table = 'tbl_payroll_time_sheet_record';
	protected $primaryKey = "payroll_time_sheet_record_id";
    public $timestamps = false;

	public function scopewherearray($query, $array = array())
	{
		foreach($array as $key => $value)
		{
			$query->where($key, $value);
		}
		return $query;
	}
}
