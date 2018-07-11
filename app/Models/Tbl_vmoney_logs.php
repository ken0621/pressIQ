<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_vmoney_logs extends Model
{
   	protected $table = 'tbl_vmoney_logs';
	protected $primaryKey = "vmoney_logs_id";
    public $timestamps = true;
}