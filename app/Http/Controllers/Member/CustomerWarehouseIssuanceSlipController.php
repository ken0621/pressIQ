<?php

namespace App\Http\Controllers\Member;
use Illuminate\Http\Request;

use App\Models\Tbl_warehouse;
use App\Models\Tbl_user_warehouse_access;
use App\Models\Tbl_item;
use App\Models\Tbl_sub_warehouse;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_settings;
use App\Models\Tbl_customer_wis;
use Redirect;

use App\Globals\Warehouse2;
use App\Globals\Warehouse;
use App\Globals\Utilities;
use App\Globals\Vendor;
use App\Globals\Pdf_global;
use App\Globals\UnitMeasurement;
use App\Globals\Purchasing_inventory_system;
use App\Globals\CustomerWIS;
use App\Globals\WarehouseTransfer;
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
        $data['_cust_wis'] = CustomerWIS::get_all_customer_wis($this->user_info->shop_id, $data['status'], $current_warehouse);
        return view('member.warehousev2.customer_wis.customer_wis_list',$data);
    }

    public function getCustomerLoadWisTable(Request $request)
    {
        $current_warehouse = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $data['status'] = isset($request->status) ? $request->status : 'pending';
        $data['_cust_wis'] = CustomerWIS::get_all_customer_wis($this->user_info->shop_id, $data['status'], $current_warehouse);

        return view('member.warehousev2.customer_wis.load_customer_wis_table',$data);
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
        $remarks = $request->cust_wis_remarks;
        $items = Session::get('cust_wis_item');
        $items = $request->item_id;
        $shop_id = $this->user_info->shop_id;
        
        //dd($this->user_info->shop_id);
        $ins_wis['cust_wis_shop_id']                = $shop_id;
        $ins_wis['cust_wis_number']                 = $request->cust_wis_number;
        $ins_wis['cust_wis_from_warehouse']         = Warehouse2::get_current_warehouse($shop_id);
        $ins_wis['cust_wis_remarks']                = $remarks;
        $ins_wis['destination_customer_id']         = $request->customer_id;
        $ins_wis['destination_customer_address']    = $request->customer_address;
        $ins_wis['cust_receiver_code']              = $this->user_info->user_id;
        $ins_wis['cust_delivery_date']              = $request->delivery_date;
        $ins_wis['created_at']                      = Carbon::now();

        $_item = null;
        foreach ($items as $key => $value) 
        {
            if($value)
            {
                $_item[$key] = null;
                $_item[$key]['item_id'] = $value;
                $_item[$key]['quantity'] = $request->item_quantity[$key];
                $_item[$key]['remarks'] = $request->cust_wis_remarks[$key];
            }
        }

        $val = CustomerWIS::customer_create_wis($shop_id, $remarks,$ins_wis , $_item);
        $data = null;
        if(is_numeric($val))
        {
            $data['status'] = 'success';
            $data['call_function'] = 'success_create_customer_wis';
            
        }
        else
        {
            $data['status'] = 'error';
            $data['status_message'] = $val;
        }
        
        return json_encode($data);
    }

    public function getConfirm(Request $request, $cust_wis_id)
    {
        $data['cust_wis_id'] = $cust_wis_id;
        $data['cust_wis'] = CustomerWIS::get_customer_wis_data($cust_wis_id);

        return view('member.warehousev2.customer_wis.customer_wis_confirm', $data);
    }

    public function postConfirmSubmit(Request $request)
    {
        $cust_wis_id = $request->customer_wis_id;
        $update['cust_wis_status'] = $request->confirm_status;
        $update['cust_confirm_image'] = $request->confirm_image;
        $update['cust_receiver_code'] = $this->user_info->user_id;

        $return = CustomerWIS::update_customer_wis($this->user_info->shop_id, $cust_wis_id, $update);

        $data = null;
        if($return)
        {
            $data['status'] = 'success';
            $data['call_function'] = 'success_confirm'; 
        }

        return json_encode($data);
    }
     public function getPrint(Request $request, $wis_id)
    {

        $data['wis'] = CustomerWIS::get_customer_wis_data($wis_id);

        $customer_id = $data['wis']->destination_customer_id;

        $data['wis_item'] = CustomerWIS::print_customer_wis_item($wis_id);
        $data['user'] = $this->user_info;
        $data['owner'] = WarehouseTransfer::get_warehouse_data($data['wis']->cust_wis_from_warehouse);
        $data['customer'] = CustomerWIS::get_customer($this->user_info->shop_id)->where('customer_id',$customer_id);
        //dd($data['customer']);
        
        //return view('member.warehousev2.customer_wis.customer_wis_print', $data);
        $pdf = view('member.warehousev2.customer_wis.customer_wis_print', $data);
        return Pdf_global::show_pdf($pdf,null,$data['wis']->cust_wis_number);
    }

    /*public function getReceiveItems(Request $request, $cust_wis_id)
    {
        $check = CustomerWIS::get_customer_wis_data($cust_wis_id);
        if($check)
        {
            Session::put('cust_wis_id',$cust_wis_id);
            return redirect('/member/customer/wis/receive-inventory');
        }
    }

    public function getReceiveInventory()
    {
        $check = CustomerWIS::get_customer_wis_data((Session::get('cust_wis_id')));
        if($check)
        {
            $cust_wis_id = Session::get('cust_wis_id');

            $data['customer_wis'] = CustomerWIS::get_customer_wis_data($cust_wis_id);
            $data['cust_wis_item'] = CustomerWIS::get_customer_wis_item($cust_wis_id);

            //dd($data);
            return view('member.warehousev2.customer_wis.customer_wis_receive',$data);
        }
        else
        {
            return redirect('/member/customer/wis');
        }
    }

    public function postReceiveInventorySubmit(Request $request)
    {

        $shop_id = $this->user_info->shop_id;
        $ins_rr['rr_shop_id'] = $shop_id;
        $ins_rr['rr_number'] = $request->rr_number;
        $ins_rr['cust_wis_id'] = Session::get('cust_wis_id');
        $ins_rr['warehouse_id'] = Warehouse2::get_current_warehouse($shop_id);
        $ins_rr['rr_remarks'] = $request->rr_remarks;
        $ins_rr['created_at'] = Carbon::now();

        $wis_data = CustomerWIS::get_customer_wis_data((Session::get('cust_wis_id')));

        $_item = $request->rr_item_quantity;

        $return = null;

        $items = null;
        foreach ($_item as $key => $value) 
        {
            if($value)
            {
                if($request->wis_item_quantity[$key] < $value)
                {
                    $return .= "The ITEM no ".$key." is not enough to transfer <br>";
                }

                $items[$key]['item_id'] = $key;
                $items[$key]['quantity'] = $value;
                $items[$key]['remarks'] = 'Transfer item no. '.$key.' from WIS -('.$wis_data->wis_number.')';                
            }
        }

        $data = null;
        if(count($items) > 0)
        {
            if(!$return)
            {
                $val = CustomerWIS::receive_item($shop_id, $ins_rr['cust_wis_id'], $ins_rr, $items);
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

    }*/
}
