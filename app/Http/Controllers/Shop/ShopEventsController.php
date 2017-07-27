<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;

use Crypt;
use Redirect;
use Request;
use View;

use App\Models\Tbl_post;
use App\Globals\Post;

class ShopEventsController extends Shop
{
    public function index()
    {
        $data["page"] = "Events";
        $data["_post"] = Post::get_posts($this->shop_info->shop_id);

        return view("events", $data);
    }

    public function view($id)
    {
    	$data["page"] = "Events View";
    	$data["post"] = Post::get_post($id, $this->shop_info->shop_id);
    	$data["_related"] = Post::get_related_posts($data["post"]->post_category_id, $this->shop_info->shop_id);

    	return view("events_view", $data);
    }
}