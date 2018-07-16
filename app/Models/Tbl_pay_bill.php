<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_pay_bill extends Model
{
	protected $table = 'tbl_pay_bill';
	protected $primaryKey = "paybill_id";
    public $timestamps = false;
    
    public static function scopeVendor($query)
    {
    	return $query->leftjoin("tbl_vendor","tbl_vendor.vendor_id","=","tbl_pay_bill.paybill_vendor_id");
    }
}