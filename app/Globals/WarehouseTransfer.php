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
use App\Models\Tbl_price_level;
use App\Models\Tbl_price_level_item;
use App\Models\Tbl_sub_warehouse;
use App\Models\Tbl_settings;

use App\Models\Tbl_warehouse_issuance_report;
use App\Models\Tbl_warehouse_issuance_report_item;
use App\Models\Tbl_warehouse_issuance_report_itemline;
use App\Models\Tbl_warehouse_receiving_report;
use App\Models\Tbl_warehouse_receiving_report_item;
use App\Models\Tbl_warehouse_receiving_report_itemline;

use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Warehouse2;
use App\Globals\Purchasing_inventory_system;
use App\Globals\Tablet_global;
use App\Globals\Currency;
use Session;
use DB;
use Carbon\carbon;
use App\Globals\Merchant;
use Validator;
class WarehouseTransfer
{   
	public static function get_all_wis($shop_id = 0, $status = 'pending', $current_warehouse = 0)
	{
		$data = Tbl_warehouse_issuance_report::inventory_item()->where('wis_shop_id',$shop_id)->where('wis_status', $status)->groupBy('tbl_warehouse_issuance_report.wis_id')->where('wis_from_warehouse', $current_warehouse)->get();
		foreach ($data as $key => $value) 
		{
			$count = Tbl_warehouse_receiving_report::wis()->inventory_item()->where('tbl_warehouse_receiving_report.wis_id',$value->wis_id)->count();

			$data[$key]->total_received_qty = $count;
		}

		return $data;
	}
	public static function get_all_rr($shop_id = 0)
	{
		return Tbl_warehouse_receiving_report::wis()->inventory_item()->where('rr_shop_id',$shop_id)->groupBy('tbl_warehouse_receiving_report.rr_id')->orderBy('tbl_warehouse_receiving_report.rr_id','DESC')->get();
	}
	public static function scan_item($shop_id, $item_code)
	{
		$chk = Tbl_item::where('item_id',$item_code)->where('item_type_id',1)->where('shop_id',$shop_id)->first();
		$data['item_id'] = $item_code;
		if(!$chk)
		{
			$data = null;
			/* SEARCH FOR OTHER ITEM NUMBER HERE*/

			/* - WAREHOUSE SERIAL - */
			$a = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',Warehouse2::get_current_warehouse($shop_id))->where('record_shop_id', $shop_id)->where('record_serial_number',$item_code)->value('record_item_id');
			if($a)
			{
				$data['item_id'] = $a;
				$data['item_serial'] = $item_code;
			}
		}

		return $data;
	}
	public static function add_item_to_list($shop_id, $item_id, $quantity = 1, $serial = '', $is_change_qty = 0)
	{
		$first_data = Session::get('wis_item'); 

		$data = Session::get('wis_item');

		$data[$item_id]['item_id'] = $item_id;
		$data[$item_id]['item_name'] = Item::info($item_id)->item_name;
		$data[$item_id]['item_sku'] = Item::info($item_id)->item_sku;
		$data[$item_id]['item_quantity'] = $quantity;
		$data[$item_id]['item_serial'] = null;
		if($serial != '')
		{
			$data[$item_id]['item_serial'][0] = $serial;
		}

		$check = Session::get('wis_item');
		if(count($check) > 0)
		{
			if(isset($first_data[$item_id]))
			{
				$data[$item_id]['item_id'] = $item_id;
				$data[$item_id]['item_name'] = Item::info($item_id)->item_name;
				$data[$item_id]['item_sku'] = Item::info($item_id)->item_sku;
				$data[$item_id]['item_quantity'] = $first_data[$item_id]['item_quantity'] + $quantity;
				if($is_change_qty == 1)
				{
					$data[$item_id]['item_quantity'] = $quantity;
				}

				if(count($first_data[$item_id]['item_serial']) > 0)
				{
					foreach ($first_data[$item_id]['item_serial'] as $key => $value) 
					{
						if($serial != '')
						{
							if($value != $serial)
							{
								$data[$item_id]['item_serial'][$key] = $value;
							}						
						}
					}

					$data[$item_id]['item_serial'][count($first_data[$item_id]['item_serial']) + 1] = $serial;
				}


				unset(Session::get('wis_item')[$item_id]);
			}
		}
		Session::put('wis_item', $data);
	}
	public static function delete_item_from_list($item_id)
	{
		$data = Session::get('wis_item');
		unset($data[$item_id]);

		Session::put('wis_item', $data);
	}
	public static function update_wis($shop_id, $wis_id, $up)
	{
		return Tbl_warehouse_issuance_report::where('wis_shop_id',$shop_id)->where('wis_id',$wis_id)->update($up);
	}
	public static function create_wis($shop_id, $remarks, $ins, $_item)
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
        	$val = Self::wis_insertline($wis_id, $_item);
            if(is_numeric($val))
            {
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
        }

        return $validate;
	}

    public static function wis_insertline($wis_id, $insert_item)
    {
        $return = null;
        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {
            $itemline[$key]['wt_wis_id']      	= $wis_id;
            $itemline[$key]['wt_item_id']     	= $value['item_id'];
            $itemline[$key]['wt_description'] 	= $value['item_description'];
            $itemline[$key]['wt_qty']         	= $value['item_qty'];
            $itemline[$key]['wt_orig_qty']      = $value['item_qty'];
            $itemline[$key]['wt_um']           	= $value['item_um'];
            $itemline[$key]['wt_rate']          = $value['item_rate'];
            $itemline[$key]['wt_amount']     	= $value['item_amount'];
            $itemline[$key]['wt_refname']     	= $value['item_refname'];
            $itemline[$key]['wt_refid']       	= $value['item_refid'];
        }
        if(count($itemline) > 0)
        {
            Tbl_warehouse_issuance_report_itemline::insert($itemline);
            $return = 1;
        }

        return $return;
    }
    public static function rr_insertline($rr_id, $insert_item)
    {
        $return = null;
        $itemline = null;
        foreach ($insert_item as $key => $value) 
        {
            $itemline[$key]['rr_id']      		= $rr_id;
            $itemline[$key]['rr_item_id']     	= $value['item_id'];
            $itemline[$key]['rr_description'] 	= $value['item_description'];
            $itemline[$key]['rr_qty']         	= $value['item_qty'];
            $itemline[$key]['rr_orig_qty']      = $value['item_qty'];
            $itemline[$key]['rr_um']           	= $value['item_um'];
            $itemline[$key]['rr_rate']          = $value['item_rate'];
            $itemline[$key]['rr_amount']     	= $value['item_amount'];
            $itemline[$key]['rr_refname']     	= $value['item_refname'];
            $itemline[$key]['rr_refid']       	= $value['item_refid'];
        }
        if(count($itemline) > 0)
        {
            Tbl_warehouse_receiving_report_itemline::insert($itemline);
            $return = 1;
        }

        return $return;
    }
    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
    }
	public static function get_wis_data($wis_id)
	{
		return Tbl_warehouse_issuance_report::where('wis_shop_id',WarehouseTransfer::getShopId())->where('wis_id',$wis_id)->first();
	}
	public static function get_wis_item($wis_id)
	{
        $return_item = Tbl_warehouse_inventory_record_log::item()->inventory()->where('record_consume_ref_name','wis')->where('record_consume_ref_id',$wis_id)->groupBy('record_item_id')->get();

		return $return_item;
	}
	public static function get_wis_itemline($wis_id)
	{
		$data = Tbl_warehouse_issuance_report_itemline::item()->um()->where("wt_wis_id", $wis_id)->get();
		foreach($data as $key => $value) 
        {
            $qty = UnitMeasurement::um_qty($value->wt_um);

            $total_qty = $value->wt_orig_qty * $qty;
            $data[$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->wt_um);
        }
        return $data;
	}
	public static function get_rr_data($rr_id)
	{
		return Tbl_warehouse_receiving_report::where('rr_id',$rr_id)->first();
	}
	public static function get_rr_item($wis_id)
	{
        $return_item = Tbl_warehouse_inventory_record_log::item()->inventory()->where('record_source_ref_name','wis')->where('record_source_ref_id',$wis_id)->groupBy('record_item_id')->get();

		return $return_item;
	}
	public static function print_wis_item($wis_id)
	{
		return Tbl_warehouse_issuance_report_item::inventory_item()->where('wis_id',$wis_id)->groupBy('record_item_id')->get();
	}
	public static function print_rr_item($rr_id)
	{
		return Tbl_warehouse_receiving_report_item::inventory_item()->where('rr_id',$rr_id)->groupBy('record_item_id')->get();
	}

	public static function get_warehouse_data($warehouse_id)
	{
        return Tbl_warehouse::shop()->where('warehouse_id',$warehouse_id)->first();
	}
	public static function get_code($shop_id)
	{
        $code = strtoupper(str_random(6));

        $ctr = Tbl_warehouse_issuance_report::where("wis_shop_id",$shop_id)->where('receiver_code',$code)->count();
        if($ctr > 0)
        {
            $code = Self::check_code($shop_id, strtoupper(str_random(6)));
        }

        return $code;
	}

    public static function check_code($shop_id, $code = '')
    {
        $ctr = Tbl_warehouse_issuance_report::where("wis_shop_id",$shop_id)->where('receiver_code',$code)->count();
        if($ctr > 0)
        {
            $code = Self::check_code($shop_id, strtoupper(str_random(6)));
        }

        return $code;
    }
    public static function check_wis($shop_id, $warehouse_id, $receiver_code)
    {
    	$check = Tbl_warehouse_issuance_report::where('wis_shop_id',$shop_id)->where('wis_from_warehouse', $warehouse_id)->where('receiver_code',$receiver_code)->first();

    	$return = null;
    	if($check)
    	{
    		$return = $check->wis_id;
    	}
    	else
    	{
    		$return = 'Code does not match any record.';
    	}

    	return $return;
    }
    public static function create_rr($shop_id, $wis_id, $ins_rr, $_item = array())
    {
    	$return = null;

        $wis_data = WarehouseTransfer::get_wis_data($wis_id);

        if($wis_data->destination_warehouse_id)
        {
	        if($wis_data->destination_warehouse_id != $ins_rr['warehouse_id'])
	        {
	        	$warehouse_name = Warehouse2::check_warehouse_existence($shop_id, $ins_rr['warehouse_id'])->warehouse_name;
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
	        $val = Self::rr_insertline($rr_id, $_item);
            if(is_numeric($val))
            {

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
	        }

        	return $val;
    	}
    	else
    	{
    		return $return;
    	}
    }
}