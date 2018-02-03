<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_inventory_adjustment extends Model
{
	protected $table = 'tbl_inventory_adjustment';
	protected $primaryKey = "inventory_Adjustment_id";
    public $timestamps = false;

    public function scopeWarehouse($query)
    {
        return $query->leftjoin("tbl_warehouse", "adj_warehouse_id", "=", "warehouse_id");
    }
}