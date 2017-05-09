<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_vendor_item extends Model
{
    protected $table = 'tbl_vendor_item';
	protected $primaryKey = "vendor_item_id";
    public $timestamps = false;

    public function scopeItem($query)
    {
    	return $query->join("tbl_item","tbl_item.item_id","=","tag_item_id");
    }
}
