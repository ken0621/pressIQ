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

	public function postReadFile()
	{
		// dd(Request::input('value'));
		$value     = Request::input('value');

		$type 					= $value["Type"];
		$name 					= $value["Name"];
		$sku 					= $value["Sku"];
		$um 					= $value["UM"];
		$category 				= $value["Category"];
		$sales_information 		= $value["Sales Information"];
		$sales_price 			= $value["Sales Price"];
		$income_account 		= $value["Income Account"];
		$sale_to_customer 		= $value["Sale to Customer"];
		$purchase_from_supplier = $value["Purchase From Supplier"];


		/* Validation */
		$duplicate_item		= Tbl_item::where("shop_id", $this->getShopId())->where("item_name", $name)->first();
		$has_Category 		= Tbl_category::where("type_name", $category)->where("type_shop", $this->getShopId())->first();
		$has_Income_Account = Tbl_chart_of_account::where("account_shop_id", $this->getShopId())->where("account_name", $income_account)->first();
		$has_UM 			= Tbl_unit_measurement::where("um_shop", $this->getShopId())->where("um_name", $um)->first();

		if(!$duplicate_item)
		{
			if($has_Category)
			{
				if($has_Income_Account)
				{
					if($type == "INVENTORY" || $type == "NON-INVENTORY" || $type == "SERVICE")
					{
						$insert["item_name"]				      = $name;
						$insert["item_sku"]					      = $sku;
						$insert["item_category_id"]			      = $has_Category->type_id;
						$insert["item_sales_information"] 	      = $sales_information;
						$insert["item_price"] 				      = $sale_price;
						$insert["item_income_account_id"]         = $income_account;

						if($type == "INVENTORY")
						{

						}
						elseif($type == "NON-INVENTORY")
						{

						}
						elseif($type == "SERVICE")
						{
							$insert["item_type_id"]				      = 3;
							$insert["item_sale_to_customer"]		  = isset($sale_to_customer) ? $sale_to_customer : 0;
							$insert["item_purchase_from_supplier"]	  = isset($purchase_from_supplier) ? $purchase_from_supplier : 0;
							
							$rules["item_name"]					      = 'required';
							$rules["item_sku"]					      = 'required';
							$rules["item_price"]				      = 'required|numeric';
							$rules["item_income_account_id"]		  = 'required';
							$rules["item_sale_to_customer"]		      = 'required|numeric|min:0|max:1';
							$rules["item_purchase_from_supplier"]     = 'required|numeric|min:0|max:1';
						}

						$validator = Validator::make($insert, $rules);
						if ($validator->fails())
						{
							$return["status"] 	= "error";
							$return["message"]  = $validator->errors()->first();
						}
						else
						{
							$item_id = Tbl_item::insertGetId($insert);

							$json["status"]		= "success";
							$json["message"]	= "Success";
							$json["item_id"]	= $item_id;
						}
					}
					else
					{
						$json["status"]		= "error";
						$json["message"]	= "Item Type Unknown [INVENTORY, NON-INVENTORY , SERVICE]";
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


        return json_encode($json);
	}

}
 