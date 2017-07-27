<?php
namespace App\Http\Controllers\Member;

use App\Globals\Ec_order;
use App\Globals\Invoice;
use App\Globals\Accounting;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Warehouse;
use App\Globals\Ecom_Product;
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
use App\Models\Tbl_online_pymnt_method;

use Request;
use Input;
use File;
use Response;
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
        $data["_payment_method"]    = Tbl_online_pymnt_method::get();
        $data['_product']           = Ecom_Product::getProductList(null, [1,0]);
        // dd($data);
        $data['_um']                = UnitMeasurement::load_um_multi();
        $data["action"]             = "/member/ecommerce/product_order/create_order/create_invoice";

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
            // dd($data["_product"]);
        return view('member.product_order.product_create_order', $data);
    }
    public function invoice_list()
    {
        $data["ec_order_pending"]    = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Pending")->paginate(10);
        $data["ec_order_failed"]     = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Failed")->paginate(10);
        $data["ec_order_processing"] = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Processing")->paginate(10);
        $data["ec_order_shipped"]    = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Shipped")->paginate(10);
        $data["ec_order_completed"]  = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Completed")->paginate(10);
        $data["ec_order_on_hold"]    = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","On-hold")->paginate(10);
        $data["ec_order_cancelled"]  = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Cancelled")->paginate(10);
        return view("member.product_order.product_order",$data);
    }
    public function create_invoice()
    {
        $customer_info                      = [];
        $customer_info['customer_id']       = Request::input('inv_customer_id');
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

        $item_count                         = 0;

        foreach(Request::input("invline_item_id") as $request_item)
        {
            if($request_item != "")
            {
                $item_count++;
            }
        }

        if($item_count != 0)
        {
                $returned_data = Ec_order::create_ec_order(Request::input());
                if($returned_data["status"] == "error")
                {
                    $json["status"]            = "error";
                    $json["status_message"]    = $returned_data["status_message"];

                    return json_encode($json);
                }
                else
                {
                    $json["status"]         = "success-invoice";
                    $json["redirect_to"]    = "/member/ecommerce/product_order/create_order?id=".$returned_data;

                    return json_encode($json);
                }
        }
        else
        {   
            $json["status"]         = "error";
            $json["status_message"] = "No ordered item.";
            return json_encode($json);
        }
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
                    $check_invoice = Tbl_ec_order::where('ec_order_id',$invoice_id)->first();
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
        $data["ec_order_id"]    = Request::input("ec_order_id");
        $data["order_status"]   = Request::input("order_status");
        $data["payment_status"] = Request::input("payment_status");

        $response                           = Ec_order::update_ec_order($data);
        if(isset($response["status"]))
        {
            if($response["status"] == "error")
            {
                $return["status"]                   = "error";
                $return["status_message"]           = $response["status_message"];
                return json_encode($return);
            }
            else
            {
                $return["status"]                   = "success-update-invoice";
                $return["redirect_to"]              = "/member/ecommerce/product_order/create_order?id=".$data["ec_order_id"];
                return json_encode($return);
            }
        }
        else
        {
            $return["status"]                   = "success-update-invoice";
            $return["redirect_to"]              = "/member/ecommerce/product_order/create_order?id=".$data["ec_order_id"];
            return json_encode($return);
        }
    }

    public function submit_payment_upload()
    {
        $shop_id    = $this->user_info->shop_id;
        $shop_key   = $this->user_info->shop_key;
        $order_id   = Request::input('ec_order_id');

        /* SAVE THE IMAGE IN THE FOLDER */
        $file               = Input::file('file');

        if($file)
        {
            $extension          = $file->getClientOriginalExtension();
            //$filename         = $file->getClientOriginalName();
            $filename           = str_random(15).".".$extension;
            $destinationPath    = 'uploads/'.$shop_key."-".$shop_id.'/ecommerce-upload';

            if(!File::exists($destinationPath)) 
            {
                $create_result = File::makeDirectory(public_path($destinationPath), 0775, true, true);
            }

            $upload_success    = Input::file('file')->move($destinationPath, $filename);

            /* SAVE THE IMAGE PATH IN THE DATABASE */
            $image_path = $destinationPath."/".$filename;

            $update["payment_upload"] = "/" . $image_path;
            $image_id = Tbl_ec_order::where("ec_order_id", $order_id)->update($update);

            if( $upload_success) 
            {
               return Response::json('success', 200);
            } 
            else 
            {
               return Response::json('error', 400);
            }
        }
        else
        {
            return Response::json('success', 200);
        }

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