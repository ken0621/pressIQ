<?php
namespace App\Http\Controllers\Member;
use App\Globals\Cart2;
use App\Globals\Item;
use App\Globals\Customer;
use App\Globals\Transaction;
use App\Globals\WarehouseTransfer;
use App\Globals\Warehouse2;
use App\Globals\Utilities;
use Request;
use Session;
use Carbon\Carbon;
use App\Models\Tbl_payment_method;
use DB;
class CashierController extends Member
{
    public function pos()
    {
        Cart2::set_cart_key("cashier-" . $this->user_info->user_id);
    	$data["page"]           = "Point of Sale";
        $data["cart"]           = $_items = Cart2::get_cart_info();
        $data["_price_level"]   = Item::list_price_level($this->user_info->shop_id,null,null,null);
        $data["current_level"]  = ($data["cart"]["info"] ? $data["cart"]["info"]->price_level_id : 0);
        $data['_warehouse'] = Warehouse2::get_all_warehouse($this->user_info->shop_id);
        $data['_salesperson'] = Utilities::get_all_users($this->user_info->shop_id, $this->user_info->user_id);
        $data['_payment'] = Cart2::load_payment($this->user_info->shop_id);
        if(Session::has('customer_id'))
        {
            $data['customer'] = Customer::info(Session::get('customer_id'), $this->user_info->shop_id);
            $data['customer_points'] = Customer::get_points_wallet(Session::get('customer_id'));
            $cust_data = Customer::get_info($this->user_info->shop_id, Session::get('customer_id'));
            $warehouse_id = null;
            if($cust_data)
            {
                $warehouse_id = $cust_data->stockist_warehouse_id;
            }
            
            $data['_warehouse'] = Warehouse2::get_all_warehouse($this->user_info->shop_id, $warehouse_id);
            $data['exist'] = $data['customer'];
        }

        $data['_method'] = $method = Tbl_payment_method::where('shop_id',$this->user_info->shop_id)->where('isDefault',0)->get();
        foreach ($method as $key => $value) 
        {
            $data['_method'][$key]['_type'] = DB::table('tbl_payment_tag')->where('tbl_payment_tag.payment_method_id',$value->payment_method_id)->join('tbl_payment_type','tbl_payment_type.payment_type_id','=','tbl_payment_tag.payment_type_id')->get();
        }

        return view("member.cashier.pos", $data);
    }
    public function add_payment()
    {
        $payment_type = Request::input('payment_method');
        $payment_amount = Request::input('payment_amount');

        if($payment_amount > 0)
        {
            $return = Cart2::scan_payment($this->user_info->shop_id, $payment_type, $payment_amount);
            if(is_numeric($return))
            {
                $return = null;
                $return['status'] = 'success';
            }            
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = "You can't add zero amount of payment";

        }
        return json_encode($return);
    }
    public function load_payment()
    {
        $data['_payment'] = Cart2::load_payment($this->user_info->shop_id);

        return view('member.cashier.pos_payment_method',$data);
    }
    public function remove_payment()
    {
        $return = Cart2::remove_payment(Request::input('cart_payment_id'));

        return json_encode('success');
    }
    public function pos_table_item()
    {
    	$data["cart_key"]   = $cart_key = Cart2::get_cart_key();
        $data["cart"]       = $_items = Cart2::get_cart_info();
    	return view("member.cashier.pos_table_item", $data);
    }
    public function pos_search_item()
    {
        $data["page"]    = "POS Search Results";
        $data["shop_id"] = $this->user_info->shop_id;
        $data["keyword"] = Request::input("item_keyword");

        Item::get_search($data["keyword"]);
        $data["_item"]   = Item::get($data["shop_id"]);
        return view("member.cashier.pos_search_item", $data);
    }
    public function pos_search_customer()
    {
        $data['_customer'] = Customer::search_get($this->user_info->shop_id, Request::input("customer_keyword"));
        $data["shop_id"] = $this->user_info->shop_id;
        $data["keyword"] = Request::input("customer_keyword");

        return view("member.cashier.pos_search_customer", $data);
    }
    public function pos_scan_customer()
    {
        $data["shop_id"]        = $shop_id = $this->user_info->shop_id;
        $data["customer_id"]    = $customer_id = Request::input("customer_id");
        $data["customer"]       = $item = Customer::scan_customer($data["shop_id"], $data["customer_id"]);

        if($data["customer"])
        {    
            /* SCAN IF HAVE RESERVED CODE */
            $reserved_item = Cart2::scan_reserved_code($shop_id, $data['customer']->customer_id);
            
            Session::put('customer_id', $data['customer']->customer_id);
            $return["status"]   = "success";
            $return["message"]  = "";
            $return["reserved_item"]  = $reserved_item;
            $return["price_level_id"] = $data['customer']->membership_price_level;
            $return["stockist_warehouse_id"] = $data['customer']->stockist_warehouse_id;
        }
        else
        {
            $return["status"]   = "error";
            $return["message"]  = "The Customer you scanned didn't match any record.";
        }

        echo json_encode($return);
    }
    public function remove_customer()
    {
        Session::forget('customer_id');
        $return['status'] = 'success';
        $return['load_item_table'] = '';
        if(session('reserved_item'))
        {
            Cart2::clear_cart();
            $return['load_item_table'] = 'true';
        }

        return json_encode($return);
    }
    public function customer()
    {
        $data = [];
        if(Session::has('customer_id'))
        {
            $data = Customer::info(Session::get('customer_id'), $this->user_info->shop_id);
            $data['exist'] = $data;
            $data['customer_points'] = Customer::get_points_wallet(Session::get('customer_id'));
        }
        return view('member.cashier.pos_customer_info',$data);
    }
    public function get_current_gc()
    {
        $slot_no = request('slot_no');
        // $data['current_slot_gc'] = Customer::get_current_slot_gc($slot_no);
        // $data['current_slot_wallet'] = Customer::get_current_slot_wallet($slot_no);
        // $slot_id = Customer::get_slot_id($slot_no);
        $data['current_slot_gc'] = currency("",Customer::get_points_wallet_per_slot($slot_no)['total_gc']);
        $data['current_slot_wallet'] = currency("",Customer::get_points_wallet_per_slot($slot_no)['total_wallet']);
        return json_encode($data);
    }
    public function pos_scan_item()
    {
        $data["shop_id"]    = $shop_id = $this->user_info->shop_id;
        $data["item_id"]    = $item_id = Request::input("item_id");
        $data["item"]       = $item = Cart2::scan_item($data["shop_id"], $data["item_id"]);

        if(!$data['item'])
        {
            $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
            $data['item'] = $val = Cart2::scan_ref_num($data["shop_id"], $warehouse_id, $data["item_id"]);
            $item_id = $val;
        }

        $val = 0;
        if(!$data['item'])
        {
            $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
            $data['item'] = $val = Cart2::scan_pin_code($data["shop_id"], $warehouse_id, $data["item_id"]);
            $item_id = $val;
        }
        if($data["item"] && is_numeric($val))
        {
            $return["status"]   = "success";
            $return["message"]  = "Item Number " .  $item_id . " has been added.";
            Cart2::add_item_to_cart($shop_id, $item_id, 1);
        }
        else
        {
            $return["status"]   = "error";
            $return["message"]  = "The ITEM you scanned didn't match any record.";
            if(!is_numeric($val))
            {
                $return["message"]  = $val;
            }
        }

        echo json_encode($return);
    }
    public function pos_change_qty()
    {
        $data["shop_id"]    = $shop_id = $this->user_info->shop_id;
        $data["item_id"]    = $item_id = Request::input("item_id");
        $quantity           = Request::input("qty");
        $data["item"]       = $item = Cart2::scan_item($data["shop_id"], $data["item_id"]);
        $count = Cart2::get_item_pincode($shop_id, $item_id);

        if(count($count) > 0)
        {
            $return["status"]   = "error";
            $return["status_message"]  = "The ITEM cannot change quantity.";
        }
        else
        {
            if($data["item"])
            {
                $return["status"]   = "success";
                $return["status_message"]  = "Item Number " .  $item->item_id . " has been added.";
                Cart2::add_item_to_cart($shop_id, $item_id, $quantity, true);
                $return["call_function"] = "";
            }
            else
            {
                $return["status"]   = "error";
                $return["status_message"]  = "The ITEM you scanned didn't match any record.";
            }   
        }

        echo json_encode($return);
    }

    public function pos_change_non_inventory_price()
    {
        $data["shop_id"]    = $shop_id = $this->user_info->shop_id;
        $data["item_id"]    = $item_id = Request::input("item_id");
        $new_price          = Request::input("new_price");
        $data["item"]       = $item = Cart2::scan_item($data["shop_id"], $data["item_id"]);
        

        if($data["item"])
        {
            $return["status"]   = "success";
            $return["status_message"]  = "New Price Posted";
            Cart2::add_item_to_cart($shop_id, $item_id, 0, false, $new_price);
            $return["call_function"] = "";
        }
        else
        {
            $return["status"]   = "error";
            $return["status_message"]  = "The ITEM you scanned didn't match any record.";
        }   
        echo json_encode($return);
    }

    public function set_cart_info($key, $value)
    {
        $cart_key           = Cart2::get_cart_key();
        $set_info_status    = Cart2::set($key, $value);
        echo json_encode($set_info_status);
    }
    public function pos_remove_item()
    {
        $item_id = Request::input("item_id");
        Cart2::delete_item_from_cart($item_id); 
        $return["status"] = "success";
        $return["item_id"] = $item_id;
        echo json_encode($return);
    }
    public function load_warehouse()
    {
        $warehouse_id = Request::input('w_id');
        $data['_warehouse'] = Warehouse2::get_all_warehouse($this->user_info->shop_id, $warehouse_id);
        return view('member.cashier.pos_load_warehouse',$data);
    }

    public function settings()
    {
        $data["page"]           = "Cashier Settings";
        
        /*THIS IS FOR PHILTECH ONLY ------INSERT IF NO DATA JAMES OMOSORA*/
        $seed = ['CASH','GC','WALLET','BANK','REMITTANCE'];
        $seeds = ['PALAWAN EXPRESS','LBC','BDO','ML KWARTA PADALA','CEBUANA LHUILLIER'];

        foreach ($seed as $key => $value) 
        {
            $check = Tbl_payment_method::where('shop_id',$this->user_info->shop_id)->where('payment_name',$value)->first();
            if(!$check && $this->user_info->shop_id == 1)
            {
                $ins['shop_id']         = $this->user_info->shop_id;
                $ins['payment_name']    = $value;
                $ins['isDefault']       = 0;
                $ins['archived']        = 0;
                $id = Tbl_payment_method::insertGetId($ins);

                for($i = 1; $i <= 5; $i++)
                {
                    $tag['payment_method_id'] = $id;
                    $tag['payment_type_id'] = $i;

                    DB::table('tbl_payment_tag')->insert($tag);
                }
                
            }
        }

        foreach ($seeds as $key => $value) 
        {
            $check = DB::table('tbl_payment_type')->where('payment_type_name',$value)->first();
            if(!$check && $this->user_info->shop_id == 1)
            {
                $ins['payment_type_name']    = $value;
                $id = DB::table('tbl_payment_type')->insert($ins);
            }
        }

        $data['_list']          = Tbl_payment_method::where('shop_id',$this->user_info->shop_id)->where('isDefault',0)->where('archived',0)->get();

        return view('member.cashier.settings.cashier_settings',$data);
    }

    
    public function settings_action($id)
    {
        if($id == "submit")
        {
            $data = Request::all();
            DB::table('tbl_payment_method')->where('payment_method_id',$data['payment_method_id'])->update(['payment_name'=>$data['payment_name']]);
            
            $list                    = DB::table('tbl_payment_tag')->where('payment_method_id',$data['payment_method_id'])->delete();
            $return  = Self::adding_payment_type($data,$data['payment_method_id']);
            
        
            return $return;
        }
        else if($id == "add")
        {
            $data['_type']          = DB::table('tbl_payment_type')->get();

            return view('member.cashier.settings.cashier_settings_add',$data);
        }
        else if($id == "add_submit")
        {
            Self::settings_add_submit(Request::all());
        }
        else
        {
            $data['method']          = DB::table('tbl_payment_method')->where('payment_method_id',$id)->first();
            $list                    = DB::table('tbl_payment_tag')->where('payment_method_id',$id)->join('tbl_payment_type','tbl_payment_type.payment_type_id','=','tbl_payment_tag.payment_method_id')->get();
            $data['_type']           = $type  = DB::table('tbl_payment_type')->get();

            foreach($type as $key=>$types)
            {
                $check               = DB::table('tbl_payment_tag')->where('payment_method_id',$id)->where('payment_type_id',$types->payment_type_id)->first();
                
                $data['_type'][$key]->is_check = $check ?  "checked" : "";
            }

            return view('member.cashier.settings.cashier_settings_edit',$data);
        }
        
    }

    public static function settings_add_submit($data)
    {
        if($data['payment_name'] == "")
        {
            $return['message'] = "Method Name Required";
            $return['status'] = 'error';
        }
        else
        {
            $insert['shop_id']         = $this->user_info->shop_id;
            $insert['payment_name']    = $data['payment_name'];
            $insert['isDefault']       = 0;
            $insert['archived']        = 0;
            $id = Tbl_payment_method::insertGetId($insert);
        
            $return  = Self::adding_payment_type($data,$id);
        }
        return $return;
    }

    public static function adding_payment_type($data,$id)
    {
        foreach($data['payment_type_id'] as $key=>$payment)
        {
            $check = DB::table('tbl_payment_tag')->where('payment_method_id',$id)->where('payment_type_id',$payment)->first();
            
            if(!$check)
            {
                if($payment == 0 && $data['payment_type_name'][$key] != "")
                {
                    $ins['payment_type_name']    = $data['payment_type_name'][$key];
                    $payment = DB::table('tbl_payment_type')->insert($ins);
                }

                $tag['payment_method_id'] = $id;
                $tag['payment_type_id'] = $payment;
                if($payment != 0)
                {
                    DB::table('tbl_payment_tag')->insert($tag);
                }
                
            }
        }
        $return['message'] = "SUCCESS";
        $return['status'] = 'success';

        return $return;
    }

    public function process_sale()
    {
        $cart = Cart2::get_cart_info();
        $consume_inventory                                  = Request::input('consume_inventory');
            
        $method                                             = Request::input('payment_method');
        $payment_method_type                                = Request::input('payment_method_type');
        $transaction_remark                                 = Request::input('transaction_remark');
        $transaction_sales_person                           = Request::input('transaction_sales_person');
        $amount                                             = Request::input('payment_amount');
        $slot_id                                            = Request::input('slot_id');
        $use_product_code                                   = Request::input('use_product_code');

        $transaction_payment_method      = $method;
        $transaction_payment_method_type = $payment_method_type;
        $transaction_remark              = $transaction_remark;

        $shop_id                                            = $this->user_info->shop_id;
        $transaction_new["transaction_reference_table"]     = "tbl_customer";
        $transaction_new["transaction_reference_id"]        = Session::get('customer_id');
        $transaction_new["transaction_sales_person"]        = Request::input('transaction_sales_person');
        $transaction_type                                   = "ORDER";
        $transaction_date                                   = Carbon::now();
        $destination_warehouse_id                           = Request::input('destination_warehouse_id');

        $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
        $return = null;
        $validate = null;

        if($cart)
        {   
            if($transaction_new["transaction_reference_id"])
            {
                foreach ($cart["_item"] as $key => $value)
                {
                    $item_type = Item::get_item_type($value->item_id);
                    if($item_type == 1 || $item_type == 5)
                    {
                        $validate .= Warehouse2::consume_validation($shop_id, $warehouse_id, $value->item_id, $value->quantity,'Consume');
                    }
                }

                if(!$destination_warehouse_id && $consume_inventory == 'wis')
                {
                    $validate .= 'Please choose a warehouse destination <br>';
                }

                $validate .= Transaction::validate_payment($shop_id, $slot_id);

                if(!$validate)
                {
                    Transaction::create_set_method('pos');
                    Transaction::create_set_method_id(0);
                    /*FROM NEGATIVE SIGN> JAMES CHANGE*/
                    $transaction_list_id                                = Transaction::create($shop_id, $transaction_new, $transaction_type, $transaction_date, '-', null, null, null,$transaction_payment_method,$transaction_payment_method_type,$transaction_remark,$transaction_sales_person);
                    // $transaction_list_id                                = Transaction::create($shop_id, $transaction_new, $transaction_type, $transaction_date, '-');

                    if(is_numeric($transaction_list_id))
                    {
                        $get_transaction_list = Transaction::get_data_transaction_list($transaction_list_id);
                        $get_item = Transaction::get_transaction_item($transaction_list_id);
                        $remarks = 'Consume in Transaction Number : '.$get_transaction_list->transaction_number;


                        if($consume_inventory == 'instant')
                        {
                            /* NAG ADD AKO NG SLOT ID */
                            Transaction::consume_in_warehouse($shop_id, $transaction_list_id, $remarks, $warehouse_id,$slot_id,$use_product_code);
                            $validate = 1;
                        }
                        if($consume_inventory == 'wis')
                        {
                            $ins_wis['wis_shop_id'] = $shop_id;
                            $ins_wis['wis_number'] = $get_transaction_list->transaction_number;
                            $ins_wis['wis_from_warehouse'] = $warehouse_id;
                            $ins_wis['destination_warehouse_id'] = Request::input('destination_warehouse_id');
                            $ins_wis['wis_remarks'] = $remarks;
                            $ins_wis['created_at'] = Carbon::now();

                            $_item = null;
                            foreach ($get_item as $key_item => $value_item) 
                            {
                                $_item[$key_item]['item_id'] = $value_item->item_id;
                                $_item[$key_item]['quantity'] = $value_item->quantity;
                                $_item[$key_item]['remarks'] = 'wis';
                            }
                            $validate = WarehouseTransfer::create_wis($shop_id, $remarks, $ins_wis, $_item);
                        }


                        if(is_numeric($validate))
                        {
                            /** CONSUME - PAYMENT FOR GC AND WALLET **/ 
                            $validate = Transaction::consume_payment($shop_id, $transaction_list_id, $slot_id);

                            if(is_numeric($validate))
                            {
                                /*FROM POSITIVE SIGN> JAMES CHANGE*/
                                $transaction_receipt_list_id      = Transaction::create($shop_id, $get_transaction_list->transaction_id, 'RECEIPT', $transaction_date, '+', null, null, null,$transaction_payment_method,$transaction_payment_method_type,$transaction_remark,$transaction_sales_person);
                                
                                if(is_numeric($transaction_receipt_list_id))
                                {
                                    Session::forget('customer_id');
                                    Cart2::clear_cart();
                                    $return['status'] = 'success';
                                    $return['receipt_id'] = $transaction_list_id;
                                    $return['call_function'] = 'success_process_sale';
                                }
                                else
                                {
                                    $return['status'] = 'error';
                                    $return['status_message'] = $$transaction_receipt_list_id;
                                }

                            }
                            else
                            {
                                $return['status'] = 'error';
                                $return['status_message'] = $validate;                                
                            }
                        }
                        else
                        {
                            $return['status'] = 'error';
                            $return['status_message'] = $validate;
                        }
                    }
                }
                else
                {
                    $return['status'] = 'error';
                    $return['status_message'] = $validate;
                }
            }
            else
            {
                $return['status'] = 'error';
                $return['status_message'] = 'Please Select Customer';
            }
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = 'CART IS EMPTY';
        }

        return json_encode($return);
    }
}