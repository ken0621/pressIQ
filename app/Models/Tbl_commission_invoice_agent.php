<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_commission_invoice_agent extends Model
{
	protected $table = 'tbl_commission_invoice_agent';
	protected $primaryKey = "invoice_agent_id";
    public $timestamps = false;


    public function scopeComm_invoice($query)
    {
        return $query->leftjoin('tbl_commission_invoice','tbl_commission_invoice.comm_inv_id','=','tbl_commission_invoice_agent.agent_comm_inv_id');
    }
}