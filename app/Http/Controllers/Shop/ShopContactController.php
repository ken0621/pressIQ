<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

class ShopContactController extends Shop
{
    public function index()
    {
        $data["page"] = "Contact";
        return view("contact", $data);
    }
}