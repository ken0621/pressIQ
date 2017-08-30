<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DOMDocument;
use Config;
use DB;
use Response;
use Input;
use App\Globals\Mail_global;
use App\Models\Tbl_user;
use App\Models\Tbl_email_template;
use App\Models\Tbl_partners;

class ShopPartnersController extends Shop
{
    public function index()
    {
        $data["page"] = "Partners";
        $data["_company_information"]  = Tbl_partners::get();
        $data['locationList'] = Tbl_partners::select('company_location')->distinct()->get();
        return view("partners", $data);
    }
    public function partnerFilterByLocation()
    {
        if(Request::input('locationVal')=="ALL")
        {
         $partnerResult = Tbl_partners::get();
            $partnerResultView = view('partner-filter-result', compact('partnerResult'))->render();
            return Response::json($partnerResultView);   
        }
        else
        {
                 $partnerResult = Tbl_partners::where('company_location', '=', Request::input('locationVal'))->get();
            $partnerResultView = view('partner-filter-result', compact('partnerResult'))->render();
            return Response::json($partnerResultView);   
        }

    }
}