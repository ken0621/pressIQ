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
       
        return view('member.warehousev2.invtentory_adjustment.inventory_adjustment_list',$data);
    }

    public function getCreate()
    {
        $data['page']       = "Inventory Adjustment";
        $data['_item']      = Item::get_all_category_item([1,4,5]);
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['transaction_refnum'] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'inventory_adjustment');
        $data['_warehouse'] = Warehouse2::get_all_warehouse($this->user_info->shop_id);

        $data['action'] = '/member/item/warehouse/inventory_adjustment/create-submit';

        return view('member.warehousev2.invtentory_adjustment.inventory_adjustment',$data);
    }
    public function postCreateSubmit(Request $request)
    {
        $btn_action = $request->button_action;

        $insert['transaction_refnum']    = $request->transaction_refnum;
        $insert['adj_warehouse_id']      = $request->adj_warehouse_id;
        $insert['adj_created']           = date("Y-m-d", strtotime($request->adj_created));
        $insert['adjustment_remarks']    = $request->adjustment_remarks;
        $insert['adjustment_memo']       = $request->adjustment_memo;
        $insert['adj_user_id']           = $this->user_info->user_id;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['itemline_item_id']           = $value;
                $insert_item[$key]['itemline_item_description']  = $request->item_description[$key];
                $insert_item[$key]['itemline_item_um']           = $request->item_um[$key];
                $insert_item[$key]['itemline_actual_qty']        = str_replace(',', '', $request->item_actual_qty[$key]);
                $insert_item[$key]['itemline_new_qty']           = str_replace(',', '', $request->item_new_qty[$key]);
                $insert_item[$key]['itemline_diff_qty']          = str_replace(',', '', $request->item_diff_qty[$key]);
                $insert_item[$key]['itemline_rate']              = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['itemline_amount']            = str_replace(',', '', $request->item_amount[$key]);
            }
        }


    }
}
