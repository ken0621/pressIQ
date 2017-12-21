<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_wis_item_line extends Model
{
    protected $table = 'tbl_customer_wis_item_line';
	protected $primaryKey = "itemline_id";
    public $timestamps = false;
}