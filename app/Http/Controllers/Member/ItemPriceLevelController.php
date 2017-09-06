<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;
use Request;

class ItemPriceLevelController extends Member
{
    public function index()
    {
        $data["page"]   = "Price Level - List";
        return view("member.price_level.price_level_list", $data);
    }
    public function add()
    {
        $data["page"]           = "Price Level - Add";
        $data["_item"]          = Item::get($this->user_info->shop_id);
        return view("member.price_level.price_level_add", $data);
    }
    public function add_submit()
    {
        $return["call_function"]        = "new_price_level_save_done";
        $return["status"]               = "success";
        $return["price_level_id"]       = $price_level_id = Item::insert_price_level($this->user_info->shop_id, Request::input("price_level_name"), Request::input("price_level_type"), Request::input("fixed-percentage-mode"),  Request::input("fixed-percentage-source"), Request::input("fixed-percentage-value"));
        $return["price_level_name"]     = Request::input("price_level_name");
        
        Item::insert_price_level_item($this->user_info->shop_id, $price_level_id, Request::input("_item"));
        echo json_encode($return);
    }
}