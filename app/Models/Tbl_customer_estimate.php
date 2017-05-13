<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_customer_estimate extends Model
{
	protected $table = 'tbl_customer_estimate';
	protected $primaryKey = "est_id";
    public $timestamps = false;

	public static function scopeCustomer($query)
    {
    	return $query->leftjoin("tbl_customer","tbl_customer.customer_id","=","tbl_customer_estimate.est_customer_id");
    }
    public static function scopeEstimate_item($query)
    {
    	return $query->leftjoin("tbl_customer_estimate_line","tbl_customer_estimate_line.estline_est_id","=","tbl_customer_estimate.est_id")
    				->leftjoin("tbl_item","tbl_item.item_id","=","estline_item_id");
    }

    public static function scopeByCustomer($query, $shop_id, $customer_id)
    {
        return $query->where("est_shop_id", $shop_id)->where("est_customer_id", $customer_id);
    }
}