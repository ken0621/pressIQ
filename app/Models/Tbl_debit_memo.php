<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_debit_memo extends Model
{
   protected $table = 'tbl_debit_memo';
   protected $primaryKey = "db_id";
   public $timestamps = false;

    public function scopeVendor($query)
    {
    	return $query->leftjoin("tbl_vendor","tbl_vendor.vendor_id","=","tbl_debit_memo.db_vendor_id");
    }
}
