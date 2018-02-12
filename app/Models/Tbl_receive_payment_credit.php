<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_receive_payment_credit extends Model
{
	protected $table = 'tbl_receive_payment_credit';
	protected $primaryKey = "rp_credit_id";
    public $timestamps = false;
}