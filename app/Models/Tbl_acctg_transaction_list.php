<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_acctg_transaction_list extends Model
{
	protected $table = 'tbl_acctg_transaction_list';
	protected $primaryKey = "acctg_transaction_list_id";
    public $timestamps = false;
}