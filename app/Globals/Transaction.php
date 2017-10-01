<?php
namespace App\Globals;

use App\Globals\Accounting;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_temp_customer_invoice;
use App\Models\Tbl_temp_customer_invoice_line;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use App\Models\Tbl_customer;

use App\Models\Tbl_transaction;
use App\Models\Tbl_transaction_list;
use App\Models\Tbl_transaction_item;
use App\Globals\AuditTrail;
use App\Globals\Tablet_global;

use DB;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Carbon\carbon;

class Transaction
{
    public static function create($shop_id, $transaction_id, $transaction_type, $transaction_date, $posted = false, $source = null, $transaction_number = null, $hidden_remarks = null)
    {
        if($source == null)
        {
            $cart = Cart2::get_cart_info();
        }
        else
        {
            $cart = null;
        }
        
        
        if($cart || $source != null) //INSERT ONLY IF CART IS NOT ZERO OR THERE IS SOURCE
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
            $insert_list["transaction_number"]          =  ($transaction_number ? $transaction_number :  Self::generate_transaction_number($shop_id, $transaction_type));
            
            if($source == null)
            {
                $insert_list["transaction_subtotal"]        = $cart["_total"]->total;
                $insert_list["transaction_tax"]             = 0;
                $insert_list["transaction_discount"]        = $cart["_total"]->global_discount;
                $insert_list["transaction_total"]           = $cart["_total"]->grand_total;
                $total                                      = $cart["_total"]->grand_total;
            }
            else
            {
                $source_transaction_list = Tbl_transaction_list::where("transaction_list_id", $source)->first();
                $insert_list["transaction_subtotal"]        = $source_transaction_list->transaction_subtotal;
                $insert_list["transaction_tax"]             = $source_transaction_list->transaction_tax;
                $insert_list["transaction_discount"]        = $source_transaction_list->transaction_discount;
                $insert_list["transaction_total"]           = $source_transaction_list->transaction_total;
                $total                                      = $source_transaction_list->transaction_total;
            }
            
            if($posted == "-")
            {
                $insert_list["transaction_posted"] = $total * -1;
            }
            elseif($posted == "+")
            {
                $insert_list["transaction_posted"] = $total;
            }
            else
            {
                $insert_list["transaction_posted"] = 0;
            }

            $transaction_list_id                        = Tbl_transaction_list::insertGetId($insert_list);    

            if($source == null)
            {
                /* INSERT ITEMS */
                foreach($cart["_item"] as $key => $item)
                {
                    $insert_item[$key]["transaction_list_id"]           = $transaction_list_id;
                    $insert_item[$key]["item_id"]                       = $item->item_id;
                    $insert_item[$key]["item_name"]                     = $item->item_name;
                    $insert_item[$key]["item_sku"]                      = $item->item_sku;
                    $insert_item[$key]["item_price"]                    = $item->item_price;
                    $insert_item[$key]["quantity"]                      = $item->quantity;
                    $insert_item[$key]["discount"]                      = $item->discount;
                    $insert_item[$key]["subtotal"]                      = $item->subtotal;
                }
                
                 Tbl_transaction_item::insert($insert_item);
            }
            else
            {
                $_item = Tbl_transaction_item::where("transaction_list_id", $source)->get();
                
                /* INSERT FROM OTHER TRANSACTION */
                foreach($_item as $key => $item)
                {
                    $insert_item[$key]["transaction_list_id"]           = $transaction_list_id;
                    $insert_item[$key]["item_id"]                       = $item->item_id;
                    $insert_item[$key]["item_name"]                     = $item->item_name;
                    $insert_item[$key]["item_sku"]                      = $item->item_sku;
                    $insert_item[$key]["item_price"]                    = $item->item_price;
                    $insert_item[$key]["quantity"]                      = $item->quantity;
                    $insert_item[$key]["discount"]                      = $item->discount;
                    $insert_item[$key]["subtotal"]                      = $item->subtotal;
                }
                
                Tbl_transaction_item::insert($insert_item);
            }
            
            $return = $transaction_list_id;
            Self::update_transaction_balance($transaction_id);
        }
        else
        {
            $return = "CARTY IS EMPTY";
        }

        return $return;
    }
    public static function consume_in_warehouse($shop_id, $transaction_list_id)
    {
        $warehouse_id = Warehouse2::get_main_warehouse($shop_id);
        
        $get_item = Tbl_transaction_item::where('transaction_list_id',$transaction_list_id)->get();
        
        $consume['name'] = 'transaction_list';
        $consume['id'] = $transaction_list_id;
        foreach ($get_item as $key => $value) 
        {
            Warehouse2::consume($shop_id, $warehouse_id, $value->item_id, $value->quantity, 'Enroll kit', $consume);
        }
    }
    public static function update_transaction_balance($transaction_id)
    {
        $balance = Tbl_transaction_list::where("transaction_id", $transaction_id)->groupBy("transaction_id")->sum("transaction_posted");
        $update["transaction_balance"] = $balance;
        $balance = Tbl_transaction::where("transaction_id", $transaction_id)->update($update);
    }
    public static function generate_transaction_number($shop_id, $transaction_type)
    {
        switch ($transaction_type)
        {
            case 'ORDER':
                $prefix = "ORDER-";
            break;
           
            case 'RECEIPT':
                $prefix = "";
            break;

            default:
                $prefix = "";
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
    public static function getCustomerNameTransaction($transaction_id = 0)
    {
        $customer_name = 'No customer found!';
        if($transaction_id)
        {
            $data = Tbl_transaction::where('transaction_id',$transaction_id)->first();
            
            if($data)
            {
                if($data->transaction_reference_table == 'tbl_customer' && $data->transaction_reference_id != 0)
                {
                    $chck = Tbl_customer::where('customer_id', $data->transaction_reference_id)->first();
                    if($chck)
                    {
                        $customer_name = $chck->first_name.' '.$chck->middle_name.' '.$chck->last_name;
                    }
                }
            }
        }
        return $customer_name;
    }
    public static function get_transaction_list($shop_id, $transaction_type = 'all', $search_keyword = '', $paginate = 5, $transaction_id = 0)
    {
        $data = Tbl_transaction_list::where('shop_id',$shop_id);
        if($transaction_id != 0)
        {
            $data = Tbl_transaction_list::where('transaction_id',$transaction_id)->where('shop_id',$shop_id);
        }
        
        if(isset($transaction_type))
        {
            if($transaction_type != 'all')
            {
                $data->where('transaction_type', $transaction_type);
            }
        }
        if(isset($search_keyword))
        {
            $data->where('transaction_number', "LIKE", "%" . $search_keyword . "%");
        }
        
        if($paginate)
        {
            $data = $data->paginate(5);
        }
        else
        {
            $data = $data->get();
        }
        
        foreach($data as $key => $value)
        {
            $data[$key]->customer_name = Transaction::getCustomerNameTransaction($value->transaction_id);
        }
        
        return $data;
    }
    public static function get_all_transaction_type()
    {
        $type[0] = 'order';
        $type[1] = 'receipt';
        
        return $type;
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