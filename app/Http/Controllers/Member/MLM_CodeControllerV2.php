<?php
namespace App\Http\Controllers\Member;
use App\Globals\Item;
use App\Globals\MLM2;

class MLM_CodeControllerV2 extends Member
{
    public function membership_code()
    {
    	$data["page"] = "Membership Code";
        Item::get_filter_type(5);
        $data["_item_kit"] = Item::get($this->user_info->shop_id);
        $data["_membership"] = MLM2::membership($this->user_info->shop_id);
        if(!$data["_item_kit"])
        {
            $data["title"] = "NO ITEM KIT FOUND";
            $data["content"] = "You need a <a href='/member/item/v2'>membership item kit</a> before you can use this module.";
            return view("member.error", $data);
        }
        elseif(!$data["_membership"])
        {
            $data["title"] = "NO MEMBERSHIP FOUND";
            $data["content"] = "You need to create a <a href='/member/item/v2'>membership</a> before you can use this module.";
            return view("member.error", $data);
        }
        else
        {
            return view("member.mlm_code_v2.membership_code", $data);
        }
    }
    public function membership_code_assemble()
    {
    	$data["page"] = "Membership Code Assemble";
    	return view("member.mlm_code_v2.membership_code_assemble", $data);
    }
    public function index()
    {
        $data['_item_product_code'] = Item::get_all_item_record_log();
        return view("member.mlm_code_v2.product_code",$data);
    }
}