<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Tbl_credit_memo extends Model
{
   protected $table = 'tbl_credit_memo';
	protected $primaryKey = "cm_id";
    public $timestamps = true;

    public function scopeCustomer($query)
    {
    	return $query->leftjoin("tbl_customer","tbl_customer.customer_id","=","tbl_credit_memo.cm_customer_id");
    }
    public function scopeManual_cm($query)
    {
        return $query->leftJoin("tbl_manual_credit_memo","tbl_manual_credit_memo.cm_id","=","tbl_credit_memo.cm_id")
                    ->selectRaw("*, tbl_credit_memo.cm_id as cm_id");
    }
    public static function scopeCm_item($query)
    {
    	return $query->join("tbl_credit_memo_line","tbl_credit_memo_line.cmline_cm_id","=","tbl_credit_memo.cm_id")
    				->join("tbl_item","tbl_item.item_id","=","cmline_item_id");
    }
    public static function scopeInv($query)
    {
        return $query->leftJoin("tbl_customer_invoice","credit_memo_id","=","tbl_credit_memo.cm_id");

    }
}
