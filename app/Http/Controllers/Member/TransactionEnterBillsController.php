<?php
namespace App\Http\Controllers\Member;


class TransactionEnterBillsController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Bills';
        return view('member.accounting_transaction.vendor.enter_bills.enter_bills_list', $data);
    }
    
}