<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_wis_item extends Model
{
    protected $table = 'tbl_customer_wis_item';
	protected $primaryKey = "cust_wis_item_id";
    public $timestamps = true;
}
