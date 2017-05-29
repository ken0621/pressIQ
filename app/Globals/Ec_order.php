<?php
namespace App\Globals;
use DB;
use App\Globals\Ec_order;
use App\Globals\Ecom_Product;
use App\Globals\Warehouse;
use App\Globals\Customer;
use App\Globals\Accounting;
use App\Globals\Item_code;
use App\Globals\Membership_code;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_chart_account_type;
use App\Models\Tbl_journal_entry;
use App\Models\Tbl_journal_entry_line;
use App\Models\Tbl_user;
use App\Models\Tbl_ec_order;
use App\Models\Tbl_ec_order_item;
use App\Models\Tbl_position;
use App\Models\Tbl_coupon_code;
use App\Models\Tbl_ec_variant;
use App\Models\Tbl_item;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Crypt;
use Carbon\Carbon;

class Ec_order
{
    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    /**
     * Collecting all the details of order from the ecommerce front and pass it on create_ec_order
     *
     * @param  array    $order_info
     * @return array
     */
    public static function create_ec_order_automatic($order_info)
    {
        // dd($order_info);
        if($order_info['customer_id'] == null)
        {
            $customer_id = Customer::createCustomer($order_info['shop_id'] ,$order_info['customer']);
        }
        else
        {
            $customer_id = $order_info['customer_id'];
        }

        $data['shop_id']           = $order_info['shop_id'];
        $data['inv_customer_id']   = $customer_id;
        $data['inv_customer_email']= $order_info['customer']['customer_email'];

        $data['inv_terms_id']  = '';
        $data['inv_date']      = '';
        $data['inv_due_date']  = '';
        $data['inv_customer_billing_address']   = $order_info['customer']['customer_address']." ".$order_info['customer']['customer_city']." ".$order_info['customer']['customer_state_province'];

        $data['inv_message']          = '';
        $data['inv_memo']             = '';
        $data['ewt']                  = 0;
        $data['inv_discount_type']    = '';
        $data['inv_discount_value']   = 0;
        $data['invline_service_date'] = $order_info['invline_service_date'];
        $data['invline_item_id']      = $order_info['invline_item_id'];
        $data['invline_description']  = $order_info['invline_description'];
        $data['invline_qty']          = $order_info['invline_qty'];
        $data['invline_rate']         = $order_info['invline_rate'];
        $data['invline_discount']     = $order_info['invline_discount'];
        $data['invline_discount_remark'] = $order_info['invline_discount_remark'];
        $data['payment_method_id']    = $order_info['payment_method_id'];
        $data['coupon_code']          = 0;

        $data['ec_order_load']        = $order_info["ec_order_load"];
        $data['ec_order_load_number'] = $order_info["ec_order_load_number"];
        $data['taxable']              = $order_info['taxable'];
        $data['order_status']         = $order_info['order_status'];
        $data['payment_status']       = isset($order_info['payment_status']) ? $order_info['payment_status'] : 0;

        $order_id = Ec_order::create_ec_order($data);

        $update['ec_order_slot_id'] = Ec_order::get_slot_id_session();
        $update["payment_upload"] = isset($order_info['payment_upload']) ? $order_info['payment_upload'] : '';
        $image_id = Tbl_ec_order::where("ec_order_id", $order_id)->update($update);
        
        $order_info['customer_id'] = $customer_id;
        Ec_order::create_merchant_school_item($order_info, $order_id);
        


        $return["status"]           = "success";
        $return["order_id"]         = $order_id;

        return $return;
    }
    public static function create_merchant_school_item($order_info, $order_id)
    {
        if($order_info['ec_order_merchant_school'] >= 1)
        {
            foreach($order_info['merchant_school_i_id'] as $key => $value)
            {
                // $insert['merchant_school_s_id'] = $order_info['merchant_school_s_id'][$key];
                // $insert['merchant_school_s_name'] = $order_info['merchant_school_s_name'][$key];
                $item = Tbl_item::where('item_id', $value)->first();
                if($item)
                {
                    $insert['merchant_school_i_amount'] = $item->item_price;
                }
                
                $insert['merchant_school_item_shop'] = $order_info['shop_id'];
                $insert['merchant_item_item_id'] = $value;
                $insert['merchant_item_ec_order_id'] = $order_id;
                $insert['merchant_item_customer_id'] = $order_info['customer_id'];

                // $insert['merchant_item_slot_id'] = ;
                $insert['merchant_item_code'] = Membership_code::random_code_generator(8);;
                $insert['merchant_item_pin'] = DB::table('tbl_merchant_school_item')->count() + 1;

                $insert['merchant_item_date'] = Carbon::now();
                $insert['merchant_item_status'] = 0;
                // dd($insert);
                DB::table('tbl_merchant_school_item')->insert($insert);
            }
        }
    }
	public static function create_ec_order($data)
	{
        $_itemline                          = $data['invline_item_id'];
        $prod_total_disc                    = 0;
        $prod_total                         = 0;
        $ec_order_total                     = 0;
        $ec_total                           = 0;
        $vat_total                          = 0;

        foreach($_itemline as $key => $item_line)
        {
            if($item_line)
            {
                if (preg_match("/%/", $data["invline_discount"][$key], $matches)) 
                {

                    $disc_amount = preg_replace('/[&%$]+/', '-', $data["invline_discount"][$key]);
                    $disc_type   = "percent"; 
                }
                else
                {
                    $disc_amount = $data["invline_discount"][$key];
                    $disc_type   = "fixed";
                }

                if($disc_type == "percent")
                {
                    $total_amt       = $data["invline_rate"][$key] * $data["invline_qty"][$key] - (($data["invline_rate"][$key] * $data["invline_qty"][$key])*($disc_amount/100));  
                    $prod_total_disc = $prod_total_disc + (($data["invline_rate"][$key] * $data["invline_qty"][$key])*($disc_amount/100)); 
                }
                else if($disc_type == "fixed")
                {
                    $total_amt = ($data["invline_rate"][$key] * $data["invline_qty"][$key]) - $disc_amount;  
                    $prod_total_disc = $prod_total_disc + $disc_amount;
                }

                $ec_order_item[$key]["item_id"]              = $data['invline_item_id'][$key];         
                $ec_order_item[$key]["price"]                = $data["invline_rate"][$key];      
                $ec_order_item[$key]["quantity"]             = $data["invline_qty"][$key];          
                $ec_order_item[$key]["subtotal"]             = $data["invline_rate"][$key] * $data["invline_qty"][$key];          
                $ec_order_item[$key]["discount_amount"]      = $disc_amount;                
                $ec_order_item[$key]["discount_type"]        = $disc_type;             
                $ec_order_item[$key]["remark"]               = $data["invline_discount_remark"][$key];          
                $ec_order_item[$key]["total"]                = $total_amt;  
                $ec_order_item[$key]["description"]          = $data["invline_description"][$key];              
                $ec_order_item[$key]["service_date"]         = $data["invline_service_date"][$key];              
                $ec_order_item[$key]["tax"]                  = isset($data['invline_taxable']) ? $data['invline_taxable'][$key] : 0;  

                $prod_total                                  = $prod_total + $total_amt;


                if (isset($data['invline_taxable'])) 
                {
                    if($data['invline_taxable'][$key] == 1)
                    {
                        $vat_total = $vat_total + ($total_amt * .12);
                    }
                }
            }
        }

        /* SET INFORMATION FOR EC ORDER */
        $coupon_id          = null;
        $coupon_disc_amount = 0;
        $coupon_disc_type   = "fixed";
        $ec_total           = $prod_total;
        $check_coupon = Tbl_coupon_code::where("coupon_code",$data["coupon_code"])->first();

        if($check_coupon)
        {
            if($check_coupon->used == 0 && $check_coupon->blocked == 0)
            {
                $coupon_id = $check_coupon->coupon_code_id;
                $coupon_disc_amount = $check_coupon->coupon_code_amount;
                $coupon_disc_type = $check_coupon->coupon_discounted;

                if($coupon_disc_type == "percentage")
                {
                    $coupon_disc_type = "percent";
                    $ec_total = $ec_total - ($prod_total*($coupon_disc_amount/100));
                }
                else if($coupon_disc_type == "fixed")
                {
                    $ec_total = $ec_total - $coupon_disc_amount;
                }

                $update_coupon["used"] = 1;
                Tbl_coupon_code::where("coupon_code",$data["coupon_code"])->update($update_coupon);
            }
        }

        if($data["inv_discount_type"] == "percent")
        {
            $ec_disc_type   = "percent";
            $ec_disc_amount = $data["inv_discount_value"];
        }
        else
        {
            $ec_disc_type   = "fixed";
            $ec_disc_amount = $data["inv_discount_value"];
        }

        if($ec_disc_amount != 0)
        {
            if($ec_disc_type == "fixed")
            {
                $ec_total = $ec_total - $ec_disc_amount;
            }
            else if($ec_disc_type == "percent")
            {
                $ec_total = $ec_total - ($prod_total*($ec_disc_amount/100));
            }
        }

        if($data["ewt"] != 0)
        {
            $ec_total = $ec_total - ($prod_total*$data["ewt"]);
        }

        if($data["taxable"] == 1)
        {
            $ec_total = $ec_total + $vat_total;
        }

        if(isset($data["ec_order_load"]))
        {
            $ec_order['ec_order_load']                  = $data["ec_order_load"];
            $ec_order['ec_order_load_number']           = $data["ec_order_load_number"];
        }

        $ec_order['customer_id']                    = $data["inv_customer_id"];
        $ec_order['customer_email']                 = $data["inv_customer_email"];
        $ec_order['billing_address']                = $data["inv_customer_billing_address"];
        $ec_order['invoice_date']                   = datepicker_input($data["inv_date"]);
        $ec_order['due_date']                       = datepicker_input($data["inv_due_date"]);
        $ec_order['invoice_message']                = $data["inv_message"];
        $ec_order['order_status']                   = $data["order_status"];
        $ec_order['payment_method_id']              = $data["payment_method_id"];
        $ec_order['payment_status']                 = $data["payment_status"];
        $ec_order['statement_memo']                 = $data["inv_memo"];
        $ec_order['subtotal']                       = $prod_total;
        $ec_order['ewt']                            = $data["ewt"];
        $ec_order['discount_amount_from_product']   = $prod_total_disc;
        $ec_order['discount_amount']                = $ec_disc_amount;
        $ec_order['discount_type']                  = $ec_disc_type;
        $ec_order['discount_coupon_amount']         = $coupon_disc_amount;
        $ec_order['discount_coupon_type']           = $coupon_disc_type;
        $ec_order['total']                          = $ec_total;
        $ec_order['tax']                            = $data["taxable"];
        $ec_order['coupon_id']                      = $coupon_id;
        $ec_order['term_id']                        = isset($data["inv_terms_id"]) ? $data["inv_terms_id"] : '';
        $ec_order['shop_id']                        = isset($data["shop_id"]) ? $data["shop_id"] : Ec_order::getShopId();
        $ec_order['created_date']                   = Carbon::now();
        $ec_order['archived']                       = 0;


        if($ec_order["order_status"] == "Processing" || $ec_order["order_status"] == "Completed" || $ec_order["order_status"] == "On-hold")
        {
            $warehouse_id = Ecom_Product::getWarehouseId();
            $ctr = 0;
            
            foreach($ec_order_item as $ordered)
            {  
                $get_prod_id                                   = Tbl_ec_variant::where("evariant_id",$ordered["item_id"])->first();
                $check_type                                    = Tbl_item::where("item_id",$get_prod_id->evariant_item_id)->first();
                if($check_type->item_type_id == 1)
                {
                    $warehouse_consume_product[$ctr]["product_id"] = $get_prod_id->evariant_item_id;             
                    $warehouse_consume_product[$ctr]["quantity"]   = $ordered["quantity"];
                    $ctr++;             
                }
            }

            if($ctr != 0)
            {
                $warehouse_consume_remarks  = "";                                                            
                $warehouse_consumer_id      = $ec_order["customer_id"];                          
                $warehouse_consume_reason   = "";                              
                $return_type                = "array";              
                $warehouse_response         = Warehouse::inventory_consume($warehouse_id, $warehouse_consume_remarks, $warehouse_consume_product, $warehouse_consumer_id, $warehouse_consume_reason, $return_type);

                if($warehouse_response["status"] == "error")
                {
                    return $warehouse_response;
                }
            }
        }

        $ec_order_id 								= Tbl_ec_order::insertGetId($ec_order);

       	Ec_order::create_ec_order_item($ec_order_id,$ec_order_item);

       	return $ec_order_id;
	}

	public static function create_ec_order_item($ec_order_id,$ec_order_item)
	{  
		foreach($ec_order_item as $ordered)
		{
			 $insert_item["item_id"]            = $ordered["item_id"];
			 $insert_item["price"]              = $ordered["price"];
			 $insert_item["quantity"]           = $ordered["quantity"];
			 $insert_item["subtotal"]           = $ordered["subtotal"];
			 $insert_item["discount_amount"]    = $ordered["discount_amount"];
			 $insert_item["discount_type"]      = $ordered["discount_type"];
			 $insert_item["remark"]             = $ordered["remark"];
			 $insert_item["total"]              = $ordered["total"];
			 $insert_item["description"]        = $ordered["description"];
			 $insert_item["service_date"]       = $ordered["service_date"];
			 $insert_item["tax"]                = $ordered["tax"];
			 $insert_item["ec_order_id"]        = $ec_order_id;
			 Tbl_ec_order_item::insert($insert_item);
		}
	}

	public static function update_ec_order($data)
	{
        $ec_order_id             = $data["ec_order_id"];
        $update['order_status']  = $data["order_status"];
        $update['payment_status'] = $data["payment_status"];
        $update["payment_upload"] = isset($data['payment_upload']) ? $data['payment_upload'] : '';
        $order_status            = $data["order_status"];
        $shop_id                 = isset($data["shop_id"]) ? $data["shop_id"] : null ;
        $order                   = Tbl_ec_order::where("ec_order_id",$ec_order_id)->first();
        $response                = "nothing";

        if($order->order_status == "Pending" || $order->order_status == "Failed" || $order->order_status == "Cancelled")
        {
            if($order_status == "Processing")
            {
                $response = Ec_order::update_inventory("deduct",$ec_order_id,$shop_id);
            }
            else if($order_status == "Completed")
            {
                $response = Ec_order::update_inventory("deduct",$ec_order_id,$shop_id);  
            }
            else if($order_status == "Shipped")
            {
                $response = Ec_order::update_inventory("deduct",$ec_order_id,$shop_id);   
            }
            else if($order_status == "On-hold")
            {
                $response = Ec_order::update_inventory("deduct",$ec_order_id,$shop_id);
            }
        }
        else if($order->order_status == "Processing" || $order->order_status == "Completed" || $order->order_status == "On-hold" || $order->order_status == "Shipped")
        {
            if($order_status == "Pending")
            {
                $response = Ec_order::update_inventory("add",$ec_order_id,$shop_id);
            }
            else if($order_status == "Failed")
            {
                $response = Ec_order::update_inventory("add",$ec_order_id,$shop_id);   
            }
            else if($order_status == "Cancelled")
            {
                $response = Ec_order::update_inventory("add",$ec_order_id,$shop_id);
            }
        }

        if($order_status == "Completed")
        {
            if($update['payment_status'] == 0)
            {
                $response                    = null;
                $response['status']          = "error";
                $response['status_message']  = "Cannot Complete Order with unpaid status";
                return $response;
            }
            else{
                Item_code::completed_order_action($ec_order_id);
            }
        }


        if(isset($response["status"]))
        { 
            if($response["status"] == "error")
            {
                return $response;
            }
            else
            {
                Tbl_ec_order::where("ec_order_id",$ec_order_id)->update($update);

                if($order_status == "Completed")
                {
                    $_order = Tbl_ec_order::where("ec_order_id", $ec_order_id)->first();
                    /* TRANSACTION JOURNAL */  
                    $entry["reference_module"]  = "product-order";
                    $entry["reference_id"]      = $ec_order_id;
                    $entry["name_id"]           = $_order->customer_id;
                    $entry["total"]             = $_order->total;

                    $_order_item = Tbl_ec_order_item::where("ec_order_id", $ec_order_id)->get();

                    foreach($_order_item as $key=>$item)
                    {
                        $entry_data[$key]['item_id']            = $item->item_id;
                        $entry_data[$key]['entry_qty']          = $item->quantity;
                        $entry_data[$key]['vatable']            = 0;
                        $entry_data[$key]['discount']           = $item->discount_amount;
                        $entry_data[$key]['entry_amount']       = $item->total;
                        $entry_data[$key]['entry_description']  = $item->description;
                    }

                    $product_order_journal = Accounting::postJournalEntry($entry, $entry_data);
                }
                
                return $response; 
            }
        }
        else
        {
            if($order_status == "Completed")
            {
                $_order = Tbl_ec_order::where("ec_order_id", $ec_order_id)->first();
                /* TRANSACTION JOURNAL */  
                $entry["reference_module"]  = "product-order";
                $entry["reference_id"]      = $ec_order_id;
                $entry["name_id"]           = $_order->customer_id;
                $entry["total"]             = $_order->total;

                $_order_item = Tbl_ec_order_item::where("ec_order_id", $ec_order_id)->get();

                foreach($_order_item as $key=>$item)
                {
                    $entry_data[$key]['item_id']            = $item->item_id;
                    $entry_data[$key]['entry_qty']          = $item->quantity;
                    $entry_data[$key]['vatable']            = 0;
                    $entry_data[$key]['discount']           = $item->discount_amount;
                    $entry_data[$key]['entry_amount']       = $item->total;
                    $entry_data[$key]['entry_description']  = $item->description;
                }

                $product_order_journal = Accounting::postJournalEntry($entry, $entry_data);
            }

            Tbl_ec_order::where("ec_order_id",$ec_order_id)->update($update);
            $response           = null;
            $response["status"] = "success";
            return $response;
        }
	}

    public static function update_inventory($type,$ec_order_id, $shop_id)
    {
        $ec_order     = Tbl_ec_order::where("ec_order_id",$ec_order_id)->first();
        $warehouse_id = Ecom_Product::getWarehouseId($shop_id);
        if($type == "deduct")
        {
            $ec_order_item = Tbl_ec_order_item::where("ec_order_id",$ec_order_id)->get();
            $ctr = 0;
            foreach($ec_order_item as $ordered)
            {  
                $get_prod_id                                   = Tbl_ec_variant::where("evariant_id",$ordered->item_id)->first();
                $check_type                                    = Tbl_item::where("item_id",$get_prod_id->evariant_item_id)->first();
                if($check_type->item_type_id == 1)
                {    
                    $warehouse_consume_product[$ctr]["product_id"] = $get_prod_id->evariant_item_id;             
                    $warehouse_consume_product[$ctr]["quantity"]   = $ordered->quantity;
                    $ctr++;             
                }
            }


            if($ctr != 0)
            {
                $warehouse_consume_remarks  = "";                                                            
                $warehouse_consumer_id      = $ec_order->customer_id;                          
                $warehouse_consume_reason   = "";                              
                $return_type                = "array";              
                $data                       = Warehouse::inventory_consume($warehouse_id, $warehouse_consume_remarks, $warehouse_consume_product, $warehouse_consumer_id, $warehouse_consume_reason, $return_type);
                return $data;
            }
        }
        else if($type == "add")
        {
            $ec_order_item = Tbl_ec_order_item::where("ec_order_id",$ec_order_id)->get();
            $ctr = 0;
            foreach($ec_order_item as $ordered)
            { 
                $get_prod_id                                   = Tbl_ec_variant::where("evariant_id",$ordered->item_id)->first();
                $check_type                                    = Tbl_item::where("item_id",$get_prod_id->evariant_item_id)->first();

                if($check_type->item_type_id == 1)
                {   
                    $get_prod_id                                   = Tbl_ec_variant::where("evariant_id",$ordered->item_id)->first();
                    $warehouse_refill_product[$ctr]["product_id"]  = $get_prod_id->evariant_item_id;            
                    $warehouse_refill_product[$ctr]["quantity"]    = $ordered->quantity;
                    $ctr++;             
                }
            }

            if($ctr != 0)
            {
                $warehouse_reason_refill  = "";  
                $warehouse_refill_source  = $ec_order_id;  
                $warehouse_remarks        = "";    
                $return_type              = "array";             
                $data                     = Warehouse::inventory_refill($warehouse_id, $warehouse_reason_refill, $warehouse_refill_source, $warehouse_remarks, $warehouse_refill_product, $return_type);
                

                return $data;
            } 

        }
    }

    public static function get_slot_id_session()
    {
        if(Session::get('mlm_member') != null)
        {
            $session = Session::get('mlm_member');
            if($session['slot_now'])
            {
                return $session['slot_now']->slot_id;
            }
        }
    }

    public static function create_ec_order_from_cart($order_info)
    {
        if($order_info["customer_id"])
        {
            $customer_id = $order_info["customer_id"];
        }
        else
        {
            $customer_id = $order_info["tbl_customer"]["customer_id"]; 
        }

        /* Check if Customer Account Exist */
        $customer_query = DB::table("tbl_customer")->where("customer_id", $customer_id);
        $customer = $customer_query->first();

        if ($customer) 
        {
            if (!DB::table("tbl_customer_other_info")->where("customer_id", $customer_id)->first()) 
            {
                $customer_mobile = $order_info["tbl_customer"]["customer_contact"];
                $other_insert["customer_mobile"] = $customer_mobile;
                $other_insert["customer_id"]     = $customer_id;
       
                DB::table("tbl_customer_other_info")->insert($other_insert);
            }

            $customer_other_info = DB::table("tbl_customer_other_info")->where("customer_id", $customer_id)->first();

            $order_info["tbl_customer"]["customer_id"] = $customer->customer_id;
            $order_info["tbl_customer"]["first_name"] = $customer->first_name;
            $order_info["tbl_customer"]["last_name"] = $customer->last_name;
            $order_info["tbl_customer"]["middle_name"] = $customer->middle_name;
            $order_info["tbl_customer"]["email"] = $customer->email;
            $order_info["tbl_customer"]["password"] = $customer->password;
            $order_info["tbl_customer"]["customer_mobile"] = $customer_other_info->customer_mobile;
            $order_info["tbl_ec_order"]["customer_id"] = $customer->customer_id;
        }
        else
        {
            unset($order_info["tbl_customer"]["customer_id"]);
            $customer_mobile = $order_info["tbl_customer"]["customer_contact"];
            unset($order_info["tbl_customer"]["customer_contact"]);
            $order_info["tbl_customer"]["middle_name"] = "";
            $order_info["tbl_customer"]["password"] = Crypt::encrypt($order_info["tbl_customer"]["password"]);
            $customer_id = $customer_query->insertGetId($order_info["tbl_customer"]);
            
            if (!DB::table("tbl_customer_other_info")->where("customer_id", $customer_id)->first()) 
            {
                $other_insert["customer_mobile"] = $customer_mobile;
                $other_insert["customer_id"]     = $customer_id;
                DB::table("tbl_customer_other_info")->insert($other_insert);
            }
        }

        /* Check if Customer Address Exist to Update if not Insert */
        foreach ($order_info["tbl_customer_address"] as $key => $value) 
        {
            $value["customer_id"]      = $customer_id;
            $value["customer_zipcode"] = $value["customer_zip_code"];
            $value["purpose"]          = $key;
            unset($value["customer_zip_code"]);
            $query = DB::table("tbl_customer_address")->where("customer_id", $customer_id)->where("purpose", $value["purpose"]);
            $customer_address = $query->first();
            
            if ($customer_address) 
            {
                $query->update($value);
            }
            else
            {
                $query->insert($value);
            }
        }

        /* Insert Order */
        unset($order_info["tbl_ec_order"]["ec_order_id"]);
        $order_info["tbl_ec_order"]["customer_id"] = $customer_id;
        $order_info["tbl_ec_order"]["discount_coupon_amount"] = $order_info["tbl_ec_order"]["discount_coupon_amount"] ? $order_info["tbl_ec_order"]["discount_coupon_amount"] : 0;
        $order_info["tbl_ec_order"]["discount_coupon_type"] = $order_info["tbl_ec_order"]["discount_coupon_type"] ? $order_info["tbl_ec_order"]["discount_coupon_type"] : "fixed";
        $order_info["tbl_ec_order"]["ec_order_id"] = DB::table("tbl_ec_order")->insertGetId($order_info["tbl_ec_order"]);

        /* Insert Order Item */
        foreach ($order_info["tbl_ec_order_item"] as $key => $value) 
        {
            $order_info["tbl_ec_order_item"][$key]["ec_order_id"] = $order_info["tbl_ec_order"]["ec_order_id"];
            DB::table("tbl_ec_order_item")->insert($value);
        }

        return $order_info["tbl_ec_order"]["ec_order_id"];
    }
}