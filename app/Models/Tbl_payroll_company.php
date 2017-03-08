<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_company extends Model
{
    protected $table = 'tbl_payroll_company';
	protected $primaryKey = "payroll_company_id";
    public $timestamps = false;
}
