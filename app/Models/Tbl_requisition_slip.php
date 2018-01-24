<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_requisition_slip extends Model
{
	protected $table = 'tbl_requisition_slip';
	protected $primaryKey = "requisition_slip_id";
    public $timestamps = false;

}