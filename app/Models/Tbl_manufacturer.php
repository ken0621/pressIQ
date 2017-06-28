<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_manufacturer extends Model
{
	protected $table = 'tbl_manufacturer';
	protected $primaryKey = "manufacturer_id";
	public $timestamps = false;

	// public function scopeType($query)
	// {
	// 	return $query->join('tbl_chart_account_type','chart_type_id','=','account_type_id');
	// } 
}