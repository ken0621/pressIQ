<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_jobtitle extends Model
{
    protected $table = 'tbl_payroll_jobtitle';
	protected $primaryKey = "payroll_jobtitle_id";
    public $timestamps = false;

    public function scopesel($query, $shop_id = 0, $archived = 0)
    {
    	$query->leftjoin('tbl_payroll_department','tbl_payroll_department.payroll_department_id','=','tbl_payroll_jobtitle.payroll_jobtitle_department_id')
    		 ->where('tbl_payroll_jobtitle.shop_id', $shop_id)
    		 ->where('tbl_payroll_jobtitle.payroll_jobtitle_archived', $archived);
    		 
    	return $query;
    }
}
