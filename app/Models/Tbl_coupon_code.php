<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_coupon_code extends Model
{
	protected $table = 'tbl_coupon_code';
	protected $primaryKey = "coupon_code_id";
    public $timestamps = false;
}