<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_receive_payment extends Model
{
	protected $table = 'tbl_receive_payment';
	protected $primaryKey = "rp_id";
    public $timestamps = true;
    
    public static function scopeCustomer($query)
    {
    	return $query->join("tbl_customer","tbl_customer.customer_id","=","tbl_receive_payment.rp_customer_id");
    }
    public static function scopeRpline($query)
    {
    	return $query->leftjoin("tbl_receive_payment_line","rpline_rp_id","=","rp_id");    	
    }
}