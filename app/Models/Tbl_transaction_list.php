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
		return $query->leftjoin("tbl_transaction", "tbl_transaction.transaction_id", "=", "tbl_transaction_list.transaction_id");
	}
	public function scopeCodeVaultTransaction($query)
	{
		return $query->join("tbl_transaction", "tbl_transaction.transaction_id", "=", "tbl_transaction_list.transaction_id")->join("tbl_warehouse_inventory_record_log", "tbl_warehouse_inventory_record_log.record_consume_ref_id", "=", "tbl_transaction_list.transaction_list_id")->leftjoin('tbl_item','item_id','=','record_item_id');
	}
	public function scopeSalesperson($query)
	{
		return $query->leftjoin("tbl_user", "user_id", "=", "transaction_sales_person");
	}

	public function scopeGetTransaction($query)
	{
		$query->join("tbl_transaction", "tbl_transaction.transaction_id", "=", "tbl_transaction_list.transaction_id");
		$query->join("tbl_transaction_item", "tbl_transaction_item.transaction_list_id", "=", "tbl_transaction_list.transaction_list_id");
		$query->join("tbl_item", "tbl_item.item_id", "=", "tbl_transaction_item.item_id");

		return $query;
	}
}