<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Warehouse2;
use App\Globals\WarehouseTransfer;

use Session;
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
    public function postInputCode(Request $request)
    {
        $return = WarehouseTransfer::check_wis($this->user_info->shop_id, $request->warehouse_id, $request->receiver_code);
        $data = null;
        if(is_numeric($return))
        {
            $data['status'] = 'success';
            $data['call_function'] = 'success_code';
            Session::put('wis_id', $return);
        }
        else
        {
            $data['status'] = 'error';
            $data['status_message'] = $return;
        }
        return json_encode($data);
    }
    public function getReceiveInventory()
    {
        if(Session::has('wis_id'))
        {
            $wis_id = Session::get('wis_id');

            $data['wis'] = WarehouseTransfer::get_wis_data($wis_id);
            $data['wis_item'] = WarehouseTransfer::get_wis_item($wis_id);

            return view('member.warehousev2.rr.rr_receive_inventory',$data);
        }
        else
        {
            return redirect('/member/item/warehouse/rr');
        }
    }
    public function postReceiveInventorySubmit(Request $request)
    {
        dd($request->rr_item_quantity);
    }
}
