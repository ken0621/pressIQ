<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_address extends Model
{
    protected $table = 'tbl_customer_address';
	protected $primaryKey = "customer_address_id";
    public $timestamps = true;
}
