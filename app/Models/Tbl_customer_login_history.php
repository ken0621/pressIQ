<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_login_history extends Model
{
	protected $table = 'tbl_customer_login_history';
	protected $primaryKey = "customer_login_history_id";
    public $timestamps = false;

}