<?php
namespace App\Globals;

use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_tree_sponsor;

use App\Http\Controllers\Member\MLM_MembershipController;
use App\Http\Controllers\Member\MLM_ProductController;

use Schema;
use Session;
use DB;

use App\Globals\Mlm_compute;

class Mlm_tree
{   
    public static function insert_tree_placement($slot_info, $new_slot, $level)
    {
        if($slot_info != null)
        {
            $old_level   = $level;
            $upline_info = Tbl_mlm_slot::id($slot_info->slot_placement)->first();

            if($upline_info)
            {
                $insert['shop_id'] = $slot_info->shop_id;
                $insert["placement_tree_parent_id"] = $upline_info->slot_id;
                $insert["placement_tree_child_id"] = $new_slot->slot_id;
                $insert["placement_tree_position"] = $slot_info->slot_position;
                $insert["placement_tree_level"] = $level;
                Tbl_tree_placement::insert($insert);
                $level++;
                Mlm_tree::insert_tree_placement($upline_info, $new_slot, $level);  
            }  

            if($old_level == 1)
            {
                MLM_tree::update_auto_balance_position($new_slot,$old_level);
            }
        }
         
    }

    public static function update_auto_balance_position($new_slot,$level)
    {
        $top_slot                        = Tbl_mlm_slot::where("shop_id",$new_slot->shop_id)->orderBy("slot_id","ASC")->first();
        $get_top_level                   = Tbl_tree_placement::where("placement_tree_parent_id",$top_slot->slot_id)->where("placement_tree_child_id",$new_slot->slot_placement)->first();
        $placement                       = Tbl_mlm_slot::where("slot_id",$new_slot->slot_placement)->first();
        if($get_top_level)
        {     
            if($new_slot->slot_position == "left")
            {
                $auto_balance_position  = $placement->auto_balance_position + pow(2,$get_top_level->placement_tree_level);
            }
            else
            {
                $auto_balance_position  = $placement->auto_balance_position + (pow(2,$get_top_level->placement_tree_level) * 2);
            }
        }
        else
        {
            if($new_slot->slot_sponsor == 1)
            {
                if($new_slot->slot_position == "left")
                {
                    $auto_balance_position = 2;
                }
                else
                {
                    $auto_balance_position = 3;
                }
            }
        }
        if(isset($auto_balance_position))
        {
            $update["auto_balance_position"] = $auto_balance_position;
            Tbl_mlm_slot::where("slot_id",$new_slot->slot_id)->update($update);
        }
    }

    public static function insert_tree_sponsor($slot_info, $new_slot, $level)
    {
        if($slot_info != null)
        {
            $upline_info = Tbl_mlm_slot::id($slot_info->slot_sponsor)->first();

            if($upline_info)
            {
                $insert['shop_id'] = $new_slot->shop_id;
                $insert["sponsor_tree_parent_id"] = $upline_info->slot_id;
                $insert["sponsor_tree_child_id"] = $new_slot->slot_id;
                $insert["sponsor_tree_level"] = $level;
                Tbl_tree_sponsor::insert($insert);
                $level++;
                Mlm_tree::insert_tree_sponsor($upline_info, $new_slot, $level);  
            }
        }
    }
    public static function auto_place_slot_binary_left_to_right($slot_info)
    {
        // $slot_placement_sponsor = Tbl_mlm_slot::id()->membership
        // Get first slot with no left
        // $slot_with_no
        $arr_slot = [];
        $count_last = Tbl_tree_placement::where('shop_id', $slot_info->shop_id)
        ->orderby('placement_tree_parent_id', 'ASC')
        ->get(); 
        foreach($count_last as $key=> $value)
        {
            if(isset($arr_slot[$value->placement_tree_parent_id]))
            {
                if($value->placement_tree_level == 1)
                {
                    $arr_slot[$value->placement_tree_parent_id] += 1;
                }
            }
            else
            {
                if($value->placement_tree_level == 1)
                {
                    $arr_slot[$value->placement_tree_parent_id] = 1;
                }
            }
        }
        $select_slot = 0;
        $select_slot_2 = 0;
        foreach($arr_slot as $key => $value)
        {
            if($value == 1)
            {
                if($select_slot == 0)
                {
                    $select_slot = $key;
                }
            }
            if($value == 2)
            {
                $select_slot_2 = $key;
            }
        }

        if($select_slot == 0)
        {
            $select_slot_3 = 0;
            foreach($count_last as $value)
            {
                if($select_slot_3 == 0)
                {
                    if(!isset($arr_slot[$value->placement_tree_child_id]))
                    {
                        $select_slot_3 = $value->placement_tree_child_id;
                    }
                }
            }
            if($select_slot_3 == 0)
            {
                $slot = Tbl_mlm_slot::where('shop_id', $slot_info->shop_id)->first();

                $update['slot_placement']   = $slot->slot_id;
                $update['slot_position'] = 'left';
                Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->update($update);

                $slot_info_e = Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->first();
            }
            else
            {
                $update['slot_placement']   = $select_slot_3;
                $update['slot_position'] = 'left';
                Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->update($update);

                $slot_info_e = Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->first();
            }
        }
        else
        {
            // got the slot
            $update['slot_placement']   = $select_slot;
            $update['slot_position'] = 'right';
            Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->update($update);

            $slot_info_e = Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->first();
        }
        // dd ($select_slot_3);
        
        Mlm_tree::insert_tree_placement($slot_info_e, $slot_info_e, 1);
    }
    public static function auto_place_slot_binary_auto_balance($slot_info)
    {

        $update_slot_no_placement['slot_placement'] = 0;
        $update_slot_no_placement2 = Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->update($update_slot_no_placement);
        $slot_info = Mlm_compute::get_slot_info($slot_info->slot_id);

        $arr_slot = [];
        $arr_slot_all= [];
        $selected_next_placement = 0;
        $count_last = Tbl_tree_placement::where('shop_id', $slot_info->shop_id)
        ->where('placement_tree_parent_id', $slot_info->slot_sponsor)
        ->orderby('placement_tree_parent_id', 'ASC')
        ->get(); 

        if(count($count_last) == 0)
        {
            $selected_next_placement = $slot_info->slot_sponsor;
            $position                = 'left';
        }

        // Get all down line of sponsor
        $slot_s = [];
        foreach($count_last as $key => $value)
        {
            $slot_s[$key] = $value->placement_tree_child_id;
        }

        // select tree in of all downline of sponsor
        // 
        $count_last = Tbl_tree_placement::where('shop_id', $slot_info->shop_id)
        ->where('placement_tree_parent_id', $slot_info->slot_sponsor);
        foreach($slot_s as $key => $value)
        {
            $count_last->orwhere('placement_tree_parent_id', $value);
        }
        $count_last = $count_last->orderby('placement_tree_parent_id', 'ASC')->get();

        // dd(DB::getQueryLog());
        

        // select all with downline
        foreach($count_last as $key=> $value)
        {
            if(isset($arr_slot[$value->placement_tree_parent_id]))
            {
                if($value->placement_tree_level == 1)
                {
                    $arr_slot[$value->placement_tree_parent_id] += 1;
                }
            }
            else
            {
                if($value->placement_tree_level == 1)
                {
                    $arr_slot[$value->placement_tree_parent_id] = 1;
                }
            }
        }
        // select all with no downline
        foreach ($count_last as $key => $value) 
        {
            $arr_slot_all[$value->placement_tree_child_id] = 0;
        }
        

        // combine no downline and with downline
        foreach($arr_slot as $key => $value)
        {
            foreach($arr_slot_all as $key2 => $value2)
            {
                if(!isset($arr_slot[$key2]))
                {
                    $arr_slot[$key2] = 0;   
                }
            }
        }
        $count_array_with_1_downline = 0;

        // sort array ascending
        ksort($arr_slot);
        $fiter_by_level = [];
        // Sort from left to right
            $get_slot_per_level = Tbl_tree_placement::where('shop_id', $slot_info->shop_id)
            ->where('placement_tree_parent_id', $slot_info->slot_sponsor)->orderby('placement_tree_parent_id', 'ASC')->get();

            foreach($arr_slot as $key => $value)
            {
                foreach($get_slot_per_level as $key2 => $value2)
                {
                    if($key == $value2->placement_tree_child_id)
                    {
                        $fiter_by_level[$key] = $value2->placement_tree_level;
                    }
                }
            }
            $filtered = [];
            foreach($fiter_by_level as $key => $value)
            {
                
                foreach($get_slot_per_level as $key2 => $value2)
                {
                    if($key == $value2->placement_tree_child_id)
                    {
                        $filtered[$value][$key] = $value2->placement_tree_position;
                    }
                }
            }
            foreach($filtered as $key => $value)
            {
                $array_keys = array_keys($value);
                array_multisort($value, $array_keys);
                $result = array_combine($array_keys, $value);
                $filtered[$key] = $result;
            }
            $filtered_with_n_level = [];
            foreach($filtered as $key => $value)
            {
                foreach($value as $key2 => $value2)
                {
                    $filtered_with_n_level[$key2] = 0;
                }
            }
            foreach($filtered_with_n_level as $key => $value)
            {
                foreach($arr_slot as $key2 => $value2)
                {
                    if($key == $key2)
                    {
                       $filtered_with_n_level[$key] = $value2; 
                    }
                }
            }
            $arr_slot = $filtered_with_n_level;
        // end


        // count slots with 1 downline
        foreach($arr_slot as $key => $value)
        {
            if($value == 1)
            {
                $count_array_with_1_downline++;
            }
        } 
        $position = 'left';       
        if($count_array_with_1_downline == 0)
        {
            $next = 0;
            // get first slot with no downline
            foreach($arr_slot as $key => $value)
            {
                if($value == 2)
                {
                    $next = 1;
                }
                elseif($value == 0)
                {
                    if($next == 0)
                    {
                        $position                   = 'left';
                        $selected_next_placement    = $key;
                        $next                       = 2;
                    }
                    else if($next == 1)
                    {
                        $position                   = 'left';
                        $selected_next_placement    = $key;
                        $next                       = 2;
                    }
                }
                else
                {
                    if($next == 1)
                    {
                        $position                   = 'left';
                        $selected_next_placement    = $key;
                        $next                       =0;
                    }
                }
            }
        }
        else
        {
            $next = 0;
            $slot_with_one = 0;
            $head = 0;
            foreach($arr_slot as $key => $value)
            {   
                if($head == 0)
                {
                    $head = $key;
                }

                if($value == 1)
                {
                    $next = 1;
                    $slot_with_one = $key;
                }
                else
                {
                    if($next == 1)
                    {
                        $selected_next_placement = $key;
                        $position = 'left';
                        $next =0;
                    }
                }
            }
            // dd($selected_next_placement);
            $head = $slot_info->slot_sponsor;

            $count_last_head = Tbl_tree_placement::where('shop_id', $slot_info->shop_id)
            ->orderby('placement_tree_parent_id', 'ASC')
            ->where('placement_tree_parent_id', $head)
            ->get();

            

            $count_per_level = [];

            $count_per_level_left_right = [];
            foreach($count_last_head as $key => $value)
            {
                if(isset($count_per_level[$value->placement_tree_level]))
                {
                    $count_per_level[$value->placement_tree_level]++;
                }
                else
                {
                    $count_per_level[$value->placement_tree_level] = 1;
                }
                if(isset($count_per_level_left_right[$value->placement_tree_level][$value->placement_tree_position]))
                {
                    $count_per_level_left_right[$value->placement_tree_level][$value->placement_tree_position]++;
                }
                else
                {
                    $count_per_level_left_right[$value->placement_tree_level][$value->placement_tree_position] = 1;
                }
            }

            

            $defendency_level = 0;
            $last_level = 0;
            $sum = [];
            $sum_n = [];
            ksort($count_per_level);
             foreach($count_per_level as $key => $value)
            {
                if($last_level == 0)
                {
                    $sum_dapat = 2;
                }
                else
                {
                    $sum_dapat = $last_level + $last_level;
                }
                $sum_ngayon = $value;
                $sum[$key] = $sum_dapat;
                $sum_n[$key] = $sum_ngayon;
                if($defendency_level == 0)
                {       
                    if($sum_dapat > $sum_ngayon)
                    {
                        $defendency_level = $key - 1;
                    }
                }
                $last_level = $sum_dapat;
            }

            $pos_final_selection = 'left';
            foreach($count_per_level_left_right as $key => $value)
            {
                if($defendency_level + 1 == $key)
                {
                    if(!isset($value['left']))
                    {
                        $value['left'] = 0;
                    }
                    if(!isset($value['right']))
                    {
                        $value['right'] = 0;
                    }
                    if($value['left'] == $value['right'])
                    {
                        $pos_final_selection = 'left';
                    }
                    else if($value['left'] > $value['right'])
                    {
                        $pos_final_selection = 'right';
                    }
                    else
                    {
                        $pos_final_selection = 'right';
                    }
                }
            }

            $arr_level_selected_final = [];
            foreach($count_last_head as $key => $value)
            {
                if($pos_final_selection == $value->placement_tree_position)
                {
                    if($value->placement_tree_level == $defendency_level)
                    {
                        $arr_level_selected_final[$value->placement_tree_child_id] = 0;
                    }
                }
                
            }
            // dd($arr_level_selected_final);
            foreach($count_last as $key => $value)
            {
                if($value->placement_tree_level  == 1)
                {
                    if(isset($arr_level_selected_final[$value->placement_tree_parent_id]))
                    {
                        $arr_level_selected_final[$value->placement_tree_parent_id]++;
                    }        
                }
            }
            $selector = 0;
            $lowest = 2;
            $lowest_old = 2;
            $selected_pos = 0;
            $selector_0 = 0;
            ksort($arr_level_selected_final);
            foreach($arr_level_selected_final as $key => $value)
            {

                $lowest_old = $lowest;
                $lowest = $value;
                if($value == 1)
                {

                    if($selector == 0)
                    {
                        
                        if($lowest <= $lowest_old)
                        {

                            $selector = $key;
                            $selected_pos = $lowest;
                        }
                    }
                }
                if($value == 0)
                {
                    if($selector_0 == 0)
                    {
                        $selector = $key;
                        $selected_pos = $lowest;
                        $selector_0 = $key;
                    }
                }
            }

            $selected_next_placement = $selector;
            if($selected_pos == 0)
            {
                $position                = 'left';
            }
            else
            {
                $position               = 'right';
            }
        }

        if(count($count_last) == 1)
        {
            $selected_next_placement = $slot_info->slot_sponsor;
            $position                = 'right';
        }

        $update['slot_placement']   = $selected_next_placement;
        $update['slot_position']    = $position;
        // dd($update);

        Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->update($update);

        $slot_info_e = Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->first();
        Mlm_tree::insert_tree_placement($slot_info_e, $slot_info_e, 1);
        // dd($arr_slot);
        // dd($update);
    }
    
    public static function auto_place_slot_binary_auto_balance_revised($slot_info)
    {
        if($slot_info->slot_sponsor != 0)
        {
            $sponsor = Tbl_mlm_slot::where("slot_id",$slot_info->slot_sponsor)->first();
            if($sponsor)
            {
                $condition_update = false;
                $current_level = $sponsor->current_level;
                while($condition_update == false)
                {                 
                    if($current_level == 0)
                    {
                        $check_placement = Tbl_mlm_slot::where("slot_placement",$slot_info->slot_sponsor)->where("slot_position","left")->first();
                        if(!$check_placement)
                        {
                            $slot_placement   = $slot_info->slot_sponsor;
                            $slot_position    = "left";
                            $slot_level       = 0;
                            $condition_update = true;
                            break;
                        }
                        else
                        {
                           $check_placement = Tbl_mlm_slot::where("slot_placement",$slot_info->slot_sponsor)->where("slot_position","right")->first();
                           if(!$check_placement)
                           {
                             $slot_placement   = $slot_info->slot_sponsor;
                             $slot_position    = "right";
                             $slot_level       = 1;
                             $condition_update = true;
                             break;
                           }
                        }
                    }
                    else
                    {
                        $placement_tree = Tbl_tree_placement::where("placement_tree_parent_id",$sponsor->slot_id)->where("placement_tree_level",$current_level)->childslot()->orderBy("tbl_mlm_slot.auto_balance_position","ASC")->get();
                        $current_count  = Tbl_tree_placement::where("placement_tree_parent_id",$sponsor->slot_id)->where("placement_tree_level",$current_level + 1)->childslot()->orderBy("tbl_mlm_slot.auto_balance_position","ASC")->count();
                        $max_count      = pow(2, $current_level + 1);
                        if($current_count < $max_count)
                        {   
                            $condition_right = true;

                            foreach($placement_tree as $placement)
                            {
                                $check_placement = Tbl_mlm_slot::where("slot_placement",$placement->placement_tree_child_id)->where("slot_position","left")->first();
                                if(!$check_placement)
                                {
                                    $slot_placement   = $placement->placement_tree_child_id;
                                    $slot_position    = "left";
                                    $condition_update = true;
                                    $condition_right  = false;
                                    if(($current_count + 1) >= $max_count)
                                    {
                                        $slot_level = $current_level + 1;
                                    }
                                    else
                                    {
                                        $slot_level = $current_level;
                                    }
                                    break;
                                }
                            }


                            if($condition_right == true)
                            {
                                foreach($placement_tree as $placement)
                                {
                                    $check_placement = Tbl_mlm_slot::where("slot_placement",$placement->placement_tree_child_id)->where("slot_position","right")->first();
                                    if(!$check_placement)
                                    {
                                        $slot_placement   = $placement->placement_tree_child_id;
                                        $slot_position    = "right";
                                        $condition_update = true;
                                        $condition_right  = false;
                                        if(($current_count + 1) >= $max_count)
                                        {
                                            $slot_level = $current_level + 1;
                                        }
                                        else
                                        {
                                            $slot_level = $current_level;
                                        }
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    $current_level++;
                }



                if($condition_update == true)
                {
                    $update_sponsor['current_level']  = $slot_level;
                    Tbl_mlm_slot::where('slot_id', $slot_info->slot_sponsor)->update($update_sponsor);

                    // got the slot
                    $update['slot_placement'] = $slot_placement;
                    $update['slot_position']  = $slot_position;

                    Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->update($update);

                    $slot_info_e = Tbl_mlm_slot::where('slot_id', $slot_info->slot_id)->first();
                    Mlm_tree::insert_tree_placement($slot_info_e, $slot_info_e, 1);
                }
            }
        }
    }
}