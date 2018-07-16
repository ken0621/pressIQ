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
    public function scopeDistributed($query)
    {
        return $query->join('tbl_distribute_product_code', 'tbl_warehouse_inventory_record_log.record_log_id', '=', 'tbl_distribute_product_code.record_log_id');
    }
    public function scopeCustomer($query)
    {
        return $query->leftjoin('tbl_customer','tbl_distribute_product_code.customer_id','=','tbl_customer.customer_id');
    }
    public function scopeReleased($query)
    {
        return $query->leftjoin('tbl_release_product_code', 'tbl_warehouse_inventory_record_log.record_log_id', '=', 'tbl_release_product_code.record_log_id');
    }
    public function scopeReleasedCustomer($query)
    {
        return $query->leftjoin('tbl_customer', 'tbl_release_product_code.customer_id', '=', 'tbl_customer.customer_id');
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
    public function scopeCustomerinfo_data($query)
    {
        return $query->leftjoin('tbl_transaction_list','record_consume_ref_id','=','transaction_list_id')
                     ->leftjoin('tbl_transaction','tbl_transaction_list.transaction_id','=','tbl_transaction.transaction_id')
                     ->leftjoin('tbl_customer','tbl_customer.customer_id','=','tbl_transaction.transaction_reference_id');
    }
    public function scopeReserved_customer($query)
    {
        return $query->leftjoin('tbl_customer','record_consume_ref_id','=','customer_id');
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
    public function scopeReceivingReport($query)
    {
        $query->leftjoin('tbl_warehouse_receiving_report','record_source_ref_id','=','rr_id')
        ->leftjoin('tbl_item','tbl_warehouse_inventory_record_log.record_item_id','=','tbl_item.item_id')
        ->leftjoin('tbl_merchant_commission_report_setting','tbl_warehouse_inventory_record_log.record_warehouse_id','=','tbl_merchant_commission_report_setting.merchant_commission_warehouse_id');
    }
}