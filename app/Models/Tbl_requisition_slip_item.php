<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_requisition_slip_item extends Model
{
	protected $table = 'tbl_requisition_slip_item';
	protected $primaryKey = "rs_itemline_id";
    public $timestamps = false;

    public function scopeVendor($query)
    {
    	return $query->leftjoin('tbl_vendor','rs_vendor_id','=','vendor_id');
    }
    public function scopeItem($query)
    {
    	return $query->leftjoin('tbl_item','rs_item_id','=','item_id');    	
    }
}