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
        return $query->leftjoin('tbl_vendor', 'tbl_write_check.wc_reference_id', '=', 'tbl_vendor.vendor_id');
    }
    public function scopeCustomer($query)
    {
        return $query->leftjoin('tbl_customer', 'tbl_write_check.wc_reference_id', '=', 'tbl_customer.customer_id');
    }
    public function scopegetVendor($query)
    {
        return $query->join('tbl_vendor', 'tbl_write_check.wc_reference_id', '=', 'tbl_vendor.vendor_id');
    }
    public function scopegetCustomer($query)
    {
        return $query->join('tbl_customer', 'tbl_write_check.wc_reference_id', '=', 'tbl_customer.customer_id');
    }
}
