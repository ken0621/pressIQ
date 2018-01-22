<?php
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Globals\Invoice;
use App\Globals\Accounting;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Warehouse;
use App\Globals\Billing;
use App\Globals\Pdf_global;
use App\Globals\Utilities;
use App\Globals\Purchasing_inventory_system;
use App\Globals\TransactionPurchaseOrder;
use App\Globals\TransactionPurchaseRequisition;
use App\Globals\AccountingTransaction;
use App\Globals\TransactionSalesOrder;
use App\Globals\TransactionDebitMemo;

use App\Globals\Vendor;
use App\Globals\AuditTrail;
use App\Globals\Purchase_Order;
use App\Globals\ItemSerial;
use App\Models\Tbl_terms;
use App\Models\Tbl_purchase_order_line;

use Carbon\Carbon;
use Session;
use Redirect;
use PDF;


class TransactionPurchaseOrderController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Purchase Order';
        return view('member.accounting_transaction.vendor.purchase_order.purchase_order_list', $data);

    }
    public function getLoadPurchaseOrder(Request $request)
    {
        $data['_purchase_order'] = TransactionPurchaseOrder::get($this->user_info->shop_id, 10, $request->search_keyword, $request->tab_type);
        //dd($data['_purchase_order']);
        return view('member.accounting_transaction.vendor.purchase_order.purchase_order_table', $data);
    }
    public function getAddItem($po_id)
    {
        $po_data = Tbl_purchase_order_line::um()->where("poline_po_id",$po_id)->get();
        
        foreach ($po_data as $key => $value) 
        {
            Session::push('po_item',collect($value)->toArray());
        }
        $data["ctr_item"] = count(Session::get("po_item"));

        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["serial"] = ItemSerial::check_setting();

        return view('member.accounting_transaction.vendor.purchase_order.po_load_item_session',$data);
    }
    public function getPrint(Request $request)
    {
        $po_id = $request->id;

        $data["po"] = TransactionPurchaseOrder::info($this->user_info->shop_id, $po_id);
        $data["_poline"]       = TransactionPurchaseOrder::info_item($po_id);
        //dd($data);
        foreach($data["_poline"] as $key => $value) 
        {
            $qty = UnitMeasurement::um_qty($value->poline_um);

            $total_qty = $value->poline_orig_qty * $qty;
            $data["_poline"][$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->poline_um);
        }

        $pdf = view("member.accounting_transaction.vendor.purchase_order.purchase_order_pdf",$data);
        return Pdf_global::show_pdf($pdf);
    }
    public function getCreate(Request $request)
    {
        $shop_id            = $this->user_info->shop_id;
        $data["page"]       = "Create Purchase order";
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data["_terms"]     = Tbl_terms::where("archived", 0)->where("terms_shop_id", $shop_id)->get();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['transaction_refnum'] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'purchase_order');
        $data['action']     = "/member/transaction/purchase_order/create-purchase-order";
        $data['count_transaction'] = TransactionDebitMemo::countTransaction($shop_id);
        $data["vendor_id"]       = $request->vendor_id;
        $data["terms_id"]       = $request->vendor_terms;
        $po_id = $request->id;

        if($po_id)
        {
            $data["po"]            = TransactionPurchaseOrder::info($this->user_info->shop_id, $po_id);
            $data["_poline"]       = TransactionPurchaseOrder::info_item($po_id);
            $data["action"]        = "/member/transaction/purchase_order/update-purchase-order";
        }
        
        return view('member.accounting_transaction.vendor.purchase_order.purchase_order', $data);
    }

    public function postCreatePurchaseOrder(Request $request)
    {
        $btn_action  = $request->button_action;

        $insert['transaction_refnumber'] = $request->transaction_refnumber;
        $insert['vendor_id']             = $request->vendor_id;
        $insert['vendor_address']        = $request->vendor_address;
        $insert['vendor_email']          = $request->vendor_email;
        $insert['vendor_terms']          = $request->vendor_terms;
        $insert['transaction_date']      = $request->transaction_date;
        $insert['transaction_duedate']   = $request->transaction_duedate;
        $insert['vendor_message']        = $request->vendor_message;
        $insert['vendor_memo']           = $request->vendor_memo;
        $insert['vendor_ewt']            = $request->vendor_ewt;
        $insert['vendor_terms']          = $request->vendor_terms;
        $insert['vendor_discount']       = $request->vendor_discount;
        $insert['vendor_discounttype']   = $request->vendor_discounttype;
        $insert['vendor_tax']            = $request->vendor_tax;
        $insert['vendor_subtotal']       = $request->vendor_subtotal;
        $insert['vendor_total']          = $request->vendor_total;

        //die(var_dump($insert));
        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id']          = $value;
                $insert_item[$key]['item_servicedate'] = $request->item_servicedate[$key];
                $insert_item[$key]['item_description'] = $request->item_description[$key];
                $insert_item[$key]['item_um']          = $request->item_um[$key];
                $insert_item[$key]['item_qty']         = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']        = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_discount']    = str_replace(',', '', $request->item_discount[$key]);
                $insert_item[$key]['item_remark']      = $request->item_remark[$key];
                $insert_item[$key]['item_amount']      = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_taxable']     = $request->item_taxable[$key];
            }
        }
        //die(var_dump($insert_item));

        $validate = TransactionPurchaseOrder::postInsert($this->user_info->shop_id, $insert, $insert_item);

        $return = null;
        if(is_numeric($validate))
        {
            $return['status'] = 'success';
            $return['status_message'] = 'Success creating purchase order.';
            $return['call_function'] = 'success_purchase_order';
            $return['status_redirect'] = AccountingTransaction::get_redirect('purchase_order', $validate ,$btn_action);
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;
        }
        return json_encode($return);
    }

    public function postUpdatePurchaseOrder(Request $request)
    {
        $po_id  = $request->po_id;
        $btn_action  = $request->button_action;

        $insert['transaction_refnumber'] = $request->transaction_refnumber;
        $insert['vendor_id']             = $request->vendor_id;
        $insert['vendor_address']        = $request->vendor_address;
        $insert['vendor_email']          = $request->vendor_email;
        $insert['vendor_terms']          = $request->vendor_terms;
        $insert['transaction_date']      = $request->transaction_date;
        $insert['transaction_duedate']   = $request->transaction_duedate;
        $insert['vendor_message']        = $request->vendor_message;
        $insert['vendor_memo']           = $request->vendor_memo;
        $insert['vendor_ewt']            = $request->vendor_ewt;
        $insert['vendor_terms']          = $request->vendor_terms;
        $insert['vendor_discount']       = $request->vendor_discount;
        $insert['vendor_discounttype']   = $request->vendor_discounttype;
        $insert['vendor_tax']            = $request->vendor_tax;
        $insert['vendor_subtotal']       = $request->vendor_subtotal;
        $insert['vendor_total']          = $request->vendor_total;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id']          = $value;
                $insert_item[$key]['item_servicedate'] = $request->item_servicedate[$key];
                $insert_item[$key]['item_description'] = $request->item_description[$key];
                $insert_item[$key]['item_um']          = $request->item_um[$key];
                $insert_item[$key]['item_qty']         = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']        = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_discount']    = str_replace(',', '', $request->item_discount[$key]);
                $insert_item[$key]['item_remark']      = $request->item_remark[$key];
                $insert_item[$key]['item_amount']      = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_taxable']     = $request->item_taxable[$key];
            }
        }
       
        $validate = TransactionPurchaseOrder::postUpdate($po_id, $this->user_info->shop_id, $insert, $insert_item);

        $return = null;
        if(is_numeric($validate))
        {
            $return['status'] = 'success';
            $return['status_message'] = 'Success creating purchase order.';
            $return['call_function'] = 'success_purchase_order';
            $return['status_redirect'] = AccountingTransaction::get_redirect('purchase_order', $validate ,$btn_action);
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;
        }
        return json_encode($return);
    }

    public function getLoadTransaction(Request $request)
    {
        $data['_so'] = TransactionSalesOrder::getAllOpenSO($this->user_info->shop_id);
        $data['_pr'] = TransactionPurchaseRequisition::getAllOpenPR($this->user_info->shop_id);
        
       
        return view('member.accounting_transaction.vendor.purchase_order.load_transaction', $data);
    }
}
