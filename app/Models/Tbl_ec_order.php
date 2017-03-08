<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_ec_order extends Model
{
	protected $table = 'tbl_ec_order';
	protected $primaryKey = "ec_order_id";
    public $timestamps = false;

    public static function scopeCustomer($query)
    {
    	return $query->join("tbl_customer","tbl_customer.customer_id","=","tbl_ec_order.customer_id");
    }
}