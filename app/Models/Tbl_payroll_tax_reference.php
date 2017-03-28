<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_payroll_tax_reference extends Model
{
    protected $table = 'tbl_payroll_tax_reference';
	protected $primaryKey = "payroll_tax_reference_id";
    public $timestamps = false;

    /* COLUMN REFERENCE NAME */

	// [PRIMARY KEY] 	payroll_tax_reference_id
	// [INTEGER] 		payroll_tax_status_id
	// [INTEGER]		shop_id
	// [VARCHAR] 		tax_category
	// [DOUBLE] 		tax_first_range
	// [DOUBLE] 		tax_second_range
	// [DOUBLE] 		tax_third_range
	// [DOUBLE] 		tax_fourth_range
	// [DOUBLE] 		tax_fifth_range
	// [DOUBLE] 		taxt_sixth_range
	// [DOUBLE] 		tax_seventh_range
}
