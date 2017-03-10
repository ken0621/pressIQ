<?php
namespace App\Globals;

use App\Globals\Accounting;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_temp_customer_invoice;
use App\Models\Tbl_temp_customer_invoice_line;
use App\Models\Tbl_user;
use App\Models\Tbl_item;

use App\Globals\AuditTrail;

use DB;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Carbon\carbon;

/**
 * Transaction Module - all transaction related module
 *
 * @author Bryan Kier Aradanas
 */

class Transaction
{
	public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public static function check_number_existense($tbl_name, $column_name, $shop_column_name,$number)
    {
        $data = DB::table($tbl_name)->where($column_name,$number)->where($shop_column_name,Transaction::getShopId())->count();

        return $data;
    }

    public static function get_last_number($tbl_name, $column_name, $shop_column_name)
    {
        $data = DB::table($tbl_name)->orderBy($column_name,"DESC")->where($shop_column_name,Transaction::getShopId())->pluck($column_name);

        return $data + 1 ;
    }

    /**
     * Getting all the list of transaction
     *
     * @param string    $filter     (byCustomer, byAccount, byItem)
     */

    public static function getAllTransaction($filter = null)
    {

    }
}