<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;
use App\Globals\Category;
use App\Globals\Manufacturer;
use App\Globals\Accounting;
use App\Globals\Columns;
use Request;

class ItemControllerV2 extends Member
{
	public function list()
	{
		$data["page"] 		 	= "Item List";
		$data["_item_type"]     = Item::get_item_type_list();
		$data["_item_category"] = Item::getItemCategory($this->user_info->shop_id);

		return view("member.itemv2.list_item", $data);
	}
	public function list_table()
	{
		$data["page"]		= "Item List - Table";

		$archived 			= Request::input("archived") ? 1 : 0;
		$item_type_id 		= Request::input("item_type_id");
		$item_category_id   = Request::input("item_category_id");
		$search				= Request::input("search");

		Item::get_add_markup(); 
		Item::get_add_display();
		Item::get_filter_type($item_type_id);
		Item::get_filter_category($item_category_id);
		$data["_item"]		= Item::get($this->user_info->shop_id, 5, $archived, $search);
		$data["pagination"] = Item::get_pagination();
		$data["archive"]	= $archived == 1 ? "restore" : "archive";
		$data["hide"]		= Columns::checkColumns($this->user_info->shop_id, $this->user_info->user_id, "item");
		return view("member.itemv2.list_item_table", $data);
	}
	public function get_item()
	{
		$data['_service']  		 = Category::getAllCategory(['services']);
		$data['_inventory']  	 = Category::getAllCategory(['inventory']);
		$data['_noninventory']   = Category::getAllCategory(['non-inventory']);
		$data['_bundle']         = Category::getAllCategory(['bundles']);
		$data["_income"] 		 = Accounting::getAllAccount('all',null,['Income','Other Income']);
		$data["_asset"] 		 = Accounting::getAllAccount('all', null, ['Other Current Asset','Fixed Asset','Other Asset']);
		$data["_expense"] 		 = Accounting::getAllAccount('all',null,['Expense','Other Expense','Cost of Goods Sold']);
		$data['default_income']  = Accounting::get_default_coa("accounting-sales");
		$data['default_asset']   = Accounting::get_default_coa("accounting-inventory-asset");
		$data['default_expense'] = Accounting::get_default_coa("accounting-expense");
		$data["_manufacturer"]   = Manufacturer::getAllManufaturer();
		$data['item_info'] 	     = [];
		$id 					 = Request::input('item_id');

		if($id)
		{
			$data['item_info'] 	      = Item::info($id);
			$data["link_submit_here"] = "/member/item/v2/edit_submit?item_id=" . $id;
			$data["item_main"]	      = "";
			$data["item_picker"]	  = "hide";
			$data["item_button"]	  = "";
		}
		else
		{
			$data["page"]			  = "Item Add";
			$data["link_submit_here"] = "/member/item/v2/add_submit";
			$data["item_main"]	      = 'display: none';
			$data["item_picker"]	  = "";
			$data["item_button"]	  = "disabled";
		}

		return $data;
	}
	public function submit_item($from)
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
		$insert['item_asset_account_id']       = Request::input('item_asset_account_id');
		$insert['has_serial_number']           = Request::input('item_has_serial');

		/*For inventory refill*/
		$insert['item_quantity'] 		  	   = Request::input('item_initial_qty');
		$insert['item_date_tracked'] 		   = Request::input('item_date_track');
		$insert['item_reorder_point'] 		   = Request::input('item_reorder_point');

		$shop_id = $this->user_info->shop_id;
		
		if($from == "add")
		{
			$item_type_id = 1;
			$return 	  = Item::create($shop_id, $item_type_id, $insert);
		}
		elseif($from == "edit")
		{
			$item_id 	  = Request::input("item_id");
			$return  	  = Item::modify($shop_id, $item_id, $insert);
		}

		return $return;
	}
	public function add_item()
	{
		$data = $this->get_item();

		return view("member.itemv2.add_item",$data);
	}
	public function add_item_submit()
	{
		$return = $this->submit_item("add");		

		return json_encode($return);
	}
	public function edit_item()
	{
		$data = $this->get_item();

		return view("member.itemv2.add_item",$data);
	}
	public function edit_item_submit()
	{
		$return = $this->submit_item("edit");

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
	public function archive()
	{
		$item_id = Request::input("item_id");
		if ($item_id) 
		{
			Item::archive($this->user_info->shop_id, $item_id);
		}

		echo json_encode("success");
	}
	public function restore()
	{
		$item_id = Request::input("item_id");
		if ($item_id) 
		{
			Item::restore($this->user_info->shop_id, $item_id);
		}

		echo json_encode("success");
	}
	public function columns()
	{
		if (Request::isMethod('post'))
		{
			$shop_id = $this->user_info->shop_id;
			$user_id = $this->user_info->user_id;
			$from	 = "item";
			$column  = Request::input("column");

			$result = Columns::submitColumns($shop_id, $user_id, $from, $column);

			if($result)
			{
				$response["response_status"] = "success";
				$response["message"] = "Column has been saved.";
				$response["call_function"] = "columns_submit_done";
			}
			else
			{
				$response["response_status"] = "error";
				$response["message"] = "Some error occurred.";
			}

			return json_encode($response);
		}
		else
		{
			$data["page"] 	 = "Item Columns";
			$shop_id 	  	 = $this->user_info->shop_id;
			$user_id	  	 = $this->user_info->user_id;
			$from    	  	 = "item";
			$default[0]   	 = ["Item ID","item_id", true];
			$default[1]   	 = ["SKU", "item_sku", true];
			$default[2]	  	 = ["Price", "display_price", true];
			$default[3]	  	 = ["Cost", "display_cost", true];
			$default[4]	  	 = ["Markup", "display_markup", true];
			$default[5]	  	 = ["Inventory", "", true];
			$default[6]	  	 = ["U/M", "", true];
			$data["_column"] = Columns::getColumns($shop_id, $user_id, $from, $default);
			
			return view("member.itemv2.columns_item", $data);
		}
	}
}