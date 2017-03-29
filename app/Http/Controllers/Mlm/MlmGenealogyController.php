<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_tree_placement;
use App\Globals\Mlm_genealogy;

class MlmGenealogyController extends Mlm
{
    public function index($tree)
    {
    	return $this->$tree();
    	return Self::show_maintenance();
    	
        $data["page"] = "Genealogy";
        return view("mlm.genealogy", $data);
    }
    public function unilevel()
    {
    	$data = [];
    	$data['head'] = Request::input('head');
        $data['slot_now'] = Self::$slot_now;
        // dd($data);
    	return view("mlm.genealogy.unilevel", $data);
    }
    public function binary()
    {
        $data = [];
    	return view("mlm.genealogy.binary", $data);
    }

    public function tree()
    {
        $slot_id           = Request::input('id');
        $shop_id           = Self::$shop_id;
        // return Mlm_genealogy::tree($slot_id, $shop_id);
        
        $data["slot"]      = Tbl_mlm_slot::membership()->customer()->where("tbl_mlm_slot.shop_id",$shop_id)->where("slot_id",$slot_id)->first();
        $data['l']         = Tbl_tree_placement::where('placement_tree_parent_id',$slot_id)->where('placement_tree_position','left')->count();
        $data['r']         = Tbl_tree_placement::where('placement_tree_parent_id',$slot_id)->where('placement_tree_position','right')->count();

        if($data["slot"])
        {
             $data["downline"] = $this->downline($slot_id);   
        }
        else
        {
            die('Invalid Slot');
        }
        $data['format'] = Request::input("mode");
        return view('mlm.genealogy.genealogy', $data);
    }
    public function downline($x = 0)
    {
        $format = Request::input("mode");

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
            $return .= $this->binary_downline($slot_id);
        }
        else
        {
            $return .= $this->unilevel_downline($slot_id);
        }

        $return .= "</ul>";

        if($x == 0)
        {
            return json_encode($return);
        }
        else
        {
            return $return;
        }   
    }
    public function binary_downline($slot_id)
    {  
        $left_info  = Tbl_mlm_slot::where("slot_placement", $slot_id)->where("slot_position", "left")->membership()->customer()->first();
        $right_info = Tbl_mlm_slot::where("slot_placement", $slot_id)->where("slot_position", "right")->membership()->customer()->first(); 

        $tree_string = "";
        $tree_string .= $this->downline_format($left_info,'Left',$slot_id);
        $tree_string .= $this->downline_format($right_info,'Right',$slot_id);

        return $tree_string;
    }
    public function unilevel_downline($slot_id)
    {
        $_info = Tbl_mlm_slot::where("slot_sponsor", $slot_id)->membership()->customer()->get();
        $count = Tbl_mlm_slot::where("slot_sponsor", $slot_id)->membership()->customer()->count();

        $tree_string = "";

        if($count != 0)
        {
            foreach($_info as $info)
            {
                $tree_string .= $this->downline_format_unilevel($info);  
            }
        }
        else
        {
            $tree_string .= '<li class="width-reference">
                                <span class="parent parent-reference VC">
                                    <div class="id">NO<br>SLOT</div>
                                </span>
                            </li>';

        }

        
        return $tree_string;
    }
    public function downline_format_unilevel($slot_info,$position = null,$placement = null)
    {

        if($slot_info)
        {
            $l = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','left')->count();
            $r = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','right')->count();
            

            $str_slot = '<span class="downline parent parent-reference PS SILVER" x="' . $slot_info->slot_id . '">';    



            if($slot_info->profile == null)
            {
                return  '<li class="width-reference">'.$str_slot.
                                    '<div id="info">
                                        <div id="photo">
                                            <img src="/assets/slot_genealogy/member/img/default-image.jpg" alt="" />
                                        </div>
                                        <div id="cont">
                                            <div>' . strtoupper($slot_info->first_name) . ' </div>
                                            <b>' . $slot_info->membership_name . ' </b>
                                        </div>
                                        <div>' . $slot_info->slot_status . '</div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="id">' . $slot_info->slot_no . '</div>
                                </span>
                                <i class="downline-container"></i>
                            </li>';
            }
            else
            {
                return  '<li class="width-reference">'.$str_slot.
                                    '<div id="info">
                                        <div id="photo">
                                            <img src="'.$slot_info->profile.'">
                                        </div>
                                        <div id="cont">
                                            <div>' . strtoupper($slot_info->first_name) . ' </div>
                                            <b>' . $slot_info->membership_name . ' </b>
                                        </div>
                                        <div>' . $slot_info->slot_status . '</div>
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

    public function downline_format_unilevel_a($slot_info,$position = null,$placement = null)
    {

        if($slot_info)
        {
            $l = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','left')->count();
            $r = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','right')->count();
            

            $str_slot = '<span class="downline parent parent-reference PS SILVER" x="' . $slot_info->slot_id . '">';    



            if($slot_info->image == "")
            {
                return  '<li class="width-reference">'.$str_slot.
                                    '<div id="info">
                                        <div id="photo">
                                            <img src="/assets/slot_genealogy/member/img/default-image.jpg" alt="" />
                                        </div>
                                        <div id="cont">
                                            <div>' . strtoupper($slot_info->first_name) . ' </div>
                                            <b>' . $slot_info->membership_name . ' </b>
                                        </div>
                                        <div>' . $slot_info->slot_status . '</div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="id">' . $slot_info->slot_no . '</div>
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
                                            <div>' . strtoupper($slot_info->first_name) . ' </div>
                                            <b>' . $slot_info->membership_name . ' </b>
                                        </div>
                                        <div>' . $slot_info->slot_status . '</div>
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
    public function downline_format($slot_info,$position = null,$placement = null)
    {

        if($slot_info)
        {
            $l = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','left')->count();
            $r = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','right')->count();
            

            $str_slot = '<span class="downline parent parent-reference PS SILVER" x="' . $slot_info->slot_id . '">';    



            if($slot_info->image == "")
            {
                return  '<li class="width-reference">'.$str_slot.
                                    '<div id="info">
                                        <div id="photo">
                                            <img src="/assets/slot_genealogy/member/img/default-image.jpg" alt="" />
                                        </div>
                                        <div id="cont">
                                            <div>' . strtoupper($slot_info->first_name) . ' </div>
                                            <b>' . $slot_info->membership_name . ' </b>
                                        </div>
                                        <div>' . $slot_info->slot_status . '</div>
                                        <div>' . "L:".$l." R:".$r.'</div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="id">' . $slot_info->slot_no . '</div>
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
                                            <div>' . strtoupper($slot_info->first_name) . ' </div>
                                            <b>' . $slot_info->membership_name . ' </b>
                                        </div>
                                        <div>' . $slot_info->slot_status . '</div>
                                        <div>' . "L:".$l."</br>R:".$r.'</div>
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
    public function set_inactive_slot($slot_id)
    {
        $slot = Tbl_mlm_slot::where('slot_id', $slot_id)->first();
        if($slot)
        {
            if($slot->slot_active == 0)
            {
                $update['slot_active'] = 1;
            }
            else
            {
                $update['slot_active'] = 0;
            }
            Tbl_mlm_slot::where('slot_id', $slot->slot_id)->update($update);

            if($update['slot_active'] == 0)
            {
                echo "Statu: ";
                echo 'Active (<a href="javascript:" onClick="setactive('.$slot->slot_id.')">Set as Inactive</a>)';    
            }
            else
            {
                echo "Statu: ";
                echo 'Inactive (<a href="javascript:" onClick="setactive('.$slot->slot_id.')">Set as Active</a>)';    
            }
        }
        else
        {
            return "Oops Something Went Wrong";
        }
    }
}