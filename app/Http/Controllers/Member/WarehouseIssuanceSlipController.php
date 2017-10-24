<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Cart2;
use App\Globals\WarehouseTransfer;
use App\Globals\Warehouse2;
use App\Globals\Item;

use Session;
use Carbon\Carbon;
use App\Globals\Pdf_global;

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
        $data['_wis'] = WarehouseTransfer::get_all_wis($this->user_info->shop_id, $data['status']);

        return view('member.warehousev2.wis.load_wis_table',$data);
    }
    public function getCreate()
    {
    	$data['page'] = 'CREATE - WIS';
        $data['_item']  = Item::get_all_category_item([1,5]);
        $data['_warehouse'] = Warehouse2::get_all_warehouse($this->user_info->shop_id);
    	return view('member.warehousev2.wis.wis_create',$data);
    }
    public function getTableItem()
    {
        $data['page'] = 'Table Item';
        $data["_wis_item"] = Session::get('wis_item');
        if(count($data['_wis_item']) > 0)
        {
            foreach ($data['_wis_item'] as $key => $value) 
            {
                $data['_wis_item'][$key]['warehouse_qty'] = Warehouse2::get_item_qty(Warehouse2::get_current_warehouse($this->user_info->shop_id), $key);
            }            
        }

        return view('member.warehousev2.wis.wis_table_item',$data);
    }
    public function postScanItem(Request $request)
    {
        $data["shop_id"]    = $shop_id = $this->user_info->shop_id;
        $data["item_id"]    = $item_id = $request->item_id;
        $return             = $item = WarehouseTransfer::scan_item($data["shop_id"], $data["item_id"]);

        if($return)
        {
            $return["status"]   = "success";
            $return["message"]  = "Item Number " .  $return['item_id'] . " has been added.";
            $serial = isset($return['item_serial']) ? $return['item_serial'] : null;
            WarehouseTransfer::add_item_to_list($shop_id, $return['item_id'], 1, $serial);
        }
        else
        {
            $return["status"]   = "error";
            $return["message"]  = "The ITEM you scanned didn't match any record.";
        }

        echo json_encode($return);
    }
    public function getCreateRemoveItem(Request $request)
    {        
        $item_id = $request->item_id;
        WarehouseTransfer::delete_item_from_list($item_id);
        $return["status"] = "success";
        $return["item_id"] = $item_id;
        echo json_encode($return);
    }
    public function getViewSerial(Request $request, $item_id)
    {
        $item = Session::get('wis_item');
        $data['item'] = Item::info($item_id);
        $data['_serial'] = $item[$item_id]['item_serial'];

        return view('member.warehousev2.wis.wis_serial',$data);
    }
    public function getChangeQuantity(Request $request)
    {
        $shop_id = $this->user_info->shop_id;
        WarehouseTransfer::add_item_to_list($shop_id, $request->item_id, $request->qty, '',1);

        echo json_encode('success');
    }   
    public function postCreateSubmit(Request $request)
    {
        $remarks = $request->wis_remarks;
        $items = Session::get('wis_item');
        $items = $request->item_id;
        $shop_id = $this->user_info->shop_id;

        $ins_wis['wis_shop_id'] = $shop_id;
        $ins_wis['wis_number'] = $request->wis_number;
        $ins_wis['wis_from_warehouse'] = Warehouse2::get_current_warehouse($shop_id);
        $ins_wis['wis_remarks'] = $remarks;
        $ins_wis['destination_warehouse_id'] = $request->destination_warehouse_id;
        $ins_wis['destination_warehouse_address'] = $request->destination_warehouse_address;
        $ins_wis['created_at'] = Carbon::now();

        $_item = null;
        foreach ($items as $key => $value) 
        {
            if($value)
            {
                $_item[$key] = null;
                $_item[$key]['item_id'] = $value;
                $_item[$key]['quantity'] = $request->item_quantity[$key];
                $_item[$key]['remarks'] = $request->item_remarks[$key];
            }
        }

        $val = WarehouseTransfer::create_wis($shop_id, $remarks,$ins_wis , $_item);
        $return = null;
        if(is_numeric($val))
        {
            $return['status'] = 'success';
            $return['call_function'] = 'success_create_wis';
            Session::forget('wis_item');
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $val;
        }

        return json_encode($return);
    }
    public function getPrint(Request $request, $wis_id)
    {
        $data['wis'] = WarehouseTransfer::get_wis_data($wis_id);
        $data['wis_item'] = WarehouseTransfer::print_wis_item($wis_id);
        $data['user'] = $this->user_info;
        $data['owner'] = WarehouseTransfer::get_warehouse_data($data['wis']->wis_from_warehouse);
        
        // return view('member.warehousev2.wis.print_wis', $data);
        $pdf = view('member.warehousev2.wis.print_wis', $data);
        return Pdf_global::show_pdf($pdf,null,$data['wis']->wis_number);
    }
    public function getConfirm(Request $request, $wis_id)
    {
        $data['wis_id'] = $wis_id;
        $data['wis'] = WarehouseTransfer::get_wis_data($wis_id);

        return view('member.warehousev2.wis.wis_confirm', $data);
    }
    public function postConfirmSubmit(Request $request)
    {
        $wis_id = $request->wis_id;
        $up['wis_status'] = $request->wis_status;
        $up['confirm_image'] = $request->confirm_image;
        $up['receiver_code'] = WarehouseTransfer::get_code($this->user_info->shop_id);

        $return = WarehouseTransfer::update_wis($this->user_info->shop_id, $wis_id, $up);

        $data = null;
        if($return)
        {
            $data['status'] = 'success';
            $data['call_function'] = 'success_confirm'; 
        }

        return json_encode($data);
    }
}
