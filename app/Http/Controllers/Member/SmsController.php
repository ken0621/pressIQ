<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_sms_key;
use App\Models\Tbl_sms_template;
use App\Models\Tbl_sms_default_key;
use App\Models\Tbl_user;

use App\Globals\Variant;
use App\Globals\Item;
use App\Globals\Ecom_Product;
use App\Globals\Category;
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

/**
 * Ecommerce Product Module - all product related module
 * 
 * @author Bryan Kier Aradanas
 */

class SmsController extends Member
{
	public static function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
	}

	public function getIndex()
	{
		$data["_sms"] = Tbl_sms_default_key::template($this->getShopId())->get();
		return view('member.sms.sms', $data);
	}

	public function getSmsModal($key)
	{
		$data["sms"] = Tbl_sms_default_key::template($this->getShopId())->where("sms_default_key", $key)->first();
		return view('member.sms.sms_modal', $data);
	}

	public function postUpdate()
	{
		$data["sms_temp_shop_id"] 	= $this->getShopId();
		$data["sms_temp_key"] 		= Request::input('sms_temp_key');
		$data["sms_temp_is_on"]		= Request::input('sms_temp_is_on');
		$data["sms_temp_content"] 	= Request::input('sms_temp_content');

		$sms_data	= Tbl_sms_template::where("sms_temp_shop_id", $this->getShopId())->where("sms_temp_key", $data["sms_temp_key"])->first();
		if($sms_data)
		{
			Tbl_sms_template::where("sms_temp_id", $sms_data->sms_temp_id)->update($data);
		}
		else
		{
			Tbl_sms_template::insert($data);
		}


		$json["status"] 	= "success";
		$json["type"] 		= "sms";
		$json["message"]	= "Success ";
		return json_encode($json);
	}
}
 