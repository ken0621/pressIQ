<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_warehouse_issuance_report extends Model
{
	protected $table = 'tbl_warehouse_issuance_report';
	protected $primaryKey = "wis_id";
    public $timestamps = true;


    public function scopeInventory_item($query)
    {
        $query->selectRaw("*, count(wis_item_id) as issued_qty")->leftjoin("tbl_warehouse_issuance_report_item","tbl_warehouse_issuance_report.wis_id", "=", "tbl_warehouse_issuance_report_item.wis_id");
        return $query;
    }
}