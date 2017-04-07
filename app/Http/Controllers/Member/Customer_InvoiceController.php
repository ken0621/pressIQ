<?php
namespace App\Http\Controllers\Member;

use App\Globals\Invoice;
use App\Globals\Accounting;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Warehouse;
use App\Globals\Pdf_global;
use App\Globals\CreditMemo;
use App\Globals\Transaction;
use App\Globals\Customer;

use App\Models\Tbl_customer;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_manual_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_unit_measurement_multi;
use App\Models\Tbl_item;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_user;

use Request;
use Carbon\Carbon;
use Session;
use Redirect;
use PDF;

class Customer_InvoiceController extends Member
{
    public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public function index()
    {
        $data["page"]       = "Customer Invoice";
        $data["_customer"]  = Customer::getAllCustomer();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["action"]     = "/member/customer/invoice/create";
        $data["new_inv_id"] = Transaction::get_last_number("tbl_customer_invoice","new_inv_id","inv_shop_id"); 
        $data["c_id"] = Request::input("customer_id");
        $id = Request::input('id');
        if($id)
        {
            $data["inv"]            = Tbl_customer_invoice::where("inv_id", $id)->first();
            
            $data["_invline"]       = Tbl_customer_invoice_line::um()->where("invline_inv_id", $id)->get();
            $data["action"]         = "/member/customer/invoice/update";

            // dd($data["inv"]);

            $sir = Tbl_manual_invoice::where("inv_id",$id)->first();
            if($sir)
            {
                $data["sir_id"] = $sir->sir_id;
                $data["action"] = "/member/customer/invoice/manual_invoice_update";
                $data['_item'] = Item::get_all_item_sir($sir->sir_id);
            }
        }

        return view('member.customer_invoice.customer_invoice', $data);
    }

    public function invoice_list()
    {
        $data["_invoices"] = Tbl_customer_invoice::manual_invoice()->customer()->orderBy("tbl_customer_invoice.inv_id","DESC")->where("inv_shop_id",$this->user_info->shop_id)->get();
        return view("member.customer_invoice.customer_invoice_list",$data);
    }
    public function create_invoice()
    {
        // dd(Request::input());
        $button_action = Request::input('button_action');

        $customer_info                      = [];
        $customer_info['customer_id']       = Request::input('inv_customer_id');;
        $customer_info['customer_email']    = Request::input('inv_customer_email');

        $invoice_info                       = [];
        $invoice_info['invoice_terms_id']   = Request::input('inv_terms_id');
        $invoice_info['new_inv_id']         = Request::input('new_invoice_id');
        $invoice_info['invoice_date']       = datepicker_input(Request::input('inv_date'));
        $invoice_info['invoice_due']        = datepicker_input(Request::input('inv_due_date'));
        $invoice_info['billing_address']    = Request::input('inv_customer_billing_address');

        $invoice_other_info                 = [];
        $invoice_other_info['invoice_msg']  = Request::input('inv_message');
        $invoice_other_info['invoice_memo'] = Request::input('inv_memo');

        $total_info                         = [];
        $total_info['ewt']                  = Request::input('ewt');
        $total_info['total_discount_type']  = Request::input('inv_discount_type');
        $total_info['total_discount_value'] = Request::input('inv_discount_value');
        $total_info['taxable']              = Request::input('taxable');

        $item_info                          = [];
        $_itemline                          = Request::input('invline_item_id');

        foreach($_itemline as $key => $item_line)
        {
            if($item_line)
            {
                $item_info[$key]['item_service_date']  = Request::input('invline_service_date')[$key];
                $item_info[$key]['item_id']            = Request::input('invline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('invline_description')[$key];
                $item_info[$key]['um']                 = Request::input('invline_um')[$key];
                $item_info[$key]['quantity']           = Request::input('invline_qty')[$key];
                $item_info[$key]['rate']               = convertToNumber(Request::input('invline_rate')[$key]);
                $item_info[$key]['discount']           = Request::input('invline_discount')[$key];
                $item_info[$key]['discount_remark']    = Request::input('invline_discount_remark')[$key];
                $item_info[$key]['amount']             = convertToNumber(Request::input('invline_amount')[$key]);
                $item_info[$key]['taxable']            = Request::input('invline_taxable')[$key];


                $um_qty = UnitMeasurement::um_qty(Request::input("invline_um")[$key]);
                $product_consume[$key]["quantity"] = $um_qty * $item_info[$key]['quantity'];
                $product_consume[$key]["product_id"] = Request::input('invline_item_id')[$key];
            }
        }
        //START if bundle inventory_consume arcy
        foreach ($_itemline as $keyitem => $value_item) 
        {
            $item_bundle_info = Tbl_item::where("item_id",Request::input("invline_item_id")[$keyitem])->where("item_type_id",4)->first();
            if($item_bundle_info)
            {
                $bundle = Tbl_item_bundle::where("bundle_bundle_id",Request::input("invline_item_id")[$keyitem])->get();
                foreach ($bundle as $key_bundle => $value_bundle) 
                {
                    $qty = UnitMeasurement::um_qty(Request::input("invline_um")[$keyitem]);
                    $bundle_qty = UnitMeasurement::um_qty($value_bundle->bundle_um_id);
                    $_bundle[$key_bundle]['product_id'] = $value_bundle->bundle_item_id;
                    $_bundle[$key_bundle]['quantity'] = (Request::input('invline_qty')[$keyitem] * $qty) * ($value_bundle->bundle_qty * $bundle_qty);

                    array_push($product_consume, $_bundle[$key_bundle]);
                }
            } 
        }
        foreach ($product_consume as $key_items => $value_items) 
        {
             $i = null;
             foreach ($_itemline as $keyitemline => $valueitemline)
             {
                $type = Tbl_item::where("item_id",Request::input("invline_item_id")[$keyitemline])->pluck("item_type_id");
                if($type == 4)
                {
                    if(Request::input("invline_item_id")[$keyitemline] == $value_items['product_id'])
                    {
                        $i = "true";
                    }                    
                }
             }
            if($i != null)
            {
                unset($product_consume[$key_items]);
            }           
        }
        //END if bundle inventory_consume arcy

        $inv = Transaction::check_number_existense("tbl_customer_invoice","new_inv_id","inv_shop_id",Request::input('new_invoice_id'));

        if($inv == 0 || Request::input("keep_val") == "keep")
        {
            $inv_id = Invoice::postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);
            
            $remarks            = "Invoice";
            $warehouse_id       = Tbl_warehouse::where("warehouse_shop_id",$this->user_info->shop_id)->where("main_warehouse",1)->pluck("warehouse_id");
            $transaction_type   = "invoice";
            $transaction_id     = $inv_id;
            $data               = Warehouse::inventory_consume($warehouse_id, $remarks, $product_consume, 0, '' ,  'array', $transaction_type, $transaction_id);                

            $json["status"]         = "success-invoice";
            if($button_action == "save-and-edit")
            {
                $json["redirect"]    = "/member/customer/invoice?id=".$inv_id;
            }
            elseif($button_action == "save-and-new")
            {
                $json["redirect"]   = '/member/customer/invoice';
            }
            Request::session()->flash('success', 'Invoice Successfully Created');
        }
        else
        {
            $json["inv_id"] = Request::input("new_invoice_id");            
            $json["status"] = "error-inv-no";
        }

        return json_encode($json);
    }
    public function error_inv_no($id)
    {
        $data["inv_id"] = $id;

        return view("member.customer_invoice.confirm_invoice_number",$data);
    }
    public function update_invoice()
    {
        $invoice_id     = Request::input("invoice_id");
        $button_action  = Request::input('button_action');

        $customer_info                      = [];
        $customer_info['customer_id']       = Request::input('inv_customer_id');;
        $customer_info['customer_email']    = Request::input('inv_customer_email');

        $invoice_info                       = [];
        $invoice_info['invoice_terms_id']   = Request::input('inv_terms_id');
        $invoice_info['invoice_date']       = datepicker_input(Request::input('inv_date'));
        $invoice_info['new_inv_id']         = Request::input('new_invoice_id');
        $invoice_info['invoice_due']        = datepicker_input(Request::input('inv_due_date'));
        $invoice_info['billing_address']    = Request::input('inv_customer_billing_address');

        $invoice_other_info                 = [];
        $invoice_other_info['invoice_msg']  = Request::input('inv_message');
        $invoice_other_info['invoice_memo'] = Request::input('inv_memo');

        $total_info                         = [];
        $total_info['ewt']                  = Request::input('ewt');
        $total_info['total_discount_type']  = Request::input('inv_discount_type');
        $total_info['total_discount_value'] = Request::input('inv_discount_value');
        $total_info['taxable']              = Request::input('taxable');

        $item_info                          = [];
        $_itemline                          = Request::input('invline_item_id');

        foreach($_itemline as $key => $item_line)
        {
            if($item_line)
            {               
                $item_info[$key]['item_service_date']  = Request::input('invline_service_date')[$key];
                $item_info[$key]['item_id']            = Request::input('invline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('invline_description')[$key];
                $item_info[$key]['um']                 = Request::input('invline_um')[$key];
                $item_info[$key]['quantity']           = Request::input('invline_qty')[$key];
                $item_info[$key]['rate']               = convertToNumber(Request::input('invline_rate')[$key]);
                $item_info[$key]['discount']           = Request::input('invline_discount')[$key];
                $item_info[$key]['discount_remark']    = Request::input('invline_discount_remark')[$key];
                $item_info[$key]['taxable']            = Request::input('invline_taxable')[$key];
                $item_info[$key]['amount']             = convertToNumber(Request::input('invline_amount')[$key]);

                $qty = UnitMeasurement::um_qty(Request::input("invline_um")[$key]);
                $product_consume[$key]["quantity"] = $qty * $item_info[$key]['quantity'];
                $product_consume[$key]["product_id"] = Request::input('invline_item_id')[$key];
            }
        }

         //START if bundle inventory_consume arcy
        foreach ($_itemline as $keyitem => $value_item) 
        {
            $item_bundle_info = Tbl_item::where("item_id",Request::input("invline_item_id")[$keyitem])->where("item_type_id",4)->first();
            if($item_bundle_info)
            {
                $bundle = Tbl_item_bundle::where("bundle_bundle_id",Request::input("invline_item_id")[$keyitem])->get();
                foreach ($bundle as $key_bundle => $value_bundle) 
                {
                    $qty = UnitMeasurement::um_qty(Request::input("invline_um")[$keyitem]);
                    $bundle_qty = UnitMeasurement::um_qty($value_bundle->bundle_um_id);
                    $_bundle[$key_bundle]['product_id'] = $value_bundle->bundle_item_id;
                    $_bundle[$key_bundle]['quantity'] = (Request::input('invline_qty')[$keyitem] * $qty) * ($value_bundle->bundle_qty * $bundle_qty);

                    array_push($product_consume, $_bundle[$key_bundle]);
                }
            } 
        }
        foreach ($product_consume as $key_items => $value_items) 
        {
             $i = null;
             foreach ($_itemline as $keyitemline => $valueitemline)
             {
                $type = Tbl_item::where("item_id",Request::input("invline_item_id")[$keyitemline])->pluck("item_type_id");
                if($type == 4)
                {
                    if(Request::input("invline_item_id")[$keyitemline] == $value_items['product_id'])
                    {
                        $i = "true";
                    }                    
                }
             }
            if($i != null)
            {
                unset($product_consume[$key_items]);
            }           
        }
        //END if bundle inventory_consume arcy

        Invoice::updateIsPaid($invoice_id);

        $inv = Transaction::check_number_existense("tbl_customer_invoice","new_inv_id","inv_shop_id",Request::input('new_invoice_id'));

        if($inv <= 1 || Request::input("keep_val") == "keep")
        {
            $inv_id = Invoice::updateInvoice($invoice_id, $customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);

            $transaction_id = $inv_id;
            $transaction_type = "invoice";
            $json = Warehouse::inventory_update($transaction_id, $transaction_type, $product_consume, $return = 'array');

            if($json["status"] == "success")
            {
                $json["status"]         = "success-invoice";
                $json["invoice_id"]     = $inv_id;
                $json["link"]           = "/member/customer/invoice_list";

                if($button_action == "save-and-new")
                {
                    $json["redirect"]   = '/member/customer/invoice';
                }
                Request::session()->flash('success', 'Invoice Successfully Updated');
            }
        }
        else
        {
            $json["inv_id"] = Request::input("new_invoice_id");            
            $json["status"] = "error-inv-no";
        }

        return json_encode($json);
    }

    public function  return_to_number($number = '0.00'){
    	$num = explode($number);
    	$return = '';
    	foreach($num as $n){
    		$return .= ''.$n;
    	}
    	return $return;
    }
    public function invoice_view($invoice_id)
    {
        $data["invoice_id"] = $invoice_id;
        $data["action_load"] = "/member/customer/customer_invoice_pdf";
        return view("member.customer_invoice.invoice_view",$data);
    }
    public function invoice_view_pdf($inv_id)
    {
        $data["invoice"] = Tbl_customer_invoice::customer()->where("inv_id",$inv_id)->first();

        $data["invoice_item"] = Tbl_customer_invoice_line::invoice_item()->where("invline_inv_id",$inv_id)->get();
        foreach($data["invoice_item"] as $key => $value) 
        {
          $um = Tbl_unit_measurement_multi::where("multi_id",$value->invline_um)->first();
            $qty = 1;
            if($um != null)
            {
                $qty = $um->unit_qty;
            }

            $total_qty = $value->invline_qty * $qty;
            $data["invoice_item"][$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->invline_um);
        }
          $pdf = view('member.customer_invoice.invoice_pdf', $data);
          return Pdf_global::show_pdf($pdf);
    }
}