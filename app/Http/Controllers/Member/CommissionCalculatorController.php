<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommissionCalculatorController extends Member
{
    /**
     * Display a listing of the resource.
     * @author ARCYLEN
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data['page'] = "Commission Calculator";
        return view('member.cashier.commission_calculator.commission_calculator_list',$data);
    }
    public function getCreate()
    {
        $data['page'] = "Commission Calculator";
        return view('member.cashier.commission_calculator.create',$data);        
    }
}
