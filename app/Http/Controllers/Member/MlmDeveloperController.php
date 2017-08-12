<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_membership;
use App\Models\Tbl_customer;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_tree_placement;
use App\Globals\Currency;
use App\Globals\Mlm_compute;
use App\Globals\Reward;
use DB;
use Redirect;
use Request;
use Crypt;

class MlmDeveloperController extends Member
{
    public $session = "MLM Developer";

    public function index()
    {
    	$data["page"]           = "MLM Developer";
        return view("member.mlm_developer.mlm_developer", $data);
    }
    public function index_table()
    {
        /* INITIAL DATA */
        $data               = Self::get_initial_settings();
    	$data["slot_count"] = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->count();
    	$data["_slot_page"] = $_slot = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->customer()->currentWallet()->orderBy("slot_id", "desc")->paginate(5);

        /* CUSTOM SLOT TABLE */
        foreach($_slot as $key => $slot)
        {
        	$data["_slot"][$key] = $slot;
            $data["_slot"][$key]->sponsor = Tbl_mlm_slot::customer()->where("slot_id", $slot->slot_sponsor)->first();
            $data["_slot"][$key]->placement = Tbl_mlm_slot::customer()->where("slot_id", $slot->slot_placement)->first();
        	$data["_slot"][$key]->current_wallet_format = "<a href='javascript:'>" . Currency::format($data["_slot"][$key]->current_wallet) . "</a>";
        	$data["_slot"][$key]->total_earnings_format = "<a href='javascript:'>" . Currency::format($data["_slot"][$key]->total_earnings) . "</a>";
        	$data["_slot"][$key]->total_payout_format = "<a href='javascript:'>" . Currency::format($data["_slot"][$key]->total_payout * -1) . "</a>";
        
            if(!$data["_slot"][$key]->sponsor)
            {
                $data["_slot"][$key]->sponsor_button = "";
            }
            else
            {
                $data["_slot"][$key]->sponsor_button = "<a href='javascript:'> SLOT NO. " . $slot->sponsor->slot_no . "</a>";
            }

            if(!$data["_slot"][$key]->placement)
            {
                $data["_slot"][$key]->placement_button = "";
            }
            else
            {
                $data["_slot"][$key]->placement_button = "<a href='javascript:'>" . strtoupper($slot->slot_position) . " OF " . strtoupper($slot->placement->slot_no) . "</a>";
            }
        }

        /* GET TOTALS */
        $total_slot_wallet  = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->sum("wallet_log_amount");
    	$total_payout       = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_amount", "<", 0)->sum("wallet_log_amount") * -1;
    	$total_earnings     = Tbl_mlm_slot_wallet_log::slot()->where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->where("wallet_log_amount", ">", 0)->sum("wallet_log_amount");
    	
        /* FORMAT TOTALS */
    	$data["total_slot_wallet"]     = Currency::format($total_slot_wallet);
    	$data["total_slot_earnings"]   = Currency::format($total_earnings);
    	$data["total_payout"]          = Currency::format($total_payout);

    	return view("member.mlm_developer.mlm_developer_table", $data);
    }
    public function create_slot()
    {
        /* INITIAL DATA */
        $data                          = Self::get_initial_settings();
        $shop_id                        = $this->user_info->shop_id;
        $data["_membership"]            = Tbl_membership::shop($this->user_info->shop_id)->reverseOrder()->active()->joinPackage()->get();
        
        /* CHECK IF MEMBERSHIP AVAILABLE */
        if(count($data["_membership"]) > 0)
        {
            return view("member.mlm_developer.create_slot", $data);
        }
        else
        {
            $data["title"]      = "MEMBERSHIP ERROR";
            $data["message"]    = "You need to have a membership in order to create a TEST SLOT.";

            return view("error_modal", $data);
        }
    }
    public function create_slot_submit()
    {
        $data                       = Self::get_initial_settings();
        $array_position             = array("left", "right");

        /* INITIALIZE AND CAPTURE DATA */
        $shop_id                    = $this->user_info->shop_id;
        $sponsor                    = Tbl_mlm_slot::where("slot_no", Request::input("sponsor"))->where("shop_id", $shop_id)->pluck("slot_id");
        $placement                  = Tbl_mlm_slot::where("slot_no", Request::input("placement"))->where("shop_id", $shop_id)->pluck("slot_id");
        $random_sponsor             = Tbl_mlm_slot::where("shop_id", $shop_id)->orderBy(DB::raw("rand()"))->pluck("slot_id");
        $random_placement           = Tbl_mlm_slot::where("shop_id", $shop_id)->orderBy(DB::raw("rand()"))->pluck("slot_id");  
        $random_position            = $array_position[array_rand($array_position)];

        /* POSITIONING DATA */
        $slot_sponsor               = $sponsor != null ? $sponsor : $random_sponsor;
        $slot_placement             = $placement != null ? $placement : $random_placement;
        $slot_position              = (Request::input("position") == "random" ? $random_position : Request::input("position"));

        /* SLOT GENERATION */
        $membership_package_id      = Request::input("membership");
    	$customer_id                = Self::create_slot_submit_random_customer($shop_id);
        $membership_code_id         = Self::create_slot_submit_create_code($customer_id, $membership_package_id);
        $slot_id                    = Self::create_slot_submit_create_slot($customer_id, $membership_code_id, $slot_sponsor, $slot_placement, $slot_position, $shop_id);
        
        /* RANDOM WHILE PLACEMENT IS STILL TAKEN */
        if(isset($slot_id["message"]))
        {
            if($slot_id["message"] == "Placement Alread Taken")
            {
                while($slot_id["message"] == "Placement Alread Taken")
                {
                    $slot_placement = Tbl_mlm_slot::where("shop_id", $shop_id)->orderBy(DB::raw("rand()"))->pluck("slot_id"); 
                    $slot_id = Self::create_slot_submit_create_slot($customer_id, $membership_code_id, $slot_sponsor, $slot_placement, $slot_position, $shop_id);
                }
            }
        }

        if(isset($slot_id["status"]))
        {
            $return["status"]        = "error";
            $return["message"]       = $slot_id["message"];
        }
        else
        {
            if($slot_sponsor != null)
            {
                Mlm_compute::entry($slot_id);
            }
            
            $return["status"]        = "success";
            $return["call_function"] = "create_test_slot_done";
        }

        echo json_encode($return);
    }
    public static function create_slot_submit_random_customer($shop_id)
    {
    	$random_user = json_decode(file_get_contents('https://randomuser.me/api/?nat=us'))->results[0];

    	$insert_customer["shop_id"]        = $shop_id;
    	$insert_customer["first_name"]     = ucfirst($random_user->name->first);
    	$insert_customer["last_name"]      = ucfirst($random_user->name->last);
    	$insert_customer["email"]          = $random_user->email;
    	$insert_customer["ismlm"]          = 1;
    	$insert_customer["mlm_username"]   = $random_user->login->username;
    	$insert_customer["password"]       = Crypt::encrypt($random_user->login->password);

    	return Tbl_customer::insertGetId($insert_customer);
    }
    public static function create_slot_submit_create_code($customer_id, $membership_package_id)
    {
        $membership_code_return = Reward::generate_membership_code($customer_id, $membership_package_id);
        $membership_code_id = null;

        if($membership_code_return['status'] == 'success')
        {
            $membership_code_id = $membership_code_return['membership_code_id'];
        }
        else
        { 
            return json_encode($membership_code_return); 
        }

        return $membership_code_id;
    }
    public static function create_slot_submit_create_slot($customer_id, $membership_code_id, $slot_sponsor, $slot_placement, $slot_position, $shop_id)
    {
        $request_check['shop_id']               = $shop_id; //required
        $request_check['slot_owner']            = $customer_id; //required
        $request_check['membership_code_id']    = $membership_code_id; //required
        $request_check['slot_sponsor']          = $slot_sponsor; // required
        $request_check['slot_placement']        = $slot_placement; // optional defends on settings
        $request_check['slot_position']         = $slot_position; // optional defends on settings

        $return = Reward::create_slot($request_check);
        $slot_id = null;

        if($return['status'] == 'success')
        {
            $slot_id = $return['slot_id'];
        }
        else
        {
            return $return;
        }

        return $slot_id;
    }
    public function reset()
    {
        $shop_id    = $this->user_info->shop_id;
        $_slot      = Tbl_mlm_slot::where("shop_id", $shop_id)->get();

        Tbl_tree_placement::where("shop_id", $shop_id)->delete();
        Tbl_tree_sponsor::where("shop_id", $shop_id)->delete();
        Tbl_mlm_slot_wallet_log::where("shop_id", $shop_id)->delete();

        foreach($_slot as $slot)
        {
            Tbl_mlm_slot::where("slot_id", $slot->slot_id)->delete();
            Tbl_customer_address::where("customer_id", $slot->slot_owner)->delete();
            Tbl_customer::where("customer_id", $slot->slot_owner)->delete(); 
        }

        return Redirect::to("/member/mlm/developer");
    }
    public function get_initial_settings()
    {
        $shop_id = $this->user_info->shop_id;
        $binary_settings = Tbl_mlm_plan::where('shop_id', $shop_id)->code('BINARY')->enable(1)->trigger('Slot Creation')->first();
        $binary_advance = Tbl_mlm_binary_setttings::where('shop_id', $shop_id)->first(); 

        $count_tree_if_exist = 0;
        $data['binary_enabled']  = 0;
        $data['binary_auto'] = 0;

        if(isset($binary_settings->marketing_plan_enable))
        {
           if($binary_settings->marketing_plan_enable == 1)
           {
                $data['binary_enabled'] = $binary_settings->marketing_plan_enable;
                if(isset($binary_advance->binary_settings_placement))
                {
                    $data['binary_auto'] = $binary_advance->binary_settings_placement;
                }
           }      
        }

        return $data;
    }
}