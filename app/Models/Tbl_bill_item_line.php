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
}
