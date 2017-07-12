<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_attachment extends Model
{
    protected $table = 'tbl_customer_attachment';
	protected $primaryKey = "customer_attachment_id";
    public $timestamps = true;
}
