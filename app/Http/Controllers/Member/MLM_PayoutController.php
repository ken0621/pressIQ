<?php
namespace App\Http\Controllers\Member;

use Request;
use Carbon\Carbon;
use Session;
use Validator;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot;
use App\Globals\Currency;
use Redirect;
use App\Globals\MLM2;

class MLM_PayoutController extends Member
{
	public function getIndex()
	{
		$data["page"] = "Payout Processing";
		return view('member.mlm_payout.payout', $data);
	}
	public function postIndexTable()
	{
		$shop_id 		= $this->user_info->shop_id;
		$query 			= Tbl_mlm_slot_wallet_log::where("tbl_mlm_slot_wallet_log.shop_id", $shop_id)->slot()->customer();

		/* PAYOUT IMPORTATION QUERIES */
		$query->where("wallet_log_amount", "<", 0);
		$query->orderBy("wallet_log_date_created", "desc");
		
		/* SEARCH QUERY */
		$search_key = Request::input("search");
		if($search_key != "")
		{
			$query->where(function($q) use ($search_key)
			{
				$q->orWhere("first_name", "LIKE", "%$search_key%");
				$q->orWhere("last_name", "LIKE", "%$search_key%");
				$q->orWhere("slot_no", "LIKE", "%$search_key%");
			});
		}

		$data["_payout"]		= null;
		$data["total_payout"]	= Currency::format($query->sum("wallet_log_amount") * -1);
		$data["total_request"]	= Currency::format($query->sum("wallet_log_request"));
		$data["total_tax"]		= Currency::format($query->sum("wallet_log_tax"));
		$data["total_service"]	= Currency::format($query->sum("wallet_log_service_charge"));
		$data["total_other"]	= Currency::format($query->sum("wallet_log_other_charge"));
		$data["__payout"] 		= $query->paginate(5);

		foreach($data["__payout"] as $key => $payout)
		{
			$data["_payout"][$key] 										= $payout;
			$reward_slot 												= Tbl_mlm_slot::where("slot_id", $payout->wallet_log_slot)->first();
			$data["_payout"][$key]->display_wallet_log_amount 			= Currency::format($payout->wallet_log_amount * -1);
			$data["_payout"][$key]->time_ago 							= time_ago($payout->wallet_log_date_created);
			$data["_payout"][$key]->display_date 						= date("m/d/Y", strtotime($payout->wallet_log_date_created));
			$data["_payout"][$key]->slot_no 							= $reward_slot->slot_no;
			$data["_payout"][$key]->display_wallet_log_request 			= Currency::format($payout->wallet_log_request);
			$data["_payout"][$key]->display_wallet_log_tax 				= Currency::format($payout->wallet_log_tax);
			$data["_payout"][$key]->display_wallet_log_service_charge 	= Currency::format($payout->wallet_log_service_charge);
			$data["_payout"][$key]->display_wallet_log_other_charge 	= Currency::format($payout->wallet_log_other_charge);
		}


		return view('member.mlm_payout.payout_table', $data);
	}
	public function getImport()
	{
		return view("member.mlm_payout.payout_import");
	}
	public function postImport()
	{
		$return["input"] = Request::input();
		$return["status"] = "success";

		$slot_info = Tbl_mlm_slot::where("shop_id", $this->user_info->shop_id)->where("slot_no", Request::input("slot_no"))->first();

		if(!$slot_info)
		{
			$return["status"] = "error";
			$return["message"] = "The Slot No you entered doesn't exist";
		}
		else
		{
			$shop_id 	= $this->user_info->shop_id;
			$slot_id 	= $slot_info->slot_id;
			$method 	= Request::input("method");
			$remarks 	= "Result of Manual Importation";
			$amount 	= Request::input("payout_amount");
			$tax 		= Request::input("tax");
			$service 	= Request::input("service_charge");
			$other 		= Request::input("other_charge");
			$date 		= Request::input("payout_date");
			$payout 	= MLM2::slot_payout($shop_id, $slot_id, $method, $remarks, $amount, $tax, $service, $other, $date);

			if(is_numeric($payout))
			{
				$return["status"] = "success";
			}
			else
			{
				$return["status"] = "error";
				$return["message"] = $payout;
			}
		}

		echo json_encode($return);
	}
	public function getReset()
	{
		Tbl_mlm_slot_wallet_log::where("shop_id", $this->user_info->shop_id)->where("wallet_log_details", "Result of Manual Importation")->delete();
		return Redirect::to("/member/mlm/payout");
	}
}