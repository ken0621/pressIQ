<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership;
// use App\Models\Tbl_mlm_slot;
use App\Globals\Mlm_tree;
use App\Globals\Mlm_compute;
use Request;
use Carbon\Carbon;
class Developer_AutoBalanceTree extends Member
{
	public function index()
	{
		return view('member.developer.auto_balance_tree');
	}

    public function initialize()
    {
        $shop_id             = $this->user_info->shop_id;
        $data["_slot"]       = Tbl_mlm_slot::where("shop_id",$shop_id)->orderBy("slot_id","ASC")->get();

        return json_encode($data);
    }

    public function retree()
    {
        $slot  = Tbl_mlm_slot::where("slot_id",Request::input("slot_id"))->first();
        if($slot->slot_sponsor != null)
        {
            MLM_tree::update_auto_balance_position($slot,1);
        }

        $return["message"] = "success";
        return json_encode($return);
    }
    public function change_sponsor()
    {
        
        return view('member.developer.change_sponsor');
    }
    public function change_sponsor_submit()
    {
        
        // Exist
        
        $slot = Tbl_mlm_slot::where('slot_no', Request::input('slot'))->first();
        $slot_sponsor = Tbl_mlm_slot::where('slot_no', Request::input('slot_sponsor'))->first();
        if($slot && $slot_sponsor)
        {
            // no sponsor
            if($slot->slot_sponsor == null)
            {
                $update['slot_sponsor'] = $slot_sponsor->slot_id;
                Tbl_mlm_slot::where('slot_id', $slot->slot_id)->update($update);
                
                
                Mlm_compute::entry($slot->slot_id);
                $data['status'] = 'success';
                $data['message'] = 'Success';
            }
            else
            {
                $data['status'] = 'warning';
                $data['message'] = 'Already have a sponsor';
            }
        }
        else
        {
            $data['status'] = 'warning';
            $data['message'] = 'Slot or Sponsor not found';
        }
        return json_encode($data);
    }
}