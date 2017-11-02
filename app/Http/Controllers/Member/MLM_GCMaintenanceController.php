<?php
namespace App\Http\Controllers\Member;

use Request;
use Carbon\Carbon;
use Session;
use Validator;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_bank;
use App\Models\Tbl_mlm_slot_money_remittance;
use App\Models\Tbl_mlm_slot_coinsph;
use App\Models\Tbl_mlm_encashment_settings;
use App\Models\Tbl_payout_bank;
use App\Models\Tbl_payout_bank_shop;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_shop;
use App\Globals\Currency;
use Redirect;
use App\Globals\MLM2;
use Excel;
use stdClass;

class MLM_GCMaintenanceController extends Member
{
	public function getIndex()
	{
		$data["page"] = "GC Maintenance";
		return view('member.mlm_gcmaintenance.gcmaintenance', $data);
	}
}