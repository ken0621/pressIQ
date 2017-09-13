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
use App\Models\Tbl_shop;
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
    public function connection_test()
    {
        $_test = DB::table("tbl_connection_test")->orderBy("connection_test_id", "desc")->limit(5)->get();
        foreach($_test as $test)
        {
            echo "<hr>";
            echo "From (" . $test->connection_test_id . ") " . $test->ip_address . "<br>";
            
            echo "<pre>";
            print_r(unserialize($test->test_data_serialize));
            echo "</pre>";
        }
    }
    
    public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
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
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.aftership.com/v4/couriers/all",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => array(
                "aftership-api-key: 118485a6-ed28-4200-a924-ee42e5019b47",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        dd(json_decode($response));
    }

    public function getPostTracking()
    {
        dd(Accounting::getAllAccount());
    }

    public function getTracking()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.aftership.com/v4/trackings",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => array(
                "aftership-api-key: 118485a6-ed28-4200-a924-ee42e5019b47",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        dd(json_decode($response));

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
        dd(Customer::createCustomer($shop_id, $data));
    }

    public function getPayroll()
    {
        
    }
    public function samptest()
    {
        
       
        if(Request::isMethod("post"))
        {
            $_customer  = Tbl_customer::where("archived", 0);

            if(Request::input("sort") != "")
            {
                $_customer->orderBy(Request::input("sort"));
            }

            if(Request::input("shop_id") != 0)
            {
                $_customer->where("shop_id", Request::input("shop_id"));
            }

            $data["_customer"] = $_customer->paginate(5);

            return view("errors.test_table", $data);
        }
        else
        {
            $data["_shop"] = Tbl_shop::get();
            return view("errors.test", $data);
        }
        
    }
}