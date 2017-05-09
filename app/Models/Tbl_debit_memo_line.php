<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_debit_memo_line extends Model
{
   protected $table = 'tbl_debit_memo_line';
   protected $primaryKey = "dbline_id";
   public $timestamps = false;

   public function scopeUm($query)
    {
        return $query->leftjoin("tbl_unit_measurement_multi", "multi_id", "=", "dbline_um");
    }
    public function scopeDb_item($query)
    {
    	return $query->join("tbl_item","tbl_item.item_id","=","dbline_item_id");
    }
}
