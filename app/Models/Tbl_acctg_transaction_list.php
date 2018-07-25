<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_acctg_transaction_list extends Model
{
	protected $table = 'tbl_acctg_transaction_list';
	protected $primaryKey = "acctg_transaction_list_id";
    public $timestamps = false;

    public function scopeAcctgTransaction($query)
    {
    	$query->leftjoin('tbl_acctg_transaction','tbl_acctg_transaction.acctg_transaction_id','=','tbl_acctg_transaction_list.acctg_transaction_id');
    }
}