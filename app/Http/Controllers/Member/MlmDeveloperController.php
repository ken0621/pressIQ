<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_membership;
use App\Models\Tbl_customer;
use App\Globals\Currency;
use App\Globals\Mlm_compute;
use Request;
use Crypt;

class MlmDeveloperController extends Member
{
    public $session = "MLM Developer";

    public function index()
    {
    	$data["page"] = "MLM Developer";
        return view("member.mlm_developer.mlm_developer", $data);
    }
    public function index_table()
    {
        /* INITIAL DATA */
    	$data["slot_count"] = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->count();
    	$data["_slot_page"] = $_slot = Tbl_mlm_slot::where("tbl_mlm_slot.shop_id", $this->user_info->shop_id)->customer()->currentWallet()->orderBy("slot_id", "desc")->paginate(5);

        /* CUSTOM SLOT TABLE */
        foreach($_slot as $key => $slot)
        {
        	$data["_slot"][$key] = $slot;
        	$data["_slot"][$key]->current_wallet_format = "<a href='javascript:'>" . Currency::format($data["_slot"][$key]->current_wallet) . "</a>";
        	$data["_slot"][$key]->total_earnings_format = "<a href='javascript:'>" . Currency::format($data["_slot"][$key]->total_earnings) . "</a>";
        	$data["_slot"][$key]->total_payout_format = "<a href='javascript:'>" . Currency::format($data["_slot"][$key]->total_payout * -1) . "</a>";
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
    	$data["page"]                   = "CREATE SLOT";
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
    	$customer_id                = Self::create_slot_submit_random_customer();
        $membership_package_id      = Request::input("membership");
        $membership_code_id         = Self::create_slot_submit_create_code($customer_id, $membership_package_id);
        $slot_id                    = Self::create_slot_submit_create_slot($membership_code_id);
        
    	$return["status"]        = "success";
    	$return["call_function"] = "create_test_slot_done";
    	echo json_encode($return);
    }
    public static function create_slot_submit_random_customer()
    {
    	$random_user = json_decode(file_get_contents('https://randomuser.me/api/?nat=us'))->results[0];

    	$insert_customer["shop_id"]        = $this->user_info->shop_id;
    	$insert_customer["first_name"]     = ucfirst($random_user->name->first);
    	$insert_customer["last_name"]      = ucfirst($random_user->name->last);
    	$insert_customer["email"]          = $random_user->email;
    	$insert_customer["ismlm"]          = 1;
    	$insert_customer["mlm_username"]   = $random_user->login->username;
    	$insert_customer["password"]       = Crypt::encrypt($random_user->login->password);

    	return Tbl_customer::insertGetId($insert_customer);
    }
    public static function create_slot_submit_create_code($customer_id, $membership_package_id, $type = "PS")
    {
        $insert_code["membership_activation_code"]  = "00000000";
        $insert_code["customer_id"]                 = $customer_id;
        $insert_code["membership_package_id"]       = $membership_package_id;
        $insert_code["membership_code_invoice_id"]  = 0;
        $insert_code["used"]                        = 0;
        $insert_code["shop_id"]                     = $this->user_info->shop_id;
        $insert_code["membership_code_pin"]         = 0;
        $insert_code["membership_code_price"]       = 0;
        $insert_code["membership_type"]             = $type;

        return Tbl_membership_code::insertGetId($insert_code);
    }
    public static function create_slot_submit_create_slot()
    {
        return Tbl_mlm_slot::insertGetId($insert_code);
    }
}