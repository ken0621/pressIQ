<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_item;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_category;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_sub_warehouse;
use App\Models\Tbl_settings;
use App\Models\Tbl_unit_measurement;
use App\Models\Tbl_product_vendor;
use App\Models\Tbl_manufacturer;
use App\Models\Tbl_unit_measurement_multi;
use App\Models\Tbl_item_discount;
use App\Models\Tbl_item_multiple_price;
use App\Models\Tbl_inventory_slip;
use App\Models\Tbl_um;
use App\Models\Tbl_item_merchant_request;
use App\Models\Tbl_user;
use App\Models\Tbl_merchant_markup;

use App\Globals\Category;
use App\Globals\AuditTrail;
use App\Globals\Accounting;
use App\Globals\DigimaTable;
use App\Globals\Warehouse;
use App\Globals\Item;
use App\Globals\Vendor;
use App\Globals\UnitMeasurement;
use App\Globals\Purchasing_inventory_system;
use App\Globals\Utilities;

use Crypt;
use Redirect;
use Request;
use View;
use Session;
use DB;
use Input;
use Validator;
use Carbon\Carbon;

class MerchantController extends Member
{
	public function index()
	{
		$shop_id = $this->user_info->shop_id;
		$data = [];

		$item_type[0] = 1;
		$item_type[1] = 2;
		
		$user_id = Request::input('user_id');
		$data['selected_merchant']  = null;
		if($user_id)
		{
			$data['selected_merchant'] = Tbl_user::where('user_shop', $shop_id)
										 ->where('user_id', $user_id)
										 ->where('user_is_merchant', 1)->first();
				
										 	
			$data['items'] = Tbl_item::whereIn('item_type_id', $item_type)	
			->where('tbl_item.shop_id', $shop_id)
			->get();		

			// leftjoin('tbl_merchant_markup', 'tbl_merchant_markup.item_id', '=', 'tbl_item.item_id')
			// ->where('tbl_merchant_markup.user_id', $user_id)
			// ->orWhereNull('tbl_merchant_markup.user_id')
			// ->select('tbl_item.*', 'tbl_merchant_markup.item_markup_percentage', 'tbl_merchant_markup.item_markup_value', 'tbl_merchant_markup.item_after_markup')
			// ->

			$markup = Tbl_merchant_markup::where('user_id', $user_id)->get()->keyBy('item_id');

			foreach ($data['items']  as $key => $value) 
			{
				if(isset($markup[$value->item_id]))
				{
					$data['items'][$key]->item_markup_percentage = $markup[$value->item_id]->item_markup_percentage;
					$data['items'][$key]->item_markup_value = $markup[$value->item_id]->item_markup_value;
					$data['items'][$key]->item_after_markup = $markup[$value->item_id]->item_after_markup;
				}
				else
				{
					$data['items'][$key]->item_markup_percentage = 0;
					$data['items'][$key]->item_markup_value = $value->item_price;
					$data['items'][$key]->item_after_markup = $value->item_price;
				}
			}

			
							 						 
		}
		else
		{
			$data['items'] = Tbl_item::where('shop_id', $shop_id)->whereIn('item_type_id', $item_type)->get();
			$data['selected_merchant'] = null;

		}

		$data['merchants'] = Tbl_user::where('user_shop', $shop_id)->where('user_is_merchant', 1)->get();
		$data['item_count'] = Tbl_item::where('shop_id', $shop_id)->whereIn('item_type_id', $item_type)->count();
		foreach ($data['merchants'] as $key => $value) 
		{
			$data['merchant_count_item'][$key] = Tbl_merchant_markup::where('user_id', $value->user_id)->where('item_markup_percentage', '!=', 0)->count();
		}
		return view('member.merchant.markup', $data);
	}
	public function update()
	{
		$user_id = Request::input('user_id');
		$user_mark_up_default = Request::input('user_mark_up_default');
		$user_mark_up_lowest = Request::input('user_mark_up_lowest');

		$update['user_mark_up_default'] = $user_mark_up_default;
		$update['user_mark_up_lowest'] = $user_mark_up_lowest;

		if($user_mark_up_default < $user_mark_up_lowest)
		{
			$data['status'] = 'warning';
			$data['message'] = 'Default must be greater or equal to lowest markup';
			return json_encode($data);
		}

		Tbl_user::where('user_id', $user_id)->update($update);

		$data = $this->set_all_mark_up($user_id, $update);


		if(!isset($data['status']))
		{
			$data['status'] = 'success';
			$data['message'] = 'Markup Updated';
		}

		return json_encode($data);
	}

	public function set_all_mark_up($user_id, $markup)
	{
		if(isset($markup['user_mark_up_default']) && isset($markup['user_mark_up_lowest']))
		{
			$shop_id 	= $this->user_info->shop_id;
			$user = Tbl_user::where('user_id', $user_id)->first();

			$item_type[0] = 1;
			$item_type[1] = 2;

			$items 		= Tbl_item::where('shop_id', $shop_id)->whereIn('item_type_id', $item_type)	->get(); 

			foreach ($items as $key => $value)
			{
				$this->set_per_piece_mark_up($value, $user);
			}
		}
	}
	public function set_per_piece_mark_up($item, $user, $mark_up_percentage = null)
	{
		if($item && $user)
		{
			$shop_id 	= $this->user_info->shop_id;
			if($mark_up_percentage != null)
			{
				$user->user_mark_up_default = $mark_up_percentage;
			}

			$check_mark_up = Tbl_merchant_markup::where('item_id', $item->item_id)->where('user_id', $user->user_id)->count();
			if($check_mark_up >= 1)
			{
				$update['item_price'] = $item->item_price;
				$update['item_markup_percentage'] = $user->user_mark_up_default;
				$update['item_markup_value'] = ($user->user_mark_up_default/100) * $item->item_price;
				$update['item_after_markup'] = $item->item_price - $update['item_markup_value'];
				Tbl_merchant_markup::where('item_id', $item->item_id)->where('user_id', $user->user_id)->update($update);
			}
			else
			{
				$insert['user_id'] = $user->user_id;
				$insert['shop_id'] = $shop_id;
				$insert['item_id'] = $item->item_id;
				$insert['item_price'] = $item->item_price;
				$insert['item_markup_percentage'] = $user->user_mark_up_default;
				$insert['item_markup_value'] = ($user->user_mark_up_default/100) * $item->item_price;
				$insert['item_after_markup'] = $item->item_price - $insert['item_markup_value'];
				$insert['merchant_markup_date_created'] = Carbon::now();
				
				Tbl_merchant_markup::insert($insert);
			}
		}
	}
	public function update_per_piece()
	{
		$item_markup_percentage = Request::input('item_markup_percentage');
		$user_id = Request::input('user_id');
		if($item_markup_percentage)
		{
			foreach ($item_markup_percentage as $key => $value) 
			{
				$whereIn_item[$key] = $key;
			}

			$items = Tbl_item::whereIn('item_id', $whereIn_item)->get()->keyBy('item_id');
			$user = Tbl_user::where('user_id', $user_id)->first();
			foreach ($items as $key => $value) 
			{
				if(isset($item_markup_percentage[$key]))
				{
					$this->set_per_piece_mark_up($value, $user, $item_markup_percentage[$key]);		
				}
			}	
		}

		$data['status'] = 'success';
		$data['message'] = 'Markup Updated';
		return json_encode($data);
	}


	public function report()
	{

	}
	public function commission()
	{
		
	}
}