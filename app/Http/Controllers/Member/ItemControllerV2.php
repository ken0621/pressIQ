<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;
use App\Globals\Category;
use App\Globals\Manufacturer;
use App\Globals\Accounting;
use App\Globals\Warehouse2;
use App\Globals\Columns;
use Request;
use Session;

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
		Item::get_search($search);

		$data["_item"]		= Item::get($this->user_info->shop_id, 5);
		$data["pagination"] = Item::get_pagination();
		$data["archive"]	= $archived == 1 ? "restore" : "archive";
		
		$default[]   	 	= ["Item Name","item_name", false];
		$default[]   	 	= ["Item ID","item_id", true];
		$default[]   	 	= ["SKU", "item_sku", true];
		$default[]	  		= ["Price", "display_price", true];
		$default[]	  		= ["Cost", "display_cost", true];
		$default[]	  		= ["Markup", "display_markup", true];
		$default[]	  		= ["Inventory", "inventory_count", true];
		$default[]	  		= ["U/M", "multi_abbrev", true];

		$data["_item"]	    	= Columns::filterColumns($this->user_info->shop_id, $this->user_info->user_id, "item", $data["_item"], $default);
		
		return view("member.itemv2.list_item_table", $data);
	}
	public function get_item()
	{
		Session::forget('choose_item');
		
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
		$data['_membership']	 = Item::get_membership();
		$data["_manufacturer"]   = Manufacturer::getAllManufaturer();
		$data['item_info'] 	     = [];
		$id 					 = Request::input('item_id');

		if($id)
		{
			$data['page_title'] 	  = "EDIT ITEM";
			$data['item_info'] 	      = Item::info($id);
			$data["link_submit_here"] = "/member/item/v2/edit_submit?item_id=" . $id;
			$data["item_picker"]	  = "hide";
			$data["item_button"]	  = "";
			$data['item_type']		  = Item::get_item_type_modify($data['item_info']->item_type_id);
			$data['_choose_item']	  = Item::get_choose_item($id);
		}
		else
		{
			$data['page_title'] 	  = "CREATE NEW ITEM";
			$data["page"]			  = "Item Add";
			$data["link_submit_here"] = "/member/item/v2/add_submit";
			$data["item_picker"]	  = "";
			$data["item_button"]	  = "disabled";
			$data['item_type']		  = Item::get_item_type_modify();	
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
		$insert['membership_id']       		   = Request::input('membership_id');
		$insert['gc_earning']         		   = Request::input('gc_earning');
		
		/*For inventory refill*/
		$insert['item_quantity'] 		  	   = Request::input('item_initial_qty');
		$insert['item_date_tracked'] 		   = Request::input('item_date_track');
		$insert['item_reorder_point'] 		   = Request::input('item_reorder_point');

		$shop_id = $this->user_info->shop_id;
		
		$item_type_id = Item::get_item_type_id(Request::input('item_type_id'));

		if($from == "add")
		{
			if($item_type_id <= 3)
			{
				$return = Item::create_validation($shop_id, $item_type_id, $insert);

				if(!$return['message'])
				{
					$return = Item::create($shop_id, $item_type_id, $insert);
				}				
			}
			else
			{
				$_item = Session::get('choose_item');
				$return = Item::create_bundle_validation($shop_id, $item_type_id, $insert, $_item);

				if(!$return['message'])
				{
					$return = Item::create_bundle($shop_id, $item_type_id, $insert, $_item);
				}	
			}
		}
		elseif($from == "edit")
		{
			$item_id 	  = Request::input("item_id");
			if($item_type_id <= 3)
			{
				$return = Item::create_validation($shop_id, $item_type_id, $insert);

				if(!$return['message'])
				{
					$return  	  = Item::modify($shop_id, $item_id, $insert);
				}
			}
			else
			{
				$_item = Session::get('choose_item');
				$return = Item::create_bundle_validation($shop_id, $item_type_id, $insert, $_item);

				if(!$return['message'])
				{
					$return = Item::modify_bundle($shop_id, $item_id, $insert, $_item);
				}
			}
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
			$data["_column"] = Columns::getColumns($shop_id, $user_id, $from);
			
			return view("member.itemv2.columns_item", $data);
		}
	}
	public function choose()
	{
		$data['_item_to_bundle']	= Item::get_all_category_item([1,2,3]);
		$data['choose_item_submit']	 = "/member/item/choose/submit";
		return view("member.itemv2.choose",$data);
	}
	public function choose_submit()
	{
		$id = Request::input("item_id");
		$qty = Request::input("quantity");
		$info = Item::info($id);

		$return['status'] = null;
		$return['message'] = null;

		$data = Session::get('choose_item'); 
		if($info)
		{
			$data[$id]['item_id'] = $id;
			$data[$id]['item_sku'] = $info->item_sku;
			$data[$id]['item_price'] = $info->item_price;
			$data[$id]['item_cost'] = $info->item_cost;
			$data[$id]['quantity'] = $qty;

			Session::put('choose_item',$data);

			$return['status'] = 'success';
			$return['call_function'] = 'success_choose_item';
		}
		else
		{
			$return['status'] = 'error';
			$return['message'] = "Item doesn't exist";
		}

		return json_encode($return);
	}
	public function load_item()
	{
		$data['_choose_item'] = Session::get('choose_item');

		return view('member.load_ajax_data.load_choose_item',$data);
	}
	public function remove_item()
	{
		$id = Request::input('item_id');

		$data = Session::get('choose_item');
		unset($data[$id]);
		Session::put('choose_item',$data);

		return 'success';
	}
}