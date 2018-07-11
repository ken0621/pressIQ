<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_commission_invoice extends Model
{
	protected $table = 'tbl_commission_invoice';
	protected $primaryKey = "comm_inv_id";
    public $timestamps = false;

    public function scopePayment($query)
    {
        return $query->leftjoin('tbl_receive_payment','rp_id','=','payment_ref_id');
    }
}