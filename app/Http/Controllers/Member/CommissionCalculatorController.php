<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Globals\Customer;
use App\Globals\Item;
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
        $data['_customer'] = Customer::getAllCustomer();
        $data['_item'] = Item::get_all_category_item([2]);

        return view('member.cashier.commission_calculator.create',$data);        
    }
}
