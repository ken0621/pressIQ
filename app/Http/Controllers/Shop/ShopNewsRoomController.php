<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

class ShopNewsRoomController extends Shop
{
    public function index()
    {
        $data["page"] = "News Room";
        return view("news_room", $data);
    }
    public function news_room_view()
    {
        $data["page"] = "News Room";
        return view("news_room_view", $data);
    }
}