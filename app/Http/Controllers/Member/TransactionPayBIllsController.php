<?php
namespace App\Http\Controllers\Member;


class TransactionPayBillsController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Pay Bills';
        return view('member.accounting_transaction.vendor.pay_bills.pay_bills', $data);
    }
    
}