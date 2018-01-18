<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Models\Tbl_mlm_point_log_setting;

class MLM_RecaptchaController extends Member
{
    public function index()
    {
    	$data['page'] = "Recaptcha";
    	return view("member.mlm_recaptcha.mlm_recaptcha",$data);
    }
    
}
