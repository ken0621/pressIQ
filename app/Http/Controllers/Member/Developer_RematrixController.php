<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
class Developer_RematrixController extends Member
{
	public function index()
	{
		$shop_id 			= $this->user_info->shop_id;
		$data["slot_count"] = Tbl_mlm_slot::where("shop_id",$shop_id)->count() ? Tbl_mlm_slot::where("shop_id",$shop_id)->count() : 0;
		return view('member.developer.rematrix',$data);
	}
}