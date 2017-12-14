<?php
namespace App\Http\Controllers\Member;
use Request;
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
        $data['pis']        = Purchasing_inventory_system::check();
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data["_terms"]     = Tbl_terms::where("archived", 0)->where("terms_shop_id", Billing::getShopId())->get();
        $data['_item']      = Item::get_all_category_item();
        $data['_account']   = Accounting::getAllAccount();
        $data['_um']        = UnitMeasurement::load_um_multi();
        
        return view('member.accounting_transaction.vendor.enter_bills.enter_bills', $data);
    }
    
}