<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_receive_payment_line extends Model
{
	protected $table = 'tbl_receive_payment_line';
	protected $primaryKey = "rpline_id";
    public $timestamps = false;
}