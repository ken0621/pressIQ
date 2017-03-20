<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_item_multiple_price extends Model
{
	protected $table = 'tbl_item_multiple_price';
	protected $primaryKey = "multiprice_id";
    public $timestamps = false;
}