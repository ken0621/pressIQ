<?php
namespace App\Globals;

use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_shop;
use App\Models\Tbl_customer;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_customer_search;
use App\Models\Tbl_customer_other_info;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_mlm_lead;
use App\Models\Tbl_country;
use App\Models\Tbl_customer_login_history;

use App\Http\Controllers\Member\MLM_MembershipController;
use App\Http\Controllers\Member\MLM_ProductController;

use Schema;
use Session;
use DB;
use Carbon\Carbon;
use Request;
use Validator;
use Crypt;

use App\Globals\Mlm_compute;
use App\Globals\Mlm_slot_log;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_member;
class Mlm_login_history
{
    // customer_login_history_id
    // customer_login_history_login
    // customer_login_history_logout
    // customer_login_history_last_activity
    // customer_id
    public static function add_to_history($customer_id, $username, $password)
    {
        $insert['customer_login_history_login'] = Carbon::now();
        $insert['customer_login_history_last_activity'] = Carbon::now();
        $insert['customer_id'] = $customer_id;
        $insert['customer_username'] = $username;
        $insert['customer_password'] = Crypt::encrypt($password); 
        $insert['status_message'] = 'Success Login';
        $customer_login_history_id = Tbl_customer_login_history::insertGetId($insert);
        
        $login_history = Tbl_customer_login_history::where('customer_login_history_id', $customer_login_history_id)->first();
        Session::put('login_history', $login_history);
    }
    public static function update_last_activity()
    {
        $login_history = Session::get('login_history');
        if($login_history)
        {
            $update['customer_login_history_last_activity'] = Carbon::now();
            Tbl_customer_login_history::where('customer_login_history_id', $login_history->customer_login_history_id)->update($update);
        }
    }
    public static function log_out()
    {
        $login_history = Session::get('login_history');
        if($login_history)
        {
            $update['customer_login_history_logout'] = Carbon::now();
            $update['customer_login_history_last_activity'] = Carbon::now();
            Tbl_customer_login_history::where('customer_login_history_id', $login_history->customer_login_history_id)->update($update);
        }
    }
    public static function fail_login($username, $password, $message)
    {
        $insert['customer_login_history_login'] = Carbon::now();
        $insert['customer_login_history_last_activity'] = Carbon::now();
        $insert['customer_username'] = $username;
        $insert['customer_password'] = Crypt::encrypt($password); 
        $insert['status_message'] = $message;
        $insert['status'] = 0;
        $customer_login_history_id = Tbl_customer_login_history::insertGetId($insert);
    }
}