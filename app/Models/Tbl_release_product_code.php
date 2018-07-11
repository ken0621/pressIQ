<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_release_product_code extends Model
{
	protected $table = 'tbl_release_product_code';
	protected $primaryKey = "release_product_id";
    public $timestamps = false;
}