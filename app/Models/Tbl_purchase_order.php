<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_purchase_order extends Model
{   
	protected $table = 'tbl_purchase_order';
	protected $primaryKey = "po_id";
    public $timestamps = false;

    public static function scopeVendor($query)
    {
    	return $query->join("tbl_vendor","tbl_vendor.vendor_id","=","tbl_purchase_order.po_vendor_id");
    }
    public static function scopeTerms($query)
    {
    	return $query->join("tbl_terms","tbl_terms.terms_id","=","tbl_purchase_order.po_terms_id");
    }
}
