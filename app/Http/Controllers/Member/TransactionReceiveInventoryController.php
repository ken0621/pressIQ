<?php
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tbl_terms;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_purchase_order;

use App\Globals\TransactionDebitMemo;
use App\Globals\TransactionPurchaseOrder;
use App\Globals\AccountingTransaction;
use App\Globals\TransactionReceiveInventory;
use App\Globals\Purchasing_inventory_system;
use App\Globals\Vendor;
use App\Globals\ItemSerial;
use App\Globals\AuditTrail;
use App\Globals\Accounting;
use App\Globals\Purchase_Order;
use App\Globals\Billing;
use App\Globals\Item;
use App\Globals\Warehouse;
use App\Globals\Warehouse2;
use App\Globals\Utilities;
use App\Globals\UnitMeasurement;
use App\Globals\Pdf_global;
use Carbon\Carbon;
use Session;
class TransactionReceiveInventoryController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Receive Inventory';
        return view('member.accounting_transaction.vendor.receive_inventory.receive_inventory_list', $data);
    }

    public function getLoadReceiveInventory(Request $request)
    {
        $data['_receive_inventory'] = TransactionReceiveInventory::get($this->user_info->shop_id, 10, $request->search_keyword);
        return view('member.accounting_transaction.vendor.receive_inventory.receive_inventory_table', $data);
    }
    public function getPrint(Request $request)
    {
        $ri_id = $request->id;
        $data["ri"] = TransactionReceiveInventory::info($this->user_info->shop_id,$ri_id);
        $data["_riline"] = TransactionReceiveInventory::info_item($ri_id);

        $footer = AccountingTransaction::get_refuser($this->user_info);
        $pdf = view("member.accounting_transaction.vendor.receive_inventory.receive_inventory_pdf",$data);
        return Pdf_global::show_pdf($pdf, null, $footer);
    }
    public function getCreate(Request $request)
    {
        $data['page'] = 'Create Receive Inventory';

        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data['_item']      = Item::get_all_category_item();
        $data['_account']   = Accounting::getAllAccount();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["_terms"]     = Tbl_terms::where("archived", 0)->where("terms_shop_id", Billing::getShopId())->get();
        $data["transaction_refnum"] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'received_inventory');

        $data["_po"] = Tbl_purchase_order::where("po_vendor_id",$request->vendor_id)->where("po_is_billed",0)->get();
        $data['action']     = '/member/transaction/receive_inventory/create-receive-inventory';
        
        $receive_id = $request->id;
        $data['term'] = $request->vendor_terms;

        Session::forget("applied_transaction");
        if($receive_id)
        {
            $data['ri'] = TransactionReceiveInventory::info($this->user_info->shop_id,$receive_id);
            $data['_riline']= TransactionReceiveInventory::info_item($receive_id);
            $data['action']     = '/member/transaction/receive_inventory/update-receive-inventory';
        }
        return view('member.accounting_transaction.vendor.receive_inventory.receive_inventory', $data);
    }
    public function postCreateReceiveInventory(Request $request)
    {
        $btn_action = $request->button_action;

        $insert['transaction_refnumber']    = $request->transaction_refnumber;
        $insert['vendor_id']                = $request->vendor_id;
        $insert['vendor_address']           = $request->vendor_address;
        $insert['vendor_email']             = $request->vendor_email;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['transaction_date']         = $request->transaction_date;
        $insert['transaction_duedate']      = $request->transaction_duedate;
        $insert['vendor_memo']              = $request->vendor_memo;
        $insert['vendor_total']             = $request->vendor_total;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id']          = $value;
                $insert_item[$key]['item_ref_name']    = $request->item_ref_name[$key];
                $insert_item[$key]['item_ref_id']      = $request->item_ref_id[$key];
                $insert_item[$key]['item_description'] = $request->item_description[$key];
                $insert_item[$key]['item_um']          = $request->item_um[$key];
                $insert_item[$key]['item_qty']         = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']        = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_amount']      = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_discount']    = 0;
            }
        }

        $return = null;
        $warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $validate = AccountingTransaction::inventory_validation('refill', $this->user_info->shop_id, $warehouse_id, $insert_item);
        if(!$validate)
        {
            $validate = TransactionReceiveInventory::postInsert($this->user_info->shop_id, $insert, $insert_item);
            if(Session::get('applied_transaction') > 0)
            {
                TransactionPurchaseOrder::checkPoQty($validate, Session::get('applied_transaction'));
            }
        }
        if(is_numeric($validate))
        {
            $return['status'] = 'success';
            $return['status_message'] = 'Success creating receive inventory.';
            $return['call_function'] = 'success_receive_inventory';
            $return['status_redirect'] = AccountingTransaction::get_redirect('receive_inventory', $validate ,$btn_action);
            Session::forget('applied_transaction');
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;
        }

        return json_encode($return);
    }

    public function postUpdateReceiveInventory(Request $request)
    {
        $btn_action = $request->button_action;
        $ri_id = $request->ri_id;

        $insert['transaction_refnumber']    = $request->transaction_refnumber;
        $insert['vendor_id']                = $request->vendor_id;
        $insert['vendor_address']           = $request->vendor_address;
        $insert['vendor_email']             = $request->vendor_email;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['transaction_date']         = $request->transaction_date;
        $insert['transaction_duedate']      = $request->transaction_duedate;
        $insert['vendor_memo']              = $request->vendor_memo;
        $insert['vendor_total']             = $request->vendor_total;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id']          = $value;
                $insert_item[$key]['item_ref_name']    = $request->item_ref_name[$key];
                $insert_item[$key]['item_ref_id']      = $request->item_ref_id[$key];
                $insert_item[$key]['item_description'] = $request->item_description[$key];
                $insert_item[$key]['item_um']          = $request->item_um[$key];
                $insert_item[$key]['item_qty']         = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']        = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_amount']      = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_discount']    = 0;
            }
        }


        $validate = TransactionReceiveInventory::postUpdate($ri_id, $this->user_info->shop_id, $insert, $insert_item);

        if(Session::get("applied_transaction") > 0)
        {
            TransactionPurchaseOrder::checkPoQty($validate, Session::get("applied_transaction"));
        }

        $return = null;
        $warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $validate = AccountingTransaction::inventory_validation('refill', $this->user_info->shop_id, $warehouse_id, $insert_item);
        if(!$validate)
        {
            $validate = TransactionReceiveInventory::postUpdate($ri_id, $this->user_info->shop_id, $insert, $insert_item);
        }
        
        if(is_numeric($validate))
        {
            $return['status'] = 'success';
            $return['status_message'] = 'Success updating receive inventory.';
            $return['call_function'] = 'success_receive_inventory';
            $return['status_redirect'] = AccountingTransaction::get_redirect('receive_inventory', $validate ,$btn_action);
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;
        }

        return json_encode($return);
    }

    public function getCountTransaction(Request $request)
    {
        $vendor_id = $request->vendor_id;
        return TransactionReceiveInventory::countTransaction($this->user_info->shop_id, $vendor_id);
    }
    public function getLoadTransaction(Request $request)
    {
        $data['_po'] = TransactionPurchaseOrder::getOpenPO($this->user_info->shop_id, $request->vendor);
        $data['_dm'] = TransactionDebitMemo::getOpenDM($this->user_info->shop_id, $request->vendor);
        $data['vendor'] = Vendor::getVendor($this->user_info->shop_id, $request->vendor);
        
        $data['_applied'] = Session::get("applied_transaction");
        $data['action'] = '/member/transaction/receive_inventory/apply-transaction';
        return view('member.accounting_transaction.vendor.receive_inventory.load_transaction', $data);
    }
    public function postApplyTransaction(Request $request)
    {
        $apply_transaction = $request->_apply_transaction;
        Session::put("applied_transaction", $apply_transaction);

        $return['status']        = "success";
        $return['call_function'] = "success_apply_transaction";

        return json_encode($return);

    }
    public function getLoadAppliedPoTransaction(Request $request)
    {
        $applied_transaction = Session::get('applied_transaction');

        if(count($applied_transaction) > 0)
        {
            foreach ($applied_transaction as $key => $value)
            {
                $_applied_poline = TransactionPurchaseOrder::info_item($key);
                $info = TransactionPurchaseOrder::info($this->user_info->shop_id,$key);

                $remarks = null;
                foreach ($_applied_poline as $poline_key => $poline_value) 
                {
                    $type = Item::get_item_type($poline_value->poline_item_id);
                    if($type == 1 || $type == 4 || $type == 5 )
                    {
                        $return[$key.'i'.$poline_key]['poline_po_id'] = $poline_value->poline_po_id;
                        $return[$key.'i'.$poline_key]['item_id'] = $poline_value->poline_item_id;
                        $return[$key.'i'.$poline_key]['item_description'] = $poline_value->poline_description;
                        $return[$key.'i'.$poline_key]['item_um'] = $poline_value->poline_um;
                        $return[$key.'i'.$poline_key]['item_qty'] = $poline_value->poline_qty;
                        $return[$key.'i'.$poline_key]['item_rate'] = $poline_value->poline_rate;
                        $return[$key.'i'.$poline_key]['item_amount'] = $poline_value->poline_amount;
                    }
                }    
                if($info)
                {
                    $remarks .= $info->transaction_refnum != "" ? $info->transaction_refnum.', ' : 'PO#'.$info->po_id.', ';
                }
            }
        }

        $data['_po']     = $return;
        $data['remarks'] = $remarks;
        $data['_um']     = UnitMeasurement::load_um_multi();
        $data['_item']   = Item::get_all_category_item();

        return view('member.accounting_transaction.vendor.purchase_order.applied_po_transaction', $data);
    }

}

    