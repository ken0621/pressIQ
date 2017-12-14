<?php
namespace App\Http\Controllers\Member;


class TransactionBadOrderController  extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Bad Order';
        return view('member.accounting_transaction.vendor.bad_order.bad_order_list', $data);
    }
    
}