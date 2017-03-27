<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_tax_period extends Model
{
    protected $table = 'tbl_payroll_tax_period';
	protected $primaryKey = "payroll_tax_period_id";
    public $timestamps = false;


    /* COLUMN NAME REFERENCE */
    // [PRIMARY KEY] 	payroll_tax_period_id
    // [VARCHAR] 		payroll_tax_period
    // [INTEGER] 		shop_id
}
