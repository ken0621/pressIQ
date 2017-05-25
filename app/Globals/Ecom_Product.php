<?php
namespace App\Globals;
use DB;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use App\Models\Tbl_category;
use App\Models\Tbl_ec_product;
use App\Models\Tbl_ec_variant;
use App\Models\Tbl_variant_name;
use App\Models\Tbl_option_name;
use App\Models\Tbl_option_value;
use App\Models\Tbl_ec_variant_image;
use App\Models\Tbl_collection_item;
use App\Models\Tbl_warehouse;

use App\Globals\Mlm_discount;

use Request;
use Session;
use Validator;
use Redirect;

/**
 * Acommerce Products and Variants - all product of ecommerce related module
 *
 * @author Bryan Kier Aradanas
 */

class Ecom_Product
{
	/**
	 * Get the id of current shop_id that logged in.
	 *
	 * @return int 		Shop id
	 */
	public static function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
	}

	/**
	 * Get the id of default Ecommerce Warehouse 
	 *
	 * @return int 		Warehouse ID
	 */
	public static function getWarehouseId($shop_id = null)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		return Tbl_warehouse::where("main_warehouse", 2)->where("warehouse_shop_id", $shop_id)->pluck('warehouse_id');
	}

	/**
	 * Getting all Product w/ variants and options. If shop_id is null, the current shop id that logged on will be used.
	 *
	 * @param int    $shop_id 	Shop id of the products that you wnat to get. null if auto get
	 */
	public static function getAllProduct($shop_id = null)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}
		
		$_product = Tbl_ec_product::where("eprod_shop_id", $shop_id)->where("archived", 0)->get()->toArray();
		
		foreach($_product as $key=>$product)
		{
			$_product[$key]			 	= Ecom_Product::getProduct($product["eprod_id"], $shop_id);
			// $_product[$key]["variant"] = Tbl_ec_variant::where("evariant_prod_id", $product["eprod_id"])->get()->toArray();

			// foreach($_product[$key]["variant"] as $key2=>$variant)
			// {
			// 	$variant_option_name = Tbl_variant_name::nameOnly()->where("variant_id", $variant["evariant_id"])->get()->toArray();
				
			// 	foreach($variant_option_name as $key3=>$option_name)
			// 	{
			// 		$variant_option_value = Tbl_option_value::where("option_value_id", $option_name["option_value_id"])->first()->toArray();
			// 		$_product[$key]["variant"][$key2]["options"][$option_name['option_name']] = $variant_option_value["option_value"];
			// 	}
			// }
		}
		
		return $_product;
	}

	/**
	 * Getting all Product Searched w/ variants and options. If shop_id is null, the current shop id that logged on will be used.
	 *
	 * @param int    $shop_id 	Shop id of the products that you wnat to get. null if auto get
	 */
	public static function getAllProductSearch($search, $shop_id = null)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		$get_popular_tag = DB::table("tbl_ec_popular_tags")->where("keyword", $search)->where("shop_id", $shop_id)->first();
		if ($get_popular_tag) 
		{
			$insert_tags["count"]   = $get_popular_tag->count + 1;

			DB::table("tbl_ec_popular_tags")->where("keyword", $search)->where("shop_id", $shop_id)->update($insert_tags);
		}
		else
		{
			$insert_tags["count"] = 1;
			$insert_tags["keyword"] = $search;
			$insert_tags["shop_id"] = $shop_id;

			DB::table("tbl_ec_popular_tags")->insert($insert_tags);
		}
		
		$_product = Tbl_ec_product::where("eprod_shop_id", $shop_id)->where('eprod_name', 'like', "%{$search}%")->where("archived", 0)->get()->toArray();
		
		foreach($_product as $key=>$product)
		{
			$_product[$key]	= Ecom_Product::getProduct($product["eprod_id"], $shop_id);
		}
		
		return $_product;
	}

	/**
	 * Getting all Product w/ cateogry, variants and options. If shop_id is null, the current shop id that logged on will be used.
	 * 
	 * @param int    $shop_id 	Shop id of the products that you wnat to get. null if auto get
	 */
	public static function getAllCategoryProduct($shop_id = null)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}
		
		return Ecom_Product::getItemPerSub($shop_id, 0);
	}
	
	public static function getItemPerSub($shop_id, $category_id)
	{
		$_category = Tbl_category::product()->where("type_shop", $shop_id)->where("type_parent_id", $category_id)->where("tbl_category.archived",0)->get()->toArray();

		foreach($_category as $key0=>$category)
		{
			$_product = Tbl_ec_product::where("eprod_category_id", $category["type_id"])->where("archived",0)->get()->toArray();
		
			foreach($_product as $key1=>$product)
			{
				$_product[$key1]			   = $product;
				$_product[$key1]["variant"] = Tbl_ec_variant::where("evariant_prod_id", $product["eprod_id"])->get()->toArray();

				foreach($_product[$key1]["variant"] as $key2=>$variant)
				{
					$variant_option_name = Tbl_variant_name::nameOnly()->where("variant_id", $variant["evariant_id"])->get()->toArray();
					$_product[$key1]["variant"][$key2]["image"] = Tbl_ec_variant_image::where("eimg_variant_id", $variant["evariant_id"])->get()->toArray();

					foreach($variant_option_name as $key3=>$option_name)
					{
						$variant_option_value = Tbl_option_value::where("option_value_id", $option_name["option_value_id"])->first()->toArray();
						$_product[$key1]["variant"][$key2]["options"][$option_name['option_name']] = $variant_option_value["option_value"];
					}
				}
			}

			$_category[$key0]["Product"]		= $_product;
			
			$_category[$key0]["subcategory"]	= Ecom_Product::getItemPerSub($shop_id, $category["type_id"]);
		}

		return $_category;
	}

	public static function getAllProductByCategory($category_id, $shop_id = null)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		return Ecom_Product::getAllProductPerCategory($category_id, $shop_id, []);
	}
	public static function getAllProductPerCategory($category_id, $shop_id, $_product_value)
	{
		$_product = Tbl_ec_product::category()->where("eprod_category_id", $category_id)->where("tbl_ec_product.archived",0)->get()->toArray();

		foreach($_product as $key=>$product)
		{
			$_product_value[$category_id."-".$key] = Ecom_Product::getProduct($product["eprod_id"], $shop_id);
			if($_product_value[$category_id."-".$key] == null) unset($_product_value[$category_id."-".$key]);
		}

		$_category = Tbl_category::product()->where("type_shop", $shop_id)->where("type_parent_id", $category_id)->where("tbl_category.archived",0)->get()->toArray();
		foreach($_category as $key=>$category)
		{	
			$_product_value	= Ecom_Product::getAllProductPerCategory($category["type_id"], $shop_id, $_product_value);
		}

		return $_product_value;
	}

	public static function getAllCategory($shop_id = null)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}
		
		return Ecom_Product::getCategoryPerSub($shop_id, 0, 0);
	}
	public static function getCategoryPerSub($shop_id, $category_id, $ctr)
	{
		$_category = Tbl_category::where("type_shop", $shop_id)->where("type_parent_id", $category_id)->where("tbl_category.archived",0)->get()->toArray();

		foreach($_category as $key=>$category)
		{	
			$_category[$key]["product_count"]	= Tbl_ec_product::where("eprod_category_id", $category["type_id"])->where("archived",0)->count();
			$ctr += $_category[$key]["product_count"] == 0 ? -$ctr : $_category[$key]["product_count"];
			$_category[$key]["products"] = $ctr;
			
			$_category[$key]["subcategory"] = Ecom_Product::getCategoryPerSub($shop_id, $category["type_id"], $ctr);

			if(!$_category[$key]["subcategory"] && $ctr == 0)
			{
				unset($_category[$key]);
			}
		}
		return $_category;
	}

	/**
	 * Getting specific product. If shop_id is null, the current shop id that logged on will be used.
	 * B
	 * @param int    $product_id 	Product ID of the specific product.
	 * @param int    $shop_id 		Shop id of the products that you wnat to get. null if auto get
	 */
	public static function getProduct($product_id, $shop_id = null)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		$product = Tbl_ec_product::price()->where("eprod_id", $product_id)->where("tbl_ec_product.archived",0)->first();

		if($product)
		{
			$product = collect($product)->toArray();
			$product			   	= $product;
			$product["variant"] 	= Tbl_ec_variant::select("*")->item()->inventory(Ecom_Product::getWarehouseId($shop_id))->where("evariant_prod_id", $product["eprod_id"])->get()->toArray();

			foreach($product["variant"] as $key2=>$variant)
			{
				$variant_option_name = Tbl_variant_name::nameOnly()->where("variant_id", $variant["evariant_id"])->get()->toArray();
				$product["variant"]["$key2"]["mlm_discount"] = Ecom_Product::getMlmDiscount($shop_id, $variant["evariant_item_id"], $variant["evariant_price"]);
				$product["variant"]["$key2"]["image"] = Tbl_ec_variant_image::path()->where("eimg_variant_id", $variant["evariant_id"])->get()->toArray();

				foreach($variant_option_name as $key3=>$option_name)
				{
					$variant_option_value = Tbl_option_value::where("option_value_id", $option_name["option_value_id"])->first()->toArray();
					$product["variant"][$key2]["options"][$option_name['option_name']] = $variant_option_value["option_value"];
				}
			}
		}

		return $product;
	}
	public static function getMlmDiscount($shop_id, $item_id, $product_price)
	{
		$_discount = Mlm_discount::get_discount_all_membership($shop_id, $item_id);
		
		if($_discount['status'] == "success")
		{
			$data = null;
			$ctr  = 0;
			foreach($_discount['discount'] as $key=>$discount)
			{
				$discount_value = $discount['value'];
				if($discount['type'] == 1) $discount_value = ($discount['value'] / 100) * $product_price;

				$data[$ctr]["discount_name"]  = $key;
				$data[$ctr]["discount_value"] = $discount['value'];
				$data[$ctr]["discount_type"]  = intval($discount['type']);
				$data[$ctr]["discounted_amount"] = $product_price - $discount_value;
				$ctr++;
			}
		}
		else
		{
			return null;
		}

		return $data;
	}

	public static function getProductOption($product_id = null, $separator = ' • ')
	{
		if($product_id)
		{
			return Tbl_ec_product::variantOption($separator)->where("eprod_id", $product_id)->get()->toArray();
		}
		else
		{
			return Tbl_ec_product::variantOption($separator)->get()->toArray();
		}
	}

	public static function getVariant($name, $product_id, $separator = ' • ')
	{
		$shop_id = Tbl_ec_product::where("eprod_id", $product_id)->pluck("eprod_shop_id");
		return Tbl_ec_variant::variantName($separator)->item()->inventory(Ecom_Product::getWarehouseId($shop_id))->having("evariant_prod_id", "=", $product_id)->having("variant_name", "=", $name)->first();
	}

	public static function getVariantInfo($variant_id)
	{
		$shop_id = Tbl_ec_variant::product()->where("evariant_id", $variant_id)->pluck("eprod_shop_id");
		return Tbl_ec_variant::variantName()->item()->inventory(Ecom_Product::getWarehouseId($shop_id))->where("evariant_id", $variant_id)->Product()->FirstImage()->first();
	}

	public static function getAllVariants()
	{
		return Tbl_ec_variant::variantName()->product()->where("eprod_shop_id", Ecom_Product::getShopId())->get()->toArray();
	}

	/**
	 * Getting all image of specific variant
	 *
	 * @param int   $variant_id 	Unique Id of the specific variant of a product
	 */
	public static function getVariantImage($variant_id)
	{
		return Tbl_ec_variant::where("evariant_id", $variant_id)->imageOnly()->get();
	}

	public static function getProductCollection($collection_id, $shop_id = null)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		$collection = Tbl_collection_item::where("tbl_collection_item.collection_id", $collection_id)
										 ->where("tbl_collection_item.hide", 0)
										 ->where("tbl_collection_item.archived", 0)
										 ->where("tbl_collection.shop_id", $shop_id)
										 ->leftJoin("tbl_collection", "tbl_collection_item.collection_id", "=", "tbl_collection.collection_id")
										 ->get();
	
		foreach ($collection as $key => $value) 
		{
			$product = Ecom_Product::getProduct($value->ec_product_id, $shop_id);

			$collection[$key]->product = $product;
		}
		
		return $collection;
	}

	/**
	 * Getting all Product w/ cateogory only. If shop_id is null, the current shop id that logged on will be used.
	 *
	 * @param  int    $shop_id 		Shop id of the products that you want to get. null if auto get
	 * @param  array  $archived 	product status of the item. Default is not archived
	 * @return array  [Product name : variation (if any)] -> "Product 1 : blue • small" or "Product 1"
	 */
	public static function getProductList($shop_id = null, $archived = [0])
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		return Ecom_Product::getProductPerSub($shop_id, 0, $archived);
	}
	public static function getProductPerSub($shop_id, $category_id, $archived)
	{
		$_category = Tbl_category::product()->where("type_shop", $shop_id)->where("type_parent_id", $category_id)->where("tbl_category.archived", 0)->get()->toArray();

		foreach($_category as $key0=>$category)
		{
			$_product = Tbl_ec_product::variant()->where("eprod_category_id", $category["type_id"])->whereIn("tbl_ec_product.archived", $archived)->get()->toArray();
		
			foreach($_product as $key1=>$product)
			{
				$_product[$key1]["product_new_name"] = $product["eprod_name"] . ($product["variant_name"] ? ' : '.$product["variant_name"] : '');
			}

			$_category[$key0]["Product"]		= $_product;
			
			$_category[$key0]["subcategory"]	= Ecom_Product::getProductPerSub($shop_id, $category["type_id"], $archived);
		}

		return $_category;
	}

	public static function getVariantFullName($variant_id)
	{
		$_product = Tbl_ec_product::variant()->first()->toArray();

		$_product["product_new_name"] = $product["eprod_name"] . ($product["variant_name"] ? ' : '.$product["variant_name"] : '');

		return $_product["product_new_name"];
	}

	/**
	 * Getting all Product w/ a specific category name regardless of the level, thus product with the same category name
	 *
	 * @param  int    $shop_id 	  Shop id of the products that you wnat to get. null if auto get
	 * @param  string $type_name  Name of the category
	 * @return array  Porduct Details
	 */
	public static function getProductByCategoryName($type_name, $shop_id = null)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		$_products = Tbl_ec_product::Category()->where("eprod_shop_id", $shop_id)->where("type_name", $type_name)->where("tbl_ec_product.archived", 0)->get()->toArray();

		Foreach($_products as $key=>$product)
		{
			$_products[$key]	= Ecom_Product::getProduct($product["eprod_id"], $shop_id);
		}

        return $_products;     
    }

	/**
	 * Getting all category for breadcrumbs.
	 *
	 * @param  int    $category_id 	Shop id of the products that you wnat to get. null if auto get
	 * @param  int    $shop_id 	Shop id of the products that you wnat to get. null if auto get
	 */
	public static function getProductBreadcrumbs($category_id, $shop_id)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		$current = $category_id;
		$stop = 0;
		$ctr = 0;
		$category = [];

		while ($stop == 0) 
		{ 
			$get_parent = Tbl_category::where("type_shop", $shop_id)->where("type_id", $current)->first();

			if ($get_parent) 
			{
				$current = $get_parent->type_parent_id;

				$category[$ctr]['type_name'] = $get_parent->type_name;
				$category[$ctr]['type_id'] = $get_parent->type_id;

				if ($get_parent->type_parent_id == 0) 
				{
					$stop++;
					break;
				}
			}
			else
			{
				$stop++;
				break;
			}

			$ctr++;
		}
		
		return $category;
	}

	/**
	 * Search product by keywords.
	 *
	 * @param  int    $keywords Keywords to search in products.
	 * @param  int    $shop_id 	Shop id of the products that you want to get. null if auto get
	 */
	public static function searchProduct($keywords, $shop_id)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		$product = Tbl_ec_product::price()->where('eprod_name', 'like', "%{$keywords}%")
										  ->where('eprod_shop_id', $shop_id)
										  ->where("tbl_ec_product.archived", 0)
										  ->get();

		if($product)
		{
			$product = collect($product)->toArray();
			$product = $product;
			foreach ($product as $key => $value) 
			{
				$product[$key]['variant'] = Tbl_ec_variant::select("*")->item()->inventory(Ecom_Product::getWarehouseId($shop_id))->where("evariant_prod_id", $value["eprod_id"])->get()->toArray();
				
				$update["eprod_search_count"] = $value["eprod_search_count"] + 1;
				Tbl_ec_product::where("eprod_id", $value["eprod_id"])->update($update);
			}
		}

		return $product;
	}

	/**
	 * Get most searched product per shop.
	 *
	 * @param  int    $shop_id 	Shop id of the products that you want to get. null if auto get
	 * @param  int    $limit    Limit of product to show.
	 */
	public static function getMostSearched($limit, $shop_id)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}

		$product = Tbl_ec_product::price()->where('eprod_shop_id', $shop_id)
										  ->where("tbl_ec_product.archived", 0)
										  ->orderBy('tbl_ec_product.eprod_search_count', 'DESC')
										  ->take($limit)
										  ->get();

		if($product)
		{
			$product = collect($product)->toArray();
			$product = $product;

			foreach ($product as $key => $value) 
			{
				$product[$key]['variant'] = Tbl_ec_variant::select("*")->item()->inventory(Ecom_Product::getWarehouseId($shop_id))->where("evariant_prod_id", $value["eprod_id"])->get()->toArray();
				foreach($product[$key]["variant"] as $key2=>$variant)
				{
					$variant_option_name = Tbl_variant_name::nameOnly()->where("variant_id", $variant["evariant_id"])->get()->toArray();
					$product[$key]["variant"][$key2]["mlm_discount"] = Ecom_Product::getMlmDiscount($shop_id, $variant["evariant_item_id"], $variant["evariant_price"]);
					$product[$key]["variant"][$key2]["image"] = Tbl_ec_variant_image::path()->where("eimg_variant_id", $variant["evariant_id"])->get()->toArray();

					foreach($variant_option_name as $key3=>$option_name)
					{
						$variant_option_value = Tbl_option_value::where("option_value_id", $option_name["option_value_id"])->first()->toArray();
						$product[$key]["variant"][$key2]["options"][$option_name['option_name']] = $variant_option_value["option_value"];
					}
				}
			}
		}

		return $product;
	}


	public static function searchProName($keywords, $shop_id)
	{
		if(!$shop_id)
		{
			$shop_id = Ecom_Product::getShopId();
		}
		
		$_product = Tbl_ec_product::where("eprod_name", 'like', "%{$keywords}%")
				->where('tbl_ec_product.archived', 0)
				->where('eprod_id', "!=", "")
				->where('eprod_shop_id', $shop_id)
				->get()
				->toArray();
		
	
		foreach($_product as $key=>$product)
		{
			$_product[$key]	 = Ecom_Product::getProduct($product["eprod_id"], $shop_id);
		}
		return $_product;	
	}
	

}