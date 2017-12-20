<?php
namespace App\Globals;
use App\Models\Tbl_acctg_transaction;
use App\Models\Tbl_acctg_transaction_list;
use App\Models\Tbl_acctg_transaction_item;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class AccountingTransaction
{
	/**
	  * @param  
		$trans_data = [
		transaction_ref_name
		transaction_ref_id
		transaction_list_number	
		transaction_date]

		$trans_item = [
			itemline_item_id	int(10) unsigned	 
			itemline_item_um	int(10) unsigned NULL	 
			itemline_item_description	text	 
			itemline_item_qty	double	 
			itemline_item_rate	double	 
			itemline_item_taxable	tinyint(4)	 
			itemline_item_discount	double	 
			itemline_item_discount_type	varchar(255)	 
			itemline_item_discount_remarks	varchar(255)	 
			itemline_item_amount double	
		]
	  */
	public static function insertTransaction($shop_id, $trans_data = array(), $trans_item = array())
	{
		$insert_trans['shop_id'] = $shop_id;
		$insert_trans['transaction_number'] = "TR00001"; // MUST BE AUTO GENERATED

		$acctg_trans_id = Tbl_acctg_transaction::insertGetId($insert_trans);

		$trans_data['acctg_transaction_id'] = $acctg_trans_id;
		$trans_data['date_created'] = Carbon::now();
		Tbl_acctg_transaction_list::insert($trans_data);

		Self::insertItemline($acctg_trans_id, $trans_item);
	}
	public static function insertItemline($acctg_trans_id, $trans_item)
	{
		if(count($trans_item) > 0)
		{
			foreach ($trans_item as $key => $value)
			{
				$ins['acctg_transaction_id'] = $acctg_trans_id;
				$ins['itemline_item_id'] = $value['itemline_item_id'];
				$ins['itemline_item_um'] = $value['itemline_item_um'];
				$ins['itemline_item_description'] = $value['itemline_item_description'];
				$ins['itemline_item_qty'] = $value['itemline_item_qty'];
				$ins['itemline_item_rate'] = $value['itemline_item_rate'];
				$ins['itemline_item_taxable'] = $value['itemline_item_taxable'];
				$ins['itemline_item_discount'] = $value['itemline_item_discount'];
				$ins['itemline_item_discount_type'] = $value['itemline_item_discount_type'];
				$ins['itemline_item_discount_remarks'] = $value['itemline_item_discount_remarks'];
				$ins['itemline_item_amount'] = $value['itemline_item_amount'];

				Tbl_acctg_transaction_item::insert($ins);
			}
		}
	}
	public static function check_transaction($shop_id, $transaction_name, $transaction_id)
	{
		$check = Tbl_acctg_transaction_list::where("transaction_ref_name", $transaction_name)-
											->where("transaction_ref_id", $transaction_id)->first();
		
		$return = null;
		if($check)
		{
			$return = $check->acctg_transaction_id;
		}
		return $return;
	}
	public static function updateTransaction($shop_id, $acctg_trans_id, $trans_item = array())
	{
		
	}
}