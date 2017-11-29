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
use App\Globals\CustomerWIS;
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
        $data['_item']  = Item::get_all_category_item([1,5]);
        $data['_customer'] = CustomerWIS::get_customer($this->user_info->shop_id);

        return view('member.warehousev2.customer_wis.customer_wis_create',$data);
    }
    public function postCreateSubmit(Request $request)
    {
        $remarks = $request->remarks;
        $items = Session::get('cust_wis_item');
        $items = $request->item_id;
        $shop_id = $this->user_info->shop_id;
        
        //dd($this->user_info->shop_id);
        $ins_wis['cust_wis_shop_id']                = $shop_id;
        $ins_wis['cust_wis_number']                 = $request->wis_number;
        $ins_wis['cust_wis_from_warehouse']         = Warehouse2::get_current_warehouse($shop_id);
        $ins_wis['cust_wis_remarks']                = $remarks;
        $ins_wis['destination_customer_id']         = $request->customer_id;
        $ins_wis['destination_customer_address']    = $request->customer_address;
        $ins_wis['cust_receiver_code']              = $this->info_user->user_id;
        $ins_wis['cust_delivery_date']              = $request->delivery_date;
        $ins_wis['created_at']                      = Carbon::now();

        /*$_item = null;
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

        return json_encode($return);*/
        return $ins_wis;
    }

}
