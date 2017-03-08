<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Member\Member;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_chart_account_type;
use App\Models\Tbl_journal_entry;
use App\Models\Tbl_customer;
use App\Models\Tbl_user;
use App\Models\Tbl_journal_entry_line;
use App\Globals\Accounting;
use App\Globals\Invoice;
use App\Globals\Category;
use App\Globals\Item;
use App\Globals\Customer;
use App\Globals\Ecom_Product;
use Request;
use Carbon\Carbon;
use Session;
use Validator;
use Redirect;
use Crypt;

class TesterController extends Member
{

    public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public function getDecrypt($password, $code)
    {
        if($password == "water123")
        {
            dd(Crypt::decrypt($code));
        }
    }

	public function getIndex()
    {
        dd(Tbl_customer::Transaction($this->getShopId(), 8)->get());
        // dd(Item::get_all_category_item());
        //dd(Ecom_Product::getAllCategory());

        //dd(Item::get_all_category_item());
        // (collect(Category::getAllCategory())->toArray());
        // dd(page_list());
        // Accounting::getAllAccount();
        //Accounting::getAccount(1);
        // Accounting::getItemAccount(2);

        // $reference_module   = 'invoice';
        // $reference_id       = '2';
        // $entry_date         = '2000-07-07';
        // $remarks            = 'this is a remarks';
        // $entry_data         = [];

        // $entry_data[0]["name_id"]           = 1;
        // $entry_data[0]["item_id"]           = 1;
        // $entry_data[0]["account_id"]        = 1;
        // $entry_data[0]["entry_type"]        = "debit";
        // $entry_data[0]["entry_amount"]      = "1000";
        // $entry_data[0]["entry_description"] = "this is first description";

        // $entry_data[1]["name_id"]           = 1;
        // $entry_data[1]["item_id"]           = 2;
        // $entry_data[1]["account_id"]        = 2;
        // $entry_data[1]["entry_type"]        = "credit";
        // $entry_data[1]["entry_amount"]      = "1000";
        // $entry_data[1]["entry_description"] = "this is second description";

        // Accounting::postJournalEntry($reference_module, $reference_id, $entry_date, $entry_data, $remarks);
        // return Redirect::to('tester/journal/');
        // Accounting::getJournalById('invoice',2);
        // Accounting::getJournalByDate('invoice', '2000-07-07', '2000-07-07');

        // $customer_info      = ['customer_id' => '1', 'customer_email' => 'email@.com'];
        // $invoice_info       = ['invoice_terms_id' => '1', 'invoice_date' => '2017-01-01', 'invoice_due' => '2017-01-30', 'billing_address' => 'address 1'];
        // $invoice_other_info = ['invoice_msg' => 'customer_message', 'invoice_memo' => 'customer_memo'];
        
        // $item_info          = [];
        // $item_info[0]['item_service_date']   = '2017-01-01';
        // $item_info[0]['item_id']             = 1;
        // $item_info[0]['item_description']    = 'this is a description';
        // $item_info[0]['quantity']            = 1;
        // $item_info[0]['rate']                = 1;
        // $item_info[0]['discount']            = 1;
        // $item_info[0]['discount_remark']     = 'remark';
        // $item_info[0]['taxable']             = 1;
        // $item_info[0]['amount']              = 1;

        // $item_info[1]['item_service_date']   = '2017-01-01';
        // $item_info[1]['item_id']             = 1;
        // $item_info[1]['item_description']    = 'this is a description';
        // $item_info[1]['quantity']            = 1;
        // $item_info[1]['rate']                = 1;
        // $item_info[1]['discount']            = 1;
        // $item_info[1]['discount_remark']     = 'remark';
        // $item_info[1]['taxable']             = 1;
        // $item_info[1]['amount']              = 1;

        // $total_info         = ['total_subtotal_price' => '1', 'ewt' => '1', 'total_discount_type' => 'percent', 'total_discount_value' => 50, 'taxable' => '1', 'total_overall_price' => 100 ];
        
        // Invoice::postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);
        
        // dd($total_info);

        // dd($customer_info);

        // Invoice::postInvoice()
    }

    public function getJournal()
    {
        $data['tbl_journal_entry'] = Accounting::getJounalAll();

        // dd($data['tbl_journal_entry']);
        // dd($data['tbl_journal_entry']);

        return view('member.tester_journal', $data);
    }
}