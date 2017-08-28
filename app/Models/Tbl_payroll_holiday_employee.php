<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_holiday_employee extends Model
{
	protected $table = 'tbl_payroll_holiday_employee';
	protected $primaryKey = "holiday_employee_id";
    public $timestamps = false;
}