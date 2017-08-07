<?php
namespace App\Globals;

use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_item_code;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_membership_code;
use App\Http\Controllers\Member\MLM_MembershipController;
use App\Http\Controllers\Member\MLM_ProductController;
use App\Models\Tbl_customer;
use Schema;
use Session;
use DB;
use Carbon\Carbon;

use App\Globals\Mlm_tree;
use App\Globals\Mlm_complan_manager;
use App\Globals\Mlm_complan_manager_cd;
use App\Globals\Mlm_complan_manager_fs;
use App\Globals\Mlm_gc;
class Reward
{   
    public static function generate_membership_code($customer_id, $membership_id = null, $return = null)
    {
        $customer = Tbl_customer::where('customer_id', $customer_id)->first();
        if($customer)
        {
            $shop_id = $customer->shop_id;
            if($membership_id == null)
            {
                $membership = Tbl_membership_package::where('shop_id', $shop_id)->membership()->where('membership_archive', 0)->get()->toArray();
                
                $random = array_rand($membership);
                $membership_id = $membership[$random]['membership_package_id'];  
                $membership = Tbl_membership_package::where('membership_package_id', $membership_id)->membership()->first();
            }
            else
            {
                $membership = Tbl_membership_package::where('membership_id', $membership_id)->membership()->first();
            }
            
            $membership_package_id = $membership->membership_package_id;

            $insert['membership_activation_code'] = Self::random_code_generator(8);
            $insert['customer_id'] = $customer->customer_id;
            $insert['membership_package_id'] = $membership_package_id;
            $insert['membership_code_invoice_id'] = 0;
            $insert['shop_id'] = $shop_id;
            $insert['membership_code_pin'] = Tbl_membership_code::where('shop_id', $shop_id)->count() + 1; 
            $insert['membership_type'] = 'PS';

            Tbl_membership_code::insert($insert);

            $return['status'] = 'success';
            $return['message'] = 'Invalid Customer';
            $return['membership_code'] = $insert;
            
        }
        else
        {
            $return['status'] = 'error';
            $return['message'] = 'Invalid Customer';

        }

        if($return == 'json'){ return json_encode($return); }

        return $return;
    }
    public static function random_code_generator($word_limit)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $word_limit; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}