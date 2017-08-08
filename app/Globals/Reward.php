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
use Validator;

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
            }
            $membership = Tbl_membership_package::where('membership_package_id', $membership_id)->membership()->first();
            $membership_package_id = $membership->membership_package_id;

            $insert['membership_activation_code'] = Self::random_code_generator(8);
            $insert['customer_id'] = $customer->customer_id;
            $insert['membership_package_id'] = $membership_package_id;
            $insert['membership_code_invoice_id'] = 0;
            $insert['shop_id'] = $shop_id;
            $insert['membership_code_pin'] = Tbl_membership_code::where('shop_id', $shop_id)->count() + 1; 
            $insert['membership_type'] = 'PS';
            $id = Tbl_membership_code::insertGetId($insert);

            $return['status'] = 'success';
            $return['message'] = 'Invalid Customer';
            $return['membership_code'] = $insert;
            $return['membership_code_id'] = $id;
            
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
    public static function create_slot_submit_create_slot($request)
    {
        // slot_owner           Required
        // membership_code_id   Required
        // slot_sponsor         Required
        // slot_placement       Required/Defending on settings
        //                      lef/right
        // slot_position        Required/Defending on settings
        // shop_id              Required
        $required['slot_owner'] = null;
        $required['membership_code_id'] = null;
        $required['slot_sponsor'] = null;
        $required['slot_placement'] = null;
        $required['slot_position'] = null;
        $required['shop_id'] = null; 
        foreach($required as $key => $value)
        {
            if(!isset($request[$key]))
            {
                $request[$key] = null;
            }
        }

        
        $shop_id = $request['shop_id'];

        $validate['shop_id']            = $request['shop_id'];
        $validate['slot_owner']         = $request['slot_owner'];
        $validate['membership_code_id'] = $request['membership_code_id'];
        $validate['slot_sponsor']       = $request['slot_sponsor'];
        
        
        $rules['shop_id']               = "required";
        $rules['slot_owner']            = "required";
        $rules['membership_code_id']    = "required";
        $rules['slot_sponsor']          = "required";
        
        $binary_settings = Tbl_mlm_plan::where('shop_id', $shop_id)->code('BINARY')->enable(1)->trigger('Slot Creation')->first();
        $binary_advance = Tbl_mlm_binary_setttings::shop($shop_id)->first();
        $enable_binary = 0;
        $enable_auto_place = 0;
        $count_tree_if_exist = 0;

        if(isset($binary_settings->marketing_plan_enable))
        {
            $enable_binary = $binary_settings->marketing_plan_enable;
            if(isset($binary_advance->binary_settings_placement))
            {
                $enable_auto_place = $binary_advance->binary_settings_placement;
                if($enable_auto_place == 0)
                {
                    $validate['slot_placement'] = $request['slot_placement'];
                    $validate['slot_position'] = $request['slot_position'];

                    $rules['slot_placement'] = "required";
                    $rules['slot_position'] = "required";

                    $count_tree_if_exist = Tbl_tree_placement::where('placement_tree_position', $validate['slot_position'])
                    ->where('placement_tree_parent_id', $validate['slot_placement'])
                    ->where('shop_id', $shop_id)
                    ->count();

                    $insert['slot_placement'] = $validate['slot_placement'];
                    $insert['slot_position'] = $validate['slot_position'];
                }
            }
        }

        $validator = Validator::make($validate,$rules);
        $membership = Tbl_membership_code::where('membership_code_id', $validate['membership_code_id'])->package()->membership()->first();

        if($count_tree_if_exist >= 1)
        {
            $return['status'] = "error"; $return['message'] = "Slot Placement Already Taken";       return $return;
        }
        if(!$validator->passes())
        {
            $return['status'] = "error"; $return['message'] = $validator->messages();               return $return;
        }
        if(!$membership)
        {
            $return['status'] = "error"; $return['message'] = "Membership Code does not exist";     return $return;
        }
        if($membership->used != 0)
        {
            $return['status'] = "error"; $return['message'] = "Membership Code already used";       return $return;  
        }

        $insert['slot_no'] = Mlm_plan::set_slot_no($shop_id, $validate['membership_code_id']);
        $insert['shop_id'] = $shop_id;
        $insert['slot_owner'] = $validate['slot_owner'];
        $insert['slot_created_date'] = Carbon::now();
        $insert['slot_membership'] = $membership->membership_id;
        $insert['slot_status'] = $membership->membership_type;
        $insert['slot_sponsor'] = $validate['slot_sponsor'];       
        $id = Tbl_mlm_slot::insertGetId($insert);
                    
        $update['used'] = 1;
        $update['date_used'] = Carbon::now();
        $update['slot_id'] = $id;
        Tbl_membership_code::where('membership_code_id', $validate['membership_code_id'])->update($update);
                    
        $return['status'] = "success"; $return['slot_id'] = $id; return $return; 
    }
}