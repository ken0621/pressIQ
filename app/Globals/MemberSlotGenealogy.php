<?php
namespace App\Globals;

use Request;
use Carbon\Carbon;
use Session;
use Validator;
use Redirect;
use Response;
use View;
use Excel;
use DB;

use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_user;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_stairstep_settings;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_membership;
use App\Models\Tbl_customer_search;
use App\Models\Tbl_customer_other_info;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_mlm_matching_log;
use App\Models\Tbl_mlm_transfer_slot_log;
use App\Models\Tbl_mlm_binary_pairing;
use App\Globals\Item;
use App\Globals\AuditTrail;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_complan_manager;
use App\Globals\Mlm_complan_manager_cd;
use App\Globals\Mlm_tree;
use App\Globals\Membership_code;
use App\Globals\Settings;
use App\Globals\Mlm_voucher;
use App\Globals\Mlm_slot_log;
use App\Globals\Item_code;
use App\Globals\Mlm_gc;

// use App\Globals\Mlm_compute;
use App\Globals\Mlm_complan_manager_repurchase;
use App\Globals\Utilities;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_member;
use App\Globals\Mlm_discount;
// use App\Globals\Mlm_compute;
use App\Models\Tbl_email_content;
use Crypt;
use App\Globals\Reward;

/**
 * Chart of Account Module - all account related module
 *
 * @author ARCY
 */

class MemberSlotGenealogy
{


    public static function tree($shop_id, $slot_id, $mode = '')
    {
        $data["slot"]      = Tbl_mlm_slot::membership()->customer()->where("tbl_mlm_slot.shop_id",$shop_id)->where("slot_id",$slot_id)->first();
        $data['l']         = Tbl_tree_placement::where('placement_tree_parent_id',$slot_id)->where('placement_tree_position','left')->count();
        $data['r']         = Tbl_tree_placement::where('placement_tree_parent_id',$slot_id)->where('placement_tree_position','right')->count();
        if($data["slot"])
        {
             $data["downline"] = Self::downline($slot_id);   
        }
        else
        {
            die('Invalid Slot');
        }
        $data['format'] = $mode;

        return $data;
    }
    public static function downline($x = 0, $mode = '')
    {
        $format = $mode;
        if(!$mode)
        {
            $format = Request::input("mode");
        }

        if($x == 0)
        {
            $slot_id = Request::input("x");
        }
        else
        {
            $slot_id = $x;
        }

        $return = "<ul>";

        if($format == "binary")
        {
            $return .= Self::binary_downline($slot_id);
        }
        else
        {
            $return .= Self::unilevel_downline($slot_id);
        }

        $return .= "</ul>";
        if($x == 0)
        {
            return json_encode($return);
        }
        else
        {
            if($mode)
            {
                return json_encode($return);
            }
            else
            {
                return $return;
            }
        }   
    }
    public static function binary_downline($slot_id)
    {
        $left_info  = Tbl_mlm_slot::where("slot_placement", $slot_id)->where("slot_position", "left")->membership()->customer()->first();
        $right_info = Tbl_mlm_slot::where("slot_placement", $slot_id)->where("slot_position", "right")->membership()->customer()->first(); 

        $tree_string = "";
        $tree_string .= Self::downline_format($left_info,'Left',$slot_id);
        $tree_string .= Self::downline_format($right_info,'Right',$slot_id);

        return $tree_string;
    }
    public static function unilevel_downline($slot_id)
    {
        $_info = Tbl_mlm_slot::where("slot_sponsor", $slot_id)->membership()->customer()->get();
        $count = Tbl_mlm_slot::where("slot_sponsor", $slot_id)->membership()->customer()->count();

        $tree_string = "";

        if($count != 0)
        {
            foreach($_info as $info)
            {
                $tree_string .= Self::downline_format_unilevel($info);  
            }
        }
        else
        {
            $tree_string .= '<li class="width-reference">
                                <span class="parent parent-reference VC" >
                                    <div class="id popup_add"  >+</div>
                                </span>
                            </li>';
        }

        
        return $tree_string;
    }
    public static function downline_format_unilevel($slot_info,$position = null,$placement = null)
    {

        if($slot_info)
        {
            $l = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','left')->count();
            $r = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','right')->count();


            $abb = strtoupper(substr($slot_info->first_name, 0, 3));

            $str_slot = '<span class="downline parent parent-reference PS SILVER" x="' . $slot_info->slot_id . '">';    

            if($slot_info->image == "")
            {
                return  '<li class="width-reference">'.$str_slot.
                                    '<div id="info">
                                        <div id="photo">
                                            <img src="/assets/slot_genealogy/member/img/default-image.jpg" alt="" />
                                        </div>
                                        <div id="cont">
                                            <div><b>' . strtoupper($slot_info->first_name) . ' ' . strtoupper($slot_info->last_name) . '</b></div> 
                                            <div><b>' . strtoupper($slot_info->slot_no) . '</b></div>
                                            <div>'  . ' </div>
                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="id">' . $abb . '</div>
                                </span>
                                <i class="downline-container"></i>
                            </li>';
            }
            else
            {
                return  '<li class="width-reference">'.$str_slot.
                                    '<div id="info">
                                        <div id="photo">
                                            <img src="/assets/slot_genealogy/member/img/default-image.jpg">
                                        </div>
                                        <div id="cont">
                                            <div><b>' . strtoupper($slot_info->first_name) . ' ' . strtoupper($slot_info->last_name) . '</b></div> 
                                            <div><b>' . strtoupper($slot_info->slot_no) . '</b></div>  
                                            <div>' . ' </div>
                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="id">' . $slot_info->slot_id . '</div>
                                </span>
                                <i class="downline-container"></i>
                            </li>';             
            }

        }
        else if($position) 
        {
            $slot_info = Tbl_mlm_slot::where('slot_id',$placement)->customer()->first();

            return  '   <li class="width-reference">
                            <span class="positioning parent parent-reference VC" position="'.$position.'" placement="'.$placement.'" y="'.$slot_info->first_name.'">
                                <div class="id">+</div>
                            </span>
                        </li>';
        }
        else
        {
            return  '   <li class="width-reference">
                            <span class="parent parent-reference VC">
                                <div class="id">+</div>
                            </span>
                        </li>';
        }
    }
    public static function downline_format($slot_info,$position = null,$placement = null)
    {

        if($slot_info)
        {
            $l = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','left')->count();
            $r = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','right')->count();
            

            $abb = strtoupper(substr($slot_info->first_name, 0, 3));

            $str_slot = '<span class="downline parent parent-reference PS SILVER" x="' . $slot_info->slot_id . '">';    



            if($slot_info->image == "")
            {
                return  '<li class="width-reference">'.$str_slot.
                                    '<div id="info">
                                        <div id="photo">
                                            <img src="/assets/slot_genealogy/member/img/default-image.jpg" alt="" />
                                        </div>
                                        <div id="cont">
                                            <div><b>' . strtoupper($slot_info->first_name) . ' ' . strtoupper($slot_info->last_name) . '</b></div> 
                                            <div><b>' . strtoupper($slot_info->slot_no) . '</b></div>
                                            <div>' . ' </div>
                                        </div>
                                        <div>' . "L:".$l." R:".$r.'</div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="id">' . $abb . '</div>
                                </span>
                                <i class="downline-container"></i>
                            </li>';
            }
            else
            {
                return  '<li class="width-reference">'.$str_slot.
                                    '<div id="info">
                                        <div id="photo">
                                            <img src="/assets/slot_genealogy/member/img/default-image.jpg">
                                        </div>
                                        <div id="cont">
                                            <div><b>' . strtoupper($slot_info->first_name) . ' ' . strtoupper($slot_info->last_name) . '</b></div> 
                                            <div><b>' . strtoupper($slot_info->slot_no) . '</b></div> 
                                            <div>' . ' </div>
                                        </div>
                                        <div>' . "L:".$l."</br>R:".$r.'</div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="id">' . $slot_info->slot_no . '</div>
                                </span>
                                <i class="downline-container"></i>
                            </li>';             
            }

        }
        else if($position) 
        {
            $slot_info = Tbl_mlm_slot::where('slot_id',$placement)->customer()->first();

            return  '   <li class="width-reference">
                            <span class="positioning parent parent-reference VC" position="'.$position.'" placement="'.$placement.'" y="'.$slot_info->first_name.'">
                                <div class="id">+</div>
                            </span>
                        </li>';
        }
        else
        {
            return  '   <li class="width-reference">
                            <span class="parent parent-reference VC">
                                <div class="id">+</div>
                            </span>
                        </li>';
        }
    }
}