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
        $data["page"]   = "Price Level - Add";
        $data["_item"]  = Item::get_all_item($this->user_info->shop_id);
        return view("member.price_level.price_level_add", $data);
    }
    public function add_submit()
    {
        $return["status"] = "success";

        /* INSERT PRICE LEVEL */
        $insert_price_level["price_level_name"] = Request::input("price_level_name");
        $insert_price_level["price_level_type"] = Request::input("price_level_type");
        $insert_price_level["fixed_percentage_mode"] = Request::input("fixed-percentage-mode");
        $insert_price_level["fixed_percentage_source"] = Request::input("fixed-percentage-source");
        $price_level_id = Item::insert_price_level($this->user_info->shop_id, $insert_price_level);
        Item::insert_price_level_items($this->user_info->shop_id, $price_level_id, Request::input("_item"));
        $return["call_function"] = "new_price_level_save_done";
        echo json_encode($return);
    }
}