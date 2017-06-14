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
use App\Globals\Ec_brand;

class ShopHomeController extends Shop
{
    public function index()
    {
        $data["page"]      = "Home";
        $data["_product"] = Ecom_Product::getAllProduct($this->shop_info->shop_id);

        /* Intogadgets Exclusive */
        if ($this->shop_info->shop_theme == "intogadgets") 
        {
        	$data["_brand"] = Ec_brand::getAllBrands($this->shop_info->shop_id);
        }
     	
        return view("home", $data);
    }
}