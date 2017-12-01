<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Models\Tbl_mlm_point_log_setting;

class MLM_PointLogSettingController extends Member
{
    public function index()
    {
    	$data['page'] = "Point Log Settings";
    	return view("member.mlm_point_log_setting.mlm_point_log_setting",$data);
    }
    public function add()
    {
    	$data['page'] = "Add New Notification";
    	return view("member.mlm_point_log_setting.point_log_setting_add",$data);
    }
    public function submit_add(Request $request)
    {
    	$insert = $request->except('_token');
    	// $insert->unset('_token');
    	if(Tbl_mlm_point_log_setting::insert($insert))
		{
			$reponse['call_function'] = 'success';
		}
		else
		{
			$reponse['call_function']= 'error';
		}
		return json_encode($reponse);
    }
}
