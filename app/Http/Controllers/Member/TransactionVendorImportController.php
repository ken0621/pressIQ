<?php
namespace App\Http\Controllers\Member;


class TransactionVendorImportController extends Member
{
    public function getIndex()
    {
        $data['page'] = 'Vendor Import';
        return view('member.accounting_transaction.vendor.vendor_import.vendor_import', $data);
    }
    
}