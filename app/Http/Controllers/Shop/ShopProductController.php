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
        $type = Request::input("type");
        $brand = Request::input("brand");
        if ($type) 
        {
            // Get Product by Category
            $product = Ecom_Product::getAllProductByCategory($type, $this->shop_info->shop_id);
            // Get Breadcrumbs
            $data["breadcrumbs"] = Ecom_Product::getProductBreadcrumbs($type, $this->shop_info->shop_id);
        }
        elseif($brand)
        {
            $product = Ecom_product::getProductByCategoryName($brand, $this->shop_info->shop_id);
            $data["breadcrumbs"][0]["type_name"] = $brand;
        }
        else
        {
            // Get Product by Category
            $product = Ecom_Product::getAllProduct($this->shop_info->shop_id);
            // Get Breadcrumbs
            $data["breadcrumbs"] = [];
        }
        // Get Most Searched
        $data["_most_searched"] = Ecom_Product::getMostSearched(5, $this->shop_info->shop_id);
        // Get Category
        $data["_category"] = Ecom_Product::getAllCategory($this->shop_info->shop_id);
        // Count total product
        $data["total_product"] = count($product);
        // Filter Price
        $min = Request::input("min");
        $max = Request::input("max");
        if ($product) 
        {
            $max_price = array_column($product, 'max_price');
            $min_price = array_column($product, 'min_price');
            $data['max_price'] = max($max_price);
            $data['min_price'] = min($min_price);
        }
        else
        {
            $data['max_price'] = 0;
            $data['min_price'] = 0;
        }
        if ($min && $max) 
        {
            foreach ($product as $key => $value) 
            {
                if ($value['min_price'] >= $min && $value['min_price'] <= $max && $value['max_price'] >= $min && $value['max_price'] <= $max) 
                {
                    // No Unset
                }
                else
                {
                    unset($product[$key]);
                }
            }
        }
        //Sort
        $sort = Request::input("sort");
        switch ($sort) 
        {
            case 'name_asc':
                usort($product, function($a, $b) 
                {
                    return $a['eprod_name'] <=> $b['eprod_name'];
                });
            break;

            case 'name_desc':
                usort($product, function($a, $b) 
                {
                    return $b['eprod_name'] <=> $a['eprod_name'];
                });
            break;

            case 'price_asc':
                usort($product, function($a, $b) 
                {
                    return $a['max_price'] <=> $b['max_price'];
                });
            break;

            case 'price_desc':
                usort($product, function($a, $b) 
                {
                    return $b['min_price'] <=> $a['min_price'];
                });
            break;

            case 'newest':
                usort($product, function($a, $b) 
                {
                    return $b['date_created'] <=> $a['date_created'];
                });
            break;
            
            default:
                usort($product, function($a, $b) 
                {
                    return $a['eprod_name'] <=> $b['eprod_name'];
                });
            break;
        }
        Pagination
        $perPage = 12;
        $data["current_count"] = count($product);
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