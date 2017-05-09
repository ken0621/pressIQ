<?php

namespace App\Http\Controllers\Member;

use App\Models\Tbl_customer;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_credit_memo_line;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Customer;
use App\Globals\CreditMemo;
use App\Http\Controllers\Controller;
use Request;

class CreditMemoController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data["page"]       = "Credit Memo";
        $data["_customer"]  = Customer::getAllCustomer();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["action"]     = "/member/customer/credit_memo/create_submit";

        $id = Request::input('id');
        if($id)
        {
            $data["cm"]            = Tbl_credit_memo::where("cm_id", $id)->first();
            $data["_cmline"]       = Tbl_credit_memo_line::um()->where("cmline_cm_id", $id)->get();
            $data["action"]         = "/member/customer/credit_memo/update";
        }

        return view("member.customer.credit_memo.credit_memo_add",$data);
    }
    public function create_submit()
    {
        $customer_info[] = null;
        $customer_info["cm_customer_id"] = Request::input("cm_customer_id");
        $customer_info["cm_customer_email"] = Request::input("cm_customer_email");
        $customer_info["cm_date"] = datepicker_input(Request::input("cm_date"));
        $customer_info["cm_message"] = Request::input("cm_message");
        $customer_info["cm_memo"] = Request::input("cm_memo");
        $customer_info["cm_amount"] = Request::input("overall_price");

        $item_info[] = null;
        $_items = Request::input("cmline_item_id");
        $ctr_items = 0;
        foreach ($_items as $key => $value) 
        {   
            if($value)
            {
                $ctr_items++;
                $item_info[$key]['item_service_date']  = datepicker_input(Request::input('cmline_service_date')[$key]);
                $item_info[$key]['item_id']            = Request::input('cmline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('cmline_description')[$key];
                $item_info[$key]['um']                 = Request::input('cmline_um')[$key];
                $item_info[$key]['quantity']           = str_replace(',', "",Request::input('cmline_qty')[$key]);
                $item_info[$key]['rate']               = str_replace(',', "", Request::input('cmline_rate')[$key]);
                $item_info[$key]['amount']             = str_replace(',', "", Request::input('cmline_amount')[$key]);
            }        
        }

        if($ctr_items != 0)
        {
            $cm_id = CreditMemo::postCM($customer_info, $item_info);

            $data["status"] = "success-credit-memo";
            $data["redirect_to"] = "/member/customer/credit_memo?id=".$cm_id;
        }
        else
        {
            $data["status"] = "error";
            $data["status_message"] = "Please Insert Item";
        }
        return json_encode($data);
    }
    public function update_submit()
    {
        $cm_id = Request::input("credit_memo_id");

        $ctr_items = 0;
        $customer_info[] = null;
        $customer_info["cm_customer_id"] = Request::input("cm_customer_id");
        $customer_info["cm_customer_email"] = Request::input("cm_customer_email");
        $customer_info["cm_date"] = datepicker_input(Request::input("cm_date"));
        $customer_info["cm_message"] = Request::input("cm_message");
        $customer_info["cm_memo"] = Request::input("cm_memo");
        $customer_info["cm_amount"] = Request::input("overall_price");

        $item_info[] = null;
        $_items = Request::input("cmline_item_id");
        foreach ($_items as $key => $value) 
        {  
            if($value)
            {
                $ctr_items++;
                $item_info[$key]['item_service_date']  = datepicker_input(Request::input('cmline_service_date')[$key]);
                $item_info[$key]['item_id']            = Request::input('cmline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('cmline_description')[$key];
                $item_info[$key]['um']                 = Request::input('cmline_um')[$key];
                $item_info[$key]['quantity']           = str_replace(',', "",Request::input('cmline_qty')[$key]);
                $item_info[$key]['rate']               = str_replace(',', "", Request::input('cmline_rate')[$key]);
                $item_info[$key]['amount']             = str_replace(',', "", Request::input('cmline_amount')[$key]);
            }
        }

        if($ctr_items != 0)
        {
            CreditMemo::updateCM($cm_id, $customer_info, $item_info);

            $data["status"] = "success-credit-memo";
            $data["redirect_to"] = "/member/customer/credit_memo?id=".$cm_id;
        }
        else
        {
            $data["status"] = "error";
            $data["status_message"] = "Please Insert Item";
        }

        return json_encode($data);
    }
    public function cm_list()
    {
        $data["_cm"] = Tbl_credit_memo::manual_cm()->customer()->orderBy("tbl_credit_memo.cm_id","DESC")->get();

        return view("member.customer.credit_memo.cm_list",$data);
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
