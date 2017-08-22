<?php
namespace App\Http\Controllers\Member;
use App\Globals\Cart2;
use Request;

class ItemPriceLevelController extends Member
{
    public function index()
    {
        $data["page"] = "Price Level - List";
        return view("member.price_level.price_level_list", $data);
    }
    public function add()
    {
        $data["page"] = "Price Level - Add";
        return view("member.price_level.price_level_add", $data);
    }
}