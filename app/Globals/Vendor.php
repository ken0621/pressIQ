<?php
namespace App\Globals;

use App\Models\Tbl_vendor;
use App\Models\Tbl_vendor_address;
use App\Models\Tbl_vendor_other_info;
use App\Models\Tbl_user;
use DB;

/**
 * Vendor Globals - all vendor related module
 *
 * @author Bryan Kier Aradanas
 */


class Vendor
{
	public static function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
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

	// public static function 

}