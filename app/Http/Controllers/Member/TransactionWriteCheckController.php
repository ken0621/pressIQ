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

    public function getCreate()
    {
        $data['page'] = 'Create Write Check';

        Session::forget("po_item");
        $data["pis"]    	= Purchasing_inventory_system::check();
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data["_name"]      = Tbl_customer::unionVendor(WriteCheck::getShopId())->get();
        $data['_item']      = Item::get_all_category_item();
        $data['_account']   = Accounting::getAllAccount();
        $data['_um']        = UnitMeasurement::load_um_multi();

        $data['action']     = '/member/transaction/write_check/create-write-check';

        return view('member.accounting_transaction.vendor.write_check.write_check', $data);
    }

    public function postCreateWriteCheck(Request $request)
    {
        $btn_action = $request->button_action;

        $insert['wc_reference_id']         = $request->wc_reference_id;
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
            
                /*$insert_item[$key]['itemline_ref_id']       = $value;
                $insert_item[$key]['itemline_ref_name']     = $request->itemline_ref_name[$key];*/

                $insert_item[$key]['item_id']           = $value;
                $insert_item[$key]['item_description']  = $request->item_description[$key];
                $insert_item[$key]['item_um']           = $request->item_um[$key];
                $insert_item[$key]['item_qty']          = str_replace(',', '', $request->item_qty[$key]);
                $insert_item[$key]['item_rate']         = str_replace(',', '', $request->item_rate[$key]);
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
            }

            die(var_dump($btn_action));
        }
    }
    public function getCountTransaction(Request $request)
    {
        $vendor_id = $request->vendor_id;
        return TransactionWriteCheck::countTransaction($this->user_info->shop_id, $vendor_id);
    }
    public function getLoadTransaction()
    {
        dd('Wail Langs!');
    }

}