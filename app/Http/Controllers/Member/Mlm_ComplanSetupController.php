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
use DB;

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

		$merchant_school = $this->user_info->shop_merchant_school;
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

		$count = Tbl_mlm_plan::where('shop_id', $shop_id)->where('marketing_plan_code', 'UNILEVEL_REPURCHASE_POINTS')
		->where('marketing_plan_enable', 1)
		->count();
		if($count >= 1)
		{
			$data['links'][0]['label'] = 'Unilevel Distribute';
			$data['links'][0]['link'] = '/member/mlm/complan_setup/unilevel/distribute';
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
	public function unilevel_distribute()
	{
		$data = [];
		$shop_id = $this->user_info->shop_id;
		$data['settings_unilevel'] = DB::table('tbl_mlm_unilevel_distribute_settings')->where('u_r_shop_id', $shop_id)->first();
		return view('member.mlm_complan_setup.unilevel_distribute', $data);
	}
	public function unilevel_distribute_set_settings()
	{
		// return $_POST;

		$i['u_r_personal'] = Request::input('u_r_personal');
		$i['u_r_group'] = Request::input('u_r_group');
		$i['u_r_convertion'] = Request::input('u_r_convertion');
		$i['u_r_shop_id'] = $shop_id = $this->user_info->shop_id;
		$i['u_r_date'] = Carbon::now();

		$count = DB::table('tbl_mlm_unilevel_distribute_settings')->where('u_r_shop_id', $i['u_r_shop_id'])->count();
		if($count == 0)
		{
			DB::table('tbl_mlm_unilevel_distribute_settings')->insert($i);
		}
		else
		{
			$u['u_r_personal'] = $i['u_r_personal'];
			$u['u_r_group'] = $i['u_r_group'];
			$u['u_r_convertion'] = $i['u_r_convertion'];
			$u['u_r_date'] = $i['u_r_date'];
			DB::table('tbl_mlm_unilevel_distribute_settings')->where('u_r_shop_id', $i['u_r_shop_id'])->update($u);
		}

		$data['response_status'] = 'successd';
		$data['message'] = 'Unilevel Distribute Settings Updated';

		return json_encode($data);
	}
	public function unilevel_distribute_simulate()
	{
		$shop_id = $this->user_info->shop_id;
		$settings = DB::table('tbl_mlm_unilevel_distribute_settings')->where('u_r_shop_id', $shop_id)->first();
		if($settings)
		{
			$from = Request::input('from');
			$to = Request::input('to');

			$plan[0] = 'UNILEVEL_REPURCHASE_POINTS';
			$plan[1] = 'REPURCHASE_POINTS';
	        $all_log_personal = Tbl_mlm_slot_points_log::where('shop_id', $shop_id)
	        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_mlm_slot_points_log.points_log_slot')
	        // ->where('points_log_complan', 'UNILEVEL_REPURCHASE_POINTS')

	        ->select(DB::raw('sum(points_log_points ) as sum_personal'), DB::raw('tbl_mlm_slot_points_log.*'), DB::raw('tbl_mlm_slot.*'))

	        ->groupBy('points_log_complan')
	        ->groupBy('points_log_slot')

	        ->where('points_log_complan', 'REPURCHASE_POINTS')
	        ->get()->keyBy('points_log_slot');
	        $selected_slot = [];
	        $personal_points = [];
	        $structured = [];
	        foreach($all_log_personal as $p_key => $p_value)
	        {
	        	$u_r_personal = $settings->u_r_personal;
	        	if( $p_value->sum_personal >= $u_r_personal)
	        	{
	        		$selected_slot[$p_value->points_log_slot] = $p_value->points_log_slot;
	        		$personal_points[$p_value->points_log_slot] = $p_value->sum_personal;
	        	}
	        }

	        $all_log_group = Tbl_mlm_slot_points_log::where('shop_id', $shop_id)
	        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_mlm_slot_points_log.points_log_slot')
	        // ->where('points_log_complan', 'UNILEVEL_REPURCHASE_POINTS')

	        ->select(DB::raw('sum(points_log_points ) as sum_group'), DB::raw('tbl_mlm_slot_points_log.*'), DB::raw('tbl_mlm_slot.*'))

	        ->groupBy('points_log_complan')
	        ->groupBy('points_log_slot')

	        ->where('points_log_complan', 'UNILEVEL_REPURCHASE_POINTS')
	        // ->where('sum_group', '>=', $settings->u_r_group)
	        ->whereIn('points_log_slot', $selected_slot)
	        ->get()->keyBy('points_log_slot');

	        foreach ($all_log_group as $g_key => $g_value) 
	        {
	        	# code...
	        	$u_r_group = $settings->u_r_group;
	        	if( $g_value->sum_group >= $u_r_group )
	        	{

	        		$structured[$g_value->points_log_slot]['group_points'] = $g_value->sum_group;
	        		$structured[$g_value->points_log_slot]['personal_points'] = $personal_points[$g_value->points_log_slot];
	        		$structured[$g_value->points_log_slot]['info'] = $g_value;
	        	}
	        }

	        $data_v['structured'] = $structured;	
	        $data['response_status'] = 'success_e';
	        $data['view_blade'] = view('member.mlm_complan_setup.unilevel.unilevel_simulate', $data_v);
		}
	}
}