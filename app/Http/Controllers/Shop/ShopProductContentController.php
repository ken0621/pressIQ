<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Models\Tbl_product;
use App\Globals\Ecom_Product;
use App\Models\Tbl_ec_product;

class ShopProductContentController extends Shop
{
    public function index($id)
    {
        $data["page"]     = "Product Content";
        $data["product"]  = Ecom_Product::getProduct($id, $this->shop_info->shop_id);
        $data["category"] = Tbl_ec_product::category()->where("eprod_category_id", $data["product"]["eprod_category_id"])->first();
        $data["_variant"] = Ecom_Product::getProductOption($id, ",");
        $data["_related"] = Ecom_Product::getAllProductByCategory($data["product"]["eprod_category_id"], $this->shop_info->shop_id);
        
        foreach ($data["product"]["variant"] as $keys => $values) 
        {
            $data["product"]["variant"][$keys]["variant_image"] = Ecom_Product::getVariantImage($values["evariant_id"])->toArray();
        }

        return view("product_content", $data);
    }

    public function variant()
    {
        $name    = implode(",", Request::input("variation"));
        $variant = Ecom_Product::getVariant($name, Request::input("product_id"), ",");

        if ($variant)
        {
            $response["variation"] = $variant->toArray();
            $response["result"] = "success";
        }
        else
        {
            $response["result"] = "fail";
        }

        echo json_encode($response);
    }
}