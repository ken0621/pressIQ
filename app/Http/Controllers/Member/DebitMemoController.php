<?php

namespace App\Http\Controllers\Member;
use App\Models\Tbl_customer;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_credit_memo_line;
use App\Models\Tbl_debit_memo;
use App\Models\Tbl_debit_memo_line;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Customer;
use App\Globals\Vendor;
use App\Globals\DebitMemo;
use App\Http\Controllers\Controller;
use Request;

class DebitMemoController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $access = Utilities::checkAccess('vendor-debit-memo', 'access_page');
        if($access == 1)
        { 
            $data["page"]       = "Credit Memo";
            $data["_vendor"]    = Vendor::getAllVendor('active');
            $data['_item']      = Item::get_all_category_item();
            $data['_um']        = UnitMeasurement::load_um_multi();
            $data["action"]     = "/member/vendor/debit_memo/create_submit";

            $id = Request::input('id');
            if($id)
            {
                $data["db"]            = Tbl_debit_memo::where("db_id", $id)->first();
                $data["_dbline"]       = Tbl_debit_memo_line::um()->where("dbline_db_id", $id)->get();
                $data["action"]         = "/member/vendor/debit_memo/update";
            }

            return view("member.vendor.debit_memo.debit_memo_add",$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function create_submit()
    {
        $vendor_info[] = null;
        $vendor_info["db_vendor_id"] = Request::input("db_vendor_id");
        $vendor_info["db_vendor_email"] = Request::input("db_vendor_email");
        $vendor_info["db_date"] = datepicker_input(Request::input("db_date"));
        $vendor_info["db_message"] = Request::input("db_message");
        $vendor_info["db_memo"] = Request::input("db_memo");
        $vendor_info["db_amount"] = Request::input("overall_price");

        $item_info[] = null;
        $ctr_items = 0;
        $_items = Request::input("dbline_item_id");
        foreach ($_items as $key => $value) 
        {   
            if($value)
            {
                $ctr_items++;
                $item_info[$key]['item_service_date']  = datepicker_input(Request::input('dbline_service_date')[$key]);
                $item_info[$key]['item_id']            = Request::input('dbline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('dbline_description')[$key];
                $item_info[$key]['um']                 = Request::input('dbline_um')[$key];
                $item_info[$key]['quantity']           = str_replace(',', "",Request::input('dbline_qty')[$key]);
                $item_info[$key]['rate']               = str_replace(',', "", Request::input('dbline_rate')[$key]);
                $item_info[$key]['amount']             = str_replace(',', "", Request::input('dbline_amount')[$key]);
            }        
        }
        if($ctr_items != 0)
        {
            $db_id = DebitMemo::postdb($vendor_info, $item_info);

            $data["status"] = "success-debit-memo";
            $data["redirect_to"] = "/member/vendor/debit_memo?id=".$db_id;            
        }
        else
        {
            $data["status"] = "error";
            $data["status_message"] = "Please Insert Items";
        }

        return json_encode($data);
    }
    public function update_submit()
    {
        $db_id = Request::input("debit_memo_id");

        $vendor_info[] = null;
        $vendor_info["db_vendor_id"] = Request::input("db_vendor_id");
        $vendor_info["db_vendor_email"] = Request::input("db_vendor_email");
        $vendor_info["db_date"] = datepicker_input(Request::input("db_date"));
        $vendor_info["db_message"] = Request::input("db_message");
        $vendor_info["db_memo"] = Request::input("db_memo");
        $vendor_info["db_amount"] = Request::input("overall_price");

        $item_info[] = null;
        $_items = Request::input("dbline_item_id");
        foreach ($_items as $key => $value) 
        {
            if($value)
            {
                $item_info[$key]['item_service_date']  = datepicker_input(Request::input('dbline_service_date')[$key]);
                $item_info[$key]['item_id']            = Request::input('dbline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('dbline_description')[$key];
                $item_info[$key]['um']                 = Request::input('dbline_um')[$key];
                $item_info[$key]['quantity']           = str_replace(',', "",Request::input('dbline_qty')[$key]);
                $item_info[$key]['rate']               = str_replace(',', "", Request::input('dbline_rate')[$key]);
                $item_info[$key]['amount']             = str_replace(',', "", Request::input('dbline_amount')[$key]);
            }     
        }

        DebitMemo::updatedb($db_id, $vendor_info, $item_info);

        $data["status"] = "success-debit-memo";
        $data["redirect_to"] = "/member/vendor/debit_memo?id=".$db_id;

        return json_encode($data);
    }
    public function db_list()
    {        
        $access = Utilities::checkAccess('vendor-debit-memo', 'access_page');
        if($access == 1)
        { 
            $data["_db"] = Tbl_debit_memo::vendor()->orderBy("tbl_debit_memo.db_id","DESC")->get();

            return view("member.vendor.debit_memo.db_list",$data);
        }
        else
        {
            return $this->show_no_access();
        }        
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
