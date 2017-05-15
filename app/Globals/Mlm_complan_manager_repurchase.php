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
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_mlm_item_points;
use App\Models\Tbl_mlm_unilevel_points_settings;
use App\Models\Tbl_mlm_stairstep_settings;
use App\Models\Tbl_mlm_stairstep_points_settings;
use App\Models\Tbl_item_code_invoice;
use App\Models\Tbl_mlm_triangle_repurchase;
use App\Models\Tbl_mlm_triangle_repurchase_slot;
use App\Models\Tbl_mlm_discount_card_settings;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_mlm_triangle_repurchase_tree;

use App\Http\Controllers\Member\MLM_MembershipController;
use App\Http\Controllers\Member\MLM_ProductController;

use Schema;
use Session;
use DB;

use Carbon\Carbon;

use App\Globals\Mlm_compute;
use App\Globals\Mlm_slot_log;
use App\Globals\Mlm_complan_manager_repurchase;
use App\Globals\Mlm_tree;
use App\Globals\Membership_code;




class Mlm_complan_manager_repurchase
{   
    public static function unilevel($slot_info, $item_code_id)
    {
        $slot_info     = Tbl_mlm_slot::where("slot_id", $slot_info->slot_id)->customer()->membership()->first();
        $item_code     = Tbl_item_code::where("item_code_id",$item_code_id)->first(); 

        if($item_code)
        {

            $mlm_item_points  = Tbl_mlm_item_points::where("item_id",$item_code->item_id)
            ->where('membership_id', $slot_info->membership_id)
            ->first();

            if($mlm_item_points)
            {
                $unilevel_pts = $mlm_item_points->UNILEVEL;
            }
            else
            {
                $unilevel_pts = 0;
            }
        }
        else
        {
            $unilevel_pts = 0;
        }
        $_unilevel_setting = Tbl_mlm_unilevel_settings::get();
        $_tree             = Tbl_tree_sponsor::child($slot_info->slot_id)->level()->distinct_level()->get();

        $unilevel_level = [];
        $unilevel_level_settings = [];
        foreach($_unilevel_setting as $key => $level)
        {
            $unilevel_level[$level->membership_id][$level->unilevel_settings_level] =  $level->unilevel_settings_amount;
            $unilevel_level_settings[$level->membership_id][$level->unilevel_settings_level] =  $level->unilevel_settings_type;
            $unilevel_level_settings_percentage[$level->membership_id][$level->unilevel_settings_level] =  $level->unilevel_settings_percent;
        }
        foreach($_tree as $key => $tree)
        {
            $slot_recipient = Mlm_compute::get_slot_info($tree->sponsor_tree_parent_id);
            if(isset($unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]))
            {
                      
                $settings = $unilevel_level_settings[$slot_recipient->membership_id][$tree->sponsor_tree_level];
                $percentage = $unilevel_level_settings_percentage[$slot_recipient->membership_id][$tree->sponsor_tree_level];
                // 0 = fixed
                // 1 = percentage
                if($percentage === 0)
                {
                    $unilevel_bonus = $unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level];
                }
                else
                {
                    $unilevel_bonus = ($unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]/100) * $unilevel_pts;
                }
            }

            else
            {
                $unilevel_bonus = 0;  
            }
            if($unilevel_bonus != 0)
            {
                // 0 = points
                // 1 = cash
                if($settings === 0)
                {
                    $array['points_log_complan'] = "UNILEVEL";
                    $array['points_log_level'] = $tree->sponsor_tree_level;
                    $array['points_log_slot'] = $slot_recipient->slot_id;
                    $array['points_log_Sponsor'] = $slot_info->slot_id;
                    $array['points_log_date_claimed'] = Carbon::now();
                    $array['points_log_converted'] = 0;
                    $array['points_log_converted_date'] = Carbon::now();
                    $array['points_log_type'] = 'GPV';
                    $array['points_log_from'] = 'Product Repurchase';
                    $array['points_log_points'] = $unilevel_bonus;

                    Mlm_slot_log::slot_log_points_array($array);
                }
                else
                {
                    $log_array['earning'] = $unilevel_bonus;
                    $log_array['level'] = $tree->sponsor_tree_level;
                    $log_array['level_tree'] = 'Sponsor Tree';
                    $log_array['complan'] = 'UNILEVEL';

                    $log = Mlm_slot_log::log_constructor($slot_recipient, $slot_info,  $log_array);

                    $arry_log['wallet_log_slot'] = $slot_recipient->slot_id;
                    $arry_log['shop_id'] = $slot_info->shop_id;
                    $arry_log['wallet_log_slot_sponsor'] = $slot_info->slot_id;
                    $arry_log['wallet_log_details'] = $log;
                    $arry_log['wallet_log_amount'] = $unilevel_bonus;
                    $arry_log['wallet_log_plan'] = "UNILEVEL";
                    $arry_log['wallet_log_status'] = "n_ready";   
                    $arry_log['wallet_log_claimbale_on'] = Mlm_complan_manager::cutoff_date_claimable('DIRECT', $slot_info->shop_id); 
                    Mlm_slot_log::slot_array($arry_log);
                }
            }
        }
        Mlm_complan_manager_repurchase::unilevel_cutoff('UNILEVEL', $slot_info->shop_id);  
    }
    public static function unilevel_cutoff($code, $shop_id)
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
    public static function unilevel_v2($slot_info,$item_code_id)
    {
        
        /* ----- COMPUTATION OF PERSONAL PV */
        $update_recipient["slot_personal_points"] = $slot_info->slot_personal_points + $unilevel_pts;

        dd($update_recipient["slot_personal_points"]);
        /* UPDATE SLOT CHANGES TO DATABASE */
        Tbl_mlm_slot::where("slot_id",$slot_info->slot_id)->update($update_recipient);
        $update_recipient  = null;

        /* ----- COMPUTATION OF GROUP PV ----- */
        $_unilevel_setting = Tbl_mlm_unilevel_settings::get();
        $_tree             = Tbl_tree_sponsor::child($slot_info->slot_id)->level()->distinct_level()->get();

        /* RECORD ALL INTO A SINGLE VARIABLE */
        $unilevel_level = null;
        foreach($_unilevel_setting as $key => $level)
        {
            $unilevel_level[$level->membership_id][$level->unilevel_settings_level] =  $level->unilevel_settings_amount;
        }

            /* CHECK IF LEVEL EXISTS */
            if($unilevel_level)
            {
                foreach($_tree as $key => $tree)
                {
                    /* GET SLOT INFO FROM DATABASE */
                    $slot_recipient                          = Tbl_mlm_slot::where("slot_id",$tree->sponsor_tree_parent_id)->customer()->membership()->first();
                    $update_recipient["slot_group_points"]   = $slot_recipient->slot_group_points;
                    $update_recipient["slot_upgrade_points"] = $slot_recipient->slot_upgrade_points;

                    /* COMPUTE FOR BONUS */
                    if(isset($unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]))
                    {
                        $unilevel_bonus = ($unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]/100) * $unilevel_pts;      
                    }
                    else
                    {
                        $unilevel_bonus = 0;  
                    }

                    /* CHECK IF BONUS IS ZERO */
                    if($unilevel_bonus != 0)
                    {
                        /* UPDATE GROUP PTS */
                        $update_recipient["slot_group_points"]  = $update_recipient["slot_group_points"] + $unilevel_bonus;
                    }
                    Tbl_mlm_slot::where("slot_id",$slot_recipient->slot_id)->update($update_recipient);
                }
            }            
    }
    public static function binary_repurchase($slot_info,$item_code_id)
    {

        $item_code     = Tbl_item_code::where("item_code_id",$item_code_id)->first();

        if($item_code)
        {
            $mlm_item_points  = Tbl_mlm_item_points::where("item_id",$item_code->item_id)->first();

            if($mlm_item_points)
            {
                $binary_pts = $mlm_item_points->BINARY_REPURCHASE;
            }
            else
            {
                $binary_pts = 0;
            }
        }
        else
        {
            $binary_pts = 0;
        }


        /* FOR PS ONLY or CD Turned PS */
        // GET PAIRING SETTINGS / BINARY TREE
        $settings_pairing       = Tbl_mlm_binary_pairing::orderBy("pairing_point_left", "desc")->get();
        $binary_advance_pairing = Tbl_mlm_binary_setttings::where('shop_id', $slot_info->shop_id)->first();

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

        // end

        // DISTRIBUTE BINARY POINTS
        foreach($settings_tree as $tree)
        {
            // RETRIEVE LEFT & RIGHT POINTS
            $binary["left"] = $tree->slot_binary_left;
            $binary["right"] = $tree->slot_binary_right; 
            // END

            // GET BINARY POINTS OF MEMBERSHIP
            $binary['points'] = $unilevel_pts  = $binary_pts;
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

    public static function stairstep($slot_info,$item_code_id)
    {
        $slot_info     = Tbl_mlm_slot::where("slot_id", $slot_info->slot_id)->customer()->membership()->first();
        $shop_id       = $slot_info->shop_id;
        $item_code     = Tbl_item_code::where("item_code_id",$item_code_id)->first(); 
        if($item_code)
        {
            $mlm_item_points  = Tbl_mlm_item_points::where("item_id",$item_code->item_id)
            ->where('membership_id', $slot_info->membership_id)
            ->first();

            if($mlm_item_points)
            {
                $stairstep_points = $mlm_item_points->STAIRSTEP;
            }
            else
            {
                $stairstep_points = 0;
            }
        }
        else
        {
            $stairstep_points = 0;
        }

        if($stairstep_points != 0)
        {
            $array['points_log_complan'] = "STAIRSTEP";
            $array['points_log_level'] = 0;
            $array['points_log_slot'] = $slot_info->slot_id;
            $array['points_log_Sponsor'] = $slot_info->slot_id;
            $array['points_log_date_claimed'] = Carbon::now();
            $array['points_log_converted'] = 0;
            $array['points_log_converted_date'] = Carbon::now();
            $array['points_log_type'] = 'RPV';
            $array['points_log_from'] = 'Stairstep Points';
            $array['points_log_points'] = $stairstep_points;

            Mlm_slot_log::slot_log_points_array($array);
        }

        $array               = null;
        $_stairstep_settings = Tbl_mlm_stairstep_points_settings::where("shop_id",$shop_id)->get();
        $_tree               = Tbl_tree_sponsor::child($slot_info->slot_id)->level()->distinct_level()->get();

        $stairstep_level = [];

        foreach($_stairstep_settings as $key => $level)
        {
            $stairstep_level[$level->stairstep_points_level]                     =  $level->stairstep_points_amount;
            $stairstep_level_settings_percentage[$level->stairstep_points_level] =  $level->stairstep_points_percentage;
        }

        foreach($_tree as $key => $tree)
        {
            $slot_recipient = Mlm_compute::get_slot_info($tree->sponsor_tree_parent_id);
            if(isset($stairstep_level[$tree->sponsor_tree_level]))
            {      
                // 0 = fixed
                // 1 = percentage
                $percentage = $stairstep_level_settings_percentage[$tree->sponsor_tree_level];
                if($percentage === 0)
                {
                    $stairstep_bonus = $stairstep_level[$tree->sponsor_tree_level];
                }
                else
                {
                    $stairstep_bonus = ($stairstep_level[$tree->sponsor_tree_level]/100) * $stairstep_points;
                }
            }
            else
            {
                $stairstep_bonus = 0;  
            }


            if($stairstep_bonus != 0)
            {
                    $array['points_log_complan']        = "STAIRSTEP";
                    $array['points_log_level']          = $tree->sponsor_tree_level;
                    $array['points_log_slot']           = $slot_recipient->slot_id;
                    $array['points_log_Sponsor']        = $slot_info->slot_id;
                    $array['points_log_date_claimed']   = Carbon::now();
                    $array['points_log_converted']      = 0;
                    $array['points_log_converted_date'] = Carbon::now();
                    $array['points_log_type']           = 'RGPV';
                    $array['points_log_from']           = 'Product Repurchase';
                    $array['points_log_points']         = $stairstep_bonus;

                    Mlm_slot_log::slot_log_points_array($array);
            }
        }
        Mlm_complan_manager_repurchase::stairstep_cutoff('STAIRSTEP', $slot_info->shop_id);  
    }

    public static function stairstep_cutoff($code,$slot_info)
    { 

        // $placement_tree  = Tbl_tree_placement::where("placement_tree_child_id",$slot_info->slot_id)->orderBy("placement_tree_level","ASC")->get();
        // $percentage      = null;
        // $check_stairstep = Tbl_mlm_stairstep_settings::where("shop_id",$slot_info->shop_id)->first();
        // $slot_pv         = $unilevel_pts;

        // if($check_stairstep)
        // {
        //     foreach($placement_tree as $placement)
        //     {
        //         $reduced_percent = 0;
        //         $owned_pv        = Tbl_mlm_slot_points_log::where("points_log_slot",$placement->placement_tree_parent_id)->where("points_log_type","PV")->sum("points_log_points");
        //         $owned_gpv       = Tbl_mlm_slot_points_log::where("points_log_slot",$placement->placement_tree_parent_id)->where("points_log_type","GPV")->sum("points_log_points");
        //         if($owned_pv == null)
        //         {
        //             $owned_pv = 0;
        //         }                

        //         if($owned_gpv == null)
        //         {
        //             $owned_gpv = 0;
        //         }

        //         $computed_points = 0;

        //         if(!$percentage)
        //         {
        //             $slot_stairstep = Tbl_mlm_stairstep_settings::where("shop_id",$slot_info->shop_id)
        //                                                     ->where("stairstep_required_pv","<=",$owned_pv)
        //                                                     ->where("stairstep_required_gv","<=",$owned_gpv)
        //                                                     ->orderBy("stairstep_level","DESC")
        //                                                     ->first();

        //             if($slot_stairstep->stairstep_bonus != 0)
        //             {
        //                 $computed_points = ($slot_stairstep->stairstep_bonus/100) * $slot_pv;
        //             }         

        //             $percentage      = $slot_stairstep->stairstep_bonus;
        //             $reduced_percent = $slot_stairstep->stairstep_bonus;
        //         }
        //         else
        //         {
        //             $slot_stairstep = Tbl_mlm_stairstep_settings::where("shop_id",$slot_info->shop_id)
        //                                                     ->where("stairstep_required_pv","<=",$owned_pv)
        //                                                     ->where("stairstep_required_gv","<=",$owned_gpv)
        //                                                     ->orderBy("stairstep_level","DESC")
        //                                                     ->first();
                                                            
        //             if($slot_stairstep->stairstep_bonus > $percentage)
        //             { 
        //                 if($slot_stairstep->stairstep_bonus != 0)
        //                 {
        //                     $reduced_percent = $slot_stairstep->stairstep_bonus - $percentage;
        //                     if($reduced_percent > 0)
        //                     {
        //                         $computed_points = (($reduced_percent)/100) * $slot_pv;
        //                         $percentage      = $slot_stairstep->stairstep_bonus;
        //                     }
        //                 }    
        //             }
        //         }

        //         if($computed_points > 0)
        //         {             
        //             $log                                    = "You earned ".$reduced_percent."% of ".$unilevel_pts."(".$computed_points.") from slot #".$slot_info->slot_id."(Current Rank:".$slot_stairstep->stairstep_name.").";
        //             $arry_log['wallet_log_slot']            = $placement->placement_tree_parent_id;
        //             $arry_log['shop_id']                    = $slot_info->shop_id;
        //             $arry_log['wallet_log_slot_sponsor']    = $placement->placement_tree_parent_id;
        //             $arry_log['wallet_log_details']         = $log;
        //             $arry_log['wallet_log_amount']          = $computed_points;
        //             $arry_log['wallet_log_plan']            = "STAIRSTEP";
        //             $arry_log['wallet_log_status']          = "n_ready";   
        //             $arry_log['wallet_log_claimbale_on']    = Mlm_complan_manager::cutoff_date_claimable('STAIRSTEP', $slot_info->shop_id); 
        //             Mlm_slot_log::slot_array($arry_log);    
        //         }
        //     }
        // }
    }

    public static function repurchase_points($slot_info,$item_code_id)
    {
        $item_code     = Tbl_item_code::where("item_code_id",$item_code_id)->first(); 
        if($item_code)
        {
            $mlm_item_points  = Tbl_mlm_item_points::where("item_id",$item_code->item_id)
            ->where('membership_id', $slot_info->membership_id)
            ->first();
            // $percentage = ($slot_info->membership_points_repurchase / 100);
            $percentage = 1;
            if($mlm_item_points)
            {
                $membership_points_repurchase = $mlm_item_points->REPURCHASE_POINTS * $percentage;
            }
            else
            {
                $membership_points_repurchase = 0;
            }
        }
        else
        {
            $membership_points_repurchase = 0;
        }
        if($membership_points_repurchase != 0)
        {
            $array['points_log_complan'] = "REPURCHASE_POINTS";
            $array['points_log_level'] = 0;
            $array['points_log_slot'] = $slot_info->slot_id;
            $array['points_log_Sponsor'] = $slot_info->slot_id;
            $array['points_log_date_claimed'] = Carbon::now();
            $array['points_log_converted'] = 0;
            $array['points_log_converted_date'] = Carbon::now();
            $array['points_log_type'] = 'PV';
            $array['points_log_from'] = 'Product Repurchase';
            $array['points_log_points'] = $membership_points_repurchase;

            Mlm_slot_log::slot_log_points_array($array);
        }
    }
    public static function repurchase_cashback($slot_info,$item_code_id)
    {
       $item_code     = Tbl_item_code::where("item_code_id",$item_code_id)->first();  
       if($item_code)
        {
            $mlm_item_points  = Tbl_mlm_item_points::where("item_id",$item_code->item_id)
            ->where('membership_id', $slot_info->membership_id)
            ->first();
            // $percentage = ($slot_info->membership_points_repurchase_cashback / 100);
            $percentage = 1;
            if($mlm_item_points)
            {
                $membership_points_repurchase_cashback = $mlm_item_points->REPURCHASE_CASHBACK * $percentage;
            }
            else
            {
                $membership_points_repurchase_cashback = 0;

            }
        }
        if($membership_points_repurchase_cashback != 0)
        {
            $log_array['earning'] = $membership_points_repurchase_cashback;
            $log_array['level'] = 0;
            $log_array['level_tree'] = 'Sponsor Tree';
            $log_array['complan'] = 'REPURCHASE_CASHBACK';

            $log = Mlm_slot_log::log_constructor($slot_info, $slot_info,  $log_array);

            $arry_log['wallet_log_slot'] = $slot_info->slot_id;
            $arry_log['shop_id'] = $slot_info->shop_id;
            $arry_log['wallet_log_slot_sponsor'] = $slot_info->slot_id;
            $arry_log['wallet_log_details'] = $log;
            $arry_log['wallet_log_amount'] = $membership_points_repurchase_cashback;
            $arry_log['wallet_log_plan'] = "REPURCHASE_CASHBACK";
            $arry_log['wallet_log_status'] = "n_ready";   
            $arry_log['wallet_log_claimbale_on'] = Mlm_complan_manager::cutoff_date_claimable('REPURCHASE_CASHBACK', $slot_info->shop_id); 
            Mlm_slot_log::slot_array($arry_log);
        }
    }
    public static function unilevel_repurchase_points($slot_info, $item_code_id)
    {
        $slot_info     = Tbl_mlm_slot::where("slot_id", $slot_info->slot_id)->customer()->membership()->first();
        $item_code     = Tbl_item_code::where("item_code_id",$item_code_id)->first(); 
        if($item_code)
        {
            $mlm_item_points  = Tbl_mlm_item_points::where("item_id",$item_code->item_id)
            ->where('membership_id', $slot_info->membership_id)
            ->first();
            if($mlm_item_points)
            {
                $unilevel_pts = $mlm_item_points->UNILEVEL_REPURCHASE_POINTS;
            }
            else
            {
                $unilevel_pts = 0;
            }
        }
        else
        {
            $unilevel_pts = 0;
        }
        $_unilevel_setting = Tbl_mlm_unilevel_points_settings::where('unilevel_points_archive', 0)->get();
        $_tree             = Tbl_tree_sponsor::child($slot_info->slot_id)->level()->distinct_level()->get();

        $unilevel_level = [];
        $unilevel_level_settings = [];
        foreach($_unilevel_setting as $key => $level)
        {
            $unilevel_level[$level->membership_id][$level->unilevel_points_level] =  $level->unilevel_points_amount;
            $unilevel_level_settings_percentage[$level->membership_id][$level->unilevel_points_level] =  $level->unilevel_points_percentage;
        }
        foreach($_tree as $key => $tree)
        {
            $slot_recipient = Mlm_compute::get_slot_info($tree->sponsor_tree_parent_id);
            if(isset($unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]))
            {
                $percentage = $unilevel_level_settings_percentage[$slot_recipient->membership_id][$tree->sponsor_tree_level];
                // 0 = fixed
                // 1 = percentage
                if($percentage === 0)
                {
                    $unilevel_bonus = $unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level];
                }
                else
                {
                    $unilevel_bonus = ($unilevel_level[$slot_recipient->membership_id][$tree->sponsor_tree_level]/100) * $unilevel_pts;
                }
            }
            else
            {
                $unilevel_bonus = 0;  
            }
            if($unilevel_bonus != 0)
            {
                $array['points_log_complan'] = "UNILEVEL_REPURCHASE_POINTS";
                $array['points_log_level'] = $tree->sponsor_tree_level;
                $array['points_log_slot'] = $slot_recipient->slot_id;
                $array['points_log_Sponsor'] = $slot_info->slot_id;
                $array['points_log_date_claimed'] = Carbon::now();
                $array['points_log_converted'] = 0;
                $array['points_log_converted_date'] = Carbon::now();
                $array['points_log_type'] = 'GPV';
                $array['points_log_from'] = 'Product Repurchase';
                $array['points_log_points'] = $unilevel_bonus;
                Mlm_slot_log::slot_log_points_array($array);
            }
        }
        Mlm_complan_manager_repurchase::unilevel_cutoff('UNILEVEL_REPURCHASE_POINTS', $slot_info->shop_id);
    }
    
    public static function discount_card_repurchase($slot_info, $item_code_id)
    {
        $item_code     = Tbl_item_code::where("item_code_id",$item_code_id)->first();  
       if($item_code)
        {
            $mlm_item_points  = Tbl_mlm_item_points::where("item_id",$item_code->item_id)
            ->where('membership_id', $slot_info->membership_id)
            ->first();
            $dc_count = 0;
            if($mlm_item_points)
            {
                $dc_count = $mlm_item_points->DISCOUNT_CARD_REPURCHASE;
            }
            else
            {
                $dc_count = 0;

            }
        }
        if($dc_count != 0)
        {
            $membership_id = $slot_info->slot_membership;
            $settings = Tbl_mlm_discount_card_settings::where('membership_id', $membership_id)->first();
            for($i = 0; $i < $dc_count; $i++)
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
    public static function triangle_repurchase($slot_info, $item_code_id)
    {
        ini_set('xdebug.max_nesting_level', 500);
        $item_code = Tbl_item_code::where('item_code_id', $item_code_id)->first();
        if($item_code)
        {
            $invoice = Tbl_item_code_invoice::where('item_code_invoice_id', $item_code->item_code_invoice_id)->first();

            if($invoice)
            {
                $amount = $invoice->item_subtotal;
                Mlm_complan_manager_repurchase::triangle_repurchase_amount($slot_info, $amount, $item_code->item_code_invoice_id);
            }
        }
    }
    public static function triangle_repurchase_amount($slot_info, $amount, $invoice_id)
    {
        $shop_id =  $slot_info->shop_id;
        $settings = Tbl_mlm_triangle_repurchase::where('shop_id', $shop_id)
        ->where('membership_id', $slot_info->membership_id)  
        ->first();
        if($settings)
        {
            if($settings->triangle_repurchase_amount != 0 || $settings->triangle_repurchase != null)
            {
                $mod = floor($amount/ $settings->triangle_repurchase_amount);

                $count_i = Tbl_mlm_triangle_repurchase_slot::where('repurchase_slot_invoice_id', $invoice_id)->count();
                if($count_i == 0)
                {
                    if($mod >= 1)
                    {
                        for($i = 0; $i < $mod; $i++)
                        {
                            // repurchase_slot_no
                            $insert['repurchase_slot_owner'] = $slot_info->customer_id;
                            $insert['repurchase_slot_slot_id'] = $slot_info->slot_id;
                            $insert['repurchase_slot_invoice_id'] = $invoice_id;
                            $insert['repurchase_slot_amount'] = $settings->triangle_repurchase_amount;
                            $insert['repurchase_slot_shop_id'] = $shop_id;  

                            $id = Tbl_mlm_triangle_repurchase_slot::insertGetId($insert);
                            $count_slot = Tbl_mlm_triangle_repurchase_slot::where('repurchase_slot_shop_id', $shop_id)->count();
                            $slot = Tbl_mlm_triangle_repurchase_slot::where('repurchase_slot_id', $id)->first();
                            if($count_slot >= 2)
                            {
                                Mlm_tree::triangle_repurchase_tree_l_r($slot);
                            }
                            Mlm_complan_manager_repurchase::triangle_repurchase_graduate($id, $shop_id);
                        }
                    }
                }
            }
        }
    }
    public static function triangle_repurchase_graduate($repurchase_slot_id, $shop_id)
    {
        $slot = Tbl_mlm_triangle_repurchase_slot::where('repurchase_slot_id', $repurchase_slot_id)->first();

        if($slot)
        {
            $slot_placement_grad_count = Tbl_mlm_triangle_repurchase_tree::where('tree_repurchase_slot_sponsor', $slot->repurchase_slot_placement)
            ->where('tree_repurchase_tree_level', 1)
            ->count();
            if($slot_placement_grad_count == 2)
            {

                $slot_earn = Tbl_mlm_triangle_repurchase_slot::where('repurchase_slot_id', $slot->repurchase_slot_placement)
                ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_mlm_triangle_repurchase_slot.repurchase_slot_slot_id')
                ->first();
                if($slot_earn)
                {
                    $settings = Tbl_mlm_triangle_repurchase::where('shop_id', $shop_id)
                    ->where('membership_id', $slot_earn->slot_membership)  
                    ->first();

                    if($settings)
                    {
                        $label = Mlm_compute::get_label_plan('TRIANGLE_REPURCHASE', $shop_id);
                        $log = 'Congratulations! Your repurchase slot #'.$slot_earn->repurchase_slot_id.' earned ' .  $settings->triangle_repurchase_income . ' in ' . $label . '. From tree of Repurchase Slot #' . $slot->repurchase_slot_placement ;
                        $arry_log['wallet_log_slot'] = $slot_earn->slot_id;
                        $arry_log['shop_id'] = $slot_earn->shop_id;
                        $arry_log['wallet_log_slot_sponsor'] = $slot_earn->slot_id;
                        $arry_log['wallet_log_details'] = $log;
                        $arry_log['wallet_log_amount'] = $settings->triangle_repurchase_income;
                        $arry_log['wallet_log_plan'] = "TRIANGLE_REPURCHASE";
                        $arry_log['wallet_log_status'] = "released";   
                        $arry_log['wallet_log_claimbale_on'] = Carbon::now(); 
                        Mlm_slot_log::slot_array($arry_log); 

                        $tree_income = Tbl_mlm_triangle_repurchase_tree::where('tree_repurchase_slot_child', $slot_earn->repurchase_slot_id)
                        ->distinct_level()
                        ->get();
                        
                        foreach($tree_income as $key => $value)
                        {
                            $slot_earn = Tbl_mlm_triangle_repurchase_slot::where('repurchase_slot_id', $value->tree_repurchase_slot_sponsor)
                            ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_mlm_triangle_repurchase_slot.repurchase_slot_slot_id')
                            ->first();

                            $label = Mlm_compute::get_label_plan('TRIANGLE_REPURCHASE', $shop_id);
                            $log = 'Congratulations! Your repurchase slot #'.$slot_earn->repurchase_slot_id.' earned ' .  $settings->triangle_repurchase_income . ' in ' . $label . '. From tree of Repurchase Slot #' . $slot->repurchase_slot_placement ;
                            $arry_log['wallet_log_slot'] = $slot_earn->slot_id;
                            $arry_log['shop_id'] = $slot_earn->shop_id;
                            $arry_log['wallet_log_slot_sponsor'] = $slot_earn->slot_id;
                            $arry_log['wallet_log_details'] = $log;
                            $arry_log['wallet_log_amount'] = $settings->triangle_repurchase_income;
                            $arry_log['wallet_log_plan'] = "TRIANGLE_REPURCHASE";
                            $arry_log['wallet_log_status'] = "released";   
                            $arry_log['wallet_log_claimbale_on'] = Carbon::now(); 
                            Mlm_slot_log::slot_array($arry_log); 
                        }
                    }
                    
                }
                
            }
        }
    }
}