<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_ec_order extends Model
{
	protected $table = 'tbl_ec_order';
	protected $primaryKey = "ec_order_id";
    public $timestamps = false;

    public static function scopeCustomer($query)
    {
    	return $query->join(DB::raw("(select customer_id, title_name, first_name, middle_name, last_name from tbl_customer) customer"),"customer.customer_id","=","tbl_ec_order.customer_id");
    }
}