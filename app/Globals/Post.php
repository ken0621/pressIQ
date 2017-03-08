<?php
namespace App\Globals;
use DB;
use Session;
use App\Models\Tbl_post;
use App\Models\Tbl_post_category;
use App\Models\Rel_post_category;
use Carbon\Carbon;
use Validator;

class Post
{
    public static function add($insert)
    {
        $post_category_id       = $insert["post_category_id"];
        unset($insert["post_category_id"]);

        $rules['post_author']   = 'required';
        $rules['post_date']     = 'required|date';
        $rules['post_title']    = 'required';
        $rules['post_content']  = 'required';
        $rules['post_excerpt']  = 'required';
        $rules['post_type']     = 'required';
        $rules['post_image']    = 'required';

        $validator = Validator::make($insert, $rules);

        if($validator->fails())
        {
            $response["response_status"]  = "warning";
            $response["message"]          = null;
            foreach ($validator->errors()->all() as $key => $value) 
            {
                $response["message"] .= $value . "</br>";
            }
        }
        else
        {
            $success = Tbl_post::insertGetId($insert);

            if ($success) 
            {
                Rel_post_category::where("post_id", $success)->delete();

                if ($post_category_id) 
                {
                    foreach ($post_category_id as $key => $value) 
                    {
                        $rel_insert["post_id"]          = $success;
                        $rel_insert["post_category_id"] = $value;
                        
                        Rel_post_category::insert($rel_insert);
                    }
                }

                $response["response_status"]  = "success";
                $response["message"]          = "Post has been successfully added.";
            }
            else
            {
                $response["response_status"]  = "warning";
                $response["message"]          = "Some error occurred. Please try again.";
            }
        }

        return $response;
    }

    public static function edit($insert, $id)
    {
        $post_category_id       = $insert["post_category_id"];
        unset($insert["post_category_id"]);

        $rules['post_author']   = 'required';
        $rules['post_date']     = 'required|date';
        $rules['post_title']    = 'required';
        $rules['post_content']  = 'required';
        $rules['post_excerpt']  = 'required';
        $rules['post_type']     = 'required';
        $rules['post_image']    = 'required';

        $validator = Validator::make($insert, $rules);

        if($validator->fails())
        {
            $response["response_status"]  = "warning";
            $response["message"] = null;
            foreach ($validator->errors()->all() as $key => $value) 
            {
                $response["message"] .= $value . "</br>";
            }
        }
        else
        {
            $success = Tbl_post::where("post_id", $id)->update($insert);

            if ($success) 
            {
                Rel_post_category::where("post_id", $id)->delete();

                if ($post_category_id) 
                {
                    foreach ($post_category_id as $key => $value) 
                    {
                        $rel_insert["post_id"]          = $id;
                        $rel_insert["post_category_id"] = $value;
                        
                        Rel_post_category::insert($rel_insert);
                    }
                }

                $response["response_status"]  = "success";
                $response["message"]          = "Post has been successfully edited.";
            }
            else
            {
                $response["response_status"]  = "warning";
                $response["message"]          = "Some error occurred. Please try again.";
            }
        }

        return $response;
    }

    public static function category_add($insert)
    {
        $response['id']              = null;

        $rules['post_category_name'] = 'required';

        $validator = Validator::make($insert, $rules);

        if($validator->fails())
        {
            $response["response_status"]  = "warning";
            $response["message"]          = null;
            foreach ($validator->errors()->all() as $key => $value) 
            {
                $response["message"] .= $value . "</br>";
            }
        }
        else
        {
            $success = Tbl_post_category::insertGetId($insert);

            if ($success) 
            {
                $response['id']               = $success;
                $response["response_status"]  = "success";
                $response["message"]          = "Post Category has been successfully added.";
            }
            else
            {
                $response["response_status"]  = "warning";
                $response["message"]          = "Some error occurred. Please try again.";
            }
        }

        return $response;
    }
}