<?php
namespace App\Globals;

use App\Models\Tbl_credit_memo;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionReceivePayment
{
	public static function countAvailableCredit($shop_id, $customer_id)
	{
		return Tbl_credit_memo::where("cm_shop_id", $shop_id)->where("cm_customer_id", $customer_id)->where("cm_type",1)->where("cm_used_ref_name","retain_credit")->count();
	}
}