<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Tbl_item extends Model
{
    protected $table = 'tbl_item';
	protected $primaryKey = "item_id";
    public $timestamps = false;
    
    public function scopeType($query)
    {
        $query->join('tbl_item_type','tbl_item_type.item_type_id','=','tbl_item.item_type_id');
        return $query;
    }

    public function scopeCategory($query)
    {
        $query->join('tbl_category','type_id','=','item_category_id');
        return $query;
    }

    public function scopeselitem($query, $item_id)
    {
        $query->where('item_id',$item_id);
    }

    public function scopeAccountAsset($query)
    {
        return $query->leftjoin("tbl_chart_of_account", "account_id", "=", "item_asset_account_id")
                     ->leftjoin("tbl_chart_account_type", "chart_type_id", "=", "account_type_id");
    }

    public function scopeItemDiscount($query)
    {
        return $query->leftjoin("tbl_item_discount","tbl_item_discount.discount_item_id","=","tbl_item.item_id");
    }
    public function scopeAccountIncome($query)
    {
        return $query->leftjoin("tbl_chart_of_account", "account_id", "=", "item_income_account_id")
                     ->leftjoin("tbl_chart_account_type", "chart_type_id", "=", "account_type_id");
    }

    public function scopeAccountExpense($query)
    {
        return $query->leftjoin("tbl_chart_of_account as asset", "account_id", "=", "item_expense_account_id")
                     ->leftjoin("tbl_chart_account_type", "chart_type_id", "=", "account_type_id");
    }

    public function scopeBundle($query)
    {
        return $query->leftjoin("tbl_item_bundle as bundle","bundle_bundle_id","=","item_id")
                     ->join("tbl_item as bundle_item","item_id","=","bundle_item_id");
    }

    public function scopeInventory($query, $warehouse_id = null)
    {
        return $query->selectRaw("*, IFNULL(sum(inventory_count),0) as inventory_count")
                     ->leftjoin(DB::raw("(Select wi.* from tbl_warehouse_inventory wi INNER JOIN tbl_warehouse wh on wh.warehouse_id = wi.warehouse_id where wh.archived = 0) warehouse"), function($join) use ($warehouse_id)
                     {
                        $join->on("inventory_item_id","=","item_id");
                        if($warehouse_id)
                        {
                            $join->on("warehouse.warehouse_id","=", DB::raw($warehouse_id));
                        }
                     })
                     ->groupBy("item_id");
    }

    public function scopeNewPrice($query, $qty)
    {
        return $query->selectRaw("*, IFNULL(multiprice_price, item_price) as new_price")
                     ->leftJoin("tbl_item_multiple_price", function($on) use($qty)
                     {
                        $on->on("multiprice_item_id","=","item_id");
                        $on->on("multiprice_qty","=",DB::raw("(Select max(multiprice_qty) from tbl_item_multiple_price where multiprice_qty <= $qty and tbl_item.item_id = multiprice_item_id group by multiprice_item_id)"));
                     });                  
    }

    public function scopeMultiPrice($query)
    {
        return $query->select("multiprice_qty","multiprice_price")
                     ->join("tbl_item_multiple_price","multiprice_item_id","=","item_id");
    }
    public function scopeUm($query)
    {
        return $query->leftjoin("tbl_unit_measurement","item_measurement_id","=","um_id");
    }

    public function scopeProduct($query, $archived = null)
    {
        $query->join("tbl_ec_variant","item_id","=","evariant_item_id")
              ->join("tbl_ec_product","evariant_prod_id","=","eprod_id");
        if($archived != null) $query->where("tbl_ec_product.archived",$archived);

        return $query;
    }

    // public function scope

}
