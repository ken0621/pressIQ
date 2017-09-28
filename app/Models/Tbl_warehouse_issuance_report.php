<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_warehouse_issuance_report extends Model
{
	protected $table = 'tbl_warehouse_issuance_report';
	protected $primaryKey = "wis_id";
    public $timestamps = true;
}