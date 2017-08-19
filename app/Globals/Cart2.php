<?php
namespace App\Globals;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use Session;

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
	public static function set_cart_key($key)
	{
		Session::put("cart_key", $key);
	}
	public static function get_cart_key()
	{
		return session("cart_key");
	}
	public static function set_customer($customer_id)
	{
	}
	public static function detach_customer($customer_id)
	{
	}
	public static function set_payment_method($payment_method_id)
	{
	}
	public static function set_payment_method_information($payment_method_info)
	{
	}
	public static function add_item_to_cart($item_id, $price_per_unit , $quantity)
	{
	}
	public static function edit_item_from_cart($item_id, $quantity)
	{
	}
	public static function delete_item_from_cart($item_id)
	{
	}
	public static function get_cart_items()
	{
		return null;
	}
	public static function get_cart_totals()
	{
		return null;
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