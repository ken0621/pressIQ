<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_inventory_slip extends Model
{
    protected $table = 'tbl_inventory_slip';
	protected $primaryKey = "inventory_slip_id";
    public $timestamps = false;
}
