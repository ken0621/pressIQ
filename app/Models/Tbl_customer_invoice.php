<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_customer_invoice extends Model
{
	protected $table = 'tbl_customer_invoice';
	protected $primaryKey = "inv_id";
    public $timestamps = true;

	public static function scopeCustomer($query)
    {
    	return $query->join("tbl_customer","tbl_customer.customer_id","=","tbl_customer_invoice.inv_customer_id");
    }
    public static function scopeC_m($query)
    {
        return $query->leftJoin("tbl_credit_memo","cm_id","=","tbl_customer_invoice.credit_memo_id");
    }
    public static function scopeReturns_item($query)
    {
        return $query->leftjoin("tbl_credit_memo_line","tbl_credit_memo_line.cmline_cm_id","=","tbl_customer_invoice.credit_memo_id")->leftjoin("tbl_item","cmline_item_id","=","item_id");;
    }
    public static function scopeManual_invoice($query)
    {
        return $query->leftJoin("tbl_manual_invoice","tbl_manual_invoice.inv_id","=","tbl_customer_invoice.inv_id")
                    ->selectRaw("*, tbl_customer_invoice.inv_id as inv_id");
    }
    public static function scopeInvoice_item($query)
    {
    	return $query->join("tbl_customer_invoice_line","tbl_customer_invoice_line.invline_inv_id","=","tbl_customer_invoice.inv_id")
    				->join("tbl_item","tbl_item.item_id","=","invline_item_id");
    }

    public static function scopeAppliedPayment($query, $shop_id = 0)
    {
        return $query->leftJoin(DB::raw("(select sum(rpline_amount) as amount_applied, rpline_reference_id from tbl_receive_payment_line as rpline inner join tbl_receive_payment rp on rp_id = rpline_rp_id where rp_shop_id = ".$shop_id." and rpline_reference_name = 'invoice' group by concat(rpline_reference_name,'-',rpline_reference_id)) pymnt"), "pymnt.rpline_reference_id", "=", "inv_id");
    }

    public static function scopeByCustomer($query, $shop_id, $customer_id)
    {
        return $query->where("inv_shop_id", $shop_id)->where("inv_customer_id", $customer_id);
    }

    public static function scopeRcvPayment($query, $rcvpayment_id, $invoice_id)
    {
        return $query->leftJoin(DB::raw("(select * from tbl_receive_payment_line where rpline_rp_id =" .$rcvpayment_id ." and rpline_reference_name = 'invoice') rp"),"rp.rpline_reference_id","=","inv_id")
                     ->where(function($query) use ($invoice_id)
                     {
                        $query->where("inv_is_paid", 0);
                        $query->orWhere(function($query) use ($invoice_id)
                        {
                            $query->whereIn("inv_id", $invoice_id);
                        });
                     });
    }
}