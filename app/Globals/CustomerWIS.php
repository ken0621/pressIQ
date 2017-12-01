<?php
namespace App\Globals;

use App\Models\Tbl_customer;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_customer_wis;
use App\Models\Tbl_warehouse_inventory_record_log;
use App\Models\Tbl_customer_wis_item;

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
class CustomerWIS
{   
    public static function get_customer($shop_id, $customer_id = 0)
    {
        $data = Tbl_customer::where('shop_id',$shop_id)->where('archived',0);
        if($customer_id != 0)
        {
            $data = $data->where('customer_id',$customer_id);
        }
        return $data->get();
    }

    public static function get_consume_validation($shop_id, $warehouse_id, $item_id, $quantity, $remarks)
    {
        $return = null;
        $check_warehouse = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();

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
    public static function customer_create_wis($shop_id, $remarks, $ins, $_item)
    {
        $validate = null;
        $warehouse_id = $ins['cust_wis_from_warehouse'];
        // dd($_item);
        foreach ($_item as $key => $value)
        {
            $validate .= CustomerWIS::get_consume_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks']);
        }
        
        $check = Tbl_customer_wis::where('cust_wis_number',$ins['cust_wis_number'])->where('cust_wis_shop_id',$shop_id)->first();
        //die(var_dump($check));
 
        if($check)
        {
            $validate .= 'WIS number already exist';
        }

        if(!$validate)
        {
            $wis_id = Tbl_customer_wis::insertGetId($ins);
            $reference_name = 'customer_wis';

            $return = Warehouse2::consume_bulk($shop_id, $warehouse_id, $reference_name, $wis_id ,$remarks ,$_item);

            if(!$return)
            {
                $get_item = Tbl_warehouse_inventory_record_log::where('record_consume_ref_name','customer_wis')->where('record_consume_ref_id',$wis_id)->get();

                $ins_customer_item = null;
                foreach ($get_item as $key_item => $value_item)
                {
                    $ins_customer_item[$key_item]['cust_wis_id'] = $wis_id;
                    $ins_customer_item[$key_item]['cust_wis_record_log_id'] = $value_item->record_log_id;
                }

                if($ins_customer_item)
                {
                    Tbl_customer_wis_item::insert($ins_customer_item);
                    $validate = 1;
                }
            }
        }

        return $validate;
    }

    public static function get_all_customer_wis($shop_id = 0, $status = 'pending', $current_warehouse = 0)
    {
        $data = Tbl_customer_wis::InventoryItem()->where('cust_wis_shop_id',$shop_id)->where('cust_wis_status', $status)->groupBy
        ('tbl_customer_wis.cust_wis_id')->where('cust_wis_from_warehouse', $current_warehouse)->get();
    
        //die(var_dump($data));
        return $data;

    }
    public static function get_customer_wis_data($cust_wis_id)
    {
        return Tbl_customer_wis::where('cust_wis_shop_id',WarehouseTransfer::getShopId())->where('cust_wis_id',$cust_wis_id)->first();
    }

    public static function update_customer_wis($shop_id, $cust_wis_id, $update)
    {
        return Tbl_customer_wis::where('cust_wis_shop_id',$shop_id)->where('cust_wis_id',$cust_wis_id)->update($update);
    }
    public static function get_customer_wis_item($cust_wis_id)
    {
        $return_item = Tbl_warehouse_inventory_record_log::item()->inventory()->where('record_consume_ref_name','customer_wis')->where('record_consume_ref_id',$cust_wis_id)->groupBy('record_item_id')->get();

        return $return_item;
    }

    public static function check_customer_existence($shop_id, $customer_id = 0)
    {
        return Tbl_customer::where('customer_id',$customer_id)->where('shop_id',$shop_id)->first();
    }
    public static function receive_item($shop_id, $wis_id, $ins_rr, $_item = array())
    {
        $return = null;

        $wis_data = CustomerWIS::get_customer_wis_data($wis_id);

        //die(var_dump($ins_rr['cust_wis_id']));

        if($wis_data->destination_customer_id)
        {

            if($wis_data->destination_customer_id != $ins_rr['cust_wis_id'])
            {
                
                $warehouse_name = Warehouse2::check_warehouse_existence($shop_id, $ins_rr['cust_wis_id'])->warehouse_name;
                die(var_dump($warehouse_name));
                $return .= '<b>'.ucfirst($warehouse_name).'</b> is not supposed to received items in this WIS - ('.$wis_data->wis_number.')';
            }   
        }

        foreach ($_item as $key => $value) 
        {
            $return .= Warehouse2::transfer_validation($shop_id, $wis_data->wis_from_warehouse, $ins_rr['warehouse_id'], $value['item_id'], $value['quantity'], 'rr');
        }


        $check = Tbl_warehouse_receiving_report::where('rr_number',$ins_rr['rr_number'])->where('rr_shop_id',$shop_id)->first();
        if($check)
        {
            $return .= 'RR number already exist';
        }

        if(!$return)
        {
            $rr_id = Tbl_warehouse_receiving_report::insertGetId($ins_rr);

            $source['name'] = 'wis';
            $source['id'] = $wis_id;    

            $to['name'] = 'rr';
            $to['id'] = $rr_id; 

            $val = Warehouse2::transfer_bulk($shop_id, $wis_data->wis_from_warehouse, $ins_rr['warehouse_id'], $_item, $ins_rr['rr_remarks'], $source, $to);

            if(!$val)
            {
                $get_item = Tbl_warehouse_inventory_record_log::where('record_source_ref_name','rr')->where('record_source_ref_id',$rr_id)->get();

                $ins_report_item = null;
                foreach ($get_item as $key_item => $value_item)
                {
                    $ins_report_item[$key_item]['rr_id'] = $rr_id;
                    $ins_report_item[$key_item]['record_log_item_id'] = $value_item->record_log_id;
                }

                if($ins_report_item)
                {
                    Tbl_warehouse_receiving_report_item::insert($ins_report_item);

                    if($wis_data->wis_status == 'confirm')
                    {
                        $udpate_wis['wis_status'] = 'received';
                        WarehouseTransfer::update_wis($shop_id, $wis_id, $udpate_wis);  
                    }
                }
            }

            return $val;
        }
        else
        {
            return $return;
        }
    }
}