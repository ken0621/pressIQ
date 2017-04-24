<?php
use App\Globals\Ecom_Product;
use App\Globals\Settings;
function get_post($shop_id, $key)
{
    $post_id = explode(",", DB::table("tbl_content")->where("key", $key)->where("shop_id", $shop_id)->first()->value);

    $post = DB::table("tbl_post")->where("archived", 0)->where("shop_id", $shop_id)->get();
    foreach ($post as $key => $value) 
    {
        foreach ($post_id as $keys => $values) 
        {
            if ($values != $value->post_id) 
            {
                unset($post[$key]);
            }
        }
    }

    return $post;
}

function get_content($data, $tab, $content, $default = "")
{
    $response = $data->$tab->$content->default;

    return $response ? $response : $default;
}

function get_collection($collection_id, $shop_id = null)
{
    $collection = Ecom_Product::getProductCollection($collection_id, $shop_id);
    foreach ($collection as $key => $value) 
    {
        if (!isset($value["product"]["variant"][0])) 
        {
            unset($collection[$key]);
        }
    }

    return $collection;
}

function get_collection_first_name($data)
{
    return $data['product']['eprod_name'] ? $data['product']['eprod_name'] : '';
}

function get_collection_first_image($data)
{
    if(isset($data['product']['variant'][0]))
    {
        return $data['product']['variant'][0]['image'] ? $data['product']['variant'][0]['image'][0]['image_path'] : '';
    }
    else
    {
        return '';
    }
}

function get_collection_first_price($data)
{
    if (isset($data['product']['min_price']) && isset($data['product']['max_price'])) 
    {
        return $data['product']['min_price'] == $data['product']['max_price'] ? "&#8369; " . number_format($data['product']['max_price'], 2) : "&#8369; " . number_format($data['product']['min_price'], 2) . " - " . number_format($data['product']['max_price'], 2);
    }
    else
    {
        return "&#8369; 0.00";
    }
}

function get_product_first_name($data)
{
    return isset($data['eprod_name']) ? $data['eprod_name'] : '';
}

function get_product_first_description($data)
{
    if (isset($data['variant'][0])) 
    {
        return $data['variant'][0]['evariant_description'] ? $data['variant'][0]['evariant_description'] : '';
    }
    else
    {
        return '';
    }
}

function get_product_first_price($data, $shop_id = 1)
{
    $currency = Settings::get_currency($shop_id);
    if (isset($data['min_price']) && isset($data['max_price'])) 
    {
        return $data['min_price'] == $data['max_price'] ? "&#8369; " . number_format($data['max_price'], 2) : "&#8369; " . number_format($data['min_price'], 2) . " - " . number_format($data['max_price'], 2);
    }
    else
    {
        return "&#8369; 0.00";
    }
}

function get_product_first_image($data)
{
    if (isset($data['variant'][0])) 
    {
        return $data['variant'][0]['image'] ? $data['variant'][0]['image'][0]['image_path'] : '';
    }
    else
    {
        return '';
    }   
}