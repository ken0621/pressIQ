<?php
namespace App\Globals;

use App\Globals\Accounting;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_temp_customer_invoice;
use App\Models\Tbl_temp_customer_invoice_line;
use App\Models\Tbl_user;
use App\Models\Tbl_item;

use App\Models\Tbl_transaction;
use App\Models\Tbl_transaction_list;

use App\Globals\AuditTrail;
use App\Globals\Tablet_global;

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
    public static function create($shop_id, $transaction_id, $transaction_type, $transaction_date, $posted = false)
    {
        $cart = Cart2::get_cart_info();

        if($cart["_total"]->grand_total > 0) //INSERT ONLY IF CART IS NOT ZERO
        {
            if(!is_numeric($transaction_id)) //CREATE NEW IF TRANSACTION ID if $transaction_id is an ARRAY
            {
                $insert_transaction["shop_id"]                      = $shop_id;
                $insert_transaction["transaction_id_shop"]          = Self::shop_increment($shop_id);  
                $insert_transaction["transaction_reference_table"]  = $transaction_id["transaction_reference_table"];
                $insert_transaction["transaction_reference_id"]     = $transaction_id["transaction_reference_id"];
                $transaction_id = Tbl_transaction::insertGetId($insert_transaction);
            }

            /* INSERT NEW LIST */
            $insert_list["transaction_id"]              = $transaction_id;
            $insert_list["shop_id"]                     = $shop_id;
            $insert_list["transaction_date"]            = $transaction_date;
            $insert_list["transaction_due_date"]        = $transaction_date;
            $insert_list["transaction_date_created"]    = Carbon::now();
            $insert_list["transaction_date_updated"]    = Carbon::now();
            $insert_list["transaction_type"]            = $transaction_type;
            $insert_list["transaction_number"]          = Self::generate_transaction_number($shop_id, $transaction_type);
            $insert_list["transaction_subtotal"]        = $cart["_total"]->total;
            $insert_list["transaction_tax"]             = 0;
            $insert_list["transaction_discount"]        = $cart["_total"]->global_discount;
            $insert_list["transaction_total"]           = $cart["_total"]->grand_total;
            $insert_list["transaction_posted"]          = ($posted ? $cart["_total"]->grand_total : 0);
            
            /* INSERT ITEMS */
            foreach($cart["_item"] as $key => $item)
            {
                $insert_item[$key]["transaction_list_id"]           = Tbl_transaction_list::insertGetId($insert_list);
                $insert_item[$key]["item_id"]                       = $item->item_id;
                $insert_item[$key]["item_name"]                     = $item->item_name;
                $insert_item[$key]["item_sku"]                      = $item->item_sku;
                $insert_item[$key]["item_price"]                    = $item->item_price;
                $insert_item[$key]["quantity"]                      = $item->quantity;
                $insert_item[$key]["discount"]                      = $item->discount;
                $insert_item[$key]["subtotal"]                      = $item->subtotal;
                $insert_item[$key]["remarks"]                       = "FROM CART";
                
            }
        }
    }
    public static function generate_transaction_number($shop_id, $transaction_type)
    {
        switch ($transaction_type)
        {
            case 'ORDER':
                $prefix = "ORDER";
            break;
           
            case 'RECEIPT':
                $prefix = "RECEIPT";
            break;

            default:
                $prefix = "TRANS";
            break;
        }

        $last_transaction_number = Tbl_transaction_list::where("shop_id", $shop_id)->where("transaction_type", $transaction_type)->orderBy("transaction_list_id", "desc")->value("transaction_number");
        
        if($last_transaction_number)
        {
            $next_transaction_number = intval(str_replace($prefix, "", $last_transaction_number)) + 1;
        }
        else
        {
            $next_transaction_number = 1;
        }

        $transaction_number = $prefix . str_pad($next_transaction_number, 6, '0', STR_PAD_LEFT);

        return $transaction_number;
    }
    public static function shop_increment($shop_id)
    {
        $last_transaction_id = Tbl_transaction::where("shop_id", $shop_id)->orderBy("transaction_id_shop", "desc")->value("transaction_id_shop");

        if($last_transaction_id)
        {
            return $last_transaction_id + 1;
        }
        else
        {
            return 1;
        }
    }
	public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
    }

    public static function check_number_existense($tbl_name, $column_name, $shop_column_name,$number, $for_tablet = false)
    {
        $shop_id = Transaction::getShopId();
        if($for_tablet == true)
        {
            $shop_id = Tablet_global::getShopId();
        }
        $data = DB::table($tbl_name)->where($column_name,$number)->where($shop_column_name,$shop_id)->count();

        return $data;
    }

    public static function get_last_number($tbl_name, $column_name, $shop_column_name,$for_tablet = false)
    {
        $shop_id = Transaction::getShopId();
        if($for_tablet == true)
        {
            $shop_id = Tablet_global::getShopId();
        }
        $data = DB::table($tbl_name)->orderBy($column_name,"DESC")->where($shop_column_name,$shop_id)->value($column_name);

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