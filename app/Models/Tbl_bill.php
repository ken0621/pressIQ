<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
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
    public static function scopeByVendor($query, $shop_id, $vendor_id)
    {
        return $query->where("bill_shop_id", $shop_id)->where("bill_vendor_id", $vendor_id);
    }
    public static function scopeAppliedPayment($query, $shop_id)
    {
        return $query->leftJoin(DB::raw("(select sum(pbline_amount) as amount_applied, pbline_reference_id from tbl_pay_bill_line as pbline inner join tbl_pay_bill pb on paybill_id = pbline_pb_id where paybill_shop_id = ".$shop_id." and pbline_reference_name = 'bill' group by concat(pbline_reference_name,'-',pbline_reference_id)) pymnt"), "pymnt.pbline_reference_id", "=", "bill_id");
    }
    public function scopeVendor($query)
    {
         return $query->leftjoin('tbl_vendor', 'tbl_bill.bill_vendor_id', '=', 'tbl_vendor.vendor_id');
    }
    public static function scopePayBill($query, $pb_id, $bill_id)
    {
        return $query->leftJoin(DB::raw("(select * from tbl_pay_bill_line where pbline_pb_id =" .$pb_id ." and pbline_reference_name = 'bill') pb"),"pb.pbline_reference_id","=","bill_id")
                     ->where(function($query) use ($bill_id)
                     {
                        $query->where("bill_is_paid", 0);
                        $query->orWhere(function($query) use ($bill_id)
                        {
                            $query->whereIn("bill_id", $bill_id);
                        });
                     });
    }
}
