<?php
namespace App\Http\Controllers;
use App\Models\Tbl_shop;

class SuperController extends Controller
{
    public function getIndex()
    {   
        return view("super.login");
    }
}