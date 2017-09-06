<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_columns extends Model
{
    protected $table = 'tbl_columns';
	protected $primaryKey = "columns_id";
    public $timestamps = false;

    public function scopeUser($query, $user_id)
    {    	
        return $query->where("tbl_columns.user_id", $user_id);
    }

    public function scopeShop($query, $shop_id)
    {       
        return $query->where("tbl_columns.shop_id", $shop_id);
    }
}
