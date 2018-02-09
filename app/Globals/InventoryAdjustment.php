<?php
namespace App\Globals;

use App\Models\Tbl_inventory_adjustment;
use App\Models\Tbl_inventory_adjustment_line;
use App\Globals\Warehouse2;
use Carbon\Carbon;
use DB;

/**
 * 
 *
 * @author Arcylen
 */

class InventoryAdjustment
{
	public static function info($shop_id, $adj_id)
	{
		return Tbl_inventory_adjustment::warehouse()->where('adj_shop_id', $shop_id)->where('inventory_adjustment_id', $adj_id)->first();
	}

	public static function get($shop_id, $paginate = null, $search_keyword = null)
	{
		$data = Tbl_inventory_adjustment::warehouse()->where('adj_shop_id', $shop_id);
		if($search_keyword)
		{
			$data->where(function($q) use ($search_keyword)
            {
                $q->orWhere("transaction_refnum", "LIKE", "%$search_keyword%");
                $q->orWhere("warehouse_name", "LIKE", "%$search_keyword%");
            });
		}
		
		if($paginate)
		{
			$data = $data->paginate($paginate);
		}
		else
		{
			$data = $data->get();
		}

		return $data;
	}
	public static function info_item($adj_id)
	{
		$data = Tbl_inventory_adjustment_line::item()->um()->where('itemline_ia_id', $adj_id)->get();
		foreach($data as $key => $value) 
        {
            $new_qty = UnitMeasurement::um_qty($value->itemline_item_um);
            $actual_qty = UnitMeasurement::um_qty($value->itemline_item_um);
            $diff_qty = UnitMeasurement::um_qty($value->itemline_item_um);

            $total_actual_qty = $value->itemline_actual_qty * $new_qty;
            $total_new_qty = $value->itemline_new_qty * $actual_qty;
            $total_diff_qty = $value->itemline_diff_qty * $diff_qty;

            $data[$key]->actual_qty = UnitMeasurement::um_view($total_actual_qty, $value->item_measurement_id,$value->itemline_item_um);
            $data[$key]->new_qty = UnitMeasurement::um_view($total_new_qty, $value->item_measurement_id,$value->itemline_item_um);
            $data[$key]->diff_qty = UnitMeasurement::um_view($total_diff_qty, $value->item_measurement_id,$value->itemline_item_um);
        }

		return $data;
	}
	public static function postInsert($shop_id, $insert, $insert_item)
	{
		$total_amount = collect($insert_item)->sum('item_amount');
		$insert['adj_shop_id'] = $shop_id;
		$insert['created_at'] = Carbon::now();
		$insert['adjustment_amount'] = $total_amount;

		$adj_id = Tbl_inventory_adjustment::insertGetId($insert);

		Self::insertline($adj_id, $insert_item);
		$ref['name'] = 'adjust_inventory';
		$ref['id'] = $adj_id;
		Warehouse2::adjust_inventory_bulk($shop_id, $insert['adj_warehouse_id'], $insert_item,'Adjust Inventory', $ref);

		return $adj_id;
	}
	public static function postUpdate($adj_id, $shop_id, $insert, $insert_item)
	{
		$total_amount = collect($insert_item)->sum('item_amount');
		$insert['adj_shop_id'] = $shop_id;
		$insert['adjustment_amount'] = $total_amount;

		Tbl_inventory_adjustment::where('inventory_adjustment_id', $adj_id)->update($insert);
		Tbl_inventory_adjustment_line::where('itemline_ia_id', $adj_id)->delete();

		Self::insertline($adj_id, $insert_item);

		$ref['name'] = 'adjust_inventory';
		$ref['id'] = $adj_id;
		Warehouse2::adjust_inventory_update_bulk($shop_id, $insert['adj_warehouse_id'], $insert_item,'Adjust Inventory', $ref);
		return $adj_id;

	}
	public static function insertline($inventory_adjustment_id, $insert_item, $entry = array())
	{
		$itemline = null;
		foreach ($insert_item as $key => $value) 
		{
			$itemline[$key]['itemline_ia_id'] 			 = $inventory_adjustment_id;
			$itemline[$key]['itemline_item_id'] 		 = $value['item_id'];
			$itemline[$key]['itemline_item_description'] = $value['item_description'];
			$itemline[$key]['itemline_item_um'] 		 = $value['item_um'];
			$itemline[$key]['itemline_actual_qty'] 		 = $value['item_actual_qty'];
			$itemline[$key]['itemline_new_qty'] 		 = $value['item_new_qty'];
			$itemline[$key]['itemline_diff_qty'] 		 = $value['item_diff_qty'];
			$itemline[$key]['itemline_rate'] 			 = $value['item_rate'];
			$itemline[$key]['itemline_amount'] 			 = $value['item_amount'];
		}

		if(count($itemline) > 0)
		{
			Tbl_inventory_adjustment_line::insert($itemline);
		}

		return $inventory_adjustment_id;
	}
}