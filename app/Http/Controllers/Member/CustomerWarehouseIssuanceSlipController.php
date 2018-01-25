<?php

namespace App\Http\Controllers\Member;
use Illuminate\Http\Request;
use Redirect;

use App\Globals\Warehouse2;
use App\Globals\Warehouse;
use App\Globals\Utilities;
use App\Globals\Vendor;
use App\Globals\Pdf_global;
use App\Globals\UnitMeasurement;
use App\Globals\Purchasing_inventory_system;
use App\Globals\CustomerWIS;
use App\Globals\TransactionSalesOrder;
use App\Globals\TransactionSalesInvoice;
use App\Globals\TransactionSalesReceipt;
use App\Globals\TransactionEstimateQuotation;
use App\Globals\Customer;
use App\Globals\WarehouseTransfer;
use App\Http\Controllers\Controller;
use App\Models\Tbl_customer_wis_item_line;
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
     * @author EDEN
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $data['page'] = 'WIS';
        $data['status'] = isset($request->status) ? $request->status : 'pending';
        $current_warehouse = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $data['_cust_wis'] = CustomerWIS::get_all_customer_wis($this->user_info->shop_id, $data['status'], $current_warehouse);
        //dd($data['_cust_wis']);
        return view('member.warehousev2.customer_wis.customer_wis_list',$data);
    }

    public function getCustomerLoadWisTable(Request $request)
    {
        $current_warehouse = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $data['status'] = isset($request->status) ? $request->status : 'pending';
        $data['_cust_wis'] = CustomerWIS::get_all_customer_wis($this->user_info->shop_id, $data['status'], $current_warehouse);

        return view('member.warehousev2.customer_wis.load_customer_wis_table',$data);
    }

    public function getCreate(Request $request)
    {
        $data['page'] = 'CREATE - CUSTOMER WIS';
        $data['_item']  = Item::get_all_category_item([1,4,5]);
        $data["_customer"]  = Customer::getAllCustomer();
        $data['action']     = "/member/customer/wis/create-submit";

        $data['c_id'] = $request->customer_id;
        //dd($data['c_id']);
        $cust_wis_id = $request->id;
        if($cust_wis_id)
        {
            $data["wis"]  = CustomerWIS::get_customer_wis_data($cust_wis_id);
            $data["_wisline"] = CustomerWIS::get_wis_line($cust_wis_id);
            $data['action']     = "/member/customer/wis/update-submit";
        }

        return view('member.warehousev2.customer_wis.customer_wis_create',$data);
    }
    public function postCreateSubmit(Request $request)
    {
        $btn_action = $request->button_action;
        
        $remarks = $request->cust_wis_remarks;
        $items = Session::get('cust_wis_item');
        $items = $request->item_id;
        $shop_id = $this->user_info->shop_id;

        
        $ins_wis['cust_wis_shop_id']                = $shop_id;
        $ins_wis['transaction_refnum']              = $request->cust_wis_number;
        $ins_wis['cust_wis_from_warehouse']         = Warehouse2::get_current_warehouse($shop_id);
        $ins_wis['cust_email']                      = $request->customer_email;
        $ins_wis['total_amount']                    = $request->overall_price;
        $ins_wis['cust_wis_remarks']                = $remarks;
        $ins_wis['destination_customer_id']         = $request->customer_id;
        $ins_wis['destination_customer_address']    = $request->customer_address;
        $ins_wis['cust_receiver_code']              = $this->user_info->user_id;
        $ins_wis['cust_delivery_date']              = date("Y-m-d", strtotime($request->delivery_date));
        $ins_wis['created_at']                      = Carbon::now();

        //die(var_dump($ins_wis['cust_delivery_date']));
        $_item = null;
        $insert_item = null;
        foreach ($items as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id'] = $value;
                $insert_item[$key]['item_description'] = $request->item_description[$key];
                $insert_item[$key]['item_qty'] = $request->item_qty[$key];
                $insert_item[$key]['item_um'] = $request->item_um[$key];
                $insert_item[$key]['item_rate'] = $request->item_rate[$key];
                $insert_item[$key]['item_amount'] = $request->item_amount[$key];
                $insert_item[$key]['item_discount'] = 0;

                $_item[$key] = null;
                $_item[$key]['item_id'] = $value;
                $_item[$key]['quantity'] = $request->item_qty[$key] * UnitMeasurement::um_qty($insert_item[$key]['item_um']);
                $_item[$key]['remarks'] = $request->item_description[$key];

            }
        }

        $val = CustomerWIS::customer_create_wis($shop_id, $remarks, $ins_wis, $_item, $insert_item);

        $data = null;
        if(is_numeric($val))
        {
            $data['status'] = 'success';
            $data['call_function'] = 'success_create_customer_wis';
            $data['status_message'] = 'Success';


            if($btn_action == 'sclose')
            {
                $data['redirect_to'] = '/member/customer/wis';
            }
            if($btn_action == 'snew')
            {
                $data['redirect_to'] = '/member/customer/wis/create';
            }
            if($btn_action == 'sedit')
            {
                $data['redirect_to'] = '/member/customer/wis/create?id='.$val;
            }
            if($btn_action == 'sprint')
            {
                $data['redirect_to'] = '/member/customer/wis/print/'.$val;
            }
        }
        else
        {
            $data['status'] = 'error';
            $data['status_message'] = $val;
        }
        
        return json_encode($data);
    }
    public function postUpdateSubmit(Request $request)
    {
        $btn_action = $request->button_action;
        $wis_id  = $request->cust_wis_id;
        $remarks = $request->cust_wis_remarks;
        $items = Session::get('cust_wis_item');
        $items = $request->item_id;
        $shop_id = $this->user_info->shop_id;

        
        //die(var_dump($wis_id));
        $ins_wis['cust_wis_shop_id']                = $shop_id;
        $ins_wis['transaction_refnum']              = $request->cust_wis_number;
        $ins_wis['cust_wis_from_warehouse']         = Warehouse2::get_current_warehouse($shop_id);
        $ins_wis['cust_email']                      = $request->customer_email;
        $ins_wis['total_amount']                    = $request->overall_price;
        $ins_wis['cust_wis_remarks']                = $remarks;
        $ins_wis['destination_customer_id']         = $request->customer_id;
        $ins_wis['destination_customer_address']    = $request->customer_address;
        $ins_wis['cust_receiver_code']              = $this->user_info->user_id;
        $ins_wis['cust_delivery_date']              = date("Y-m-d", strtotime($request->delivery_date));
        $ins_wis['created_at']                      = Carbon::now();

        //die(var_dump($ins_wis['cust_delivery_date']));
        $_item = null;
        $insert_item = null;
        foreach ($items as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id'] = $value;
                $insert_item[$key]['item_description'] = $request->item_description[$key];
                $insert_item[$key]['item_qty'] = $request->item_qty[$key];
                $insert_item[$key]['item_um'] = $request->item_um[$key];
                $insert_item[$key]['item_rate'] = $request->item_rate[$key];
                $insert_item[$key]['item_amount'] = $request->item_amount[$key];
                $insert_item[$key]['item_discount'] = 0;

                $_item[$key] = null;
                $_item[$key]['item_id'] = $value;
                $_item[$key]['quantity'] = $request->item_qty[$key] * UnitMeasurement::um_qty($insert_item[$key]['item_um']);
                $_item[$key]['remarks'] = $request->item_description[$key];

            }
        }

        $val = CustomerWIS::customer_update_wis($wis_id, $shop_id, $remarks, $ins_wis, $_item, $insert_item);
        //die(var_dump($val));
        $data = null;
        if(is_numeric($val))
        {
            $data['status'] = 'success';
            $data['call_function'] = 'success_create_customer_wis';
            $data['status_message'] = 'Success';


            if($btn_action == 'sclose')
            {
                $data['redirect_to'] = '/member/customer/wis';
            }
            if($btn_action == 'snew')
            {
                $data['redirect_to'] = '/member/customer/wis/create';
            }
            if($btn_action == 'sedit')
            {
                $data['redirect_to'] = '/member/customer/wis/create?id='.$val;
            }
            if($btn_action == 'sprint')
            {
                $data['redirect_to'] = '/member/customer/wis/print/'.$val;
            }
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
    public function getCountTransaction(Request $request)
    {
        $customer_id = $request->customer_id;
        return CustomerWIS::countTransaction($this->user_info->shop_id, $customer_id);
    }
    public function getLoadTransaction(Request $request)
    {
        $data['page'] = "Open Transaction";

        $data['_eq'] = TransactionEstimateQuotation::getOpenEQ($this->user_info->shop_id, $request->c);
        $data['_so'] = TransactionSalesOrder::getOpenSO($this->user_info->shop_id, $request->c);
        $data['_si'] = TransactionSalesInvoice::getUndeliveredSalesInvoice($this->user_info->shop_id, $request->c);
        $data['_sr'] = TransactionSalesReceipt::getUndeliveredSalesReceipt($this->user_info->shop_id, $request->c);
        $data['customer_name'] = Customer::get_name($this->user_info->shop_id, $request->c);
        $data['action'] = '/member/customer/wis/apply-transaction';
        return view('member.warehousev2.customer_wis.load_transaction', $data);
    }
    public function postApplyTransaction(Request $request)
    {
        $_transaction = $request->apply_transaction;
        Session::put('applied_transaction', $_transaction);

        $return['call_function'] = "success_apply_transaction";
        $return['status'] = "success";

        return json_encode($return);
    }
    public function getLoadAppliedTransaction(Request $request)
    {
        $_ids = Session::get('applied_transaction');

        $return = null;
        $remarks = null;
        if(count($_ids) > 0)
        {
            foreach ($_ids as $key => $value) 
            {
                $get = CustomerWIS::get_inv_item($this->user_info->shop_id, $key);
                $info = CustomerWIS::get_inv($this->user_info->shop_id, $key);

                foreach ($get as $key_item => $value_item)
                {
                    $type = Item::get_item_type($value_item->invline_item_id);
                    if($type == 1 || $type == 4 || $type == 5 )
                    {
                        $return[$key.'i'.$key_item]['item_id'] = $value_item->invline_item_id;
                        $return[$key.'i'.$key_item]['item_description'] = $value_item->invline_description;
                        $return[$key.'i'.$key_item]['item_um'] = $value_item->invline_um;
                        $return[$key.'i'.$key_item]['item_qty'] = $value_item->invline_qty;
                        $return[$key.'i'.$key_item]['item_rate'] = $value_item->invline_rate;
                        $return[$key.'i'.$key_item]['item_amount'] = $value_item->invline_amount;
                    }
                }
                if($info)
                {
                    $remarks .= $info->transaction_refnum != "" ? $info->transaction_refnum.', ' : 'INV#'.$info->inv_id.', ';
                }
            }
        }
        $data['_item']  = Item::get_all_category_item([1,4,5]);
        $data['_transactions'] = $return;
        $data['remarks'] = $remarks;

        return view('member.warehousev2.customer_wis.applied_transaction', $data);
    }
}
