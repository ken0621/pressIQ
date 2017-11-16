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
    public function scopeMembership($query)
    {
        return $query->leftjoin('tbl_membership','tbl_item.membership_id','=','tbl_membership.membership_id');
    }
    public function scopeSlotinfo($query)
    {
        return $query->leftjoin('tbl_mlm_slot','tbl_mlm_slot.slot_id','=','tbl_warehouse_inventory_record_log.mlm_slot_id_created');
    }
    public function scopeCustomerinfo($query)
    {
        return $query->leftjoin('tbl_customer','tbl_mlm_slot.slot_owner','=','tbl_customer.customer_id');
    }
    public function scopeInventory($query)
    {
        return $query->selectRaw("*, IFNULL(count(record_log_id),0) as wis_item_quantity");
    }
    public function scopeWarehouse($query)
    {
    	return $query->leftjoin('tbl_warehouse','warehouse_id','=','record_warehouse_id');
    }
    public function scopeCodes($query, $shop_id, $pin, $activation)
    {
        $query->where("tbl_warehouse_inventory_record_log.record_shop_id", $shop_id);
        $query->whereRaw("REPLACE(tbl_warehouse_inventory_record_log.mlm_pin, '\n','') = '" . $pin . "'");
        $query->where("tbl_warehouse_inventory_record_log.mlm_activation", $activation);
        return $query;
    }
}