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
        $invoice = DB::table("tbl_customer")->selectRaw("inv_date as date, 'Invoice' as type, inv_id as no, inv_due_date as due_date, 'balance' as balance, inv_overall_price as total, 'status' as status")
        			->join("tbl_customer_invoice","inv_customer_id","=","customer_id")
        			->where("inv_shop_id", $shop_id);
        if($customer_id) $invoice->where("inv_customer_id", $customer_id);

       	$receive_payment = DB::table("tbl_customer")->selectRaw("rp_date as date, 'Payment' as type, rp_id as no, rp_date as due_date, 'balance' as balance, rp_total_amount as total, 'status' as status")
        			->join("tbl_receive_payment","rp_customer_id","=","customer_id")
        			->where("rp_shop_id", $shop_id);
        if($customer_id) $receive_payment->where("rp_customer_id", $customer_id);
        
       	return $query = $receive_payment->union($invoice)->orderBy("date","desc");
    }
}