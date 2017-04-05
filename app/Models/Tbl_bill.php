<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_bill extends Model
{
   	protected $table = 'tbl_bill';
	protected $primaryKey = "bill_id";
    public $timestamps = false;

    public function scopeAccount_line($query)
    {
    	 return $query->join('tbl_bill_account_line', 'tbl_bill_account_line.accline_bill_id', '=', 'tbl_bill.bill_id');
    }
    public function scopeItem_line($query)
    {
    	 return $query->join('tbl_bill_item_line', 'tbl_bill_item_line.itemline_bill_id', '=', 'tbl_bill.bill_id');
    }
    public function scopeVendor($query)
    {
         return $query->join('tbl_vendor', 'tbl_bill.bill_vendor_id', '=', 'tbl_vendor.vendor_id');
    }
}
