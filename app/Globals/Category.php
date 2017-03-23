<?php
namespace App\Globals;

use DB;
use App\Models\Tbl_category;
use App\Models\Tbl_user;

class Category
{
	public static function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
	}

	/* BREAKDONW OF CATEGRORY */
	public static function breakdown($shop_id = 0, $parent = 0, $category_type = '')
	{
		$data['raw'] = Category::re_select_raw($shop_id, $parent);
		$data['html'] = Category::re_select_html($shop_id, $parent);
		return $data;
	}

	public static function getAllCategory($cat_type = array("all","service","inventory","non-inventory"))
	{
		$data = Category::re_select_raw(Category::getShopId(), 0, $cat_type);
		return $data;
	}

	/* RECURSIVE SELECTION OF RAW DATA */ 
	public static function re_select_raw($shop_id = 0, $parent = 0, $cat_type = array("all","service","inventory","non-inventory"))
	{
		$data = array();
        $_category = Tbl_category::selecthierarchy($shop_id, $parent, $cat_type)->get();
		// dd($_category);
        foreach($_category as $key => $category)
        {
            $data[$key] = $category;
            $count =  Tbl_category::selecthierarchy($shop_id, $parent, $cat_type)->count();
            
            if($count != 0)
            {
                // dd($category->type_parent_id);
                $data[$key]['sub'] = Category::re_select_raw($shop_id, $category->type_id, $cat_type);
            }
        }
        return collect($data)->toArray();
	}

	/* RECURSIVE SELECETION OF HTML DATA FOR MODAL  [/member/item/category] */ 
	public static function re_select_html($shop_id = 0, $parent = 0, $padding = 0)
	{
		$data = '';
		$padding += 20;
        $_category = Tbl_category::selecthierarchy($shop_id, $parent)->orderBy('type_name','asc')->get();
        foreach($_category as $key => $cat)
        {
            $data .= '<a href="javascript:" style="padding-left:'.$padding.'px" class="list-group-item category-list" data-content="'.$cat->type_id.'">'.$cat->type_name.'</a>';
            $count =  Tbl_category::selecthierarchy($shop_id, $cat->type_parent_id)->count();
            
            if($count != 0)
            {
                $data  .= '<div class="list-group">'.Category::re_select_html($shop_id, $cat->type_id, $padding).'</div>';
            }
        }
        return $data;
	}

	public static function re_select_html_front($shop_id = 0, $parent = 0) //FOR FRONTEND
	{
		$data = '';
        $_category = Tbl_category::selecthierarchy($shop_id, $parent)->orderBy('type_name','asc')->get();
        foreach($_category as $key => $cat)
        {
        	$firstlel = true;
        	if ($cat->type_sub_level == 1) 
        	{
        		$data .= '</ul>';
        		
        		$data .= '<ul class="col-md-3">';	

        		$firstlel = false;
        	}

        	$data .= '<li><a style="' . ($cat->type_sub_level == 1 ? "color: #585de8; font-size: 14px;" : ($cat->type_sub_level == 2 ? "color: #484848; font-size: 14px; " : "color: #8d8d8d; font-size: 12px; line-height: 18px;")) . '" href="javascript:">'.$cat->type_name.'</a></li>';
            
            $count =  Tbl_category::selecthierarchy($shop_id, $cat->type_parent_id)->count();
            
            if($count != 0)
            {
                $data  .= Category::re_select_html_front($shop_id, $cat->type_id);
            }
        }
        return $data;
	}


	/* SEARCH CATEGORY WITH HTML*/
	public static function search_category($search = '' , $type_category = '', $shop_id = 0)
	{
		$data = '';

		$_category = Tbl_category::search($search, $type_category, $shop_id)->orderBy('type_name','asc')->get();;
		
		// dd($_category);
		$data['html'] = '';

		foreach($_category as $key => $cat)
        {
        	$data[$key] = $cat; 
            $data['html'] .= '<a href="javascript:" class="list-group-item category-list" data-content="'.$cat->type_id.'">'.$cat->type_name.'</a>';
            $count =  Tbl_category::where('type_shop', $shop_id)->where('type_parent_id', $cat->type_parent_id)->where('archived',0)->count();
            
            if($count != 0)
            {
            	$data[$key]['sub'] = Category::re_select_raw($shop_id, $cat->type_id);
                $data['html']  .= '<div class="list-group">'.Category::re_select_html($shop_id, $cat->type_id).'</div>';
            }
        }

        return $data;
	}

	public static function search_category_raw($search = '' , $type_category = '', $shop_id = 0)
	{

		$_category = Tbl_category::search($search, $type_category, $shop_id)->orderBy('type_name','asc')->get();;
		
		$data = array();

		foreach($_category as $key => $cat)
        {
        	$data[$key] = $cat; 
            
            $count =  Tbl_category::where('type_shop', $shop_id)->where('type_parent_id', $cat->type_parent_id)->where('archived',0)->count();
            
            if($count != 0)
            {
            	$data[$key]['sub'] = Category::re_select_raw($shop_id, $cat->type_id);
            }
        }

        return $data;
	}


	/*	FOR CATEGORY WITH HIERARCHY TR HTML	*/ 
	public static function select_tr_html($shop_id = 0, $archived = 0, $parent = 0, $margin_left = 0, $hierarchy = [])
	{
		$html = '';
		$_category = Tbl_category::selecthierarchy($shop_id, $parent, array("all","service","inventory","non-inventory"), $archived)->orderBy('type_name','asc')->get();
		foreach($_category as $key => $cat)
		{
			$class = '';
			$child = '';

			if($cat->type_parent_id != 0)
			{
				$class = 'tr-sub-'.$cat->type_parent_id.' tr-parent-'.$parent.' ';
			}
			$class .= $child;

			$caret = '';
			$count = Tbl_category::selecthierarchy($shop_id, $parent, array("all","service","inventory","non-inventory"), $archived)->count();
			if($count != 0)
			{
				$caret = '<i class="fa fa-caret-down toggle-category margin-right-10 cursor-pointer" data-content="'.$cat->type_id.'"></i>';
			}

			$data['class'] 	= $class;
			$data['cat'] 	= $cat;
			$data['margin_left'] = 'style="margin-left:'.$margin_left.'px"';
			$data['category'] = $caret.$cat->type_name;

			$html .= view('member.manage_category.tr_row',$data)->render();
			if($count != 0)
			{	
				$html .= Category::select_tr_html($shop_id, $archived, $cat->type_id, $margin_left + 30);
			}
		}
		return $html;
	}
}