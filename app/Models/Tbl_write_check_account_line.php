<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_write_check_account_line extends Model
{
	protected $table = 'tbl_write_check_account_line';
	protected $primaryKey = "accline_id";
    public $timestamps = false;
}