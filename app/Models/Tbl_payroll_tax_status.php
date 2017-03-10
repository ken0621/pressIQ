<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_tax_status extends Model
{
    protected $table = 'tbl_payroll_tax_status';
	protected $primaryKey = "payroll_tax_status_id";
    public $timestamps = false;
}
