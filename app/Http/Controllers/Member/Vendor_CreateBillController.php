<?php

namespace App\Http\Controllers\Member;

use Request;
use App\Http\Controllers\Controller;
use App\Models\Tbl_customer;
use App\Models\Tbl_warehousea;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_manual_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_item;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_vendor;
use App\Globals\Vendor;
use App\Globals\AuditTrail;
use App\Globals\Accounting;
use App\Globals\Purchase_Order;
use App\Globals\Billing;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_bill;
use App\Models\Tbl_bill_account_line;
use App\Models\Tbl_bill_item_line;
use Carbon\Carbon;

class Vendor_CreateBillController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["_bill_list"] = Tbl_bill::vendor()->where("bill_shop_id",Billing::getShopId())->get();

        foreach ($data["_bill_list"] as $key => $value) 
        {
           $price = 0;
           $item = Tbl_bill_item_line::where("itemline_bill_id",$value->bill_id)->get();
           foreach ($item as $key_item => $value_item) 
           {
                $price += (UnitMeasurement::um_qty($value_item->itemline_um) * $value_item->itemline_qty) * $value_item->itemline_rate;
           }
           $data["_bill_list"][$key]->bill_price = $price;
        }
        return view("member.vendor_list.bill_list",$data);
    }    
    public function create_bill()
    {
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data['_item']      = Item::get_all_category_item();
        $data['_account']   = Accounting::getAllAccount();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['action']     = "/member/vendor/create_bill/add";
        $data['vendor_id']     = Request::input("vendor_id");
        
        $data["_po"] = Tbl_purchase_order::where("po_vendor_id",Request::input("vendor_id"))->where("po_is_billed",0)->get();

        $id = Request::input("id");
        if($id)
        {
           $data["bill"] = Tbl_bill::where("bill_id",$id)->first();
           $data["_bill_item_line"] = Tbl_bill_item_line::where("itemline_bill_id",$id)->get();
           $data['_item']      = Item::get_all_category_item();
           $data['_account']   = Accounting::getAllAccount();
           $data['action']     = "/member/vendor/create_bill/update";
        }
        
       return view("member.vendor_list.create_bill",$data);
    }
    public function load_purchase_order($vendor_id)
    {
        $data["_po"] = Tbl_purchase_order::where("po_vendor_id",$vendor_id)->where("po_is_billed",0)->get();

        return view("member.load_ajax_data.load_purchase_order",$data);
    }
    public function load_po_item()
    {
        $po_id = Request::input("po_id");
        $data = Tbl_purchase_order_line::um()->where("poline_po_id",$po_id)->get();

        return json_encode($data);
    }
    public function add_bill()
    {
        $button_action = Request::input('button_action');

        $vendor_info                         = [];
        $vendor_info['bill_vendor_id']       = Request::input('bill_vendor_id');
        $vendor_info['bill_vendor_email']    = Request::input('bill_vendor_email');
        $vendor_info['bill_mailing_address'] = Request::input('bill_mailing_address');

        $bill_info                          = [];
        $bill_info['bill_terms_id']         = Request::input('bill_terms_id');
        // $invoice_info['new_inv_id']         = Request::input('new_invoice_id');
        $bill_info['bill_date']             = datepicker_input(Request::input('bill_date'));
        $bill_info['bill_due_date']         = datepicker_input(Request::input('bill_due_date'));

        $bill_other_info                    = [];
        $bill_other_info['bill_memo']       = Request::input('bill_memo');

        $total_info                         = [];
        $total_info['bill_total_amount']    = Request::input('bill_total_amount');

        $item_info                          = [];
        $_itemline                          = Request::input('itemline_item_id');

        foreach($_itemline as $key => $item_line)
        {
            if($item_line)
            {
                $item_info[$key]['itemline_description']  = Request::input('itemline_description')[$key];
                $item_info[$key]['itemline_um']           = Request::input('itemline_um')[$key];
                $item_info[$key]['itemline_item_id']      = Request::input('itemline_item_id')[$key];
                $item_info[$key]['itemline_qty']          = str_replace(",","", Request::input('itemline_qty')[$key]);
                $item_info[$key]['itemline_rate']         = str_replace(",","", Request::input('itemline_rate')[$key]);
                $item_info[$key]['itemline_amount']       = str_replace(",","", Request::input('itemline_amount')[$key]);
            }
        }


        // $inv = Transaction::check_number_existense("tbl_customer_invoice","new_inv_id","inv_shop_id",Request::input('new_invoice_id'));

        // if($inv == 0 || Request::input("keep_val") == "keep")
        // {
            $bill_id = Billing::postBill($vendor_info, $bill_info, $bill_other_info, $item_info, $total_info);
    
            $json["status"]         = "success-bill";
            if($button_action == "save-and-edit")
            {
                $json["redirect"]    = "/member/vendor/bill_list";
            }
            elseif($button_action == "save-and-new")
            {
                $json["redirect"]   = '/member/vendor/create_bill';
            }
            Request::session()->flash('success', 'Invoice Successfully Created');
        // }
        // else
        // {
        //     $json["inv_id"] = Request::input("new_invoice_id");            
        //     $json["status"] = "error-inv-no";
        // }

        return json_encode($json);

    }
    public function update_bill()
    {
        $bill_id = Request::input("bill_id");
        $button_action = Request::input('button_action');

        $vendor_info                         = [];
        $vendor_info['bill_vendor_id']       = Request::input('bill_vendor_id');
        $vendor_info['bill_vendor_email']    = Request::input('bill_vendor_email');
        $vendor_info['bill_mailing_address'] = Request::input('bill_mailing_address');

        $bill_info                          = [];
        $bill_info['bill_terms_id']         = Request::input('bill_terms_id');
        // $invoice_info['new_inv_id']         = Request::input('new_invoice_id');
        $bill_info['bill_date']             = datepicker_input(Request::input('bill_date'));
        $bill_info['bill_due_date']         = datepicker_input(Request::input('bill_due_date'));

        $bill_other_info                    = [];
        $bill_other_info['bill_memo']       = Request::input('bill_memo');

        $total_info                         = [];
        $total_info['bill_total_amount']    = Request::input('bill_total_amount');

        $item_info                          = [];
        $_itemline                          = Request::input('itemline_item_id');

        foreach($_itemline as $key => $item_line)
        {
            if($item_line)
            {
                $item_info[$key]['itemline_description']  = Request::input('itemline_description')[$key];
                $item_info[$key]['itemline_um']           = Request::input('itemline_um')[$key];
                $item_info[$key]['itemline_item_id']      = Request::input('itemline_item_id')[$key];
                $item_info[$key]['itemline_qty']          = str_replace(",","", Request::input('itemline_qty')[$key]);
                $item_info[$key]['itemline_rate']         = str_replace(",","", Request::input('itemline_rate')[$key]);
                $item_info[$key]['itemline_amount']       = str_replace(",","", Request::input('itemline_amount')[$key]);
            }
        }


        // $inv = Transaction::check_number_existense("tbl_customer_invoice","new_inv_id","inv_shop_id",Request::input('new_invoice_id'));

        // if($inv == 0 || Request::input("keep_val") == "keep")
        // {
            $bill_id = Billing::updateBill($bill_id, $vendor_info, $bill_info, $bill_other_info, $item_info, $total_info);
    
            $json["status"]         = "success-bill";
            if($button_action == "save-and-edit")
            {
                $json["redirect"]    = "/member/vendor/create_bill?id=".$bill_id;
            }
            elseif($button_action == "save-and-new")
            {
                $json["redirect"]   = '/member/vendor/create_bill';
            }
            Request::session()->flash('success', 'Invoice Successfully Created');
        // }
        // else
        // {
        //     $json["inv_id"] = Request::input("new_invoice_id");            
        //     $json["status"] = "error-inv-no";
        // }

        return json_encode($json);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
