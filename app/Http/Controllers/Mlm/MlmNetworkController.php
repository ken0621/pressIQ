<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_mlm_slot_wallet_log;

class MlmNetworkController extends Mlm
{
    public function index()
    {

    }
    public function unilevel()
    {
        if(Self::$slot_id != null)
        {
            $data = [];
            $tree = Tbl_tree_sponsor::where('sponsor_tree_parent_id', Self::$slot_id)
            ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_tree_sponsor.sponsor_tree_child_id')
            ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
            ->join('tbl_membership', 'tbl_membership.membership_id', '=', 'tbl_mlm_slot.slot_membership')
            ->join('tbl_membership_code', 'tbl_membership_code.slot_id', '=', 'tbl_mlm_slot.slot_id')
            ->orderBy('tbl_tree_sponsor.sponsor_tree_level', 'ASC')
            ->get();
            $data['tree'] = [];
            foreach($tree as $key => $value)
            {
                $data['tree'][$value->sponsor_tree_level][$value->slot_id] = $value;
            }
            return view('mlm.network.unilevel', $data);
        }
        else
        {
            return Self::show_no_access();
        }
    }
    public function binary()
    {
        if(Self::$slot_id != null)
        {
            $data = [];
            $tree = Tbl_tree_placement::where('placement_tree_parent_id', Self::$slot_id)
            ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_tree_placement.placement_tree_child_id')
            ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
            ->join('tbl_membership', 'tbl_membership.membership_id', '=', 'tbl_mlm_slot.slot_membership')
            ->join('tbl_membership_code', 'tbl_membership_code.slot_id', '=', 'tbl_mlm_slot.slot_id')
            ->where('placement_tree_position', 'left')
            ->orderBy('tbl_tree_placement.placement_tree_level', 'ASC')
            ->get();
            $data['tree_left'] = [];
            $data['tree_right'] = [];
            foreach($tree as $key => $value)
            {
                $data['tree_left'][$value->placement_tree_level][$value->slot_id] = $value;
            }

            $tree = Tbl_tree_placement::where('placement_tree_parent_id', Self::$slot_id)
            ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_tree_placement.placement_tree_child_id')
            ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
            ->join('tbl_membership', 'tbl_membership.membership_id', '=', 'tbl_mlm_slot.slot_membership')
            ->join('tbl_membership_code', 'tbl_membership_code.slot_id', '=', 'tbl_mlm_slot.slot_id')
            ->where('placement_tree_position', 'right')
            ->get();
            foreach($tree as $key => $value)
            {
                $data['tree_right'][$value->placement_tree_level][$value->slot_id] = $value;
            }
            return view('mlm.network.binary', $data);
        }
        else
        {
            return Self::show_no_access();
        }
    }
    
}