<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_user_warehouse_access;
use App\Models\Tbl_item;
use App\Models\Tbl_sub_warehouse;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_settings;
use Redirect;

use App\Globals\Warehouse2;
use App\Globals\Warehouse;
use App\Globals\Utilities;
use App\Globals\Vendor;
use App\Globals\Pdf_global;
use App\Globals\UnitMeasurement;
use App\Globals\AccountingTransaction;
use App\Globals\InventoryAdjustment;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Session;
use App\Globals\Item;
use App\Globals\AuditTrail;
use Validator;
use Excel;
use DB;
class WarehouseInventoryAdjustmentController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data['page'] = "Inventory Adjustment";
       
        return view('member.warehousev2.inventory_adjustment.inventory_adjustment_list',$data);
    }

    public function getLoadInventoryAdjustment(Request $request)
    {
        $data['_inventory_adjustment'] = InventoryAdjustment::get($this->user_info->shop_id, 10, $request->search_keyword);
        return view('member.warehousev2.inventory_adjustment.inventory_adjustment_table',$data);      
    }
    public function getCreate(Request $request)
    {
        $data['page']       = "Inventory Adjustment";
        $data['_item']      = Item::get_all_category_item([1,4,5], null, true);
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['transaction_refnum'] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'inventory_adjustment');
        $data['_warehouse'] = Warehouse2::get_all_warehouse($this->user_info->shop_id);

        $data['action'] = '/member/item/warehouse/inventory_adjustment/create-submit';
        if($request->id)
        {
            $data['action'] = '/member/item/warehouse/inventory_adjustment/update-submit';
            $data['adj'] = InventoryAdjustment::info($this->user_info->shop_id, $request->id);
            $data['_adj_line'] = InventoryAdjustment::info_item($request->id);
        }

        return view('member.warehousev2.inventory_adjustment.inventory_adjustment',$data);
    }
    public function postCreateSubmit(Request $request)
    {
        $btn_action = $request->button_action;

        $insert['transaction_refnum']    = $request->transaction_refnum;
        $insert['adj_warehouse_id']      = $request->adj_warehouse_id;
        $insert['date_created']          = date("Y-m-d", strtotime($request->adj_created));
        $insert['adjustment_remarks']    = $request->adjustment_remarks;
        $insert['adjustment_memo']       = $request->adjustment_memo;
        $insert['adj_user_id']           = $this->user_info->user_id;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value && $request->item_new_qty[$key])
            {
                $insert_item[$key]['item_id']           = $value;
                $insert_item[$key]['item_description']  = $request->item_description[$key];
                $insert_item[$key]['item_um']           = $request->item_um[$key];
                $insert_item[$key]['item_actual_qty']   = str_replace(',', '', $request->item_actual_qty[$key]);
                $insert_item[$key]['item_new_qty']      = str_replace(',', '', $request->item_new_qty[$key]);
                $insert_item[$key]['item_diff_qty']     = str_replace(',', '', $request->item_diff_qty[$key]);
                $insert_item[$key]['item_rate']         = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
            }
        }

        $val = null;
        if(count($insert_item) > 0)
        {
            $val = InventoryAdjustment::postInsert($this->user_info->shop_id, $insert, $insert_item);
        }
        if(is_numeric($val))
        {
            $return['status'] = 'success';
            $return['call_function'] = 'success_adjust_inventory';
            $return['status_message'] = 'Success adjusting inventory.';

            if($btn_action == 'sclose')
            {
                $return['status_redirect'] = '/member/item/warehouse/inventory_adjustment';
            }
            elseif ($btn_action == 'sedit')
            {
                $return['status_redirect'] = '/member/item/warehouse/inventory_adjustment/create?id='.$val;
            }
            elseif ($btn_action == 'snew')
            {
                $return['status_redirect'] = '/member/item/warehouse/inventory_adjustment/create';
            }
            elseif ($btn_action == 'sprint')
            {
                $return['status_redirect'] = '/member/item/warehouse/inventory_adjustment/print/'.$val;
            }

        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = "Please select item or enter it's new quantity.";
        }

        return json_encode($return);
    }
    public function getPrint(Request $request)
    {
        dd('Under Maintenance');
    }
    public function postUpdateSubmit(Request $request)
    {
        $btn_action = $request->button_action;

        $adj_id = $request->adj_id;
        $insert['transaction_refnum']    = $request->transaction_refnum;
        $insert['adj_warehouse_id']      = $request->adj_warehouse_id;
        $insert['date_created']           = date("Y-m-d", strtotime($request->adj_created));
        $insert['adjustment_remarks']    = $request->adjustment_remarks;
        $insert['adjustment_memo']       = $request->adjustment_memo;
        $insert['adj_user_id']           = $this->user_info->user_id;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id']           = $value;
                $insert_item[$key]['item_description']  = $request->item_description[$key];
                $insert_item[$key]['item_um']           = $request->item_um[$key];
                $insert_item[$key]['item_actual_qty']   = str_replace(',', '', $request->item_actual_qty[$key]);
                $insert_item[$key]['item_new_qty']      = str_replace(',', '', $request->item_new_qty[$key]);
                $insert_item[$key]['item_diff_qty']     = str_replace(',', '', $request->item_diff_qty[$key]);
                $insert_item[$key]['item_rate']         = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
            }
        }

        $val = null;
        if(count($insert_item) > 0)
        {
            $val = InventoryAdjustment::postUpdate($adj_id, $this->user_info->shop_id, $insert, $insert_item);
        }
        if(is_numeric($val))
        {
            $return['status'] = 'success';
            $return['call_function'] = 'success_adjust_inventory';
            $return['status_message'] = 'Success adjusting inventory.';
            if($btn_action == 'sclose')
            {
                $return['status_redirect'] = '/member/item/warehouse/inventory_adjustment';
            }
            elseif ($btn_action == 'sedit')
            {
                $return['status_redirect'] = '/member/item/warehouse/inventory_adjustment/create?id='.$val;
            }
            elseif ($btn_action == 'snew')
            {
                $return['status_redirect'] = '/member/item/warehouse/inventory_adjustment/create';
            }
            elseif ($btn_action == 'sprint')
            {
                $return['status_redirect'] = '/member/item/warehouse/inventory_adjustment/print/'.$val;
            }
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = 'Please select item.';
        }

        return json_encode($return);
    }
}
