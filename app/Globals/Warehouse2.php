<?php
namespace App\Globals;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_warehouse_inventory_record_log;
use App\Models\Tbl_inventory_slip;
use App\Models\Tbl_variant;
use App\Models\Tbl_user;
use App\Models\Tbl_mlm_item_discount;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_category;
use App\Models\Tbl_item;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_sir_item;
use App\Models\Tbl_inventory_history;
use App\Models\Tbl_inventory_history_items;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_audit_trail;
use App\Models\Tbl_inventory_serial_number;
use App\Models\Tbl_price_level;
use App\Models\Tbl_price_level_item;
use App\Models\Tbl_sub_warehouse;
use App\Models\Tbl_user_warehouse_access;
use App\Models\Tbl_settings;
use App\Models\Tbl_customer;

use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Warehouse;
use App\Globals\Purchasing_inventory_system;
use App\Globals\Tablet_global;
use App\Globals\Currency;
use Session;
use DB;
use Carbon\carbon;
use App\Globals\Merchant;
use Validator;
class Warehouse2
{   
    public static function get_all_warehouse($shop_id, $warehouse_id = '')
    {
        $data = Tbl_warehouse::where('warehouse_shop_id',$shop_id)->where('archived',0);
        if($warehouse_id != '')
        {
            $data = $data->where('warehouse_id',$warehouse_id);
        }
        return $data->get();
    }
	public static function get_current_warehouse($shop_id)
	{
		return session('warehouse_id_'.$shop_id);
	}
	public static function get_main_warehouse($shop_id)
	{
	    return Tbl_warehouse::where('warehouse_shop_id',$shop_id)->where('main_warehouse',1)->where('archived',0)->value('warehouse_id');
	}
    public static function get_item_qty($warehouse_id, $item_id)
    {
        $count = Tbl_warehouse_inventory_record_log::where("record_warehouse_id",$warehouse_id)
                                                   ->where("record_item_id",$item_id)
                                                   ->where("record_inventory_status",0)
                                                   ->count();
        return $count;
    }
    public static function get_transaction_item($transaction_ref_name = '', $transaction_ref_id = 0)
    {
        return Tbl_warehouse_inventory_record_log::where('record_consume_ref_name',$transaction_ref_name)
                                                   ->where('record_consume_ref_id', $transaction_ref_id)
                                                   ->get(); 
    }
    public static function get_source_transaction_item($transaction_ref_name = '', $transaction_ref_id = 0)
    {
        return Tbl_warehouse_inventory_record_log::where('record_source_ref_name',$transaction_ref_name)
                                                   ->where('record_source_ref_id', $transaction_ref_id)
                                                   ->get(); 
    }
    public static function get_item_qty_transfer($warehouse_id, $item_id)
    {
        $count = Tbl_warehouse_inventory_record_log::where("record_warehouse_id",$warehouse_id)
                                                   ->where("record_item_id",$item_id)
                                                   ->count();
        return $count;
    }
    public static function check_warehouse_existence($shop_id, $warehouse_id = 0)
    {
        return Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();
    }
  
    public static function get_history_number($shop_id, $warehouse_id, $history_type = '')
    {
        $prefix = Tbl_settings::where("settings_key","inventory_rr_prefix")->value('settings_value');

        $history_ctr = Tbl_inventory_history::where('shop_id',$shop_id)->where('warehouse_id',$warehouse_id)->where('history_type',$history_type)->count();
        if($history_type == 'WIS')
        {
            $prefix = Tbl_settings::where("settings_key","inventory_wis_prefix")->value('settings_value');
        }

        return $prefix.sprintf("%'.05d", $history_ctr+1);

    }
    public static function transfer_validation($shop_id, $wh_from, $wh_to, $item_id, $quantity, $remarks, $serial = array(), $source = array(), $to = array())
    {
        $return = null;

        $item_data = Item::get_item_details($item_id);
        if(Warehouse2::check_warehouse_existence($shop_id, $wh_from) && Warehouse2::check_warehouse_existence($shop_id, $wh_to))
        {
            $warehouse_qty = Warehouse2::get_item_qty_transfer($wh_from, $item_id);

            if($item_data)
            {
                $get_data = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$wh_from)->where('record_item_id',$item_id)->first();

                if(isset($source['name']) && isset($source['id']) && isset($to['name']) && isset($to['id']))
                {   
                    if($source['name'] == 'wis')
                    {
                        $get_data = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$wh_from)->where('record_item_id',$item_id)->where('record_consume_ref_name',$source['name'])->where('record_consume_ref_id',$source['id'])->first();
                        $truck_qty = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$wh_from)->where('record_item_id',$item_id)->where('record_consume_ref_name',$source['name'])->where('record_consume_ref_id',$source['id'])->count();
                    }

                    if($truck_qty < $quantity)
                    {
                        $return .= 'The quantity of '.$item_data->item_name.' is not enough to transfer <br>';
                    }
                }
                if(is_numeric($quantity) == false)
                { 
                    $return .= "The quantity must be a number. <br>";
                }
                if($quantity < 0)
                {
                    $return .= 'The quantity of '.$item_data->item_name.' is less than one. <br>';                
                }
                if(!$get_data)
                {
                    $return .= 'The item '.$item_data->item_name.' does not exist in this warehouse. <br>';                
                }
                // if($warehouse_qty < $quantity)
                // {
                //     $return .= 'The quantity of '.$item_data->item_name.' is not enough to transfer <br>';
                // }
                $serial_qty = count($serial);
                if($serial_qty > 0)
                {
                    if($serial_qty != $quantity)
                    {
                        $return .= "The serial number are not equal from the quantity. <br> ";
                    }
                    foreach ($serial as $key => $value) 
                    {
                        $check_serial = Tbl_warehouse_inventory_record_log::where('record_serial_number',$value)->where('record_item_id',$item_id)->where('record_warehouse_id',$wh_from)->first();
                        if(!$check_serial)
                        {
                            $return .= "The serial number ".$value." does not belong to ".$item_data->item_name.". <br> ";
                        }
                    }
                }
            }
            else
            {
                $return.= "The item number ". $item_id." doesn't exist!";            
            }
        }
        else
        {
            $return .= "The warehouses does not exist!";            
        }

        return $return;
    }
    public static function transfer($shop_id, $wh_from, $wh_to, $item_id, $quantity, $remarks, $serial = array(), $inventory_history = '', $source = array(), $to = array())
    {
        $return = Warehouse2::transfer_validation($shop_id, $wh_from, $wh_to, $item_id, $quantity, $remarks, $serial);
      
        if(!$return)
        {
            $return = null;
            for ($ctr_qty = 0; $ctr_qty < $quantity ; $ctr_qty++)
            {                
                $get_data = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$wh_from)->where('record_item_id',$item_id)->first();
                if(count($serial) > 0)
                {
                    $get_data = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$wh_from)->where('record_item_id',$item_id)->where('record_serial_number',$serial[$ctr_qty])->first();
                }
                if(isset($source['name']) && isset($source['id']) && isset($to['name']) && isset($to['id']))
                {   
                    $update['record_source_ref_name'] = $to['name'];
                    $update['record_source_ref_id'] = $to['id'];
                    if($source['name'] == 'wis')
                    {
                        $get_data = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$wh_from)->where('record_item_id',$item_id)->where('record_consume_ref_name',$source['name'])->where('record_consume_ref_id',$source['id'])->first();
                    }
                    if(count($serial) > 0)
                    {
                        $get_data = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$wh_from)->where('record_item_id',$item_id)->where('record_consume_ref_name',$source['name'])->where('record_consume_ref_id',$source['id'])->where('record_serial_number',$serial[$ctr_qty])->first();
                    }                        
                }
                Warehouse2::insert_item_history($get_data->record_log_id);

                $update['record_inventory_status'] = 0;
                $update['record_consume_ref_name'] = null;
                $update['record_consume_ref_id'] = 0;
                $update['record_warehouse_id'] = $wh_to;
                $update['record_item_remarks'] = $remarks;
                $update['record_log_date_updated'] = Carbon::now();
                Tbl_warehouse_inventory_record_log::where('record_log_id',$get_data->record_log_id)->update($update);
            }

            if(!$inventory_history)
            {
                $wh_from_name = Warehouse2::get_info($wh_from)->value('warehouse_name');
                $wh_to_name = Warehouse2::get_info($wh_to)->value('warehouse_name');
                $inventory_wis['history_description'] = "Transfer items from ".$wh_from_name." to ".$wh_to_name;
                $inventory_wis['history_remarks'] = $remarks;
                $inventory_wis['history_type'] = "WIS";
                $inventory_wis['history_number'] = Warehouse2::get_history_number($shop_id, $wh_from, $inventory_wis['history_type']);


                $inventory_rr['history_description'] = "Transfer items from ".$wh_from_name." to ".$wh_to_name;
                $inventory_rr['history_remarks'] = $remarks;
                $inventory_rr['history_type'] = "RR";
                $inventory_rr['history_number'] = Warehouse2::get_history_number($shop_id, $wh_to, $inventory_rr['history_type']);


                $history_wis[0]['item_id'] = $item_id;
                $history_wis[0]['quantity'] = $quantity;
                $history_wis[0]['item_remarks'] = $remarks;

                $history_rr[0]['item_id'] = $item_id;
                $history_rr[0]['quantity'] = $quantity;
                $history_rr[0]['item_remarks'] = $remarks;

                Warehouse2::insert_inventory_history($shop_id, $wh_from, $inventory_wis, $history_wis);
                Warehouse2::insert_inventory_history($shop_id, $wh_to, $inventory_rr, $history_rr);
            }

            Warehouse2::update_inventory_count($wh_to, 0, $item_id, $quantity);
        }
        return $return;
    }
    public static function transfer_bulk($shop_id, $wh_from, $wh_to, $_item, $remarks = '', $source = array(),$to = array())
    {
        $validate = null;
        foreach ($_item as $key => $value)
        {
            $serial = isset($value['serial']) ? $value['serial'] : array();
            $validate .= Warehouse2::transfer_validation($shop_id, $wh_from, $wh_to, $value['item_id'], $value['quantity'], $value['remarks'], $serial, $source, $to);
        }

        if(!$validate)
        {
            $wh_from_name = Warehouse2::get_info($wh_from)->value('warehouse_name');
            $wh_to_name = Warehouse2::get_info($wh_to)->value('warehouse_name');
            $inventory_wis['history_description'] = "Transfer items from ".$wh_from_name." to ".$wh_to_name;
            $inventory_wis['history_remarks'] = $remarks;
            $inventory_wis['history_type'] = "WIS";
            $inventory_wis['history_number'] = Warehouse2::get_history_number($shop_id, $wh_from, $inventory_wis['history_type']);


            $inventory_rr['history_description'] = "Transfer items from ".$wh_from_name." to ".$wh_to_name;
            $inventory_rr['history_remarks'] = $remarks;
            $inventory_rr['history_type'] = "RR";
            $inventory_rr['history_number'] = Warehouse2::get_history_number($shop_id, $wh_to, $inventory_rr['history_type']);

            foreach ($_item as $key => $value)
            {
                $serial = isset($value['serial']) ? $value['serial'] : array();

                $history_wis[$key]['item_id'] = $value['item_id'];
                $history_wis[$key]['quantity'] = $value['quantity'];
                $history_wis[$key]['item_remarks'] = $value['remarks'];

                $history_rr[$key]['item_id'] = $value['item_id'];
                $history_rr[$key]['quantity'] = $value['quantity'];
                $history_rr[$key]['item_remarks'] = $value['remarks'];

                $validate = Warehouse2::transfer($shop_id, $wh_from, $wh_to, $value['item_id'], $value['quantity'], $value['remarks'], $serial, 'inventory_history_recorded', $source, $to);
            }

            Warehouse2::insert_inventory_history($shop_id, $wh_from, $inventory_wis, $history_wis);
            Warehouse2::insert_inventory_history($shop_id, $wh_to, $inventory_rr, $history_rr);
        }

        return $validate;
    }
    public static function validate_warehouse($shop_id, $insert)
    {
        $check_warehouse = Tbl_warehouse::where('warehouse_name',$insert['warehouse_name'])->where('warehouse_shop_id',$shop_id)->first();
        $return = null;
        if($check_warehouse)
        {
            $return .= "The warehouse name already exist";
        }
        if($insert != 0)
        {
            $check_price_level = Tbl_price_level::where('price_level_id',$insert['sale_price_level'])->first();
            if(!$check_price_level)
            {
                $return .= "The sale_price_level does't exist";
            }
        }
        if($insert['purchase_price_level'] != 0)
        {
            $check_price_level = Tbl_price_level::where('price_level_id',$insert['purchase_price_level'])->first();
            if(!$check_price_level)
            {
                $return .= "The sale_price_level does't exist";
            }
        }

        return $return;        
    }
    public static function get_info($warehouse_id)
    {
        return Tbl_warehouse::where('warehouse_id',$warehouse_id)->first();
    }
    public static function create($shop_id, $insert)
    {
        $return = Warehouse2::validate_warehouse($shop_id, $insert);

        if(!$return['message'])
        {
            $insert["warehouse_created"] = Carbon::now();
            $insert["warehouse_shop_id"] = $shop_id;

            $warehouse_id = Tbl_warehouse::insertGetId($ins_warehouse);

            Warehouse::insert_access($id);

            $get_all_item = Tbl_item::where('shop_id',$shop_id)->get();

            foreach ($get_all_item as $key => $value) 
            {
                $check = Tbl_sub_warehouse::where("item_id",$value->item_id)->where("warehouse_id",$warehouse_id)->first();
                if($check == null)
                {
                    $ins_sub["warehouse_id"] = $warehouse_id;
                    $ins_sub["item_id"] = $value->item_id;
                    $ins_sub["item_reorder_point"] = $value->item_reorder_point;

                    Tbl_sub_warehouse::insert($ins_sub);
                }
            }     

            $return = $warehouse_id;
        }

        return $return;
    }
    public static function insert_item_history($record_log_id = 0)
    {
        $get_data = Tbl_warehouse_inventory_record_log::where('record_log_id',$record_log_id)->first();
        if($get_data)
        {            
            $datenow = $get_data->record_log_date_updated;
            if($get_data->record_log_history)
            {
                $serialize = unserialize($get_data->record_log_history);
                $serialize[$datenow] = collect($get_data)->toArray();

                $update['record_log_history'] = serialize($serialize);
                Tbl_warehouse_inventory_record_log::where('record_log_id',$get_data->record_log_id)->update($update);
            }
            else
            {                
                $serialize[$datenow] = collect($get_data)->toArray();
                $update['record_log_history'] = serialize($serialize);
                Tbl_warehouse_inventory_record_log::where('record_log_id',$get_data->record_log_id)->update($update);
            }
        }
    }

    public static function refill_validation($shop_id, $warehouse_id, $item_id, $quantity, $remarks, $serial = array())
    {
        $return = null;
        $check_warehouse = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();

        if(is_numeric($quantity) == false)
        { 
            $return .= "The quantity must be a number. <br>";
        }

        $serial_qty = count($serial);
        if($serial_qty != 0)
        {
            if($serial_qty != $quantity)
            {
                $item_info = Item::info($item_id);
                $return .= "The serial number of ".$item_info->item_name." are not equal from the quantity. <br> ";
            }
            foreach ($serial as $key => $value) 
            {
                $check_serial = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$warehouse_id)->where('record_item_id', $item_id)->where('record_serial_number',$value)->first();
                if($check_serial)
                {
                    $return .= "The serial number ".$value." already exist. <br>";
                }
            }
        }
        if($quantity < 0)
        {
            $return .= "The quantity is less than 1. <br> ";
        }
        if(!$check_warehouse)
        {
            $return .= "The warehouse doesn't belong to your account <br>";
        }

        return $return;
    }
    public static function refill($shop_id, $warehouse_id, $item_id = 0, $quantity = 1, $remarks = '', $source = array(), $serial = array(), $inventory_history = '', $update_count = true)
    {
        $check_warehouse = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();

        $return = null;

        $serial_qty = count($serial);
        if($serial_qty != 0)
        {
            if($serial_qty != $quantity)
            {
                $return .= "The serial number are not equal from the quantity. <br> ";
            }
        }
        if($quantity < 0)
        {
            $return .= "The quantity is less than 1. <br> ";
        }
        if(!$check_warehouse)
        {
            $return .= "The warehouse doesn't belong to your account <br>";
        }

        if(!$return)
        {  
            $insert_slip['warehouse_id']                 = $warehouse_id;
            $insert_slip['inventory_remarks']            = $remarks;
            $insert_slip['inventory_slip_date']          = Carbon::now();
            $insert_slip['inventory_slip_shop_id']       = $shop_id;
            $insert_slip['inventroy_source_reason']      = isset($source['name']) ? $source['name'] : '';
            $insert_slip['inventory_source_id']          = isset($source['id']) ? $source['id'] : 0;
            $insert_slip['slip_user_id']                 = Warehouse2::get_user_login();
            $slip_id = Tbl_inventory_slip::insertGetId($insert_slip);

            $insert = null;
            for ($ctr_qty = 0; $ctr_qty < $quantity; $ctr_qty++) 
            {
                $insert[$ctr_qty]['record_shop_id']            = $shop_id;
                $insert[$ctr_qty]['record_item_id']            = $item_id;
                $insert[$ctr_qty]['record_warehouse_id']       = $warehouse_id;
                $insert[$ctr_qty]['record_item_remarks']       = $remarks;
                $insert[$ctr_qty]['record_warehouse_slip_id']  = $slip_id;
                $insert[$ctr_qty]['record_source_ref_name']    = isset($source['name']) ? $source['name'] : '';
                $insert[$ctr_qty]['record_source_ref_id']      = isset($source['id']) ? $source['id'] : 0;
                $insert[$ctr_qty]['record_log_date_updated']   = Carbon::now();
                $insert[$ctr_qty]['mlm_pin']                   = Warehouse2::get_mlm_pin($shop_id);
                $insert[$ctr_qty]['mlm_activation']            = Item::get_mlm_activation($shop_id);
                $insert[$ctr_qty]['ctrl_number']               = Warehouse2::get_control_number($warehouse_id, $shop_id, Item::get_item_type($item_id));

                if($serial_qty > 0)
                {
                    $insert[$ctr_qty]['record_serial_number'] = $serial[$ctr_qty];
                }
                Tbl_warehouse_inventory_record_log::insert($insert[$ctr_qty]);
            }

            if(!$inventory_history)
            {
                $inventory_details['history_description'] = "Refill items from ". $insert_slip['inventroy_source_reason']." #".$insert_slip['inventory_source_id'];
                $inventory_details['history_remarks'] = $remarks;
                $inventory_details['history_type'] = "RR";
                $inventory_details['history_reference'] = $insert_slip['inventroy_source_reason'];
                $inventory_details['history_reference_id'] = $insert_slip['inventory_source_id'];
                $inventory_details['history_number'] = Warehouse2::get_history_number($shop_id, $warehouse_id, $inventory_details['history_type']);

                $history_item[0]['item_id'] = $item_id;
                $history_item[0]['quantity'] = $quantity;
                $history_item[0]['item_remarks'] = $remarks;

                Warehouse2::insert_inventory_history($shop_id, $warehouse_id, $inventory_details, $history_item);
            }

            if($update_count == true)
            {
                Warehouse2::update_inventory_count($warehouse_id, $slip_id, $item_id, $quantity);
            }
        }       

        return $return;
    }
    public static function get_control_number($warehouse_id, $shop_id, $item_type = null)
    {
        $return = 0;
        if($shop_id == 5) // SPECIAL FOR BROWN 
        {
            if($item_type == 5) // MEMBERSHIP KIT TYPE ITEM
            {
                $check = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->value('main_warehouse');
                if($check == 3)
                {
                    $count = Tbl_warehouse_inventory_record_log::item()->where('record_warehouse_id',$warehouse_id)->where('item_type_id',$item_type)->count();
                    $return = $count + 1;
                }
            }
        }
        return $return;

    }
    public static function update_inventory_count($warehouse_id, $slip_id, $item_id, $quantity)
    {
        // $update["inventory_count"] = Tbl_warehouse_inventory_record_log::where("record_warehouse_id", $warehouse_id)->where("record_item_id", $item_id)->count();
        // Tbl_warehouse_inventory::where("warehouse_id", $warehouse_id)->where("inventory_item_id", $item_id)->update($update);
        $ins['inventory_item_id'] = $item_id;
        $ins['warehouse_id'] = $warehouse_id;
        $ins['inventory_created'] = Carbon::now();
        $ins['inventory_count'] = $quantity;
        $ins['inventory_slip_id'] = $slip_id;
        Tbl_warehouse_inventory::insert($ins);
    }
    public static function get_mlm_pin($shop_id)
    {       
        $return = 0; 
        $prefix = Tbl_settings::where("settings_key","mlm_pin_prefix")->where('shop_id',$shop_id)->value('settings_value');
        
        if($prefix)
        {
            $ctr_item = Tbl_warehouse_inventory_record_log::where('record_shop_id',$shop_id)->count() + 1;
            $return = $prefix.sprintf("%'.05d",$ctr_item);
        }

        return $return;
    }
    /**           
        $_item[0]['item_id'] = 15;
        $_item[0]['quantity'] = 1;
        $_item[0]['remarks'] = 'test';
        $_item[0]['serial'] = array("1SERIAL001");;

        $_item[1]['item_id'] = 17;
        $_item[1]['quantity'] = 1;
        $_item[1]['remarks'] = 'test_consume';
        $_item[1]['serial'] = array("1SERIAL004");;

        $ret = Warehouse2::refill_bulk($this->user_info->shop_id, 6, 'refill_bulk_test', 20 , 'test refill', $_item);
        
        $ret = Warehouse2::transfer_bulk($this->user_info->shop_id, 29, 6, $_item, "test transfer 1");

        $ret = Warehouse2::consume_bulk($this->user_info->shop_id, 6, 'consumebulk_test', 1 , 'test consume', $_item);

        dd($ret);
    */
    public static function refill_bulk($shop_id, $warehouse_id, $reference_name = '', $reference_id = 0 , $remarks = '', $_item = array())
    {
        $validate = null;
        foreach ($_item as $key => $value)
        {
            $serial = isset($value['serial']) ? $value['serial'] : array();
            $validate .= Warehouse2::refill_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks'], $serial);
        }

        if(!$validate)
        {
            $inventory_details['history_description'] = "Refill items from ".$reference_name." #".$reference_id;
            $inventory_details['history_remarks'] = $remarks;
            $inventory_details['history_type'] = "RR";
            $inventory_details['history_reference'] = $reference_name;
            $inventory_details['history_reference_id'] = $reference_id;
            $inventory_details['history_number'] = Warehouse2::get_history_number($shop_id, $warehouse_id, $inventory_details['history_type']);

            foreach ($_item as $key => $value) 
            {
                $serial = isset($value['serial']) ? $value['serial'] : array();

                $source['name'] = $reference_name;
                $source['id'] = $reference_id;

                $history_item[$key]['item_id'] = $value['item_id'];
                $history_item[$key]['quantity'] = $value['quantity'];
                $history_item[$key]['item_remarks'] = $value['remarks'];

                $validate = Warehouse2::refill($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks'], $source, $serial, 'inventory_history_recorded');
            }

            Warehouse2::insert_inventory_history($shop_id, $warehouse_id, $inventory_details, $history_item);

        }

        return $validate;
    }
    public static function consume_validation($shop_id, $warehouse_id, $item_id, $quantity, $remarks, $serial = array())
    {
        $return = null;
        $check_warehouse = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();

        $serial_qty = count($serial);
        if($serial_qty != 0)
        {
            if($serial_qty != $quantity)
            {
                $return .= "The serial number are not equal from the quantity. <br> ";
            }

            foreach ($serial as $key => $value) 
            {
                $check_serial = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$warehouse_id)->where('record_item_id', $item_id)->where('record_serial_number',$value)->first();
                if(!$check_serial)
                {
                    $return .= "The serial number ".$value." does not exist in this warehouse. <br>";
                }
            }
        }
        if(is_numeric($quantity) == false)
        { 
            $return .= "The quantity must be a number. <br>";
        }
        if($quantity < 0)
        {
            $return .= "The quantity is less than 1. <br> ";
        }
        if(!$check_warehouse)
        {
            $return .= "The warehouse doesn't belong to your account <br>";
        }
        $inventory_qty = Warehouse2::get_item_qty($warehouse_id, $item_id);
        if($quantity > $inventory_qty)
        {
            $return .= "The quantity of <b>".Item::info($item_id)->item_name."</b> is not enough to consume. <br>";
        }
        return $return;
    }
    public static function consume_update($ref_name, $ref_id, $item_id, $quantity)
    {
        $data = Tbl_warehouse_inventory_record_log::where("record_consume_ref_name",$ref_name)->where("record_consume_ref_id",$ref_id)->get();
        
        for ($ctr_qty = 0; $ctr_qty < $quantity ; $ctr_qty ++) 
        { 
            $update['record_consume_ref_name'] = '';
            $update['record_consume_ref_id'] = 0;
            $update['record_inventory_status'] = 0;
            $update['record_item_remarks'] = 'Disassembled Item FROM Membership kit#'.$ref_id;

            Tbl_warehouse_inventory_record_log::where("record_consume_ref_name",$ref_name)->where("record_item_id",$item_id)->where("record_consume_ref_id",$ref_id)->update($update);
        }
    }
    public static function consume($shop_id, $warehouse_id, $item_id = 0, $quantity = 1, $remarks = '', $consume = array(), $serial = array(), $inventory_history = '')
    {
        $return = null;

        $insert_slip['warehouse_id']                 = $warehouse_id;
        $insert_slip['inventory_remarks']            = $remarks;
        $insert_slip['inventory_slip_date']          = Carbon::now();
        $insert_slip['inventory_slip_shop_id']       = $shop_id;
        $insert_slip['slip_user_id']                 = Warehouse::getUserid();
        $insert_slip['inventroy_source_reason']      = isset($consume['name']) ? $consume['name'] : '';
        $insert_slip['inventory_source_id']          = isset($consume['id']) ? $consume['id'] : 0;
        $insert_slip['slip_user_id']                 = Warehouse::getUserid();
        $slip_id = Tbl_inventory_slip::insertGetId($insert_slip);

        $serial_qty = count($serial);
        for ($ctr_qty = 0; $ctr_qty < $quantity; $ctr_qty++) 
        {
            $insert['record_shop_id']            = $shop_id;
            $insert['record_item_id']            = $item_id;
            $insert['record_warehouse_id']       = $warehouse_id;
            $insert['record_item_remarks']       = $remarks;
            $insert['record_warehouse_slip_id']  = $slip_id;
            $insert['record_consume_ref_name']   = isset($consume['name']) ? $consume['name'] : '';
            $insert['record_consume_ref_id']     = isset($consume['id']) ? $consume['id'] : 0;
            $insert['record_inventory_status']   = 1;
            $insert['record_log_date_updated']   = Carbon::now();

            $id = Tbl_warehouse_inventory_record_log::where("record_warehouse_id",$warehouse_id)
                                                   ->where("record_item_id",$item_id)
                                                   ->where("record_inventory_status",0)
                                                   ->where("item_in_use",'unused')
                                                   ->value('record_log_id');
            if($serial_qty > 0)
            {
                $insert['record_serial_number'] = $serial[$ctr_qty];

                $id = Tbl_warehouse_inventory_record_log::where("record_warehouse_id",$warehouse_id)
                                                   ->where("record_item_id",$item_id)
                                                   ->where("record_inventory_status",0)
                                                   ->where("record_serial_number",$serial[$ctr_qty])
                                                   ->where("item_in_use",'unused')
                                                   ->value('record_log_id');
            }
            Warehouse2::insert_item_history($id);
            Tbl_warehouse_inventory_record_log::where('record_log_id',$id)->update($insert);
        }

        if(!$inventory_history)
        {
            $inventory_details['history_description'] = "Consume items from ". $insert_slip['inventroy_source_reason']." #".$insert_slip['inventory_source_id'];
            $inventory_details['history_remarks'] = $remarks;
            $inventory_details['history_type'] = "WIS";
            $inventory_details['history_reference'] = $insert_slip['inventroy_source_reason'];
            $inventory_details['history_reference_id'] = $insert_slip['inventory_source_id'];
            $inventory_details['history_number'] = Warehouse2::get_history_number($shop_id, $warehouse_id, $inventory_details['history_type']);

            $history_item[0]['item_id'] = $item_id;
            $history_item[0]['quantity'] = $quantity;
            $history_item[0]['item_remarks'] = $remarks;

            Warehouse2::insert_inventory_history($shop_id, $warehouse_id, $inventory_details, $history_item);
        }

        Warehouse2::update_inventory_count($warehouse_id, $slip_id, $item_id, -($quantity));

        return $return;
    }
    public static function sold_kit($shop_id, $warehouse_id, $item_id = 0, $quantity = 1, $remarks = '', $sold = array())
    {
        $ctr_inventory = Tbl_warehouse_inventory_record_log::where("record_warehouse_id",$warehouse_id)
                                               ->where("record_item_id",$item_id)
                                               ->where("record_consume_ref_id",0)
                                               ->where("record_inventory_status",0)
                                               ->count('record_log_id');
        $return = null;
        if($ctr_inventory > 0)
        {
            $insert['record_shop_id']            = $shop_id;
            $insert['record_item_id']            = $item_id;
            $insert['record_warehouse_id']       = $warehouse_id;
            $insert['record_item_remarks']       = $remarks;
            $insert['record_consume_ref_name']   = isset($sold['name']) ? $sold['name'] : '';
            $insert['record_consume_ref_id']     = isset($sold['id']) ? $sold['id'] : 0;
            $insert['record_log_date_updated']   = Carbon::now();
    
            $id = Tbl_warehouse_inventory_record_log::where("record_warehouse_id",$warehouse_id)
                                                   ->where("record_item_id",$item_id)
                                                   ->where("record_inventory_status",0)
                                                   ->value('record_log_id');
            
            Tbl_warehouse_inventory_record_log::where('record_log_id',$id)->update($insert);
            
            Warehouse2::insert_item_history($id);
            
            return $id;
        }
    }
    public static function consume_bulk($shop_id, $warehouse_id, $reference_name = '', $reference_id = 0 , $remarks = '', $_item)
    {
        $validate = null;
        foreach ($_item as $key => $value)
        {
            $serial = isset($value['serial']) ? $value['serial'] : null;
            $validate .= Warehouse2::consume_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks'], $serial);
        }
        if(!$validate)
        {
            foreach ($_item as $key => $value) 
            {                
                $serial = isset($value['serial']) ? $value['serial'] : null;

                $consume['name'] = $reference_name;
                $consume['id'] = $reference_id;

                $validate = Warehouse2::consume($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks'], $consume, $serial, 'inventory_history_recorded');
            }
        }

        return $validate;
    }

    /* PARAM
        $code[0]['mlm_pin']
        $code[0]['mlm_activation']
     */
    public static function consume_bulk_product_codes($shop_id = 0, $codes = array(), $consume = array())
    {
        foreach ($code as $key => $value) 
        {
            $ret .= Warehouse2::consume_product_code_validation($shop_id, $value['mlm_pin'], $value['mlm_activation'], $consume);
        }
        if(!$ret)
        {
            foreach ($code as $key => $value) 
            {
                Warehouse2::consume_product_codes($shop_id, $value['mlm_pin'], $value['mlm_activation'], $consume);
            }            
        }

    }
    public static function consume_product_code_validation($shop_id = 0, $mlm_pin = '', $mlm_activation = '' )
    {
        $return = null;
        $val = Tbl_warehouse_inventory_record_log::where("record_shop_id",$shop_id)
                                                 ->where('mlm_activation',$mlm_activation)
                                                 ->where('mlm_pin',$mlm_pin)
                                                 ->where('record_inventory_status',0)
                                                 ->first();
        if(!$val)
        {
            $return ="<b>". $mlm_pin."</b> and <b>".$mlm_activation ."</b> doesn't exist.<br>";
        }

        return $return;

    }
    public static function consume_product_codes($shop_id = 0, $mlm_pin = '', $mlm_activation = '', $consume = array(), $remarks = "Consume using product codes.", $code_used = 'used')
    {
        $return = null;
        $val = Tbl_warehouse_inventory_record_log::where("record_shop_id",$shop_id)
                                                 ->where('mlm_activation',$mlm_activation)
                                                 ->where('mlm_pin',$mlm_pin)
                                                 ->where('item_in_use', 'unused')
                                                 ->first();
        if($val)
        {
            if($val->record_inventory_status == 1)
            {
                $update['record_log_date_updated']   = Carbon::now();
                $update['item_in_use']               = $code_used;
               
                Warehouse2::insert_item_history($val->record_log_id);
                Tbl_warehouse_inventory_record_log::where('record_log_id',$val->record_log_id)->update($update);
            }
            else
            {
                Warehouse2::consume_record_log($shop_id, $val->record_warehouse_id, $val->record_item_id,$val->record_log_id, 1, $remarks, $consume,null, $code_used);
            }
            $return = $val->record_item_id;
        }
        else
        {
            $return = "Pin number and activation code doesn't exist.";
        }

        return $return;

    }
    public static function consume_record_log($shop_id, $warehouse_id, $item_id = 0, $recor_log_id = 0, $quantity = 1, $remarks = '', $consume = array(), $inventory_history = '', $code_used = 'used')
    {
        $return = null;

        $insert_slip['warehouse_id']                 = $warehouse_id;
        $insert_slip['inventory_remarks']            = $remarks;
        $insert_slip['inventory_slip_date']          = Carbon::now();
        $insert_slip['inventory_slip_shop_id']       = $shop_id;
        $insert_slip['slip_user_id']                 = Warehouse::getUserid();
        $insert_slip['inventroy_source_reason']      = isset($consume['name']) ? $consume['name'] : '';
        $insert_slip['inventory_source_id']          = isset($consume['id']) ? $consume['id'] : 0;
        $insert_slip['slip_user_id']                 = Warehouse::getUserid();
        $slip_id = Tbl_inventory_slip::insertGetId($insert_slip);
       
        $insert['record_shop_id']            = $shop_id;
        $insert['record_item_id']            = $item_id;
        $insert['record_warehouse_id']       = $warehouse_id;
        $insert['record_item_remarks']       = $remarks;
        $insert['record_warehouse_slip_id']  = $slip_id;
        $insert['record_consume_ref_name']   = isset($consume['name']) ? $consume['name'] : '';
        $insert['record_consume_ref_id']     = isset($consume['id']) ? $consume['id'] : 0;
        $insert['record_inventory_status']   = 1;
        $insert['record_log_date_updated']   = Carbon::now();
        $insert['item_in_use']               = $code_used;
       
        Warehouse2::insert_item_history($recor_log_id);
        Tbl_warehouse_inventory_record_log::where('record_log_id',$recor_log_id)->update($insert);

        if(!$inventory_history)
        {
            $inventory_details['history_description'] = "Consume items from ". $insert_slip['inventroy_source_reason']." #".$insert_slip['inventory_source_id'];
            $inventory_details['history_remarks'] = $remarks;
            $inventory_details['history_type'] = "WIS";
            $inventory_details['history_reference'] = $insert_slip['inventroy_source_reason'];
            $inventory_details['history_reference_id'] = $insert_slip['inventory_source_id'];
            $inventory_details['history_number'] = Warehouse2::get_history_number($shop_id, $warehouse_id, $inventory_details['history_type']);

            $history_item[0]['item_id'] = $item_id;
            $history_item[0]['quantity'] = $quantity;
            $history_item[0]['item_remarks'] = $remarks;

            Warehouse2::insert_inventory_history($shop_id, $warehouse_id, $inventory_details, $history_item);
        }

        Warehouse2::update_inventory_count($warehouse_id, $slip_id, $item_id, -($quantity));

        return $return;
    }
    public static function get_user_login()
    {
        $user_id = 0;
        $user_data = Tbl_user::where("user_email", session('user_email'))->shop()->value('user_id');
        if($user_data)
        {
            $user_id = $user_data;
        }
        return $user_id;
    }
    /** example 
        WIS - For Consuming
        RR - For Reffiling    

        $inventory_details['history_description'] = "Bulk Consume 5 EACH item to Main Warehouse";
        $inventory_details['history_remarks'] = "INVOICE #14545";
        $inventory_details['history_type'] = "WIS";
        $inventory_details['history_reference'] = "invoice";
        $inventory_details['history_reference_id'] = 25;
        $inventory_details['history_number'] = 'RR00001';

        $history_item[0]['item_id'] = 500;
        $history_item[0]['quantity'] = 5;
        $history_item[0]['item_remarks'] = 'Item 1';

        $history_item[1]['item_id'] = 501;
        $history_item[1]['quantity'] = 5;
        $history_item[1]['item_remarks'] = 'Item 2';

        $history_item[2]['item_id'] = 502;
        $history_item[2]['quantity'] = 5;
        $history_item[2]['item_remarks'] = 'Item 3';

        $return = Warehouse2::insert_inventory_history($this->user_info->shop_id,Warehouse2::get_current_warehouse($this->user_info->shop_id),$inventory_details,$history_item);

    */
    public static function insert_inventory_history($shop_id, $warehouse_id, $history_details = array(), $history_item = array())
    {
        $insert_history['shop_id']              = $shop_id;
        $insert_history['warehouse_id']         = $warehouse_id;
        $insert_history['history_description']  = $history_details['history_description'];
        $insert_history['history_remarks']      = $history_details['history_remarks'];
        $insert_history['history_type']         = $history_details['history_type'];
        $insert_history['history_reference']    = isset($history_details['history_reference']) ? $history_details['history_reference'] : '';
        $insert_history['history_reference_id'] = isset($history_details['history_reference_id']) ? $history_details['history_reference_id'] : 0;
        $insert_history['history_number']       = $history_details['history_number'];
        $insert_history['history_date']         = Carbon::now();
        $insert_history['history_user']         = Warehouse2::get_user_login();

        $history_id = Tbl_inventory_history::insertGetId($insert_history);

        $return = Warehouse2::insert_inventory_history_item($history_id, $history_item);

        return $return;
    }

    public static function insert_inventory_history_item($history_id, $history_item)
    {
        $history_data = Tbl_inventory_history::where('history_id',$history_id)->first();
        foreach ($history_item as $key => $value) 
        {
            $initial_qty = Tbl_inventory_history_items::history()->where('warehouse_id',$history_data->warehouse_id)->where('item_id',$value['item_id'])->orderBy('history_item_id', 'DESC')->value('running_quantity');

            $qty = 1;
            if($history_data->history_type == 'WIS')
            {
                $qty = -1;
            }

            $insert_item['history_id'] = $history_id;
            $insert_item['item_id'] = $value['item_id'];
            $insert_item['quantity'] = $value['quantity'];
            $insert_item['item_remarks'] = $value['item_remarks'];
            $insert_item['initial_quantity'] = $initial_qty != '' ? $initial_qty : 0 ; 
            $insert_item['running_quantity'] = $insert_item['initial_quantity'] + ($value['quantity'] * $qty);

            Tbl_inventory_history_items::insert($insert_item);
        }

        return 0;
    }
    public static function update_warehouse_item($record_log_id, $update)
    {
        Warehouse2::insert_item_history($record_log_id);
        Tbl_warehouse_inventory_record_log::where('record_log_id',$record_log_id)->update($update);
    }

    public static function get_all_warehousev2()
    {
        return Tbl_warehouse::selectRaw('warehouse_id, warehouse_shop_id')->where('archived',0)->get();        
    }
    public static function item_warehouse($warehouse_id)
    {
        return Tbl_item::inventory()->where('warehouse_id',$warehouse_id)->get();
    }
    public static function migrate_warehouse_inventory()
    {
        $all_warehouse = Tbl_warehouse::where('archived',0)->get();
        $return = null;

        $all_serial = Tbl_inventory_serial_number::selectRaw("item_id, serial_number")->where('archived',0)->where("item_consumed",0)->where("sold",0)->groupBy('serial_number')->get()->toArray();
            $_item = null;
        foreach ($all_warehouse as $key_warehouse => $value_warehouse) 
        {
            $all_item = Tbl_item::inventory()->where('warehouse_id',$value_warehouse->warehouse_id)->get();
            
            $total_inventory = 0;
            foreach ($all_item as $key => $value)
            {
                $log_count = 0;

                $get_log_count = Tbl_item::recordloginventory()
                                     ->where('item_id',$value->item_id)
                                     ->where('record_inventory_status',0)
                                     ->value('log_count');
                if($get_log_count)
                {
                    $log_count = $get_log_count;
                }

                $total_inventory = $value->inventory_count - $log_count;
                if($total_inventory > 0)
                {
                    $_item[$key]["item_id"]              = $value->item_id;
                    $_item[$key]["quantity"]             = $total_inventory;
                    $_item[$key]["remarks"]              = "Refill - Inventory Migrated from old warehouse";    
                    $_item[$key]["warehouse_shop_id"]    = $value_warehouse->warehouse_shop_id;        
                    $_item[$key]["warehouse_id"]         = $value_warehouse->warehouse_id;          
                    $_item[$key]["ref_name"]             = 'inventory_migrate';
                }
            }
            // if(count($_item) > 0)
            // {
            //     $return = Warehouse2::refill_bulk($value_warehouse->warehouse_shop_id, $value_warehouse->warehouse_id, "inventory_migrate", 0 , "Refill - Inventory Migrated from old warehouse", $_item);
            // }
        }

        return $_item;       
    }
    public static function get_codes($warehouse_id, $start_date, $end_date, $transaction_type = '', $code_type = 'membership_code')
    {
        $data = Tbl_warehouse_inventory_record_log::warehouse()->item()->slotinfo()->where("item_in_use",'used')->where("record_inventory_status",1)->where('record_warehouse_id',$warehouse_id)->whereBetween('record_log_date_updated',[$start_date, $end_date]);

        if($transaction_type != '')
        {
            if($transaction_type == 'online')
            {
                $data = $data->where('record_consume_ref_name', 'transaction_list');
            }
            if($transaction_type == 'offline')
            {
                $data = $data->where('record_consume_ref_name','!=', 'transaction_list');
            }
        }
        if($code_type == 'product_code')
        {
            $data = $data->where("item_type_id", '!=', 5);
            if($transaction_type != 'offline')
            {
                $data = $data->customerinfo_data();
            }
        }
        else
        {
            $data = $data->customerinfo();
        }

        return $data->get();
    }
    public static function load_warehouse_list($shop_id, $user_id, $parent = 0, $margin_left = 0)
    {
        $warehouse = Tbl_warehouse::where('warehouse_shop_id', $shop_id)->where('warehouse_parent_id', $parent)->get();

        $return = null;
        
        foreach ($warehouse as $key => $value) 
        {
            $check_if_owned = Tbl_user_warehouse_access::where("user_id",$user_id)->where("warehouse_id",$value->warehouse_id)->first();
            if($check_if_owned)
            {

                $data['tr_class'] = 'tr-sub-'.$value->warehouse_parent_id.' tr-parent-'.$parent.' ';
                $data['warehouse'] = $value;
                $data['margin_left'] = 'style="margin-left:'.$margin_left.'px"';

                $return .= view('member.warehousev2.warehouse_list_tr',$data)->render();

                $count = Tbl_warehouse::where("warehouse_parent_id", $value->warehouse_id)->count();
                if($count != 0)
                {
                    $return .= Self::load_warehouse_list($shop_id, $user_id, $value->warehouse_id, $margin_left + 30);
                }                
            }

        }
        return $return;
    }
    public static function load_all_warehouse_select($shop_id, $user_id, $parent = 0, $warehouse_id_selected = 0, $excluded_warehouse = 0)
    {
        $return = null;
        $warehouse = Tbl_warehouse::where('warehouse_shop_id', $shop_id)->where('warehouse_parent_id', $parent);
        if($excluded_warehouse)
        {
            $warehouse = $warehouse->where('warehouse_id', '!=', $excluded_warehouse);
        }
        $warehouse = $warehouse->get();
        foreach ($warehouse as $key => $value) 
        {
            $check_if_owned = Tbl_user_warehouse_access::where("user_id",$user_id)->where("warehouse_id",$value->warehouse_id)->first();
            if($check_if_owned)
            {
                $data['warehouse'] = $value;
                $data['warehouse_id'] = $warehouse_id_selected;
                $return .= view('member.warehousev2.load_warehouse_v2',$data)->render();
                $count = Tbl_warehouse::where("warehouse_parent_id", $value->warehouse_id)->count();
                if($count != 0)
                {
                    $return .= Self::load_all_warehouse_select($shop_id, $user_id, $value->warehouse_id, $warehouse_id_selected);
                } 
            }
        }
        return $return;
    }
}