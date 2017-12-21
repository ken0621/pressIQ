<?php
namespace App\Globals;

use App\Models\Tbl_customer_estimate;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionPurchaseRequisition
{
	public static function countTransaction($shop_id)
	{
		return Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_status","accepted")->count();
	}
	public static function postInsert()
	{
		
	}
}