<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_item_bundle extends Model
{
	protected $table = 'tbl_item_bundle';
	protected $primaryKey = "bundle_id";
    public $timestamps = false;

    public function scopeItem($query)
    {
    	return $query->join("tbl_item","item_id","=","bundle_item_id");
    }
}