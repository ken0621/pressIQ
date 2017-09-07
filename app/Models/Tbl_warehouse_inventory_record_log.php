<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Tbl_warehouse_inventory_record_log extends Model
{
    protected $table = 'tbl_warehouse_inventory_record_log';
	protected $primaryKey = "record_log_id";
    public $timestamps = false;
    
    public function scopeItem($query)
    {
    	return $query->leftjoin('tbl_item','item_id','=','record_item_id');
    }
    public function scopeWarehouse($query)
    {
    	return $query->leftjoin('tbl_warehouse','warehouse_id','=','record_warehouse_id');
    }
}