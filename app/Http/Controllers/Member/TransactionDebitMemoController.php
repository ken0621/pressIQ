<?php
namespace App\Http\Controllers\Member;
use Illuminate\Http\Request;

use App\Globals\AccountingTransaction;
use App\Globals\TransactionDebitMemo;
use App\Globals\TransactionPurchaseOrder;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Customer;
use App\Globals\Vendor;
use App\Globals\DebitMemo;
use App\Globals\Warehouse;
use App\Globals\Utilities;
use App\Globals\Pdf_global;
use App\Globals\Purchasing_inventory_system;
use App\Globals\ItemSerial;
use App\Http\Controllers\Controller;
use Session;


class TransactionDebitMemoController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Debit Memo';
        return view('member.accounting_transaction.vendor.debit_memo.debit_memo_list', $data);
    }
    public function getLoadDebitMemo(Request $request)
    {
        $data['_debit_memo']  = TransactionDebitMemo::get($this->user_info->shop_id, 10, $request->search_keyword, $request->tab_type);
        return view('member.accounting_transaction.vendor.debit_memo.debit_memo_table', $data);
    }
    public function getCreate(Request $request)
    {
        $data['page']       = 'Create Debit Memo';
    	$data["_vendor"]    = Vendor::getAllVendor('active');
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["transaction_refnum"] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'debit_memo');
        $data['action']     ='/member/transaction/debit_memo/create-debit-memo';

        $dm_id = $request->id;
        
        Session::forget("applied_transaction");
        if($dm_id)
        {
            $data['dm']      = TransactionDebitMemo::info($this->user_info->shop_id, $dm_id);
            $data['_dmline'] = TransactionDebitMemo::info_item($dm_id);
            $data['action']  ='/member/transaction/debit_memo/update-debit-memo';
        }
    
        return view('member.accounting_transaction.vendor.debit_memo.debit_memo', $data);
    }
    public function getPrint(Request $request)
    {
        $dm_id = $request->id;

        $data["db"] = TransactionDebitMemo::info($this->user_info->shop_id, $dm_id);
        $data["_dbline"] = TransactionDebitMemo::info_item($dm_id);

        $footer = AccountingTransaction::get_refuser($this->user_info);
        $pdf = view('member.accounting_transaction.vendor.debit_memo.debit_memo_pdf', $data);
        return Pdf_global::show_pdf($pdf, null, $footer);
    }
    public function postCreateDebitMemo(Request $request)
    {
        $btn_action  = $request->button_action;

        $insert['transaction_refnumber']    = $request->transaction_refnumber;
        $insert['vendor_id']                = $request->vendor_id;
        $insert['vendor_email']             = $request->vendor_email;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['transaction_date']         = $request->transaction_date;
        $insert['vendor_message']           = $request->vendor_message;
        $insert['vendor_memo']              = $request->vendor_memo;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id']           = $value;
                $insert_item[$key]['item_description']  = $request->item_description[$key];
                $insert_item[$key]['item_um']           = $request->item_um[$key];
                $insert_item[$key]['item_qty']          = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']         = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_discount']     = 0;
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
            }
        }

        
        $validate = TransactionDebitMemo::postInsert($this->user_info->shop_id, $insert, $insert_item);
        $return = null;
        if(is_numeric($validate))
        {
            $return['status'] = 'success';
            $return['status_message'] = 'Success creating debit memo.';
            $return['call_function'] = 'success_debit_memo';
            $return['status_redirect'] = AccountingTransaction::get_redirect('debit_memo', $validate ,$btn_action);
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;
        }
        return json_encode($return);
    }
    public function postUpdateDebitMemo(Request $request)
    {
        $btn_action  = $request->button_action;
        $debit_memo_id = $request->dm_id;

        $insert['transaction_refnumber']    = $request->transaction_refnumber;
        $insert['vendor_id']                = $request->vendor_id;
        $insert['vendor_email']             = $request->vendor_email;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['transaction_date']         = $request->transaction_date;
        $insert['vendor_message']           = $request->vendor_message;
        $insert['vendor_memo']              = $request->vendor_memo;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id']           = $value;
                $insert_item[$key]['item_description']  = $request->item_description[$key];
                $insert_item[$key]['item_um']           = $request->item_um[$key];
                $insert_item[$key]['item_qty']          = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']         = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_discount']     = 0;
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
            }
        }

        
        $validate = TransactionDebitMemo::postUpdate($debit_memo_id, $this->user_info->shop_id, $insert, $insert_item);
        $return = null;
        if(is_numeric($validate))
        {
            $return['status'] = 'success';
            $return['status_message'] = 'Success creating debit memo.';
            $return['call_function'] = 'success_debit_memo';
            $return['status_redirect'] = AccountingTransaction::get_redirect('debit_memo', $validate ,$btn_action);
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
        return TransactionPurchaseOrder::countOpenPOTransaction($this->user_info->shop_id, $vendor_id);
    }

    public function getLoadTransaction(Request $request)
    {
        $data['_po'] = TransactionPurchaseOrder::getOpenPO($this->user_info->shop_id, $request->vendor);
        $data['vendor'] = Vendor::getVendor($this->user_info->shop_id, $request->vendor);

        $data['_applied'] = Session::get('applied_transaction');
        $data['action']   = '/member/transaction/enter_bills/apply-transaction';
        return view('member.accounting_transaction.vendor.debit_memo.load_transaction', $data); 
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

        return view('member.accounting_transaction.vendor.debit_memo.applied_transaction', $data);
    }

}