<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_pay_bill_line extends Model
{
	protected $table = 'tbl_pay_bill_line';
	protected $primaryKey = "pbline_id";
    public $timestamps = false;

}