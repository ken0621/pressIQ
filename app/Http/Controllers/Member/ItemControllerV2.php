<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;

class ItemControllerV2 extends Member
{
	public function list()
	{
		$data["page"] 		= "Item List";
		return view("member.itemv2.list_item", $data);
	}
	public function list_table()
	{
		$data["page"]		= "Item List - Table";
		$data["_item_raw"]	= Item::get_all_item($this->user_info->shop_id, 5);
		$data["_item"]		= Item::apply_additional_info_to_array($data["_item_raw"]);
		return view("member.itemv2.list_item_table", $data);
	}
	public function add_item()
	{
		$data["page"]		= "Item Add";
		return view("member.itemv2.add_item");
	}
	public function cost()
	{
		$data["page"]		= "Item Cost";
		return view("member.itemv2.cost");
	}
	public function price_level()
	{
		$data["page"]		= "Item Price Level";
		return view("member.itemv2.price_level");
	}
}