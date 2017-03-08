<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_ec_order_item extends Model
{
	protected $table = 'tbl_ec_order_item';
	protected $primaryKey = "ec_order_item_id";
    public $timestamps = false;
}