<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_pay_bill_line extends Model
{
	protected $table = 'tbl_pay_bill_line';
	protected $primaryKey = "pbline_id";
    public $timestamps = false;

    public static function scopePBInfo($query)
    {
    	return $query->leftjoin('tbl_pay_bill', 'tbl_pay_bill.paybill_id', '=', 'tbl_pay_bill_line.pbline_pb_id');
    }

}