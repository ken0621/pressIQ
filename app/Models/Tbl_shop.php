<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_shop extends Model
{
	protected $table = 'tbl_shop';
	protected $primaryKey = "shop_id";
    public $timestamps = false;

    public static function scopegetUser($query)
    {
    	return $query->leftjoin("tbl_user","tbl_user.user_shop","=","tbl_shop.shop_id");
    }
}