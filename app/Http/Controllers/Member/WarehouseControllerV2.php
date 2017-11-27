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
            $data['_warehouse'] = Warehouse2::get_all_warehouse($this->user_info->shop_id);
            //dd($data["_warehouse"]);
            if(Request::input("search_txt"))
            {
               $data["_warehouse"]->where("warehouse_name","LIKE","%".Request::input("search_txt")."%");
            }
            
            $all_item = null;
            foreach($data["_warehouse"] as $key => $value)
            {
                $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$value->warehouse_id)->first();
                
                if(!$check_if_owned)
                {
                    unset($data["_warehouse"][$key]);
                }
            }
            
            $data["_warehouse_archived"] = null;

            $data['pis'] = Purchasing_inventory_system::check();

            return view('member.warehousev2.list_warehouse',$data);
        }
        else
        {
            return $this->show_no_access();
        }
        
    }

    public function getEdit($id)
    {
    
        $access = Utilities::checkAccess('warehouse-inventory', 'edit');
        if($access == 1)
        { 

            $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$id)->first();
            if(!$check_if_owned)
            {
                return $this->show_no_access_modal();
            }
            $data["warehouse"] = Tbl_warehouse::where("warehouse_id",$id)->first();
     
            return view("member.warehousev2.edit_warehouse",$data);
        }
        else
        {
            return $this->show_no_access_modal();
        }
    }
    public function postEditSubmit()
    {
        
        $warehouse_id  = Request::input("warehouse_id");

        $old_data = AuditTrail::get_table_data("tbl_warehouse","warehouse_id",$warehouse_id);

        $up_warehouse["warehouse_name"] = Request::input("warehouse_name");
        $up_warehouse["warehouse_address"] = Request::input("warehouse_address");

        Tbl_warehouse::where("warehouse_id",Request::input("warehouse_id"))->update($up_warehouse);

        $data['status'] = 'success';

        if($data['status'] == 'success')
        {
            $w_data = AuditTrail::get_table_data("tbl_warehouse","warehouse_id",$warehouse_id);
            AuditTrail::record_logs("Edited","warehouse",$warehouse_id,serialize($old_data),serialize($w_data));
        }

             return json_encode($data);
    }
    public function getAdd()
    {
        $data['$access'] = Utilities::checkAccess('warehouse-inventory', 'add');
        if($data['$access'] == 1)
        { 
           return view("member.warehousev2.add_warehouse", $data);
        }
        else
        {
            return $this->show_no_access_modal();
        }
    }

    public function postAddSubmit()
    {       
        //INSERT TO tbl_warehouse
        $ins_warehouse["warehouse_name"]    = Request::input("warehouse_name");
        $ins_warehouse["warehouse_address"] = Request::input("warehouse_address");
        $ins_warehouse["warehouse_shop_id"] = $this->user_info->shop_id;
        $ins_warehouse["warehouse_created"] = Carbon::now();

        $id = Tbl_warehouse::insertGetId($ins_warehouse);

        Warehouse::insert_access($id);
              
        $data['status'] = 'success';

        if($data['status'] == 'success')
        {
            $w_data = AuditTrail::get_table_data("tbl_warehouse","warehouse_id",$id);
            AuditTrail::record_logs("Added","warehouse",$id,"",serialize($w_data));
        }

         return json_encode($data);
    }

    public function getRefill()
    {
        $access = Utilities::checkAccess('warehouse-inventory', 'refill');
        if($access == 1)
        { 
            $id = Request::input("warehouse_id");
            $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$id)->first();
            if(!$check_if_owned)
            {
                return $this->show_no_access_modal();
            }
            $data["warehouse"] = Tbl_warehouse::where("warehouse_id",$id)->first();
            $data["_vendor"]    = Vendor::getAllVendor('active');
            /*$data["_item"] = Warehouse::select_item_warehouse_single($id,'array');
            dd($data["_item"][0]);*/
            $data['_item']  = Item::get_all_category_item([1,5]);
            dd($data['_item']);

            
            return view("member.warehousev2.refill_warehouse",$data);
        }
    }
}
