<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use App\Models\Tbl_user;
use App\Models\Tbl_locale;

use Carbon\Carbon;
use Request;
use Response;
use Image;
use Validator;
use Redirect;
use File;
use Crypt;
use URL;
use Session;

/**
 * Location Module - all location related module
 *
 * @author Bryan Kier Aradanas
 */

class LocationController extends Member
{
    public function hasAccess($page_code, $acces)
    {
        $access = Utilities::checkAccess($page_code, $acces);
        if($access == 1) return true;
        else return false;
    }

    public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public function getList()
    {
        $search_province    = Request::input("search_province");
        $search_city        = Request::input("search_city");
        $search_barangay    = Request::input("search_barangay");


        $data["_province"]  = Tbl_locale::where("locale_parent", 0);
        if($search_province) $data["_province"]->where("locale_name","like","%" . $search_province . "%");
        $data["_province"]  = $data["_province"]->get();

        $city_parent        = Request::input("city_parent") ? Request::input("city_parent") : $data["_province"][0]->locale_id; 
        $data["_city"]      = Tbl_locale::where("locale_parent", $city_parent);
        if($search_city) $data["_city"]->where("locale_name","like","%" . $search_city . "%");
        $data["_city"]      = $data["_city"]->get();


        $barangay_parent    = Request::input("barangay_parent") ? Request::input("barangay_parent") : $data["_city"][0]->locale_id; 
        $data["_barangay"]  = Tbl_locale::where("locale_parent", $barangay_parent);
        if($search_barangay) $data["_barangay"]->where("locale_name","like","%" . $search_barangay . "%");
        $data["_barangay"]      = $data["_barangay"]->get();

        return view('member.location.location', $data);
    }

    public function getTerms()
    {
        $data['name'] = "";

        $terms_id = Request::input('id');
        if($terms_id)
        {
            $data["terms"] = Tbl_terms::where("terms_id", $terms_id)->where("terms_shop_id", $this->getShopId())->first(); 
        }

        return view('member.terms.modal_create_terms', $data);
    }

    public function getLoadTerms()
    {
        $data['_terms'] = Tbl_terms::where("archived", 0)->where("terms_shop_id", $this->getShopId())->get(); 

        return view('member.load_ajax_data.load_terms', $data);
    }
	
}