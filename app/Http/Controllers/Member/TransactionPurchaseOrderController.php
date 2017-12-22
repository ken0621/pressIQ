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
use App\Globals\TransactionPurchaseOrder;

use App\Globals\AccountingTransaction;

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
    public function getIndex()
    {
        $data['page'] = 'Purchase Order';
        return view('member.accounting_transaction.vendor.purchase_order.purchase_order_list', $data);

    }
    public function getCreate()
    {
        $shop_id = $this->user_info->shop_id;
        $data["page"]       = "Create Purchase order";
        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data["_terms"]     = Tbl_terms::where("archived", 0)->where("terms_shop_id", Purchase_Order::getShopId())->get();
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();

        $data['action']     = "/member/transaction/purchase_order/create-purchase-order";
        $data['count_so']   = TransactionPurchaseOrder::countTransaction($this->user_info->shop_id);
        return view('member.accounting_transaction.vendor.purchase_order.purchase_order', $data);
    }
    public function postCreatePurchaseOrder(Request $request)
    {
        $btn_action  = $request->button_action;

        $insert['transaction_refnumber']    = $request->transaction_refnumber;
        $insert['vendor_id']                = $request->vendor_id;
        $insert['vendor_address']           = $request->vendor_address;
        $insert['vendor_email']             = $request->vendor_email;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['transaction_date']         = $request->transaction_date;
        $insert['transaction_duedate']      = $request->transaction_duedate;
        $insert['vendor_message']           = $request->vendor_message;
        $insert['vendor_memo']              = $request->vendor_memo;
        $insert['vendor_ewt']               = $request->vendor_ewt;
        $insert['vendor_terms']             = $request->vendor_terms;
        $insert['vendor_discount']          = $request->vendor_discount;
        $insert['vendor_discounttype']      = $request->vendor_discounttype;
        $insert['vendor_tax']               = $request->vendor_tax;
        $insert['vendor_subtotal']          = $request->vendor_subtotal;
        $insert['vendor_total']             = $request->vendor_total;


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
                $insert_item[$key]['item_remark']      = $request->item_remark[$key];
                $insert_item[$key]['item_amount']       = str_replace(',', '', $request->item_amount[$key]);
                $insert_item[$key]['item_taxable']      = $request->item_taxable[$key];
            }
        }
        $validate = TransactionPurchaseOrder::postInsert($this->user_info->shop_id, $insert, $insert_item);

        if(is_numeric($validate))
        {
            
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $validate;
        }
        return json_encode($return);
    }

    public function getLoadTransaction()
    {
        dd('Wait Langs!');
    }
}
