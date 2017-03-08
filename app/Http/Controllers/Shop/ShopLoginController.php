<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

class ShopLoginController extends Shop
{
    public function index()
    {
        $data["page"] = "Login";
        return view("login", $data);
    }
}