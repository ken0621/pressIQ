<?php
namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class Tbl_warehouse extends Model
{
	protected $table = 'tbl_warehouse';
	protected $primaryKey = "warehouse_id";
    public $timestamps = false;

    public function scopeInventory($query)
    {
    	 return $query->leftjoin('tbl_warehouse_inventory', 'tbl_warehouse_inventory.warehouse_id', '=', 'tbl_warehouse.warehouse_id');
    }
    public function scopeWarehouseitem($query)
    {
    	 return $query->leftjoin('tbl_sub_warehouse', 'tbl_sub_warehouse.warehouse_id', '=', 'tbl_warehouse.warehouse_id')
                     ->leftjoin('tbl_item','tbl_item.item_id','=','tbl_sub_warehouse.item_id');

    }
    public function scopeselect_info($query, $shop_id = 0, $archived = 0)
    {
        $query->selectRaw('*, tbl_warehouse.warehouse_id as warehouse_id, sum(tbl_warehouse_inventory.inventory_count) as total_qty')
                    ->where("tbl_warehouse.archived",$archived)
                    ->where("tbl_warehouse.warehouse_shop_id", $shop_id);
        return $query;
    }

    public function scopeselect_inventory($query, $warehouse_id = 0, $item_id = 0, $archived = 0)
    {
        $query->join('tbl_warehouse_inventory','tbl_warehouse_inventory.inventory_item_id','=','tbl_item.item_id')
            ->where('tbl_sub_warehouse.warehouse_id', $warehouse_id)
            ->where('tbl_warehouse_inventory.warehouse_id','=',$warehouse_id);
        if($item_id != 0)
        {
            $query->where('tbl_item.item_id',$item_id);
        }
            $query->where('tbl_item.archived',$archived)             
                 ->groupBy('tbl_warehouse_inventory.inventory_item_id')
                 ->select(DB::raw('tbl_item.item_id as product_id, tbl_item.item_name as product_name, tbl_item.item_sku as product_sku, sum(tbl_warehouse_inventory.inventory_count) as product_warehouse_stocks, tbl_sub_warehouse.item_reorder_point as product_reorder_point, tbl_item.has_serial_number as has_serial_number'))
                 ->orderBy("product_warehouse_stocks","ASC");

        return $query;
    }
}