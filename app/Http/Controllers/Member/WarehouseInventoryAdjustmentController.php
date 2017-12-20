<?php

namespace App\Http\Controllers\Member;
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
use App\Globals\Purchasing_inventory_system;
use Request;
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
        $data['page'] = "Inventory Adjustment";
        $data['pis']        = Purchasing_inventory_system::check();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();

        return view('member.warehousev2.invtentory_adjustment.inventory_adjustment',$data);
    }

}
