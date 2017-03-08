<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_mlm_plan extends Model
{
	protected $table = 'tbl_mlm_plan';
	protected $primaryKey = "marketing_plan_code_id";
    public $timestamps = false;
    // marketing_plan_enable
    // 2 = inactive
    // 1= active
    // 0 = not configure
    
    // marketing_plan_release_schedule
    // 1 = instant
    // 2 = daily
    // 3 = weekly
    // 4= monthly
}
