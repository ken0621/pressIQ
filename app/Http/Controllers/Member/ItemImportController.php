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
use App\Models\Tbl_user;

use App\Globals\Category;
use App\Globals\AuditTrail;
use App\Globals\Accounting;
use App\Globals\DigimaTable;
use App\Globals\Item;
use App\Globals\Vendor;
use App\Globals\UnitMeasurement;
use App\Globals\Utilities;
use App\Globals\Warehouse;

use Carbon\Carbon;
use Request;
use Image;
use Validator;
use Redirect;
use File;
use URL;
use DB;
use Crypt;
use Session;
use Excel;

/**
 * Import Item Module - all importation related module
 * 
 * @author Bryan Kier Aradanas
 */

class ItemImportController extends Member
{
	public static function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
	}

	public function getIndex()
	{

		return view('member.import.item_import');
	}

	public function getItemTemplate()
	{
		Excel::create("ItemTemplate", function($excel)
		{
			// Set the title
		    $excel->setTitle('Digimahouse');

		    // Chain the setters
		    $excel->setCreator('DigimaWebSolutions')
		          ->setCompany('DigimaWebSolutions');

		    $excel->sheet('Template', function($sheet) {
		    	$header = [
		    				'Type',
		    				'Name',
		    				'Sku',
		    				'UM',
		    				'Category',
		    				'Sales Information',
		    				'Sales Price',
		    				'Income Account',
		    				'Sale to Customer',
		    				'Purchase From Supplier',
		    				'Purchasing Information',
		    				'Purchase Cost',
		    				'Barcode',
		    				'Qty on Hand',
		    				'Reorder Point',
		    				'As of Date',
		    				'Asset Account',
		    				'Packing Size',
		    				'Manufacturer'
		    				];
		    	$sheet->freezeFirstRow();
		        $sheet->row(1, $header);

		    });


		})->download('csv');
	}

	public function postReadFile()
	{
		Session::forget("import_item_error");

		$value     = Request::input('value');
		$input     = Request::input('input');

		$ctr 	   		= Request::input('ctr');
		$data_length 	= Request::input('data_length');
		$error_data 	= Request::input('error_data');

		if($ctr != $data_length)
		{
			$type 					= isset($value["Type"]) 				? $value["Type"] : '';					  	//1,2,3
			$name 					= isset($value["Name"]) 				? $value["Name"] : '';					  	//1,2,3
			$sku 					= isset($value["Sku"]) 					? $value["Sku"] : '';				      	//1,2,3
			$um 					= isset($value["UM"]) 					? $value["UM"] : '';					  	//1,2,3
			$category 				= isset($value["Category"]) 			? $value["Category"] : '';				  	//1,2,3
			$sales_information 		= isset($value["Sales Information"]) 	? $value["Sales Information"] : '';		  	//1,2,3
			$sales_price 			= isset($value["Sales Price"]) 			? $value["Sales Price"] : '';			  	//1,2,3
			$income_account 		= isset($value["Income Account"]) 		? $value["Income Account"] : '';		  	//1,2,3
			$sale_to_customer 		= isset($value["Sale to Customer"]) 	? $value["Sale to Customer"] : '';        	//2,3
			$purchase_from_supplier = isset($value["Purchase From Supplier"]) ? $value["Purchase From Supplier"] : '';	//2,3
			$purchasing_information = isset($value["Purchasing Information"]) ? $value["Purchasing Information"] : '';	//3
			$purchase_cost 			= isset($value["Purchase Cost"]) 		? $value["Purchase Cost"] : ''; 			//3
			$expense_account 		= isset($value["Expense Account"]) 		? $value["Expense Account"] : '';			//3
			$barcode 				= isset($value["Barcode"]) 				? $value["Barcode"] : '';					//3
			$qty_on_hand 			= isset($value["Qty on Hand"]) 			? $value["Qty on Hand"] : 0;				//3
			$reorder_point 			= isset($value["Reorder Point"]) 		? $value["Reorder Point"] : 0;				//3
			$as_of_date 			= isset($value["As of Date"]) 			? $value["As of Date"] : '';				//3
			$asset_account 			= isset($value["Asset Account"]) 		? $value["Asset Account"] : '';				//3
			$packing_size 			= isset($value["Packing Size"]) 		? $value["Packing Size"] : '';				//3
			$manufacturer 			= isset($value["Manufacturer"]) 		? $value["Manufacturer"] : '';				//3


			/* Import Setting */
			$auto_category			= isset($input["category"]) 		? $input["category"] : NULL;
			$auto_income_account	= isset($input["income_account"]) 	? $input["income_account"] : NULL;
			$auto_expense_account	= isset($input["expense_account"]) 	? $input["expense_account"] : NULL;
			$auto_asset_account		= isset($input["asset_account"]) 	? $input["asset_account"] : NULL;

			/* Validation */
			$duplicate_item		= Tbl_item::where("shop_id", $this->getShopId())->where("item_name", $name)->first();
			$has_Category 		= Tbl_category::where("type_name", $category)->where("type_shop", $this->getShopId())->first();
			$has_Income_Account = Tbl_chart_of_account::where("account_shop_id", $this->getShopId())
								->where("account_name", $income_account)->first();
			$has_Expense_Account= Tbl_chart_of_account::where("account_shop_id", $this->getShopId())
								->where("account_name", $expense_account)->first();
			$has_Asset_Account 	= Tbl_chart_of_account::where("account_shop_id", $this->getShopId())
								->where("account_name", $asset_account)->first();
			$has_UM 			= Tbl_unit_measurement::where("um_shop", $this->getShopId())->where("um_name", $um)->first();

			if(!$duplicate_item)
			{
				if($has_Category || $auto_category)
				{
					/* CHECK CATEGORY */
					if(!$has_Category && $auto_category && $category != '')
					{
						$category = $this->create_category($category);
					}
					else
					{
						$category = $has_Category->type_id;
					}

					if($has_Income_Account || $auto_income_account)
					{
						/* CHECK INCOME ACCOUNT */
						if(!$has_Income_Account && $auto_income_account && $income_account != '')
						{
							$income_account = $this->create_income_account($income_account);
						}
						else
						{
							$income_account = $has_Income_Account->account_id;
						}

						/* IF TYPE IS ACCEPTED */
						if($type == "INVENTORY" || $type == "NON-INVENTORY" || $type == "SERVICE")
						{
							$insert["shop_id"]				      	  = $this->getShopId();
							$insert["item_name"]				      = $name;
							$insert["item_sku"]					      = $sku;
							$insert["item_category_id"]			      = $category;
							$insert["item_sales_information"] 	      = $sales_information;
							$insert["item_price"] 				      = $sales_price;
							$insert["item_income_account_id"]         = $income_account;
							$insert["item_date_created"]         	  = Carbon::now();

							$message = [];

							if($type == "INVENTORY")
							{
								/*  Check Expense Account */
								if(!$has_Expense_Account && $auto_expense_account && $expense_account != '')
								{
									$expense_account = $this->create_expense_account($expense_account);
								}
								elseif($has_Expense_Account)
								{
									$expense_account = $has_Expense_Account->account_id;
								}

								/* Check Asset Account */
								if(!$has_Asset_Account && $auto_asset_account && $asset_account != '')
								{
									$asset_account = $this->create_asset_account($asset_account);
								}
								elseif($has_Asset_Account)
								{
									$asset_account = $has_Asset_Account->account_id;
								}

								$insert["item_type_id"]				      = 1;
								$insert["item_purchasing_information"]    = $purchasing_information;
								$insert["item_cost"]				      = $purchase_cost;
								$insert["item_expense_account_id"]	      = $expense_account;
								$insert["item_barcode"]				      = $barcode;
								$insert["item_quantity"]		          = $qty_on_hand == '' ? 0 : $qty_on_hand;
								$insert["item_reorder_point"] 		      = $reorder_point;
								$insert["item_date_tracked"]	          = datepicker_input($as_of_date);
								$insert["item_asset_account_id"]          = $asset_account;
								$insert["packing_size"]				      = $packing_size;
								$insert["item_manufacturer_id"]	      	  = $manufacturer;

								$rules["item_quantity"]				      = 'required|numeric';
								$rules["item_cost"]					      = 'required|numeric';
								$rules["item_expense_account_id"]		  = 'required';
								$rules["item_asset_account_id"]			  = 'required';
								
								if($qty_on_hand > 0)
								{
									$rules["item_date_tracked"] 		  = 'required|date';
									$message["item_date_tracked.required"]= "The As of Date field is required when Qty on Hand is not empty";
									$message["item_date_tracked.date"]	  = "The As of Date field should be in Date format";
								}
							}
							elseif($type == "NON-INVENTORY")
							{
								$insert["item_type_id"]				      = 2;
								$insert["item_sale_to_customer"]		  = isset($sale_to_customer) ? $sale_to_customer : 0;
								$insert["item_purchase_from_supplier"]	  = isset($purchase_from_supplier) ? $purchase_from_supplier : 0;
								
								$rules["item_sale_to_customer"]		  	  = 'required|numeric|min:0|max:1';
								$rules["item_purchase_from_supplier"]  	  = 'required|numeric|min:0|max:1';
				
							}
							elseif($type == "SERVICE")
							{
								$insert["item_type_id"]				      = 3;
								$insert["item_sale_to_customer"]		  = isset($sale_to_customer) ? $sale_to_customer : 0;
								$insert["item_purchase_from_supplier"]	  = isset($purchase_from_supplier) ? $purchase_from_supplier : 0;
								
								$rules["item_sale_to_customer"]		      = 'required|numeric|min:0|max:1';
								$rules["item_purchase_from_supplier"]     = 'required|numeric|min:0|max:1';
							}

							$rules["item_name"]					      = 'required';
							$rules["item_sku"]					      = 'required';
							$rules["item_price"]				      = 'required|numeric';
							$rules["item_income_account_id"]		  = 'required';

							$validator = Validator::make($insert, $rules, $message);
							if ($validator->fails())
							{
								$json["status"] 	= "error";
								$json["message"]  	= $validator->errors()->first();
							}
							else
							{
								/* INSERT ITEM */ 
								$item_id 		= Tbl_item::insertGetId($insert);

								/* INSERT WAREHOUSE SLIP AND INVENTORY */
								$insert_sub["warehouse_id"] = $this->current_warehouse->warehouse_id;
								$insert_sub["item_id"] 		= $item_id;
								$insert_sub["item_reorder_point"] = $reorder_point;
								Tbl_sub_warehouse::insert($insert_sub);

								$ins_slip["inventory_reason"] 		= "insert_item";
								$ins_slip["warehouse_id"] 			= $this->current_warehouse->warehouse_id;
								$ins_slip["inventory_remarks"] 		= "Insert Item";
								$ins_slip["inventory_slip_date"] 	= Carbon::now();
								$ins_slip["inventory_slip_shop_id"] = $this->getShopId();
								$ins_slip["inventroy_source_reason"]= "item";
								$ins_slip["inventory_source_id"] 	= $item_id;
								$slip_id = Tbl_inventory_slip::insertGetId($ins_slip);

								$ins_inven["inventory_item_id"] = $item_id;
								$ins_inven["warehouse_id"] 		= $this->current_warehouse->warehouse_id;
								$ins_inven["inventory_created"] = Carbon::now();
								$ins_inven["inventory_count"] 	= $qty_on_hand;
								$ins_inven["inventory_slip_id"] = $slip_id;
								$inventory_id = Tbl_warehouse_inventory::insertGetId($ins_inven);

								$json["status"]		= "success";
								$json["message"]	= "Success";
								$json["item_id"]	= $item_id;
							}
						}
						else
						{
							$json["status"]		= "error";
							$json["message"]	= "Item Type Unknown";
						}
					}
					else
					{
						$json["status"]		= "error";
						$json["message"]	= "Income Account Not Found";
					}
				}
				else
				{
					$json["status"]		= "error";
					$json["message"]	= "Category Not Found";
				}
			}
			else
			{
				$json["status"]		= "error";
				$json["message"]	= "Duplicate Item Name";
			}

			$json["item_name"]	= $value["Name"];
			$status_color 		= $json["status"] == 'success' ? 'green' : 'red';
			$json["tr_data"]	= "<tr>";
			$json["tr_data"]   .= "<td class='$status_color'>".$json["status"]."</td>";
			$json["tr_data"]   .= "<td nowrap>".$json["message"]."</td>";
			$json["tr_data"]   .= "<td nowrap>".$type."</td>";
			$json["tr_data"]   .= "<td nowrap>".$name."</td>";
			$json["tr_data"]   .= "<td nowrap>".$sku."</td>";
			$json["tr_data"]   .= "<td>".$um."</td>";
			$json["tr_data"]   .= "<td nowrap>".$category."</td>";
			$json["tr_data"]   .= "<td>".$sales_information."</td>";
			$json["tr_data"]   .= "<td>".$sales_price."</td>";
			$json["tr_data"]   .= "<td nowrap>".$income_account."</td>";
			$json["tr_data"]   .= "<td>".$sale_to_customer."</td>";
			$json["tr_data"]   .= "<td>".$purchase_from_supplier."</td>";
			$json["tr_data"]   .= "<td>".$purchasing_information."</td>";
			$json["tr_data"]   .= "<td>".$purchase_cost."</td>";
			$json["tr_data"]   .= "<td nowrap>".$expense_account."</td>";
			$json["tr_data"]   .= "<td nowrap>".$barcode."</td>";
			$json["tr_data"]   .= "<td>".$qty_on_hand."</td>";
			$json["tr_data"]   .= "<td>".$reorder_point."</td>";
			$json["tr_data"]   .= "<td>".$as_of_date."</td>";
			$json["tr_data"]   .= "<td nowrap>".$asset_account."</td>";
			$json["tr_data"]   .= "<td nowrap>".$packing_size."</td>";
			$json["tr_data"]   .= "<td nowrap>".$manufacturer."</td>";
			$json["tr_data"]   .= "</tr>";

			$json["value_data"] = $value;
			$length 			= sizeOf($json["value_data"]);

			foreach($json["value_data"] as $key=>$value)
			{
				$json["value_data"]['Error Description'] = $json["message"];
			}
		}
		else /* DETERMINE IF LAST IN CSV */
		{
			Session::put("import_item_error", $error_data);
			$json["status"] = "end";
		}

        return json_encode($json);
	}

	public function getExportError()
	{
		$_value = Session::get("import_item_error");

		if($_value)
		{
			Excel::create("ItemImportError", function($excel) use($_value)
			{
				// Set the title
			    $excel->setTitle('Digimahouse');

			    // Chain the setters
			    $excel->setCreator('DigimaWebSolutions')
			          ->setCompany('DigimaWebSolutions');

			    $excel->sheet('Template', function($sheet) use($_value) {
			    	$header = [
			    				'Type',
			    				'Name',
			    				'Sku',
			    				'UM',
			    				'Category',
			    				'Sales Information',
			    				'Sales Price',
			    				'Income Account',
			    				'Sale to Customer',
			    				'Purchase From Supplier',
			    				'Purchasing Information',
			    				'Purchase Cost',
			    				'Barcode',
			    				'Qty on Hand',
			    				'Reorder Point',
			    				'As of Date',
			    				'Asset Account',
			    				'Packing Size',
			    				'Manufacturer',
			    				'Error_Description'
			    				];
			    	$sheet->freezeFirstRow();
			        $sheet->row(1, $header);
			        foreach($_value as $key=>$value)
			        {
			        	$sheet->row($key+2, $value);
			        }

			    });


			})->download('csv');
		}
		else
		{
			return Redirect::back();
		}
	}

	public function create_category($name)
	{
		$insert["type_name"] = $name;
		$insert["type_shop"] = $this->getShopId();
		return Tbl_category::insertGetId($insert);
	}

	public function create_income_account($name)
	{
		$insert["account_shop_id"] 	= $this->getShopId();
		$insert["account_type_id"] 	= 11;
		$insert["account_number"] 	= 00000;
		$insert["account_name"] 	= $name;
		return Tbl_chart_of_account::insertGetId($insert);
	}

	public function create_expense_account($name)
	{
		$insert["account_shop_id"] 	= $this->getShopId();
		$insert["account_type_id"] 	= 13;
		$insert["account_number"] 	= 00000;
		$insert["account_name"] 	= $name;
		return Tbl_chart_of_account::insertGetId($insert);
	}

	public function create_asset_account($name)
	{
		$insert["account_shop_id"] 	= $this->getShopId();
		$insert["account_type_id"] 	= 5;
		$insert["account_number"] 	= 00000;
		$insert["account_name"] 	= $name;
		return Tbl_chart_of_account::insertGetId($insert);
	}

	/* Do not Remove */
	public function postUrl()
	{

	}

}
 