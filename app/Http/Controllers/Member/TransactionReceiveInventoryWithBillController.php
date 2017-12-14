<?php
namespace App\Http\Controllers\Member;


class TransactionReceiveInventoryWithBillController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Receive Inventory w/ Bill';
        return view('member.accounting_transaction.vendor.receive_inventory_with_bill.receive_inventory_with_bill', $data);
    }
    
}