<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_write_check extends Model
{
    protected $table = 'tbl_write_check';
	protected $primaryKey = "wc_id";
    public $timestamps = false;

    public function scopeVendor($query)
    {
        return $query->join('tbl_vendor', 'tbl_write_check.wc_vendor_id', '=', 'tbl_vendor.vendor_id');
    }
}
