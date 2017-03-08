<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Globals\Cart;
use App\Models\Tbl_item;
use App\Models\Tbl_category;
use App\Globals\Category;
use App\Globals\Ecom_Product;
use App\Globals\Cards;

class ShopHomeController extends Shop
{
    public function index()
    {
        $data["page"]      = "Home";

        return view("home", $data);
    }
}