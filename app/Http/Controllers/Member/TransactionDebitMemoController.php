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
        $insert['vendor_address']           = $request->vendor_address;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['transaction_date']         = $request->transaction_date;
        $insert['transaction_duedate']      = $request->transaction_duedate;
        $insert['vendor_message']           = $request->vendor_message;
        $insert['vendor_memo']              = $request->vendor_memo;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id']           = $value;
                $insert_item[$key]['item_servicedate']  = $request->item_servicedate[$key];
                $insert_item[$key]['item_description']  = $request->item_description[$key];
                $insert_item[$key]['item_um']           = $request->item_um[$key];
                $insert_item[$key]['item_qty']          = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']         = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_discount']     = str_replace(',', '', $request->item_discount[$key]);
                $insert_item[$key]['item_remarks']      = $request->item_remarks[$key];
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_taxable']      = $request->item_taxable[$key];
            }
        }
        die(var_dump($btn_action));
    }
}