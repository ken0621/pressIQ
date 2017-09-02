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
use Session;
use DB;
use Carbon\carbon;
use App\Globals\Merchant;
use Validator;
class Warehouse2
{   
    public static function refill($shop_id, $warehouse_id, $item_id, $quantity, $remarks, $serial)
    {
    	$check_warehouse = Tbl_warehouse::where('warehouse_id',$warehouse_id)->where('shop_id',$shop_id)->first();

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
    		for ($ctr_qty = 0; $ctr_qty < $quantity; $ctr_qty++) 
    		{
    			$insert['record_shop_id'] 		= $shop_id;
    			$insert['record_item_id'] 		= $item_id;
    			$insert['record_warehouse_id']  = $warehouse_id;
    			$insert['record_item_remarks']  = $remarks;

    			if($serial_qty > 0)
    			{
    				$insert['record_serial_number'] = $serial[$ctr_qty];
    			}
    			// Tbl_warehouse_inventory_record_log::insert($insert);
    		}
    	}

    	return $return;
    }
}