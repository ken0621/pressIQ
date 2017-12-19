<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DB;

use App\Tbl_pressiq_press_releases;

class ShopNewsRoomController extends Shop
{
    public function index()
    {
        $pr = DB::table('tbl_pressiq_press_releases')
                ->where('pr_status', "sent")
                ->orderByRaw('pr_date_sent DESC')
                ->get();

        $data["pr"]=$pr;
        $data["page"] = "News Room";
        return view("news_room", $data);
    }
    public function news_room_view($pid)
    {
        $pr = DB::table('tbl_pressiq_press_releases')
                ->where('pr_id', $pid)
                ->get();

        $data["pr"]=$pr;
        $data["page"] = "News Room";
        return view("news_room_view", $data);
    }
}