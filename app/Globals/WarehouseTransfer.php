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
use App\Models\Tbl_warehouse_receiving_report;
use App\Models\Tbl_warehouse_receiving_report_item;

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
	public static function get_all_wis($shop_id = 0, $status = 'pending')
	{
		$data = Tbl_warehouse_issuance_report::inventory_item()->where('wis_shop_id',$shop_id)->where('wis_status', $status)->groupBy
		('tbl_warehouse_issuance_report.wis_id')->get();

		return $data;
	}
	public static function get_all_rr($shop_id = 0, $status = 'pending')
	{
		return Tbl_warehouse_receiving_report::where('rr_shop_id',$shop_id)->where('rr_status', $status)->get();
	}
	public static function scan_item($shop_id, $item_id)
	{
		$chk = Tbl_item::where('item_id',$item_id)->where('item_type_id',1)->where('shop_id',$shop_id)->first();
		$id = $item_id;
		if(!$chk)
		{
			/* SEARCH FOR OTHER ITEM NUMBER HERE*/
			$id = null;
		}

		return $id;
	}
	public static function add_item_to_list($shop_id, $item_id, $quantity = 1, $serial = array())
	{
		$first_data = Session::get('wis_item'); 

		$data[$item_id]['item_id'] = $item_id;
		$data[$item_id]['item_name'] = Item::info($item_id)->item_name;
		$data[$item_id]['item_sku'] = Item::info($item_id)->item_sku;
		$data[$item_id]['item_quantity'] = $quantity;
		$data[$item_id]['item_serial'] = $serial;

		$data = Session::get('wis_item');

		$check = Session::get('wis_item');
		if(count($check) > 0)
		{
			if(isset($first_data[$item_id]))
			{
				$data[$item_id]['item_id'] = $item_id;
				$data[$item_id]['item_name'] = Item::info($item_id)->item_name;
				$data[$item_id]['item_sku'] = Item::info($item_id)->item_sku;
				$data[$item_id]['item_quantity'] = $first_data[$item_id]['item_quantity'] + $quantity;
				$data[$item_id]['item_serial'] = $serial;

				unset(Session::get('wis_item')[$item_id]);
			}
		}

		Session::put('wis_item', $data);
	}
}