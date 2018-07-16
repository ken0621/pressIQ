<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_bill_item_line extends Model
{
    protected $table = 'tbl_bill_item_line';
	protected $primaryKey = "itemline_id";
    public $timestamps = false;

    public function scopeUm($query)
    {    	
        return $query->leftjoin("tbl_unit_measurement_multi", "multi_id", "=", "itemline_um");
    }

    public function scopeItem($query)
    {
    	 return $query->join('tbl_item', 'tbl_item.item_id', '=', 'tbl_bill_item_line.itemline_item_id');
    }
}
