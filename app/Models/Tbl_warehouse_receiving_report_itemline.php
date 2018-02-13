<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_warehouse_receiving_report_itemline extends Model
{
	protected $table = 'tbl_warehouse_receiving_report_itemline';
	protected $primaryKey = "rrline_id";
    public $timestamps = false;
}