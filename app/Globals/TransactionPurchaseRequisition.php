<?php
namespace App\Globals;

use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_requisition_slip;
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
		return Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_status","accepted")->where('is_sales_order', 1)->count();
	}
	public static function getAllOpenPR($shop_id)
	{
		return Tbl_requisition_slip::where('shop_id',$shop_id)->where("requisition_slip_status","open")->get();
	}
	public static function postInsert()
	{
		
	}
}