<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_warehouse_receiving_report extends Model
{
	protected $table = 'tbl_warehouse_receiving_report';
	protected $primaryKey = "rr_id";
    public $timestamps = true;

    public function scopeWis($query)
    {
    	return $query->leftjoin('tbl_warehouse_issuance_report','tbl_warehouse_issuance_report.wis_id','=','tbl_warehouse_receiving_report.wis_id');
    }
    public function scopeInventory_item($query)
    {
        $query->selectRaw("*, count(rr_item_id) as received_qty")->leftjoin("tbl_warehouse_receiving_report_item","tbl_warehouse_receiving_report.rr_id", "=", "tbl_warehouse_receiving_report_item.rr_id");
        return $query;
    }
    public function scopeWarehouse_item($query)
    {
        return $query->leftjoin('tbl_warehouse_inventory_record_log','tbl_warehouse_receiving_report_item.record_log_item_id','=','record_item_id');        
    }
}