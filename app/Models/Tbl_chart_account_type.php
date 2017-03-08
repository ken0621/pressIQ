<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_chart_account_type extends Model
{
	protected $table = 'tbl_chart_account_type';
	protected $primaryKey = "account_type_id";
    public $timestamps = false;
}