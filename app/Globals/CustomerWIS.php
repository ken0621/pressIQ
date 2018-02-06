<?php
namespace App\Globals;

use App\Models\Tbl_customer;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_customer_wis;
use App\Models\Tbl_customer_wis_item_line;
use App\Models\Tbl_warehouse_inventory_record_log;
use App\Models\Tbl_customer_estimate;
use App\Models\Tbl_customer_wis_item;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_settings;

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
    public static function get_sales_info($shop_id, $transaction_id)
    {
        $return['info'] = Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('inv_id', $transaction_id)->first();
        $return['info_item'] = Tbl_customer_invoice_line::where('invline_inv_id', $transaction_id)->get();

        return $return;
    }
    public static function get_inv($shop_id, $inv_id)
    {
        return Tbl_customer_invoice::where('inv_shop_id', $shop_id)->where('inv_id', $inv_id)->first();
    }
    public static function get_inv_item($shop_id, $inv_id)
    {
        return Tbl_customer_invoice_line::invoice_item()->um()->invoice()->where('inv_shop_id', $shop_id)->where('invline_inv_id', $inv_id)->get();
    }
    public static function settings($shop_id)
    {
        return Tbl_settings::where('settings_key','customer_wis')->where('shop_id', $shop_id)->value('settings_value');
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
    public static function applied_transaction($shop_id)
    {
        $applied_transaction = Session::get('applied_transaction_wis');
        if(count($applied_transaction) > 0)
        {
            foreach ($applied_transaction as $key => $value) 
            {
                $update['item_delivered'] = 1;
                Tbl_customer_invoice::where("inv_id", $key)->where('inv_shop_id', $shop_id)->update($update);
            }
        }
    }
    public static function customer_create_wis($shop_id, $remarks, $ins, $_item = array(), $insert_item = array())
    {
        $validate = null;
        $warehouse_id = $ins['cust_wis_from_warehouse'];
        // dd($_item);

        if(count($_item) <= 0)
        {
            $validate .= "Please Select item.<br>";
        }
        if(!$ins['destination_customer_id'])
        {
            $validate .= "Please Select customer.<br>";
        }
        if(!$validate)
        {
            foreach ($_item as $key => $value)
            {
                $validate .= CustomerWIS::get_consume_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks']);
            }        
        }
        
        $check = Tbl_customer_wis::where('transaction_refnum',$ins['transaction_refnum'])->where('cust_wis_shop_id',$shop_id)->first();
        //die(var_dump($check));
 
        if($check)
        {
            $validate .= 'WIS number already exist';
        }
        if(!$validate)
        {
            $wis_id = Tbl_customer_wis::insertGetId($ins);
            $reference_name = 'customer_wis';

            /* TOTAL */
            $overall_price = collect($insert_item)->sum('item_amount');

            /* Transaction Journal */
            $entry["reference_module"]  = 'warehouse-issuance-slip';
            $entry["reference_id"]      = $wis_id;
            $entry["name_id"]           = $ins['destination_customer_id'];
            $entry["total"]             = $overall_price;
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';

            $val = Self::insertline($wis_id, $insert_item, $entry);
            if(is_numeric($val))
            {
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
                        $validate = $wis_id;
                    }
                }                
            }
        }

        return $validate;
    }
    public static function customer_update_wis($wis_id, $shop_id, $remarks, $ins, $_item = array(), $insert_item = array())
    {
        $old = Tbl_customer_wis::where("cust_wis_id", $wis_id);


        $validate = null;

        $warehouse_id = $ins['cust_wis_from_warehouse'];
        // dd($_item);

        if(count($_item) <= 0)
        {
            $validate .= "Please Select item.<br>";
        }
        if(!$ins['destination_customer_id'])
        {
            $validate .= "Please Select customer.<br>";
        }
        if(!$validate)
        {
            foreach ($_item as $key => $value)
            {
                $validate .= CustomerWIS::get_consume_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks']);
            }        
        }
        
        /*$check = Tbl_customer_wis::where('transaction_refnum',$ins['transaction_refnum'])->where('cust_wis_shop_id',$shop_id)->first();
        //die(var_dump($check));
 
        if($check)
        {
            $validate .= 'WIS number already exist';
        }*/
        if(!$validate)
        {
            Tbl_customer_wis::where("cust_wis_id", $wis_id)->update($ins);
            //die(var_dump($wis_id));
           
            //Tbl_customer_wis::insertGetId($ins);
            $reference_name = 'customer_wis';
            //Tbl_purchase_order::where("po_id", $po_id)->update($update);

            /* TOTAL */
            $overall_price = collect($insert_item)->sum('item_amount');

            /* Transaction Journal */
            $entry["reference_module"]  = 'warehouse-issuance-slip';
            $entry["reference_id"]      = $wis_id;
            $entry["name_id"]           = $ins['destination_customer_id'];
            $entry["total"]             = $overall_price;
            $entry["vatable"]           = '';
            $entry["discount"]          = '';
            $entry["ewt"]               = '';

            Tbl_customer_wis_item_line::where("itemline_wis_id", $wis_id)->delete();
            //Self::insertLine($po_id, $insert_item);

            $val = Self::insertline($wis_id, $insert_item, $entry);
            if(is_numeric($val))
            {
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
                        $validate = $wis_id;
                    }
                }                
            }
        }

        return $validate;
    }
    public static function insertline($cust_wis_id, $insert_item, $entry)
    {
        $return = null;
        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {
            $itemline[$key]['itemline_wis_id']      = $cust_wis_id;
            $itemline[$key]['itemline_item_id']     = $value['item_id'];
            $itemline[$key]['itemline_description'] = $value['item_description'];
            $itemline[$key]['itemline_qty']         = $value['item_qty'];
            $itemline[$key]['itemline_um']          = $value['item_um'];
            $itemline[$key]['itemline_rate']        = $value['item_rate'];
            $itemline[$key]['itemline_amount']      = $value['item_amount'];
        }
        if(count($itemline) > 0)
        {
            Tbl_customer_wis_item_line::insert($itemline);
            $return = AccountingTransaction::entry_data($entry, $insert_item);
        }

        return $return;
    }

    public static function get_all_customer_wis($shop_id = 0, $status = 'pending', $current_warehouse = 0)
    {
        $data = Tbl_customer_wis::CustomerInfo()->InventoryItem()->where('cust_wis_shop_id',$shop_id)->where('cust_wis_status', $status)->groupBy
        ('tbl_customer_wis.cust_wis_id')->where('cust_wis_from_warehouse', $current_warehouse)->get();
    
        //die(var_dump($data));
        return $data;

    }
    public static function get_customer_wis_data($cust_wis_id)
    {
        return Tbl_customer_wis::customerinfo()->where('cust_wis_shop_id',WarehouseTransfer::getShopId())->where('cust_wis_id',$cust_wis_id)->first();
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
    public static function get_wis_line($cust_wis_id)
    {
        return Tbl_customer_wis_item_line::um()->where("itemline_wis_id", $cust_wis_id)->get();
    }

    public static function print_customer_wis_item($wis_id)
    {
        return Tbl_customer_wis_item::InventoryItem()->where('cust_wis_id',$wis_id)->groupBy('record_item_id')->get();
    }
    public static function customer_wis_itemline($wis_id)
    {
        $data = Tbl_customer_wis_item_line::item()->um()->where('itemline_wis_id',$wis_id)->get();

        foreach($data as $key => $value) 
        {
            $qty = UnitMeasurement::um_qty($value->itemline_um);
            $total_qty = $value->itemline_qty * $qty;
            $data[$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->itemline_um);
        }
        return $data;
    }
    public static function countTransaction($shop_id, $customer_id)
    {
        $so = Tbl_customer_estimate::where('est_shop_id',$shop_id)->where("est_customer_id",$customer_id)->where("est_status","accepted")->count();
        $so = 0;
        $inv = TransactionSalesInvoice::countUndeliveredSalesInvoice($shop_id, $customer_id);
        $sr = TransactionSalesReceipt::countUndeliveredSalesReceipt($shop_id, $customer_id);
        return $inv + $sr;
    }

    /*public static function check_customer_existence($shop_id, $customer_id = 0)
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
                die(var_dump($wis_data->destination_customer_id));

                $warehouse_name = Warehouse2::check_warehouse_existence($shop_id, $ins_rr['cust_wis_id'])->warehouse_name;
                
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
    }*/
}