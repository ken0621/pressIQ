<?php
namespace App\Http\Controllers\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tbl_customer;
use App\Models\Tbl_warehousea;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_manual_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_item;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_bill_po;
use App\Models\Tbl_vendor;
use App\Models\Tbl_terms;

use App\Globals\TransactionEnterBills;
use App\Globals\Vendor;
use App\Globals\AuditTrail;
use App\Globals\Accounting;
use App\Globals\Purchase_Order;
use App\Globals\Billing;
use App\Globals\Item;
use App\Globals\Warehouse;
use App\Globals\UnitMeasurement;
use App\Globals\Utilities;
use App\Globals\Pdf_global;
use App\Globals\ItemSerial;
use App\Globals\Purchasing_inventory_system;

use App\Models\Tbl_purchase_order;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_bill;
use App\Models\Tbl_bill_account_line;
use App\Models\Tbl_bill_item_line;
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

    public function getCreate()
    {
        $data['page'] = 'Create Bills';

    	Session::forget("po_item");
        $data["serial"]     = ItemSerial::check_setting();
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data["_terms"]     = Tbl_terms::where("archived", 0)->where("terms_shop_id", Billing::getShopId())->get();
        $data['_item']      = Item::get_all_category_item();
        $data['_account']   = Accounting::getAllAccount();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data['action']     = '/member/transactio/create-enter-bills';
        
        return view('member.accounting_transaction.vendor.enter_bills.enter_bills', $data);
    }

    public function postCreateEnterBills(Request $request)
    {
        $btn_action  = $request->button_action;

        $insert['transaction_refnumber']    = $request->transaction_refnumber;
        $insert['vendor_id']                = $request->vendor_id;
        $insert['vendor_address']           = $request->vendor_address;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['transaction_date']         = $request->transaction_date;
        $insert['transaction_duedate']      = $request->transaction_duedate;
        $insert['vendor_memo']              = $request->vendor_memo;

        $insert_item = null;
        foreach ($request->item_id as $key => $value) 
        {
            if($value)
            {
                $insert_item[$key]['item_id'] = $value;
                $insert_item[$key]['item_servicedate'] = $request->item_servicedate[$key];
                $insert_item[$key]['item_description'] = $request->item_description[$key];
                $insert_item[$key]['item_um'] = $request->item_um[$key];
                $insert_item[$key]['item_qty'] = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate'] = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_amount'] = str_replace(',', '', $request->item_amount[$key]);
            }
        }

        $validate = TransactionEnterBills::postInsert($this->user_info->shop_id, $insert, $insert_item);

        if(is_numeric($validate))
        {

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
        return TransactionEnterBills::countTransaction($this->user_info->shop_id, $vendor_id);
    }
    public function getLoadTransaction()
    {
        dd('Wail Langs!');
    }
    
}