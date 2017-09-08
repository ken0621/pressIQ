<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

class ShopMemberController extends Shop
{
    public function getIndex()
    {
        $data["page"] = "Dashboard";
        return view("member.dashboard", $data);
    }
    public function getRegister()
    {
    	$data["page"] = "Register";
    	return view("member.register", $data);
    }
}