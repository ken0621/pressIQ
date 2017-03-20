<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_leave_temp extends Model
{
    /*public $fillable = ['payroll_leave_temp_id',,'shop_id','payroll_leave_temp_name', 'payroll_leave_temp_days_cap','payroll_leave_temp_with_pay','payroll_leave_temp_is_cummulative','payroll_leave_temp_is_archived'];*/

    protected $table = 'tbl_payroll_leave_temp';
	protected $primaryKey = "tbl_payroll_leave_temp_id";
    public $timestamps = false;


/*    	tbl_payroll_leave_temp
		$table->increments('tbl_payroll_leave_temp');
        $table->integer('shop_id');
        $table->string('payroll_leave_temp_name',100);
        $table->integer('payroll_leave_temp_days_cap');
        $table->tinyInteger('payroll_leave_temp_with_pay');
        $table->tinyInteger('payroll_leave_temp_is_cummulative');*/   
    public function scopesel($query, $shop_id = 0, $archived = 0)
	{
		return $query->where('shop_id', $shop_id)->where('payroll_leave_temp_archived', $archived);
	}
}