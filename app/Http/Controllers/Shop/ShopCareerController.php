<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

class ShopCareerController extends Shop
{
    public function index()
    {
        $data["page"] = "Career";
        return view("career", $data);
    }
}