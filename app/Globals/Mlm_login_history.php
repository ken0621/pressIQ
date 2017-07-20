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
    // ip_address
    // ip_browser
    // ip_device
    public static function add_to_history($customer_id, $username, $password)
    {
        $insert['customer_login_history_login'] = Carbon::now();
        $insert['customer_login_history_last_activity'] = Carbon::now();
        $insert['customer_id'] = $customer_id;
        $insert['customer_username'] = $username;
        $insert['customer_password'] = Crypt::encrypt($password); 
        $insert['status_message'] = 'Success Login';
        $insert['ip_address'] = Self::getIp();
        $insert['ip_browser'] = Self::getBrowser();
        $insert['ip_device'] =  $_SERVER['HTTP_USER_AGENT'];
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
        $insert['ip_address'] = Self::getIp();
        $insert['ip_browser'] = Self::getBrowser();
        $insert['ip_device'] =  $_SERVER['HTTP_USER_AGENT'];
        $customer_login_history_id = Tbl_customer_login_history::insertGetId($insert);
    }
    public static function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
    public static function getBrowser() 
    { 
        $u_agent = $_SERVER['HTTP_USER_AGENT']; 
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
    
        //First get the platform
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
    
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            $bname = 'Mozilla Firefox'; 
            $ub = "Firefox"; 
        }
        elseif(preg_match('/OPR/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)) 
        { 
            $bname = 'Google Chrome'; 
            $ub = "Chrome"; 
        } 
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        } 
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        } 
    
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
    
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }
    
        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
        
        
        return 'Browser: ' . $bname . ', Version: ' . $version .  ', Platform: ' . $platform; 
        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    } 
}