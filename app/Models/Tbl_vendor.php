<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_vendor extends Model
{
	protected $table = 'tbl_vendor';
	protected $primaryKey = "vendor_id";
    public $timestamps = false;

    public function scopeAddress($query)
    {
    	return $query->join("tbl_vendor_address","ven_addr_vendor_id","=","vendor_id");
    }

    public function scopeInfo($query)
    {
    	return $query->join("tbl_vendor_address","ven_addr_vendor_id","=","vendor_id")
    		  		 ->join("tbl_vendor_other_info","ven_info_vendor_id","=","vendor_id");
    }
}