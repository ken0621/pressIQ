<?php

namespace App\Http\Controllers\Member;

use Request;
use Validator;
use Crypt;
use App\Globals\Pdf_global;

class PayrollGovernmentFormsController extends Member
{
    public function getIndex()
    {   
        return view("member.payroll.government_forms.index");
    }

    public function getBir()
    {
        return view("member.payroll.government_forms.bir");
    }

    public function getSss()
    {
    	return view("member.payroll.government_forms.sss");
    }

    public function getErcontribution()
    {
        return view("member.payroll.government_forms.ercontribution");
    }

    public function getPagibig()
    {
        return view("member.payroll.government_forms.pagibig");
    }
}
