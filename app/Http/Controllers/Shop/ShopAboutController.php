<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
class ShopAboutController extends Shop
{
    public function index()
    {
        $data["page"] = "About";
        return view("about", $data);
    }
}