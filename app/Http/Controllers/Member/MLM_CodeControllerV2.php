<?php
namespace App\Http\Controllers\Member;

class MLM_CodeControllerV2 extends Member
{
    public function membership_code()
    {
    	$data["page"] = "Membership Code";
    	return view("member.mlm_code_v2.membership_code", $data);
    }
    public function membership_code_assemble()
    {
    	$data["page"] = "Membership Code Assemble";
    	return view("member.mlm_code_v2.membership_code_assemble", $data);
    }
}