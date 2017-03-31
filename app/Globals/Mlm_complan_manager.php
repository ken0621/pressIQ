<?php
namespace App\Globals;

use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_item_code;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_binary_pairing;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_indirect_setting;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_mlm_unilevel_settings;
use App\Models\Tbl_mlm_item_points;
use App\Models\Tbl_mlm_matching;
use App\Models\Tbl_mlm_matching_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_mlm_complan_executive_settings;
use App\Models\Tbl_mlm_leadership_settings;
use App\Models\Tbl_mlm_indirect_points_settings;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_mlm_discount_card_settings;
use App\Globals\Mlm_gc;
use App\Models\Tbl_mlm_gc;
use App\Http\Controllers\Member\MLM_MembershipController;
use App\Http\Controllers\Member\MLM_ProductController;

use Schema;
use Session;
use DB;

use Carbon\Carbon;

use App\Globals\Mlm_compute;
use App\Globals\Mlm_slot_log;
use App\Globals\Membership_code;
class Mlm_complan_manager
{   

    // DIRECT
	public static function direct($slot_info)
	{
        $slot_sponsor = Tbl_mlm_slot::where('slot_id', $slot_info->slot_sponsor)->membership()->first();
        /* CHECK IF SLOT RECIPIENT EXIST */
        if($slot_sponsor)
        {
            if($slot_info->membership_points_direct != null || $slot_info->membership_points_direct != 0)
            {
                $log_array['earning'] = $slot_info->membership_points_direct;
                $log_array['level'] = 1;
                $log_array['level_tree'] = 'Sponsor Tree';
                $log_array['complan'] = 'DIRECT';

                $log = Mlm_slot_log::log_constructor($slot_sponsor, $slot_info,  $log_array);

                $arry_log['wallet_log_slot'] = $slot_sponsor->slot_id;
                $arry_log['shop_id'] = $slot_info->shop_id;
                $arry_log['wallet_log_slot_sponsor'] = $slot_info->slot_id;
                $arry_log['wallet_log_details'] = $log;
                $arry_log['wallet_log_amount'] = $slot_info->membership_points_direct;
                $arry_log['wallet_log_plan'] = "DIRECT";
                $arry_log['wallet_log_status'] = "n_ready";   
                $arry_log['wallet_log_claimbale_on'] = Mlm_complan_manager::cutoff_date_claimable('DIRECT', $slot_info->shop_id); 
                Mlm_slot_log::slot_array($arry_log);
            }
        }   
        Mlm_complan_manager::cutoff_direct('DIRECT', $slot_info->shop_id);      
	}
    public static function cutoff_direct($code, $shop_id)
    {
        // function releasing income from cutoff
        $now = Carbon::now();
        $wallet_log = Tbl_mlm_slot_wallet_log::where('shop_id', $shop_id)
        ->where('wallet_log_plan', $code)
        ->where('wallet_log_status', 'n_ready')
        ->where('wallet_log_claimbale_on', '<', Carbon::now()->addMinutes(1))
        ->get();  
        $cutoff_log = [];
        foreach($wallet_log as $key => $value)
        {
            $cutoff_log[$value->wallet_log_slot][$value->wallet_log_id] = $value->wallet_log_amount; 
        }
        if($cutoff_log != null)
        {
            foreach($cutoff_log as $key => $value)
            {
                foreach($value as $key2 => $value2)
                {
                    $update['wallet_log_status'] = 'released';
                    Tbl_mlm_slot_wallet_log::where('wallet_log_id', $key2)->update($update);
                }
            }
        }
    }
    // END DIRECT

    // INDIRECT
	public static function indirect($slot_info)
	{
        $settings_indirect = Tbl_mlm_indirect_setting::where('indirect_setting_archive', 0)->get();
        $slot_tree = Tbl_tree_sponsor::child($slot_info->slot_id)->orderby("sponsor_tree_level", "asc")->distinct_level()->parentslot()->membership()->get();
        /* RECORD ALL INTO A SINGLE VARIABLE */
        $indirect_level = null;
        foreach($settings_indirect as $key => $level)
        {
            /* CHECK IF PERCENTAGE OR FIXED AMOUNT */
            //indirect_seting_percent  0 = fixed
            //indirect_seting_percent  1 = percentage
            $value = 0;
            if($level->indirect_seting_percent == 0)
            {
                $value = $level->indirect_seting_value;
            }
            else
            {
                $value = $slot_info->membership_price * ($level->indirect_seting_value/100);
            }
            $indirect_level[$level->membership_id][$level->indirect_seting_level] = $value;
        }
        /* CHECK IF LEVEL EXISTS */
        if($indirect_level)
        {
            foreach($slot_tree as $key => $tree)
            {
                /* COMPUTE FOR BONUS */
                if(isset($indirect_level[$tree->membership_id][$tree->sponsor_tree_level]))
                {
                    $indirect_bonus = $indirect_level[$slot_info->membership_id][$tree->sponsor_tree_level];    
                }
                else
                {
                    $indirect_bonus = 0;
                }
                /* CHECK IF BONUS IS ZERO */
                if($indirect_bonus != 0)
                {
                    $log_array['earning'] = $indirect_bonus;
                    $log_array['level'] = $tree->sponsor_tree_level;
                    $log_array['level_tree'] = 'Sponsor Tree';
                    $log_array['complan'] = 'INDIRECT';

                    $slot_sponsor = Mlm_compute::get_slot_info($tree->slot_id);
                    $log = Mlm_slot_log::log_constructor($slot_sponsor, $slot_info,  $log_array);

                    $arry_log['wallet_log_slot'] = $tree->slot_id;
                    $arry_log['shop_id'] = $slot_info->shop_id;
                    $arry_log['wallet_log_slot_sponsor'] = $slot_info->slot_id;
                    $arry_log['wallet_log_details'] = $log;
                    $arry_log['wallet_log_amount'] = $indirect_bonus;
                    $arry_log['wallet_log_plan'] = "INDIRECT";
                    $arry_log['wallet_log_status'] = "n_ready";   
                    $arry_log['wallet_log_claimbale_on'] = Mlm_complan_manager::cutoff_date_claimable('INDIRECT', $slot_info->shop_id); 
                    
                    Mlm_slot_log::slot_array($arry_log);
                }
            }
        }  
        Mlm_complan_manager::cutoff_indirect('INDIRECT', $slot_info->shop_id);    
	}
    public static function cutoff_indirect($code, $shop_id)
    {
        $now = Carbon::now();
        $wallet_log = Tbl_mlm_slot_wallet_log::where('shop_id', $shop_id)
        ->where('wallet_log_plan', $code)
        ->where('wallet_log_status', 'n_ready')
        ->where('wallet_log_claimbale_on', '<', Carbon::now()->addMinutes(1))
        ->get();  
        $cutoff_log = [];
        foreach($wallet_log as $key => $value)
        {
            $cutoff_log[$value->wallet_log_slot][$value->wallet_log_id] = $value->wallet_log_amount; 
        }
        if($cutoff_log != null)
        {
            foreach($cutoff_log as $key => $value)
            {
                foreach($value as $key2 => $value2)
                {
                    $update['wallet_log_status'] = 'released';
                    Tbl_mlm_slot_wallet_log::where('wallet_log_id', $key2)->update($update);
                }
            }
        }
    }
    // END INDIRECT

    // Binary
    public static function binary($slot_info)
    {
        /* FOR PS ONLY or CD Turned PS */
        // GET PAIRING SETTINGS / BINARY TREE
        $settings_pairing = Tbl_mlm_binary_pairing::orderBy("pairing_point_left", "desc")->get();
        $binary_advance_pairing = Tbl_mlm_binary_setttings::where('shop_id', $slot_info->shop_id)->first();
        // binary_settings_max_tree_level
        // select max tree level
        if(isset($binary_advance_pairing->binary_settings_max_tree_level))
        {
            $binary_settings_max_tree_level = $binary_advance_pairing->binary_settings_max_tree_level;
        }
        else
        {
            // set 999 max tree level if setting does not exist
            $binary_settings_max_tree_level = 999;
        }
        $settings_tree = Tbl_tree_placement::child($slot_info->slot_id)
        ->where('placement_tree_level', '<=', $binary_settings_max_tree_level)
        ->level()->distinct_level()->parentslot()->get();

        $notify_max_level = Tbl_tree_placement::child($slot_info->slot_id)
        ->where('placement_tree_level', '>', $binary_settings_max_tree_level)
        ->level()->distinct_level()->parentslot()->get();
        foreach($notify_max_level as $key => $value)
        {
            $log = "Sorry, Your Slot has already reached the max level for binary. Slot " . $slot_info->slot_no . "'s binary points will not be added.";
            $arry_log['wallet_log_slot']            = $value->slot_id;
            $arry_log['shop_id']                    = $value->shop_id;
            $arry_log['wallet_log_slot_sponsor']    = $slot_info->slot_id;
            $arry_log['wallet_log_details']         = $log;
            $arry_log['wallet_log_amount']          = 0;
            $arry_log['wallet_log_plan']            = "BINARY_MAX_LEVEL";
            $arry_log['wallet_log_status']          = "n_ready";   
            $arry_log['wallet_log_claimbale_on']    = Carbon::now(); 
            Mlm_slot_log::slot_array($arry_log); 
        }

        // DISTRIBUTE BINARY POINTS
        foreach($settings_tree as $tree)
        {
            // RETRIEVE LEFT & RIGHT POINTS
            $binary["left"] = $tree->slot_binary_left;
            $binary["right"] = $tree->slot_binary_right; 
            // END

            // GET BINARY POINTS OF MEMBERSHIP
            $binary['points'] = $slot_info->membership_points_binary;
            // End
            if($binary['points'] != 0)
            {
                // ADD OLD BINARY POINTS + NEW BINARY POINTS

                $binary[$tree->placement_tree_position] = $binary[$tree->placement_tree_position] + $binary['points']; 

                // End
                $update['slot_binary_left'] =   $binary["left"];
                $update['slot_binary_right'] =  $binary["right"];
                Tbl_mlm_slot::where('slot_id', $tree->placement_tree_parent_id)->update($update);
            }
        }
        // END
        $a = Mlm_complan_manager::binary_pairing($slot_info);
        Mlm_complan_manager::cutoff_binary('BINARY', $slot_info->shop_id); 
    }
    public static function binary_pairing($slot_info)
    {
        $shop_id = $slot_info->shop_id;
        // Get All Slot
        $membership = Tbl_membership::where('shop_id', $shop_id)
        ->where('membership_archive', 0)
        ->get();
        foreach($membership as $key => $value)
        {
            // Get Pairing Settings
            $settings_pairing[$value->membership_id] = Tbl_mlm_binary_pairing::orderBy("pairing_point_left", "desc")
            ->where('pairing_point_left', '!=', 0)
            ->where('pairing_point_right', '!=', 0)
            ->where('pairing_bonus', '!=', 0)
            ->where('pairing_archive', 0)
            ->where('membership_id', $value->membership_id)->get();
        }
        // Get All Slot
        $slots = Tbl_tree_placement::child($slot_info->slot_id)
        ->level()
        ->distinct_level()
        ->parentslot()
        ->membership()
        ->membership_points()
        ->where('tbl_mlm_slot.slot_binary_left', '!=', 0)
        ->where('tbl_mlm_slot.slot_binary_right', '!=', 0)
        ->get();

        // Get Complan Setting
        $plan = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_code', 'BINARY')
        ->where('marketing_plan_enable', 1)
        ->where('marketing_plan_trigger', 'Slot Creation')
        ->first();

        $binary_advance_pairing = Tbl_mlm_binary_setttings::where('shop_id', $shop_id)->first();
        // binary_settings_strong_leg /strong_leg /no_strong_leg

        // Check if plan is true
        if($plan != null)
        {
            if($binary_advance_pairing != null)
            {
            // All Slot 
                foreach($slots as $slot)
                {
                    $binary["left"]     = $slot->slot_binary_left;
                    $binary["right"]    = $slot->slot_binary_right;

                    // Pairing Settings All Membership
                    foreach($settings_pairing as $key => $value)
                    {

                        // Pairing Settings Per Membership
                        foreach($value as $key2 => $value2)
                        {

                            // Check if Pairing Settings(Membership) == Slot MEmbership
                            if($key == $slot->slot_membership)
                            {
                                // Initialize the points    
                                $current_pair               = intval($slot->slot_pairs_current);
                                $current_gc                 = $slot->slot_pairs_gc;
                                $current_pairs_per_date     = $slot->slot_pairs_per_day_date;
                                $gc_arr_sample[$slot->slot_id] = $current_gc;

                                $earning            = 0;
                                $flush              = 0;
                                $pair_this_pairing  = 0;
                                $gc_count           = 0;
                                
                                
                                // Check if binary points is greater than pairing points requirement
                                while($binary["left"] >= $value2->pairing_point_left && $binary["right"] >= $value2->pairing_point_right)
                                {
                                    // marketing_plan_release_schedule
                                    // 1 = instant; 2 = dailay; 3 = weekly; 4 = monthly

                                    $binary["left"]         = $binary["left"] - $value2->pairing_point_left;
                                    $binary["right"]        = $binary["right"] - $value2->pairing_point_left;

                                    $pair_this_pairing      = $pair_this_pairing + 1;

                                    $current_pair           = $current_pair + 1;
                                    
                                    $current_pair_lst_date  = Carbon::parse($slot->slot_pairs_per_day_date)->format('Y-m-d');
                                    $current_date           = Carbon::now()->format('Y-m-d'); 
                                    $current_day            = Mlm_complan_manager::date_current('d');
                                    $current_week_day       = strtolower(Mlm_complan_manager::date_current('l'));
                                    $current_month          = Carbon::now()->day;
                                    $current_year           = Mlm_complan_manager::date_current('Y');
                                    $current_hour           = intval(Carbon::now()->format('G'));

                                    // enable/disable
                                    $setting_gc_enabled     = $binary_advance_pairing->binary_settings_gc_enable;
                                    $setting_gc_every_pair  = $binary_advance_pairing->binary_settings_gc_every_pair;
                                    $setting_gc_name        = $binary_advance_pairing->binary_settings_gc_title;
                                    $setting_gc_amount      = $binary_advance_pairing->binary_settings_gc_amount;

                                    // no of cycle 
                                    $setting_cycle_no       = $binary_advance_pairing->binary_settings_no_of_cycle;
                                    $setting_cycle_time     = $binary_advance_pairing->binary_settings_time_of_cycle;

                                    // strong_leg/no_strong_leg
                                    $setting_strong_leg     = $binary_advance_pairing->binary_settings_strong_leg;
                                    
                                    // check if now and pairs per day are equal
                                    $check_date_is_today = Mlm_complan_manager::compare_date($current_pairs_per_date, Carbon::now(), 'day');

                                    // check if gc this pair
                                    if($binary_advance_pairing->binary_settings_gc_enable == 'enable')
                                    {
                                        if($binary_advance_pairing->binary_settings_gc_every_pair != 0)
                                        {
                                            $modulus = ($current_pair%$binary_advance_pairing->binary_settings_gc_every_pair);
                                        } 
                                        else
                                        {
                                            $modulus = 1;
                                        }
                                    }
                                    else
                                    {
                                        $modulus = 1;
                                    }

                                    // fir pairing cycle of binary
                                    if($setting_cycle_no == 1)
                                    {

                                        // check if now and pairs per day are equal
                                        if($check_date_is_today == 1)
                                        {

                                            // check pairing
                                            if($slot->membership_points_binary_max_pair < $current_pair)
                                            {
                                                // add to flushout
                                                $flush += $value2->pairing_bonus;
                                            }
                                            else
                                            {
                                                // check if gc pair
                                                if($modulus == 0)
                                                {
                                                    // add gc 
                                                    $gc_count = $gc_count + 1;
                                                    $current_gc             = $current_gc   + 1;
                                                }
                                                else
                                                {
                                                    // add income
                                                    $earning += $value2->pairing_bonus;
                                                    $current_gc             = $current_gc   + 1;
                                                }
                                            }

                                        }
                                        // else pairs today not equal / reset pairing
                                        else
                                        {
                                            // reset pairing to 1
                                            $current_pair   = 1;
                                            $gc_count = 0;
                                            $current_pairs_per_date = Carbon::now();

                                            if($modulus == 0)
                                            {
                                                // add gc 
                                                $gc_count = $gc_count + 1;
                                                $current_gc             = $current_gc   + 1;
                                            }
                                            else
                                            {
                                                // add income
                                                $earning += $value2->pairing_bonus;
                                                $current_gc             = $current_gc   + 1;
                                            }
                                            
                                        }
                                    }
                                    if($setting_cycle_no == 2)
                                    {

                                        if($check_date_is_today == 1)
                                        {
                                            if($current_hour < 12)
                                            {
                                                // cycle 1
                                                $current_pairs_per_date_hour           = Carbon::parse($current_pairs_per_date)->format('G');
                                                if($current_pairs_per_date_hour < 12)
                                                {
                                                    // continue pairing
                                                    // check pairing
                                                    if($slot->membership_points_binary_max_pair < $current_pair)
                                                    {

                                                        // flush
                                                        $flush += $value2->pairing_bonus;

                                                    }
                                                    else
                                                    {
                                                        if($modulus == 0)
                                                        {
                                                            // add gc 
                                                            $current_gc             = $current_gc   + 1;
                                                            $gc_count = $gc_count + 1;
                                                        }
                                                        else
                                                        {
                                                            // add income
                                                            $earning += $value2->pairing_bonus;
                                                            $current_gc             = $current_gc   + 1;
                                                        }
                                                    }
                                                }
                                                else
                                                {   
                                                    // reset
                                                    $current_pair = 1;
                                                    $current_pairs_per_date =  Carbon::now();

                                                    // check pairing
                                                    if($slot->membership_points_binary_max_pair < $current_pair)
                                                    {
                                                        // flush
                                                        $flush += $value2->pairing_bonus;
                                                    }
                                                    else
                                                    {
                                                        if($modulus == 0)
                                                        {
                                                            // add gc 
                                                            $gc_count               = $gc_count + 1;
                                                            $current_gc             = $current_gc   + 1;
                                                        }
                                                        else
                                                        {
                                                            // add income
                                                            $earning += $value2->pairing_bonus;
                                                            $current_gc             = $current_gc   + 1;
                                                        }
                                                    }
                                                }
                                            }
                                            else if($current_hour >= 12)
                                            {
                                                // cycle 2
                                                $current_pairs_per_date_hour           = Carbon::parse($$current_pairs_per_date)->format('G');
                                                if($current_pairs_per_date_hour >= 12)
                                                {
                                                    // continue pairing
                                                    // check pairing
                                                    if($slot->membership_points_binary_max_pair < $current_pair)
                                                    {
                                                        // flush
                                                        $flush += $value2->pairing_bonus;
                                                    }
                                                    else
                                                    {
                                                        if($modulus == 0)
                                                        {
                                                            // add gc 
                                                            $gc_count               = $gc_count + 1;
                                                            $current_gc             = $current_gc   + 1;
                                                        }
                                                        else
                                                        {
                                                            // add income
                                                            $earning               += $value2->pairing_bonus;
                                                            $current_gc             = $current_gc   + 1;
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    // reset
                                                    $current_pair = 1;
                                                    $current_pairs_per_date         = Carbon::now();

                                                    // check pairing
                                                    if($slot->membership_points_binary_max_pair < $current_pair)
                                                    {
                                                        // flush
                                                        $flush                     += $value2->pairing_bonus;
                                                    }
                                                    else
                                                    {
                                                        if($modulus == 0)
                                                        {
                                                            // add gc 
                                                            $gc_count               = $gc_count + 1;
                                                            $current_gc             = $current_gc   + 1;
                                                        }
                                                        else
                                                        {
                                                            // add income
                                                            $earning += $value2->pairing_bonus;
                                                            $current_gc             = $current_gc   + 1;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        else
                                        {
                                            // reset
                                            $current_pair = 1;
                                            $current_pairs_per_date =  Carbon::now();

                                            // check pairing
                                            if($slot->membership_points_binary_max_pair < $current_pair)
                                            {
                                                // flush
                                                $flush += $value2->pairing_bonus;
                                            }
                                            else
                                            {
                                                if($modulus == 0)
                                                {
                                                    // add gc 
                                                    $gc_count               = $gc_count + 1;
                                                    $current_gc             = $current_gc   + 1;
                                                }
                                                else
                                                {
                                                    // add income
                                                    $earning               += $value2->pairing_bonus;
                                                    $current_gc             = $current_gc   + 1;
                                                }
                                            }
                                        }
                                    }
                                }
                                $update_slot['slot_binary_left']            = $binary["left"];
                                $update_slot['slot_binary_right']           = $binary["right"];

                                // add income
                                if($earning != 0)
                                {
                                    $log = "Congratulations! You Paired ".$pair_this_pairing." From Slot " .$slot->slot_id ." Earned " . $earning . " By Binary Pairing Bonus and flushed " . $flush;
                                    $arry_log['wallet_log_slot']            = $slot->slot_id;
                                    $arry_log['shop_id']                    = $slot->shop_id;
                                    $arry_log['wallet_log_slot_sponsor']    = $slot->slot_id;
                                    $arry_log['wallet_log_details']         = $log;
                                    $arry_log['wallet_log_amount']          = $earning;
                                    $arry_log['wallet_log_plan']            = "BINARY";
                                    $arry_log['wallet_log_status']          = "n_ready";   
                                    $arry_log['wallet_log_claimbale_on']    = Mlm_complan_manager::cutoff_date_claimable('BINARY', $slot->shop_id); 
                                    Mlm_slot_log::slot_array($arry_log);  
                                    
                                }
                                // add flush
                                if($flush != 0)
                                {
                                    $log = "Your account has exceeded the maximum pair this cycle. Your pairing had flushed ".$flush;
                                    $arry_log['wallet_log_slot']            = $slot->slot_id;
                                    $arry_log['shop_id']                    = $slot->shop_id;
                                    $arry_log['wallet_log_slot_sponsor']    = $slot->slot_id;
                                    $arry_log['wallet_log_details']         = $log;
                                    $arry_log['wallet_log_amount']          = 0;
                                    $arry_log['wallet_log_plan']            = "BINARY_FLUSHED";
                                    $arry_log['wallet_log_status']          = "n_ready";   
                                    $arry_log['wallet_log_claimbale_on']    = Mlm_complan_manager::cutoff_date_claimable('BINARY', $slot->shop_id); 
                                    Mlm_slot_log::slot_array($arry_log);  
                                    //check if strong leg  retention
                                    // binary_settings_strong_leg /strong_leg /no_strong_leg
                                    if($binary_advance_pairing->binary_settings_strong_leg == 'no_strong_leg')
                                    {
                                        $update_slot['slot_binary_left']    = 0;
                                        $update_slot['slot_binary_right']   = 0;
                                    }
                                }
                                // add gc
                                if($gc_count != 0)
                                {
                                    for($i = 0; $i < $gc_count; $i++)
                                    {
                                        // binary_advance_pairing
                                        $log = "You have Earned " . $binary_advance_pairing->binary_settings_gc_title . ". With an amount of " .$binary_advance_pairing->binary_settings_gc_amount ;
                                        $arry_log['wallet_log_slot']            = $slot->slot_id;
                                        $arry_log['shop_id']                    = $slot->shop_id;
                                        $arry_log['wallet_log_slot_sponsor']    = $slot->slot_id;
                                        $arry_log['wallet_log_details']         = $log;
                                        $arry_log['wallet_log_amount']          = $binary_advance_pairing->binary_settings_gc_amount;
                                        $arry_log['wallet_log_plan']            = "BINARY_GC";
                                        $arry_log['wallet_log_status']          = "n_ready";   
                                        $arry_log['wallet_log_claimbale_on']    = Mlm_complan_manager::cutoff_date_claimable('BINARY', $slot->shop_id); 
                                        Mlm_slot_log::slot_array($arry_log);  
                                    }
                                }
                                // update slot
                                // slot_pairs_current
                                // slot_pairs_gc
                                // slot_binary_left
                                // slot_binary_right
                                
                                $update_slot['slot_pairs_gc']           = $current_gc;
                                $update_slot['slot_pairs_current']      = $current_pair;
                                $update_slot["slot_pairs_per_day_date"] =   Carbon::now();
                                Tbl_mlm_slot::where('slot_id', $slot->slot_id)->update($update_slot);
                            }  
                        }
                    }
                }
            }    
        }
    }
    public static function cutoff_binary($code, $shop_id)
    {
        $now = Carbon::now();
        $wallet_log = Tbl_mlm_slot_wallet_log::where('shop_id', $shop_id)
        ->where('wallet_log_plan', $code)
        ->where('wallet_log_status', 'n_ready')
        ->where('wallet_log_claimbale_on', '<', Carbon::now()->addMinutes(1))
        ->get();  
        $cutoff_log = [];
        foreach($wallet_log as $key => $value)
        {
            $cutoff_log[$value->wallet_log_slot][$value->wallet_log_id] = $value->wallet_log_amount; 
        }
        if($cutoff_log != null)
        {
            foreach($cutoff_log as $key => $value)
            {
                foreach($value as $key2 => $value2)
                {
                    $update['wallet_log_status'] = 'released';
                    Tbl_mlm_slot_wallet_log::where('wallet_log_id', $key2)->update($update);
                }
            }
        }
        // dd($settings_pairing);
    }
    // End Binary


    // EXECUTIVE BONUS
    public static function executive_bonus($slot_info)
    {
        $slot_sponsor = Tbl_mlm_slot::where('slot_id', $slot_info->slot_sponsor)->membership()->first();

        /* CHECK IF SLOT RECIPIENT EXIST */
        if($slot_sponsor)
        {
            if($slot_info->membership_points_executive != null || $slot_info->membership_points_executive != 0)
            {
                $array['points_log_complan'] = "EXECUTIVE_BONUS";
                $array['points_log_level'] = 1;
                $array['points_log_slot'] = $slot_sponsor->slot_id;
                $array['points_log_Sponsor'] = $slot_info->slot_id;
                $array['points_log_date_claimed'] = Carbon::now();
                $array['points_log_converted'] = 0;
                $array['points_log_converted_date'] = Carbon::now();
                $array['points_log_type'] = 'PV';
                $array['points_log_from'] = 'Slot Creation';
                $array['points_log_points'] = $slot_info->membership_points_executive;

                Mlm_slot_log::slot_log_points_array($array);

                Mlm_complan_manager::executive_bonus_gradute($slot_sponsor);
            }
        }   
        Mlm_complan_manager::executive_bonus_cutoff('EXECUTIVE_BONUS', $slot_info->shop_id);  
    }
    public static function executive_bonus_gradute($slot_info)
    {

        $sum_points = Tbl_mlm_slot_points_log::where('points_log_slot', $slot_info->slot_id)
                                                ->where('points_log_complan', 'EXECUTIVE_BONUS')
                                                ->where('points_log_level', 1)
                                                ->sum('points_log_points');
        $settings = Tbl_mlm_complan_executive_settings::where('membership_id', $slot_info->slot_membership)->first();
        if(isset($settings->executive_settings_required_points))
        {
            if($sum_points >= $settings->executive_settings_required_points)
            {
                if($settings->executive_settings_required_points != 0)
                {
                    if($settings->executive_settings_bonus != 0)
                    {
                        $array['points_log_complan'] = "EXECUTIVE_BONUS";
                        $array['points_log_level'] = 1;
                        $array['points_log_slot'] = $slot_info->slot_id;
                        $array['points_log_Sponsor'] = $slot_info->slot_id;
                        $array['points_log_date_claimed'] = Carbon::now();
                        $array['points_log_converted'] = 0;
                        $array['points_log_converted_date'] = Carbon::now();
                        $array['points_log_type'] = 'PV';
                        $array['points_log_from'] = 'Slot Creation';
                        $array['points_log_points'] = -$settings->executive_settings_required_points;

                        Mlm_slot_log::slot_log_points_array($array);


                        $log = "Congratulations Your Slot " . $slot_info->slot_id ." Earned " . $settings->executive_settings_bonus . " from EXECUTIVE BONUS";
                        $arry_log['wallet_log_slot'] = $slot_info->slot_id;
                        $arry_log['shop_id'] = $slot_info->shop_id;
                        $arry_log['wallet_log_slot_sponsor'] = $slot_info->slot_id;
                        $arry_log['wallet_log_details'] = $log;
                        $arry_log['wallet_log_amount'] = $settings->executive_settings_bonus;
                        $arry_log['wallet_log_plan'] = "EXECUTIVE_BONUS";
                        $arry_log['wallet_log_status'] = "n_ready";   
                        $arry_log['wallet_log_claimbale_on'] = Mlm_complan_manager::cutoff_date_claimable('EXECUTIVE_BONUS', $slot_info->shop_id); 
                        Mlm_slot_log::slot_array($arry_log);
                    }
                }
            }
        }                           
    }
    public static function executive_bonus_cutoff($code, $shop_id)
    {
        $now = Carbon::now();
        $wallet_log = Tbl_mlm_slot_wallet_log::where('shop_id', $shop_id)
        ->where('wallet_log_plan', $code)
        ->where('wallet_log_status', 'n_ready')
        ->where('wallet_log_claimbale_on', '<', Carbon::now()->addMinutes(1))
        ->get();  
        $cutoff_log = [];
        foreach($wallet_log as $key => $value)
        {
            $cutoff_log[$value->wallet_log_slot][$value->wallet_log_id] = $value->wallet_log_amount; 
        }
        if($cutoff_log != null)
        {
            foreach($cutoff_log as $key => $value)
            {
                foreach($value as $key2 => $value2)
                {
                    $update['wallet_log_status'] = 'released';
                    Tbl_mlm_slot_wallet_log::where('wallet_log_id', $key2)->update($update);
                }
            }
        }
    }
    // END EXECUTIVE BONUS
    
    // MEMBERSHIP MATCHING
    public static function membership_matching($slot_info)
    {
        $settings = 
        Tbl_mlm_matching::where('shop_id', $slot_info->shop_id)
        ->where('membership_id', $slot_info->slot_membership)
        ->get()
        ->toArray();

        // get tree with same membership
        $tree = 
        Tbl_tree_sponsor::where('sponsor_tree_child_id', $slot_info->slot_id)
        
        ->parent_info()
        ->get()
        ->toArray();
        $tree_selected = [];
        foreach($tree as $key => $value)
        {
            foreach($settings as $key2 => $value2)
            {
                $tree_selected[$key2][$value['sponsor_tree_parent_id']] = 
                Tbl_tree_sponsor::where('sponsor_tree_parent_id', $value['sponsor_tree_parent_id'])
                ->child_info()
                ->where('sponsor_tree_level', '>=', $value2['matching_settings_start'])
                ->where('sponsor_tree_level', '<=', $value2['matching_settings_end'])
                ->where('slot_membership', $value2['membership_id'])
                ->where('slot_matched_membership', 0)
                ->get()
                ->toArray();
            }
        }
        // dd($tree_selected);
        $tree_match = [];
        foreach($tree_selected as $key => $value)
        {
            foreach($value as $key2 => $value2)
            {
                if(count($value) >= 2)
                {
                    foreach($value2 as $key3 => $value3)
                    {
                        $slot_id = $value3['slot_id'];

                        $count =
                        Tbl_mlm_matching_log::where('matching_log_earner', $key2)
                        ->where(function ($query) use ($slot_id){
                                $query->where('matching_log_slot_1', $slot_id)
                                      ->orWhere('matching_log_slot_2', $slot_id);
                            })
                        ->count(); 

                        if($count == 0)
                        {
                            foreach($settings as $settings_key => $setting)
                            {
                                if($setting['matching_settings_start'] <= $value3['sponsor_tree_level'] && $setting['matching_settings_end'] >= $value3['sponsor_tree_level'])
                                {
                                    $tree_match[$key2][$value3['slot_id']] = $setting['matching_settings_id'];
                                }   
                            }
                            
                        }                                                
                    }
                }
            }
        }
        

        $tree_ready = [];
        foreach($tree_match as $key => $value)
        {
            $count = 0;
            $team = 0;
            $last = 0;
            foreach($value as $key2=> $value2)
            {
                if($last == 0)
                {
                    $last = $value2;
                }
                else
                {
                    if($last == $value2)
                    {

                    }
                    else
                    {
                        $last = $value2;
                        $count = 0;
                        $team++;
                    }
                }

                $count++;
                if($count == 1)
                {
                    $tree_ready[$key][$team][0] = $key2;
                }
                else
                {
                    $tree_ready[$key][$team][1] = $key2;
                    $team++;
                    $count = 0;
                }
            }
        }


        foreach($tree_ready as $slot_earner => $team)
        {
            foreach($team as $count => $slot_child)
            {
                if(count($slot_child) == 2)
                {

                    $matching_log_slot_1_info = Tbl_tree_sponsor::where('sponsor_tree_parent_id', $slot_earner)
                                                ->where('sponsor_tree_child_id',  $slot_child[0])
                                                ->first();
                    $matching_log_slot_2_info = Tbl_tree_sponsor::where('sponsor_tree_parent_id', $slot_earner)
                                                ->where('sponsor_tree_child_id',  $slot_child[1])
                                                ->first();

                    $matching_log_slot_1 = $slot_child[0];
                    $matching_log_slot_2 = $slot_child[1];    

                    $matching_log_membership_1 = $slot_info->slot_membership;
                    $matching_log_membership_2 = $slot_info->slot_membership;

                    $matching_log_level_1 = $matching_log_slot_1_info->sponsor_tree_level;
                    $matching_log_level_2 = $matching_log_slot_2_info->sponsor_tree_level;

                    $matching_log_earner = $slot_earner;

                    $settingss = 
                    Tbl_mlm_matching::where('shop_id', $slot_info->shop_id)
                    ->where('matching_settings_start', '<=', $matching_log_level_1)
                    ->where('matching_settings_end', '>=', $matching_log_level_1)
                    ->where('matching_settings_start', '<=', $matching_log_level_2)
                    ->where('matching_settings_end', '>=', $matching_log_level_2)
                    ->where('membership_id', $slot_info->slot_membership)
                    ->first(); 

                    if(isset($settingss->matching_settings_earnings))
                    {
                        $matching_log_earning = $settingss->matching_settings_earnings;

                        $insert['matching_log_slot_1'] =    $matching_log_slot_1; 
                        $insert['matching_log_slot_2'] =    $matching_log_slot_2;
                        $insert['matching_log_membership_1'] =  $matching_log_membership_1;
                        $insert['matching_log_membership_2'] =  $matching_log_membership_2;
                        $insert['matching_log_level_1'] =   $matching_log_level_1;
                        $insert['matching_log_level_2'] =   $matching_log_level_2;
                        $insert['matching_log_earner'] =    $matching_log_earner;
                        $insert['matching_log_earning'] = $matching_log_earning;

                        
                        

                        if($settingss->matching_settings_gc_count != 0 && $settingss->matching_settings_gc_amount != 0)
                        {
                        	$count_matching = Tbl_mlm_matching_log::where('matching_log_earner', $matching_log_earner)->count() + 1;
                        	$mod = $count_matching % $settingss->matching_settings_gc_count;
                        	if($mod == 0)
                        	{
                        		$slot_i = Mlm_compute::get_slot_info($matching_log_earner);
                        		$insert_gc['mlm_gc_tag'] = 'MAT';
                                $insert_gc['mlm_gc_code'] = Mlm_gc::random_code_generator(8, $slot_i->slot_id, $insert_gc['mlm_gc_tag']);
                                $insert_gc['mlm_gc_amount'] = $settingss->matching_settings_gc_amount;
                                $insert_gc['mlm_gc_member'] = $slot_i->slot_owner;
                                $insert_gc['mlm_gc_slot'] = $slot_i->slot_id;
                                $insert_gc['mlm_gc_date'] = Carbon::now();
                                Tbl_mlm_gc::insert($insert_gc);
                                 $insert['matching_log_earning'] = 0;
                                 $insert['matching_log_gc_amount'] = $settingss->matching_settings_gc_amount;
                                 $insert['matching_log_is_gc'] = 1;
                                 $insert['matching_log_gc'] = $insert_gc['mlm_gc_code'];
                        	}
                        	else
                        	{
                        		$slot_aaa = Tbl_mlm_slot::where('slot_id', $matching_log_slot_1)->first();
		                        $slot_bbb = Tbl_mlm_slot::where('slot_id', $matching_log_slot_2)->first();
		                        $log = "Congratulations Your Slot " . $matching_log_earner . " Earned " . $matching_log_earning . " From Membership Matching. Slot " . $slot_aaa->slot_no . "(level ". $matching_log_level_1 .") and Slot " . $slot_bbb->slot_no . "(level ". $matching_log_level_2 .") Matched.";
		                        $arry_log['wallet_log_slot'] = $matching_log_earner;
		                        $arry_log['shop_id'] = $slot_info->shop_id;
		                        $arry_log['wallet_log_slot_sponsor'] = $slot_info->slot_id;
		                        $arry_log['wallet_log_details'] = $log;
		                        $arry_log['wallet_log_amount'] = $matching_log_earning;
		                        $arry_log['wallet_log_plan'] = "MEMBERSHIP_MATCHING";
		                        $arry_log['wallet_log_status'] = "n_ready";   
		                        $arry_log['wallet_log_claimbale_on'] = Mlm_complan_manager::cutoff_date_claimable('MEMBERSHIP_MATCHING', $slot_info->shop_id); 
		                        Mlm_slot_log::slot_array($arry_log);
                        	}
                        }
                        else
                        {
                        	$slot_aaa = Tbl_mlm_slot::where('slot_id', $matching_log_slot_1)->first();
	                        $slot_bbb = Tbl_mlm_slot::where('slot_id', $matching_log_slot_2)->first();
	                        $log = "Congratulations Your Slot " . $matching_log_earner . " Earned " . $matching_log_earning . " From Membership Matching. Slot " . $slot_aaa->slot_no . "(level ". $matching_log_level_1 .") and Slot " . $slot_bbb->slot_no . "(level ". $matching_log_level_2 .") Matched.";
	                        $arry_log['wallet_log_slot'] = $matching_log_earner;
	                        $arry_log['shop_id'] = $slot_info->shop_id;
	                        $arry_log['wallet_log_slot_sponsor'] = $slot_info->slot_id;
	                        $arry_log['wallet_log_details'] = $log;
	                        $arry_log['wallet_log_amount'] = $matching_log_earning;
	                        $arry_log['wallet_log_plan'] = "MEMBERSHIP_MATCHING";
	                        $arry_log['wallet_log_status'] = "n_ready";   
	                        $arry_log['wallet_log_claimbale_on'] = Mlm_complan_manager::cutoff_date_claimable('MEMBERSHIP_MATCHING', $slot_info->shop_id); 
	                        Mlm_slot_log::slot_array($arry_log);
                        }
                        Tbl_mlm_matching_log::insert($insert);
                        
                    }                  
                }
            }
        } 
        Mlm_complan_manager::membership_matching_cutoff('MEMBERSHIP_MATCHING', $slot_info->shop_id);  
        // $settings = Tbl_mlm_matching::membership_id('') 
    }
    public static function membership_matching_cutoff($code, $shop_id)
    {
        $now = Carbon::now();
        $wallet_log = Tbl_mlm_slot_wallet_log::where('shop_id', $shop_id)
        ->where('wallet_log_plan', $code)
        ->where('wallet_log_status', 'n_ready')
        ->where('wallet_log_claimbale_on', '<', Carbon::now()->addMinutes(1))
        ->get();  
        $cutoff_log = [];
        foreach($wallet_log as $key => $value)
        {
            $cutoff_log[$value->wallet_log_slot][$value->wallet_log_id] = $value->wallet_log_amount; 
        }
        if($cutoff_log != null)
        {
            foreach($cutoff_log as $key => $value)
            {
                foreach($value as $key2 => $value2)
                {
                    $update['wallet_log_status'] = 'released';
                    Tbl_mlm_slot_wallet_log::where('wallet_log_id', $key2)->update($update);
                }
            }
        }
    }
    // END MEMBERSHIP MATCHING

    // LEADERSHIP_BONUS
    public static function leadership_bonus($slot_info)
    {
        // $tree = Tbl_tree_sponsor::where('sponsor_tree_child_id', $slot_info->slot_id)->
        $membership_points_leadership = $slot_info->membership_points_leadership;
        $settings_combination = Tbl_mlm_leadership_settings::where('shop_id', $slot_info->shop_id)
                                    ->where('leadership_settings_start', '!=', 0)
                                    ->where('leadership_settings_end', '!=', 0)
                                    ->where('leadership_settings_earnings', '!=', 0)
                                    ->where('leadership_settings_required_points', '!=', 0)
                                    ->where('membership_id', $slot_info->membership_id)
                                    ->get()
                                    ->toArray();
                                    // dd($settings_combination);
        foreach($settings_combination as $key => $value)
        {
            $tree = Tbl_tree_sponsor::where('sponsor_tree_child_id', $slot_info->slot_id)
            ->where('sponsor_tree_level', '>=', $value['leadership_settings_start'])
            ->where('sponsor_tree_level', '<=', $value['leadership_settings_end'])
            ->distinct_level()
            ->get();
            // dd($tree);
            foreach($tree as  $key2 => $value2)
            {
                $array['points_log_complan'] = "LEADERSHIP_BONUS";
                $array['points_log_level'] = $value2->sponsor_tree_level;
                $array['points_log_slot'] = $value2->sponsor_tree_parent_id;
                $array['points_log_Sponsor'] = $slot_info->slot_id;
                $array['points_log_date_claimed'] = Carbon::now();
                $array['points_log_converted'] = 0;
                $array['points_log_converted_date'] = Carbon::now();
                $array['points_log_type'] = 'GPV';
                $array['points_log_from'] = 'Slot Creation';
                $array['points_log_points'] = $membership_points_leadership;

                Mlm_slot_log::slot_log_points_array($array);

                Mlm_complan_manager::leadership_bonus_2($value2->sponsor_tree_parent_id);
            }
        }      
        Mlm_complan_manager::leadership_bonus_cutoff('LEADERSHIP_BONUS', $slot_info->shop_id);                      

    }
    public static function leadership_bonus_2($slot_id)
    {
        $slot_info = Mlm_compute::get_slot_info($slot_id);

        $settings_combination = Tbl_mlm_leadership_settings::where('shop_id', $slot_info->shop_id)
                                    ->where('leadership_settings_start', '!=', 0)
                                    ->where('leadership_settings_end', '!=', 0)
                                    ->where('leadership_settings_earnings', '!=', 0)
                                    ->where('leadership_settings_required_points', '!=', 0)
                                    ->where('membership_id', $slot_info->membership_id)
                                    ->get()
                                    ->toArray();
        // $all_points = Tbl_mlm_slot_points_log::where('points_log_complan', 'LEADERSHIP_BONUS')->
        foreach($settings_combination as $key => $value)
        {
            $all_points = Tbl_mlm_slot_points_log::where('points_log_complan', 'LEADERSHIP_BONUS')
            ->where('points_log_level', '>=', $value['leadership_settings_start'])
            ->where('points_log_level', '<=', $value['leadership_settings_end'])
            ->where('points_log_slot', $slot_info->slot_id)->sum('points_log_points');

            // dd($all_points);
             if($all_points >= $value['leadership_settings_required_points'])
                {
                    $array['points_log_complan'] = "LEADERSHIP_BONUS";
                    $array['points_log_level'] = $value['leadership_settings_start'];
                    $array['points_log_slot'] = $slot_info->slot_id;
                    $array['points_log_Sponsor'] = $slot_info->slot_id;
                    $array['points_log_date_claimed'] = Carbon::now();
                    $array['points_log_converted'] = 0;
                    $array['points_log_converted_date'] = Carbon::now();
                    $array['points_log_type'] = 'GPV';
                    $array['points_log_from'] = 'Slot Creation';
                    $array['points_log_leve_start'] = $value['leadership_settings_start'];
                    $array['points_log_leve_end'] = $value['leadership_settings_end'];
                    $array['points_log_points'] = $value['leadership_settings_required_points'] * (-1);

                    Mlm_slot_log::slot_log_points_array($array);

                    $earn = $value['leadership_settings_earnings'];
                    $log = "Congratulations!, Your Slot ". $slot_info->slot_no . " has earned " . $value['leadership_settings_earnings'] . ' from Leadership Bonus. '. $value['leadership_settings_required_points'] . ' Leadership Points is deducted to your level ' . $value['leadership_settings_start'] .' to level '.$value['leadership_settings_end'] . ' leadership points' ;
                    $arry_log['wallet_log_slot'] =  $slot_info->slot_id;
                    $arry_log['shop_id'] =  $slot_info->shop_id;
                    $arry_log['wallet_log_slot_sponsor'] = $slot_info->slot_id;
                    $arry_log['wallet_log_details'] = $log;
                    $arry_log['wallet_log_amount'] = $value['leadership_settings_earnings'];
                    $arry_log['wallet_log_plan'] = "LEADERSHIP_BONUS";
                    $arry_log['wallet_log_status'] = "released";   
                    $arry_log['wallet_log_claimbale_on'] = Mlm_complan_manager::cutoff_date_claimable('EXECUTIVE_BONUS', $slot_info->shop_id); 
                    Mlm_slot_log::slot_array($arry_log);
                }

        }                            
    }
    public static function leadership_bonus_earn($slot_info)
    {
        if($slot_info)
        {
            $slot_tree = Tbl_tree_sponsor::where('sponsor_tree_child_id', $slot_info->slot_id)
                            ->parent_info()->get()->toArray();
                            // slot_membership
                          
            $settings_combination = Tbl_mlm_leadership_settings::where('shop_id', $slot_info->shop_id)
                                    ->where('leadership_settings_start', '!=', 0)
                                    ->where('leadership_settings_end', '!=', 0)
                                    ->where('leadership_settings_earnings', '!=', 0)
                                    ->where('leadership_settings_required_points', '!=', 0)
                                    ->get()
                                    ->toArray();
            $slot_sorted = [];
            foreach($slot_tree as $key => $value)
            {
                foreach($settings_combination as $key2 => $value2)
                {
                    if($value['slot_membership'] == $value2['membership_id'])
                    {
                        $affected_slots = Tbl_tree_sponsor::where('sponsor_tree_parent_id',  $value['slot_id'])
                        ->where('sponsor_tree_level', '>=', $value2['leadership_settings_start'])
                        ->where('sponsor_tree_level', '<=', $value2['leadership_settings_end'])
                        ->get()->toArray();

                        $sum = 0;
                        foreach($affected_slots as $key3 => $value3)
                        {
                            $sum += Tbl_mlm_slot_points_log::where('points_log_slot', $value3['sponsor_tree_child_id'])
                            ->where('points_log_complan', 'LEADERSHIP_BONUS')
                            ->where('points_log_type', 'GPV')
                            ->sum('points_log_points');
                        }
                        // points_log_level

                        $sum_out = Tbl_mlm_slot_points_log::where('points_log_slot', $value['slot_id'])
                            ->where('points_log_complan', 'LEADERSHIP_BONUS')
                            ->where('points_log_type', 'GPV_OUT')
                            ->where('points_log_leve_start', '>=',$value2['leadership_settings_start']) 
                            ->where('points_log_leve_end', '<=', $value2['leadership_settings_end'])
                            ->sum('points_log_points');

                        $sum_all =   $sum - $sum_out; 
                        // $slot_sorted[$value['slot_membership']][$value['slot_id']] = $sum_all;

                        if($sum_all >= $value2['leadership_settings_required_points'])
                        {
                            $array['points_log_complan'] = "LEADERSHIP_BONUS";
                            $array['points_log_level'] = 1;
                            $array['points_log_slot'] = $value['slot_id'];
                            $array['points_log_Sponsor'] = $value['slot_id'];
                            $array['points_log_date_claimed'] = Carbon::now();
                            $array['points_log_converted'] = 0;
                            $array['points_log_converted_date'] = Carbon::now();
                            $array['points_log_type'] = 'GPV_OUT';
                            $array['points_log_from'] = 'Slot Creation';
                            $array['points_log_leve_start'] = $value2['leadership_settings_start'] ;
                            $array['points_log_leve_end'] = $value2['leadership_settings_end'];
                            $array['points_log_points'] = $value2['leadership_settings_required_points'];

                            Mlm_slot_log::slot_log_points_array($array);
                            $slot = Tbl_mlm_slot::where('slot_id', $value['slot_id'])->first();
                            $log = "Congratulations!, Your Slot ". $slot->slot_no . " has earned " . $value2['leadership_settings_earnings'] . ' from Leadership Bonus. '. $value2['leadership_settings_required_points'] . ' Leadership Points is deducted to your level ' . $value2['leadership_settings_start'] .' to level '.$value2['leadership_settings_end'] . ' leadership points' ;
                            $arry_log['wallet_log_slot'] =  $value['slot_id'];
                            $arry_log['shop_id'] =  $value['shop_id'];
                            $arry_log['wallet_log_slot_sponsor'] = $value['slot_id'];
                            $arry_log['wallet_log_details'] = $log;
                            $arry_log['wallet_log_amount'] = $value2['leadership_settings_earnings'];
                            $arry_log['wallet_log_plan'] = "LEADERSHIP_BONUS";
                            $arry_log['wallet_log_status'] = "n_ready";   
                            $arry_log['wallet_log_claimbale_on'] = Mlm_complan_manager::cutoff_date_claimable('EXECUTIVE_BONUS', $slot_info->shop_id); 
                            Mlm_slot_log::slot_array($arry_log);

                            $slot_sorted[$value['slot_membership']][$value['slot_id']] = $sum_all;
                        }

                    }
                }
            }                      
        }
    }
    public static function leadership_bonus_cutoff($code, $shop_id)
    {
        $now = Carbon::now();
        $wallet_log = Tbl_mlm_slot_wallet_log::where('shop_id', $shop_id)
        ->where('wallet_log_plan', $code)
        ->where('wallet_log_status', 'n_ready')
        ->where('wallet_log_claimbale_on', '<', Carbon::now()->addMinutes(1))
        ->get();  
        $cutoff_log = [];
        foreach($wallet_log as $key => $value)
        {
            $cutoff_log[$value->wallet_log_slot][$value->wallet_log_id] = $value->wallet_log_amount; 
        }
        if($cutoff_log != null)
        {
            foreach($cutoff_log as $key => $value)
            {
                foreach($value as $key2 => $value2)
                {
                    $update['wallet_log_status'] = 'released';
                    Tbl_mlm_slot_wallet_log::where('wallet_log_id', $key2)->update($update);
                }
            }
        }
    }
    // END LEADERSHIP_BONUS
    
    // DIRECT POINTS
    public static function direct_points($slot_info)
    {
        $slot_sponsor = Tbl_mlm_slot::where('slot_id', $slot_info->slot_sponsor)->membership()->first();

        /* CHECK IF SLOT RECIPIENT EXIST */
        if($slot_sponsor)
        {
            if($slot_info->membership_points_direct_not_bonus != null || $slot_info->membership_points_direct_not_bonus != 0)
            {
                $array['points_log_complan'] = "DIRECT_POINTS";
                $array['points_log_level'] = 1;
                $array['points_log_slot'] = $slot_sponsor->slot_id;
                $array['points_log_Sponsor'] = $slot_info->slot_id;
                $array['points_log_date_claimed'] = Carbon::now();
                $array['points_log_converted'] = 0;
                $array['points_log_converted_date'] = Carbon::now();
                $array['points_log_type'] = 'PV';
                $array['points_log_from'] = 'Slot Creation';
                $array['points_log_points'] = $slot_info->membership_points_direct_not_bonus;

                Mlm_slot_log::slot_log_points_array($array);
            }
        }   
    }
    // END DIRECT POITS


    // INDIRECT POINTS
    public static function indirect_points($slot_info)
    {
        $settings_indirect = Tbl_mlm_indirect_points_settings::where('indirect_points_archive', 0)->get();
        $slot_tree = Tbl_tree_sponsor::child($slot_info->slot_id)->orderby("sponsor_tree_level", "asc")->distinct_level()->parentslot()->membership()->get();
        /* RECORD ALL INTO A SINGLE VARIABLE */
        $indirect_level = [];
        foreach($settings_indirect as $key => $level)
        {
            $value = $level->indirect_points_value;
            $indirect_level[$level->membership_id][$level->indirect_points_level] = $value;
        }
        // dd($indirect_level);
        /* CHECK IF LEVEL EXISTS */
        if($indirect_level)
        {
            foreach($slot_tree as $key => $tree)
            {
                /* COMPUTE FOR BONUS */
                if(isset($indirect_level[$tree->membership_id][$tree->sponsor_tree_level]))
                {
                    $indirect_bonus = $indirect_level[$slot_info->membership_id][$tree->sponsor_tree_level];    
                }
                else
                {
                    $indirect_bonus = 0;
                }
                /* CHECK IF BONUS IS ZERO */
                if($indirect_bonus != 0)
                {
                    $array['points_log_complan'] = "INDIRECT_POINTS";
                    $array['points_log_level'] = $tree->sponsor_tree_level;
                    $array['points_log_slot'] = $tree->sponsor_tree_parent_id;
                    $array['points_log_Sponsor'] = $tree->sponsor_tree_child_id;
                    $array['points_log_date_claimed'] = Carbon::now();
                    $array['points_log_converted'] = 0;
                    $array['points_log_converted_date'] = Carbon::now();
                    $array['points_log_type'] = 'PV';
                    $array['points_log_from'] = 'Slot Creation';
                    $array['points_log_points'] = $indirect_bonus;

                    Mlm_slot_log::slot_log_points_array($array);
                }
            }
        }
    }
    // END INDIRECT POINTS

    // INITIAL POINTS
    public static function initial_points($slot_info)
    {
        // $slot_sponsor = Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->membership()->first();

        /* CHECK IF SLOT RECIPIENT EXIST */
        if($slot_info)
        {
            if($slot_info->membership_points_initial_points != null || $slot_info->membership_points_initial_points != 0)
            {
                $array['points_log_complan'] = "INITIAL_POINTS";
                $array['points_log_level'] = 0;
                $array['points_log_slot'] = $slot_info->slot_id;
                $array['points_log_Sponsor'] = $slot_info->slot_id;
                $array['points_log_date_claimed'] = Carbon::now();
                $array['points_log_converted'] = 0;
                $array['points_log_converted_date'] = Carbon::now();
                $array['points_log_type'] = 'PV';
                $array['points_log_from'] = 'Slot Creation';
                $array['points_log_points'] = $slot_info->membership_points_initial_points;

                Mlm_slot_log::slot_log_points_array($array);
            }
        }   
    }
    // END INITIAL POITS

    // Discount Card
    public static function discount_card($slot_info)
    {
        $membership_id = $slot_info->slot_membership;
        $settings = Tbl_mlm_discount_card_settings::where('membership_id', $membership_id)->first();
        if($settings)
        {
            if($settings != null)
            {
                if($settings->discount_card_count_membership != 0)
                {
                    $count = $settings->discount_card_count_membership;
                    for ($i = 1; $i <= $count; $i++) 
                    {
                        $insert['discount_card_log_date_created'] = Carbon::now();
                        $insert['discount_card_slot_sponsor'] = $slot_info->slot_id;
                        $insert['discount_card_customer_sponsor'] = $slot_info->slot_owner;
                        $insert['discount_card_membership'] = $settings->discount_card_membership;
                        $insert['discount_card_log_code'] = Membership_code::random_code_generator(8);
                        Tbl_mlm_discount_card_log::insert($insert);
                    }
                }
            }
        }

        // Tbl_mlm_discount_card_log
        // Tbl_mlm_discount_card_settings
    }
    // End discount Card

    public static function direct_promotions($slot_info)
    {
        $slot_sponsor = Tbl_mlm_slot::where('slot_id', $slot_info->slot_sponsor)->membership()->first();
        /* CHECK IF SLOT RECIPIENT EXIST */
        if($slot_sponsor)
        {
            $membership = Tbl_membership::where('shop_id', $slot_info->shop_id) ->where('membership_archive', 0)->get();
            foreach($membership as $key => $value)
            {
                $direct_promotion = DB::table('tbl_mlm_plan_settings_direct_promotions')->where('shop_id', $slot_sponsor->shop_id)->where('membership_id', $value->membership_id)->first();
                if($direct_promotion)
                {
                    /* Count Direct */
                    // $count_direct = Tbl_tree_sponsor::where('sponsor_tree_parent_id', $slot_sponsor->slot_id)->where('sponsor_tree_level', 1)
                    // ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_tree_sponsor.sponsor_tree_child_id')
                    // ->where('slot_membership', $value->membership_id)
                    // ->where('slot_matched_membership', 0)
                    // ->count();

                    $count_direct = Tbl_mlm_slot::where('slot_sponsor', $slot_sponsor->slot_id)
                    ->where('slot_membership', $value->membership_id)
                    ->where('slot_matched_membership', 0)
                    ->count();
                    
                    
                    if(isset($direct_promotion->settings_direct_promotions_count))
                    {
                        if($direct_promotion->settings_direct_promotions_count != 0)
                        {
                            if($direct_promotion->settings_direct_promotions_bonus != 0)
                            {
                                $count_income = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', $slot_sponsor->slot_id)->where('wallet_log_plan', 'DIRECT_PROMOTIONS')
                                ->where('wallet_log_membership_filter', $value->membership_id)
                                ->count();
                                $mod = $count_direct - ($count_income * $direct_promotion->settings_direct_promotions_count);
                                $mod2 = round($mod, 0, PHP_ROUND_HALF_DOWN);
                                $mod2 = $mod;

                                
                                if($mod2 >= $direct_promotion->settings_direct_promotions_count)
                                {
                                    $mod4 = $mod/$direct_promotion->settings_direct_promotions_count;
                                    $mod3 = round($mod4, 0, PHP_ROUND_HALF_DOWN);
                                    for($i = 0; $i < $mod3; $i++ )
                                    {
                                        $plan = Tbl_mlm_plan::where('marketing_plan_code', 'DIRECT_PROMOTIONS')->where('shop_id', $slot_info->shop_id)->first();
                                        if($direct_promotion->settings_direct_promotions_type == 0)
                                        {
                                            for($z = 0; $z < $direct_promotion->settings_direct_promotions_bonus; $z++ )
                                            {
                                                $insert['discount_card_log_date_created'] = Carbon::now();
                                                $insert['discount_card_slot_sponsor'] = $slot_sponsor->slot_id;
                                                $insert['discount_card_customer_sponsor'] = $slot_sponsor->slot_owner;
                                                $insert['discount_card_membership'] = 1;
                                                $insert['discount_card_log_code'] = Membership_code::random_code_generator(8);
                                                Tbl_mlm_discount_card_log::insert($insert);
                                                // return $mod3;
                                            }
                                            $log = 'Congratulations you earned ' . $direct_promotion->settings_direct_promotions_bonus . ' Discount Card thru ' . $plan->marketing_plan_label .'. You can check your other Discount Card at the Report, Discount Card Tab.';
                                        }
                                        else if($direct_promotion->settings_direct_promotions_type == 1)
                                        {
                                            $insert['mlm_gc_tag'] = 'DIP';
                                            $insert['mlm_gc_code'] = Mlm_gc::random_code_generator(8, $slot_sponsor->slot_id, $insert['mlm_gc_tag']);
                                            $insert['mlm_gc_amount'] = $direct_promotion->settings_direct_promotions_bonus;
                                            $insert['mlm_gc_member'] = $slot_sponsor->slot_owner;
                                            $insert['mlm_gc_slot'] = $slot_sponsor->slot_id;
                                            $insert['mlm_gc_date'] = Carbon::now();
                                            Tbl_mlm_gc::insert($insert);

                                            $log = 'Congratulations you earned ' . $direct_promotion->settings_direct_promotions_bonus . ' GC thru ' . $plan->marketing_plan_label .'. You can check your other G.C. at the Gift Certificates Tab.';
                                        }
                                        
                                        $arry_log['wallet_log_slot'] = $slot_sponsor->slot_id;
                                        $arry_log['shop_id'] = $slot_sponsor->shop_id;
                                        $arry_log['wallet_log_slot_sponsor'] = $slot_info->slot_id;
                                        $arry_log['wallet_log_details'] = $log;
                                        $arry_log['wallet_log_amount'] = 0;
                                        $arry_log['wallet_log_plan'] = "DIRECT_PROMOTIONS";
                                        $arry_log['wallet_log_status'] = "n_ready"; 
                                        $arry_log['wallet_log_membership_filter'] = $value->membership_id;
                                        $arry_log['wallet_log_claimbale_on'] = Carbon::now(); 
                                        Mlm_slot_log::slot_array($arry_log);

                                    }
                                    // return $mod3;
                                }
                                // return $mod2;
                                
                            }
                        }
                    }
                }
            }
            
        }   
    }



    // OTHER FUNCTIONS
    public static function date_current($type)
    {
        return Carbon::now()->format($type);
    }
    public static function cutoff_date_claimable($code, $shop_id)
    {
        // Cut off Date Defending on the date set on mlm plan
        $plan = Tbl_mlm_plan::where('shop_id', $shop_id)
        ->where('marketing_plan_code', $code)
        ->where('marketing_plan_enable', 1)
        ->where('marketing_plan_trigger', 'Slot Creation')
        ->first();
        if($plan != null)
        {
            // marketing_plan_release_schedule
            // 1 = instant; 2 = dailay; 3 = weekly; 4 = monthly
            $hours = Carbon::parse($plan->marketing_plan_release_time)->format('H:i:s');
            $hours = explode(':',$hours);
            $current_day        = Mlm_complan_manager::date_current('d');
            $current_week_day   = strtolower(Mlm_complan_manager::date_current('l'));
            $current_month      = Carbon::now()->day;
            $current_year       = Mlm_complan_manager::date_current('Y');
            if($plan->marketing_plan_release_schedule == 1)
            {
                return Carbon::now();
            }
            else if($plan->marketing_plan_release_schedule == 2)
            {
                return Carbon::now()->addDays(1)->setTime($hours[0], $hours[1], $hours[2]);
            }
            else if($plan->marketing_plan_release_schedule == 3)
            {
                if($plan->marketing_plan_release_weekly == $current_week_day)
                {
                    return Carbon::now()->addWeeks(7)->setTime($hours[0], $hours[1], $hours[2]);
                }
                else
                {
                    return  Carbon::parse('next '. $plan->marketing_plan_release_weekly)->setTime($hours[0], $hours[1], $hours[2]);
                }
            }
            else if($plan->marketing_plan_release_schedule == 4)
            {
                if($plan->marketing_plan_release_monthly == $current_month)
                {
                    return Carbon::now()->addMonths(1)->setTime($hours[0], $hours[1], $hours[2]);
                }
                else
                {
                    return Carbon::now()->day($plan->marketing_plan_release_monthly)->setTime($hours[0], $hours[1], $hours[2]);
                }
            }

        }
        return Carbon::now();
    }
    public static function compare_date($date1, $date2, $compare)
    {
        $date1_carbon = Carbon::parse($date1);
        $date2_carbon = Carbon::parse($date2);
        if($compare == 'year')
        {
            if($date1_carbon->format('Y') == $date2_carbon->format('Y'))
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
        if($compare == 'month')
        {
            if($date1_carbon->format('Y') == $date2_carbon->format('Y'))
            {
                if($date1_carbon->format('n') == $date2_carbon->format('n'))
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return 0;
            }
        }
        if($compare == 'day')
        {
            if($date1_carbon->format('Y') == $date2_carbon->format('Y'))
            {
                if($date1_carbon->format('n') == $date2_carbon->format('n'))
                {
                    if($date1_carbon->format('j') == $date2_carbon->format('j'))
                    {
                        return 1;
                    }
                    else
                    {
                        return 0;
                    }                
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return 0;
            }
        }
    }
    public static function show_income($shop_id)
    {
        $log = Tbl_mlm_slot_wallet_log::where('shop_id', $shop_id)->get();
        echo '<link rel="stylesheet" href="/assets/member/styles/92bc1fe4.bootstrap.css">';
        echo "<table class='table'>";
        echo "<tr><th>Sponsor</th><th>Earner</th><th>Amount</th><th>PLAN</th><th>DATE</th><th>LOG</th></tr>";
        foreach($log as $key => $value)
        {
            echo "<tr>";
            echo    "<td>".$value->wallet_log_slot_sponsor."</td>";
            echo    "<td>".$value->wallet_log_slot."</td>";
            echo    "<td>".$value->wallet_log_amount."</td>";
            echo    "<td>".$value->wallet_log_plan."</td>";
            echo    "<td>".$value->wallet_log_date_created."</td>";
            echo    "<td>".$value->wallet_log_details."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo '<script src="/assets/member/scripts/e1d08589.bootstrap.min.js"></script>';
    }
    // END OTHER FUNCTIONS

}