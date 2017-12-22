<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_requisition_slip extends Model
{
	protected $table = 'tbl_requisition_slip';
	protected $primaryKey = "requisition_slip_id";
    public $timestamps = false;

    public static function scopeGetPR($query)
    {
    	$query->join('tbl_requisition_slip', 'tbl_requisition_slip.requisition_slip_id', ' = ', 'tbl_requisition_slip_item.rs_id');

    	return $query;
    }
}