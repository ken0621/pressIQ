<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
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
        return view("news", $data);
    }

    public function contactus()
    {
        $data["page"] = "contactus";
        return view("contactus", $data);
    }
}