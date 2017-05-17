<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_stairstep_distribute;
use App\Models\Tbl_stairstep_distribute_slot;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_user;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_mlm_stairstep_settings;
use App\Models\Tbl_mlm_slot;
use App\Globals\Mlm_slot_log;
use App\Globals\Mlm_complan_manager;
use Crypt;
use Redirect;
use Request;
use Carbon\Carbon;
use View;
use App\Models\Tbl_mlm_plan;


class Mlm_ComplanSetupController extends Member
{
	public function index()
	{
		# code...
		$data = [];
		$shop_id = $this->user_info->shop_id;

		$count = Tbl_mlm_plan::where('shop_id', $shop_id)->where('marketing_plan_code', 'BINARY_PROMOTIONS')
		->where('marketing_plan_enable', 1)
		->count();

		if($count >= 1)
		{
			$data['links'][0]['label'] = 'Binary Promotions Setup';
			$data['links'][0]['link'] = '/member/mlm/complan_setup/binary_pro';
		}		
		$merchant_school = $this->merchant_school($this->user_info->shop_key);
		if($merchant_school == 1)
		{
			$data['links'][1]['label'] = 'School Merchant';
			$data['links'][1]['link'] = '/member/mlm/merchant_school';
		}

		$tours_wallet = $this->user_info->shop_wallet_tours;
		if($tours_wallet == 1)
		{
			$data['links'][2]['label'] = 'Tours Wallet';
			$data['links'][2]['link'] = '/member/mlm/tours_wallet';
		}
		return view('member.mlm_complan_setup.index', $data);
	}
	public function binary_promotions()
	{
		$data = [];
		return view('member.mlm_complan_setup.binary_complan', $data);
	}
	public function merchant_school($shop_key)
	{
		$data['PhilTECH'] = 'PhilTECH';
		if(isset($data[$shop_key]))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	public function tours_wallet()
	{
		$data = [];
		return view('member.mlm_tours_wallet.index', $data);
	}
}