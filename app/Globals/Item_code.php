<?php
namespace App\Globals;

use App\Models\Tbl_item;
use App\Models\Tbl_item_code;
use App\Models\Tbl_item_code_invoice;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_mlm_gc;
use App\Models\Tbl_item_code_item;
use App\Models\Tbl_inventory_serial_number;
use App\Models\Tbl_mlm_plan_setting;
use App\Globals\Mlm_voucher;
use App\Globals\Item;
use App\Globals\Item_code;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_gc;
use App\Globals\AuditTrail;
use App\Globals\Mlm_slot_log;

use Session;
use Carbon\Carbon;
use Validator;
use App\Models\Tbl_email_template;
use App\Globals\EmailContent;
use Mail;
class Item_code
{
	public static function add_code($data,$shop_id)
	{ 
	   // $shop_id                                                 = $this->user_info->shop_id;

        $go_serial = 0;
        if(isset($data['item_serial_enable']))
        {
            if(isset($data['item_serial']))
            {
                foreach($data["item_id"] as $key => $value)
                {
                    if(isset($data['item_serial'][$value]))
                    {
                        foreach($data['item_serial'][$value] as $key2 => $value2)
                        {
                            $check_serial = Tbl_inventory_serial_number::where('serial_number', $value2)->where('item_consumed', 0)->count();
                            if($check_serial >= 1)
                            {
                                $check_serial_first = Tbl_inventory_serial_number::where('serial_number', $value2)->where('item_consumed', 0)->first();
                                // return $check_serial_first;
                                if($check_serial_first->item_id == $value)
                                {
                                    $go_serial = 1;
                                }
                                else
                                {
                                    $send['response_status']      = "warning";
                                    $send['warning_validator'][0] = "Sorry, the serial : " . $value2 . ' does not belong to the item.';
                                    return $send;
                                }
                            }
                            else
                            {
                                $send['response_status']      = "warning";
                                $send['warning_validator'][0] = "Sorry, we can't find the serial : " . $value2;
                                return $send;
                            }
                        }
                    }
                    
                }
            }
            else
            {

            }
        }

        if(!isset($data["customer_id"]))
        {
            if(!isset($data["slot_id"]))
            {
                if(!isset($data['discount_card_log_id']))
                {
                    $send['response_status']      = "warning";
                    $send['warning_validator'][0] = "Invalid Customer/Slot/Discount Card";
                    return $send;
                }
                else
                {
                    $slot = Tbl_mlm_discount_card_log::where('discount_card_log_id', $data['discount_card_log_id'])->pluck('discount_card_membership');
                    $insert['slot_id'] = Tbl_mlm_discount_card_log::where('discount_card_log_id', $data['discount_card_log_id'])->pluck('discount_card_slot_sponsor'); 
                    $insert['discount_card_log_id'] = $data['discount_card_log_id'];
                }
            }
            else
            {
                $slot = Tbl_mlm_slot::where('slot_id', $data["slot_id"])->pluck('slot_membership');
                $insert['slot_id'] = $data["slot_id"];
            }
        }
        else
        {
            if($data["slot_id"] == null)
            {
                if($data['discount_card_log_id'] == null)
                {
                    $send['response_status']      = "warning";
                    $send['warning_validator'][0] = "Invalid Customer/Slot/Discount Card";
                    return $send;
                }
                else
                {
                    $slot = Tbl_mlm_discount_card_log::where('discount_card_log_id', $data['discount_card_log_id'])->pluck('discount_card_membership');
                    $insert['slot_id'] = Tbl_mlm_discount_card_log::where('discount_card_log_id', $data['discount_card_log_id'])->pluck('discount_card_slot_sponsor'); 
                    $insert['discount_card_log_id'] = $data['discount_card_log_id'];

                    $dis = Tbl_mlm_discount_card_log::where('discount_card_log_id', $data['discount_card_log_id'])->first();
                    if($dis->discount_card_log_is_expired == 1)
                    {
                        $send['response_status']      = "warning";
                        $send['warning_validator'][0] = "Discount Card Is Already Expired";
                        return $send; 
                    }
                }
            }
            else
            {
                $slot = Tbl_mlm_slot::where('slot_id', $data["slot_id"])->pluck('slot_membership');
                $insert['slot_id'] = $data["slot_id"];
            }
        }
        if(!isset($data["item_code_customer_email"]))
        {
            $send['response_status']      = "warning";
            $send['warning_validator'][0] = "Email is required";
            return $send;
        }
        $gc = 0;
        $gc_amount = 0;
        $wallet = 0;
        $wallet_amount = 0;
        if(isset($data['use_wallet']))
        {
            if($data['use_wallet'] == 'on')
            {
                if(isset($data["slot_id"]))
                {
                    $wallet = 1;
                    $wallet_amount = Mlm_slot_log::get_sum_wallet($data["slot_id"]);
                }
                else
                {
                    $send['response_status']      = "warning";
                    $send['warning_validator'][0] = "No Slot/Discount Card Selected";
                    return $send;
                }
            }
        }
        if(isset($data['use_gc']))
        {
            if($data['use_gc'] == 'on')
            {
                if($data['gc_code'] != null)
                {
                    $gc = Tbl_mlm_gc::where('mlm_gc_code', $data['gc_code'])->first();
                    if(isset($gc->mlm_gc_slot))
                    {
                        if($data["slot_id"] == $gc->mlm_gc_slot)
                        {
                            if($gc->mlm_gc_used == 0)
                            {
                                $update_gc['mlm_gc_used'] = 1;
                                $update_gc['mlm_gc_used_date'] = Carbon::now();
                                $gc_amount = $gc->mlm_gc_amount;
                                $gc = 1;
                            }
                            else
                            {
                                $send['response_status']      = "warning";
                                $send['warning_validator'][0] = "GC, Already Used.";
                                return $send;
                            }
                            
                        }
                        else
                        {
                            $send['response_status']      = "warning";
                            $send['warning_validator'][0] = "GC, does not belong to the account.";
                            return $send;
                        }
                    }
                    else
                    {
                        $send['response_status']      = "warning";
                        $send['warning_validator'][0] = "Invalid GC Code";
                        return $send;
                    }
                    
                }
                else
                {
                    $send['response_status']      = "warning";
                    $send['warning_validator'][0] = "Invalid GC Code";
                    return $send;
                }
            }
        }
        if($gc  ==1 && $wallet == 1)
        {
            $send['response_status']      = "warning";
            $send['warning_validator'][0] = "Can't Use Wallet and GC at the Same Time";
            return $send;
        }
        $insert['customer_id']                             = $data["customer_id"];
        $insert['item_code_customer_email']                = $data["item_code_customer_email"];
        $insert['item_code_paid']                          = $data["item_code_paid"];
        $insert['item_code_product_issued']                = $data["item_code_product_issued"];
        $insert['item_code_date_created']                  = Carbon::now();
        $insert['shop_id']                                 = $shop_id;
        // $insert['slot_id']                                 = $data["slot_id"];
        $discount_card_log_id = $data['discount_card_log_id'];

        $rules['customer_id']                              = 'required|exists:tbl_customer,customer_id|';
        $rules['item_code_customer_email']                 = 'required|email';
        $rules['item_code_paid']                           = 'required|between:0,1';
        $rules['item_code_product_issued']                 = 'required|between:0,1';   
        // $rules['slot_id']                                  = 'required|exists:tbl_mlm_slot,slot_id';

        $messages['customer_id.required']                  = 'Customer is required.';
        $messages['customer_id.exists']                    = 'Something wrong on customers list.';
        // $messages['slot_id.exists']                         = 'Slot Does not Exists';
        $messages['item_code_customer_email.required']     = 'Customer email is required.'; 
        $messages['item_code_customer_email.email']        = 'Please use a proper format for customer email.';
        $messages['item_code_paid.required']               = 'Something wrong on product code paid.';
        $messages['item_code_paid.between']                = 'Something wrong on product code paid.';
        $messages['item_code_product_issued.required']     = 'Something wrong on product code issued.';
        $messages['item_code_product_issued.between']      = 'Something wrong on product code issued.';
        
        $item_subtotal            = 0;
        $item_total               = 0;
        $item_discount            = 0;
        $item_discount_percentage = 0;

        
    	$validator = Validator::make($insert,$rules,$messages);
    	if ($validator->passes())
    	{
    	    if(isset($data["item_id"]) && isset($data["quantity"]))
    	    {
        	    if(count($data["item_id"]) > 0)
        	    {   
        	        $ctr = 0;
        	        $ctr_error = 0;
                    $item_discount_sum = 0;
                    $item_subtotal_sum = 0;
        	        // $slot = Tbl_mlm_slot::where('slot_id', $insert['slot_id'])->pluck('slot_membership');
                    if($data['warehouse_id'] == null)
                    {
                        $send['warning_validator'][$ctr_error] = "Warehouse is required. For inventory";
                        $ctr_error = 1;
                    }
        	        /* SETUP THE VARIABLES FOR INSERTING MEMBERSHIP CODE */
                    $count_on_hand = [];
        	        foreach($data["item_id"] as $key => $item)
        	        {
                        if(isset($count_on_hand[$item]))
                        {
                            $count_on_hand[$item]+= $data["quantity"][$key];
                        }
                        else
                        {
                            $count_on_hand[$item] = $data["quantity"][$key];
                        }
        	            for($generated = 0; $generated < $data["quantity"][$key]; $generated++)
        	            {
        	                
        	                /* FOR ACTIVATION KEY */
        	                $condition = false;
        	                while($condition == false)
        	                {
        	                   $activation_code  = Item_code::random_code_generator(8);
        	                   $check_activation = Tbl_item_code::where("item_activation_code",$activation_code)->first();
        	                   if(!$check_activation)
        	                   {
        	                       $condition = true;
        	                   }
        	                }
        	                
        	                $code_pin                                                = Tbl_item_code::where("item_code_pin",$shop_id)->count() + 1; 
        	                $items                                                   = Tbl_item::where("item_id",$data["item_id"][$key])->where("shop_id",$shop_id)->first();
            	            if(!$items)
            	            {
                                    $send['warning_validator'][$ctr_error] = "Item #".$data["item_id"][$key]." does not exists.";
                                    $ctr_error++;
            	            }
            	            else
            	            {  

                                $item_subtotal                                     = intval($item_subtotal) + intval($items->item_price);
                	            $item_discount                                     = Item::get_discount_only($data["item_id"][$key], $slot);
                                $item_discount_sum += $item_discount;
                                $item_subtotal_sum += $items->item_price;
                                $rel_insert[$ctr]["item_activation_code"]          = $activation_code;
                	            $rel_insert[$ctr]["customer_id"]                   = $data["customer_id"];
                	            $rel_insert[$ctr]["item_id"]                       = $data["item_id"][$key];
                	            $rel_insert[$ctr]["item_code_invoice_id"]          = null;
                	            $rel_insert[$ctr]["shop_id"]                       = $shop_id;
                                $rel_insert[$ctr]["item_code_pin"]                 = $code_pin;
                                $rel_insert[$ctr]["item_code_price"]               = $items->item_price;
                	            $rel_insert[$ctr]["item_code_price_total"]         = $items->item_price;
            	            }
            	            
            	         	$ctr++;
        	            }
        	        }
                    // $send['response_status']      = "warning";
                    // $send['warning_validator'][0] = $count_on_hand;
                    // return $send;
        	        foreach($count_on_hand as $key => $value)
                    {
                        $a = Tbl_warehouse_inventory::check_inventory_single($data['warehouse_id'], $key)->pluck('inventory_count');
                        
                        if(intval($value) > intval($a))
                        {
                            $item = Tbl_item::where('item_id', $key)->first();
                            if($item->item_type_id == 1)
                            {
                                $send['warning_validator'][$ctr_error] = "Item: " . $item->item_name . ' has only ' . $a . ' while ' . $value .' is the stock needed' ;
                                $ctr_error++;
                            }
                            
                        }   
                    }

        	        /* PROCEED IF NO ERROR */
        	        if($ctr_error == 0)
        	        {
                        $insert["item_subtotal"]            = $item_subtotal_sum;
                        $insert["item_total"]               = $item_subtotal_sum - $item_discount_sum;
                        $insert["item_discount"]            = $item_discount_sum;
                        if($gc == 1)
                        {
                            if($gc_amount >= $insert["item_total"])
                            {
                                $insert['item_code_paid'] = 2;
                                $gc = 2;
                            }
                            else
                            {
                                $send['response_status']      = "warning";
                                $send['warning_validator'][0] = 'Gc Amount is only ' . $gc_amount . ' while the needed amount is ' . $insert["item_total"];
                                return $send;
                            }
                        }
                        if($wallet == 1)
                        {
                            if($wallet_amount >= $insert["item_total"])
                            {
                                $insert['item_code_paid'] = 3;
                                $wallet = 2;
                            }
                            else
                            {
                                $send['response_status']      = "warning";
                                $send['warning_validator'][0] = 'Wallet Amount is only ' . $wallet_amount . ' while the needed amount is ' . $insert["item_total"];
                                return $send;
                            }
                        }
                        foreach ($count_on_hand as $key => $value) 
                        {
                            $warehouse_consume_reason = 'Customer ' . $data["customer_id"] . ' bought a product';
                            $iteme = Tbl_item::where('item_id', $key)->first();
                            $item = [];
                            if($iteme->item_type_id == 1)
                            {
                                $s = $key;
                                $d['product_id'] = $iteme->item_id;
                                $item[0]['product_id'] = $iteme->item_id;
                                $item[0]['quantity'] = $value;
                                // dd($item);
                                // dd($data["warehouse_id"]);
                               $a = Warehouse::inventory_consume($data['warehouse_id'], 'Used for consuming of inventory in product code', $item,$data["customer_id"], $warehouse_consume_reason, 'array');
                                if($a['status'] == 'error')
                                {
                                     $send['response_status']      = "warning";
                                     $send['warning_validator'][0] = $a['status_message'];
                                     return $send;
                                }
                            }
                        }

                        

                        $insert["item_discount_percentage"] = (1 - ($insert["item_total"]  / $insert["item_subtotal"])) * 100;


        	            /* INSERTING AREA */
        	            $invoice_id = Tbl_item_code_invoice::insertGetId($insert);
        	            

        	            /* SETUP THE INVOICE ID */
        	            foreach($rel_insert as $key => $item_code_invoice_id)
        	            {
        	                $rel_insert[$key]["item_code_invoice_id"] = $invoice_id;
                            $rel_insert[$key]["slot_id"] = $insert['slot_id'];

                            // item_id
        	            }
        	            Tbl_item_code::insert($rel_insert);
        	            
                        $items = Tbl_item_code::where('item_code_invoice_id', $invoice_id)->get();
                        foreach($items as $key => $value)
                        {
                            $insert_item_per[$value->item_id]['item_id'] =  $value->item_id;
                            $item = Tbl_item::where('item_id', $value->item_id)->first();
                            if($item)
                            {
                                $insert_item_per[$value->item_id]['item_name'] = $item->item_name;
                                $insert_item_per[$value->item_id]['item_price'] = $item->item_price;  
                                $insert_item_per[$value->item_id]['item_code_invoice_id'] = $invoice_id;
                                $insert_item_per[$value->item_id]['item_code_id'] = $value->item_code_id;

                                if($go_serial == 1)
                                {
                                     $insert_item_per[$value->item_id]['item_serial'] = null;
                                     if(isset($data['item_serial'][$value->item_id]))
                                     {
                                        foreach($data['item_serial'][$value->item_id] as $key2 => $value2)
                                        {
                                            if($insert_item_per[$value->item_id]['item_serial'] == null)
                                            {
                                                $insert_item_per[$value->item_id]['item_serial'] .= $value2;
                                            }
                                            else
                                            {
                                                $insert_item_per[$value->item_id]['item_serial'] .= ', '. $value2;
                                            }
                                            $update_serail['item_consumed'] = 1;
                                            $update_serail['sold'] = 1;
                                            Tbl_inventory_serial_number::where('serial_number', $value2)->where('item_consumed', 0)->update($update_serail);
                                        }
                                    }
                                }
                                if(isset($insert_item_per[$value->item_id]['item_quantity']))
                                {
                                    $insert_item_per[$value->item_id]['item_quantity'] += 1;
                                }
                                else
                                {
                                    $insert_item_per[$value->item_id]['item_quantity'] = 1;
                                }
                            }
                        }
                        Tbl_item_code_item::insert($insert_item_per);
                        
                        Mlm_voucher::give_voucher_prod_code($invoice_id);
                        if($gc == 2)
                        {

                            $update_gc['mlm_gc_used'] = 1;
                            $update_gc['mlm_gc_used_date'] = Carbon::now();
                            Tbl_mlm_gc::where('mlm_gc_code', $data['gc_code'])->update($update_gc);

                            $return = $gc_amount - ($insert["item_total"]);
                            if($return >= 1)
                            {
                                Mlm_gc::return_gc($insert['slot_id'], $data['gc_code'], $return);
                            }
                        }
                        if($wallet == 2)
                        {
                            $log = 'Thank you for purchasing. ' .$insert["item_total"]. ' is deducted to your wallet';
                            $arry_log['wallet_log_slot'] = $insert['slot_id'];
                            $arry_log['shop_id'] = $shop_id;
                            $arry_log['wallet_log_slot_sponsor'] = $insert['slot_id'];
                            $arry_log['wallet_log_details'] = $log;
                            $arry_log['wallet_log_amount'] = ($insert["item_total"]) * (-1);
                            $arry_log['wallet_log_plan'] = "REPURCHASE";
                            $arry_log['wallet_log_status'] = "released";   
                            $arry_log['wallet_log_claimbale_on'] = Carbon::now();
                            Mlm_slot_log::slot_array($arry_log);
                        }

                        if(isset($data['use_item_code_auto']))
                        {
                            if($data['use_item_code_auto'] == 1)
                            {
                                Item_code::use_item_code_all_invoice($invoice_id);
                                Item_code::set_up_email($invoice_id, $shop_id);
                            }
                            else
                            {

                            }
                        }
        	            /* FORGET ALL SESSION FOR PURCHASED ITEM */
        	            Session::forget("sell_codes_session");
                        $send["response_status"] = "success_process";    
                        $send['invoice_id'] = $invoice_id;

                        //audit trail here
                        $item_code_invoice = Tbl_item_code_invoice::where("item_code_invoice_id",$invoice_id)->first()->toArray();
                        AuditTrail::record_logs("Added","mlm_item_code_invoice",$invoice_id,"",serialize($item_code_invoice));
        	        }
        	        else
        	        {
                	    $send['response_status']      = "warning";
        	        }
        	    }
        	    else
        	    {
        	        $send['warning_validator'][0] = "Please add a item to purchase a code.";
        	    }
    	    }
    	    else
    	    {
        	    $send['response_status']      = "warning";
        	    $send['warning_validator'][0] = "Some error ocurred please try again.";
    	    }
    	}
    	else
    	{
    	    $send['response_status']   = "warning";
    	    $send['warning_validator'] = $validator->errors()->all();
    	}
        

        return $send;
	}
	public static function set_up_email($invoice_id, $shop_id)
    {
        $plan_settings = Tbl_mlm_plan_setting::where('shop_id', $shop_id)->first();
        if($plan_settings->plan_settings_email_product_code == 0)
        {
            return 1;
        }

        $invoice = Tbl_item_code_invoice::where('item_code_invoice_id', $invoice_id)
        ->leftjoin('tbl_customer', 'tbl_customer.customer_id','=', 'tbl_item_code_invoice.customer_id')
        ->leftjoin('tbl_customer_other_info','tbl_customer_other_info.customer_id','=','tbl_customer.customer_id')
        ->first();
        if($invoice)
        {
            if(isset($invoice->item_code_invoice_id))
            {
                if($invoice->item_code_customer_email != null)
                {
                    $data['invoice'] = $invoice;
                    $data['item_code'] = Tbl_item_code::where('item_code_invoice_id', $invoice_id)
                    ->get();

                    $change_content[0]["txt_to_be_replace"] = "[product_list]";
                    $change_content[0]["txt_to_replace"] = '<table><tr><td>Item</td><td>Quantity</td></tr>';
                    $data['item_code_item'] = Tbl_item_code_item::where('item_code_invoice_id', $invoice_id)->get();
                    foreach($data['item_code_item'] as $key => $value)
                    {
                        $change_content[0]["txt_to_replace"] .= '<tr><td>'.$value->item_name.'</td><td>'. $value->item_quantity.'</td></tr>';
                    }
                    $change_content[0]["txt_to_replace"] .= '</table>';

                    $change_content[1]["txt_to_be_replace"] = "[product_code]";
                    $change_content[1]["txt_to_replace"] = '<table><tr><td>Product Code</td><td>Pin</td></tr>';
                    foreach($data['item_code'] as $key => $value)
                    {
                        $change_content[1]["txt_to_replace"] .= '<tr><td>'.$value->item_activation_code.' </td><td>'. $value->item_code_id.'</td></tr>';
                    }
                    $change_content[1]["txt_to_replace"] .= '</table>';
                    // dd($change_content);
                    

                    $data["template"] = Tbl_email_template::where("shop_id",$shop_id)->first();

                    $content_key = 'product_repurchase';
                    $data['body'] = EmailContent::email_txt_replace($content_key, $change_content);
                    // return view('emails.full_body', $data);
                    Mail::send('emails.full_body', $data, function ($m) use ($data) {
                    $m->from(env('MAIL_USERNAME'), $_SERVER['SERVER_NAME']);

                    $m->to($data['invoice']->item_code_customer_email, env('MAIL_USERNAME'))->subject('Product Repurchase')->cc('lukeglennjordan2@gmail.com');
                    });
                }
            }
        } 
    }
	public static function random_code_generator($word_limit)
	{
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $word_limit; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
	}
    public static function use_item_code_all_invoice($invoice_id)
    {
        $invoice = Tbl_item_code_invoice::where('item_code_invoice_id', $invoice_id)->first();
        if($invoice)
        {
            $item_code = Tbl_item_code::where('item_code_invoice_id', $invoice_id)->get();
            foreach($item_code as $key => $value)
            {
                $slot_info = Mlm_compute::get_slot_info($invoice->slot_id);
                if($value->used === 0)
                {
                    $a = Item_code::use_item_code_single($value, $slot_info);
                }
            }
        } 
    }
    public static function use_item_code_single($item_code, $slot_info)
    {
        $update["used"]          = 1;
        $update["date_used"]     = Carbon::now();
        $update["used_on_slot"]  = $slot_info->slot_id;
        Tbl_item_code::where('item_code_id', $item_code->item_code_id)->update($update);
        $a = Mlm_compute::repurchase($slot_info, $item_code->item_code_id);
    }
}