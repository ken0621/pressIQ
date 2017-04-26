<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_chart_account_type;
use App\Models\Tbl_journal_entry;
use App\Models\Tbl_journal_entry_line;
use App\Models\Tbl_customer;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use App\Models\Tbl_ec_product;

use App\Globals\Accounting;
use App\Globals\Account;
use App\Globals\Invoice;
use App\Globals\Category;
use App\Globals\Item;
use App\Globals\Customer;
use App\Globals\Ecom_Product;
use App\Globals\Sms;
use App\Globals\PayrollJournalEntries;
use App\Globals\Payroll;

use Request;
use Carbon\Carbon;
use Session;
use Validator;
use Redirect;
use Crypt;

class TesterController extends Controller
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

    public function getSms($recipient)
    {
        dd(Sms::SendSingleText($recipient,"Test","success_register"));
    }

	public function getIndex()
    {
        dd(PayrollJournalEntries::payroll_summary(0,0));
        dd(collect(Payroll::record_by_date($this->getShopId(), "01-26-2017", "02-10-2017"))->toArray());
        dd(collect(PayrollJournalEntries::check_payroll_entity_account_id())->toArray());
    }

    public function getJournal()
    {
        $data['tbl_journal_entry'] = Accounting::getJounalAll();

        // dd($data['tbl_journal_entry']);
        // dd($data['tbl_journal_entry']);

        return view('member.tester_journal', $data);
    }

    public function getCustomer()
    {
        $shop_id = 1;
        $data["customer_first_name"] = "Bryan";

        dd(Customer::createCustomer($shop_id, $data))   ;
    }

    public function getPayroll()
    {
        
    }
}