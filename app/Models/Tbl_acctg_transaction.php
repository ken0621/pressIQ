<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_acctg_transaction extends Model
{
	protected $table = 'tbl_acctg_transaction';
	protected $primaryKey = "acctg_transaction_id";
    public $timestamps = false;
}