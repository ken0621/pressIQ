<?php
namespace App\Http\Controllers\Member;

use App\Globals\Transaction;

class ProductOrderController2 extends Member
{
    public function index()
    {
        $shop_id            = $this->user_info->shop_id;
        $data["page"]       = "Product Orders";
        
        $dummy              = Transaction::get_transaction_customer_details();
        $dummy              = Transaction::get_transaction_date();
        $data["_order"]     = Transaction::get_transaction_list($shop_id, 'receipt');
        
        return view('member.product_order2.product_order2', $data);
    }
}