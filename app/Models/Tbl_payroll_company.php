<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_company extends Model
{
    protected $table = 'tbl_payroll_company';
	protected $primaryKey = "payroll_company_id";
    public $timestamps = false;

    /* REFERENCE COLUMN NAME */
    // [PRIMARY KEY]    payroll_company_id
    // [INTEGER]        payroll_parent_company_id
    // [VARCHAR]        payroll_company_name
    // [TEXT]           payroll_company_address
    // [VARCHAR]        payroll_company_contact
    // [VARCHAR]        payroll_company_email
    // [VARCHAR]        payroll_company_nature_of_business
    // [INTEGER]        payroll_company_rdo
    // [DATE]           payroll_company_date_started
    // [VARCHAR]        payroll_company_tin
    // [VARCHAR]        payroll_company_sss
    // [VARCHAR]        payroll_company_philhealth
    // [VARCHAR]        payroll_company_pagibig
    // [VARCHAR]        payroll_company_logo
    // [TINYINTEGER]    payroll_company_archived
    // [INTEGER]        shop_id
    // [VARCHAR]        payroll_company_code
    

    public function scopeselcompany($query,$shop_id = 0, $archived = 0)
    {
        $query->leftjoin('tbl_payroll_rdo','tbl_payroll_rdo.payroll_rdo_id','=','tbl_payroll_company.payroll_company_rdo')
              ->where('shop_id', $shop_id)
              ->where('payroll_company_archived',$archived);

        return $query;
    }


}
