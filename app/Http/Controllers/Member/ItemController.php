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

use App\Globals\Category;
use App\Globals\AuditTrail;
use App\Globals\Accounting;
use App\Globals\DigimaTable;
use App\Globals\Item;
use App\Globals\Vendor;
use App\Globals\UnitMeasurement;
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

class ItemController extends Member
{
	public function index()
	{
        $access = Utilities::checkAccess('item-list', 'access_page');
        if($access == 1)
        {
			$shop_id        		   = $this->user_info->shop_id;
			$warehouse_id 			   = Tbl_warehouse::where("main_warehouse", 1)->where("warehouse_shop_id", $this->user_info->shop_id)->pluck("warehouse_id");
	        $item 		    		   = Tbl_item::inventory()->where("tbl_item.archived",0)->where("shop_id",$shop_id)->type()->category();
	        $item_archived  		   = Tbl_item::where("tbl_item.archived",1)->where("shop_id",$shop_id)->type()->category();
	        $item_type				   = Request::input("item_type");
	        $search_name			   = Request::input("search_name");

	        if($item_type != null && $item_type != "All")
	        {
	    		$item		   = $item->where("item_type_id",$item_type);
	    		$item_archived = $item_archived->where("item_type_id",$item_type);
	        } 
	        
	        if($search_name != "")
	        {
	    		$item		   = $item->where("item_name","LIKE","%".$search_name."%");
	    		$item_archived = $item_archived->where("item_name","LIKE","%".$search_name."%");
	        }
	        
			$data["_item"]			   = $item->get();
			//item_convertion with unit measurement
			foreach ($data["_item"] as $key => $value) 
			{
				$data["_item"][$key]->inventory_count_um = UnitMeasurement::um_convert($value->inventory_count, $value->item_measurement_id);

				$um = Tbl_unit_measurement_multi::where("multi_um_id",$value->item_measurement_id)->where("is_base",0)->first();
				$data["_item"][$key]->inventory_count_um_view = "";
				if($um)
				{
					$data["_item"][$key]->inventory_count_um_view = UnitMeasurement::um_view($value->inventory_count,$value->item_measurement_id,$um->multi_id);
				}
			}
			$data["_item_archived"]	   = $item_archived->get();
			      
	        
		    return view('member.item.list',$data);
        }
        else
        {
            return $this->show_no_access();
        }
	}

	public function load_item()
    {
        $data["_item"]  = Item::get_all_item();
        return view('member.load_ajax_data.load_item', $data);
    }
    public function load_all_um()
    {    	
		$data["_um"] 		 = UnitMeasurement::load_um();

	    return view('member.load_ajax_data.load_unit_measurement',$data);
    }
    public function load_item_category()
    {
        $data['_item']			= Item::get_all_category_item();
        $data['add_search']		= "";
        return view('member.load_ajax_data.load_item_category', $data);
    }

	public function data()
	{
		$data["table_name"] = "tbl_item";
		$data["column"]		= Request::input("column");

		$data["status"]     = "success";

		return json_encode($data);
	}


	public function add()
	{   
        $access = Utilities::checkAccess('item-list', 'access_page');
        if($access == 1)
        {
			$shop_id          = $this->user_info->shop_id;
			$data["data"]	  = Session::get("item_temporary_data");
			
			$data["_income"] 	= Accounting::getAllAccount('all',null,['Income','Other Income']);
			$data["_asset"] 	= Accounting::getAllAccount('all', null, ['Other Current Asset','Fixed Asset','Other Asset']);
			$data["_expense"] 	= Accounting::getAllAccount('all',null,['Expense','Other Expense','Cost of Goods Sold']);

			$data['_category']  = Category::getAllCategory();
			$data['_item']  	= Item::get_all_category_item();
			$data["_manufacturer"]    	= Tbl_manufacturer::where("manufacturer_shop_id",$shop_id)->get();
			$data["_um"] 		= UnitMeasurement::load_um();
            $data["_vendor"]    = Vendor::getAllVendor('active');

		    return view('member.item.add',$data);
        }
        else
        {
            return $this->show_no_access();
        }
	}

	public function add_submit()
	{	
		$price= "";

		$item_name	 					= Request::input("item_name");
		$item_sku						= Request::input("item_sku");
		$item_category_id				= Request::input("item_category_id");
		$item_img 						= Request::input("item_img");
		$item_price 					= Request::input("item_price");
		$item_sales_information 		= Request::input("item_sales_information");
		$item_asset_account_id 			= Request::input("item_asset_account_id");
		$item_quantity 					= Request::input("item_quantity");
		$item_date_tracked 				= date("Y-m-d g:i:s",strtotime(Request::input("item_date_tracked")));
		$item_reorder_point 			= Request::input("item_reorder_point");
		$item_income_account_id 		= Request::input("item_income_account_id");
		$item_purchasing_information 	= Request::input("item_purchasing_information");
		$item_cost 						= Request::input("item_cost");
		$item_barcode 					= Request::input("item_barcode");
		$item_expense_account_id 		= Request::input("item_expense_account_id");
		$item_measurement_id 			= Request::input("item_measurement_id");
		$item_manufacturer_id 			= Request::input("item_manufacturer_id");
		$packing_size 					= Request::input("packing_size");

		$item_sale_to_customer 			= Request::input("item_sale_to_customer") ? 1 : 0; 
		$item_purchase_from_supplier    = Request::input("item_purchase_from_supplier") ? 1 : 0;


		$promo_price 			= Request::input("promo_price");
		$start_promo_date 		= Request::input("start_promo_date");
		$end_promo_date 		= Request::input("end_promo_date");

		$shop_id = $this->user_info->shop_id;

			
			$insert["item_date_created"]	    	  = Carbon::now();
			$insert["shop_id"]	    				  = $shop_id;

		if(Session::get("um_id") != null)
		{
			$item_measurement_id = Session::get("um_id");
		}
		if(Request::input("item_type") == "inventory")
		{
			$insert["item_type_id"]				      = 1; // TYPE (1 = Inventory , 2 = Non Inventory, 3 = Service, 4 = Bundle)

			$insert["item_name"]				      = $item_name ;
			$insert["item_sku"]					      = $item_sku ;
			$insert["item_category_id"]			      = $item_category_id ;
			$insert["item_img"]					      = $item_img ;
			$insert["item_price"] 				      = $item_price ;
			$insert["item_sales_information"] 	      = $item_sales_information ;
			$insert["item_asset_account_id"]          = $item_asset_account_id ;
			$insert["item_quantity"]		          = $item_quantity ;
			$insert["item_date_tracked"]	          = $item_date_tracked ;
			$insert["item_reorder_point"] 		      = $item_reorder_point ;
			$insert["item_income_account_id"] 	      = $item_income_account_id ;
			$insert["item_purchasing_information"]    = $item_purchasing_information ;
			$insert["item_cost"]				      = $item_cost ;
			$insert["item_barcode"]				      = $item_barcode ;
			$insert["item_expense_account_id"]	      = $item_expense_account_id ;
			$insert["item_measurement_id"]	      	  = $item_measurement_id ;
			$insert["item_manufacturer_id"]	      	  = $item_manufacturer_id ;
			$insert["packing_size"]				      = $packing_size;

			$rules["item_name"]					      = 'required';
			// $rules["item_barcode"]					  = 'required';
			// $rules["item_category_id"]			  = '';
			// $rules["item_img"]					  = '';
			// $rules["item_type_id"]				  = '';
			$rules["item_price"]				      = 'required|numeric';
			$rules["item_sales_information"]	      = '';
			$rules["item_asset_account_id"]		      = '';
			$rules["item_quantity"]				      = 'required|numeric';
			$rules["item_date_tracked"]			      = 'date';
			// $rules["item_reorder_point"]		      = 'required|numeric';
			// $rules["item_income_account_id"]	      = '';
			$rules["item_purchasing_information"]     = '';
			$rules["item_cost"]					      = 'required|numeric';
			// $rules["item_expense_account_id"]	  = '';
			$rules["item_date_tracked"] 			  = 'required|date';
			
			$message                            	  = [];
			$validator = Validator::make($insert, $rules, $message);
			if ($validator->fails()) //fail to add product
			{
				$return["error"]  	= $validator->errors()->all();
				$return["message"] 	= "Failed";
			}
			else
			{
				$item_id = Tbl_item::insertGetId($insert);

				$insert_item_discount["item_id"] = $item_id;
				$insert_item_discount["item_discount_value"] = $promo_price;
				$insert_item_discount["item_discount_date_start"] = $start_promo_date;
				$insert_item_discount["item_discount_date_end"]	 = $end_promo_date;			

				Item::insert_item_discount($insert_item_discount);

				UnitMeasurement::update_um(Session::get("um_id"),$item_name,$item_id);

				$warehouse = Tbl_warehouse::where("warehouse_id",$this->current_warehouse->warehouse_id)->first();

				$slip_id = 0 ;
				if($warehouse == null)
				{
					$warehouse = Tbl_warehouse::where("warehouse_shop_id",$shop_id)->where("main_warehouse",1)->first();
					if($warehouse == null)
					{
						//MAKE MAIN WAREHOUSE
						$ins_warehouse["warehouse_name"] = "Main Warehouse";
						$ins_warehouse["warehouse_shop_id"] = $shop_id;
						$ins_warehouse["warehouse_created"] = Carbon::now();
						$ins_warehouse["main_warehouse"] = 1;

						$warehouse_id = Tbl_warehouse::insertGetId($ins_warehouse);

						$ins["warehouse_id"] = $warehouse_id;
						$ins["item_id"] = $item_id;
						$ins["item_reorder_point"] = $item_reorder_point;

						Tbl_sub_warehouse::insert($ins);

						$ins_slip["inventory_reason"] = "insert_item";
						$ins_slip["warehouse_id"] = $warehouse_id;
						$ins_slip["inventory_remarks"] = "Insert Item";
						$ins_slip["inventory_slip_date"] = Carbon::now();
						$ins_slip["inventory_slip_shop_id"] = $this->user_info->user_shop;
						$ins_slip["inventroy_source_reason"] = "item";
						$ins_slip["inventory_source_id"] = $item_id;

						$slip_id = Tbl_inventory_slip::insertGetId($ins_slip);

						$ins_inven["inventory_item_id"] = $item_id;
						$ins_inven["warehouse_id"] = $warehouse_id;
						$ins_inven["inventory_created"] = Carbon::now();
						$ins_inven["inventory_count"] = $item_quantity;

						$inventory_id = Tbl_warehouse_inventory::insertGetId($ins_inven);						
					}
					else
					{
						$insert_sub["warehouse_id"] = $warehouse->warehouse_id;
						$insert_sub["item_id"] = $item_id;
						$insert_sub["item_reorder_point"] = $item_reorder_point;

						Tbl_sub_warehouse::insert($insert_sub);

						$ins_slip["inventory_reason"] = "insert_item";
						$ins_slip["warehouse_id"] = $warehouse->warehouse_id;
						$ins_slip["inventory_remarks"] = "Insert Item";
						$ins_slip["inventory_slip_date"] = Carbon::now();
						$ins_slip["inventory_slip_shop_id"] = $this->user_info->user_shop;
						$ins_slip["inventroy_source_reason"] = "item";
						$ins_slip["inventory_source_id"] = $item_id;

						$slip_id = Tbl_inventory_slip::insertGetId($ins_slip);

						$ins_inven["inventory_item_id"] = $item_id;
						$ins_inven["warehouse_id"] =  $warehouse->warehouse_id;
						$ins_inven["inventory_created"] = Carbon::now();
						$ins_inven["inventory_count"] = $item_quantity;
						$ins_inven["inventory_slip_id"] = $slip_id;

						$inventory_id = Tbl_warehouse_inventory::insertGetId($ins_inven);
					}
				}
				else
				{
					//
					$insert_sub["warehouse_id"] = $warehouse->warehouse_id;
					$insert_sub["item_id"] = $item_id;
					$insert_sub["item_reorder_point"] = $item_reorder_point;

					Tbl_sub_warehouse::insert($insert_sub);

					$ins_slip["inventory_reason"] = "insert_item";
					$ins_slip["warehouse_id"] = $warehouse->warehouse_id;
					$ins_slip["inventory_remarks"] = "Insert Item";
					$ins_slip["inventory_slip_date"] = Carbon::now();
					$ins_slip["inventory_slip_shop_id"] = $this->user_info->user_shop;
					$ins_slip["inventroy_source_reason"] = "item";
					$ins_slip["inventory_source_id"] = $item_id;

					$slip_id = Tbl_inventory_slip::insertGetId($ins_slip);

					$ins_inven["inventory_item_id"] = $item_id;
					$ins_inven["warehouse_id"] =  $warehouse->warehouse_id;
					$ins_inven["inventory_created"] = Carbon::now();
					$ins_inven["inventory_count"] = $item_quantity;
					$ins_inven["inventory_slip_id"] = $slip_id;

					$inventory_id = Tbl_warehouse_inventory::insertGetId($ins_inven);
				}

				$for_serial_item[$item_id]["quantity"] = $item_quantity;
                $for_serial_item[$item_id]["product_id"] = $item_id;
                $for_serial_item[$item_id]["inventory_id"] = $inventory_id;

                //
                $items["item_id"] = $item_id;
                $items["item_list"] = $for_serial_item;

				$serial = Tbl_settings::where("settings_key","item_serial")->where("settings_value","enable")->where("shop_id",$shop_id)->first();

				if($item_quantity == 0)
				{
					$serial = null;
				}
	            if($serial != null)
	            {
	                $return['status'] 	= 'success-serial';
	                $return["message"] 	= "";
	                // $return["type"]	= "item";
	                Session::put("item", $items);
	            }
	            else
	            {
	                $return['status'] 	= 'success';
	                $return['message'] 	= 'Success';
	                $return["type"]		= "item";
	            }

	            $return['item_id'] = $item_id;
	            // $return["type"]		= "item";
			}
		}
		else if(Request::input("item_type") == "noninventory")
		{
			$insert["item_name"]				      = $item_name;
			$insert["item_sku"]					      = $item_sku;
			$insert["item_category_id"]			      = $item_category_id;
			$insert["item_img"]					      = $item_img;
			$insert["item_type_id"]				      = 2; // TYPE (1 = Inventory , 2 = Non Inventory, 3 = Service, 4 = Bundle)
			$insert["item_price"] 				      = $item_price;
			$insert["item_sales_information"] 	      = $item_sales_information;
			$insert["item_asset_account_id"]          = $item_asset_account_id;
			$insert["item_sale_to_customer"]		  = $item_sale_to_customer;
			$insert["item_purchase_from_supplier"]	  = $item_purchase_from_supplier;
			$insert["item_date_tracked"]	    	  = $item_date_tracked;
			$insert["item_measurement_id"]	      	  = $item_measurement_id;
			$insert["item_income_account_id"] 		  = Request::input("item_income_account_id");
			
			$rules["item_name"]					      = 'required';
			$rules["item_price"]				      = 'required|numeric';
			$rules["item_sales_information"]	      = '';
			$rules["item_asset_account_id"]		      = '';
			$rules["item_sale_to_customer"]		  = 'required|numeric|min:0|max:1';
			$rules["item_purchase_from_supplier"]  = 'required|numeric|min:0|max:1';
			

			
			$message                            	  = [];
			$validator = Validator::make($insert, $rules, $message);
			if ($validator->fails()) //fail to add item
			{
				$return["error"]  = $validator->errors()->all();
				$return["message"] = "Failed";
				$return["type"]		= "item";
			}
			else
			{
				$item_id = Tbl_item::insertGetId($insert);

				$insert_item_discount["item_id"] = $item_id;
				$insert_item_discount["item_discount_value"] = $promo_price;
				$insert_item_discount["item_discount_date_start"] = $start_promo_date;
				$insert_item_discount["item_discount_date_end"]	 = $end_promo_date;	
				Item::insert_item_discount($insert_item_discount);
	

				$return["item_id"] = $item_id;
				$return["message"] = "Success";
				$return["type"]		= "item";
			}
		}
		else if(Request::input("item_type") == "service")
		{
			$insert["item_name"]				      = $item_name;
			$insert["item_sku"]					      = $item_sku;
			$insert["item_category_id"]			      = $item_category_id;
			$insert["item_img"]					      = $item_img;
			$insert["item_type_id"]				      = 3; // TYPE (1 = Inventory , 2 = Non Inventory, 3 = Service, 4 = Bundle)
			$insert["item_price"] 				      = $item_price;
			$insert["item_sales_information"] 	      = $item_sales_information;
			$insert["item_asset_account_id"]          = $item_asset_account_id;
			$insert["item_sale_to_customer"]		  = $item_sale_to_customer;
			$insert["item_purchase_from_supplier"]	  = $item_purchase_from_supplier;
			$insert["item_measurement_id"]	      	  = $item_measurement_id;
			$insert["item_income_account_id"] 		  = Request::input("item_income_account_id");
			
			$rules["item_name"]					      = 'required';
			$rules["item_sku"]					      = 'required';
			$rules["item_price"]				      = 'required|numeric';
			$rules["item_sales_information"]	      = '';
			$rules["item_asset_account_id"]		      = '';
			$rules["item_sale_to_customer"]		      = 'required|numeric|min:0|max:1';
			$rules["item_purchase_from_supplier"]     = 'required|numeric|min:0|max:1';

			
			$message                            	  = [];
			$validator = Validator::make($insert, $rules, $message);
			if ($validator->fails()) //fail to add item
			{
				$return["response_error"] = "error";
				$return["error"]  	= $validator->errors()->all();
				$return["message"] 	= "Failed";
				$return["item_id"] 	= null;
				$return["type"]		= "item";
			}
			else
			{
				$item_id = Tbl_item::insertGetId($insert);

				$insert_item_discount["item_id"] = $item_id;
				$insert_item_discount["item_discount_value"] = $promo_price;
				$insert_item_discount["item_discount_date_start"] = $start_promo_date;
				$insert_item_discount["item_discount_date_end"]	 = $end_promo_date;	
				Item::insert_item_discount($insert_item_discount);

				$return["item_id"] = $item_id;
				$return["message"] = "Success";
				$return["type"]		= "item";
			}
		}
		else if(Request::input("item_type") == "bundle")
		{
			$insert["item_name"]				= $item_name;
			$insert["item_sku"]					= $item_sku;
			$insert["item_category_id"]			= $item_category_id;
			$insert["item_img"]					= $item_img;
			$insert["item_sales_information"] 	= $item_sales_information;
			$insert["item_type_id"]				= 4; // TYPE (1 = Inventory , 2 = Non Inventory, 3 = Service, 4 = Bundle)

			$rules["item_name"]					= "required";
			$rules["item_sku"] 					= "required";

			$_item 	= Request::input('bundle_item_id');
			$_um 	= Request::input('bundle_um_id');
			$_qty 	= Request::input('bundle_qty');

			$item_id = "";
			$message   = [];
			$validator = Validator::make($insert, $rules, $message);
			if ($validator->fails())
			{
				$return["error"]  	= $validator->errors()->all();
				$return["message"] 	= "Failed";
				$return["item_id"] 	= null;
				$return["type"]		= "item";
			}
			else
			{
				$item_id 			= Tbl_item::insertGetId($insert);

				$insert_item_discount["item_id"] = $item_id;
				$insert_item_discount["item_discount_value"] = $promo_price;
				$insert_item_discount["item_discount_date_start"] = $start_promo_date;
				$insert_item_discount["item_discount_date_end"]	 = $end_promo_date;	
				Item::insert_item_discount($insert_item_discount);

				foreach($_item as $key=>$item)
				{
					if($item != '')
					{
						$insert_bundle["bundle_bundle_id"] 	= $item_id;
						$insert_bundle["bundle_item_id"] 	= $item;
						$insert_bundle["bundle_um_id"]		= $_um[$key];
						$insert_bundle["bundle_qty"]		= $_qty[$key];
						Tbl_item_bundle::insert($insert_bundle);
					}
				}
				
				$return["item_id"] 	= $item_id;
				$return["message"] 	= "Success";
				$return["type"]		= "item";

				$bundle_price = Tbl_item_bundle::where("bundle_bundle_id",$item_id)->get();
				foreach ($bundle_price as $key => $value) 
				{
					$item_price = Tbl_item::where("item_id",$value->bundle_item_id)->pluck("item_price");
                	$um = Tbl_unit_measurement_multi::where("multi_id",$value->bundle_um_id)->first();

					$qt = 1;
	                if($um != null)
	                {
	                    $qt = $um->unit_qty;
	                }
                	$issued_qty = $value->bundle_qty * $qt;

                	$price += $issued_qty * $item_price;
				}

				$insert["item_price"] = $price;

			}
		}
		else 
		{
			$return["error"][0] = "Please try again";
			$return["message"]   = "Failed";
			$return["item_id"] = null;
			$return["type"]		= "item";
		}
		if($return["message"] == "Success" || $return['status'] = 'success-serial')
		{
			Session::forget("item_temporary_data");
			$insert["item_id"] = $item_id;
	        AuditTrail::record_logs("Added","item",$item_id,"",serialize($insert));
		}

    	return json_encode($return);
	}	
	public function edit($id)
	{ 
        $access = Utilities::checkAccess('item-list', 'access_page');
        if($access == 1)
        {
			$shop_id          = $this->user_info->shop_id;
			$data["data"]	  = Tbl_item::um()->where("item_id",$id)->itemDiscount()->first()->toArray();
			$data["item_id"]  = $id;
			if($data["data"]["item_type_id"] == 1)
			{
				$data["data"]["type_of_item"] = "inventory_type";
			}
			else if($data["data"]["item_type_id"] == 2)
			{
				$data["data"]["type_of_item"] = "noninventory_type";
			}
			else if($data["data"]["item_type_id"] == 3)
			{
				$data["data"]["type_of_item"] = "service_type";
			}
			else if($data["data"]["item_type_id"] == 4)
			{
				$data["data"]["type_of_item"] = "bundle_type";
				$data["data"]["bundle"]		  = Tbl_item_bundle::item()->where("bundle_bundle_id", $id)->get()->toArray();
			}


			if($data["data"]["parent_basis_um"] != 0)
			{
				$data["data"]["item_measurement_id"] = $data["data"]["parent_basis_um"];	
			}
			$data["data"]["item_date_tracked"] = date('m/d/Y',strtotime($data["data"]["item_date_tracked"]));
			
			$data["_income"] 	= Accounting::getAllAccount('all',null,['Income','Other Income']);
			$data["_asset"] 	= Accounting::getAllAccount('all', null, ['Other Current Asset','Fixed Asset','Other Asset']);
			$data["_expense"] 	= Accounting::getAllAccount('all',null,['Expense','Other Expense','Cost of Goods Sold']);

			$data['_category']  = Category::getAllCategory();
			$data["_manufacturer"] = Tbl_manufacturer::where("manufacturer_shop_id",$shop_id)->get();
			$data["_um"] 	  	= UnitMeasurement::load_um();
			$data['_item']  	= Item::get_all_category_item();
            $data["_vendor"]    = Vendor::getAllVendor('active');

			// dd($data);
		    return view('member.item.edit',$data);
        }
        else
        {
            return $this->show_no_access();
        }  
	}	
	public function edit_submit()
	{	
		$shop_id = $this->user_info->shop_id;
		$id		 = Request::input("item_id");

		$price = "";

		$old = Tbl_item::where("item_id",$id)->first()->toArray();
		// dd($id);
		$insert["item_name"]						  = null;
		$insert["item_sku"]							  = null;
		$insert["item_category_id"]					  = null;
		$insert["item_img"]							  = null;
		$insert["item_price"]						  = null;
		$insert["item_sales_information"]			  = null;
		$insert["item_asset_account_id"]			  = null;
		// $insert["item_quantity"]					  = null;
		$insert["item_date_tracked"]				  = null;
		$insert["item_reorder_point"]				  = null;
		$insert["item_income_account_id"]			  = null;
		$insert["item_purchasing_information"]		  = null;
		$insert["item_cost"]						  = null;
		$insert["item_expense_account_id"]			  = null;
		$insert["item_date_created"]				  = null;
		$insert["item_sale_to_customer"]			  = 0;
		$insert["item_purchase_from_supplier"]	      = 0;
		
		$promo_price 			= Request::input("promo_price");
		$start_promo_date 		= Request::input("start_promo_date");
		$end_promo_date 		= Request::input("end_promo_date");


		$item_measurement_id = Request::input("item_measurement_id");
		$check = UnitMeasurement::check();

        if($item_measurement_id == $old["item_measurement_id"])
		{
	        if($check != 0)
	        {
	        	$item_measurement_id = Tbl_unit_measurement::where("um_id",$old["item_measurement_id"])->pluck("um_id");
	        }			
		}
		if(Session::get("um_id") != null)
		{
			$item_measurement_id = Session::get("um_id");
		}

		if(Request::input("item_type") == "inventory")
		{
			$insert["item_name"]				      = Request::input("item_name");
			$insert["item_sku"]					      = Request::input("item_sku");
			$insert["item_category_id"]			      = Request::input("item_category_id");
			$insert["item_img"]					      = Request::input("item_img") ? Request::input("item_img") : "";
			$insert["item_type_id"]				      = 1; // TYPE (1 = Inventory , 2 = Non Inventory, 3 = Service)
			$insert["item_price"] 				      = Request::input("item_price");
			$insert["item_barcode"] 				      = Request::input("item_barcode");
			$insert["item_sales_information"] 	      = Request::input("item_sales_information") ? Request::input("item_sales_information") : "";
			$insert["item_asset_account_id"]          = Request::input("item_asset_account_id");
			// $insert["item_quantity"]		          = Request::input("item_quantity");
			$insert["item_date_tracked"]	          = date("Y-m-d g:i:s",strtotime(Request::input("item_date_tracked")));
			$insert["item_reorder_point"] 		      = Request::input("item_reorder_point");
			$insert["item_income_account_id"] 	      = Request::input("item_income_account_id");
			$insert["item_purchasing_information"]    = Request::input("item_purchasing_information") ? Request::input("item_purchasing_information") : "";
			$insert["item_cost"]				      = Request::input("item_cost");
			$insert["item_expense_account_id"]	      = Request::input("item_expense_account_id");
			$insert["item_date_created"]	    	  = Carbon::now();
			$insert["item_measurement_id"]	      	  = $item_measurement_id;
			$insert["item_manufacturer_id"]	      	  = Request::input("item_manufacturer_id");
			$insert["shop_id"]	    				  = $shop_id;
				
			$rules["item_name"]					      = 'required';
			$rules["item_sku"]					      = 'required';
			// $rules["item_barcode"]					      = 'alpha_num';
			// $rules["item_category_id"]			  = '';
			// $rules["item_img"]					  = '';
			// $rules["item_type_id"]				  = '';
			$rules["item_price"]				      = 'required|numeric';
			$rules["item_sales_information"]	      = '';
			$rules["item_asset_account_id"]		      = '';
			// $rules["item_quantity"]				      = 'required|numeric';
			$rules["item_date_tracked"]			      = 'date';
			$rules["item_reorder_point"]		      = 'required|numeric';
			// $rules["item_income_account_id"]	      = '';
			$rules["item_purchasing_information"]     = '';
			$rules["item_cost"]					      = 'required|numeric';
			// $rules["item_expense_account_id"]	  = '';
			
			$message                            	  = [];
			$validator = Validator::make($insert, $rules, $message);
			if ($validator->fails()) //fail to add product
			{
				$return["error"]  = $validator->errors()->all();
				$return["message"] = "Failed";
			}
			else
			{
				//update re-order point from MAIN WAREHOUSE
				$up_item["item_reorder_point"] = $insert["item_reorder_point"];
				$warehouse = Tbl_warehouse::where("warehouse_shop_id",$shop_id)->where("main_warehouse",1)->pluck("warehouse_id");
				Tbl_sub_warehouse::where("warehouse_id",$warehouse)->where("item_id",$id)->update($up_item);

				Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->update($insert);


				$insert_item_discount["item_id"] = $id;
				$insert_item_discount["item_discount_value"] = $promo_price;
				$insert_item_discount["item_discount_date_start"] = $start_promo_date;
				$insert_item_discount["item_discount_date_end"]	 = $end_promo_date;	
				Item::insert_item_discount($insert_item_discount);

				UnitMeasurement::update_um(Session::get("um_id"),Request::input("item_name"),$id);

				$return["message"] = "Success";
			}
		}
		else if(Request::input("item_type") == "noninventory")
		{
			$insert["item_name"]				      = Request::input("item_name");
			$insert["item_sku"]					      = Request::input("item_sku");
			$insert["item_category_id"]			      = Request::input("item_category_id");
			$insert["item_img"]					      = Request::input("item_img") ? Request::input("item_img") : "";
			$insert["item_type_id"]				      = 2; // TYPE (1 = Inventory , 2 = Non Inventory, 3 = Service)
			$insert["item_price"] 				      = Request::input("item_price");
			$insert["item_sales_information"] 	      = Request::input("item_sales_information") ? Request::input("item_sales_information") : "";
			$insert["item_asset_account_id"]          = Request::input("item_asset_account_id");
			$insert["item_sale_to_customer"]		  = Request::input("item_sale_to_customer") ? 1 : 0;
			$insert["item_purchase_from_supplier"]	  = Request::input("item_purchase_from_supplier") ? 1 : 0;
			$insert["item_date_tracked"]	          = date("Y-m-d g:i:s",strtotime(Request::input("item_date_tracked")));
			$insert["item_date_created"]	    	  = Carbon::now();
			$insert["shop_id"]	    				  = $shop_id;
			$insert["item_measurement_id"]	      	  = $item_measurement_id;
			$insert["item_income_account_id"] 		  = Request::input("item_income_account_id");

			$rules["item_name"]					      = 'required';
			$rules["item_sku"]					      = 'required';
			// $rules["item_category_id"]			  = '';
			// $rules["item_img"]					  = '';
			// $rules["item_type_id"]				  = '';
			$rules["item_price"]				      = 'required|numeric';
			$rules["item_sales_information"]	      = '';
			$rules["item_asset_account_id"]		      = '';
			$rules["item_sale_to_customer"]		  = 'required|numeric|min:0|max:1';
			$rules["item_purchase_from_supplier"]  = 'required|numeric|min:0|max:1';

			
			$message                            	  = [];
			$validator = Validator::make($insert, $rules, $message);
			if ($validator->fails()) //fail to add item
			{
				$return["error"]  = $validator->errors()->all();
				$return["message"] = "Failed";
			}
			else
			{
				Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->update($insert);

				$insert_item_discount["item_id"] = $id;
				$insert_item_discount["item_discount_value"] = $promo_price;
				$insert_item_discount["item_discount_date_start"] = $start_promo_date;
				$insert_item_discount["item_discount_date_end"]	 = $end_promo_date;	
				Item::insert_item_discount($insert_item_discount);

				$return["message"] = "Success";
			}
		}
		else if(Request::input("item_type") == "service")
		{
			$insert["item_name"]				      = Request::input("item_name");
			$insert["item_sku"]					      = Request::input("item_sku");
			$insert["item_category_id"]			      = Request::input("item_category_id");
			$insert["item_img"]					      = Request::input("item_img") ? Request::input("item_img") : "";
			$insert["item_type_id"]				      = 3; // TYPE (1 = Inventory , 2 = Non Inventory, 3 = Service)
			$insert["item_price"] 				      = Request::input("item_price");
			$insert["item_sales_information"] 	      = Request::input("item_sales_information") ? Request::input("item_sales_information") : "";
			$insert["item_asset_account_id"]          = Request::input("item_asset_account_id");
			$insert["item_sale_to_customer"]		  = Request::input("item_sale_to_customer") ? 1 : 0;
			$insert["item_purchase_from_supplier"]	  = Request::input("item_purchase_from_supplier") ? 1 : 0;
			$insert["item_date_created"]	    	  = Carbon::now();
			$insert["shop_id"]	    				  = $shop_id;
			$insert["item_measurement_id"]	      	  = $item_measurement_id;
			$insert["item_income_account_id"] 		  = Request::input("item_income_account_id");
			
			$rules["item_name"]					      = 'required';
			$rules["item_sku"]					      = 'required';
			// $rules["item_category_id"]			  = '';
			// $rules["item_img"]					  = '';
			// $rules["item_type_id"]				  = '';
			$rules["item_price"]				      = 'required|numeric';
			$rules["item_sales_information"]	      = '';
			$rules["item_asset_account_id"]		      = '';
			$rules["item_sale_to_customer"]		  = 'required|numeric|min:0|max:1';
			$rules["item_purchase_from_supplier"]  = 'required|numeric|min:0|max:1';

			
			$message                            	  = [];
			$validator = Validator::make($insert, $rules, $message);
			if ($validator->fails()) //fail to add item
			{
				$return["error"]  = $validator->errors()->all();
				$return["message"] = "Failed";
			}
			else
			{
				Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->update($insert);
					$insert_item_discount["item_id"] = $id;
				$insert_item_discount["item_discount_value"] = $promo_price;
				$insert_item_discount["item_discount_date_start"] = $start_promo_date;
				$insert_item_discount["item_discount_date_end"]	 = $end_promo_date;	
				Item::insert_item_discount($insert_item_discount);

				$return["message"] = "Success";
			}
		}
		else if(Request::input("item_type") == "bundle")
		{
			$insert["item_name"]				= Request::input("item_name");
			$insert["item_sku"]					= Request::input("item_sku");
			$insert["item_img"]					= Request::input("item_img");
			$insert["item_category_id"]			= Request::input("item_category_id");
			$insert["item_sales_information"] 	= Request::input("item_sales_information");

			$rules["item_name"]					= "required";
			$rules["item_sku"] 					= "required";

			$_item 	= Request::input('bundle_item_id');
			$_um 	= Request::input('bundle_um_id');
			$_qty 	= Request::input('bundle_qty');

			$message   = [];
			$validator = Validator::make($insert, $rules, $message);
			if ($validator->fails())
			{
				$return["error"]  = $validator->errors()->all();
				$return["message"] = "Failed";
			}
			else
			{
				Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->update($insert);

				$insert_item_discount["item_id"] = $item_idid;
				$insert_item_discount["item_discount_value"] = $promo_price;
				$insert_item_discount["item_discount_date_start"] = $start_promo_date;
				$insert_item_discount["item_discount_date_end"]	 = $end_promo_date;	
				Item::insert_item_discount($insert_item_discount);

				Tbl_item_bundle::where("bundle_bundle_id",$id)->delete();

				foreach($_item as $key=>$item)
				{
					if($item != '')
					{
						$insert_bundle["bundle_bundle_id"] 	= $id;
						$insert_bundle["bundle_item_id"] 	= $item;
						$insert_bundle["bundle_um_id"]		= $_um[$key];
						$insert_bundle["bundle_qty"]		= $_qty[$key];
						Tbl_item_bundle::insert($insert_bundle);
					}
				}
				
				$return["message"] = "Success";

				$bundle_price = Tbl_item_bundle::where("bundle_bundle_id",$id)->get();
				foreach ($bundle_price as $key => $value) 
				{
					$item_price = Tbl_item::where("item_id",$value->bundle_item_id)->pluck("item_price");
                	$um = Tbl_unit_measurement_multi::where("multi_id",$value->bundle_um_id)->first();

					$qt = 1;
	                if($um != null)
	                {
	                    $qt = $um->unit_qty;
	                }
                	$issued_qty = $value->bundle_qty * $qt;

                	$price += $issued_qty * $item_price;
				}

				$insert["item_price"] = $price;
			}
		}
		else 
		{
			$return["error"][0] = "Please try again";
			$return["message"]   = "Failed";
		}
		if($return["message"] == "Success")
		{			
			$insert["item_id"] = $id;
	        AuditTrail::record_logs("Edited","item",$id,serialize($old),serialize($insert));
		}
    	
    	return json_encode($return);
	}	

	public function get_multiple_price_modal($item_id)
	{
		$shop_id = $this->user_info->shop_id;
		$data["_multiple_price"] = Tbl_item_multiple_price::item($shop_id)->get();
		$data["item_id"]		 = $item_id;

		return view('member/item/item_multiple_price_modal', $data);
	}

	public function update_multiple_price_modal()
	{
		$item_id = Request::input('item_id');
		$shop_id = $this->user_info->shop_id;

		Tbl_item_multiple_price::item($shop_id)->where("item_id", $item_id)->delete();

		foreach(Request::input('multiprice_qty') as $key=>$qty)
		{
			if($qty > 1)
			{
				$insert["multiprice_item_id"] = $item_id;
				$insert["multiprice_qty"]	  = $qty;
				$insert["multiprice_price"]	  = Request::input('multiprice_price')[$key];
				$insert["date_created"]		  = Carbon::now();

				Tbl_item_multiple_price::insert($insert);
			}
		}

		$json["response_status"] 	= "success";
		$json["type"] 				= "multiple_price";
		$json["message"]			= "Success ";
		return json_encode($json);
	}

	public function get_item_new_price($item_id, $qty)
	{
		return Tbl_item::newPrice($qty)->where("item_id", $item_id)->pluck("new_price");
	}

	public function insert_session()
	{
		$data								 = null;
		$data["type_of_item"]           	 = Request::input("type_of_item");
		$data["item_id"]					 = Request::input("item_id");
		$data["item_name"]					 = Request::input("item_name");
		$data["item_sku"]					 = Request::input("item_sku");
		$data["item_sales_information"]		 = Request::input("item_sales_information");
		$data["item_purchasing_information"] = Request::input("item_purchasing_information");
		$data["item_img"]					 = Request::input("item_img");
		$data["item_quantity"]				 = Request::input("item_quantity");
		$data["item_reorder_point"]			 = Request::input("item_reorder_point");
		$data["item_price"]					 = Request::input("item_price");
		$data["item_cost"]					 = Request::input("item_cost");
		$data["item_sale_to_customer"]		 = Request::input("item_sale_to_customer");
		$data["item_purchase_from_supplier"] = Request::input("item_purchase_from_supplier");
		$data["item_type_id"]				 = Request::input("item_type_id");
		$data["item_category_id"]			 = Request::input("item_category_id");
		$data["item_asset_account_id"]		 = Request::input("item_asset_account_id");
		$data["item_income_account_id"]		 = Request::input("item_income_account_id");
		$data["item_expense_account_id"]	 = Request::input("item_expense_account_id");
		$data["item_date_tracked"]			 = date("m/d/Y",strtotime(Request::input("item_date_tracked")));
		
		Session::put("item_temporary_data",$data);
	}
	public function archive($id)
	{
        $shop_id               = $this->user_info->shop_id;
        $data["page"]          = "Item";
        $data["item"]          = Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->first();
        if(!$data["item"])
        {
            dd("Please try again.");
        }
        return view('member.item.item_archived_modal',$data);
	}
	public function archive_submit()
	{
        $shop_id    = $this->user_info->shop_id;
        $id         = Request::input("item_id");
        $code       = Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->first();
        $ctr_inventory = Tbl_item::leftjoin("tbl_warehouse_inventory","tbl_warehouse_inventory.inventory_item_id","=","tbl_item.item_id")->where("tbl_item.item_id",$id)->where("tbl_item.shop_id",$shop_id)->sum("inventory_count");

        $has_product = Tbl_item::product('0')->where("item_id", $id)->first();

        if(!$has_product)
        {
	        if($ctr_inventory <= 0)
	        {
		        if($code)
		        {
		            if($code->used == 0 && $code->blocked == 0)
		            {
		               $update["archived"] = 1;
		               Tbl_item::where("item_id",$id)->update($update);
					   $return["error"][0]  = "Successfully archived";
					   $return["message"]   = "Sucess-archived";   
		            }
		            else if($code->archive == 1)
		            {
						$return["error"][0]  = "Already archived";
						$return["message"]   = "Failed";  
		            }

			        $item = Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->first()->toArray();

			        AuditTrail::record_logs("Archived","item",$id,"",serialize($item));
		        }
		        else
		        {
					$return["error"][0]  = "Please try again";
					$return["message"]   = "Failed";
		        }
	        }
	        else
	        {
	        	$return["error"][0]  = "You can't delete Item, ".$code->item_name." it has ".$ctr_inventory." quantity";
				$return["message"]   = "Failed";
	        }
    	}
    	else
    	{
    		$return["error"][0]  = "You can't delete Item ".$code->item_name.". It's being use in ecommerce products. ";
				$return["message"]   = "Failed";
    	}

        return json_encode($return);
	}
	public function restore($id)
	{
        $shop_id               = $this->user_info->shop_id;
        $data["page"]          = "Item";
        $data["item"]          = Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->first();
        if(!$data["item"])
        {
            dd("Please try again.");
        }
        return view('member.item.item_restore_modal',$data);
	}
	public function restore_submit()
	{
        $shop_id    = $this->user_info->shop_id;
        $id         = Request::input("item_id");
        $code       = Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->first();
        if($code)
        {

           $update["archived"] = 0;
           Tbl_item::where("item_id",$id)->update($update);
		   $return["error"][0]  = "Successfully restored";
		   $return["message"]   = "Success-restored";   

	        // $item = Tbl_item::where("item_id",$id)->where("shop_id",$shop_id)->first()->toArray();

	        AuditTrail::record_logs("Restored","item",$id,"",serialize(collect($code)->toArray()));
        }
        else
        {
			$return["error"][0]  = "Please try again";
			$return["message"]   = "Failed";
        }

        return json_encode($return);
	}
	public function show_mlm()
	{
		// return $_POST;
		$item_id = Request::input('item_id');
		$item_show_in_mlm = Request::input('item_show_in_mlm');
		if($item_show_in_mlm == null)
		{
			$item_show_in_mlm = 0;
		}
		$updata['item_show_in_mlm'] = $item_show_in_mlm;
		Tbl_item::where('item_id', $item_id)->update($updata);
		$data['response_status'] = 'success';
		$data['message'] = 'success';
		return $data;
	}
}