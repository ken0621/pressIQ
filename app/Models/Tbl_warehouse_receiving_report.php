<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_warehouse_receiving_report extends Model
{
	protected $table = 'tbl_warehouse_receiving_report';
	protected $primaryKey = "rr_id";
    public $timestamps = true;
}