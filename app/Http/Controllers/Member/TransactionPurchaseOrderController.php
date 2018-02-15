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
use App\Globals\RequisitionSlip;

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
        $data["serial"]     = ItemSerial::check_setting();

        return view('member.accounting_transaction.vendor.purchase_order.po_load_item_session',$data);
    }
    public function getPrint(Request $request)
    {
        $po_id = $request->id;

        $data["po"] = TransactionPurchaseOrder::info($this->user_info->shop_id, $po_id);
        $data["_poline"]       = TransactionPurchaseOrder::info_item($po_id);
        foreach($data["_poline"] as $key => $value) 
        {
            $qty = UnitMeasurement::um_qty($value->poline_um);

            $total_qty = $value->poline_orig_qty * $qty;
            $data["_poline"][$key]->qty = UnitMeasurement::um_view($total_qty,$value->item_measurement_id,$value->poline_um);
        }
        $footer = AccountingTransaction::get_refuser($this->user_info);

        $pdf = view("member.accounting_transaction.vendor.purchase_order.purchase_order_pdf",$data);
        return Pdf_global::show_pdf($pdf, null, $footer);
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
        $data['count_so'] = TransactionSalesOrder::getCountAllOpenSO($this->user_info->shop_id);

        $data['action']     = "/member/transaction/purchase_order/create-purchase-order";

        $data["vendor_id"]       = $request->vendor_id;
        $data["terms_id"]       = $request->vendor_terms;
        $po_id = $request->id;
        
        Session::forget("applied_transaction");
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
                $insert_item[$key]['item_taxable']     = isset($request->item_taxable[$key])? $request->item_taxable[$key] : 0;
                if($insert_item[$key]['item_taxable'] == '1')
                {
                    $insert_item[$key]['item_amount']   = (str_replace(',', '', $request->item_amount[$key] * .12)) + str_replace(',', '', $request->item_amount[$key]);
                }
                else
                {
                    $insert_item[$key]['item_amount']   = str_replace(',', '', $request->item_amount[$key]);
                }
                $insert_item[$key]['item_ref_name']    = $request->item_ref_name[$key];
                $insert_item[$key]['item_ref_id']      = $request->item_ref_id[$key];
            }
        }
        $validate = TransactionPurchaseOrder::postInsert($this->user_info->shop_id, $insert, $insert_item);
        TransactionPurchaseOrder::applied_transaction($this->user_info->shop_id, $validate);

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
                $insert_item[$key]['item_taxable']     = isset($request->item_taxable[$key])? $request->item_taxable[$key] : 0;
                
                if($insert_item[$key]['item_taxable'] == '1')
                {
                    $insert_item[$key]['item_amount']   = (str_replace(',', '', $request->item_amount[$key] * .12)) + str_replace(',', '', $request->item_amount[$key]);
                }
                else
                {
                    $insert_item[$key]['item_amount']   = str_replace(',', '', $request->item_amount[$key]);
                }
                $insert_item[$key]['item_ref_name']    = $request->item_ref_name[$key];
                $insert_item[$key]['item_ref_id']      = $request->item_ref_id[$key];
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
        
        $data['_applied'] = Session::get('applied_transaction');
        $data['action']   = '/member/transaction/purchase_order/apply-transaction';
        return view('member.accounting_transaction.vendor.purchase_order.load_transaction', $data);
    }
    public function postApplyTransaction(Request $request)
    {
        $apply_transaction = $request->_apply_transaction;
        Session::put("applied_transaction", $apply_transaction);

        $return['status'] = 'success';
        $return['call_function'] = 'success_apply_transaction';

        return json_encode($return);
    }
    public function getLoadAppliedTransaction(Request $request)
    {
        $applied_transaction = Session::get('applied_transaction');

        $return = null;
        $remarks = null;
        if(count($applied_transaction) > 0)
        {
            foreach ($applied_transaction as $key => $value) 
            {
                $get = TransactionSalesOrder::info_item($key);
                $info = TransactionSalesOrder::info($this->user_info->shop_id, $key);
                //die(var_dump($get));
                foreach ($get as $key_item => $value_item)
                {
                    if($value_item->item_type_id == 1 || $value_item->item_type_id == 4 || $value_item->item_type_id == 5)
                    {
                        $return[$key.'i'.$key_item]['so_id'] = $value_item->estline_est_id;
                        $return[$key.'i'.$key_item]['service_date'] = $value_item->estline_service_date;
                        $return[$key.'i'.$key_item]['item_id'] = $value_item->estline_item_id;
                        $return[$key.'i'.$key_item]['item_description'] = $value_item->estline_description;
                        $return[$key.'i'.$key_item]['multi_um_id'] = $value_item->multi_um_id;
                        $return[$key.'i'.$key_item]['item_um'] = $value_item->estline_um;
                        $return[$key.'i'.$key_item]['item_qty'] = $value_item->estline_qty;
                        $return[$key.'i'.$key_item]['item_rate'] = $value_item->estline_rate;
                        $return[$key.'i'.$key_item]['item_amount'] = $value_item->estline_amount;
                        $return[$key.'i'.$key_item]['item_discount'] = $value_item->estline_discount;
                        $return[$key.'i'.$key_item]['item_discount_type'] = $value_item->estline_discount_type;
                        $return[$key.'i'.$key_item]['item_remarks'] = $value_item->estline_discount_remark;
                        $return[$key.'i'.$key_item]['taxable'] = $value_item->taxable;

                    }
                }
                if($info)
                {
                    $remarks .= $info->transaction_refnum != "" ? $info->transaction_refnum.', ' : 'SO#'.$info->est_id.', ';
                }
            }
        }
        //die(var_dump($return));
        $data['_item']  = Item::get_all_category_item([1,4,5]);
        $data['_transactions'] = $return;
        $data['remarks'] = $remarks;
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["_vendor"] = Vendor::getAllVendor('active');

        return view('member.accounting_transaction.vendor.purchase_order.applied_transaction', $data);
    }
}
