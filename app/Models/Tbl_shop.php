<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_shop extends Model
{
	protected $table = 'tbl_shop';
	protected $primaryKey = "shop_id";
    public $timestamps = false;
}