<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_mlm_binary_setttings extends Model
{
	protected $table = 'tbl_mlm_binary_setttings';
	protected $primaryKey = "binary_setttings";
    public $timestamps = false;

    public function scopeShop($query, $shop_id)
    {
        $query->where("tbl_mlm_binary_setttings.shop_id", $shop_id);
    }
}
