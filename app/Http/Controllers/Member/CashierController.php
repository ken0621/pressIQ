<?php
namespace App\Http\Controllers\Member;
use App\Globals\Cart2;
use App\Globals\Item;
use Request;

class CashierController extends Member
{
    public function pos()
    {
        Cart2::set_cart_key("cashier-" . $this->user_info->user_id);
    	$data["page"]           = "Point of Sale";
        $data["cart"]           = $_items = Cart2::get_cart_info();
        $data["_price_level"]   = Item::list_price_level($this->user_info->shop_id);
        $data["current_level"]  = ($data["cart"]["info"] ? $data["cart"]["info"]->price_level_id : 0);
        
       	return view("member.cashier.pos", $data);
    }
    public function pos_table_item()
    {
    	$data["cart_key"]   = $cart_key = Cart2::get_cart_key();
        $data["cart"]       = $_items = Cart2::get_cart_info();
    	return view("member.cashier.pos_table_item", $data);
    }
    public function pos_search_item()
    {
        $data["page"]    = "POS Search Results";
        $data["shop_id"] = $this->user_info->shop_id;
        $data["keyword"] = Request::input("item_keyword");

        Item::get_search($data["keyword"]);
        $data["_item"]   = Item::get($data["shop_id"]);
        return view("member.cashier.pos_search_item", $data);
    }
    public function pos_scan_item()
    {
        $data["shop_id"]    = $shop_id = $this->user_info->shop_id;
        $data["item_id"]    = $item_id = Request::input("item_id");
        $data["item"]       = $item = Cart2::scan_item($data["shop_id"], $data["item_id"]);

        if($data["item"])
        {
            $return["status"]   = "success";
            $return["message"]  = "Item Number " .  $item->item_id . " has been added.";
            Cart2::add_item_to_cart($shop_id, $item_id, 1);
        }
        else
        {
            $return["status"]   = "error";
            $return["message"]  = "The ITEM you scanned didn't match any record.";
        }

        echo json_encode($return);
    }
    public function set_cart_info($key, $value)
    {
        $cart_key           = Cart2::get_cart_key();
        $set_info_status    = Cart2::set($key, $value);
        echo json_encode($set_info_status);
    }
    public function pos_remove_item()
    {
        $item_id = Request::input("item_id");
        Cart2::delete_item_from_cart($item_id);
        $return["status"] = "success";
        $return["item_id"] = $item_id;
        echo json_encode($return);
    }
}