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
		dd(Request::input('value'));
		$_value     = Request::input('value');

		/* Validation */
		// $has_Category = Tbl_category::where("type_name", $value["Category"])->where("type_shop", $this->getShopId())->first();
		// $has_Account  = Tbl_chart_of_account::where("account_name", $value[""])


		// $username = Tbl_register::Account()->where("username", "homerun")->first();
  //       Session::put("member", $username);

  //       $_value     = Request::input('value');
  //       $message    = "";
        
  //       foreach($_value as $key=>$value)
  //       {
  //           $message = $this->save_account($value["Account Name"],$value["Sponsor Name"], $value["Matrix Name"], $value["First Name"], $value["Last Name"], $value["Product"]);
  //           if($message != "")
  //           {
  //               $data["stat"]       = 0;
  //               $data["message"]    = $message;
  //               return json_encode($data);
  //           }
  //       }
        
  //       $data["message"]    = $message;

        return json_encode($data);
	}

}
 