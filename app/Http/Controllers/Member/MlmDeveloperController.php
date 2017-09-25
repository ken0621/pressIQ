<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_membership;
use App\Models\Tbl_customer;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_mlm_gc;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_item;
use App\Globals\Currency;
use App\Globals\Mlm_compute;
use App\Globals\Mlm_complan_manager;
use App\Globals\Reward;
use App\Globals\MLM2;
use App\Models\Tbl_mlm_item_points;
use App\Models\Tbl_brown_rank;
use DB;
use Redirect;
use Request;
use Crypt;
use Carbon\Carbon;

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
    	$data["_slot_page"] = $_slot = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->membership()->customer()->currentWallet()->orderBy("slot_id", "desc")->paginate(5);

        /* CUSTOM SLOT TABLE */
        foreach($_slot as $key => $slot)
        {
            $total_gc = Tbl_mlm_gc::where("mlm_gc_slot", $slot->slot_id)->value("mlm_gc_amount");

        	$data["_slot"][$key] = $slot;
            $data["_slot"][$key]->sponsor = Tbl_mlm_slot::customer()->where("slot_id", $slot->slot_sponsor)->first();
            $data["_slot"][$key]->placement = Tbl_mlm_slot::customer()->where("slot_id", $slot->slot_placement)->first();
        	$data["_slot"][$key]->current_wallet_format = "<a href='javascript:' link='/member/mlm/developer/popup_earnings?slot_id=" . $slot->slot_id . "' class='popup' size='lg'>" . Currency::format($data["_slot"][$key]->current_wallet) . "</a>";
        	$data["_slot"][$key]->total_earnings_format = "<a href='javascript:' link='/member/mlm/developer/popup_earnings?slot_id=" . $slot->slot_id . "' class='popup' size='lg'>" . Currency::format($data["_slot"][$key]->total_earnings) . "</a>";
        	$data["_slot"][$key]->total_payout_format = "<a href='javascript:'>" . Currency::format($data["_slot"][$key]->total_payout * -1) . "</a>";
            $data["_slot"][$key]->total_gc_format = Currency::format(0);

            /* BROWN RANK DETAILS */
            $brown_current_rank = Tbl_brown_rank::where("rank_id", $slot->brown_rank_id)->first();

            if($brown_current_rank)
            {
                $data["_slot"][$key]->brown_current_rank = strtoupper($brown_current_rank->rank_name);
            }
            else
            {
                $data["_slot"][$key]->brown_current_rank = strtoupper("NO RANK");
            }
            

            if($slot->brown_rank_id)
            {
                $brown_next_rank = Tbl_brown_rank::where("rank_id",">", $slot->brown_rank_id)->orderBy("rank_id")->first();
            }
            else
            {
                $brown_next_rank = null;
            }

            if($brown_next_rank)
            {
                $data["_slot"][$key]->brown_next_rank = strtoupper($brown_next_rank->rank_name);
                $brown_rank_required_slots = $brown_next_rank->required_slot;
                $brown_count_required = Tbl_tree_sponsor::where("sponsor_tree_parent_id", $slot->slot_id)->where("sponsor_tree_level", "<=", $brown_next_rank->required_uptolevel)->count();
                $data["_slot"][$key]->brown_next_rank_requirements = "<b><a class='popup' size='md' link='/member/mlm/developer/popup_slot_created?level=".$brown_next_rank->required_uptolevel."&slot_id=". $slot->slot_id."'>" . $brown_count_required . " SLOT(S)</a></b> OUT OF <b>" . $brown_rank_required_slots . " (LIMIT " . strtoupper(ordinal($brown_next_rank->required_uptolevel)) .  " LEVEL)</b>";
            }
            else
            {
                $data["_slot"][$key]->brown_next_rank = strtoupper("NO NEXT RANK");
                $brown_rank_required_slots = "NO NEXT RANK";
                $brown_count_required = "NO NEXT RANK";
                $data["_slot"][$key]->brown_next_rank_requirements = "NO NEXT RANK";
            }
  
            /* BROWN POINTS */
            $builder_points = Tbl_mlm_slot_points_log::where("points_log_complan", "BROWN_BUILDER_POINTS")->where("points_log_slot", $slot->slot_id)->sum("points_log_points");
            $data["_slot"][$key]->brown_builder_points = "<a link='/member/mlm/developer/popup_points?slot_id=" . $slot->slot_id . "&point=BROWN_BUILDER_POINTS' class='popup' size='lg' href='javascript:'>" . number_format($builder_points, 2) . " POINT(S)</a>";

            $leader_points = Tbl_mlm_slot_points_log::where("points_log_complan", "BROWN_LEADER_POINTS")->where("points_log_slot", $slot->slot_id)->sum("points_log_points");
            $data["_slot"][$key]->brown_leader_points = "<a link='/member/mlm/developer/popup_points?slot_id=" . $slot->slot_id . "&point=BROWN_LEADER_POINTS' class='popup' size='lg' href='javascript:'>" . number_format($leader_points, 2) . " POINT(S)</a>";

            /* SPONSOR BUTTON */
            if(!$data["_slot"][$key]->sponsor)
            {
                $data["_slot"][$key]->sponsor_button = "";
            }
            else
            {
                $data["_slot"][$key]->sponsor_button = "<a link='/member/mlm/developer/popup_genealogy?mode=sponsor&slot_no=".$slot->sponsor->slot_no."' class='popup' size='lg'>" . $slot->sponsor->slot_no . "</a>";
            }

            /* PLACEMENT BUTTON */
            if(!$data["_slot"][$key]->placement)
            {
                $data["_slot"][$key]->placement_button = "";
            }
            else
            {
                $data["_slot"][$key]->placement_button = "<a link='/member/mlm/developer/popup_genealogy?mode=binary&slot_no=".$slot->sponsor->slot_no."' class='popup' size='lg'>" . strtoupper($slot->slot_position) . " OF " . strtoupper($slot->placement->slot_no) . "</a>";
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
    public function popup_genealogy()
    {
        $data['slot_id'] = Tbl_mlm_slot::where('shop_id',$this->user_info->shop_id)->where('slot_no', Request::input('slot_no'))->value('slot_id');
        $data['mode'] = Request::input('mode');
        return view('member.mlm_developer.modal_genealogy',$data);
    }
    public function popup_slot_created()
    {
        $data['page'] = 'Popup Slot Created';
        $slot_id = Request::input('slot_id');
        // dd($slot_id);
        $data['owner'] = Tbl_mlm_slot::customer()->where('slot_id',$slot_id)->first();
        $level = Request::input('level');
        $data['_slot'] = Tbl_tree_sponsor::child_info()->customer()->where('sponsor_tree_parent_id',$slot_id)->where('sponsor_tree_level','<=',$level)->orderBy('sponsor_tree_level', 'ASC')->get();

        return view('member.mlm_developer.popup_slots_created',$data);
    }
    public function popup_earnings()
    {
        $data["page"] = "popup_earnings";
        $data["slot_info"] = Tbl_mlm_slot::where("slot_id", Request::input("slot_id"))->first();
        $_wallet = Tbl_mlm_slot_wallet_log::where("wallet_log_slot", Request::input("slot_id"))->orderBy("wallet_log_id", "asc")->get();
        
        if(count($_wallet) > 0)
        {
            $data["log_total"] = 0;
            foreach($_wallet as $key => $wallet)
            {
                $data["_wallet"][$key] = $wallet;
                $data["_wallet"][$key]->display_amount = Currency::format($wallet->wallet_log_amount);
                $data["_wallet"][$key]->display_date = date("F d, Y - h:i A ", strtotime($wallet->wallet_log_date_created)); //October 24, 1991 (10:30 AM)
                $data["log_total"] += $wallet->wallet_log_amount;
                $data["_wallet"][$key]->running_balance = Currency::format($data["log_total"]);
            }

            $data["log_total"] = Currency::format($data["log_total"]);

            return view("member.mlm_developer.popup_earnings", $data);
        }
        else
        {
            $data["title"] = "NO EARNINGS";
            $data["message"] = "This slot doesn't have any earnings yet.";
            return view("error_modal", $data);
        } 
    }
    public function popup_points()
    {
        $_points = Tbl_mlm_slot_points_log::where("points_log_slot", Request::input("slot_id"))->where("points_log_complan", Request::input("point"))->orderBy("points_log_id", "asc")->get();
        $data["slot_info"] = Tbl_mlm_slot::where("slot_id", Request::input("slot_id"))->first();

        if(count($_points) > 0)
        {
            $data["log_total"] = 0;
            foreach($_points as $key => $points)
            {
                $data["_points"][$key] = $points;
                $data["_points"][$key]->display_amount = number_format($points->points_log_points, 2) . " POINT(S)";
                $data["_points"][$key]->display_date = date("F d, Y - h:i A ", strtotime($points->points_log_date_claimed)); //October 24, 1991 (10:30 AM)
                $data["log_total"] += $points->points_log_points;
                $data["_points"][$key]->running_balance = number_format($data["log_total"], 2);
            }

            $data["log_total"] = number_format($data["log_total"], 2) . " POINT(S)";

            return view("member.mlm_developer.popup_points", $data);
        }
        else
        {
            $data["title"] = "NO POINTS";
            $data["message"] = "This slot doesn't have any points yet.";
            return view("error_modal", $data);
        }

    }

    public function create_slot_submit()
    {
        $data                       = Self::get_initial_settings();
        $array_position             = array("left", "right");

        /* INITIALIZE AND CAPTURE DATA */
        $shop_id                    = $this->user_info->shop_id;
        $sponsor                    = Tbl_mlm_slot::where("slot_no", Request::input("sponsor"))->where("shop_id", $shop_id)->value("slot_id");
        $placement                  = Tbl_mlm_slot::where("slot_no", Request::input("placement"))->where("shop_id", $shop_id)->value("slot_id");
        $random_sponsor             = Tbl_mlm_slot::where("shop_id", $shop_id)->orderBy(DB::raw("rand()"))->value("slot_id");
        $random_placement           = Tbl_mlm_slot::where("shop_id", $shop_id)->orderBy(DB::raw("rand()"))->value("slot_id");  
        $random_position            = $array_position[array_rand($array_position)];

        /* POSITIONING DATA */
        $slot_sponsor               = $sponsor != null ? $sponsor : $random_sponsor;
        $slot_placement             = $placement != null ? $placement : $random_placement;
        $slot_position              = (Request::input("position") == "random" ? $random_position : Request::input("position"));

        /* SLOT GENERATION */
        $membership_package_id      = Request::input("membership");
    	$customer_id                = Self::create_slot_submit_random_customer($shop_id);
        $membership_code_id         = Self::create_slot_submit_create_code($customer_id, $membership_package_id);
        $slot_id                    = Self::create_slot_submit_create_slot($customer_id, $membership_code_id, $slot_sponsor, $slot_placement, $slot_position, $shop_id,null,Carbon::now());
        
        /* RANDOM WHILE PLACEMENT IS STILL TAKEN */
        if(Request::input("placement") == "")
        {
            if(isset($slot_id["message"]))
            {
                if($slot_id["message"] == "Placement Alread Taken")
                {
                    while($slot_id["message"] == "Placement Alread Taken")
                    {
                        $slot_placement = Tbl_mlm_slot::where("shop_id", $shop_id)->orderBy(DB::raw("rand()"))->value("slot_id"); 
                        $slot_id = Self::create_slot_submit_create_slot($customer_id, $membership_code_id, $slot_sponsor, $slot_placement, $slot_position, $shop_id);
                    }
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
    	$random_user = Tbl_customer::orderBy(DB::raw("rand()"))->where("archived", 0)->first();

    	$insert_customer["shop_id"]        = $shop_id;
    	$insert_customer["first_name"]     = ucfirst($random_user->first_name);
    	$insert_customer["last_name"]      = ucfirst($random_user->last_name);
    	$insert_customer["email"]          = $random_user->email;
    	$insert_customer["ismlm"]          = 1;
    	$insert_customer["mlm_username"]   = $random_user->email;
    	$insert_customer["password"]       = Crypt::encrypt($random_user->first_name);

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
    public static function create_slot_submit_create_slot($customer_id, $membership_code_id, $slot_sponsor, $slot_placement, $slot_position, $shop_id, $slot_no = null, $date_created)
    {
        $lowest_rank                            = Tbl_brown_rank::where("rank_shop_id", $shop_id)->min("rank_id");
        $request_check['slot_no']               = $slot_no;
        $request_check['shop_id']               = $shop_id; //required
        $request_check['slot_owner']            = $customer_id; //required
        $request_check['membership_code_id']    = $membership_code_id; //required
        $request_check['slot_sponsor']          = $slot_sponsor; // required
        $request_check['slot_placement']        = $slot_placement; // optional defends on settings
        $request_check['slot_position']         = $slot_position; // optional defends on settings
        $request_check['date_created']          = $date_created; // optional defends on settings

        if($lowest_rank)
        {
            $request_check['brown_rank_id']         = $lowest_rank; // optional defends on settings
        }

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
        $shop_id        = $this->user_info->shop_id;
        $_slot          = Tbl_mlm_slot::where("shop_id", $shop_id)->get();

        Tbl_tree_placement::where("shop_id", $shop_id)->delete();
        Tbl_tree_sponsor::where("shop_id", $shop_id)->delete();
        Tbl_mlm_slot_wallet_log::where("shop_id", $shop_id)->delete();

        foreach($_slot as $slot)
        {
            Tbl_mlm_slot_wallet_log::where("wallet_log_slot", $slot->slot_id)->delete();
            Tbl_mlm_slot::where("slot_id", $slot->slot_id)->delete();
            Tbl_mlm_slot::where("slot_owner", $slot->slot_owner)->delete();
            Tbl_customer_address::where("customer_id", $slot->slot_owner)->delete();
        }
        
        $_customer      = Tbl_customer::where("shop_id", $shop_id)->get(); 

        foreach($_customer as $customer)
        {
            Tbl_customer_address::where("customer_id", $customer->customer_id)->delete();
            Tbl_customer::where("customer_id", $customer->customer_id)->delete();
        }



        return Redirect::to("/member/mlm/developer");
    }
    public function import()
    {
        $data["page"] = "Import Slot";
        return view("member.mlm_developer.import_slot");
    }
    public function import_submit()
    {
        
        $data                       = Self::get_initial_settings();

        /* INITIALIZE AND CAPTURE DATA */
        $shop_id                    = $this->user_info->shop_id;
        $sponsor                    = Tbl_mlm_slot::where("slot_no", Request::input("sponsor"))->where("shop_id", $shop_id)->value("slot_id");
        $placement                  = Tbl_mlm_slot::where("slot_no", Request::input("placement"))->where("shop_id", $shop_id)->value("slot_id");

        /* POSITIONING DATA */
        $slot_sponsor               = $sponsor;
        $slot_placement             = $placement;
        $slot_position              = strtolower(Request::input("position"));


        /* SLOT GENERATION */
        $membership_package_id      = Request::input("package_number");



        $existing_customer          = Tbl_customer::where("shop_id", $shop_id)->where("email", Request::input("email"))->first();

        if(Request::input("date_created") == "undefined")
        {
            $slot_date_created      = date("Y-m-d h:i");
        }
        else
        {
            $slot_date_created      = date("Y-m-d", strtotime(Request::input("date_created")));
        }
        


        if($existing_customer)
        {
            $customer_id            = $existing_customer->customer_id;
        }
        else
        {
            $random_user = Tbl_customer::orderBy(DB::raw("rand()"))->where("archived", 0)->first();

            $insert_customer["shop_id"]        = $shop_id;
            $insert_customer["first_name"]     = (Request::input("first_name") == "undefined" ? "John" : ucfirst(Request::input("first_name")));
            $insert_customer["last_name"]      = (Request::input("last_name") == "undefined" ? "Doe" : ucfirst(Request::input("last_name")));
            $insert_customer["email"]          = (Request::input("emaail") == "undefined" ? "dummy@gmail.com" : Request::input("email"));
            $insert_customer["ismlm"]          = 1;
            $insert_customer["mlm_username"]   = Request::input("slot_no");
            $insert_customer["password"]       = Crypt::encrypt(randomPassword());
            $insert_customer["created_date"]   = $slot_date_created;
            
            $customer_id = Tbl_customer::insertGetId($insert_customer);
        }

        if($membership_package_id == "undefined")
        {
            $membership_package_id  = null;
        }

        $membership_code_return     = Reward::generate_membership_code($customer_id, $membership_package_id);
        $membership_code_id         = (isset($membership_code_return["membership_code_id"]) ? $membership_code_return["membership_code_id"] : null);
        $slot_id                    = Self::create_slot_submit_create_slot($customer_id, $membership_code_id, $slot_sponsor, $slot_placement, $slot_position, $shop_id, Request::input("slot_no"), $slot_date_created);
        
        if(!$membership_code_id)
        {
            $return["status"] = "error";
            $return["message"] = "Invalid Package Number";
        }
        elseif(isset($slot_id["status"]))
        {
            $return["status"] = "error";
            $return["message"] = $slot_id["message"];
        }
        else
        {
            /* CHECK IF SPONSOR 0 - IT MEANS NO COMPUTATION */
            if($sponsor != 0)
            {
                Mlm_compute::entry($slot_id);
            }

            $return["status"] = "success";
        }

        echo json_encode($return);
    }
    public function repurchase()
    {
        $data["page"]       = "Repurchase";
        $shop_id            = $this->user_info->shop_id;
        $data               = Self::get_initial_settings();
        $data["_item"]      = Tbl_mlm_item_points::where("tbl_item.shop_id", $shop_id)->joinItem()->joinMembership()->groupBy("tbl_item.item_id")->get();
        $_item              = $data["_item"];
        // dd($data,$shop_id);
        // $data["_plan"]      = Tbl_mlm_plan::where("shop_id",$shop_id)
        //                                   ->where("marketing_plan_enable",1)
        //                                   ->where("marketing_plan_trigger","Product Repurchase")
        //                                   ->get();
        // dd($data);
        return view("member.mlm_developer.repurchase", $data);
    }
    public function repurchase_submit()
    {
        $shop_id                    = $this->user_info->shop_id;
        $return["status"]           = "success";
        $return["call_function"]    = "repurchase_submit_done";
        $slot_no                    = Request::input("slot_no");
        $_send                      = Request::input();

        unset($_send["slot_id"]);
        unset($_send["_token"]);

        if($slot_no == "")
        {
            $slot_info = Tbl_mlm_slot::where("shop_id",$shop_id)->orderByRaw("RAND()")->first();
        }
        else
        {
            $slot_info = Tbl_mlm_slot::where("slot_no",$slot_no)->where("shop_id",$shop_id)->first();
        }

        foreach($_send as $key => $send)
        {
            if($send == "")
            {
                $_send[$key] = 100;
            }
        }

        if($slot_info == null)
        {
            $return["status"]           = "error_message";
            $return["error_message"]    = "Slot error";

            return json_encode($return);
        }
        else
        {
            $slot_id = $slot_info->slot_id;
        }
        
        Mlm_compute::repurchasev2($slot_id,$shop_id,$_send);
        return json_encode($return);
    }
    public function get_initial_settings()
    {
        $shop_id                = $this->user_info->shop_id;
        $_complan               = Tbl_mlm_plan::where('shop_id', $shop_id)->enable(1)->get();

        $data['binary_enabled'] = 0;
        $data['binary_auto']    = 0;
        $data['binary_repurchase'] = 0;
        $data['unilevel'] = 0;

        foreach($_complan as $complan)
        {
            if($complan->marketing_plan_code == "BINARY" && $complan->marketing_plan_enable == 1)
            {
                $data["binary_enabled"] = 1;
                $data["binary_auto"] = 0;

                $binary_advance = Tbl_mlm_binary_setttings::where('shop_id', $shop_id)->first(); 
                if(isset($binary_advance->binary_settings_placement))
                {
                    $data['binary_auto'] = $binary_advance->binary_settings_placement;
                }
            }

            if($complan->marketing_plan_code == "BINARY_REPURCHASE" && $complan->marketing_plan_enable == 1)
            {
                $data["binary_repurchase"]               = 1;
            }

            if($complan->marketing_plan_code == "UNILEVEL" && $complan->marketing_plan_enable == 1)
            {
                $data["unilevel"]                        = 1;
            }

            if($complan->marketing_plan_code == "REPURCHASE_POINTS" && $complan->marketing_plan_enable == 1)
            {
                $data["repurchase_points"]               = 1;  
            }

            if($complan->marketing_plan_code == "REPURCHASE_CASHBACK" && $complan->marketing_plan_enable == 1)
            {
                $data["repurchase_cashback"]             = 1;
            }

            if($complan->marketing_plan_code == "UNILEVEL_REPURCHASE_POINTS" && $complan->marketing_plan_enable == 1)
            {
                $data["unilevel_repurchase_points"]      = 1;       
            }

            if($complan->marketing_plan_code == "DISCOUNT_CARD_REPURCHASE" && $complan->marketing_plan_enable == 1)
            {
                $data["discount_card_repurchase"]        = 1; 
            }

            if($complan->marketing_plan_code == "STAIRSTEP" && $complan->marketing_plan_enable == 1)
            {
                $data["stairstep"]                       = 1;
            }

            if($complan->marketing_plan_code == "RANK" && $complan->marketing_plan_enable == 1)
            {
                $data["rank"]                            = 1;
            }

        }

        return $data;
    }
} 