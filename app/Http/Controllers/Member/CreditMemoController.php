<?php

namespace App\Http\Controllers\Member;

use App\Models\Tbl_customer;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_credit_memo_line;
use App\Models\Tbl_item;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_payment_method;
use App\Models\Tbl_user;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Customer;
use App\Globals\Purchasing_inventory_system;
use App\Globals\CreditMemo;
use App\Globals\Accounting;
use App\Globals\Warehouse;
use App\Globals\Invoice;
use App\Http\Controllers\Controller;
use Request;
use Redirect;

class CreditMemoController extends Member
{
    public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function choose_type()
    {
        $data["cm_id"] = Request::input("cm_id");

        return view("member.customer.credit_memo.cm_type",$data);
    }
    public function update_action()
    {
        $cm_id = Request::input("cm_id");
        $cm_type = Request::input("type");

        $data["cm_data"] = Tbl_credit_memo::where("cm_id",$cm_id)->first();
        $data["c_id"] = Tbl_credit_memo::where("cm_id",$cm_id)->pluck("cm_customer_id");

        if($cm_type == "invoice")
        {
            $data["_customer"]      = Tbl_customer::where("customer_id",$data["c_id"])->first();
            $data['_account']       = Accounting::getAllAccount('all','',['Bank']);
            $data['_payment_method']= Tbl_payment_method::where("archived",0)->where("shop_id", $this->getShopId())->get();
            $data['action']         = "/member/customer/receive_payment/add";
            $data["_invoice"]       = Invoice::getAllInvoiceByCustomer($data["c_id"]);

            $cm_amount = $data["cm_data"]->cm_amount;
            $total_inv = 0;

            if(count($data["_invoice"]) > 0)
            {  
            //     foreach ($data["_invoice"] as $key => $value)  
            //     {
            //         $total_inv += $value["inv_overall_price"];
            //         if($cm_amount > $total_inv)
            //         {
            //             $data["_invoice"][$key]["amount_applied"] = $value["inv_overall_price"];
            //             $data["_invoice"][$key]["rpline_amount"] = $value["inv_overall_price"];
            //         }
            //     }
            // if($data["_invoice"][0]["inv_overall_price"] > $cm_amount)
            // {
                $data["_invoice"][0]["amount_applied"] = $cm_amount;
                $data["_invoice"][0]["rpline_amount"] = $cm_amount;
            // }
            }

            return view("member.receive_payment.modal_receive_payment",$data);
        }
        if($cm_type == "invoice_tablet")
        {
            $data["_customer"]      = Tbl_customer::where("customer_id",$data["c_id"])->first();
            $data['_account']       = Accounting::getAllAccount('all','',['Bank']);
            $data['_payment_method']= Tbl_payment_method::where("archived",0)->where("shop_id", $this->getShopId())->get();
            $data['action']         = "/tablet/receive_payment/add_submit";
            $data["_invoice"]       = Invoice::getAllInvoiceByCustomer($data["c_id"]);

            $cm_amount = $data["cm_data"]->cm_amount;
            $total_inv = 0;

            if(count($data["_invoice"]) > 0)
            {  
                $data["_invoice"][0]["amount_applied"] = $cm_amount;
                $data["_invoice"][0]["rpline_amount"] = $cm_amount;
            }
            return view("member.receive_payment.modal_receive_payment",$data);
        }
        if($cm_type == "others_tablet")
        {
            $up["cm_type"] = 1;
            $up["cm_used_ref_name"] = "others";

            Tbl_credit_memo::where("cm_id",$cm_id)->update($up);

            return Redirect::to("/tablet/credit_memo");
        }
    }
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

        $cm_type = Request::input("cm_type") == "" ? "returns" : Request::input("cm_type");
        $customer_info["cm_type"] = 0;
        if($cm_type != "returns")
        {
            $customer_info["cm_type"] = 1;
        }

        $item_info[] = null;
        $item_returns = [];
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

                $item_type = Tbl_item::where("item_id",Request::input('cmline_item_id')[$key])->pluck("item_type_id");
                if($item_type == 4 || $item_type == 1)
                {
                    $um_qty = UnitMeasurement::um_qty(Request::input("cmline_um")[$key]);
                    $item_returns[$key]["quantity"] = $um_qty * $item_info[$key]['quantity'];
                    $item_returns[$key]["product_id"] = Request::input('cmline_item_id')[$key];
                }
            }        
        }

        if($_items != null)
        {
             // --> for bundles
            foreach ($_items as $keyitem_cm => $value_item) 
            {
                if($value_item != null)
                {
                    $item_bundle_info = Tbl_item::where("item_id",Request::input("cmline_item_id")[$keyitem_cm])->where("item_type_id",4)->first();
                    if($item_bundle_info)
                    {
                        $bundle = Tbl_item_bundle::where("bundle_bundle_id",Request::input("cmline_item_id")[$keyitem_cm])->get();
                        foreach ($bundle as $key_bundle_cm => $value_bundle_cm) 
                        {
                            $qty = UnitMeasurement::um_qty(Request::input("cmline_um")[$keyitem_cm]);
                            $bundle_qty = UnitMeasurement::um_qty($value_bundle_cm->bundle_um_id);
                            $_bundle[$key_bundle_cm]['product_id'] = $value_bundle_cm->bundle_item_id;
                            $_bundle[$key_bundle_cm]['quantity'] = (Request::input('cmline_qty')[$keyitem_cm] * $qty) * ($value_bundle_cm->bundle_qty * $bundle_qty);

                            array_push($item_returns, $_bundle[$key_bundle_cm]);
                        }
                    }                 
                }
            }
            if(count($item_returns) > 0)
            {
                foreach ($item_returns as $key_items_cm => $value_items_cm) 
                {
                     $i = null;
                     foreach ($_items as $keyitemline_cm => $valueitemline)
                     {
                        $type = Tbl_item::where("item_id",Request::input("cmline_item_id")[$keyitemline_cm])->pluck("item_type_id");
                        if($type == 4)
                        {
                            if(Request::input("cmline_item_id")[$keyitemline_cm] == $value_items_cm['product_id'])
                            {
                                $i = "true";
                            }                    
                        }
                     }
                    if($i != null)
                    {
                        unset($item_returns[$key_items_cm]);
                    }           
                }            
            }
            // <-- end bundle            
        }
        // END CM/RETURNS 

        if($ctr_items != 0)
        {
            $cm_id = CreditMemo::postCM($customer_info, $item_info);
            
            if(count($item_returns) > 0)
            {
                $cm_remarks            = "Credit Memo # ". $cm_id;
                $cm_warehouse_id       = $this->current_warehouse->warehouse_id;
                $cm_transaction_type   = "credit_memo";
                $cm_transaction_id     = $cm_id;
                $cm_data               = Warehouse::inventory_refill($cm_warehouse_id, $cm_transaction_type, $cm_transaction_id, $cm_remarks, $item_returns, 'array' ,"returns");
            }

            $data["status"] = "success-credit-memo-action";
            $data["id"] = $cm_id;
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
        $item_returns = [];
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

                $item_type = Tbl_item::where("item_id",Request::input('cmline_item_id')[$key])->pluck("item_type_id");
                if($item_type == 4 || $item_type == 1)
                {
                    $um_qty = UnitMeasurement::um_qty(Request::input("cmline_um")[$key]);
                    $item_returns[$key]["quantity"] = $um_qty * $item_info[$key]['quantity'];
                    $item_returns[$key]["product_id"] = Request::input('cmline_item_id')[$key];
                }
            }
        }
         if($_items != null)
        {
             // --> for bundles
            foreach ($_items as $keyitem_cm => $value_item) 
            {
                if($value_item != null)
                {
                    $item_bundle_info = Tbl_item::where("item_id",Request::input("cmline_item_id")[$keyitem_cm])->where("item_type_id",4)->first();
                    if($item_bundle_info)
                    {
                        $bundle = Tbl_item_bundle::where("bundle_bundle_id",Request::input("cmline_item_id")[$keyitem_cm])->get();
                        foreach ($bundle as $key_bundle_cm => $value_bundle_cm) 
                        {
                            $qty = UnitMeasurement::um_qty(Request::input("cmline_um")[$keyitem_cm]);
                            $bundle_qty = UnitMeasurement::um_qty($value_bundle_cm->bundle_um_id);
                            $_bundle[$key_bundle_cm]['product_id'] = $value_bundle_cm->bundle_item_id;
                            $_bundle[$key_bundle_cm]['quantity'] = (Request::input('cmline_qty')[$keyitem_cm] * $qty) * ($value_bundle_cm->bundle_qty * $bundle_qty);

                            array_push($item_returns, $_bundle[$key_bundle_cm]);
                        }
                    }                 
                }
            }
            if(count($item_returns) > 0)
            {
                foreach ($item_returns as $key_items_cm => $value_items_cm) 
                {
                     $i = null;
                     foreach ($_items as $keyitemline_cm => $valueitemline)
                     {
                        $type = Tbl_item::where("item_id",Request::input("cmline_item_id")[$keyitemline_cm])->pluck("item_type_id");
                        if($type == 4)
                        {
                            if(Request::input("cmline_item_id")[$keyitemline_cm] == $value_items_cm['product_id'])
                            {
                                $i = "true";
                            }                    
                        }
                     }
                    if($i != null)
                    {
                        unset($item_returns[$key_items_cm]);
                    }           
                }            
            }
            // <-- end bundle            
        }

        if($ctr_items != 0)
        {
            CreditMemo::updateCM($cm_id, $customer_info, $item_info);
            
            if(count($item_returns) > 0)
            {
                $transaction_id = $cm_id;
                $transaction_type = "credit_memo";
                $json = Warehouse::inventory_update_returns($transaction_id, $transaction_type, $item_returns, $return = 'array');
            }

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
        $data["pis"] = Purchasing_inventory_system::check();

        $data["_cm"] = Tbl_credit_memo::manual_cm()->customer()->orderBy("tbl_credit_memo.cm_id","DESC")->where("tbl_customer.shop_id", $this->getShopId())->get();

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
