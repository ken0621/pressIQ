<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_shift_time extends Model
{
    protected $table = 'tbl_payroll_shift_time';
	protected $primaryKey = "shift_time_id";
    public $timestamps = false;
}
