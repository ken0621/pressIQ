<?php

namespace App\Http\Controllers\Member;

use Request;
use Carbon\Carbon;
use Session;
use App\Models\Tbl_shop;
use App\Globals\Utilities;

class Page_ThemesController extends Member
{
    public function index()
    {
    	$access = Utilities::checkAccess('page-theme', 'access_page');
		if($access == 1)
		{
			$data["page"] = "Vendor List";
			$dirs = scandir("../public/themes");
			$data["theme_color"] = $this->user_info->shop_theme_color;
			foreach($dirs as $key => $dir)
			{
				if($key > 1)
				{
					$string = file_get_contents("../public/themes/" . $dir . "/details.json");
					$json_a = json_decode($string, true);
					$themes[$dir] = $json_a;
					$themes[$dir]["key"] = $dir;
					$themes[$dir]["active"] = ($this->user_info->shop_theme == $dir ? "1" : "0");
					$themes[$dir]["color_scheme"] = implode(', ', array_keys($json_a["colors"]));
				}
			}

			$data["_themes"] = $themes;
	        return view('member.page.page_themes', $data);
		}
		else
		{
			return $this->show_no_access();
		}
    }
    public function popup_activate_form($key)
    {
    	$access = Utilities::checkAccess('page-theme', 'activate_theme');
		if($access == 1)
		{
			$data["page"] = "Activate Themes Form";
			$data["theme"] = file_get_contents("../public/themes/" . $key . "/details.json");
			$data["theme"] = json_decode($data["theme"], true);
			$data["key"] = $key;
	        return view('member.page.page_activate_form', $data);
		}
		else
		{
			return $this->show_no_access_modal();
		}
    }
    public function popup_activate_submit()
    {
    	$update["shop_theme_color"] = Request::input("shop_theme_color");
    	$update["shop_theme"] = Request::input("theme");
    	Tbl_shop::where("shop_id", $this->user_info->shop_id)->update($update);
    	$response["status"] = "success";
    	echo json_encode($response);
    }
}