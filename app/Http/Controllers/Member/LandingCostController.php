<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Session;
use Redirect;
use PDF;
use Carbon\Carbon;
use App\Globals\AuditTrail;
use App\Globals\LandingCost;

class LandingCostController extends Member
{
	public function getIndex()
	{
		$data['_landing_cost'] = LandingCost::get($this->user_info->shop_id);

		return view("member.landing_cost.default_landing_cost", $data);
	}
}