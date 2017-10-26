<?php
namespace App\Http\Controllers\Member;

use App\Globals\Transaction;
use App\Globals\Columns;
use App\Models\Tbl_online_pymnt_method;
use App\Globals\Payment;
use App\Models\Tbl_transaction_list;
use App\Models\Tbl_online_pymnt_link;
use Excel;
use DB;
use Request;

class ProductOrderController2 extends Member
{
    public function index()
    {
        $shop_id            = $this->user_info->shop_id;
        $data["page"]       = "Product Orders";
        $data["shop_id"]    = $shop_id;
        $data["_method"]    = Tbl_online_pymnt_link::where("link_shop_id", $shop_id)
                                                    ->leftJoin("tbl_online_pymnt_gateway", "tbl_online_pymnt_gateway.gateway_code_name", "=", "tbl_online_pymnt_link.link_reference_name")
                                                    ->groupBy("link_reference_name")
                                                    ->get();
        
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
        elseif($active_tab == "reject")
        {
            $data["_raw_table"] = Transaction::get_transaction_list($shop_id, 'reject');
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
                $data["_raw_table"][$key]->action .= '<a link="/member/ecommerce/product_order2/confirm_payment?id='. $raw_table->transaction_list_id .'" class="popup" size="md">CONFIRM</a> | ';
                $data["_raw_table"][$key]->action .= '<a link="/member/ecommerce/product_order2/reject_payment?id='. $raw_table->transaction_list_id .'" class="popup" size="md">REJECT</a>';
            }
            if($active_tab == "reject")
            { 
                $data["_raw_table"][$key]->action = '<a target="_blank" href="/member/ecommerce/product_order2/proof?id=' . $raw_table->transaction_list_id . '">VIEW PROOF</a>';
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

    public function export()
    {
        /* Session */
        session()->forget('get_transaction_filter_customer_id');
        session()->forget('get_transaction_customer_details');
        session()->forget('get_transaction_date');
        session()->forget('get_transaction_payment_method');
        session()->forget('get_transaction_slot_id');
        session()->forget('get_transaction_customer_details_v2');
        
        Transaction::get_transaction_customer_details_v2();

        $method = Request::input("method");
        $data["method"] = $method;
        $data["_transaction"] = Transaction::get_transaction_list($this->user_info->shop_id, 'order', '', 0);
        foreach ($data["_transaction"] as $key => $value) 
        {
            $transaction = Transaction::getCustomerTransaction($value->transaction_id);
            if ($transaction) 
            {
                if ($transaction->payment_method != $method) 
                {
                    unset($data["_transaction"][$key]);
                }
            }
        }
        
        Excel::create('Order Report', function($excel) use ($data)
        {
            $excel->sheet('Order', function($sheet) use ($data)
            {
                $sheet->loadView('member.product_order2.payment.export', $data);
            });
        })
        ->download('xls');
    }

    public function confirm_payment()
    {
        $shop_id            = $this->user_info->shop_id;
        $data["page"]       = "Confirm Product Orders";
        $data['title']      = "CONFIRM";
        $transaction_list_id    = request("id");
        Transaction::get_transaction_customer_details_v2();
        $data['transaction'] = Transaction::get_data_transaction_list($transaction_list_id);
        $data['action'] = '/member/ecommerce/product_order2/confirm_payment_submit';

        return view('member.product_order2.confirm_product_order2', $data);        
    }
    public function reject_payment()
    {
        $shop_id            = $this->user_info->shop_id;
        $data["page"]       = "REJECT Product Orders";
        $data['title']      = "REJECT";
        $transaction_list_id    = request("id");
        Transaction::get_transaction_customer_details_v2();
        $data['transaction'] = Transaction::get_data_transaction_list($transaction_list_id);
        $data['action'] = '/member/ecommerce/product_order2/reject_payment_submit';

        return view('member.product_order2.confirm_product_order2', $data);        
    }
    
    public function reject_payment_submit()
    {
        $val = Payment::manual_reject_payment($this->user_info->shop_id, request('transaction_id'));
        if($val)
        {
            $return['status'] = 'success';
            $return['call_function'] = 'success_confirm';            
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = "Something wen't wrong. Please try again later.";
        }

        return json_encode($return);
    }
    public function confirm_payment_submit()
    {
        $val = Payment::manual_confirm_payment($this->user_info->shop_id, request('transaction_list_id'));
        if(!$val)
        {
            $return['status'] = 'success';
            $return['call_function'] = 'success_confirm';            
        }
        else
        {
            $return['status'] = 'error';
            $return['status_message'] = $val;
        }

        return json_encode($return);
    }
}