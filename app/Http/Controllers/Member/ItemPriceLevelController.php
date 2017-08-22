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
        Tbl_price_level::insert($insert_price_level);

        /* INSERT PRIVE LEVEL ITEMS */
        $_insert = array();
        foreach(Request::input("_item") as $item_id => $custom_price)
        {
            if($custom_price != "")
            {
                $insert["price_level_id"]   = $price_level_id;
                $insert["item_id"]          = $item_id;
                $insert["custom_price"]     = $custom_price;
                $insert["shop_id"]          = $this->user_info->shop_id;
                array_push($_insert, $insert);
            }
        }

        if($_insert)
        {
            Tbl_price_level_item::insert($insert);
        }

        $return["call_function"] = "new_price_level_save_done";
        echo json_encode($return);
    }
}

/*

TODO:
- BULK PRICE ADJUST (REFER TO QUICK BOOKS SOFTWARE FOR THE DEVELOPMENT)
- MARK ALL CHECKBOX

*/
