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

}