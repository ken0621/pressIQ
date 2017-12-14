<?php
namespace App\Http\Controllers\Member;


class TransactionPurchaseOrderController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Purchase Order';

        

        return view('member.accounting_transaction.vendor.purchase_order.purchase_order_list', $data);
    }
    public function getCreate()
    {
        $data['page'] = 'Create Purchase Order';

        return view('member.accounting_transaction.vendor.purchase_order.purchase_order', $data);
    }

    
}