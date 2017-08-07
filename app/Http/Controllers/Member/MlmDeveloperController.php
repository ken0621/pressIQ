<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Globals\Currency;

class MlmDeveloperController extends Member
{
    public $session = "MLM Developer";

    public function index()
    {
    	$data["page"] = "MLM Developer";
    	$data["slot_count"] = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->count();
    	$data["_slot_page"] = $_slot = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->customer()->currentWallet()->orderBy("slot_id", "desc")->paginate(10);

        foreach($_slot as $key => $slot)
        {
        	$data["_slot"][$key] = $slot;

        	if($data["_slot"][$key]->current_wallet > 0)
        	{
        		$data["_slot"][$key]->current_wallet_format = "<a href='javascript:'>" . Currency::format($data["_slot"][$key]->current_wallet) . "</a>";
        	}
        	else
        	{
        		$data["_slot"][$key]->current_wallet_format = "PHP 0.00";
        	}
        }

        $total_slot_wallet = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->sum("wallet_log_amount");
    	$total_payout = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_amount", "<", 0)->sum("wallet_log_amount") * -1;
    	$total_earnings = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_amount", ">", 0)->sum("wallet_log_amount");
    	$data["total_slot_wallet"] = Currency::format($total_slot_wallet);
    	$data["total_slot_earnings"] = Currency::format($total_earnings);
    	$data["total_payout"] = Currency::format($total_payout);

        return view("member.mlm_developer.mlm_developer", $data);
    }
    public function create_slot()
    {
    	$data["page"] = "CREATE SLOT";
    	return view("member.mlm_developer.create_slot", $data);
    }
    public function create_slot_submit()
    {
    }
}