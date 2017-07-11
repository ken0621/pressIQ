<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership;
// use App\Models\Tbl_mlm_slot;
use App\Globals\Mlm_tree;
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
}