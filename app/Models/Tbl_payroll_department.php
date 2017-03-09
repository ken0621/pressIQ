<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_department extends Model
{
    protected $table = 'tbl_payroll_department';
	protected $primaryKey = "payroll_department_id";
    public $timestamps = false;

    public function scopesel($query, $shop_id = 0, $archived = 0)
    {
    	return $query->where('shop_id', $shop_id)->where('payroll_department_archived', $archived);
    }
}
