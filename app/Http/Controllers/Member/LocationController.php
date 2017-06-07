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
        $data['_location'] = Tbl_locale::paginate(50);

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