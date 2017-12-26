<?php
namespace App\Globals;

use App\Models\Tbl_debit_memo;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen Garcia Gutierrez
 */

class TransactionDebitMemo
{
	public static function getOpenDM($shop_id, $vendor_id)
    {
        return Tbl_debit_memo::where('db_shop_id',$shop_id)->where('db_vendor_id', $vendor_id)->get();
    }

    public static function countTransaction()
    {
    	$count_so = Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_status","accepted")->where('is_sales_order', 1)->count();
        $count_pr = Tbl_requisition_slip::where('shop_id',$shop_id)->where("requisition_slip_status","open")->count();
        
        $return = $count_so + $count_pr;
        return $return;
    }
   
}