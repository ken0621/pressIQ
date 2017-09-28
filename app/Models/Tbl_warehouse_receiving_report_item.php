<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_warehouse_issuance_report_item extends Model
{
	protected $table = 'tbl_warehouse_receiving_report_item';
	protected $primaryKey = "rr_item_id";
    public $timestamps = false;
}