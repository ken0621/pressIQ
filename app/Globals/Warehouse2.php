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
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_audit_trail;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Purchasing_inventory_system;
use App\Globals\Tablet_global;
use App\Globals\Currency;
use App\Models\Tbl_price_level;
use App\Models\Tbl_price_level_item;
use App\Models\Tbl_sub_warehouse;
use Session;
use DB;
use Carbon\carbon;
use App\Globals\Merchant;
use Validator;
class Warehouse2
{   
	public static function get_current_warehouse($shop_id)
	{
		return session('warehouse_id_'.$shop_id);
	}
    public static function get_item_qty($warehouse_id, $item_id)
    {
        $count = Tbl_warehouse_inventory_record_log::where("record_warehouse_id",$warehouse_id)
                                                   ->where("record_item_id",$item_id)
                                                   ->where("record_inventory_status",0)
                                                   ->count();
        return $count;
    }
    public static function check_warehouse_existence($shop_id, $warehouse_id = 0)
    {
        return Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();
    }
	public static function refill_validation($shop_id, $warehouse_id, $item_id, $quantity, $remarks, $serial = array())
	{
		$return['status'] = null;
    	$return['message'] = null;
        $check_warehouse = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();


    	$serial_qty = count($serial);
    	if($serial_qty != 0)
    	{
    		if($serial_qty != $quantity)
    		{
		    	$return['status'] = 'error';
		    	$return['message'] .= "The serial number are not equal from the quantity. <br> ";
    		}
    	}
    	if($quantity < 0)
    	{
	    	$return['status'] = 'error';
	    	$return['message'] .= "The quantity is less than 1. <br> ";
    	}
    	if(!$check_warehouse)
    	{
	    	$return['status'] = 'error';
	    	$return['message'] .= "The warehouse doesn't belong to your account <br>";
    	}
    	if($return['message'])
    	{
    		$return['status'] = 'error';
    	}

    	return $return;
	}
    public static function refill($shop_id, $warehouse_id, $item_id = 0, $quantity = 1, $remarks = '', $source = array(), $serial = array())
    {
    	$check_warehouse = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();

    	$return['status'] = null;
    	$return['message'] = null;

    	$serial_qty = count($serial);
    	if($serial_qty != 0)
    	{
    		if($serial_qty != $quantity)
    		{
		    	$return['status'] = 'error';
		    	$return['message'] .= "The serial number are not equal from the quantity. <br> ";
    		}
    	}
    	if($quantity < 0)
    	{
	    	$return['status'] = 'error';
	    	$return['message'] .= "The quantity is less than 1. <br> ";
    	}
    	if(!$check_warehouse)
    	{
	    	$return['status'] = 'error';
	    	$return['message'] .= "The warehouse doesn't belong to your account <br>";
    	}

    	if(!$return['status'])
    	{  
	        $insert_slip['warehouse_id']                 = $warehouse_id;
	        $insert_slip['inventory_remarks']            = $remarks;
	        $insert_slip['inventory_slip_date']          = Carbon::now();
	        $insert_slip['inventory_slip_shop_id']       = $shop_id;
	        $insert_slip['slip_user_id']				 = Warehouse::getUserid();
	        $insert_slip['inventroy_source_reason']      = isset($source['name']) ? $source['name'] : '';
	        $insert_slip['inventory_source_id']			 = isset($source['id']) ? $source['id'] : 0;
	        $insert_slip['slip_user_id']				 = Warehouse::getUserid();
            $slip_id = Tbl_inventory_slip::insertGetId($insert_slip);

    		for ($ctr_qty = 0; $ctr_qty < $quantity; $ctr_qty++) 
    		{
    			$insert['record_shop_id'] 			 = $shop_id;
    			$insert['record_item_id'] 			 = $item_id;
    			$insert['record_warehouse_id'] 	  	 = $warehouse_id;
    			$insert['record_item_remarks']  	 = $remarks;
    			$insert['record_warehouse_slip_id']  = $slip_id;
    			$insert['record_source_ref_name']	 = isset($source['name']) ? $source['name'] : '';
    			$insert['record_source_ref_id']	     = isset($source['id']) ? $source['id'] : 0;
                $insert['record_log_date_updated']   = Carbon::now();

    			if($serial_qty > 0)
    			{
    				$insert['record_serial_number'] = $serial[$ctr_qty];
    			}
    			Tbl_warehouse_inventory_record_log::insert($insert);
    		}
    		$return['status'] = 'success';
    	}

    	return $return;
    }
    public static function refill_bulk($shop_id, $warehouse_id, $_item)
    {
    	foreach ($_item as $key => $value)
    	{
            $serial = isset($value['serial']) ? $value['serial'] : array();
    		$validate = Warehouse2::refill_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks'], $serial);
    	}

		if(!$validate['message'])
		{
	    	foreach ($_item as $key => $value) 
	    	{
                $serial = isset($value['serial']) ? $value['serial'] : array();
	    		$validate =	Warehouse2::refill($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks'], $value['source'], $serial);
	    	}
	    }

    	return $validate;
    }
    public static function transfer_validation($shop_id, $wh_from, $wh_to, $item_id, $quantity, $remarks, $serial = array())
    {
        $return['status'] = null;
        $return['message'] = null;

        $item_data = Item::get_item_details($item_id);
        if(Warehouse2::check_warehouse_existence($shop_id, $wh_from) && Warehouse2::check_warehouse_existence($shop_id, $wh_to))
        {
            $warehouse_qty = Warehouse2::get_item_qty($wh_from, $item_id);

            if($item_data)
            {
                $get_data = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$warehouse_id)->where('record_item_id',$item_id)->first();
                if($quantity < 0)
                {
                    $return['status'] = 'error';
                    $return['message'] .= 'The quantity of '.$item_data->item_name.' is less than one. <br>';                
                }
                if(!$get_data)
                {
                    $return['status'] = 'error';
                    $return['message'] .= 'The item '.$item_data->item_name.' does not exist in this warehouse. <br>';                
                }
                if($warehouse_qty < $quantity)
                {
                    $return['status'] = 'error';
                    $return['message'] .= 'The quantity of '.$item_data->item_name.' is not enough to transfer <br>';
                }
                if(count($serial) > 0)
                {
                    if($serial_qty != $quantity)
                    {
                        $return['status'] = 'error';
                        $return['message'] .= "The serial number are not equal from the quantity. <br> ";
                    }
                    foreach ($serial as $key => $value) 
                    {
                        $check_serial = Tbl_warehouse_inventory_record_log::where('record_serial_number',$value)->where('record_item_id',$item_id)->where('record_warehouse_id',$wh_from)->first();
                        if(!$check_serial)
                        {
                            $return['status'] = 'error';
                            $return['message'] .= "The serial number are doesn't belong to ".$item_data->item_name.". <br> ";
                        }
                    }
                }
            }
            else
            {
                $return['status'] = 'error';
                $return['message'] .= "The item number ". $item_id." doesn't exist!";            
            }
        }
        else
        {
            $return['status'] = 'error';
            $return['message'] .= "The warehouses does not exist!";            
        }

        return $return;
    }
    public static function transfer($shop_id, $wh_from, $wh_to, $item_id, $quantity, $remarks, $serial = array())
    {
        $return['status'] = null;
        $return['message'] = null;

        $return = Warehouse2::transfer_validation($shop_id, $wh_from, $wh_to, $item_id, $quantity, $remarks, $serial);

        if(!$return['message'])
        {
            for ($ctr_qty = 0; $ctr_qty < $quantity ; $ctr_qty++)
            {
                $get_data = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$warehouse_id)->where('record_item_id',$item_id)->first();
                if(count($serial) > 0)
                {
                    $get_data = Tbl_warehouse_inventory_record_log::where('record_warehouse_id',$warehouse_id)->where('record_item_id',$item_id)->where('record_serial_number',$serial[$ctr_qty])->first();
                }
                Warehouse2::insert_item_history($get_data->record_log_id);

                $update['record_warehouse_id'] = $wh_to;
                $update['record_item_remarks'] = $remarks;
                $update['record_log_date_updated'] = Carbon::now();
                Tbl_warehouse_inventory_record_log::where('record_log_id',$get_data->record_log_id)->update($update);
            }

            $return['status'] = 'success';
        }
        return $return;
    }
    public static function transfer_bulk($shop_id, $wh_from, $wh_to, $_item)
    {
        foreach ($_item as $key => $value)
        {
            $serial = isset($value['serial']) ? $value['serial'] : array();
            $validate = Warehouse2::transfer_validation($shop_id, $wh_from, $wh_to, $value['item_id'], $value['quantity'], $value['remarks'], $serial);
        }

        if(!$validate['message'])
        {
            foreach ($_item as $key => $value)
            {
                $serial = isset($value['serial']) ? $value['serial'] : array();
                $validate = Warehouse2::transfer($shop_id, $wh_from, $wh_to, $value['item_id'], $value['quantity'], $value['remarks'], $serial);
            }
        }

        return $validate;
    }
    public static function validate_warehouse($shop_id, $insert)
    {
        $check_warehouse = Tbl_warehouse::where('warehouse_name',$insert['warehouse_name'])->where('warehouse_shop_id',$shop_id)->first();
        $return['message'] = null;
        if($check_warehouse)
        {
            $return['message'] .= "The warehouse name already exist";
        }
        if($insert['sale_price_level'] != 0)
        {
            $check_price_level = Tbl_price_level::where('price_level_id',$insert['sale_price_level'])->first();
            if(!$check_price_level)
            {
                $return['message'] .= "The sale_price_level does't exist";
            }
        }
        if($insert['purchase_price_level'] != 0)
        {
            $check_price_level = Tbl_price_level::where('price_level_id',$insert['purchase_price_level'])->first();
            if(!$check_price_level)
            {
                $return['message'] .= "The sale_price_level does't exist";
            }
        }

        return $return;        
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

        return $return
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
                $serialize[$datenow] = $get_data;

                $update['record_log_history'] = serialize($serialize);
                Tbl_warehouse_inventory_record_log::where('record_log_id',$get_data->record_log_id)->update($update);
            }
            else
            {                
                $serialize[$datenow] = $get_data;
                $update['record_log_history'] = serialize($serialize);
                Tbl_warehouse_inventory_record_log::where('record_log_id',$get_data->record_log_id)->update($update);
            }
        }
    }

    public static function consume_validation($shop_id, $warehouse_id, $item_id, $quantity, $remarks, $serial = array())
    {
        $return['status'] = null;
        $return['message'] = null;
        $check_warehouse = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();


        $serial_qty = count($serial);
        if($serial_qty != 0)
        {
            if($serial_qty != $quantity)
            {
                $return['status'] = 'error';
                $return['message'] .= "The serial number are not equal from the quantity. <br> ";
            }
        }
        if($quantity < 0)
        {
            $return['status'] = 'error';
            $return['message'] .= "The quantity is less than 1. <br> ";
        }
        if(!$check_warehouse)
        {
            $return['status'] = 'error';
            $return['message'] .= "The warehouse doesn't belong to your account <br>";
        }
        if($return['message'])
        {
            $return['status'] = 'error';
        }

        return $return;
    }
    public static function consume($shop_id, $warehouse_id, $item_id = 0, $quantity = 1, $remarks = '', $consume = array(), $serial = array())
    {
        $check_warehouse = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('warehouse_shop_id',$shop_id)->first();

        $return['status'] = null;
        $return['message'] = null;

        $serial_qty = count($serial);
        if($serial_qty != 0)
        {
            if($serial_qty != $quantity)
            {
                $return['status'] = 'error';
                $return['message'] .= "The serial number are not equal from the quantity. <br> ";
            }
        }
        if($quantity < 0)
        {
            $return['status'] = 'error';
            $return['message'] .= "The quantity is less than 1. <br> ";
        }
        if(!$check_warehouse)
        {
            $return['status'] = 'error';
            $return['message'] .= "The warehouse doesn't belong to your account <br>";
        }

        if(!$return['status'])
        {  
            $insert_slip['warehouse_id']                 = $warehouse_id;
            $insert_slip['inventory_remarks']            = $remarks;
            $insert_slip['inventory_slip_date']          = Carbon::now();
            $insert_slip['inventory_slip_shop_id']       = $shop_id;
            $insert_slip['slip_user_id']                 = Warehouse::getUserid();
            $insert_slip['inventroy_source_reason']      = isset($source['name']) ? $source['name'] : '';
            $insert_slip['inventory_source_id']          = isset($source['id']) ? $source['id'] : 0;
            $insert_slip['slip_user_id']                 = Warehouse::getUserid();
            $slip_id = Tbl_inventory_slip::insertGetId($insert_slip);

            for ($ctr_qty = 0; $ctr_qty < $quantity; $ctr_qty++) 
            {
                $insert['record_shop_id']            = $shop_id;
                $insert['record_item_id']            = $item_id;
                $insert['record_warehouse_id']       = $warehouse_id;
                $insert['record_item_remarks']       = $remarks;
                $insert['record_warehouse_slip_id']  = $slip_id;
                $insert['record_source_ref_name']    = isset($source['name']) ? $source['name'] : '';
                $insert['record_source_ref_id']      = isset($source['id']) ? $source['id'] : 0;
                $insert['record_log_date_updated']   = Carbon::now();

                if($serial_qty > 0)
                {
                    $insert['record_serial_number'] = $serial[$ctr_qty];
                }
                Tbl_warehouse_inventory_record_log::insert($insert);
            }
            $return['status'] = 'success';
        }

        return $return;
    }
    public static function consume_bulk($shop_id, $warehouse_id, $_item)
    {
        foreach ($_item as $key => $value)
        {
            $serial = isset($value['serial']) ? $value['serial'] : array();
            $validate = Warehouse2::refill_validation($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks'], $serial);
        }

        if(!$validate['message'])
        {
            foreach ($_item as $key => $value) 
            {
                $serial = isset($value['serial']) ? $value['serial'] : array();
                $validate = Warehouse2::refill($shop_id, $warehouse_id, $value['item_id'], $value['quantity'], $value['remarks'], $value['source'], $serial);
            }
        }

        return $validate;
    }
}