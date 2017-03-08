<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_inventory_serial_number extends Model
{
	protected $table = 'tbl_inventory_serial_number';
	protected $primaryKey = "serial_id";
    public $timestamps = false;
}