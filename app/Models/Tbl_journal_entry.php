<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_journal_entry extends Model
{
	protected $table = 'tbl_journal_entry';
	protected $primaryKey = "je_id";
    public $timestamps = false;

    public function scopeLine($query)
    {
    	return $query->leftjoin("tbl_journal_entry_line","jline_je_id","=","je_id");
    }

    public function scopeTransaction($query, $reference)
    {
    	if($reference == "invoice")
    	{
    		$query->selectRaw("*, concat('/member/customer/invoice?id=', inv_id) as txn_link")
    			  ->join("tbl_customer_invoice","inv_id","=","je_reference_id")
    			  ->join("tbl_customer","customer_id","=","inv_customer_id");
    	}
    }
}