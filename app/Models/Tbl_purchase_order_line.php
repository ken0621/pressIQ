<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_purchase_order_line extends Model
{   
	protected $table = 'tbl_purchase_order_line';
	protected $primaryKey = "poline_id";
    public $timestamps = false;
    

    public static function scopeUm($query)
    {
        return $query->leftjoin("tbl_unit_measurement_multi", "multi_id", "=", "poline_um");
    }
    public static function scopeItem($query)
    {
        return $query->leftjoin("tbl_item", "poline_item_id", "=", "tbl_item.item_id");
    }
    public static function scopePO($query)
    {
        return $query->join("tbl_purchase_order", "poline_po_id", "=", "tbl_purchase_order.po_id");
    }
}
