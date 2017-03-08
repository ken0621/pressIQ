<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_customer_invoice extends Model
{
	protected $table = 'tbl_customer_invoice';
	protected $primaryKey = "inv_id";
    public $timestamps = false;

	public static function scopeCustomer($query)
    {
    	return $query->join("tbl_customer","tbl_customer.customer_id","=","tbl_customer_invoice.inv_customer_id");
    }
    public static function scopeInvoice_item($query)
    {
    	return $query->join("tbl_customer_invoice_line","tbl_customer_invoice_line.invline_inv_id","=","tbl_customer_invoice.inv_id")
    				->join("tbl_item","tbl_item.item_id","=","invline_item_id");
    }
}