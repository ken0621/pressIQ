<?php
namespace App\Globals;

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

    public static function create_customer_wis($shop_id, $remarks, $ins, $_item)
	{
        $validate = null;
        $warehouse_id = $ins['wis_from_warehouse'];
        // dd($_item);
        foreach ($_item as $key => $value)
        {
            $serial = isset($value['serial']) ? $value['serial'] : null;
            $validate .= Warehouse2::consume_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks'], $serial);
        }

        $check = Tbl_warehouse_issuance_report::where('wis_number',$ins['wis_number'])->where('wis_shop_id',$shop_id)->first();
        if($check)
        {
        	$validate .= 'WIS number already exist';
        }

        if(!$validate)
        {
        	$wis_id = Tbl_warehouse_issuance_report::insertGetId($ins);
        	$reference_name = 'wis';

        	$return = Warehouse2::consume_bulk($shop_id, $warehouse_id, $reference_name, $wis_id ,$remarks ,$_item);

        	if(!$return)
        	{
        		$get_item = Tbl_warehouse_inventory_record_log::where('record_consume_ref_name','wis')->where('record_consume_ref_id',$wis_id)->get();

        		$ins_report_item = null;
        		foreach ($get_item as $key_item => $value_item)
        		{
        			$ins_report_item[$key_item]['wis_id'] = $wis_id;
        			$ins_report_item[$key_item]['record_log_item_id'] = $value_item->record_log_id;
        		}

        		if($ins_report_item)
        		{
        			Tbl_warehouse_issuance_report_item::insert($ins_report_item);
        			$validate = 1;
        		}
        	}
        }

        return $validate;
	}

}