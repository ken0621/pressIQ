<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Request;
use Session;
use Excel;
use DB;

use App\Models\Tbl_payroll_employee_basic;
use App\Models\Tbl_payroll_time_sheet;
use App\Models\Tbl_payroll_time_sheet_record;

class Payroll_BioImportController extends Controller
{

	/* MODAL IMPORT OF BIOMETRICS START*/
	public function modal_biometrics()
	{
		return view('member.payroll.modal.modal_biometrics');
	}
	/* MODAL IMPORT OF BIOMETRICS END */


    /* DMSPH BIO METRICS START */

    public function import_dmsph()
    {

    }

    public function template_dmsph()
    {

    }

    /* DMSPH BIO METRICS END */
}
