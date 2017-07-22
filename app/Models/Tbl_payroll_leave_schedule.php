<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_leave_schedule extends Model
{
    protected $table = 'tbl_payroll_leave_schedule';
	protected $primaryKey = "payroll_leave_schedule_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */
	// [integer] 	payroll_leave_schedule_id
	// [integer] 	payroll_leave_employee_id
	// [date] 		payroll_schedule_leave
	// [integer]	shop_id


	public function scopegetcurrentavailable($query, $payroll_leave_employee_id = 0, $date = array())
	{
		if(empty($date))
		{
			$date[0] = date('Y-01-01');
			$date[1] = date('Y-12-31');
		}
		
		$query->where('payroll_leave_employee_id', $payroll_leave_employee_id)
			  ->whereBetween('payroll_schedule_leave',$date);

		return $query;
	}


	public function scopegetlist($query, $shop_id = 0, $date = '0000-00-00' ,$param = '>=')
	{
		$query->join('tbl_payroll_leave_employee','tbl_payroll_leave_employee.payroll_leave_employee_id','=','tbl_payroll_leave_schedule.payroll_leave_employee_id')
			  ->join('tbl_payroll_leave_temp','tbl_payroll_leave_temp.payroll_leave_temp_id','=','tbl_payroll_leave_employee.payroll_leave_temp_id')
			  ->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_leave_employee.payroll_employee_id')
			  ->where('tbl_payroll_leave_schedule.shop_id', $shop_id)
			  ->where('tbl_payroll_leave_schedule.payroll_schedule_leave', $param, $date);
		return $query;
	}

	public function scopespecific($query, $payroll_leave_schedule_id = 0)
	{
		$query->join('tbl_payroll_leave_employee','tbl_payroll_leave_employee.payroll_leave_employee_id','=','tbl_payroll_leave_schedule.payroll_leave_employee_id')
			  ->join('tbl_payroll_leave_temp','tbl_payroll_leave_temp.payroll_leave_temp_id','=','tbl_payroll_leave_employee.payroll_leave_temp_id')
			  ->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_leave_employee.payroll_employee_id')
			  ->where('tbl_payroll_leave_schedule.payroll_leave_schedule_id', $payroll_leave_schedule_id);
		return $query;
	}


	public function scopecheckemployee($query, $payroll_employee_id = 0, $payroll_schedule_leave = '0000-00-00')
	{
		$query->join('tbl_payroll_leave_employee','tbl_payroll_leave_employee.payroll_leave_employee_id','=','tbl_payroll_leave_schedule.payroll_leave_employee_id')
			  ->join('tbl_payroll_leave_temp','tbl_payroll_leave_temp.payroll_leave_temp_id','=','tbl_payroll_leave_employee.payroll_leave_temp_id')
			  ->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_leave_employee.payroll_employee_id')
			  ->where('tbl_payroll_leave_employee.payroll_employee_id', $payroll_employee_id)
			  ->where('tbl_payroll_leave_schedule.payroll_schedule_leave', $payroll_schedule_leave);
		return $query;
	}

	public function scopegetremaining($query, $payroll_employee_id = 0, $date = '0000-00-00')
	{
		$query->join('tbl_payroll_leave_employee','tbl_payroll_leave_employee.payroll_leave_employee_id','=','tbl_payroll_leave_schedule.payroll_leave_employee_id')
			  ->join('tbl_payroll_leave_temp','tbl_payroll_leave_temp.payroll_leave_temp_id','=','tbl_payroll_leave_employee.payroll_leave_temp_id')
			  ->join('tbl_payroll_employee_basic','tbl_payroll_employee_basic.payroll_employee_id','=','tbl_payroll_leave_employee.payroll_employee_id')
			  ->where('tbl_payroll_leave_employee.payroll_employee_id', $payroll_employee_id)
			  ->where('tbl_payroll_leave_schedule.payroll_schedule_leave', '<' ,$date);
		return $query;
	}

	public function scopegetyearly($query, $payroll_leave_employee_id = 0, $date = array())
	{
		if(empty($date))
		{
			$date[0] = date('Y-01-01');
			$date[1] = date('Y-12-31');
		}

		$query->where('payroll_leave_employee_id', $payroll_leave_employee_id)->whereBetween('payroll_schedule_leave', $date);

		return $query;
	}

	/*
	public function scopegetScheduleInc($query)
	{
		return $query->join('tbl_payroll_leave_employee', 'tbl_payroll_leave_schedule.payroll_leave_employee_id', '=', 'tbl_payroll_leave_employee.payroll_leave_employee_id')
           ->join('tbl_payroll_leave_temp', 'tbl_payroll_leave_employee.payroll_leave_temp_id', '=', 'tbl_payroll_leave_temp.payroll_leave_temp_id');
	}*/

	public function scopegetScheduleIncludeLeaveTemp($query, $payroll_leave_employee_id = 0)
	{
		return $query->join('tbl_payroll_leave_employee', 'tbl_payroll_leave_schedule.payroll_leave_employee_id', '=', 'tbl_payroll_leave_employee.payroll_leave_employee_id')
                ->join('tbl_payroll_leave_temp', 'tbl_payroll_leave_employee.payroll_leave_temp_id', '=', 'tbl_payroll_leave_temp.payroll_leave_temp_id')
                ->where('tbl_payroll_leave_schedule.payroll_leave_employee_id', '=', $payroll_leave_employee_id);
	}
}
