<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use Paypal;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Globals\Digima;


class SampleTesting extends Controller
{
	public function digima()
	{
		$shop_id = 1;
		$member_count = Tbl_customer::where("shop_id", $shop_id)->count();
		$slot_count = Tbl_mlm_slot::where("shop_id", $shop_id)->count();
		$total_pay_in = $slot_count * 8000;
		$total_pay_out = Tbl_mlm_slot_wallet_log::where("shop_id", $shop_id)->where("wallet_log_amount", ">", 0)->sum("wallet_log_amount");
		Digima::updateStatistic($member_count, $slot_count, $total_pay_in, $total_pay_out);
	}
	public function index($id)
	{
		$data["id"] = $id + 1;
		$data["firsname"] = "oliver";
		$data["arrays"]	= array("1","2","3");
		
		return view('sample_testing',$data);
	}
	public function inspirer()
	{
		return redirect('http://162.251.151.81/inspirers/login');
	}

	public function samp2()
	{
		echo "asdsada";
	}
	public function ncabot()
	{
		$_slot = Tbl_mlm_slot::where("slot_eon", "!=", "")->get();
		
		foreach($_slot as $slot)
		{
			$update["customer_payout_method"] = "eon";
			Tbl_customer::where("customer_id", $slot->slot_owner)->update($update);
		}
	}
}