<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_transaction_list extends Model
{
	protected $table = 'tbl_transaction_list';
	protected $primaryKey = "transaction_list_id";
	public $timestamps = false;
	
	
	public function scopeTransaction($query)
	{
		return $query->join("tbl_transaction", "tbl_transaction.transaction_id", "=", "tbl_transaction_list.transaction_id");
	}
	public function scopeSalesperson($query)
	{
		return $query->leftjoin("tbl_user", "user_id", "=", "transaction_sales_person");
	}
}