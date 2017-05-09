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
}