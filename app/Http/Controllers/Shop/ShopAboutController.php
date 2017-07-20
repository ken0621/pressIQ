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
        $data["page"] = "Contact Us";
        return view("contactus", $data);
    }

    public function email_payment()
    {
        $data["page"] = "Email Payment";
        return view("email_payment", $data);
    }

    /*ROMMEL CUNETA START*/
    public function products()
    {
        $data["page"] = "Products";
        return view("products", $data);
    }

    public function company()
    {
        $data["page"] = "Company";
        return view("company", $data);
    }

    public function contact()
    {
        $data["page"] = "Contacts";
        return view("contact", $data);
    }
    /*ROMMEL CUNETA END*/
}