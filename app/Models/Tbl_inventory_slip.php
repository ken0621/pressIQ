<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_inventory_slip extends Model
{
    protected $table = 'tbl_inventory_slip';
	protected $primaryKey = "inventory_slip_id";
    public $timestamps = false;

    public function scopeShop($query)
    {
    	return $query->leftjoin("tbl_shop","tbl_shop.shop_id","=","tbl_inventory_slip.inventory_slip_shop_id");
    }
    public function scopeVendor($query)
    {
    	return $query->leftjoin("tbl_vendor","tbl_vendor.vendor_id","=","tbl_inventory_slip.inventory_source_id");
    }
}
