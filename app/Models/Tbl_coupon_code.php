<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_coupon_code extends Model
{
	protected $table = 'tbl_coupon_code';
	protected $primaryKey = "coupon_code_id";
    public $timestamps = false;

    public function scopeOrder($query)
    {
    	return $query->leftJoin("tbl_ec_order","coupon_id","=","coupon_code_id");
    }

    public function scopeProduct($query)
    {
    	return $query->select("*","tbl_coupon_code.date_created as coupon_date_created")
    				->leftJoin("tbl_ec_variant","evariant_id","=","coupon_product_id");
    }
}