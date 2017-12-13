<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_purchase_order_line extends Model
{   
	protected $table = 'tbl_purchase_order_line';
	protected $primaryKey = "poline_id";
    public $timestamps = false;
    

    public function scopeUm($query)
    {
        return $query->leftjoin("tbl_unit_measurement_multi", "multi_id", "=", "poline_um");
    }
    public function scopeItem($query)
    {
        return $query->leftjoin("tbl_item", "poline_item_id", "=", "tbl_item.item_id");
    }
    public function scopeGetVendor($query)
    {
        $query  ->join("tbl_item","tbl_item.item_id","=","tbl_purchase_order_line.poline_item_id")
                ->join("tbl_purchase_order","tbl_purchase_order.po_id","=","tbl_purchase_order_line.poline_po_id")
                ->join("tbl_vendor","tbl_vendor.vendor_id","=","tbl_purchase_order.po_vendor_id");
        return $query;

    }
}
