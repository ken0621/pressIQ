<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Session;
use DB;
use Carbon\Carbon;
use App\Models\Tbl_product;
use App\Globals\Ecom_Product;
use App\Models\Tbl_ec_product;
use App\Globals\Ec_wishlist;

class ShopProductContent2Controller extends Shop
{
    public function index($id)
    {
    	$data["page"]        		= "Product Content";
        $data["product"]     		= Ecom_Product::getProduct($id, $this->shop_info->shop_id);
        $data["category"]    		= Tbl_ec_product::category()->where("eprod_category_id", $data["product"]["eprod_category_id"])->first();
        $data["breadcrumbs"] 		= Ecom_Product::getProductBreadcrumbs($data["product"]["eprod_category_id"], $this->shop_info->shop_id);
        $data["_variant"]    		= Ecom_Product::getProductOption($id, ",");
        $data["_related"]    		= Ecom_Product::getAllProductByCategory($data["product"]["eprod_category_id"], $this->shop_info->shop_id);
        $data["_related"] 	 		= $this->filter_related($data["_related"], $data["product"]["eprod_id"]);
        $data["product"]["variant"] = $this->filter_variant($data["product"]["variant"]);

        return view("product_content", $data);
    }

    public function filter_related($related, $eprod_id)
    {
    	foreach ($related as $key => $value) 
        {
            if ($value["eprod_id"] == $eprod_id) 
            {
                unset($related[$key]);
            }
        }

        return $related;
    }

    public function filter_variant($variant)
    {
    	foreach ($variant as $keys => $values) 
        {
            // Convert to timestamp
            $start_ts = strtotime($values['item_discount_date_start']);
            $end_ts = strtotime($values['item_discount_date_end']);
            $user_ts = strtotime(date("Y-m-d H:i:s"));

            $result = (($user_ts >= $start_ts) && ($user_ts <= $end_ts));

            if ($result)
            {
                $variant[$keys]["discounted"] = true;
                $variant[$keys]["discounted_price"] = $values["item_discount_value"];

                if (isset($variant[$keys]["mlm_discount"])) 
                {
                    foreach ($variant[$keys]["mlm_discount"] as $key0 => $value0) 
                    {
                        if ($value0["discount_type"] == 0) 
                        {
                            $variant[$keys]["mlm_discount"][$key0]["discounted_amount"] = $values["item_discount_value"] - $value0['discount_value'];
                        }
                        else
                        {
                           $variant[$keys]["mlm_discount"][$key0]["discounted_amount"] = $values["item_discount_value"] - ($value0['discount_value'] / 100) * $values["item_discount_value"];
                        }                    
                    }
                }
            }
            else
            {
                $variant[$keys]["discounted"] = false;
            }

            $variant[$keys]["variant_image"] = Ecom_Product::getVariantImage($values["evariant_id"])->toArray();
        }

        return $variant;
    }
}