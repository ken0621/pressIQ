<?php
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Tbl_terms;
use App\Models\Tbl_customer
;

use App\Globals\Warehouse2;
use App\Globals\Vendor;
use App\Globals\WriteCheck;
use App\Globals\Accounting;
use App\Globals\Purchase_Order;
use App\Globals\Billing;
use App\Globals\Item;
use App\Globals\Warehouse;
use App\Globals\UnitMeasurement;
use App\Globals\Purchasing_inventory_system;
use App\Globals\TransactionPurchaseOrder;
use App\Globals\AccountingTransaction;
use App\Globals\TransactionEnterBills;

use App\Globals\TransactionWriteCheck;
use Carbon\Carbon;
use Session;
class TransactionWriteCheckController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Write Check';
        return view('member.accounting_transaction.vendor.write_check.write_check_list', $data);
    }
    public function getLoadWriteCheck(Request $request)
    {
        $data['_write_check']  = TransactionWriteCheck::get($this->user_info->shop_id, 10, $request->search_keyword);
        return view('member.accounting_transaction.vendor.write_check.write_check_table', $data);
    }
    public function getCreate(Request $request)
    {
        $data['page'] = 'Create Write Check';

        $data["pis"]    	= Purchasing_inventory_system::check();
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data["_name"]      = Tbl_customer::unionVendor(WriteCheck::getShopId())->get();
        $data['_item']      = Item::get_all_category_item();
        $data['_account']   = Accounting::getAllAccount();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["transaction_refnum"] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'write_check');

        Session::forget('applied_transaction');
        $data['action']     = '/member/transaction/write_check/create-write-check';

        $wc_id = $request->id;
        if($wc_id)
        {
            $data['wc']      = TransactionWriteCheck::info($this->user_info->shop_id, $wc_id);
            $data['_wcline'] = TransactionWriteCheck::info_item($wc_id);
            $data["_wc_acct_line"] = TransactionWriteCheck::acc_line($wc_id);
            $data['action']  = '/member/transaction/write_check/update-write-check';
        }

        return view('member.accounting_transaction.vendor.write_check.write_check', $data);
    }

    public function postCreateWriteCheck(Request $request)
    {
        $btn_action = $request->button_action;

        $insert['transaction_refnumber']   = $request->transaction_refnumber;
        $insert['vendor_id']               = $request->wc_ref_id;
        $insert['wc_reference_name']       = $request->wc_reference_name;
        $insert['vendor_email']            = $request->wc_customer_vendor_email;
        $insert['wc_mailing_address']      = $request->wc_mailing_address;
        $insert['wc_payment_date']         = $request->wc_payment_date;
        $insert['wc_memo']                 = $request->wc_memo;
        $insert['wc_total_amount']         = $request->wc_total_amount;
        
        $insert_item = null;
        foreach($request->item_id as $key => $value)
        {
            if($value)
            {
                $insert_item[$key]['item_id']           = $value;
                $insert_item[$key]['item_ref_name']     = $request->item_ref_name[$key];
                $insert_item[$key]['item_ref_id']       = $request->item_ref_id[$key];
                $insert_item[$key]['item_description']  = $request->item_description[$key];
                $insert_item[$key]['item_um']           = $request->item_um[$key];
                $insert_item[$key]['item_qty']          = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']         = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_discount']     = 0;
            }
        }

        $return = null;
        $warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $validate = AccountingTransaction::inventory_validation('refill', $this->user_info->shop_id, $warehouse_id, $insert_item);
        if(!$validate)
        {
            $validate = TransactionWriteCheck::postInsert($this->user_info->shop_id, $insert, $insert_item);
            if(Session::get('applied_transaction') > 0)
            {
                TransactionWriteCheck::checkPOQty($validate, Session::get("applied_transaction"));
            }
        }
        if(is_numeric($validate))
        {
            $return['status'] = 'success';
            $return['status_message'] = 'Success creating write check.';
            $return['call_function'] = 'success_write_check';
            $return['status_redirect'] = AccountingTransaction::get_redirect('write_check', $validate ,$btn_action);
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;
        }

        return $return;
    }
    public function postUpdateWriteCheck(Request $request)
    {
        $btn_action = $request->button_action;
        $write_check_id = $request->wc_id;

        $insert['transaction_refnumber']   = $request->transaction_refnumber;
        $insert['vendor_id']               = $request->wc_ref_id;
        $insert['wc_reference_name']       = $request->wc_reference_name;
        $insert['vendor_email']            = $request->wc_customer_vendor_email;
        $insert['wc_mailing_address']      = $request->wc_mailing_address;
        $insert['wc_payment_date']         = $request->wc_payment_date;
        $insert['wc_memo']                 = $request->wc_memo;
        $insert['wc_total_amount']         = $request->wc_total_amount;
        
        $insert_item = null;
        foreach($request->item_id as $key => $value)
        {
            if($value)
            {            
                $insert_item[$key]['item_id']           = $value;
                $insert_item[$key]['item_ref_id']       = $request->item_ref_id[$key];
                $insert_item[$key]['item_ref_name']     = $request->item_ref_name[$key];
                $insert_item[$key]['item_description']  = $request->item_description[$key];
                $insert_item[$key]['item_um']           = $request->item_um[$key];
                $insert_item[$key]['item_qty']          = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']         = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_discount']     = 0;
            }
        }

        $return = null;
        $warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $validate = AccountingTransaction::inventory_validation('refill', $this->user_info->shop_id, $warehouse_id, $insert_item);
        if(!$validate)
        {
            $validate = TransactionWriteCheck::postUpdate($write_check_id, $this->user_info->shop_id, $insert, $insert_item);
        }
        if(is_numeric($validate))
        {
            $return['status'] = 'success';
            $return['status_message'] = 'Success creating write check.';
            $return['call_function'] = 'success_write_check';
            $return['status_redirect'] = AccountingTransaction::get_redirect('write_check', $validate ,$btn_action);
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;
        }
        return $return;
    }
    public function getCountTransaction(Request $request)
    {
        $vendor_id = $request->vendor_id;
        return TransactionPurchaseOrder::countOpenPOTransaction($this->user_info->shop_id, $vendor_id);
    }
    public function getLoadTransaction(Request $request)
    {
        $data['_po'] = TransactionPurchaseOrder::getOpenPO($this->user_info->shop_id, $request->vendor);
        $data['vendor'] = Vendor::getVendor($this->user_info->shop_id, $request->vendor);

        $data['_applied'] = Session::get('applied_transaction');
        $data['action']   = '/member/transaction/write_check/apply-transaction';
        return view('member.accounting_transaction.vendor.write_check.load_transaction', $data);
    }
    public function postApplyTransaction(Request $request)
    {
        $apply_transaction = $request->_apply_transaction;
        Session::put("applied_transaction", $apply_transaction);

        $return['status'] = 'success';
        $return['call_function'] = 'success_apply_transaction';

        return json_encode($return);
    }
    public function getLoadAppliedTransaction()
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
                        $return[$key.'i'.$poline_key]['po_id'] = $poline_value->poline_po_id;
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
        return view('member.accounting_transaction.vendor.write_check.applied_transaction', $data);

    }

}