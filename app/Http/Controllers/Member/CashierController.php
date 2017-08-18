<?php
namespace App\Http\Controllers\Member;
use App\Globals\Cart2;
use Request;

class CashierController extends Member
{
    public function pos()
    {
    	$data["page"] = "Point of Sale";
    	Cart2::set_cart_key("cashier-" . $this->user_info->user_id);

       	return view("member.cashier.pos", $data);
    }
    public function pos_table_item()
    {
    	$data["cart_key"]   = $cart_key = Cart2::get_cart_key();
        $data["_items"]     = $_items = Cart2::get_cart_items();
        $data["totals"]     = $totals = Cart2::get_cart_totals();

    	return view("member.cashier.pos_table_item", $data);
    }
    public function pos_search_item()
    {
        $data["page"]    = "POS Search Results";
        $data["shop_id"] = $this->user_info->shop_id;
        $data["keyword"] = Request::input("item_keyword");
        $data["_item"]   = Cart2::search_item($data["shop_id"], $data["keyword"]);

        return view("member.cashier.pos_search_item", $data);
    }
    public function scan_item()
    {
        
    }
}