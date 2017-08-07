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
use App\Globals\Cart;
use App\Globals\Item_code;

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
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_wallet_log;

use Excel;
use DB;
use Request;
use Input;
use File;
use Response;
use Carbon\Carbon;
use Session;
use Redirect;
use PDF;
use DB;
class ProductOrderController extends Member
{
    public function index()
    {
        $data["page"]               = "Customer Invoice";
        $data["_customer"]          = Tbl_customer::where("tbl_customer.archived", 0)->get();
        $data["_payment_method"]    = Tbl_online_pymnt_method::get();
        $data['_product']           = Ecom_Product::getProductList($this->user_info->shop_id, 0, 1);
        // dd($data);
        $data['_um']                = UnitMeasurement::load_um_multi();
        $data["action"]             = "/member/ecommerce/product_order/create_order/create_invoice";


        $data['view_invoice']       = Ec_order::get_settings();
        $id = Request::input('id');
        if($id)
        {
            $data["inv"]            = Tbl_ec_order::where("ec_order_id", $id)->first();
            $data["_invline"]       = Tbl_ec_order_item::where("ec_order_id", $id)->get();
            $data["action"]         = "/member/ecommerce/product_order/create_order/update_invoice";

            $mobile = DB::table("tbl_customer_other_info")->where("customer_id", $data["inv"]->customer_id)->first();
            $data["inv"]->customer_mobile = $mobile->customer_mobile or '';

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

            /* Payment Method Reference */
            foreach ($data["_payment_method"] as $key => $value) 
            {
                if ($data["inv"]->payment_method_id == $value->method_id) 
                {
                    $method_id = $value->method_id;
                    $shop_id = $this->user_info->shop_id;
                    $method_information = Cart::get_method_information($shop_id, $method_id);

                    if ( isset($method_id) && isset($method_information) )
                    {
                        switch ($method_information->link_reference_name)
                        {
                            // case 'paypal2': dd("UNDER DEVELOPMENT"); break;
                            // case 'paymaya': Cart::submit_using_paymaya($data, $shop_id, $method_information, $from); break;
                            // case 'paynamics': dd("UNDER DEVELOPMENT"); break;
                            // case 'dragonpay': return Cart::submit_using_dragonpay($data, $shop_id, $method_information, $from); break;
                            case 'ipay88': 
                                $ipay88 = DB::table("tbl_ipay88_logs")->where("order_id", $id)->first();

                                $data["log_name"] = "Ipay88 Reference Number";
                                $data["log_reference"] = isset($ipay88->log_trans_id) ? $ipay88->log_trans_id : 'Not found';
                            break;
                            // case 'other': return Cart::submit_using_proof_of_payment($shop_id, $method_information);  break;
                            // case 'e_wallet': return Cart::submit_using_ewallet($data, $shop_id); break;
                            // case 'cashondelivery': return Cart::submit_using_cash_on_delivery($shop_id, $method_information); break;
                            // default: dd("UNDER DEVELOPMENT"); break;
                        }
                    }
                }
            }
        }
       
        return view('member.product_order.product_create_order', $data);
    }
    public function order_invoice()
    {
        $order_id = Request::input("order_id");
        $data["page"] = "Invoice";
        $data["shop_info"] = $this->user_info;
        $data["order"] = Tbl_ec_order::where("tbl_ec_order.ec_order_id", $order_id)->customer()->customer_address()->where("purpose","billing")->first();

        $data["shop_theme"] = "intogadgets";
        if ($data["order"]->payment_status == 1) 
        {
            $data["_item"] = Tbl_ec_order_item::where("tbl_ec_order_item.ec_order_id", $order_id)->groupBy("tbl_ec_order_item.item_id")->item()->get();

            $data["order"]->subtotal = $data["order"]->subtotal - Cart::get_coupon_discount($data["order"]->coupon_id, $data["order"]->subtotal); 
            $data["coupon_discount"] = Cart::get_coupon_discount($data["order"]->coupon_id, $data["order"]->subtotal);
            $data['order']->vat     = $data["order"]->subtotal / 1.12 * 0.12;
            $data['order']->vatable = $data['order']->subtotal - $data['order']->vat;

            if($data["order"]->billing_address == ', , , ')
            {
                $data["order"]->billing_address = $data["order"]->customer_street.", ".$data["order"]->customer_zipcode.", ".$data["order"]->customer_city.", ".$data["order"]->customer_state;
            }
            
            return view("member.product_order.account_invoice", $data);
        }
        else
        {
            return Redirect::back();
        }

    }
    public function invoice_list()
    {
        

        $data["ec_order_pending"]    = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Pending")
                                        ->orderBy("ec_order_id", "DESC");
        $data["ec_order_failed"]     = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Failed")
                                        ->orderBy("ec_order_id", "DESC");
        $data["ec_order_processing"] = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Processing")
                                        ->orderBy("ec_order_id", "DESC");
        $data["ec_order_shipped"]    = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Shipped")
                                        ->orderBy("ec_order_id", "DESC");
        $data["ec_order_completed"]  = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Completed")
                                        ->orderBy("ec_order_id", "DESC");
        $data["ec_order_on_hold"]    = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","On-hold")
                                        ->orderBy("ec_order_id", "DESC");
        $data["ec_order_cancelled"]  = Tbl_ec_order::customer()->where("shop_id",$this->user_info->shop_id)->where("order_status","Cancelled")
                                        ->orderBy("ec_order_id", "DESC");
        $filtered_by                 = Request::input("type_chosen");                                 
        foreach($data as $key => $order)
        {
            if($filtered_by != "All" && $filtered_by != "")
            {
                $data[$key] = $data[$key]->where("payment_method_id",$filtered_by);
            }

            $data[$key] = $data[$key]->paginate(10);
        }   

        /* PUT THE DATA HERE IF IT IS NOT FROM EC_ORDER TABLE */
        $data["_filter"]             = Tbl_online_pymnt_method::where("method_shop_id",$this->user_info->shop_id)->get();

        $data['filtera']['All'] = 'All';
        $data['filtera']['Pending'] = 'Pending';
        $data['filtera']['Failed'] = 'Failed';
        $data['filtera']['Processing'] = 'Processing';
        $data['filtera']['Shipped'] = 'Shipped';
        $data['filtera']['Completed'] = 'Completed';
        $data['filtera']['On-hold'] = 'On-hold';
        $data['filtera']['Cancelled'] = 'Cancelled';

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

        $data["tracking_no"] = Request::input("tracking_no");

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

                Tbl_ec_order::where("ec_order_id",$data["ec_order_id"])->update(["manual_inv_number" => Request::input("manual_inv_number")]);
                
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
    public function update_manual($order_id)
    {
        $update["manual"] = 1;
        DB::table("tbl_ec_order")->where("ec_order_id", $order_id)->update($update);
    }
    public function paymaya_verify()
    {
        $data = [];

        return view('member.product_order.verfiy.paymaya', $data);
    }
    public function paymaya_verify_id($page, $search ='')
    {
        $data = [];
        if(is_numeric($search))
        {
            $data['order'] = Tbl_ec_order::where('ec_order_id', $search)->customer()->get();
        }
        else
        {
             $data['order'] = Tbl_ec_order::join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_ec_order.customer_id')->where(DB::raw("CONCAT(tbl_customer.first_name, ' ', tbl_customer.middle_name, ' ', tbl_customer.last_name)"), 'LIKE', "%".$search."%")->get();
        }

        return view('member.product_order.verfiy.search', $data);
    }
    public function paymaya_verify_id_order($page, $oder_id ='')
    {
        $data = [];
        $data['order'] = Tbl_ec_order::where('ec_order_id', $oder_id)
        ->leftjoin('tbl_paymaya_logs', 'tbl_paymaya_logs.order_id','=',  'tbl_ec_order.ec_order_id')
        ->leftjoin('tbl_online_pymnt_method', 'tbl_online_pymnt_method.method_id', '=', 'tbl_ec_order.payment_method_id')
        ->leftjoin('tbl_ec_order_slot', 'tbl_ec_order_slot.order_slot_ec_order_id', '=', 'tbl_ec_order.ec_order_id')
        ->leftjoin('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_ec_order_slot.order_slot_id_c')
        ->customer()->first();

        $data['slots'] = Tbl_mlm_slot::get()->keyBy('slot_id');
        return view('member.product_order.verfiy.order', $data);
    }
    public function paymaya_verify_id_order_update_slot()
    {
        $order_slot_id = Request::input('order_slot_id');
        $referrer = Request::input('referrer');
        $ec_order_id = Request::input('ec_order_id');
        $order = Tbl_ec_order::where('ec_order_id', $ec_order_id)->first();
        if($order)
        {
            if($order_slot_id)
            {
                $tbl_ec_order_slot = DB::table('tbl_ec_order_slot')->where('order_slot_id', $order_slot_id)->first();
                if($tbl_ec_order_slot)
                {
                    Item_code::ec_order_slot($order->ec_order_id);
                    $data['status'] = 'success';
                    $data['message'] = 'Slot Created';
                    
                    /* Insert Logs by Edward */
                    $this->update_manual($order->ec_order_id);
                    
                    return json_encode($data);
                }
                else
                {
                    $data['status'] = 'error';
                    $data['message'] = 'Invalid, please reload the page';
                    return json_encode($data);
                }
            }
            else
            {
                $count = DB::table('tbl_ec_order_slot')->where('order_slot_ec_order_id', $ec_order_id)->count();
                if($count == 0)
                {
                    $insert['order_slot_ec_order_id'] = $order->ec_order_id;
                    $insert['order_slot_customer_id'] = $order->customer_id;
                    // $insert['order_slot_sponsor'] = 
                    if($referrer)
                    {
                        $check_sponsor = Tbl_mlm_slot::where('slot_nick_name', $referrer)->where('slot_defaul', 1)->first();
                        if($check_sponsor)
                        {
                            $insert['order_slot_sponsor'] = $check_sponsor->slot_id;
                        }
                        else
                        {
                            $check_sponsor = Tbl_mlm_slot::where('slot_no', $referrer)->first();
                            if($check_sponsor)
                            {
                                $insert['order_slot_sponsor'] = $check_sponsor->slot_id;
                            }
                            else{ $data['status'] = 'error'; $data['message'] = 'Invalid Referrer'; return json_encode($data); }
                        }
                    }
                    DB::table('tbl_ec_order_slot')->insert($insert);
                    Item_code::ec_order_slot($order->ec_order_id);
                    
                    /* Insert Logs by Edward */
                    $this->update_manual($order->ec_order_id);
                    
                    $data['status'] = 'success'; $data['message'] = 'Slot Created'; return json_encode($data);
                }
                else
                {
                    $data['status'] = 'error'; $data['message'] = 'Already have a slot'; return json_encode($data);
                }
            }
        }
        else
        {
            $data['status'] ='error';
            $data['message'] = 'Invalid order please refresh the page';
            return json_encode($data);
        }
    }
    public  function paymaya_verify_id_order_update_slot_payment()
    {
        $update['payment_status'] = 1;
        $update['order_status'] = 'Processing';

        $ec_order_id = Request::input('ec_order_id');
        $order = Tbl_ec_order::where('ec_order_id', $ec_order_id)->first();
        if($order)
        {
            $order = Tbl_ec_order::where('ec_order_id', $ec_order_id)->update($update);
            return $this->paymaya_verify_id_order_update_slot();  
        }
        else
        {
            $data['status'] ='error';
            $data['message'] = 'Invalid order please refresh the page';
            return json_encode($data);
        }
    }
    public function report_e_commerce()
    {
        $this->set_invoice_number();
        $to = Request::input('to');
        $from = Request::input('from');
        $filter = Request::input('filter');

        $c_to = Carbon::parse($to);
        $c_from = Carbon::parse($from)->endOfDay();

        $data['order'] = Tbl_ec_order::where('tbl_ec_order.created_date', '>=', $c_from)
                    ->where('tbl_ec_order.created_date', '<=', $c_to);
        if($filter != 'All')
        {
            $data['order'] = $data['order']->where('order_status', $filter);
        }            
                    // customer
        $data['order'] = $data['order']->leftjoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_ec_order.customer_id')
                    ->leftjoin('tbl_customer_address', 'tbl_customer_address.customer_id', '=', 'tbl_customer.customer_id')
                    ->where('purpose', 'shipping')
                    ->orWhereNull('purpose', null)
                    // slot
                    ->leftjoin('tbl_ec_order_slot', 'tbl_ec_order_slot.order_slot_ec_order_id', '=', 'tbl_ec_order.ec_order_id')
                    ->leftjoin('tbl_mlm_slot as slot', 'slot.slot_id', '=', 'tbl_ec_order_slot.order_slot_id_c')
                    ->leftjoin('tbl_mlm_slot as sponsor', 'sponsor.slot_id', '=', 'slot.slot_sponsor')
                    ->leftjoin('tbl_paymaya_logs', 'tbl_paymaya_logs.order_id','=', 'tbl_ec_order.ec_order_id' )
                    // item
                    ->join('tbl_ec_order_item', 'tbl_ec_order_item.ec_order_id', '=', 'tbl_ec_order.ec_order_id')
                    ->join('tbl_ec_variant', 'tbl_ec_variant.evariant_id', '=', 'tbl_ec_order_item.item_id')
                    ->join('tbl_item', 'tbl_item.item_id', '=', 'tbl_ec_variant.evariant_item_id')
                    ->join('tbl_category', 'tbl_category.type_id', '=', 'item_category_id')
                    ->where('price','>', 0)
                    ->orWhereNull('price', null)
                    // payment metho
                    ->leftjoin('tbl_online_pymnt_method', 'tbl_online_pymnt_method.method_id', '=', 'tbl_ec_order.payment_method_id')

                    // get
                    ->select(
                            'tbl_customer_address.*',
                            'tbl_ec_order.*',
                            'tbl_ec_order_slot.*',
                            'slot.*', 
                            'sponsor.slot_no as sponsor_slot_no', 
                            'tbl_paymaya_logs.*',
                            'tbl_online_pymnt_method.*',
                            'tbl_ec_order_item.*',
                            'tbl_ec_variant.*',
                            'tbl_item.*',
                            'tbl_category.*',
                            DB::raw("CONCAT(tbl_customer_address.customer_state, ' ', tbl_customer_address.customer_city, ' ', tbl_customer_address.customer_zipcode, ' ', tbl_customer_address.customer_street) as address"),
                            DB::raw("CONCAT(tbl_customer.first_name, ' ', tbl_customer.middle_name, ' ', tbl_customer.last_name) as name"),
                            'tbl_customer.*'
                            )
                    
                    ->get();
        foreach($data['order'] as $key => $value)
        {
            $data['order'][$key]->wall_sum_binary = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', $value->order_slot_id_c)->where('wallet_log_plan', 'BINARY')->sum('wallet_log_amount'); 
            $data['order'][$key]->wall_sum_direct = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', $value->order_slot_id_c)->where('wallet_log_plan', 'DIRECT')->sum('wallet_log_amount');
            $data['order'][$key]->wall_sum = $data['order'][$key]->wall_sum_binary + $data['order'][$key]->wall_sum_direct;
            
        }            
        $data['headers']['ec_order_id'] = 'Order ID'; 
        $data['headers']['order_status'] = 'Order Status';
        $data['headers']['invoice_number'] = 'Invoice Number';
        $data['headers']['created_date'] = 'Document Date';
        $data['headers']['created_date'] = 'Due Date';
        $data['headers']['address'] = 'Ship To';
        $data['headers']['customer_state'] = 'Region';
        $data['headers']['type_name'] = 'Category';
        $data['headers']['item_sku'] = 'Item Code/Sku';
        $data['headers']['item_name'] = 'Model';
        $data['headers']['price'] = 'Price';
        $data['headers']['quantity'] = 'Quantity';
        $data['headers']['checkout_id'] = 'Checkout Id';
        $data['headers']['method_name'] = 'Payment Method';
        $data['headers']['name'] = 'Customer Name';
        $data['headers']['mlm_username'] = 'Username';
        $data['headers']['first_name'] = 'First Name';
        $data['headers']['middle_name'] = 'Middle Name';
        $data['headers']['last_name'] = 'Last Name';
        $data['headers']['b_day'] = 'Date of Birth';
        $data['headers']['tin_number'] = 'TIN';
        $data['headers']['email'] = 'Email';
        $data['headers']['slot_no'] = 'Slot #';
        $data['headers']['slot_eon'] = 'Eon Account Name';
        $data['headers']['slot_eon_account_no'] = 'Eon Account Number';
        $data['headers']['slot_eon_card_no'] = 'Eon Card Number';
        $data['headers']['wall_sum_binary'] = 'Wallet - Binary';
        $data['headers']['wall_sum_direct'] = 'Wallet - Direct';
        $data['headers']['wall_sum'] = 'Total';
        
        Excel::create('New file', function($excel) use($data) {

            $excel->sheet('New sheet', function($sheet) use($data) {

                $sheet->loadView('member.product_order.report.all', $data);

            });

        })->export('xls');            
                  
    }
    public function set_invoice_number()
    {
        $order = DB::table("tbl_ec_order")->where("payment_status", 1)->where("archived", 0)->where("invoice_number", NULL)->get();
        foreach ($order as $key => $value) 
        {
            $last = DB::table("tbl_ec_order")->where("payment_status", 1)->where("archived", 0)->max("invoice_number");
            if ($last) 
            {
                $update["invoice_number"] = $last + 1;
                DB::table('tbl_ec_order')->where("ec_order_id", $value->ec_order_id)->update($update);            
            }
            else
            {
                $update["invoice_number"] = 11000000;
                DB::table('tbl_ec_order')->where("ec_order_id", $value->ec_order_id)->update($update);
            }
        }
    }
}