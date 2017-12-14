<?php
namespace App\Http\Controllers\Member;


class TransactionWriteCheckController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Write Check';
        return view('member.accounting_transaction.vendor.write_check.write_check_list', $data);
    }
    
}