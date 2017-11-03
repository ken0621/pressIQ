<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_commission extends Model
{
	protected $table = 'tbl_commission';
	protected $primaryKey = "commission_id";
    public $timestamps = false;
}