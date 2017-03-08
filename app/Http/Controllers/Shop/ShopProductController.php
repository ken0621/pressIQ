<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Models\Tbl_category;
use App\Globals\Category;
use App\Globals\Ecom_Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ShopProductController extends Shop
{
    public function index()
    {
        $data["page"] = "Product";
        $data["_category"] = Ecom_Product::getAllCategory($this->shop_info->shop_id);
        $product = Ecom_Product::getAllProductByCategory(Request::input("type"), $this->shop_info->shop_id);
        $perPage = 12;
        $data["_product"] = self::paginate($product, $perPage);
        
        return view("product", $data);
    }
    public function paginate($items,$perPage)
    {
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage; 

        // Get only the items you need using array_slice
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage, true);

        return new LengthAwarePaginator($itemsForCurrentPage, count($items), $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
    }
}