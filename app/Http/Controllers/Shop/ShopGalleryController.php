<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DB;
class ShopGalleryController extends Shop
{
    

    public function gallery()
    {
        $data["page"] = "gallery";
        return view("gallery", $data);
    }

    public function gallery_content()
    {
        $data["page"] = "gallery_content";
        return view("gallery_content", $data);
    }    

}