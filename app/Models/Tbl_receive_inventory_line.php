<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_receive_inventory_line extends Model
{
    protected $table = 'tbl_receive_inventory_line';
	protected $primaryKey = "riline_id";
    public $timestamps = true;

}
