<?php
namespace App\Globals;
use App\Models\Tbl_shop;
use App\Models\Tbl_commission;
use App\Models\Tbl_commission_item;
use App\Models\Tbl_commission_invoice;
use App\Models\Tbl_customer_invoice;

use Carbon\carbon;
use DB;

/**
 * 
 *
 * @author Arcylen
 */

class CommissionCalculator
{
	public static function create($shop_id, $comm, $comm_item)
	{
		$comm['shop_id'] = $shop_id;
		$commission_id = Tbl_commission::insertGetId($comm);

		$comm_item['commission_id'] = $commission_id;
		$comm_item_id = Tbl_commission_item::insertGetId($comm_item);

		die(var_dump($comm_item_id));
		
	}
}