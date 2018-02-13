<?php
namespace App\Globals;

use App\Models\Tbl_vendor;
use App\Models\Tbl_vendor_address;
use App\Models\Tbl_vendor_other_info;
use App\Models\Tbl_user;
use DB;
use Carbon\Carbon;

/**
 * Vendor Globals - all vendor related module
 *
 * @author Bryan Kier Aradanas
 */


class Vendor
{
	public static function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
	}

	/**
	 * Getting all the list of vendor
	 *
	 * @param string  	$filter		(all, active, inactive)
	 * @param integer  	$parent_id  Id of the Chart of Accoutn where will it start
	 * @param array  	$type      	Filter of type of Chart of Account (eg: Accounta Payable)
	 * @param boolean  	$balance    If it will show total balance of each account (true, false)
	 */

	public static function getAllVendor($archived = 'active')
	{
		$data = Tbl_vendor::info()->where("vendor_shop_id",Vendor::getShopId());

		switch($archived)
		{
			case 'active':
				$data->where("archived", 0);
				break;
			case 'inactive':
				$data->where("archived", 1);
				break;
		}
		return $data->get()->toArray();
	}
	public static function ins_vendor($info)
	{
		$ins["vendor_shop_id"] = Vendor::getShopId();
		$ins["vendor_first_name"] = $info["manufacturer_fname"];
		$ins["vendor_middle_name"] = $info["manufacturer_mname"];
		$ins["vendor_last_name"] = $info["manufacturer_lname"];
		$ins["vendor_email"] = $info["email_address"];
		$ins["vendor_company"] = $info["manufacturer_name"];
		$ins["created_date"] = Carbon::now();

		$vendor_id = Tbl_vendor::insertGetId($ins);

		$ins_add["ven_addr_vendor_id"] = $vendor_id;

		Tbl_vendor_address::insert($ins_add);

		$ins_info["ven_info_vendor_id"] = $vendor_id;
		$ins_info["ven_info_phone"] = $info["phone_number"];

		Tbl_vendor_other_info::insert($ins_info);
	}

	public static function getVendor($shop_id, $vendor_id)
	{
		return Tbl_vendor::where('vendor_shop_id', $shop_id)->where('vendor_id', $vendor_id)->first();
	}
	public static function search_get($shop_id, $keyword = '')
	{
		$return = Tbl_vendor::where('shop_id', $shop_id);

		if($keyword != '')
		{
			$return = Tbl_vendor::where('shop_id', $shop_id);

			$return->where(function($q) use ($keyword)
            {
                $q->orWhere("tbl_vendor.vendor_first_name", "LIKE", "%$keyword%");
                $q->orWhere("tbl_vendor.vendor_last_name", "LIKE", "%$keyword%");
                $q->orWhere("tbl_vendor.vendor_middle_name", "LIKE", "%$keyword%");
                $q->orWhere("tbl_vendor.vendor_company", "LIKE", "%$keyword%");
            });
		}
		
		$return = $return->groupBy('tbl_vendor.vendor_id')->orderBy("tbl_vendor.vendor_company",'ASC')->get();

		return $return;
	}

}