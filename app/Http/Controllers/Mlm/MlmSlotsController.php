<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Carbon\Carbon;

use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_tree_placement;

use App\Globals\Mlm_compute;
use App\Globals\Mlm_member;
class MlmSlotsController extends Mlm
{
    public function index()
    {
    	if(Self::$slot_id != null)
    	{
    		$data = [];
            $check_if_enabled = Tbl_mlm_plan_setting::where("shop_id",Self::$shop_id)->where("plan_settings_upgrade_slot",1)->first();
            if($check_if_enabled)
            {   
                $data["enabled_upgrade_slot"] = 1;
            }
            else
            {
                $data["enabled_upgrade_slot"] = 0;
            }
            $data['all_slots_p'] = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)->membership()->paginate(20);
            $data['active']      = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)->where('slot_defaul', 1)->first();
            $data['_code']       = Tbl_membership_code::where('customer_id', Self::$customer_id)->where('used', 0)->get();
    		// dd($data);
    		return view('mlm.slots.index', $data);
    	}
        else
        {
        	return Self::show_no_access();
        }
    }
    public function set_nickname()
    {
        // return $_POST;
        if(isset($_POST['active_slot']))
        {
            if(isset($_POST['slot_nickname']))
            {
                $customer_id = Self::$customer_id;
                $slot_id = $_POST['active_slot'];
                $nickname = $_POST['slot_nickname'];
                $slot = Tbl_mlm_slot::where('slot_owner', $customer_id)->where('slot_no', $slot_id)->first();
                if(isset($slot->slot_id))
                {
                    if(strlen($nickname) >= 6)
                    {
                        $user_count = Tbl_mlm_slot::where('slot_no', $nickname)->where('slot_owner', '!=', $customer_id)->count();
                        $user_count_2 = Tbl_mlm_slot::where('slot_nick_name', $nickname)->where('slot_owner', '!=', $customer_id)->count();
                        $user_count_3 = Tbl_customer::where('mlm_username', $nickname)->count();
                        $all = $user_count + $user_count_2 + $user_count_3;
                        if($all == 0)
                        {
                            $update['slot_defaul'] = 0;
                            $update['slot_nick_name'] = null;
                            Tbl_mlm_slot::where('slot_owner', $customer_id)->update($update);

                            $update_new['slot_defaul'] = 1;
                            $update_new['slot_nick_name'] = $nickname;
                            Tbl_mlm_slot::where('slot_owner', $slot->slot_owner)->where('slot_id', $slot->slot_id)->update($update_new);
                            $data['message'] ='Slot Nickname/Default slot Changed!';
                            $data['status'] = 'success';
                        }
                        else
                        {
                            $data['message'] ='Nickname Already Taken.';
                            $data['status'] = 'warning';
                        } 
                        
                    }
                    else
                    {
                        $data['message'] ='Nickname Length Must Be Greater Than 6.';
                        $data['status'] = 'warning';
                    }
                }
                else
                {
                    $data['message'] ='Invalid Slot';
                    $data['status'] = 'warning';
                }
            }
            else
            {
                $data['message'] ='Nickname field is required';
                $data['status'] = 'warning';
            }
        }
        else
        {
            $data['message'] ='Slot field is required';
            $data['status'] = 'warning';

        }
        return json_encode($data);
    }
    public function upgrade_slot($id)
    {
        $check_if_enabled = Tbl_mlm_plan_setting::where("shop_id",Self::$shop_id)->where("plan_settings_upgrade_slot",1)->first();
        if($check_if_enabled)
        {   
            $data["id"] = $id;
            $slot       = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)->where("slot_id",$id)->first();
            if(!$slot)
            {
                dd("Wrong owner.");
            }

            $current_membership = Tbl_membership::where("membership_id",$slot->slot_membership)->first();
            $higher_membership  = Tbl_membership::where("shop_id",Self::$shop_id)->where("membership_price",">",$current_membership->membership_price)->lists("membership_id");
            
            $data["membership_code"]       = Tbl_membership_code::package()
                                                                ->whereIn("membership_id",$higher_membership)
                                                                ->where("used",0)->where("blocked",0)
                                                                ->where("archived",0)
                                                                ->get();

            $data["membership_code_count"] = Tbl_membership_code::package()
                                                                ->whereIn("membership_id",$higher_membership)
                                                                ->where("used",0)->where("blocked",0)
                                                                ->where("archived",0)
                                                                ->count();

            return view('mlm.slots.upgrade_slot',$data);
        }
        else
        {
            dd("Upgrade slot settings is disabled");
        }
    }

    public function upgrade_slot_post($id)
    {
        $error      = null;
        $slot       = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)->where("slot_id",$id)->first();
        if(!$slot)
        {
            $message["message"] = "Wrong owner.";
        }

        $membership_code_id = Request::input("membership_code_id");
        $current_membership = Tbl_membership::where("membership_id",$slot->slot_membership)->first();
        $higher_membership  = Tbl_membership::where("shop_id",Self::$shop_id)->where("membership_price",">",$current_membership->membership_price)->lists("membership_id");
        
        $membership_code    = Tbl_membership_code::package()
                                                 ->where("tbl_membership_code.used",0)
                                                 ->where("tbl_membership_code.blocked",0)
                                                 ->where("tbl_membership_code.archived",0)
                                                 ->whereIn("membership_id",$higher_membership)
                                                 ->where("membership_code_id",$membership_code_id)
                                                 ->where("customer_id",Self::$customer_id)
                                                 ->first();

        if(!$membership_code)
        {
            $message["message"] = "This code is not available.";
        }

        if($error == null)
        {
            $membership                = Tbl_membership::where("membership_id",$membership_code->membership_id)->first();

            $update["used"]            = 1;
            $update["date_used"]       = Carbon::now();
            $update["used_on_upgrade"] = 1;
            $update["upgrade_slot"]    = $id;
            $update["slot_id"]         = $id;
            Tbl_membership_code::where("membership_code_id",$membership_code_id)->update($update);

            $update_slot["upgraded"]   = 1;
            $update_slot["upgrade_from_membership"] = $slot->slot_membership;
            $update_slot["slot_membership"] = $membership->membership_id;
            Tbl_mlm_slot::where("slot_id",$id)->update($update_slot);
            Mlm_compute::entry($id,1);

            $message["status"]           = "success-upgrade";
            $message["message"]          = "Sucessfully upgraded";
            $message["membership_name"]  = $membership->membership_name;
            $message["slot_id"]          = $id;
        }
        return json_encode($message);
    } 
    public function add_slot_modal()
    {
        return Mlm_member::add_slot_form(Self::$customer_id);
    } 
    public function manual_add_slot_modal()
    {
        return Mlm_member::manual_add_slot_form(Self::$customer_id,Request::input("membership_id"),Self::$shop_id);
    }
    public function check_add()
    {
        $check_membership  = Tbl_membership_code::where("membership_code_id",Request::input("membership_code_id"))
                                                ->where("blocked",0)
                                                ->where("archived",0)
                                                ->where("used",0)
                                                ->where("customer_id",Self::$customer_id)
                                                ->first();
        if($check_membership)
        {
            $data["status"]    = "sucess-slot";
            $data["encrypted"] = Crypt::encrypt(Request::input("membership_code_id"));
        }
        else
        {
            $data["message"]   = "Membership code doesn't exists";
        }

        return json_encode($data);
    }

    public function manual_add_slot()
    {
        
        return view('mlm.slots.manual_add_slot');
    }

    public function manual_add_slot_post()
    {
        $check_membership  = Tbl_membership_code::where("membership_code_id",Request::input("membership_code_id"))
                                                ->where("membership_activation_code",Request::input("membership_activation_code"))
                                                ->where("shop_id",Self::$shop_id)
                                                ->first();

        if(!$check_membership)
        {
            $message["message"]          = "This code is not available.";
        }
        else
        {
            if($check_membership->used == 1)
            {
                $message["message"]          = "This code is already used.";
            }
            else if($check_membership->blocked == 1)
            {
                $message["message"]          = "This code is blocked.";
            }
            else if($check_membership->archived == 1)
            {
                $message["message"]          = "This code is not available.";
            }
            else
            {
                $message["status"]           = "success-manual";
                $message["encrypted"]        = Crypt::encrypt(Request::input("membership_code_id"));
            }
        }

        return json_encode($message);
    }
}