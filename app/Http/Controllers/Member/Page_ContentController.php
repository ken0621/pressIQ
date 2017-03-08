<?php

namespace App\Http\Controllers\Member;

use Request;
use Carbon\Carbon;
use Session;
use App\Models\Tbl_shop;
use App\Models\Tbl_content;
use App\Models\Tbl_post_category;
use Redirect;
use App\Models\Tbl_post;
use App\Models\Tbl_collection;

class Page_ContentController extends Member
{
    public function getIndex()
    {
        $data["page"] = "Vendor List";
		$dirs = scandir("../public/themes");
		$data["theme_color"] = $this->user_info->shop_theme_color;
		$data["page_info"] = $string = file_get_contents("../public/themes/" . $this->user_info->shop_theme . "/page.json");
        $data["page_info"] = json_decode($string);
        if ($data["page_info"]) 
        {
            foreach ($data["page_info"] as $key => $value) 
            {
                foreach ($value as $keys => $values) 
                {
                    $get = Tbl_content::where("key", $keys)->where("type", $values->type)->where("shop_id", $this->user_info->shop_id)->first();

                    if ($get) 
                    {
                        $data["page_info"]->$key->$keys->type = $get->type;
                        $data["page_info"]->$key->$keys->default = $get->value;
                    }
                }
            }
        }
        else
        {
            die('An error has occurred. Please contact your system administrator.');
        }

        $data["company_info"] = collect(Tbl_content::where("shop_id", $this->user_info->shop_id)->get())->keyBy('key');
        $data["_collection"] = Tbl_collection::where("shop_id", $this->user_info->shop_id)->where("archived", 0)->where("collection_status", 1)->get();
        
        return view('member.page.page_content', $data);
    }

    public function postIndex()
    {
    	$info  = Request::input("info");
   
    	foreach ($info as $key => $value) 
    	{
    		$exist = Tbl_content::where("key", $key)->where("type", $value["type"])->first();

    		$insert["key"]       = $key;

            if ($value["type"]   == "gallery") 
            {
                if (is_serialized($value["value"])) 
                {
                    $insert["value"] = $value["value"];
                }
                else
                {
                    if ($value["value"]) 
                    {
                        $insert["value"] = serialize(explode(",",$value["value"]));
                    }
                    else
                    {
                        $insert["value"] = "";
                    }
                }   
            }
            else
            {
                if(isset($value["value"]))
                {
                    $insert["value"] = $value["value"];
                }
                else
                {
                    $insert["value"] = "";
                }
            }

			$insert["type"]      = $value["type"];
			$insert["shop_id"]   = $this->user_info->shop_id;

    		if ($exist) 
    		{
				Tbl_content::where("content_id", $exist->content_id)->update($insert);
    		}
    		else
    		{	
				Tbl_content::insert($insert);
    		}
    	}

    	return Redirect::back();
    }

    public function getPost($limit)
    {
        if ($limit) {
            # code...
        }
        $post          = Tbl_content::where("key", Request::input("key"))->where("shop_id", $this->user_info->shop_id)->first();
        if ($post) 
        {
            $explode_post  = explode(",", $post->value);
        }
        $data["_post"] = Tbl_post::where("archived", 0)->where("shop_id", $this->user_info->shop_id)->get();
        foreach ($data["_post"] as $key => $value) 
        {
            $data["_post"][$key]->selected = false;
            if(isset($explode_post))
            {
                foreach ($explode_post as $keys => $values) 
                {
                    if ($value->post_id == $values) 
                    {
                        $data["_post"][$key]->selected = true;
                    }       
                }
            }
        }
        $data["limit"] = $limit;
 
        return view("member.page.page_content_post", $data);
    }

    public function postSubmitPost()
    {
        $post = Request::input("post");
        $limit = Request::input("limit");

        if($limit != "all")
        {
            if(count($post) <= $limit)
            {
                $response["response_status"] = "success";
                $response["message"]         = "Successfully added posts.";
                $response["post"]            = $post;
            }
            else
            {
                $response["response_status"] = "warning";
                $response["message"]         = "Select " . $limit . " post only.";
            }
        }
        else
        {
            $response["response_status"] = "success";
            $response["message"]         = "Successfully added posts.";
            $response["post"]            = $post;
        }

        return json_encode($response);
    }
}