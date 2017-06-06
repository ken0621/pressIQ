<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_chart_account_type;
use App\Models\Tbl_journal_entry;
use App\Models\Tbl_journal_entry_line;
use App\Models\Tbl_customer;
use App\Models\Tbl_vendor;
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
use App\Globals\Report;
use App\Globals\Utilities;

use Request;
use Carbon\Carbon;
use Session;
use Validator;
use Redirect;
use Crypt;
use DB;

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
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "http://api.aftership.com/v4",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_HTTPHEADER => array(
        //         "aftership-api-key: 118485a6-ed28-4200-a924-ee42e5019b47",
        //         "Content-Type: application/json"
        //     ),
        // ));
        
        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // curl_close($curl);

        // dd(json_decode($response));

        // $data["open_invoice"]       = Invoice::invoiceStatus()["open"];
        // $data["overdue_invoice"]    = Invoice::invoiceStatus()["overdue"];
        $period = "days_ago";
        $date["days"]   = "30";
        $from           = Report::checkDatePeriod($period, $date)['start_date'];
        $to             = Report::checkDatePeriod($period, $date)['end_date'];

        $data["_expenses"]          = Tbl_journal_entry_line::account()->journal()->totalAmount()
                                    ->where("je_shop_id", 31)
                                    ->whereIn("chart_type_name", ['Expense', 'Other Expense', 'Cost of Good Sold'])
                                    ->whereRaw("DATE(je_entry_date) >= '$from'")
                                    ->whereRaw("DATE(je_entry_date) <= '$to'")
                                    ->get();

        dd($data);
    }

    public function getJournal()
    {
        $data['tbl_journal_entry'] = Accounting::getJounalAll();
    
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