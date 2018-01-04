<?php
namespace App\Http\Controllers\Member;
use Illuminate\Http\Request;

use App\Models\Tbl_customer;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_credit_memo_line;
use App\Models\Tbl_debit_memo;
use App\Models\Tbl_item;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_debit_memo_line;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_unit_measurement_multi;
use App\Models\Tbl_user;
use App\Models\Tbl_debit_memo_replace_line;

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

class TransactionDebitMemoController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Debit Memo';
        $data['_dm']  = TransactionDebitMemo::getAllDM($this->user_info->shop_id);
        //dd($data['_dm']);
        return view('member.accounting_transaction.vendor.debit_memo.debit_memo_list', $data);
    }
    public function getCreate()
    {
        $data['page']       = 'Create Debit Memo';
    	$data["_vendor"]    = Vendor::getAllVendor('active');
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();

        $data['action']     ='/member/transaction/debit_memo/create-debit-memo';

        return view('member.accounting_transaction.vendor.debit_memo.debit_memo', $data);
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

    public function getCountTransaction(Request $request)
    {
        $vendor_id = $request->vendor_id;
        return TransactionPurchaseOrder::countOpenPOTransaction($this->user_info->shop_id, $vendor_id);
    }

    public function getLoadTransaction(Request $request)
    {
        $data['_po'] = TransactionPurchaseOrder::getOpenPO($this->user_info->shop_id, $request->vendor);
        $data['vendor'] = Vendor::getVendor($this->user_info->shop_id, $request->vendor);
        return view('member.accounting_transaction.vendor.debit_memo.load_transaction', $data); 
    }

}