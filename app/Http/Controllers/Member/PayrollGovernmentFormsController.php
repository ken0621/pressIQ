<?php

namespace App\Http\Controllers\Member;

use Request;
use Validator;
use Crypt;

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
}
