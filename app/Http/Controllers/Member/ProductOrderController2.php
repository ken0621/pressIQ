<?php
namespace App\Http\Controllers\Member;

use App\Globals\Transaction;
use App\Globals\Columns;

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
}