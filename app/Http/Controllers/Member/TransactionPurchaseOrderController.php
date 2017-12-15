<?php
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Globals\Invoice;
use App\Globals\Accounting;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Warehouse;
use App\Globals\Billing;
use App\Globals\Pdf_global;
use App\Globals\Utilities;
use App\Globals\Purchasing_inventory_system;

use App\Models\Tbl_customer;
use App\Models\Tbl_warehousea;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_manual_invoice;
use App\Models\Tbl_customer_invoice_line;
use App\Models\Tbl_item;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_vendor;
use App\Globals\Vendor;
use App\Globals\AuditTrail;
use App\Globals\Purchase_Order;
use App\Globals\ItemSerial;
use App\Models\Tbl_purchase_order;
use App\Models\Tbl_purchase_order_line;
use App\Models\Tbl_terms;

use Carbon\Carbon;
use Session;
use Redirect;
use PDF;


class TransactionPurchaseOrderController extends Member
{
    public function getIndex(Request $request)
    {
        $data['page'] = 'Purchase Order';

        return view('member.accounting_transaction.vendor.purchase_order.purchase_order_list', $data);

    }
    public function getCreate(Request $request)
    {
        $data["page"]       = "Create Purchase order";
        
        $data['pis']        = Purchasing_inventory_system::check();
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data["_terms"]     = Tbl_terms::where("archived", 0)->where("terms_shop_id", Purchase_Order::getShopId())->get();
        //dd($data["_terms"]);
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();

        return view('member.accounting_transaction.vendor.purchase_order.purchase_order', $data);
    }

}
