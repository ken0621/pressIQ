<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DB;
class ShopCompanyEventsController extends Shop
{
    

    public function company_events()
    {
        $data["page"] = "company_events";
        return view("company_events", $data);
    }

}