<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_request_payment extends Model
{
   	protected $table = 'tbl_payroll_request_payment';
	protected $primaryKey = "payroll_request_payment_id";
    public $timestamps = false;

}