<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_employee extends Model
{
	protected $table = 'tbl_employee';
	protected $primaryKey = "employee_id";
    public $timestamps = false;

    public static function scopePosition($query)
    {
    	return $query->join("tbl_position","tbl_employee.position_id","=","tbl_position.position_id");
    }
}