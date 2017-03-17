<?php
namespace App\Globals;

use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_mlm_encashment_process;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_mlm_item_discount;
use App\Http\Controllers\Member\MLM_MembershipController;
use App\Http\Controllers\Member\MLM_ProductController;
use App\Models\Tbl_mlm_gc;
use Schema;
use Session;
use DB;
use Carbon\Carbon;
use App\Globals\Mlm_gc;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_slot_log;
use App\Models\Tbl_item;
class Mlm_discount
{   
	public static function get_discount_all_membership($shop_id, $item_id, $data_type = null)
	{
		$all_membership = Tbl_membership::where('shop_id', $shop_id)->where('membership_archive', 0)->get();
		$item = Tbl_item::where('item_id', $item_id)->first();
		if($item)
		{
			foreach ($all_membership as $key => $value) 
			{
				$dis = Tbl_mlm_item_discount::where('item_id', $item_id)->where('membership_id', $value->membership_id)->first(); 				if($dis)
				if($dis)
				{
					$discount[$value->membership_name]['value'] = 	$dis->item_discount_price;
					$discount[$value->membership_name]['type'] =	$dis->item_discount_percentage;
				}
				else
				{
					$discount[$value->membership_name]['value'] = 	0;
					$discount[$value->membership_name]['type'] =	0;
				}
			}
			if($discount)
			{
				$data['status'] = 'success';
				$data['discount'] = $discount;
			}
			else
			{
				$data['status'] = 'error';
				$data['message'] = 'No Membership Available';
			}
		}
		else
		{
			$data['status'] = 'error';
			$data['message'] = 'Invalid Item';
		}

		if($data_type == 'json')
		{
			return json_encode($data);
		}
		else
		{
			return $data;
		}
		
		
	}
}