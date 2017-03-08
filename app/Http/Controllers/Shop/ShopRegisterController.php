<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

class ShopRegisterController extends Shop
{
    public function index()
    {
        $data["page"] = "register";
        return view("register", $data);
    }
}