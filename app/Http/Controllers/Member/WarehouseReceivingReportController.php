<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Globals\Warehouse2;
use App\Globals\WarehouseTransfer;
use App\Globals\AccountingTransaction;
use App\Globals\Pdf_global;
use App\Globals\Item;
use App\Globals\UnitMeasurement;

use Session;
use Carbon\Carbon;
class WarehouseReceivingReportController extends Member
{
    public function getIndex()
    {
    	$data['page'] = "Receiving Report";
        $data['_rr'] = WarehouseTransfer::get_all_rr($this->user_info->shop_id);
        Session::forget('wis_id');
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
    public function getReceiveItems(Request $request, $wis_id)
    {
        $check = WarehouseTransfer::get_wis_data($wis_id);
        if($check)
        {
            Session::put('wis_id',$wis_id);
            return redirect('/member/item/warehouse/rr/receive-inventory');
        }
    }
    public function getReceiveInventory(Request $request, $wis_id)
    {
        $data['wis']        = WarehouseTransfer::get_wis_data($wis_id);
        $data['wis_item']   = WarehouseTransfer::get_wis_itemline($wis_id);
        $data['_item']      = Item::get_all_category_item([1,4,5]);
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['wis_id']     = $wis_id;
        $data['transaction_refnum'] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'receiving_report');
        if($data['wis'])
        {
            if($data['wis']->wis_status == 'confirm')
            {
                
            }
            else
            {
                return redirect('/member/item/warehouse/rr');
            }
        }
        return view('member.warehousev2.rr.rr_receive_inventory',$data);
    }
    public function postReceiveInventorySubmit(Request $request)
    {
        $shop_id = $this->user_info->shop_id;
        $ins_rr['rr_shop_id'] = $shop_id;
        $ins_rr['rr_number'] = $request->rr_number;
        $ins_rr['wis_id'] = $request->wis_id;
        $ins_rr['rr_date_received'] = $request->rr_date_received;
        $ins_rr['warehouse_id'] = Warehouse2::get_current_warehouse($shop_id);
        $ins_rr['rr_remarks'] = $request->rr_remarks;
        $ins_rr['created_at'] = Carbon::now();

        $wis_data = WarehouseTransfer::get_wis_data($request->wis_id);

        $_item = $request->item_id;

        $return = null;

        $items = null;
        if($wis_data)
        {
            foreach ($_item as $key => $value) 
            {
                if($value)
                {
                    $qty = $request->item_qty[$key] * UnitMeasurement::um_qty($items[$key]['item_um']);
                    if($request->wis_item_quantity[$key] < $qty)
                    {
                        $return .= "The ITEM no ".$value." is not enough to transfer <br>";
                    }

                    $items[$key] = null;
                    $items[$key]['item_id']          = $value;
                    $items[$key]['item_description'] = $request->item_description[$key];
                    $items[$key]['item_um']          = $request->item_um[$key];
                    $items[$key]['item_qty']         = $request->item_qty[$key];
                    $items[$key]['item_rate']        = $request->item_rate[$key];
                    $items[$key]['item_amount']      = $request->item_amount[$key];
                    $items[$key]['item_refname']     = $request->item_refname[$key];
                    $items[$key]['item_refid']       = $request->item_refid[$key];


                    $items[$key]['quantity']         = $request->item_qty[$key] * UnitMeasurement::um_qty($items[$key]['item_um']);

                    $items[$key]['remarks'] = 'Transfer item no. '.$value.' from WIS -('.$wis_data->wis_number.')';                
                }
            }            
        }

        $data = null;
        if(count($items) > 0)
        {
            if(!$return)
            {
                $val = WarehouseTransfer::create_rr($shop_id, $ins_rr['wis_id'], $ins_rr, $items);
                if(!$val)
                {
                    $data['status'] = 'success';
                    $data['call_function'] = 'success_rr';                
                }
                else
                {
                    $data['status'] = 'error';
                    $data['status_message'] = $val;
                }
            }
            else
            {
                $data['status'] = 'error';
                $data['status_message'] = $return;
            }
        }
        else
        {
            $data['status'] = 'error';
            $data['status_message'] = "You don't have any items to receive.";
        }

        return json_encode($data);

    }
    public function getPrint(Request $request, $rr_id)
    {
        $data['rr'] = WarehouseTransfer::get_rr_data($rr_id);
        $data['rr_item'] = WarehouseTransfer::print_rr_item($rr_id);
        $data['user'] = $this->user_info;
        $data['owner'] = WarehouseTransfer::get_warehouse_data($data['rr']->warehouse_id);
        
        $pdf = view('member.warehousev2.rr.print_rr', $data);
        return Pdf_global::show_pdf($pdf,null,$data['rr']->rr_number);
    }
}
