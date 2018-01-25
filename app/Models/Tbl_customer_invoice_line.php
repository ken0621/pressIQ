<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_invoice_line extends Model
{
	protected $table = 'tbl_customer_invoice_line';
	protected $primaryKey = "invline_id";
    public $timestamps = true;

    public function scopeUm($query)
    {
        return $query->leftjoin("tbl_unit_measurement_multi", "multi_id", "=", "invline_um");
    }
    public function scopeInvoice($query)
    {
        return $query->leftjoin("tbl_customer_invoice", "invline_inv_id", "=", "inv_id");
    }
    public function scopeInvoice_item($query)
    {
    	return $query->leftjoin("tbl_item","tbl_item.item_id","=","invline_item_id");
    }
}