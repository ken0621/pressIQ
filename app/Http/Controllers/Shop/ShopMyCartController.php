<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DB;
class ShopMyCartController extends Shop
{
    

    public function MyCart()
    {
        $data["page"] = "MyCart";
        return view("MyCart", $data);
    }  
}