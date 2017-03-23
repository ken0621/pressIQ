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
        $data["page"]        = "Product Content";
        $data["product"]     = Ecom_Product::getProduct($id, $this->shop_info->shop_id);
        $data["category"]    = Tbl_ec_product::category()->where("eprod_category_id", $data["product"]["eprod_category_id"])->first();
        $data["breadcrumbs"] = Ecom_Product::getProductBreadcrumbs($data["product"]["eprod_category_id"], $this->shop_info->shop_id);
        $data["_variant"]    = Ecom_Product::getProductOption($id, ",");
        $data["_related"]    = Ecom_Product::getAllProductByCategory($data["product"]["eprod_category_id"], $this->shop_info->shop_id);

        foreach ($data["_related"] as $key => $value) 
        {
            if ($value["eprod_id"] == $data["product"]["eprod_id"]) 
            {
                unset($data["_related"][$key]);
            }
        }

        foreach ($data["product"]["variant"] as $keys => $values) 
        {
            // Convert to timestamp
            $start_ts = strtotime($values['item_discount_date_start']);
            $end_ts = strtotime($values['item_discount_date_end']);
            $user_ts = strtotime(date("Y-m-d H:i:s"));

            $result = (($user_ts >= $start_ts) && ($user_ts <= $end_ts));

            if ($result)
            {
                $data["product"]["variant"][$keys]["discounted"] = true;
                if ($values["item_discount_type"] == "fixed") 
                {
                    $data["product"]["variant"][$keys]["discounted_price"] = $values['evariant_price'] - $values["item_discount_value"];
                }
                else
                {
                    $data["product"]["variant"][$keys]["discounted_price"] = $values['evariant_price'] - ((100 - $values["item_discount_value"]) / 100);
                }
            }
            else
            {
                $data["product"]["variant"][$keys]["discounted"] = false;
            }

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

    public function search()
    {
        $search = Ecom_Product::searchProduct(Request::input("search-pokus"), $this->shop_info->shop_id);

        return json_encode($search);
    }
}