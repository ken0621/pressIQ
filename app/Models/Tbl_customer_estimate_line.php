<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_estimate_line extends Model
{
	protected $table = 'tbl_customer_estimate_line';
	protected $primaryKey = "estline_id";
    public $timestamps = true;

    public function scopeUm($query)
    {
        return $query->leftjoin("tbl_unit_measurement_multi", "multi_id", "=", "estline_um");
    }
    public function scopeEstimate_item($query)
    {
    	return $query->join("tbl_item","tbl_item.item_id","=","estline_item_id");
    }
}