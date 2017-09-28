<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Cart2;
use App\Globals\WarehouseTransfer;
use App\Globals\Warehouse2;

use Session;
class WarehouseIssuanceSlipController extends Member
{
    public function getIndex(Request $request)
    {
    	$data['page'] = 'WIS';
        $data['status'] = isset($request->status) ? $request->status : 'pending';
        $data['_wis'] = WarehouseTransfer::get_all_wis($this->user_info->shop_id);

    	return view('member.warehousev2.wis.wis_list',$data);
    }
    public function getLoadWisTable(Request $request)
    {
        $data['status'] = isset($request->status) ? $request->status : 'pending';
        $data['_wis'] = WarehouseTransfer::get_all_wis($this->user_info->shop_id);

        return view('member.warehousev2.wis.load_wis_table',$data);
    }
    public function getCreate()
    {
    	$data['page'] = 'CREATE - WIS';

    	return view('member.warehousev2.wis.wis_create',$data);
    }
    public function getTableItem()
    {
        $data['page'] = 'Table Item';
        $data["_wis_item"] = Session::get('wis_item');

        foreach ($data['_wis_item'] as $key => $value) 
        {
            $data['_wis_item'][$key]['warehouse_qty'] = Warehouse2::get_item_qty(Warehouse2::get_current_warehouse($this->user_info->shop_id), $key);

        }

        return view('member.warehousev2.wis.wis_table_item',$data);
    }
    public function postScanItem(Request $request)
    {
        $data["shop_id"]    = $shop_id = $this->user_info->shop_id;
        $data["item_id"]    = $item_id = $request->item_id;
        $data["item"]       = $item = WarehouseTransfer::scan_item($data["shop_id"], $data["item_id"]);

        if($data["item"])
        {
            $return["status"]   = "success";
            $return["message"]  = "Item Number " .  $data["item"] . " has been added.";
            WarehouseTransfer::add_item_to_list($shop_id, $item_id, 1);
        }
        else
        {
            $return["status"]   = "error";
            $return["message"]  = "The ITEM you scanned didn't match any record.";
        }

        echo json_encode($return);
    }
    public function getViewSerial()
    {

        return view('member.warehousev2.wis.wis_serial');
    }
    public function getConfirm()
    {

        return view('member.warehousev2.wis.wis_confirm');
    }
}
