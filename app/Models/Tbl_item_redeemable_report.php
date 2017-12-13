<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_item_redeemable_report extends Model
{
    protected $table = 'tbl_item_redeemable_report';
	protected $primaryKey = "redeemable_report_id";
    public $timestamps = false;

}
