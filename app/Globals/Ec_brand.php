<?php
namespace App\Globals;
use DB;
use App\Models\Tbl_manufacturer;
use App\Models\Tbl_item;
use App\Globals\Ecom_Product;
use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Crypt;
use Carbon\Carbon;

class Ec_brand
{
    /**
     * Get all brands
     *
     * @return array      List of Brands
     */
    public static function getBrands($shop_id)
    {
        if ($shop_id) 
        {
            $brand = Tbl_manufacturer::where("manufacturer_shop_id", $shop_id)->where("archived", 0)->get();
        }
        else
        {
            return null;
        }
    }
    /**
     * Get product by brands
     *
     * @return array      List of Product by Brands
     */
    public static function getBrands($manufacturer_id, $shop_id)
    {
        if ($shop_id) 
        {
            $product = Tbl_ec_product::where("tbl_ec_product.archived", 0)->where("tbl_ec_product.eprod_shop_id")->scopeVariant()->get();
            dd($product);
        }
        else
        {
            return null;
        }
    }
}