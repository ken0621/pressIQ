<?php
namespace App\Http\Controllers\Member;

use App\Globals\Transaction;
use App\Globals\Columns;
use App\Models\Tbl_transaction_list;
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
    public function table()
    {
        $shop_id            = $this->user_info->shop_id;
        $dummy              = Transaction::get_transaction_customer_details_v2();
        $dummy              = Transaction::get_transaction_date();
        $active_tab         = request("_active_tab");

        if($active_tab == "paid")
        {
            $data["_raw_table"] = Transaction::get_transaction_list($shop_id, 'receipt');
        }
        elseif($active_tab == "unconfirmed")
        {
            $data["_raw_table"] = Transaction::get_transaction_list($shop_id, 'proof');
        }
        elseif($active_tab == "pending")
        {
            $data["_raw_table"] = Transaction::get_transaction_list($shop_id, 'order');
        }
        else
        {
            $data["_raw_table"] = Transaction::get_transaction_list($shop_id, 'receipt');
        }

        foreach($data["_raw_table"] as $key => $raw_table)
        {
            $data["_raw_table"][$key]->action = "NO ACTION";
            $data["_raw_table"][$key]->name = $raw_table->first_name . " " . $raw_table->last_name;

            if($active_tab == "unconfirmed")
            {
                $data["_raw_table"][$key]->action = '<a target="_blank" href="/member/ecommerce/product_order2/proof?id=' . $raw_table->transaction_list_id . '">VIEW PROOF</a> | ';
                $data["_raw_table"][$key]->action .= '<a href="javascript:">CONFIRM</a> | ';
                $data["_raw_table"][$key]->action .= '<a href="javascript:">REJECT</a>';
            }
        }

        $default[]          = ["REF NO.","transaction_number", true];
        $default[]          = ["CUSTOMER NAME","name", true];
        $default[]          = ["DATE ORDERED","display_date_order", true];
        $default[]          = ["DATE PAID.","display_date_paid", true];
        $default[]          = ["DATE SHIPPED.","display_date_deliver", true];
        $default[]          = ["E-MAIL","email", true];
        $default[]          = ["CONTACT","phone_number", true];
        $default[]          = ["ACTIONS","action", true];
        $data["_table"]     = Columns::filterColumns($this->user_info->shop_id, $this->user_info->user_id, "Order List V2", $data["_raw_table"], $default);

        return view('member.global_table', $data);
    }
    public function proof()
    {
        $transaction_list_id    = request("id");
        $transaction_list       = Tbl_transaction_list::where("transaction_list_id", $transaction_list_id)->transaction()->first();
        $proof                  = $transaction_list->transaction_payment_proof;

        $url = $this->user_info->upload_server . $proof;
        return redirect($url);
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