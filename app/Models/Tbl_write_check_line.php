<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_write_check_line extends Model
{
    protected $table = 'tbl_write_check_line';
	protected $primaryKey = "wcline_id";
    public $timestamps = false;

     public function scopeUm($query)
    {    	
        return $query->leftjoin("tbl_unit_measurement_multi", "multi_id", "=", "wcline_um");
    }
}
