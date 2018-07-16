<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_other_info extends Model
{
    protected $table = 'tbl_customer_other_info';
	protected $primaryKey = "customer_other_info_id";
    public $timestamps = false;
}
