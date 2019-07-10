<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_cart extends Model
{
	protected $table = 'tbl_cart';
	protected $primaryKey = "cart_id";
    public $timestamps = false;


    public function scopeCategory($query)
    {
    	$query ->join('tbl_item','tbl_item.item_id','=','tbl_cart.product_id');
    	$query ->join('tbl_category','tbl_category.type_id','=','tbl_item.item_category_id');
    	

    	return $query;
    }
}