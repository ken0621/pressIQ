<?php
namespace App\Globals;

use DB;
use App\Models\Tbl_category;
use App\Models\Tbl_user;
use Session;
class Tablet_global
{
	public static function getShopId()
	{
		$shop_id = collect(Session::get("sales_agent"));
        return $shop_id['shop_id'];
	}
}