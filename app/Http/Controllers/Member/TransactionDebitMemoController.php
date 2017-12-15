<?php
namespace App\Http\Controllers\Member;
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
use Request;

class TransactionDebitMemoController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Debit Memo';
        return view('member.accounting_transaction.vendor.debit_memo.debit_memo_list', $data);
    }
    public function getCreate()
    {
    	$data['pis']        = Purchasing_inventory_system::check();
        $data['page'] = 'Create Debit Memo';
    	$data["_vendor"]    = Vendor::getAllVendor('active');
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();
        return view('member.accounting_transaction.vendor.debit_memo.debit_memo', $data);
    }
    
}