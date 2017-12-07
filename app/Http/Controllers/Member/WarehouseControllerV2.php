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
            
            $data["_warehouse_archived"] = null;

            $data['pis'] = Purchasing_inventory_system::check();
            $data['_warehouse_list'] = Warehouse2::load_warehouse_list($this->user_info->shop_id, $this->user_info->user_id);

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
            
            $data['_warehouse'] = Warehouse2::load_all_warehouse_select($this->user_info->shop_id, $this->user_info->user_id, 0, $data['warehouse']->warehouse_parent_id);
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
        $up_warehouse["warehouse_parent_id"] = Request::input("warehouse_parent_id");

        if($up_warehouse['warehouse_parent_id'])
        {            
            $up_warehouse["warehouse_level"] = Tbl_warehouse::where('warehouse_id', $up_warehouse['warehouse_parent_id'])->value('warehouse_level');
            $up_warehouse["warehouse_level"]++;
        }

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
           $data['_warehouse'] = Warehouse2::load_all_warehouse_select($this->user_info->shop_id, $this->user_info->user_id);
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
        $ins_warehouse["warehouse_parent_id"] = Request::input("warehouse_parent_id");
        $ins_warehouse["warehouse_shop_id"] = $this->user_info->shop_id;
        $ins_warehouse["warehouse_created"] = Carbon::now();

        if($ins_warehouse['warehouse_parent_id'])
        {            
            $ins_warehouse["warehouse_level"] = Tbl_warehouse::where('warehouse_id', $ins_warehouse['warehouse_parent_id'])->value('warehouse_level');
            $ins_warehouse["warehouse_level"]++;
        }

        $id = Tbl_warehouse::insertGetId($ins_warehouse);
              
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
            //$data["_item"] = Warehouse::select_item_warehouse_single($id,'array');
            $data['_item']  = Item::get_all_category_item([1,5]);
            //dd($data['_item']);
            return view("member.warehousev2.refill_warehouse",$data);

        }
        else
        {
            return $this->show_no_access_modal();
        }
    }
    
    public function postRefillSubmit()
    {
        $shop_id        = $this->user_info->shop_id;
        $warehouse_id   = Request::input("warehouse_id");

        $remarks        = Request::input("remarks");
        $reference_name = Request::input("reference_name") == "other" ? "other" : "vendor";
        $reference_id   = Request::input("reference_name") == "other" ? 0 : Request::input("reference_name");
        
        $item_quantity = Request::input("item_quantity");
        $item_id = Request::input("item_id");

        $_item = null;
        foreach ($item_id as $key => $value) 
        {
            if($value)
            {
                $_item[$key]['item_id'] = $value;
                $_item[$key]['quantity'] = str_replace(",","",$item_quantity[$key]); 
                $_item[$key]['remarks'] = Request::input("remarks");
            }
        }

        $data = Warehouse2::refill_bulk($shop_id, $warehouse_id, $reference_name, $reference_id, $remarks, $_item);

        //die(var_dump($data));
        
        $data['status'] = 'success';
        $data['call_function'] = 'success_refill_warehouse';

       /*
        $return = 0;
        if(is_numeric($data))
        {
            $return['status'] = 'success';
            $return['call_function'] = 'success_refill_warehouse';
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $data;

        }
        return json_encode($return);*/
        
        return json_encode($data);
       
       
        return $data;
    }

}
