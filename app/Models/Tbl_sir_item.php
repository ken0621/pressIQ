<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_sir_item extends Model
{
	protected $table = 'tbl_sir_item';
	protected $primaryKey = "sir_item_id";
    public $timestamps = false;

    public function scopeSelect_sir_item($query)
    {
        return $query->leftjoin("tbl_item","tbl_item.item_id","=","tbl_sir_item.item_id");
    }
}