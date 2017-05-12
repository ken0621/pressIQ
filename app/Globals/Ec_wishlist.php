<?php
namespace App\Globals;
use DB;
use App\Models\Tbl_ec_wishlist;

use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Carbon\Carbon;

use App\Globals\Ecom_Product;

class Ec_wishlist
{
    public static function getProduct($customer_id, $shop_id)
    {
        $wishlist = Tbl_ec_wishlist::where("customer_id", $customer_id)->where("shop_id", $shop_id)->where("archived", 0)->get();
        foreach ($wishlist as $key => $value) 
        {
            $wishlist[$key]->product = Ecom_Product::getProduct($value->product_id);
        }

        return $wishlist;
    }
    public static function addProduct($product_id, $customer_id, $shop_id)
    {
        $insert["customer_id"] = $customer_id;
        $insert["product_id"] = $product_id;
        $insert["shop_id"] = $shop_id;
        $insert["date"] = Carbon::now();

        $exist = Tbl_ec_wishlist::where("customer_id", $customer_id)->where("product_id", $product_id)->where("shop_id", $shop_id)->delete();

        Tbl_ec_wishlist::insert($insert);
    }
    public static function removeProduct($wishlist_id, $shop_id)
    {
        Tbl_ec_wishlist::where("id", $wishlist_id)->where("shop_id", $shop_id)->update( [ "archived" => 1 ] );
    }
}