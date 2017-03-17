<?php
namespace App\Http\Controllers\Member;

use Request;
use App\Http\Controllers\Controller;
use App\Globals\Invoice;
use App\Globals\Accounting;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Warehouse;
use App\Globals\Pdf_global;

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
use App\Globals\Purchase_Order;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_purchase_order_line;
use Carbon\Carbon;
use Session;
use Redirect;
use PDF;
class Vendor_PurchaseOrderController extends Member
{
    public function index()
    {
        $data["page"]       = "Purchase order";
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["action"]     = "/member/vendor/purchase_order/create_po";

        $id = Request::input('id');
        if($id)
        {
            $data["po"]            = Tbl_purchase_order::where("po_id", $id)->first();
            $data["_poline"]       = Tbl_purchase_order_line::um()->where("poline_po_id", $id)->get();
            $data["action"]         = "/member/vendor/purchase_order/update_po";
        }
        // dd($data);

        return view('member.purchase_order.purchase_order',$data);
    }
    public function po_list()
    {
        $data["_po"] = Tbl_purchase_order::vendor()->orderBy("po_id","DESC")->get();

        return view("member.purchase_order.purchase_order_list",$data);
    }
    public function invoice_list()
    {
        $data["_invoices"] = Tbl_customer_invoice::customer()->invoice_item()->orderBy("tbl_customer_invoice.inv_id","DESC")->get();
        return view("member.customer_invoice.customer_invoice_list",$data);
    }
    public function create_po()
    {
        // dd(Request::input());
        $vendor_info                        = [];
        $vendor_info['po_vendor_id']       = Request::input('po_vendor_id');;
        $vendor_info['po_vendor_email']    = Request::input('po_vendor_email');

        $po_info                            = [];
        $po_info['po_terms_id']             = Request::input('po_terms_id');
        $po_info['po_date']                 = datepicker_input(Request::input('po_date'));
        $po_info['po_due_date']             = datepicker_input(Request::input('po_due_date'));
        $po_info['billing_address']         = Request::input('po_billing_address');

        $po_other_info                      = [];
        $po_other_info['po_message']        = Request::input('po_message');
        $po_other_info['po_memo']           = Request::input('po_memo');

        $total_info                         = [];
        $total_info['po_subtotal_price']    = Request::input('subtotal_price');
        $total_info['ewt']                  = Request::input('ewt');
        $total_info['po_discount_value']    = Request::input('po_discount_type');
        $total_info['po_discount_type']     = Request::input('po_discount_value');
        $total_info['taxable']              = Request::input('taxable');
        $total_info['po_overall_price']     = Request::input('overall_price');

        $item_info                          = [];
        $_itemline                          = Request::input('poline_item_id');

        foreach($_itemline as $key => $item_line)
        {
            if($item_line)
            {
                $item_info[$key]['item_service_date']  = Request::input('poline_service_date')[$key];
                $item_info[$key]['item_id']            = Request::input('poline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('poline_description')[$key];
                $item_info[$key]['um']                 = Request::input('poline_um')[$key];
                $item_info[$key]['quantity']           = str_replace(',', "",Request::input('poline_qty')[$key]);
                $item_info[$key]['rate']               = str_replace(',', "", Request::input('poline_rate')[$key]);
                $item_info[$key]['discount']           = Request::input('poline_discount')[$key];
                $item_info[$key]['discount_remark']    = Request::input('poline_discount_remark')[$key];
                $item_info[$key]['taxable']            = Request::input('poline_taxable')[$key];
                $item_info[$key]['amount']             = str_replace(',', "", Request::input('poline_amount')[$key]);
            }
        }

        $po_id = Purchase_Order::postOrder($vendor_info, $po_info, $po_other_info, $item_info, $total_info);
        
        $json["status"]         = "success-po";
        $json["redirect_to"]    = "/member/vendor/purchase_order?id=".$po_id;

        return json_encode($json);

    }

    public function upate_po()
    {
        $po_id = Request::input("po_id");

       $vendor_info                        = [];
        $vendor_info['po_vendor_id']       = Request::input('po_vendor_id');;
        $vendor_info['po_vendor_email']    = Request::input('po_vendor_email');

        $po_info                            = [];
        $po_info['po_terms_id']             = Request::input('po_terms_id');
        $po_info['po_date']                 = datepicker_input(Request::input('po_date'));
        $po_info['po_due_date']             = datepicker_input(Request::input('po_due_date'));
        $po_info['billing_address']         = Request::input('po_billing_address');

        $po_other_info                      = [];
        $po_other_info['po_message']        = Request::input('po_message');
        $po_other_info['po_memo']           = Request::input('po_memo');

        $total_info                         = [];
        $total_info['po_subtotal_price']    = Request::input('subtotal_price');
        $total_info['ewt']                  = Request::input('ewt');
        $total_info['po_discount_value']    = Request::input('po_discount_type');
        $total_info['po_discount_type']     = Request::input('po_discount_value');
        $total_info['taxable']              = Request::input('taxable');
        $total_info['po_overall_price']     = Request::input('overall_price');

        $item_info                          = [];
        $_itemline                          = Request::input('poline_item_id');

        foreach($_itemline as $key => $item_line)
        {
            if($item_line)
            {               
                $item_info[$key]['item_service_date']  = Request::input('poline_service_date')[$key];
                $item_info[$key]['item_id']            = Request::input('poline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('poline_description')[$key];
                $item_info[$key]['um']                 = Request::input('poline_um')[$key];
                $item_info[$key]['quantity']           = str_replace(',', "",Request::input('poline_qty')[$key]);
                $item_info[$key]['rate']               = str_replace(',', "", Request::input('poline_rate')[$key]);
                $item_info[$key]['discount']           = Request::input('poline_discount')[$key];
                $item_info[$key]['discount_remark']    = Request::input('poline_discount_remark')[$key];
                $item_info[$key]['taxable']            = Request::input('poline_taxable')[$key];
                $item_info[$key]['amount']             = str_replace(',', "", Request::input('poline_amount')[$key]);

                $um_info = UnitMeasurement::um_info(Request::input("po_um")[$key]);
                $product_consume[$key]["quantity"] = isset($um_info->unit_qty) ? $um_info->unit_qty : 1 * $item_info[$key]['quantity'];
                $product_consume[$key]["product_id"] = Request::input('invline_item_id')[$key];
            }
        }

        $po_id = Purchase_Order::updatePurchase($po_id, $vendor_info, $po_info, $po_other_info, $item_info, $total_info);

        $json["status"]         = "success-po";
        $json["redirect_to"]    = "/member/vendor/purchase_order?id=".$po_id;

        return json_encode($json);

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