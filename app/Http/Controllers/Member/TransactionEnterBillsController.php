<?php
namespace App\Http\Controllers\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tbl_terms;

use App\Globals\Vendor;
use App\Globals\AuditTrail;
use App\Globals\Accounting;
use App\Globals\Purchase_Order;
use App\Globals\Billing;
use App\Globals\Item;
use App\Globals\Warehouse;
use App\Globals\Warehouse2;
use App\Globals\UnitMeasurement;
use App\Globals\Utilities;
use App\Globals\Pdf_global;
use App\Globals\ItemSerial;
use App\Globals\Purchasing_inventory_system;
use App\Globals\TransactionEnterBills;
use App\Globals\TransactionPurchaseOrder;
use App\Globals\AccountingTransaction;

use Carbon\Carbon;
use Session;
use PDF;


class TransactionEnterBillsController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Bills';
        return view('member.accounting_transaction.vendor.enter_bills.enter_bills_list', $data);
    }
    public function getLoadEnterBills(Request $request)
    {
        $data['_enter_bills'] = TransactionEnterBills::get($this->user_info->shop_id, 10, $request->search_keyword, $request->tab_type);
        return view('member.accounting_transaction.vendor.enter_bills.enter_bills_table', $data);
    }
    public function getPrint(Request $request)
    {
        $eb_id = $request->id;
           
        $data['eb'] = TransactionEnterBills::info($this->user_info->shop_id, $eb_id);
        $data['_ebline'] = TransactionEnterBills::info_item($eb_id);

        $pdf = view('member.accounting_transaction.vendor.enter_bills.enter_bills_pdf', $data);
        return Pdf_global::show_pdf($pdf);
    }
    public function getCreate(Request $request)
    {
        $data['page'] = 'Create Bills';

    	Session::forget("po_item");
        $data["serial"]     = ItemSerial::check_setting();
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data["_terms"]     = Tbl_terms::where("archived", 0)->where("terms_shop_id", Billing::getShopId())->get();
        $data['_item']      = Item::get_all_category_item();
        $data['_account']   = Accounting::getAllAccount();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["transaction_refnum"] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'enter_bills');
        $data['action']     = '/member/transaction/enter_bills/create-enter-bills';

        $eb_id = $request->id;

        Session::forget("applied_transaction");
        if($eb_id)
        {
            $data['eb'] = TransactionEnterBills::info($this->user_info->shop_id, $eb_id);
            $data['_ebline'] = TransactionEnterBills::info_item($eb_id);
            $data['action']     = '/member/transaction/enter_bills/update-enter-bills';
        }
        return view('member.accounting_transaction.vendor.enter_bills.enter_bills', $data);
    }

    public function postCreateEnterBills(Request $request)
    {
        $btn_action  = $request->button_action;

        $insert['transaction_refnumber']    = $request->transaction_refnumber;
        $insert['vendor_id']                = $request->vendor_id;
        $insert['vendor_address']           = $request->vendor_address;
        $insert['vendor_email']             = $request->vendor_email;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['transaction_date']         = $request->transaction_date;
        $insert['transaction_duedate']      = $request->transaction_duedate;
        $insert['vendor_memo']              = $request->vendor_memo;
        $insert['bill_ri_id']               = null;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id']          = $value;
                $insert_item[$key]['item_ref_name']    = $request->itemline_ref_name[$key];
                $insert_item[$key]['item_ref_id']      = $request->itemline_ref_id[$key];
                $insert_item[$key]['item_servicedate'] = $request->item_servicedate[$key];
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
            $validate = TransactionEnterBills::postInsert(null, $this->user_info->shop_id, $insert, $insert_item);
            TransactionPurchaseOrder::checkPoQty($validate, Session::get('applied_transaction'));
        }
        if(is_numeric($validate))
        {
            $return['status']          = 'success';
            $return['status_message']  = 'Success creating bills.';
            $return['call_function']   = 'success_enter_bills';
            $return['status_redirect'] = AccountingTransaction::get_redirect('enter_bills', $validate ,$btn_action);
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;
        }

        return json_encode($return);
    }
    public function postUpdateEnterBills(Request $request)
    {
        $btn_action  = $request->button_action;
        $bill_id  = $request->bill_id;


        $insert['transaction_refnumber']    = $request->transaction_refnumber;
        $insert['vendor_id']                = $request->vendor_id;
        $insert['vendor_address']           = $request->vendor_address;
        $insert['vendor_email']             = $request->vendor_email;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['transaction_date']         = $request->transaction_date;
        $insert['transaction_duedate']      = $request->transaction_duedate;
        $insert['vendor_memo']              = $request->vendor_memo;
        $insert['bill_ri_id']               = null;

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
                $insert_item[$key]['item_amount']      = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_discount']    = 0;
            }
        }
        $return = null;
        $warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $validate = AccountingTransaction::inventory_validation('refill', $this->user_info->shop_id, $warehouse_id, $insert_item);
        if(!$validate)
        {
            $validate = TransactionEnterBills::postUpdate($bill_id, null, $this->user_info->shop_id, $insert, $insert_item);
        }
        if(is_numeric($validate))
        {
            $return['status']          = 'success';
            $return['status_message']  = 'Success creating bills.';
            $return['call_function']   = 'success_enter_bills';
            $return['status_redirect'] = AccountingTransaction::get_redirect('enter_bills', $validate ,$btn_action);
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
        return TransactionEnterBills::countTransaction($this->user_info->shop_id, $vendor_id);
    }
    public function getLoadTransaction(Request $request)
    {
        $data['_po'] = TransactionPurchaseOrder::getOpenPO($this->user_info->shop_id, $request->vendor);
        $data['vendor'] = Vendor::getVendor($this->user_info->shop_id, $request->vendor);

        $data['_applied'] = Session::get('applied_transaction');
        $data['action']   = '/member/transaction/enter_bills/apply-transaction';
        return view('member.accounting_transaction.vendor.enter_bills.load_transaction', $data);
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

        return view('member.accounting_transaction.vendor.enter_bills.applied_transaction', $data);
    }
}