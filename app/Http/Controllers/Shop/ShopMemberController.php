<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    public function postRegister()
    {
        dd("hello world");
    }
    public function getLogin()
    {
    	$data["page"] = "Login";
    	return view("member.login", $data);
    }
}