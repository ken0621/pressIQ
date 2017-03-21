<?php
namespace App\Http\Controllers\Member;

use Request;
use App\Models\Tbl_category;
use App\Models\Tbl_item;
use Carbon\Carbon;
use App\Globals\Category;
use App\Globals\Utilities;


class Manage_Category_Controller extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $access = Utilities::checkAccess('item-categories', 'access_page');
        if($access == 1)
        {
            $shop_id = $this->user_info->user_shop;
            $data['category'] = Category::select_tr_html($shop_id, 0);
            $data['archived_category'] = Category::select_tr_html($shop_id, 1);
            // dd($data['archived_category'])
            return view('member.manage_category.manage_category_list', $data);
        }
        else
        {
            return $this->show_no_access();
        }
    }

    public function load_category()
    {
        $access = Utilities::checkAccess('item-categories', 'access_page');
        if($access == 1)
        {
            $data['_category'] = Category::getAllCategory();
            $data['add_search'] = '';

            return view('member.load_ajax_data.load_category', $data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function archived($id, $action)
    {
        $data["cat_id"] = $id;
        $data["action"] = $action;

        $data["cat"] = Tbl_category::where("type_id",$id)->first();

        return view("member.manage_category.category_confirm",$data);
    }
    public function archived_submit()
    {
        $id = Request::input("cat_id");
        $action = Request::input("action");

        $chk = Tbl_item::where("item_category_id",$id)->count();

        $update["archived"] = 0;
        $data["status"] = "success-category"; 
        if($action == "archived")
        {
            if($chk == 0)
            {          
                $update["archived"] = 1;
                $data["status"] = "success-category";         
            }
            else
            {
                $data["status"] = "error";
                $data["status_message"] = "The category is in used";
            }
        }
        $all = Tbl_category::where("type_parent_id",$id)->get();
        if($all)
        {
            foreach ($all as $key => $value) 
            {
                Tbl_category::where("type_id",$value->type_id)->update($update);
            }            
        }
        Tbl_category::where("type_id",$id)->update($update);

        return json_encode($data);
    }
    public function modal_create_category()
    {
        $access = Utilities::checkAccess('item-categories', 'access_page');
        if($access == 1)
        {
            $shop_id = $this->user_info->user_shop;

            // $data['_level_category'] = $this->recursive_select_category($shop_id);
            $data['_category'] = Category::breakdown($shop_id);

            // $data['_category'] = Tbl_category::where('type_shop', $shop_id)->where('archived',0)->get();
            return view('member.modal.create_category_modal', $data);
        }
        else
        {
            return $this->show_no_access();
        }
    }

    public function create_category()
    {
        $type_name = Request::input('type_name');
        $type_category = Request::input('type_category');

        $type_parent_id = 0;
        $type_sub_level = 0;

        if(Request::has('is_sub_category')){
            $type_parent_id = Request::input('hidden_parent_category');
            $type_sub_level = Tbl_category::where('type_id', $type_parent_id)->pluck('type_sub_level');
            $type_sub_level++;
        }   

        $shop_id = $this->user_info->user_shop;

        $insert['type_name']            = $type_name;
        $insert['type_category']        = $type_category;
        $insert['type_parent_id']       = $type_parent_id;
        $insert['type_shop']            = $shop_id;
        $insert['type_sub_level']       = $type_sub_level;
        $insert['type_date_created']    = Carbon::now();

        $category_id = Tbl_category::insertGetId($insert);

        $data["status"] = "success-category";
        $data["type"] = "category";
        $data["id"] = $category_id;

        return json_encode($data);
    }


    public function edit_category($id)
    {
        $access = Utilities::checkAccess('item-categories', 'access_page');
        if($access == 1)
        {
            $shop_id = $this->user_info->user_shop;
            $category = Tbl_category::where('type_id',$id)->first();
            $check = '';
            if($category->type_parent_id != 0){
                $check = 'checked="checked"';
            }
            $data['check'] = $check;
            $data['category'] = $category;
            $data['parent'] = Tbl_category::where('type_id',$category->type_parent_id)->first();
            $data['_category'] = Category::breakdown($shop_id);
            return view('member.modal.edit_category_modal', $data);
        }
        else
        {
            return $this->show_no_access();
        }
    }

    public function update_category()
    {
        $access = Utilities::checkAccess('item-categories', 'access_page');
        if($access == 1)
        {
            $type_id = Request::input('type_id');
            $type_category = Request::input('type_category');
            $type_name = Request::input('type_name');
            $type_parent_id = 0;

            if(Request::input('is_sub_category')){
                $type_parent_id = Request::input('hidden_parent_category');
            }
            
            $update['type_name']            = $type_name;
            $update['type_category']        = $type_category;
            $update['type_parent_id']       = $type_parent_id;
            Tbl_category::where('type_id', $type_id)->update($update);
        }
        else
        {
            return $this->show_no_access();
        }
    }

    public function recursive_select_category($shop_id = 0, $parent = 0)
    {
        $data = array();
        $_category = Tbl_category::where('type_shop', $shop_id)->where('type_parent_id', $parent)->where('archived',0)->get();
        foreach($_category as $key => $category)
        {
            $data[$key] = $category;
            $count =  Tbl_category::where('type_shop', $shop_id)->where('type_parent_id', $category->type_parent_id)->where('archived',0)->count();
            
            if($count != 0)
            {
                // dd($category->type_parent_id);
                $data[$key]['sub'] = $this->recursive_select_category($shop_id, $category->type_id);
            }
        }
        return $data;
    }

    public function search_category()
    {
        $search = Request::input('search');
        $type_category = Request::input("type_category");
        $shop_id = $this->user_info->user_shop;
        return json_encode(Category::search_category($search, $type_category, $shop_id));
    }

}
