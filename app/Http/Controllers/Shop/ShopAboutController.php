<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DB;
class ShopAboutController extends Shop
{
    public function index()
    {
        $data["page"] = "About";
        return view("about", $data);
    }

    public function runruno()
    {
    	$data["page"] = "Runruno";
    	return view("runruno", $data);
    }

    public function news()
    {
        $data["page"] = "news";
        $id = Request::input("id");
        $data["main_news"] = DB::table("tbl_post")->where("post_id", $id)->first();
        if (!isset($data["main_news"])) 
        {
            return Redirect::to("/");
        }
        return view("news", $data);
    }

    public function contactus()
    {
        $data["page"] = "contactus";
        return view("contactus", $data);
    }

    public function jobs()
    {
        $data["page"] = "jobs";
        return view("jobs", $data);
    }
}