<?php

namespace App\Http\Controllers\Member;
use App\Models\Tbl_warehouse;
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
class WarehouseControllerV2 extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data['page'] = "Warehouse V2";
       
        $access = Utilities::checkAccess('warehouse-inventory', 'access_page');
        if($access == 1)
        { 
            $data["_warehouse"] = Tbl_warehouse::inventory()->select_info($this->user_info->shop_id, 0)->groupBy("tbl_warehouse.warehouse_id");
            $data["_warehouse"] = $data["_warehouse"]->paginate(10);
            if(Request::input("search_txt"))
            {
               $data["_warehouse"]->where("warehouse_name","LIKE","%".Request::input("search_txt")."%");
            }
            //dd($data["_warehouse"]);
        }
        return view('member.warehousev2.list_warehouse',$data);
    }
}
