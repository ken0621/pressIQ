<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_slot;
use App\Globals\Mlm_compute;

class Developer_ReentryController extends Member
{
	public function index()
	{
		$shop_id 			 = $this->user_info->shop_id;
		$data["slot_count"]  = Tbl_mlm_slot::where("shop_id",$shop_id)->count() ? Tbl_mlm_slot::where("shop_id",$shop_id)->count() : 0;
		$data["_slot"] 		 = Tbl_mlm_slot::where("shop_id",$shop_id)->get();
		$data["_membership"] = Tbl_membership::where("shop_id",$shop_id)->where("membership_archive",0)->get();
		$data["_customer"]   = Tbl_customer::where("shop_id",$shop_id)->where("archived",0)->get();
		return view('member.developer.re_entry',$data);
	}

    public function instant_add_slot()
    {
    	$shop_id = $this->user_info->shop_id;
        if(Tbl_mlm_slot::where("shop_id",$shop_id)->count() == 0)
        {
            $insert['slot_sponsor'] = 0;
        }
        else
        {
            $insert['slot_sponsor'] = Request::input("slot_sponsor");    
        }

        $insert['slot_no'] = Tbl_mlm_slot::where("shop_id",$shop_id)->count() + 1;
        $insert['shop_id'] = $this->user_info->shop_id;
        $insert['slot_owner'] = Request::input("slot_owner");
        $insert['slot_created_date'] = Carbon::now();
        $insert['slot_membership'] = Request::input("slot_membership");
        $insert['slot_status']  = Request::input("slot_status");


        $id = Tbl_mlm_slot::insertGetId($insert);

        $slot_info = Tbl_mlm_slot::where('slot_id', $id)->membership()->membership_points()->customer()->first();
        // compute mlm
        $a = Mlm_compute::entry($id);
    }
}