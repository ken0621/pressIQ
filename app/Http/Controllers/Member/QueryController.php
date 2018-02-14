<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_wallet_log;
class QueryController extends Member
{
	public function getIndex(Request $request)
	{
		$data = Tbl_mlm_slot::walletinfo()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("slot_status","EZ")->groupBy("slot_id")->get();
		$return = null;
		foreach ($data as $key => $value) 
		{
			$ez_bonus = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_slot",$value->slot_id)->where("wallet_log_plan","EZ_REFERRAL_BONUS")->groupBy("slot_id")->sum("wallet_log_amount");
			$total_payout = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_slot",$value->slot_id)->whereIn("wallet_log_plan",['EON','BANK'])->groupBy("slot_id")->sum("wallet_log_amount") * -1;

			$return[$key]['slot_no'] = $value->slot_no;
			$return[$key]['ez_bonus'] = $ez_bonus;
			$return[$key]['total_payout'] = $total_payout;
			$return[$key]['payout'] = $ez_bonus - $total_payout;

			if($return[$key]['payout'] == 0)
			{
				unset($return[$key]);
			}
		}
		$data['_payout'] = $return;
		return view("/member/manual_query/query_index", $data);
	}
	public function postSubmitQuery(Request $request)
	{

	}
}