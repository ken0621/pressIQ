<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Tbl_warehouse_inventory extends Model
{
	protected $table = 'tbl_warehouse_inventory';
	protected $primaryKey = "inventory_id";
    public $timestamps = false;

    public function scopecheck_inventory_single($query, $warehouse_id = 0, $item_id = 0)
    {
    	$query->where('warehouse_id', $warehouse_id)->where('inventory_item_id',$item_id)->select(DB::raw('sum(inventory_count) as inventory_count'));
    	return $query;
    }
}