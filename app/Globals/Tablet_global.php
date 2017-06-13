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
		$id = 0;
		$shop_id = collect(Session::get("sales_agent"));
		if(count($shop_id) > 0)
		{
			$id = $shop_id['shop_id'];
		}
        return $id;
	}
}