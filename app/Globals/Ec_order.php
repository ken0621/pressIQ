<?php
namespace App\Globals;
use DB;
use App\Globals\Ec_order;
use App\Globals\Warehouse;
use App\Globals\Customer;
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

use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Carbon\Carbon;

class Ec_order
{
    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public static function create_ec_order_automatic($order_info)
    {
        $customer_id = Customer::createCustomer($order_info['shop_id'] ,$order_info['customer']);

        $data['shop_id']           = $order_info['shop_id'];
        $data['inv_customer_id']   = $customer_id;;
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

        $data['taxable']              = $order_info['taxable'];
        $data['order_status']         = "Pending";

        $order_id = Ec_order::create_ec_order($data);
        
        $return["status"]           = "success";
        $return["order_id"]         = $order_id;

        return $return;
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

        
        $ec_order['payment_method_id']              = $data["payment_method_id"];
        $ec_order['customer_id']                    = $data["inv_customer_id"];
        $ec_order['customer_email']                 = $data["inv_customer_email"];
        $ec_order['billing_address']                = $data["inv_customer_billing_address"];
        $ec_order['invoice_date']                   = $data["inv_date"];
        $ec_order['due_date']                       = $data["inv_due_date"];
        $ec_order['invoice_message']                = $data["inv_message"];
        $ec_order['order_status']                   = $data["order_status"];
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
        $ec_order['term_id']                        = $data["inv_terms_id"];
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
                $warehouse_consume_product[$ctr]["product_id"] = $get_prod_id->evariant_item_id;             
                $warehouse_consume_product[$ctr]["quantity"]   = $ordered["quantity"];
                $ctr++;             
            }

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
        $order_status            = $data["order_status"];
        $order                   = Tbl_ec_order::where("ec_order_id",$ec_order_id)->first();
        $response                = "nothing";

        if($order->order_status == "Pending" || $order->order_status == "Failed" || $order->order_status == "Cancelled")
        {
            if($order_status == "Processing")
            {
                $response = Ec_order::update_inventory("deduct",$ec_order_id);
            }
            else if($order_status == "Completed")
            {
                $response = Ec_order::update_inventory("deduct",$ec_order_id);   
            }
            else if($order_status == "On-hold")
            {
                $response = Ec_order::update_inventory("deduct",$ec_order_id);
            }
        }
        else if($order->order_status == "Processing" || $order->order_status == "Completed" || $order->order_status == "On-hold")
        {
            if($order_status == "Pending")
            {
                $response = Ec_order::update_inventory("add",$ec_order_id);
            }
            else if($order_status == "Failed")
            {
                $response = Ec_order::update_inventory("add",$ec_order_id);   
            }
            else if($order_status == "Cancelled")
            {
                $response = Ec_order::update_inventory("add",$ec_order_id);
            }
        }

        if($response["status"] == "error")
        {
            return $response;
        }
        else
        {
            Tbl_ec_order::where("ec_order_id",$ec_order_id)->update($update);
            return $response; 
        }
	}

    public static function update_inventory($type,$ec_order_id)
    {
        $warehouse_id = Ecom_Product::getWarehouseId();
        $ec_order     = Tbl_ec_order::where("ec_order_id",$ec_order_id)->first();
        if($type == "deduct")
        {
            $ec_order_item = Tbl_ec_order_item::where("ec_order_id",$ec_order_id)->get();
            $ctr = 0;
            foreach($ec_order_item as $ordered)
            {  
                $get_prod_id                                   = Tbl_ec_variant::where("evariant_id",$ordered->item_id)->first();
                $warehouse_consume_product[$ctr]["product_id"] = $get_prod_id->evariant_item_id;             
                $warehouse_consume_product[$ctr]["quantity"]   = $ordered->quantity;
                $ctr++;             
            }

            $warehouse_consume_remarks  = "";                                                            
            $warehouse_consumer_id      = $ec_order->customer_id;                          
            $warehouse_consume_reason   = "";                              
            $return_type                = "array";              
            $data                       = Warehouse::inventory_consume($warehouse_id, $warehouse_consume_remarks, $warehouse_consume_product, $warehouse_consumer_id, $warehouse_consume_reason, $return_type);
            return $data;
        }
        else if($type == "add")
        {
            $ec_order_item = Tbl_ec_order_item::where("ec_order_id",$ec_order_id)->get();
            $ctr = 0;
            foreach($ec_order_item as $ordered)
            {  
                $get_prod_id                                   = Tbl_ec_variant::where("evariant_id",$ordered->item_id)->first();
                $warehouse_refill_product[$ctr]["product_id"]  = $get_prod_id->evariant_item_id;            
                $warehouse_refill_product[$ctr]["quantity"]    = $ordered->quantity;
                $ctr++;             
            }

            $warehouse_reason_refill  = "";  
            $warehouse_refill_source  = $ec_order_id;  
            $warehouse_remarks        = "";    
            $return_type              = "array";             
            $data                     = Warehouse::inventory_refill($warehouse_id, $warehouse_reason_refill, $warehouse_refill_source, $warehouse_remarks, $warehouse_refill_product, $return_type);
            return $data;
        }
    }
}