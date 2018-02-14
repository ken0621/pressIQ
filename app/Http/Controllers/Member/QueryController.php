<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Globals\Report;
use Carbon\Carbon;
class QueryController extends Member
{
	public function anyIndex(Request $request)
	{
        $report_type    = $request->report_type;
        $load_view      = $request->load_view;

		$dataget = Tbl_mlm_slot::customer()->bank()->walletinfo()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("slot_status","EZ")->groupBy("tbl_mlm_slot.slot_id")->get();
		$return = null;
		foreach ($dataget as $key => $value) 
		{
			$ez_bonus = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_slot",$value->slot_id)->where("wallet_log_plan","EZ_REFERRAL_BONUS")->groupBy("slot_id")->sum("wallet_log_amount");
			$total_payout = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_slot",$value->slot_id)->whereIn("wallet_log_plan",['EON','BANK'])->groupBy("slot_id")->sum("wallet_log_amount") * -1;

			// $return[$key]['slot_no'] = $value->slot_no;
			// $return[$key]['customer_name'] = $value->first_name." ".$value->middle_name." ".$value->last_name;

			$payout_details = null;
			if($value->payout_bank_id)
			{
				$payout_details = $value->payout_bank_name."-".$value->bank_account_name."-".$value->bank_account_number."-".$value->bank_account_type;
				if(!$value->bank_account_number)
				{
					$payout_details = null;
				}
			}
			if($value->slot_eon)
			{
				$payout_details = $value->slot_eon."-".$value->slot_eon_account_no."-".$value->slot_eon_card_no;
			}
			// $return[$key]['payout_details'] = $payout_details;
			// $return[$key]['ez_bonus'] = $ez_bonus;
			// $return[$key]['total_payout'] = $total_payout;
			// $return[$key]['payout'] = $ez_bonus - $total_payout;


			$return[$key] = $value;
			$return[$key]->ez_bonus = $ez_bonus;
			$return[$key]->total_payout = $total_payout;
			$return[$key]->payout = $ez_bonus - $total_payout;

			if($return[$key]->payout == 0)
			{
				unset($return[$key]);
			}
			if(!$payout_details)
			{
				unset($return[$key]);				
			}
		}
        $data['action'] = '/member/report/query';
		$data['_payout'] = $return;

		if($report_type && !$load_view)
        {
            $view =  'member.manual_query.query_output'; 
            return Report::check_report_type($report_type, $view, $data, 'Payout Details-'.Carbon::now());
        }
        else
        {
			return view("/member/manual_query/query_index", $data);
        }
	}
	public function postSubmitQuery(Request $request)
	{

	}
}