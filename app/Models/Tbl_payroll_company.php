<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_company extends Model
{
    protected $table = 'tbl_payroll_company';
	protected $primaryKey = "payroll_company_id";
    public $timestamps = false;

    public function scopeselcompany($query,$shop_id = 0, $archived = 0)
    {
    	$query->leftjoin('tbl_payroll_rdo','tbl_payroll_rdo.payroll_rdo_id','=','tbl_payroll_company.payroll_company_rdo')
    		  ->where('shop_id', $shop_id)
    		  ->where('payroll_company_archived',$archived);

    	return $query;
    }
}
