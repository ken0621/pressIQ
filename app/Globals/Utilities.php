<?php
namespace App\Globals;
use DB;
use App\Models\Tbl_user;
use App\Models\Tbl_user_access;
use App\Models\Tbl_mlm_plan;
use Log;
use Request;
use Session;
use Validator;
use Redirect;

/**
 * Utilities Module - all utilities related module
 *
 * @author Bryan Kier Aradanas
 */

class Utilities
{

	/**
	 * Check if the particular user has access
	 *
	 * @param string  	$page_code 		Name of the page accessing
	 * @param string  	$accesss_name  	Name or Type of access
     * @return string   1 or 0          1 => if has an access | 0 => if doesn't have an access
	 */
	public static function checkAccess($page_code, $access_name)
	{

		$user_info = Tbl_user::where("user_email", session('user_email'))->shop()->position()->access()->first();

		$rank 	   = $user_info->position_rank;

		if($user_info)
		{
		     if($rank === 0){
                return "1";
		     }
		     else{
		     $checkifaccess = DB::table('tbl_user_access')
		                    ->where('access_position_id', $user_info->access_position_id)
		                    ->where('access_page_code', $page_code)
		                    ->where('access_name', $access_name)
		                    ->where('access_permission', 1)
		                    ->first();

			     if($checkifaccess){
			           return "1";

			     }
			     else{
			           return "0";

			     } 
		 	}
		}
		else
		{
		    return Redirect::to('/admin/login');
		}   
     }

    public static function filterPageList($position_id = null)
    {
        $_page_list = page_list();

        $page_counter = count($_page_list);
        foreach($_page_list as $key=>$page)
        {
            if(array_has($page, "submenu"))
            {
                $submenu_counter = count($page['submenu']);

                foreach($page['submenu'] as $key2=>$submenu)
                {
                    if(array_has($submenu, 'user_settings'))
                    {
                        $array_count = count($submenu['user_settings']);
                       if($array_count > 0)
                       {
                            $page_code         = $submenu['code'];
                            $setting_counter   = $array_count;
                           
                            if(isset($_page_list[$key]['submenu'][$key2]))
                            {
                                foreach($submenu['user_settings'] as $key3=>$access_name)
                                {
                                    // dd(Utilities::checkAccess($page_code, $access_name)."|".$page_code."-".$access_name);
                                    if(Utilities::checkAccess($page_code, $access_name) == 0)
                                    {
                                        array_forget($_page_list, $key.'.submenu.'.$key2.".user_settings.".$key3);
                                        $setting_counter--;
                                    }
                                    if($position_id <> null)
                                    {
                                    	// dd(true);
                                    	$if_has_access = Tbl_user_access::where("access_position_id", $position_id)
                                    					->where("access_page_code", $page_code)
                                    					->where("access_name", $access_name)->first();
                                    	$_page_list[$key]['submenu'][$key2]['setting_is_checked'][$key3] = $if_has_access ? 1 : 0;
                                	}
                                }
                                if($setting_counter < 1)
                                {
                                    array_forget($_page_list, $key.'.submenu.'.$key2);
                                    $submenu_counter--;
                                }
                            }
                            if($page_code == "mlm-stairstep-compute")
                            {
                                $check_shop         = Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
                                if($check_shop)
                                {
                                    $check_stairstep = Tbl_mlm_plan::where("marketing_plan_code","STAIRSTEP")->where("shop_id",$check_shop)->where("marketing_plan_enable","1")->first();
                                    if(!$check_stairstep)
                                    {
                                        unset($_page_list[$key]['submenu'][$key2]);
                                    }
                                    // dd();
                                }
                            }
                       }

                        /* REMOVE ENTIRE SUBMENU IF THERE IS NO SETTINGS*/  
                       else
                       {
                        array_forget($_page_list, $key.'.submenu.'.$key2);
                        $submenu_counter--;
                       }
                    }
                    else
                    {
                        $submenu_counter--;
                    }
                }

                if($submenu_counter < 1)
                {
                    // dd($submenu_counter);
                    array_forget($_page_list, $key);
                    $page_counter--;
                }
            }
        }

        if($page_counter < 1)
        {
            $_page_list = [];
        }

        // dd($_page_list);

        return $_page_list;
    }
}