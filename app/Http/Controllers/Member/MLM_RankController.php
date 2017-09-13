<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_stairstep_distribute;
use App\Models\Tbl_stairstep_distribute_slot;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_user;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_stairstep_settings;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_shop;
use App\Globals\Mlm_slot_log;
use App\Globals\Mlm_complan_manager;
use Crypt;
use Redirect;
use Request;
use Carbon\Carbon;
use View;
use DB;

class MLM_StairstepController extends Member
{
	public function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
	}

    public function rank_stairstep_view()
    {
    	
    	return view("member.mlm_stairstep.rank_update_stairstep");
    }
}