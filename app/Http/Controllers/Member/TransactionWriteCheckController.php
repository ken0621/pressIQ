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
use App\Models\Tbl_user;
use App\Models\Tbl_bill_po;
use App\Models\Tbl_vendor;
use App\Models\Tbl_terms;

use App\Globals\Vendor;
use App\Globals\WriteCheck;
use App\Globals\AuditTrail;
use App\Globals\Accounting;
use App\Globals\Purchase_Order;
use App\Globals\Billing;
use App\Globals\Item;
use App\Globals\Warehouse;
use App\Globals\UnitMeasurement;
use App\Globals\Purchasing_inventory_system;
use App\Globals\TransactionPurchaseOrder;
use App\Globals\AccountingTransaction;

use App\Globals\TransactionWriteCheck;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_bill;
use App\Models\Tbl_bill_account_line;
use App\Models\Tbl_bill_item_line;
use App\Models\Tbl_write_check;
use App\Models\Tbl_write_check_line;
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

        Session::forget("po_item");
        $data["pis"]    	= Purchasing_inventory_system::check();
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data["_name"]      = Tbl_customer::unionVendor(WriteCheck::getShopId())->get();
        $data['_item']      = Item::get_all_category_item();
        $data['_account']   = Accounting::getAllAccount();
        $data['_um']        = UnitMeasurement::load_um_multi();
        $data["transaction_refnum"] = AccountingTransaction::get_ref_num($this->user_info->shop_id, 'write_check');

        $data['action']     = '/member/transaction/write_check/create-write-check';

        $wc_id = $request->id;
        if($wc_id)
        {
            $data['wc'] = TransactionWriteCheck::info($this->user_info->shop_id, $wc_id);
            $data['_wcline'] = TransactionWriteCheck::info_item($wc_id);
            dd($data['_wcline']);
        }

        return view('member.accounting_transaction.vendor.write_check.write_check', $data);
    }

    public function postCreateWriteCheck(Request $request)
    {
        $btn_action = $request->button_action;

        $insert['transaction_refnumber']   = $request->transaction_refnumber;
        $insert['vendor_id']               = $request->wc_id;
        $insert['wc_reference_name']       = $request->wc_reference_name;
        $insert['wc_customer_vendor_email']= $request->wc_customer_vendor_email;
        $insert['wc_mailing_address']      = $request->wc_mailing_address;
        $insert['wc_payment_date']         = $request->wc_payment_date;
        $insert['wc_memo']                 = $request->wc_memo;
        $insert['wc_total_amount']         = $request->wc_total_amount;
        
        $insert_item = null;
        $ctr_items = 0;
        foreach($request->item_id as $key => $value)
        {
            if($value)
            {
                $ctr_items++;
            
                /*$insert_item[$key]['itemline_ref_id'] = $value;
                $insert_item[$key]['itemline_ref_name'] = $request->itemline_ref_name[$key];*/
                $insert_item[$key]['item_id']           = $value;
                $insert_item[$key]['item_description']  = $request->item_description[$key];
                $insert_item[$key]['item_um']           = $request->item_um[$key];
                $insert_item[$key]['item_qty']          = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']         = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_discount']     = 0;
            }

            $validate = TransactionWriteCheck::postInsert($this->user_info->shop_id, $insert, $insert_item);
            
            $return = null;
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
            //die(var_dump($return));
            return $return;
        }
    }
    public function getCountTransaction(Request $request)
    {
        $vendor_id = $request->vendor_id;
        return TransactionWriteCheck::countTransaction($this->user_info->shop_id, $vendor_id);
    }
    public function getLoadTransaction(Request $request)
    {
        $data['_po']    = TransactionPurchaseOrder::getClosePO($this->user_info->shop_id, $request->vendor);
        $data['vendor'] = Vendor::getVendor($this->user_info->shop_id, $request->vendor);

        return view('member.accounting_transaction.vendor.write_check.load_transaction', $data);
    }

}