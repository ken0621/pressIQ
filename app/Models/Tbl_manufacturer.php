<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_manufacturer extends Model
{
	protected $table = 'tbl_manufacturer';
	protected $primaryKey = "manufacturer_id";
    public $timestamps = false;
}