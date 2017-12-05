<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_requisition_slip_item extends Model
{
	protected $table = 'tbl_requisition_slip_item';
	protected $primaryKey = "rs_itemline_id";
    public $timestamps = false;
}