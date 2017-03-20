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
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data['_item']      = Item::get_all_category_item();
        $data['_account']   = Accounting::getAllAccount();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['action']     = "/member/vendor/create_bill/add";

        $data["_po"] = Tbl_purchase_order::where("po_vendor_id",Request::input("vendor_id"))->where("po_is_paid",0)->get();
        
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
        $data["_po"] = Tbl_purchase_order::where("po_vendor_id",$vendor_id)->where("po_is_paid",0)->get();

        return view("member.load_ajax_data.load_purchase_order",$data);
    }
    public function load_po_item()
    {
        $po_id = Request::input("po_id");
        $data = Tbl_purchase_order_line::where("poline_po_id",$po_id)->get();

        return json_encode($data);
    }
    public function add_bill()
    {

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
