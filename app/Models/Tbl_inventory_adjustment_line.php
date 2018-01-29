<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_inventory_adjustment_line extends Model
{
	protected $table = 'tbl_inventory_adjustment_line';
	protected $primaryKey = "itemline_id";
    public $timestamps = false;
}