<?php
namespace App\Globals;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_inventory_serial_number;
use App\Models\Tbl_sub_warehouse;
use App\Models\Tbl_item;
use App\Models\Tbl_inventory_slip;
use App\Models\Tbl_settings;
use App\Models\Tbl_user;
use App\Models\Tbl_user_warehouse_access ;
use App\Globals\Item;
use App\Models\Tbl_unit_measurement_multi;
use DB;
use Carbon\Carbon;
use Session;
class Warehouse
{   
    public static function insert_access($warehouse_id)
    {
        $ins_access["user_id"] = Warehouse::getUserid();
        $ins_access["warehouse_id"] = $warehouse_id;
        Tbl_user_warehouse_access::insert($ins_access);

        $user_position = Tbl_user::position()->where("user_id",Warehouse::getUserid())->pluck("position_rank");

        $all_user = Tbl_user::position()->where("user_shop",Warehouse::getShopId())->where("user_id","!=", Warehouse::getUserid())->where("tbl_user.archived",0)->get();

        foreach ($all_user as $key => $value) 
        {
            if($value->position_rank < $user_position)
            {
                $ins_access["user_id"] = $value->user_id;
                $ins_access["warehouse_id"] = $warehouse_id;
                Tbl_user_warehouse_access::insert($ins_access);
            }
        }
    }
    public static function inventory_input_report($inventory_slip_id)
    {
        $data = Tbl_inventory_slip::shop()->vendor()->warehouse()->where("inventory_slip_shop_id",Warehouse::getShopId())
                                                ->where("tbl_user.user_id",Warehouse::getUserid())
                                                ->where("inventory_slip_id",$inventory_slip_id)
                                                ->first();

        return $data;
    }
    public static function inventory_input_report_item($inventory_slip_id)
    {
        $data = Tbl_warehouse_inventory::inventoryslip()->item()->where("tbl_warehouse_inventory.inventory_slip_id",$inventory_slip_id)->groupBy("tbl_item.item_id")->get();

        foreach ($data as $key => $value) 
        {
            $data[$key]->serial_number_list = Tbl_inventory_serial_number::where("serial_inventory_id",$value->inventory_id)->get();
            $abbrev = Tbl_unit_measurement_multi::where("multi_um_id",$value->item_measurement_id)->where("is_base",1)->pluck("multi_abbrev");
            $data[$key]->multi_abbrev = $abbrev != "" ? $data[$key]->multi_abbrev : '-';
        }
        return $data;
    }
    public static function select_item_warehouse_single($warehouse_id = 0, $return = 'array')
    {
    	$data = Tbl_warehouse::Warehouseitem()
                             ->select_inventory($warehouse_id)
				    		 ->orderBy('product_name','asc')
    						 ->get();
                             
    	if($return == 'json')
    	{
    		$data = json_encode($data);
    	}
    	return $data; 
    }  

    public static function select_item_warehouse_single_vendor($warehouse_id = 0, $return = 'array',$vendor_id)
    {
        $data = Tbl_warehouse::Warehouseitem_vendor($vendor_id)
                             ->select_inventory($warehouse_id)
                             ->orderBy('product_name','asc')
                             ->get();
                             
        if($return == 'json')
        {
            $data = json_encode($data);
        }
        return $data; 
    }
    public static function warehouse_access()
    {
        $warehouse = Tbl_user_warehouse_access::where("user_id",Warehouse::getUserid())->get();

        $return["warehouse_id"] = null;
        foreach ($warehouse as $key => $value) 
        {
            $return["warehouse_id"][$key] = $value->warehouse_id;
        }
        return $return;        
    }

    public static function getUserid()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_id');
    }
    public static function check_inventory_on_warehouse($warehouse_id = 0, $item_id = 0, $return = 'array')
    {
    	$data = Tbl_warehouse::Warehouseitem()
                             ->select_inventory($warehouse_id, $item_id)
    						 ->get();

    	
    	if($return == 'json')
    	{
    		$data = json_encode($data);
    	}
    	return $data;
    }

    public static function inventory_transfer_bulk($source_id = 0, $destination_id = 0, $_info = array(), $remarks = '', $return = 'array')
    {
        $shop_id = Warehouse::get_shop_id($source_id);

        $insert_slip_source['inventory_slip_id_sibling']    = 0;
        $insert_slip_source['inventory_reason']             = 'source';
        $insert_slip_source['warehouse_id']                 = $source_id;
        $insert_slip_source['inventory_remarks']            = $remarks;
        $insert_slip_source['inventory_slip_date']          = Carbon::now();
        $insert_slip_source['inventory_slip_shop_id']       = $shop_id;
        $insert_slip_source['inventory_slip_status']        = 'transfer';
        $insert_slip_source['inventroy_source_reason']      = 'warehouse';
        $insert_slip_source['inventory_slip_consume_refill']= 'consume';

        $inventory_slip_id_source = Tbl_inventory_slip::insertGetId($insert_slip_source);

        $insert_slip_destination['inventory_slip_id_sibling']    = $inventory_slip_id_source;
        $insert_slip_destination['inventory_reason']             = 'destination';
        $insert_slip_destination['warehouse_id']                 = $destination_id;
        $insert_slip_destination['inventory_remarks']            = $remarks;
        $insert_slip_destination['inventory_slip_date']          = Carbon::now();
        $insert_slip_destination['inventory_slip_shop_id']       = $shop_id;
        $insert_slip_destination['inventory_slip_status']        = 'transfer';
        $insert_slip_destination['inventroy_source_reason']      = 'warehouse';
        $insert_slip_destination['inventory_source_id']          = $source_id;
        $insert_slip_destination['inventory_slip_consume_refill']= 'refill';

        $inventory_slip_id_destination = Tbl_inventory_slip::insertGetId($insert_slip_destination);

        $insertsource = '';
        $insertdestination = '';
        $inventory_success = '';
        $inventory_err = '';
        $success = 0;
        $err = 0;
        $err_msg["msg"] ="";

        foreach($_info as $key => $info)
        {
            /**/ 
            $count_on_hand = Tbl_warehouse_inventory::check_inventory_single($source_id, $info['product_id'])->pluck('inventory_count');
            
            if($info['quantity'] > 0 && $count_on_hand > 0 && $count_on_hand >= $info['quantity']) 
            {
                $quantity_source = $info['quantity'] * -1;

                $quantity_destination = $info['quantity'];

                $insertsource[$key]['inventory_item_id']        = $info['product_id'];
                $insertsource[$key]['warehouse_id']             = $source_id;
                $insertsource[$key]['inventory_created']        = Carbon::now();
                $insertsource[$key]['inventory_count']          = $quantity_source;
                $insertsource[$key]['inventory_slip_id']        = $inventory_slip_id_source;

                $insertdestination[$key]['inventory_item_id']   = $info['product_id'];
                $insertdestination[$key]['warehouse_id']        = $destination_id;
                $insertdestination[$key]['inventory_created']   = Carbon::now();
                $insertdestination[$key]['inventory_count']     = $quantity_destination;
                $insertdestination[$key]['inventory_slip_id']   = $inventory_slip_id_destination;

                $inventory_success[$success] = Warehouse::array_tansfer('transfer_success', $info['product_id']);
                $success++;
            }
            else
            {
                $item_name = Item::get_item_details($info['product_id']);
                $err_msg["msg"] .= "The quantity of ".$item_name->item_name." is not enough for your transfer.<br>";
                $inventory_err[$err] = Warehouse::array_tansfer('error', $info['product_id']);
                $err++;
            }     
            
        }

        $data['status'] = '';

        if($inventory_err == "")
        {   
            $data['status']             = 'transfer_success';
            $data['response_status']    = 'transfer_success';
            $data['success']            = $inventory_success;
            $data['error']              = $inventory_err;
            Tbl_warehouse_inventory::insert($insertsource);
            Tbl_warehouse_inventory::insert($insertdestination);
            $data['inventory_slip_id_source']       = $inventory_slip_id_source;
            $data['inventory_slip_id_destination']  = $inventory_slip_id_destination;
        }
        else
        {
            $data['status']             = 'error';
            $data['response_status']    = 'error';
            $data['error']              = $err_msg;
            $data['message'] = $err_msg["msg"];
        }
        $space = '';

        return $data;
    }


    public static function inventory_transfer_single($warehouse_source_id = 0, $warehouse_destination_id = 0, $product_id = 0, $quantity = 0, $return = 'array')
    {
        $info[0]['quantity'] = $quantity;
        $info[0]['product_id'] = $product_id;
        return Warehouse::inventory_transfer_bulk($warehouse_source_id, $warehouse_destination_id, $info, $return);
    }

    /*
    * reason_refill [string accept]
    * vendor
    * other
    */
    public static function inventory_update($transaction_id = 0, $transaction_type = '', $transaction_item_inventory = array(), $return = 'array' )
    {
        //inventory source reason = $transaction_type
        //inventory source id = $transaction_id
        $inventory_slip = Tbl_inventory_slip::where("inventory_source_id",$transaction_id)->where("inventroy_source_reason",$transaction_type)->first();
        
        Tbl_warehouse_inventory::where("inventory_slip_id",$inventory_slip->inventory_slip_id)->delete();

        foreach($transaction_item_inventory as $key2 => $value2)
        {            
            $count = Tbl_warehouse_inventory::check_inventory_single($inventory_slip->warehouse_id, $value2['product_id'])->pluck('inventory_count');
            $count_on_hand = $count + $value2["quantity"];

            if($value2['quantity'] > 0 && $count_on_hand > 0 && $count_on_hand > $value2['quantity'])
            {     
                $insert["inventory_item_id"] = $value2["product_id"];
                $insert["inventory_count"] = $value2["quantity"] * -1;
                $insert["inventory_created"] = Carbon::now();
                $insert["warehouse_id"] = $inventory_slip->warehouse_id;
                $insert["inventory_slip_id"] = $inventory_slip->inventory_slip_id;

                Tbl_warehouse_inventory::insert($insert);
                $data["status"] = "success";
            }
            else
            {
                $data["status"] = "error";
                $data["status_message"] = "The quantity is not enough";
            }
        }


        if($return == 'json')
        {
            $data = json_encode($data);
        }
        return $data;

    }
    public static function adjust_inventory($warehouse_id = 0, $reason_refill = '', $refill_source = 0, $remarks = '', $warehouse_refill_product = array(), $return = 'array', $is_return = null)
    {
        
        $shop_id = Warehouse::get_shop_id($warehouse_id);

        $insert_slip['inventory_slip_id_sibling']    = 0;
        $insert_slip['inventory_reason']             = 'adjust';
        $insert_slip['warehouse_id']                 = $warehouse_id;
        $insert_slip['inventory_remarks']            = $remarks;
        $insert_slip['inventory_slip_date']          = Carbon::now();
        $insert_slip['inventory_slip_shop_id']       = $shop_id;
        $insert_slip['inventory_slip_status']        = 'adjust';
        $insert_slip['inventroy_source_reason']      = $reason_refill;
        $insert_slip['inventory_source_id']          = $refill_source;
        $insert_slip['inventory_slip_consume_refill']= 'adjust';

        $inventory_slip_id = Tbl_inventory_slip::insertGetId($insert_slip);

        $inventory_success = '';
        $inventory_err = '';
        $success = 0;
        $err = 0;
        $insert_refill = '';

        $for_serial_item = '';
        
        if($warehouse_refill_product)
        {
            foreach($warehouse_refill_product as $key => $refill_product)
            {
               
                $insert_refill['inventory_item_id']        = $refill_product['product_id'];
                $insert_refill['warehouse_id']             = $warehouse_id;
                $insert_refill['inventory_created']        = Carbon::now();
                $insert_refill['inventory_count']          = $refill_product['quantity'];
                $insert_refill['inventory_slip_id']        = $inventory_slip_id;

                $inventory_success[$success] = Warehouse::array_tansfer('success', $refill_product['product_id']);
                $success++;

                $inventory_id = Tbl_warehouse_inventory::insertGetId($insert_refill);

                $for_serial_item[$key]["quantity"] = $refill_product['quantity'];
                $for_serial_item[$key]["product_id"] = $refill_product['product_id'];
                $for_serial_item[$key]["inventory_id"] = $inventory_id;
            }
             $data['status'] = '';
            

            // $serial = Tbl_settings::where("settings_key","item_serial")->where("settings_value","enable")->where("shop_id",$shop_id)->first();

            // if($is_return == null)
            // {
            //     if($serial != null)
            //     {
            //         $data['status'] = 'success-serial';

            //         $items["item_id"] = "";
            //         $items["item_list"] = $for_serial_item;
            //         Session::put("item", $items);
            //     }                
            // }

            $data['status'] = 'success'; 
            $data['inventory_slip_id'] = $inventory_slip_id;

        }
        else
        {
            $data['status'] = 'error';
            $data['status_message'] = 'some fields are missing';
        }
       

        $space = '';
        if($return == 'json')
        {
            $data = json_encode($data);
        }
        return $data;
    }
    public static function inventory_refill($warehouse_id = 0, $reason_refill = '', $refill_source = 0, $remarks = '', $warehouse_refill_product = array(), $return = 'array', $is_return = null)
    {
        
        $shop_id = Warehouse::get_shop_id($warehouse_id);

        $insert_slip['inventory_slip_id_sibling']    = 0;
        $insert_slip['inventory_reason']             = 'refill';
        $insert_slip['warehouse_id']                 = $warehouse_id;
        $insert_slip['inventory_remarks']            = $remarks;
        $insert_slip['inventory_slip_date']          = Carbon::now();
        $insert_slip['inventory_slip_shop_id']       = $shop_id;
        $insert_slip['inventory_slip_status']        = 'refill';
        $insert_slip['inventroy_source_reason']      = $reason_refill;
        $insert_slip['inventory_source_id']          = $refill_source;
        $insert_slip['inventory_slip_consume_refill']= 'refill';

        $inventory_slip_id = Tbl_inventory_slip::insertGetId($insert_slip);

        $inventory_success = '';
        $inventory_err = '';
        $success = 0;
        $err = 0;
        $insert_refill = '';

        $for_serial_item = '';
        
        if($warehouse_refill_product)
        {
            foreach($warehouse_refill_product as $key => $refill_product)
            {
               
                $insert_refill['inventory_item_id']        = $refill_product['product_id'];
                $insert_refill['warehouse_id']             = $warehouse_id;
                $insert_refill['inventory_created']        = Carbon::now();
                $insert_refill['inventory_count']          = $refill_product['quantity'];
                $insert_refill['inventory_slip_id']        = $inventory_slip_id;

                $inventory_success[$success] = Warehouse::array_tansfer('success', $refill_product['product_id']);
                $success++;

                $inventory_id = Tbl_warehouse_inventory::insertGetId($insert_refill);

                $for_serial_item[$key]["quantity"] = $refill_product['quantity'];
                $for_serial_item[$key]["product_id"] = $refill_product['product_id'];
                $for_serial_item[$key]["inventory_id"] = $inventory_id;
            }
             $data['status'] = '';
            

            $serial = Tbl_settings::where("settings_key","item_serial")->where("settings_value","enable")->where("shop_id",$shop_id)->first();

            $data['status'] = 'success';
            if($is_return == null)
            {
                if($serial != null)
                {
                    $data['status'] = 'success-serial';

                    $items["item_id"] = "";
                    // $items["slip_id"] = $inventory_slip_id;
                    $items["item_list"] = $for_serial_item;
                    Session::put("item", $items);
                }                
            }
 
            $data['inventory_slip_id'] = $inventory_slip_id;

        }
        else
        {
            $data['status'] = 'error';
            $data['status_message'] = 'some fields are missing';
        }
       

        $space = '';
        if($return == 'json')
        {
            $data = json_encode($data);
        }
        return $data;
    }

    public static function inventory_consume($warehouse_id = 0, $remarks = '', $consume_product ,$consumer_id = 0, $consume_cause = '', $return = 'array', $transaction_type = '', $transaction_id = 0)
    {
        $shop_id = Warehouse::get_shop_id($warehouse_id);
        $insert_slip['inventory_slip_id_sibling']     = 0;
        $insert_slip['inventory_reason']              = 'consume';
        $insert_slip['warehouse_id']                  = $warehouse_id;
        $insert_slip['inventory_remarks']             = $remarks;
        $insert_slip['inventory_slip_date']           = Carbon::now();
        $insert_slip['inventory_slip_shop_id']        = $shop_id;
        $insert_slip['inventory_slip_status']         = 'consume';
        $insert_slip['inventroy_source_reason']       = $transaction_type;
        $insert_slip['inventory_source_id']           = $transaction_id;
        $insert_slip['inventory_slip_consume_refill'] = 'consume';
        $insert_slip['inventory_slip_consumer_id']    =  $consumer_id;
        $insert_slip['inventory_slip_consume_cause']  =  $consume_cause;


        $inventory_slip_id = Tbl_inventory_slip::insertGetId($insert_slip);

        $insert_consume = '';

        $inventory_success = '';
        $inventory_err = '';
        $success = 0;
        $err = 0;
        $data['status_message'] = "";
        $err_msg = "";
        foreach($consume_product as $key => $product)
        {
            $count_on_hand = Tbl_warehouse_inventory::check_inventory_single($warehouse_id, $product['product_id'])->pluck('inventory_count');
            if($count_on_hand == null)
            {
                $count_on_hand = 0;   
            }

            if($product['quantity'] > 0 && $count_on_hand > 0 && $count_on_hand > $product['quantity'])
            {
                $insert_consume[$key]['inventory_item_id']        = $product['product_id'];
                $insert_consume[$key]['warehouse_id']             = $warehouse_id;
                $insert_consume[$key]['inventory_created']        = Carbon::now();
                $insert_consume[$key]['inventory_count']          = $product['quantity'] * -1;
                $insert_consume[$key]['inventory_slip_id']        = $inventory_slip_id;

                $inventory_success[$success] = Warehouse::array_tansfer('success', $product['product_id']);
                $success++;
            }
            else
            {
                $item_name = Item::get_item_details($product['product_id']);
                $err_msg[$key] = "The quantity of ".$item_name->item_name." is not enough for you to transfer.<br>";
                $inventory_err[$err] = Warehouse::array_tansfer('error', $product['product_id']);
                $err++;
            }
        }

        $data['status'] = '';
        if($inventory_err == '')
        {
            Tbl_warehouse_inventory::insert($insert_consume);
            $data['status'] = 'success';
            $data['inventory_slip_id'] = $inventory_slip_id;
        }
        else
        {
            $data['status'] = 'error';
            $data['status_message'] = $err_msg;
        }
        $space = '';
        if($return == 'json')
        {
            $data = json_encode($data);
        }

        return $data;
    }

    public static function get_shop_id($warehouse_id = 0)
    {

        $data = Tbl_warehouse::where('warehouse_id',$warehouse_id)->pluck('warehouse_shop_id');
        return $data;
    }
    public static function insert_item($from_warehouse_id, $to_warehouse_id)
    {
        $from_item = Tbl_sub_warehouse::where("warehouse_id",$from_warehouse_id)->get();

        foreach($from_item as $key => $value) 
        {
            $ctr_to_item_existence = Tbl_sub_warehouse::where("warehouse_id",$to_warehouse_id)->where("item_id",$value->item_id)->count();

            if($ctr_to_item_existence == 0)
            {
                $ins_item["warehouse_id"] = $to_warehouse_id;
                $ins_item["item_id"] = $value->item_id;
                $ins_item["item_reorder_point"] = 0;

                Tbl_sub_warehouse::insert($ins_item);
            }

            $ctr_to_item_inventory = Tbl_warehouse_inventory::where("warehouse_id",$to_warehouse_id)->where("inventory_item_id",$value->item_id)->count();

            if($ctr_to_item_inventory == 0)
            {
                $ins_inventory["inventory_item_id"] = $value->item_id;
                $ins_inventory["warehouse_id"] = $to_warehouse_id;
                $ins_inventory["inventory_created"] = Carbon::now();
                $ins_inventory["inventory_count"] = 0;

                Tbl_warehouse_inventory::insert($ins_inventory);
            }


        }
    }
    public static function get_transfer_warehouse_information($warehouse_from_id = 0, $warehouse_to_id = 0, $return = 'array')
    {   
        $data = Tbl_sub_warehouse::warehousetowarehouse($warehouse_from_id, $warehouse_to_id)->get();
        if($return == 'json')
        {
            $data = json_encode($data);
        }
        return $data;
    }


    public static function array_tansfer($status = '', $product_id = 0)
    {
        $item = Tbl_item::selitem($product_id)->first();
        $data['status'] = $status;
        $data['product_id'] = $product_id;
        $data['product_name'] = $item->item_name;
        return $data;
    }

    public static function put_default_warehouse($shop_id)
    {
        if(!Tbl_warehouse::where("warehouse_shop_id", $shop_id)->where("main_warehouse", 1)->first())
        {
            $insert1["warehouse_name"]    = "Main Warehouse";
            $insert1["warehouse_shop_id"] = $shop_id;
            $insert1["warehouse_created"] = Carbon::now();
            $insert1["main_warehouse"]    = "1";

            Tbl_warehouse::insertGetId($insert1);
        }

        if(!Tbl_warehouse::where("warehouse_shop_id", $shop_id)->where("warehouse_name", "Ecommerce Warehouse")->first())
        {
            $insert2["warehouse_name"]    = "Ecommerce Warehouse";
            $insert2["warehouse_shop_id"] = $shop_id;
            $insert2["warehouse_created"] = Carbon::now();
            $insert2["main_warehouse"]    = "2";

            Tbl_warehouse::insertGetId($insert2);
        }
    }

    public static function getMainwarehouse()
    {
        return Tbl_warehouse::where("warehouse_shop_id",Warehouse::getShopId())->where("main_warehouse",1)->pluck("warehouse_id");
    }
    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }
    public static function mainwarehouse_for_developer($user_id, $shop_id)
    {
        $_warehouse     = Tbl_warehouse::where("warehouse_shop_id", $shop_id)->get();
        $warehouse_id   = collect($_warehouse)->where("main_warehouse", 1)->first()->pluck("warehouse_id");
        $user           = Tbl_user::where("user_id", $user_id)->first();
        
        if($user->user_level == 1)
        {
            foreach($_warehouse as $warehouse)
            {
                 if(!Tbl_user_warehouse_access::where("user_id", $user_id)->where("warehouse_id", $warehouse->warehouse_id)->first())
                 {
                    Tbl_user_warehouse_access::insert(['user_id' => $user_id, 'warehouse_id' => $warehouse->warehouse_id]);
                 }
            }
        }
        elseif(!Tbl_user_warehouse_access::where("user_id", $user_id)->where("warehouse_id", $warehouse_id)->first())
        {
            Tbl_user_warehouse_access::insert(['user_id' => $user_id, 'warehouse_id' => $warehouse_id]);
        }
    }
   
}