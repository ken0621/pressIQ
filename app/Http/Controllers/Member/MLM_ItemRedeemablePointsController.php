<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_user;
use App\Models\Tbl_item_redeemable_request;
use App\Models\Tbl_item_redeemable_points;
use Crypt;
use Redirect;
use Illuminate\Http\Request;
use View;
use Session;
use DB;
use Carbon\Carbon;


class MLM_ItemRedeemablePointsController extends Member
{
	public function index()
	{
		// $shop_id 				    = $this->user_info->shop_id;
		// $data["_request_pending"]   = Tbl_item_redeemable_request::where("tbl_item_redeemable_request.shop_id",$shop_id)
		// 														 ->join("tbl_item_redeemable","tbl_item_redeemable_request.item_redeemable_id","=","tbl_item_redeemable.item_redeemable_id")
		// 														 ->join("tbl_mlm_slot","tbl_mlm_slot.slot_id","=","tbl_item_redeemable_request.slot_id")
		// 														 ->join("tbl_customer","tbl_customer.customer_id","=","tbl_mlm_slot.slot_owner")
		// 														 ->where("status","PENDING")
		// 														 ->get();
		// $data["_request_cancelled"] = Tbl_item_redeemable_request::where("tbl_item_redeemable_request.shop_id",$shop_id)
		// 														 ->join("tbl_item_redeemable","tbl_item_redeemable_request.item_redeemable_id","=","tbl_item_redeemable.item_redeemable_id")
		// 														 ->join("tbl_mlm_slot","tbl_mlm_slot.slot_id","=","tbl_item_redeemable_request.slot_id")
		// 														 ->join("tbl_customer","tbl_customer.customer_id","=","tbl_mlm_slot.slot_owner")
		// 														 ->where("status","CANCELLED")
		// 														 ->get();
		// $data["_request_complete"]  = Tbl_item_redeemable_request::where("tbl_item_redeemable_request.shop_id",$shop_id)
		// 														 ->join("tbl_item_redeemable","tbl_item_redeemable_request.item_redeemable_id","=","tbl_item_redeemable.item_redeemable_id")
		// 														 ->join("tbl_mlm_slot","tbl_mlm_slot.slot_id","=","tbl_item_redeemable_request.slot_id")
		// 														 ->join("tbl_customer","tbl_customer.customer_id","=","tbl_mlm_slot.slot_owner")
		// 														 ->where("status","COMPLETE")
		// 														 ->get();
		// 														 dd($data);
	    return view('member.redeemable.redeemable_request');
	}

	public function get_table()
	{
		$shop_id 		     = $this->user_info->shop_id;
        $data["activetab"]   = request("activetab");
  		$data["_redeemable"] = Tbl_item_redeemable_request::where("tbl_item_redeemable_request.shop_id",$shop_id)
														  ->join("tbl_item_redeemable","tbl_item_redeemable_request.item_redeemable_id","=","tbl_item_redeemable.item_redeemable_id")
														  ->join("tbl_mlm_slot","tbl_mlm_slot.slot_id","=","tbl_item_redeemable_request.slot_id")
														  ->join("tbl_customer","tbl_customer.customer_id","=","tbl_mlm_slot.slot_owner")
														  ->where("status",request("activetab"))
														  ->get();

        return view("member.redeemable.redeemable_request_table", $data);
	}

	public function submitpoints(Request $request)
	{
		$action = $request->action;
		$id     = $request->id;
		$check  = Tbl_item_redeemable_request::where("redeemable_request_id",$id)->where("shop_id",$this->user_info->shop_id)->where("status","PENDING")->first();
		if($check)
		{
			if($action == "complete")
			{
                $update_request["status"]   = "COMPLETE";
                Tbl_item_redeemable_request::where("redeemable_request_id",$id)->update($update_request);
                
                $response["status"] 		= "success";
                $response["status_message"] = "Success";
                return Redirect::back()->with("response",$response);
			}
			else if($action == "cancel")
			{
                $insert["amount"]       = $check->amount;
                $insert["shop_id"]      = $this->user_info->shop_id;
                $insert["slot_id"]      = $check->slot_id;
                $insert["date_created"] = Carbon::now();
                Tbl_item_redeemable_points::insert($insert);

                $update_request["status"]   = "CANCELLED";
                Tbl_item_redeemable_request::where("redeemable_request_id",$id)->update($update_request);

                $response["status"] 		= "success";
                $response["status_message"] = "Success";
                return Redirect::back()->with("response",$response);
			}
		}
	}
}