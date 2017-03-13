<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_tax_period extends Model
{
    protected $table = 'tbl_payroll_tax_period';
	protected $primaryKey = "payroll_tax_period_id";
    public $timestamps = false;
}
