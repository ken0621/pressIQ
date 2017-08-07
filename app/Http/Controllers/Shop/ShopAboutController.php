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

    public function promos()
    {
        $data["page"] = "promos";
        return view("promos", $data);
    }

    public function promo_view()
    {
        $data["page"] = "promo_view";
        return view("promo_view", $data);
    }

    public function history()
    {
        $data["page"] = "history";
        return view("history", $data);
    }

    public function how_to_join()
    {
        $data["page"] = "how_to_join";
        return view("how_to_join", $data);
    }
    public function xcell_login()
    {
        $data["page"] = "3xcell_login";
        return view("3xcell_login", $data);
    }    

    public function job()
    {
        if (Request::input("id") !== null) 
        {
            $data["page"] = "job";
            $content = DB::table("tbl_content")->where("key", "job_maintenance")->where("type", "maintenance")->where("shop_id", $this->shop_info->shop_id)->first();
            if ($content) 
            {
                if (is_serialized($content->value)) 
                {
                    if (isset(unserialize($content->value)[Request::input("id")])) 
                    {
                        $data["job"] = unserialize($content->value)[Request::input("id")];
                    }
                    else
                    {
                        return Redirect::to("/jobs");
                    }
                }
                else
                {
                    return Redirect::to("/jobs");
                }
            }

            return view("job", $data);
        }
        else
        {
            return Redirect::to("/jobs");
        }
    }

}