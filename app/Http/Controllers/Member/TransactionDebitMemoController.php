<?php
namespace App\Http\Controllers\Member;


class TransactionDebitMemoController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Debit Memo';
        return view('member.accounting_transaction.vendor.debit_memo.debit_memo_list', $data);
    }
    
}