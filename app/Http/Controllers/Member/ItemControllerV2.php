<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;
use App\Globals\Category;
use App\Globals\Manufacturer;
use App\Globals\Accounting;
use App\Globals\Warehouse2;
use App\Globals\Columns;
use App\Globals\Utilities;
use Request;
use Session;


use App\Models\Tbl_token_list;
use App\Models\Tbl_item_token;

class ItemControllerV2 extends Member
{
	public function list()
	{
        $access = Utilities::checkAccess('item-list-v2', 'access_page');
        if($access == 1)
        { 
	 		$data["page"] 		 	= "Item List";
			$data["_item_type"]     = Item::get_item_type_list();
			$data["_item_category"] = Item::getItemCategory($this->user_info->shop_id);
			//patrick
			$data['shop_id']		= $this->user_info->shop_id;

			return view("member.itemv2.list_item", $data);
		}
        else
        {
            return $this->show_no_access();
        }
	}
	public function list_table()
	{
		$data["page"]		= "Item List - Table";

		$archived 			= Request::input("archived") ? 1 : 0;
		$item_type_id 		= Request::input("item_type_id");
		$item_category_id   = Request::input("item_category_id");
		$search				= Request::input("search");
		$warehouse_id 		= Warehouse2::get_current_warehouse($this->user_info->shop_id);

		Item::get_add_markup(); 
		Item::get_add_display();
		Item::get_filter_type($item_type_id);
		Item::get_filter_category($item_category_id);
		Item::get_search($search);
		Item::get_inventory($warehouse_id);

		$data["_item"]		= Item::get($this->user_info->shop_id, 5, $archived);
		$data["pagination"] = Item::get_pagination();
		$data["archive"]	= $archived == 1 ? "restore" : "archive";
		

		$default[]   	 	= ["Item ID","item_id", true];
		$default[]   	 	= ["Item Name","item_name", false];
		$default[]   	 	= ["SKU", "item_sku", true];
		$default[]	  		= ["Price", "display_price", true];
		$default[]	  		= ["Cost", "display_cost", true];
		$default[]	  		= ["Markup", "display_markup", true];
		$default[]	  		= ["Inventory", "inventorylog", true];
		$default[]	  		= ["U/M", "multi_abbrev", true];

		$data["_item"]	    	= Columns::filterColumns($this->user_info->shop_id, $this->user_info->user_id, "item", $data["_item"], $default);
		// dd($data['_item']);
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
			// patrick
			// for icoinsshop
			$token_item = Tbl_item_token::Token()->where('item_id',$id)->first();
			if($token_item)
			{
				$data['token_name']	= $token_item->token_name;
				$data['amount']		= $token_item->amount;
			}
			else
			{
				$data['token_name']	= '';
				$data['amount']		= '0';
			}
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
		$data['shop_id']	= $this->user_info->shop_id;
		$data['tokens']		= Tbl_token_list::where('shop_id',$this->user_info->shop_id)->get();
		return $data;
	}
	public function submit_item($from)
	{
		$insert['item_name'] 				   = Request::input('item_description');
		$insert['item_sku'] 				   = Request::input('item_sku');
		$insert['item_barcode'] 			   = Request::input('item_barcode');
		$insert['item_category_id']			   = Request::input('item_category');
		$insert['item_img']				 	   = Request::input('item_img')  == null ? '' : Request::input('item_img');
		$insert['item_manufacturer_id'] 	   = Request::input('item_manufacturer_id')  == null ? '' : Request::input('item_manufacturer_id');
		$insert['item_price'] 				   = Request::input('item_price');
		$insert['item_income_account_id'] 	   = Request::input('item_income_account_id');
		$insert['item_sales_information']      = Request::input('item_sales_information') == null ? '' : Request::input('item_sales_information');
		$insert['item_cost'] 				   = Request::input('item_cost') == null ? 0 : Request::input('item_cost');
		$insert['item_expense_account_id']	   = Request::input('item_expense_account_id');
		$insert['item_purchasing_information'] = Request::input('item_purchasing_information') == null ? '' : Request::input('item_purchasing_information');
		$insert['item_asset_account_id']       = Request::input('item_asset_account_id');
		$insert['has_serial_number']           = Request::input('item_has_serial') == null ? 0 : Request::input('item_has_serial');
		$insert['membership_id']       		   = Request::input('membership_id') == null ? 0 : Request::input('membership_id');
		$insert['gc_earning']         		   = Request::input('gc_earning')  == null ? 0 : Request::input('gc_earning');
		
		/*For inventory refill*/
		$insert['item_quantity'] 		  	   = Request::input('item_initial_qty') == null ? 0 :Request::input('item_initial_qty');
		$insert['item_date_tracked'] 		   = Request::input('item_date_track') == null ? '' :Request::input('item_date_track');
		$insert['item_reorder_point'] 		   = Request::input('item_reorder_point') == null ? 0 :Request::input('item_reorder_point');

		$shop_id = $this->user_info->shop_id;
		
		$item_type_id = Item::get_item_type_id(Request::input('item_type_id'));

		// patrick
		// for icoinsshop
		if($shop_id == 87)
		{
			$token['token_id'] 	= Request::input('token_type');
			$token['amount']	= Request::input('token_amount');
		}

		if($from == "add")
		{
			if($item_type_id <= 3)
			{
				$validate = Item::create_validation($shop_id, $item_type_id, $insert);

				if(!$validate)
				{
					if($shop_id == 87)
					{
						$return = Item::create($shop_id, $item_type_id, $insert, $token);
					}
					else
					{
						$return = Item::create($shop_id, $item_type_id, $insert);
					}
					
				}
				else
				{
					$return['message'] = $validate;
					$return['status'] = 'error';
				}
			}
			else
			{
				$_item = Session::get('choose_item');
				$validate = Item::create_bundle_validation($shop_id, $item_type_id, $insert, $_item);
				if(!$validate)
				{
					$return = Item::create_bundle($shop_id, $item_type_id, $insert, $_item);
				}
				else
				{
					$return['message'] = $validate;
					$return['status'] = 'error';
				}	
			}
		}
		elseif($from == "edit")
		{
			$item_id 	  = Request::input("item_id");
			if($item_type_id <= 3)
			{
				$validate = Item::create_validation($shop_id, $item_type_id, $insert);
				if(!$validate)
				{
					if($shop_id == 87)
					{
						$return = Item::modify($shop_id, $item_id, $insert, $token);
					}
					else
					{
						$return = Item::modify($shop_id, $item_id, $insert);
					}
				}
				else
				{
					$return['message'] = $validate;
					$return['status'] = 'error';
				}
			}
			else
			{
				$_item = Session::get('choose_item');
				$validate = Item::create_bundle_validation($shop_id, $item_type_id, $insert, $_item);
				if(!$validate)
				{
					$return = Item::modify_bundle($shop_id, $item_id, $insert, $_item);
				}
				else
				{
					$return['message'] = $validate;
					$return['status'] = 'error';
				}
			}
		}

		return $return;
	}
	public function add_item()
	{
		$access = Utilities::checkAccess('item-list-v2', 'add');
        if($access == 1)
        { 
			$data = $this->get_item();

			return view("member.itemv2.add_item",$data);
		}
		else
		{

            return $this->show_no_access_modal();
		}
	}
	public function add_item_submit()
	{
		$return = $this->submit_item("add");		

		return json_encode($return);
	}
	public function edit_item()
	{
		$access = Utilities::checkAccess('item-list-v2', 'edit');
        if($access == 1)
        { 
			$data = $this->get_item();

			return view("member.itemv2.add_item",$data);
		}
		else
		{
            return $this->show_no_access_modal();
		}
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
	public function refill_item()
	{		
		$access = Utilities::checkAccess('item-list-v2', 'refill-item');
        if($access == 1)
        { 
			$item_id = Request::input('item_id');
			$data['item'] = Item::info($item_id);
			$data['refill_submit'] = '/member/item/v2/refill_submit';

			return view('member.itemv2.refill_item',$data);
		}
		else
		{

            return $this->show_no_access_modal();
		}
	}
	public function refill_submit()
	{
		$item_id = Request::input('item_id');
		$quantity = Request::input('quantity');
		$remarks = Request::input('remarks');
		$shop_id = $this->user_info->shop_id;
		$warehouse_id = Warehouse2::get_current_warehouse($shop_id);

		$validate = Warehouse2::refill_validation($shop_id, $warehouse_id, $item_id, $quantity, $remarks);
    	if(!$validate)
    	{
    		$return = Warehouse2::refill($shop_id, $warehouse_id, $item_id, $quantity, $remarks);
    		$return['call_function'] = 'success_refill';
    		$return['status'] = 'success';
    	}
    	else
    	{
    		$return['status'] = 'error';
    		$return['message'] = $validate;
    	}

    	return json_encode($return);
	}
	public function add_token()
	{
		$data['page'] = 'Add Token';
		return view('member.itemv2.add_token',$data);
	}
	public function add_token_submit()
	{
		$insert['token_name'] 	= Request::input('token_name');
		$insert['shop_id']		= $this->user_info->shop_id;
		if($insert['token_name'] != '')
		{
			$query = Tbl_token_list::insert($insert);
			$response['call_function'] = 'success';
		}
		else
		{
			$response['call_function'] = 'error_name';
		}
		return json_encode($response);
	}
	public function get_token_list()
	{
		$list = Tbl_token_list::where('shop_id',$this->user_info->shop_id)->get();
		$data = '<select class="form-control token-type" name="token-type">';
		$data .= '<option class="hidden">Select Token</option>';
		foreach($list as $token)
		{
			$data .= '<option value="'.$token->token_id.'">'. $token->token_name .'</option>';
		}
		$data .= '<option value="add_new">Add New Token</option>';
		$data .= '</select>';
		return $data;
	}
}