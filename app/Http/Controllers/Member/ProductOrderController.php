<?php
namespace App\Http\Controllers\Member;

use App\Globals\Ec_order;
use App\Globals\Invoice;
use App\Globals\Accounting;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Warehouse;
use App\Globals\Ecom_product;
use App\Globals\Pdf_global;

use App\Models\Tbl_customer;
use App\Models\Tbl_warehousea;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_manual_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_item;
use App\Models\Tbl_ec_variant;
use App\Models\Tbl_ec_order;
use App\Models\Tbl_ec_order_item;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_coupon_code;
use App\Models\Tbl_payment_method;

use Request;
use Carbon\Carbon;
use Session;
use Redirect;
use PDF;
class ProductOrderController extends Member
{
    public function index()
    {
        $data["page"]               = "Customer Invoice";
        $data["_customer"]          = Tbl_customer::where("archived", 0)->get();
        $data["_payment_method"]    = Tbl_payment_method::where("archived", 0)->where("shop_id",$this->user_info->shop_id)->get();
        $data['_product']           = Ecom_Product::getProductList();
        // dd($data);
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["action"]     = "/member/ecommerce/product_order/create_order/create_invoice";

        $id = Request::input('id');
        if($id)
        {
            $data["inv"]            = Tbl_ec_order::where("ec_order_id", $id)->first();
            $data["_invline"]       = Tbl_ec_order_item::where("ec_order_id", $id)->get();
            $data["action"]         = "/member/ecommerce/product_order/create_order/update_invoice";

            $sir                    = Tbl_ec_order::where("ec_order_id",$id)->first();
            if($sir)
            {
                if($sir->coupon_id != null)
                {
                    $data["coupon_code"]   = Tbl_coupon_code::where("coupon_code_id",$sir->coupon_id)->first()->coupon_code;
                    $data["coupon_amount"] = Tbl_coupon_code::where("coupon_code_id",$sir->coupon_id)->first()->coupon_code_amount;
                    $data["coupon_type"]   = Tbl_coupon_code::where("coupon_code_id",$sir->coupon_id)->first()->coupon_discounted;
                }
                else
                {
                    $data["coupon_code"]   = null;
                    $data["coupon_amount"] = null;
                    $data["coupon_type"]   = "fixed";
                }
 
                $data["ec_order_id"] = $sir->ec_order_id;
            }
        }

        return view('member.product_order.product_create_order', $data);
    }
    public function invoice_list()
    {
        $data["ec_order_unpaid"] = Tbl_ec_order::customer()->where("order_status","Pending")->get();
        $data["ec_order_unpaid"] = Tbl_ec_order::customer()->where("order_status","Unpaid")->get();
        $data["ec_order_unpaid"] = Tbl_ec_order::customer()->where("order_status","Unpaid")->get();
        $data["ec_order_unpaid"] = Tbl_ec_order::customer()->where("order_status","Unpaid")->get();
        $data["ec_order_paid"]   = Tbl_ec_order::customer()->where("order_status","Paid")->get();
        $data["ec_order_void"]   = Tbl_ec_order::customer()->where("order_status","Void")->get();
        return view("member.product_order.product_order",$data);
    }
    public function create_invoice()
    {
        $customer_info                      = [];
        $customer_info['customer_id']       = Request::input('inv_customer_id');;
        $customer_info['customer_email']    = Request::input('inv_customer_email');

        $invoice_info                       = [];
        $invoice_info['invoice_terms_id']   = Request::input('inv_terms_id');
        $invoice_info['invoice_date']       = Request::input('inv_date');
        $invoice_info['invoice_due']        = Request::input('inv_due_date');
        $invoice_info['billing_address']    = Request::input('inv_customer_billing_address');

        $invoice_other_info                 = [];
        $invoice_other_info['invoice_msg']  = Request::input('inv_message');
        $invoice_other_info['invoice_memo'] = Request::input('inv_memo');

        $total_info                         = [];
        $total_info['total_subtotal_price'] = Request::input('subtotal_price');
        $total_info['ewt']                  = Request::input('ewt');
        $total_info['total_discount_type']  = Request::input('inv_discount_type');
        $total_info['total_discount_value'] = Request::input('inv_discount_value');
        $total_info['taxable']              = Request::input('taxable');
        $total_info['total_overall_price']  = Request::input('overall_price');

        $item_info                          = [];
        $_itemline                          = Request::input('invline_item_id');

        // foreach($_itemline as $key => $item_line)
        // {
        //     if($item_line)
        //     {
        //         $item_info[$key]['item_service_date']  = Request::input('invline_service_date')[$key];
        //         $item_info[$key]['item_id']            = Request::input('invline_item_id')[$key];
        //         $item_info[$key]['item_description']   = Request::input('invline_description')[$key];
        //         $item_info[$key]['quantity']           = str_replace(',', "",Request::input('invline_qty')[$key]);
        //         $item_info[$key]['rate']               = str_replace(',', "", Request::input('invline_rate')[$key]);
        //         $item_info[$key]['discount']           = Request::input('invline_discount')[$key];
        //         $item_info[$key]['discount_remark']    = Request::input('invline_discount_remark')[$key];
        //         $item_info[$key]['taxable']            = Request::input('invline_taxable')[$key];
        //         $item_info[$key]['amount']             = str_replace(',', "", Request::input('invline_amount')[$key]);
        //         $item_info[$key]['um']                 = null;
        //     }
        // }
        // $inv_id = Invoice::postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);

        $returned_data = Ec_order::create_ec_order(Request::input());
        
        $json["status"]         = "success-invoice";
        $json["redirect_to"]    = "/member/ecommerce/product_order/create_order?id=".$returned_data;

        return json_encode($json);
    }
    public function submit_coupon()
    {
        $return["message"] = "";
        $code              = Request::input("sent_code");
        $invoice_id        = Request::input("invoice_id");

        $coupon            = Tbl_coupon_code::where("coupon_code",$code)->where("shop_id",$this->user_info->shop_id)->first();
        if($coupon)
        {
            if($coupon->used == 1)
            {
                if($invoice_id)
                {
                    $check_invoice = Tbl_ec_Order::where('ec_order_id',$invoice_id)->first();
                    if($check_invoice)
                    {
                        $check_coupon = Tbl_coupon_code::where("coupon_code_id",$check_invoice->coupon_id)->first();
                        if($check_coupon)
                        {
                            if($check_coupon->coupon_code == $code)
                            {
                                $return["amount"]  = $coupon->coupon_code_amount;

                                if($coupon->coupon_discounted == "fixed")
                                {
                                    $return["type"]  = "fixed";
                                }
                                else if($coupon->coupon_discounted == "percentage")
                                {
                                    $return["type"]  = "percent";
                                }

                                $return["message"] = "Success";
                            }
                            else
                            {
                                $return["message"] = "Coupon already used"; 
                            }
                        }
                        else
                        {
                            $return["message"] = "Coupon already used";        
                        }
                    }
                    else
                    {
                        $return["message"] = "Coupon already used"; 
                    }
                }
                else
                {
                    $return["message"] = "Coupon already used"; 
                }
            }
            else if($coupon->blocked == 1)
            {
                $return["message"] = "Coupon is blocked";
            }
            else
            {
                $return["amount"]  = $coupon->coupon_code_amount;

                if($coupon->coupon_discounted == "fixed")
                {
                    $return["type"]  = "fixed";
                }
                else if($coupon->coupon_discounted == "percentage")
                {
                    $return["type"]  = "percent";
                }

                $return["message"] = "Success";
            }
        }
        else
        {
            $return["message"] = "Coupon does not exist";
        }




        return json_encode($return);
    }
    public function update_invoice()
    {   
        $data["ec_order_id"]                = Request::input("ec_order_id");
        $data["order_status"]               = Request::input("order_status");

        Ec_order::update_ec_order($data);
        $return["status"]                   = "success-update-invoice";
        $return["redirect_to"]                = "/member/ecommerce/product_order/create_order?id=".$data["ec_order_id"];
        return json_encode($return);
    }

    public function invoice_view($invoice_id)
    {
        $data["invoice_id"] = $invoice_id;

        return view("member.customer_invoice.invoice_view",$data);
    }
    public function invoice_view_pdf($inv_id)
    {
        $data["invoice"] = Tbl_customer_invoice::customer()->where("inv_id",$inv_id)->first();

        $data["invoice_item"] = Tbl_customer_invoice_line::invoice_item()->um()->where("invline_inv_id",$inv_id)->get();
        foreach($data["invoice_item"] as $key => $value) 
        {
            $total_qty = $value->invline_qty * $value->unit_qty;
            $data["invoice_item"][$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->invline_um);
        }

          $pdf = view('member.customer_invoice.invoice_pdf', $data);
          return Pdf_global::show_pdf($pdf);
    }
}