<?php
namespace App\Http\Controllers\Member;

use App\Globals\Transaction;
use App\Globals\Columns;
use Excel;
use DB;

class ProductOrderController2 extends Member
{
    public function index()
    {
        $shop_id            = $this->user_info->shop_id;
        $data["page"]       = "Product Orders";
        return view('member.product_order2.product_order2', $data);
    }
    public function index_table()
    {
        $dummy              = Transaction::get_transaction_customer_details();
        $dummy              = Transaction::get_transaction_date();
        $data["_raw_table"] = Transaction::get_transaction_list($shop_id, 'receipt');
        
        $default[]          = ["RECEIPT NO.","transaction_number", true];
        $default[]          = ["CUSTOMER.","first_name", true];
        $default[]          = ["DATE ORDERED","display_date_order", true];
        $default[]          = ["DATE PAID.","display_date_paid", true];
        $default[]          = ["DATE SHIPPED.","display_date_deliver", true];
        $default[]          = ["E-MAIL","email", true];
        $default[]          = ["CONTACT","phone_number", true];
        $data["_table"]     = Columns::filterColumns($this->user_info->shop_id, $this->user_info->user_id, "Order List V2", $data["_raw_table"], $default);
        
        return view('member.global_table', $data);
    }
    public function payref()
    {
        /* Session */
        session()->forget('get_transaction_filter_customer_id');
        session()->forget('get_transaction_customer_details');
        session()->forget('get_transaction_date');
        session()->forget('get_transaction_payment_method');
        session()->forget('get_transaction_slot_id');
        session()->forget('get_transaction_customer_details_v2');

        Transaction::get_transaction_customer_details_v2();
        Transaction::get_transaction_payment_method();
        Transaction::get_transaction_slot_id();

        $data["_transaction"] = Transaction::get_transaction_list($this->user_info->shop_id, 'receipt', '', 0);
        foreach ($data["_transaction"] as $key => $value) 
        {
            if ($value->payment_method != "paymaya") 
            {
                unset($data["_transaction"][$key]);
            }
        }

        Excel::create('Paymaya Report', function($excel) use ($data)
        {
            $excel->sheet('Paymaya', function($sheet) use ($data)
            {
                $sheet->loadView('member.product_order2.payment.payref', $data);
            });
        })
        ->download('xls');
    }
    public function draref()
    {
        /* Session */
        session()->forget('get_transaction_filter_customer_id');
        session()->forget('get_transaction_customer_details');
        session()->forget('get_transaction_date');
        session()->forget('get_transaction_payment_method');
        session()->forget('get_transaction_slot_id');
        session()->forget('get_transaction_customer_details_v2');
        
        Transaction::get_transaction_customer_details_v2();
        Transaction::get_transaction_payment_method();
        Transaction::get_transaction_slot_id();

        $data["_transaction"] = Transaction::get_transaction_list($this->user_info->shop_id, 'receipt', '', 0);
        foreach ($data["_transaction"] as $key => $value) 
        {
            if ($value->payment_method != "dragonpay") 
            {
                unset($data["_transaction"][$key]);
            }
        }

        Excel::create('Dragonpay Report', function($excel) use ($data)
        {
            $excel->sheet('Dragonpay', function($sheet) use ($data)
            {
                $sheet->loadView('member.product_order2.payment.draref', $data);
            });
        })
        ->download('xls');
    }
}