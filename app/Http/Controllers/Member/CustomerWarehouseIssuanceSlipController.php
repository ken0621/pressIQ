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
class CustomerWarehouseIssuanceSlipController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $data['page'] = 'WIS';
        $data['status'] = isset($request->status) ? $request->status : 'pending';
        $current_warehouse = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        //$data['_wis'] = WarehouseTransfer::get_all_wis($this->user_info->shop_id, $data['status'], $current_warehouse);

        return view('member.warehousev2.customer_wis.customer_wis_list',$data);
    }

    public function getCustomerLoadWisTable(Request $request)
    {
        $current_warehouse = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $data['status'] = isset($request->status) ? $request->status : 'pending';
        //$data['_wis'] = WarehouseTransfer::get_all_wis($this->user_info->shop_id, $data['status'], $current_warehouse);

        return view('member.warehousev2.customer_wis.customer_load_wis_table',$data);
    }

    public function getCreate()
    {
        $data['page'] = 'CREATE - CUSTOMER WIS';
        //$data['_item']  = Item::get_all_category_item([1,5]);
        //$data['_warehouse'] = Warehouse2::get_all_warehouse($this->user_info->shop_id);
        return view('member.warehousev2.wis.wis_create',$data);
    }

}
