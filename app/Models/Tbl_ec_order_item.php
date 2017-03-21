<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_ec_order_item extends Model
{
	protected $table = 'tbl_ec_order_item';
	protected $primaryKey = "ec_order_item_id";
    public $timestamps = false;

	public static function scopeEcorder($query)
    {
    	return $query->join("tbl_ec_order","tbl_ec_order.ec_order_id","=","tbl_ec_order_item.ec_order_id");
    }
}