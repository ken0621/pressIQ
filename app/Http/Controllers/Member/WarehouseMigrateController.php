<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Warehouse2;
class WarehouseMigrateController extends Member
{ 
	public function getAllWarehouse()
    {
        return Warehouse2::get_all_warehouse();
    }
    public function getAllItemWarehouse(Request $request)
    {
    	return Warehouse2::item_warehouse($request->warehouse_id);
    }
    public function getAllItemInventory()
    {
    	return Warehouse2::migrate_warehouse_inventory();
    }
    public function postMigratePerItem(Request $request)
    {
    	$_item = $request->item;
    	if($_item)
        {
            $source['name'] = $_item['ref_name'];
            $source['id'] = 0;
            $retrun = Warehouse2::refill($_item['warehouse_shop_id'], $_item['warehouse_id'], $_item['item_id'] ,$_item['quantity'],$_item['remarks'], $source);
        }	

        return json_encode('success');
    }
}
