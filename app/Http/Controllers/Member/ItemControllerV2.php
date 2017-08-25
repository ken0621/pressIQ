<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;

class ItemControllerV2 extends Member
{
	public function list()
	{
		$data["page"] 	= "Item List";
		$data["_item_raw"]	= Item::get_all_item($this->user_info->shop_id, 5);
		$data["_item"]		= Item::get_all_item_additional_info($data["_item_raw"]);
		return view("member.itemv2.list_item", $data);
	}
}