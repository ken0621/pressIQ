<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Models\Tbl_mlm_point_log_setting;
use App\Models\Tbl_recaptcha_setting;

class MLM_RecaptchaController extends Member
{
    public function index()
    {
    	$data['page'] = "Recaptcha";
    	return view("member.mlm_recaptcha.mlm_recaptcha",$data);
    }
    public function table()
    {
    	// $data['logs'] = 
    	return 'table';
    }
    public function setting()
    {
    	$data['page'] 		= 'Recaptcha Setting';
    	$setting_points 	= Tbl_recaptcha_setting::where('shop_id',$this->user_info->shop_id)->first();
    	$data['point'] 		= $setting_points->point;
    	return view('member.mlm_recaptcha.mlm_recaptcha_setting',$data);
    }
    public function submit_setting(Request $request)
    {
    	$setting_points = Tbl_recaptcha_setting::where('shop_id',$this->user_info->shop_id)->first();
    	if(count($setting_points)>0)
    	{
    		$update['point'] = $request->point;
    		Tbl_recaptcha_setting::where('shop_id',$this->user_info->shop_id)->update($update);
    	}
    	else
    	{
    		$insert['shop_id'] 	= $this->user_info->shop_id;
    		$insert['point'] 	= $request->point;;
    		Tbl_recaptcha_setting::insert($insert);
    	}
    	$response['call_function'] = 'success';
    	return json_encode($response);
    }
    
}
