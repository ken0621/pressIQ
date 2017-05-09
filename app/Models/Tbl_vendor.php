<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tbl_vendor extends Model
{
	protected $table = 'tbl_vendor';
	protected $primaryKey = "vendor_id";
    public $timestamps = false;

    public function scopeAddress($query)
    {
    	return $query->join("tbl_vendor_address","ven_addr_vendor_id","=","vendor_id");
    }

    public function scopeInfo($query)
    {
    	return $query->join("tbl_vendor_address","ven_addr_vendor_id","=","vendor_id")
    		  		 ->join("tbl_vendor_other_info","ven_info_vendor_id","=","vendor_id");
    }

    public function scopeBalanceJournal($query)
    {
        $balance = DB::table("tbl_journal_entry_line")->join("tbl_chart_of_account", "account_id", "=", "jline_account_id")
                                           ->join("tbl_chart_account_type","chart_type_id", "=", "account_type_id")
                                           ->whereRaw("chart_type_name = 'Accounts Payable'")
                                           ->whereRaw("jline_name_reference = 'vendor'")
                                           ->whereRaw("jline_name_id = vendor_id")
                                           ->whereRaw("account_shop_id = vendor_shop_id")
                                           ->selectRaw("sum( CASE jline_type WHEN 'debit' then -jline_amount WHEN 'credit' then jline_amount END)")
                                           ->toSql();
        
        return $query->selectRaw("*, ($balance) as balance");
    }

    public function scopeTransaction($query, $shop_id, $vendor_id = null)
    {
        /* PURCHASE ORDER */
        $purchase_order = DB::table("tbl_vendor")->selectRaw("po_date as date, 'Purchase Order' as type, po_id as no, po_due_date as due_date, 0 as balance, po_overall_price as total, 'status' as status, date_created, 'vendor/purchase_order' as reference_url")
                    ->join("tbl_purchase_order","po_vendor_id","=","vendor_id")
                    ->where("po_shop_id", $shop_id);
        if($vendor_id) $purchase_order->where("po_vendor_id", $vendor_id);

        /* BILL */
        $bill = DB::table("tbl_vendor")->selectRaw("bill_date as date, 'Bill' as type, bill_id as no, bill_due_date as due_date, bill_total_amount - bill_applied_payment as balance, bill_total_amount as total, 'status' as status, date_created, 'vendor/create_bill' as reference_url")
                    ->join("tbl_bill","bill_vendor_id","=","vendor_id")
                    ->where("bill_shop_id", $shop_id);
        if($vendor_id) $bill->where("bill_vendor_id", $vendor_id);

        /* PAY BILL */
        $pay_bill = DB::table("tbl_vendor")->selectRaw("paybill_date as date, 'Payment' as type, paybill_id as no, paybill_date as due_date, 0 as balance, paybill_total_amount as total, 'status' as status, paybill_date_created, 'vendor/paybill' as reference_url")
                    ->join("tbl_pay_bill","paybill_vendor_id","=","vendor_id")
                    ->where("paybill_shop_id", $shop_id);
        if($vendor_id) $pay_bill->where("paybill_vendor_id", $vendor_id);

        /* WRITE CHECKS */
        $write_check = DB::table("tbl_vendor")->selectRaw("wc_payment_date as date, 'Check' as type, wc_id as no, '' as due_date, 0 as balance, wc_total_amount as total, 'status' as status, date_created, 'vendor/write_check' as reference_url")
                    ->join("tbl_write_check","wc_vendor_id","=","vendor_id")
                    ->where("wc_shop_id", $shop_id)
                    ->where("wc_ref_name","");
        if($vendor_id) $write_check->where("wc_vendor_id", $vendor_id);

        /* JOURNAL ENTRY */
        $journal_entry = DB::table("tbl_journal_entry")->selectRaw("je_entry_date as date, 'Journal' as type, je_id as no,'' as due_date, 0 as balance, jline_amount as total, 'status' as status, tbl_journal_entry.created_at as date_created, 'accounting/journal' as reference_url")
                    ->leftJoin("tbl_journal_entry_line","jline_je_id","=","je_id")
                    ->where("je_shop_id", $shop_id)
                    ->where("je_reference_module","journal-entry");
        if($vendor_id) $journal_entry->where("jline_name_id", $vendor_id)->where("jline_name_reference","vendor");
        
        return $query = $purchase_order->union($bill)->union($pay_bill)->union($write_check)->union($journal_entry)->orderBy("date_created","desc");
    }
}