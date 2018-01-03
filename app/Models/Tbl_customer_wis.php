<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_wis extends Model
{
    protected $table = 'tbl_customer_wis';
	protected $primaryKey = "cust_wis_id";
    public $timestamps = true;

    public function scopeInventoryItem($query)
    {
        $query->selectRaw("*, count(cust_wis_item_id) as issued_qty")->leftjoin("tbl_customer_wis_item","tbl_customer_wis.cust_wis_id", "=", "tbl_customer_wis_item.cust_wis_id");

        return $query;
    }

   public function scopeCustomerInfo($query)
    {
        $query->join("tbl_customer","tbl_customer.customer_id", "=", "tbl_customer_wis.destination_customer_id");
        return $query;
    }
}
