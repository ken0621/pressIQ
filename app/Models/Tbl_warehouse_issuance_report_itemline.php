<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_warehouse_issuance_report_itemline extends Model
{
	protected $table = 'tbl_warehouse_issuance_report_itemline';
	protected $primaryKey = "wt_id";
    public $timestamps = false;

    public function scopeUm($query)
    {
        return $query->leftjoin('tbl_unit_measurement_multi','multi_um_id','=','wt_um');
    }
}