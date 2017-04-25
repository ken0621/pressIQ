<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_customer extends Model
{
	protected $table = 'tbl_customer';
	protected $primaryKey = "customer_id";
    public $timestamps = false;
    
    public function scopeTransaction($query, $shop_id, $customer_id = null)
    {
        $invoice = DB::table("tbl_customer")->selectRaw("inv_date as date, 'Invoice' as type, inv_id as no, inv_due_date as due_date, inv_overall_price - inv_payment_applied as balance, inv_overall_price as total, 'status' as status, date_created, 'invoice' as reference_name ")
                    ->join("tbl_customer_invoice","inv_customer_id","=","customer_id")
                    ->where("inv_shop_id", $shop_id);
        if($customer_id) $invoice->where("inv_customer_id", $customer_id);

        $receive_payment = DB::table("tbl_customer")->selectRaw("rp_date as date, 'Payment' as type, rp_id as no, rp_date as due_date, 0 as balance, rp_total_amount as total, 'status' as status, date_created, 'receive_payment' as reference_name")
                    ->join("tbl_receive_payment","rp_customer_id","=","customer_id")
                    ->where("rp_shop_id", $shop_id);
        if($customer_id) $receive_payment->where("rp_customer_id", $customer_id);
        
        return $query = $receive_payment->union($invoice)->orderBy("date_created","desc");
    }

    public function scopeInfo($query)
    {
        return $query->join("tbl_customer_address","tbl_customer_address.customer_id","=","tbl_customer.customer_id")
                     ->join("tbl_customer_other_info","tbl_customer_other_info.customer_id","=","tbl_customer.customer_id");
    }

    public function scopeBalance($query, $shop_id, $customer_id = null)
    {
        $invoice = DB::table("tbl_customer")->selectRaw("sum(inv_overall_price - inv_payment_applied) as balance")
                    ->join("tbl_customer_invoice","inv_customer_id","=","customer_id")
                    ->where("inv_shop_id", $shop_id);
        if($customer_id) $invoice->where("inv_customer_id", $customer_id);

        $receive_payment = DB::table("tbl_customer")->selectRaw("sum(0) as balance")
                    ->join("tbl_receive_payment","rp_customer_id","=","customer_id")
                    ->where("rp_shop_id", $shop_id);
        if($customer_id) $receive_payment->where("rp_customer_id", $customer_id);
        
        $balance = $invoice->pluck("balance") + $receive_payment->pluck("balance");

        return $query->selectRaw("*, $balance as balance");
    }

    public function scopeUnionVendor($query, $shop_id)
    {
        $raw = DB::table("tbl_vendor")->selectRaw("vendor_id as id, vendor_first_name as first_name, vendor_middle_name as middle_name, vendor_last_name as last_name, 'vendor' as reference")->where("archived", 0)->where("vendor_shop_id", $shop_id);

        return $query->selectRaw("customer_id as id, first_name as first_name, middle_name as middle_name, last_name as last_name, 'customer' as reference")->where("archived", 0)->where("shop_id", $shop_id)->union($raw);
    }
}