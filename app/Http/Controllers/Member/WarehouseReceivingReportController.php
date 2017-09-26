<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Warehouse2;
class WarehouseReceivingReportController extends Member
{
    public function getIndex()
    {
    	$data['page'] = "Receiving Report";
    	return view('member.warehousev2.rr.rr_list',$data);
    }
    public function getReceiveCode()
    {
    	$data['_warehouse'] = Warehouse2::get_all_warehouse($this->user_info->shop_id);

    	return view('member.warehousev2.rr.rr_confirm_code',$data);
    }
    public function getReceiveInventory()
    {
        return view('member.warehousev2.rr.rr_receive_inventory');
    }
}
