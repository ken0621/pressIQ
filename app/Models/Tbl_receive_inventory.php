<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_receive_inventory  extends Model
{
	protected $table = 'tbl_receive_inventory';
	protected $primaryKey = "ri_id";
    public $timestamps = false;

    public static function scopeVendor($query)
    {
    	return $query->leftjoin('tbl_vendor', 'vendor_id', '=', 'ri_vendor_id');
    }
    
}