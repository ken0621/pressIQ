<?php
namespace App\Globals;
use App\Globals\Item;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use App\Models\Tbl_cart;
use App\Models\Tbl_cart_info;
use Session;
use Carbon\Carbon;
use App\Globals\Currency;
use stdClass;
use Schema;
class Cart2
{
	public static function search_item($shop_id, $keyword)
	{
		$_item = Tbl_item::where("shop_id", $shop_id)->active()->searchName($keyword)->get();

		if(count($_item) < 1)
		{
			$_item = Tbl_item::where("shop_id", $shop_id)->active()->searchSKU($keyword)->get();
		}

		return $_item;
	}
	public static function scan_item($shop_id, $id)
	{
		$_item = Tbl_item::where("shop_id", $shop_id)->active()->where("item_id", $id)->first();
		return $_item;
	}
	public static function set_cart_key($key)
	{
		Session::put("cart_key", $key);
	}
	public static function get_cart_key()
	{
		return session("cart_key");
	}
	public static function set_info($cart_key, $key, $value)
	{
		if(Schema::hasColumn('tbl_cart_info', $key))
		{
			$check_exist 		= Tbl_cart_info::where("unique_id_per_pc", $cart_key)->first();
			$return["status"] 	= "success";

			if($check_exist)
			{
				$update[$key] 	= $value;
				Tbl_cart_info::where("unique_id_per_pc", $cart_key)->update($update);
			}
			else
			{
				$insert[$key] 	= $value;
				$insert["unique_id_per_pc"] = $cart_key;
				Tbl_cart_info::insert($insert);
			}
			
			return $return;
		}
		else
		{
			$return["status"] 	= "error";
			$return["message"] 	= "The key you are trying to use doesn't exist.";
		}

		return $return;
	}
	public static function detach_customer()
	{
	}
	public static function set_payment_method($payment_method_id)
	{
	}
	public static function set_payment_method_information($payment_method_info)
	{
	}
	public static function add_item_to_cart($shop_id, $item_id, $quantity)
	{
		$cart_key = Self::get_cart_key();

		if($cart_key)
		{
			$check_cart = Tbl_cart::where("unique_id_per_pc", $cart_key)->where("product_id", $item_id)->where("status", "Not Processed")->first();

			if($check_cart) //ITEM EXIST IN CART
			{
				$update["quantity"] = $check_cart->quantity + $quantity;
				Tbl_cart::where("cart_id", $check_cart->cart_id)->update($update);
			}
			else //ITEM DOES NOT EXIST IN CART
			{
				$insert["product_id"] = $item_id;
				$insert["quantity"] = $quantity;
				$insert["unique_id_per_pc"] = $cart_key;
				$insert["status"] = "Not Processed";
				$insert["date_added"] = Carbon::now();
				$insert["shop_id"] = $shop_id;
				Tbl_cart::insert($insert);
			}
		}
	}
	public static function edit_item_from_cart($item_id, $quantity)
	{
	}
	public static function delete_item_from_cart($item_id)
	{
		$cart_key = Self::get_cart_key();
		Tbl_cart::where("unique_id_per_pc", $cart_key)->where("product_id", $item_id)->where("status", "Not Processed")->delete();
	}
	public static function get_cart_info()
	{
		$cart_key = Self::get_cart_key();
		$total = 0;
		$grand_total = 0;

		if($cart_key)
		{
			$_cart 			= Tbl_cart::where("unique_id_per_pc", $cart_key)->where("status", "Not Processed")->get();
			$cart_info 		= Tbl_cart_info::where("unique_id_per_pc", $cart_key)->first();

			if(!$cart_info)
			{
				$cart_info = new stdClass();
				$cart_info->price_level_id = 0;
				$cart_info->global_discount = 0;
			}
 		}

		if(count($_cart) < 1)
		{
			return null;
		}
		else
		{
			foreach($_cart as $key => $cart)
			{
				Item::get_apply_price_level($cart_info->price_level_id);
				
				$item_info 							= Item::info($cart->product_id);
				$_cart[$key] 						= $cart;
				$_cart[$key]->item_id 				= $item_info->item_id;
				$_cart[$key]->item_name 			= $item_info->item_name;
				$_cart[$key]->item_sku 				= $item_info->item_sku;
				$_cart[$key]->item_price 			= $item_info->item_price;
				$_cart[$key]->discount 				= 0;
				$_cart[$key]->subtotal 				= $_cart[$key]->item_price * $cart->quantity;
				$_cart[$key]->display_item_price 	= Currency::format($_cart[$key]->item_price);
				$_cart[$key]->display_subtotal 		= Currency::format($_cart[$key]->subtotal);
				$total += $_cart[$key]->subtotal;
			}

			$grand_total = $total;

			if($cart_info->global_discount == 0) //global discount computation
			{
				$global_discount 			= 0;
				$discount_label 			= "";	
			}
			else
			{
				if($cart_info->global_discount < 1)
				{
					$discount_label 		= number_format($cart_info->global_discount * 100, 0)  . "% DISCOUNT";
					$global_discount 		= $total * $cart_info->global_discount;
				}
				else
				{
					$discount_label 		= "FIXED DISCOUNT";
					$global_discount 		= $cart_info->global_discount;
				}

				$grand_total 				= $grand_total - $global_discount;
			}

			$data["_item"] 								= $_cart;
			$data["_total"] 							= new stdClass();
			$data["_total"]->total 						= $total;
			$data["_total"]->grand_total 				= $grand_total;
			$data["_total"]->global_discount			= $global_discount;
			$data["_total"]->display_discount_label		= $discount_label;

			$data["_total"]->display_total 				= Currency::format($total);
			$data["_total"]->display_global_discount	= Currency::format($global_discount);
			$data["_total"]->display_grand_total 		= Currency::format($grand_total);

			$data["info"]								= $cart_info;
			return $data;
		}
	}
	public static function clear_cart()
	{
	}
	public static function validate_cart()
	{
	}
	public static function process_cart()
	{
	}
}