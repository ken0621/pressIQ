<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;
use App\Globals\Category;
use App\Globals\Manufacturer;
use App\Globals\Accounting;
use Request;

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
		$data["link_submit_here"] = "/member/item/v2/add_submit";

		$data['_service']  		    = Category::getAllCategory(['services']);
		$data['_inventory']  		= Category::getAllCategory(['inventory']);
		$data['_noninventory']  	= Category::getAllCategory(['non-inventory']);
		$data['_bundle']        	= Category::getAllCategory(['bundles']);


		$data["_income"] = Accounting::getAllAccount('all',null,['Income','Other Income']);
		$data["_asset"] = Accounting::getAllAccount('all', null, ['Other Current Asset','Fixed Asset','Other Asset']);
		$data["_expense"] = Accounting::getAllAccount('all',null,['Expense','Other Expense','Cost of Goods Sold']);

		$data['default_income'] = Accounting::get_default_coa("accounting-sales");
		$data['default_asset'] = Accounting::get_default_coa("accounting-inventory-asset");
		$data['default_expense'] = Accounting::get_default_coa("accounting-expense");

		$data["_manufacturer"] = Manufacturer::getAllManufaturer();

		return view("member.itemv2.add_item",$data);
	}
	public function add_item_submit()
	{
		$insert['item_name'] 				   = Request::input('item_description');
		$insert['item_sku'] 				   = Request::input('item_sku');
		$insert['item_barcode'] 			   = Request::input('item_barcode');
		$insert['item_category_id']			   = Request::input('item_category');
		$insert['item_manufacturer_id'] 	   = Request::input('item_manufacturer_id');
		$insert['item_price'] 				   = Request::input('item_price');
		$insert['item_income_account_id'] 	   = Request::input('item_income_account_id');
		$insert['item_sales_information']      = Request::input('item_sales_information');
		$insert['item_cost'] 				   = Request::input('item_cost');
		$insert['item_expense_account_id']	   = Request::input('item_expense_account_id');
		$insert['item_purchasing_information'] = Request::input('item_purchasing_information');
		// $insert['item_initial_qty'] 		   = Request::input('item_initial_qty');
		// $insert['item_date_track'] 			   = Request::input('item_date_track');
		// $insert['item_reorder_point'] 		   = Request::input('item_reorder_point');
		$insert['item_asset_account_id']       = Request::input('item_asset_account_id');
		$insert['has_serial_number']           = Request::input('item_has_serial');

		$shop_id = $this->user_info->shop_id;
		$item_type_id = 1;
		$return =  Item::create($shop_id, $item_type_id, $insert);

		return json_encode($return);
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