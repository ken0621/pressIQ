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
use Excel;

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

		$data["_payout"]				= null;
		$data["total_payout"]			= Currency::format($query->sum("wallet_log_amount") * -1);
		$data["total_request"]			= Currency::format($query->sum("wallet_log_request"));
		$data["total_tax"]				= Currency::format($query->sum("wallet_log_tax"));
		$data["total_service"]			= Currency::format($query->sum("wallet_log_service_charge"));
		$data["total_other"]			= Currency::format($query->sum("wallet_log_other_charge"));
		$data["__payout"] 				= $query->paginate(5);

        /* GET TOTALS */
        $grand_total_slot_wallet  			= Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->sum("wallet_log_amount");
    	$grand_total_payout       			= Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_amount", "<", 0)->sum("wallet_log_amount") * -1;
    	$grand_total_earnings     			= Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_amount", ">", 0)->sum("wallet_log_amount");

        /* FORMAT TOTALS */
    	$data["grand_total_slot_wallet"]     	= Currency::format($grand_total_slot_wallet);
    	$data["grand_total_slot_earnings"]   	= Currency::format($grand_total_earnings);
    	$data["grand_total_payout"]          	= Currency::format($grand_total_payout);

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
	public function getProcess()
	{
		return view("member.mlm_payout.payout_process");
	}
	public function anyProcessOutput()
	{
		$source 				= Request::input("source");
		$method 				= Request::input("method");
		$tax_amount 			= Request::input("tax");
		$service_charge 		= Request::input("service-charge");
		$minimum 				= Request::input("minimum");
		$other_charge 			= Request::input("other-charge");
		$data["cutoff_date"]	= $cutoff_date = Request::input("cutoff-date");
		$total_payout 			= 0;
		$total_net 				= 0;
		$minimum_encashment		= $minimum;


		if($source == "wallet")
		{
			$_slot = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->membership()->customer()->currentWallet()->orderBy("customer_id", "asc")->get();
			
			foreach($_slot as $key => $slot)
			{
				$earnings_as_of 	= Tbl_mlm_slot_wallet_log::where("wallet_log_slot", $slot->slot_id)->where("wallet_log_date_created", ">", date("Y-m-d", strtotime($cutoff_date)))->sum("wallet_log_amount");
				$encashment_amount 	= $slot->current_wallet - $earnings_as_of;
				$remaining 			= $slot->current_wallet - $encashment_amount;
				$compute_net 		= $encashment_amount;
				$tax 				= ($encashment_amount - ($service_charge + $other_charge)) - (($encashment_amount - ($service_charge + $other_charge)) / (1 + ($tax_amount/100)));
				$compute_net 		= $compute_net - ($service_charge + $other_charge + $tax);


				$_slot[$key]->real_wallet 		= number_format($slot->current_wallet, 2, '.', '');
				$_slot[$key]->real_earnings 	= number_format($slot->total_earnings, 2, '.', '');
				$_slot[$key]->real_payout 		= number_format($slot->total_payout, 2, '.', '');
				$_slot[$key]->real_encash 		= number_format($encashment_amount, 2, '.', '');
				$_slot[$key]->real_remaining 	= number_format($remaining, 2, '.', '');
				$_slot[$key]->real_service 		= number_format($service_charge, 2, '.', '');
				$_slot[$key]->real_other 		= number_format($other_charge, 2, '.', '');
				$_slot[$key]->real_tax 			= number_format($tax, 2, '.', '');
				$_slot[$key]->real_net 			= number_format($compute_net, 2, '.', '');


				$_slot[$key]->display_wallet = Currency::format($slot->current_wallet);
				$_slot[$key]->display_earnings = Currency::format($slot->total_earnings);
				$_slot[$key]->display_payout = Currency::format($slot->total_payout);
				$_slot[$key]->display_encash = Currency::format($encashment_amount);
				$_slot[$key]->display_remaining = Currency::format($remaining);
				$_slot[$key]->display_service = Currency::format($service_charge);
				$_slot[$key]->display_other = Currency::format($other_charge);
				$_slot[$key]->display_tax = Currency::format($tax);
				$_slot[$key]->display_net = Currency::format($compute_net);


				if($encashment_amount <= $minimum_encashment || $remaining < 0)
				{
					unset($_slot[$key]);
				}
				else
				{
					$total_payout += $encashment_amount;
					$total_net += $compute_net;

				}
			}
		}


		$data["total_payout"] = Currency::format($total_payout);
		$data["total_net"] = Currency::format($total_net);
		$data["_slot"] = $_slot;

		if(Request::isMethod("post"))
		{
			Excel::create("payout-$method-$cutoff_date", function($excel) use ($data)
			{
			    $excel->sheet("Payout List", function($sheet) use ($data)
			    {
			        $sheet->setOrientation('landscape');
			        $sheet->loadView('member.mlm_payout.payout_process_excel', $data);
			    });

			})->export('xlsx');
		}
		else
		{
			return view("member.mlm_payout.payout_process_report", $data);
		}
	}
}