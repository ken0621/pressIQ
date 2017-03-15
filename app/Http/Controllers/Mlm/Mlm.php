<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Session;
use DB;
use App\Models\Tbl_customer;
use App\Models\Tbl_shop;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_membership_code;

use App\Globals\Mlm_member;
class Mlm extends Controller
{
    public static $customer_id;
    public static $customer_info;
    public static $shop_id;
    public static $shop_info;
    public static $slot_now;
    public static $slot_id;
    public static $discount_card_log_id;
    public static $discount_card_log;
    public function __construct()
    {	
        if(Session::get('mlm_member') != null)
        {
            $session = Session::get('mlm_member');
            Self::$customer_id = $session['customer_info']->customer_id;
            Self::$customer_info = $session['customer_info'];

            Self::$shop_id = $session['shop_info']->shop_id;
            Self::$shop_info = $session['shop_info'];

            if($session['slot_now'])
            {
                Self::$slot_id = $session['slot_now']->slot_id;
                Self::$slot_now = $session['slot_now'];
            }
            else
            {
                $count_all_slot = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)
                ->membershipcode()->count();
                if($count_all_slot >= 1)
                {
                    $count_all_slot = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)
                    ->membershipcode()->first();
                    $new_slot_id = $count_all_slot->slot_id;
                    Mlm_member::add_to_session_edit(Self::$shop_id, Self::$customer_id, $new_slot_id);
                }
                Self::$slot_id = null;
                Self::$slot_now = null;
            }
            if($session['discount_card'])
            {
                Self::$discount_card_log_id = $session['discount_card']->discount_card_log_id;
                Self::$discount_card_log =  $session['discount_card'];
            }
            else
            {
                Self::$discount_card_log_id = null;
                Self::$discount_card_log = null;
            }
            $all_slot = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)
            ->membershipcode()
            ->membership()
            ->take(10)
            ->get();
            $plan_settings = Tbl_mlm_plan::where('shop_id', Self::$shop_id)
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Slot Creation')
            ->get();

            $plan_settings_repurchase = Tbl_mlm_plan::where('shop_id', Self::$shop_id)
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Product Repurchase')
            ->get();  

            $notification_s = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)
            ->orderBy('wallet_log_notified', 'ASC')
            ->orderBy('wallet_log_id', 'DESC')
            ->sponsorslot()
            ->where('wallet_log_notified', 0)
            ->get();

            $noti_count = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)
            ->where('wallet_log_notified', 0)->count();
            // dd(Self::$customer_info);
            $content = DB::table('tbl_content')->where('shop_id', Self::$shop_id)->get();
            $content_a = [];
            foreach($content as $c => $value)
            {
                $content_a[$value->key] = $value->value;
            }
            View::share("content", $content_a);
            View::share("complan", $plan_settings);
            View::share("complan_repurchase", $plan_settings_repurchase);
            View::share("customer_info", Self::$customer_info);
            View::share("shop_info", Self::$shop_info);
            View::share("slot_now", Self::$slot_now);
            View::share("slot", $all_slot);
            View::share("notification", $notification_s);
            View::share("notification_count", $noti_count);
            View::share('discount_card_log', Self::$discount_card_log );
        }
        else
        {
            return Redirect::to("/mlm/login")->send();
        }
    }
    public static function show_maintenance()
    {
        return view('mlm.maintenance');
    }
    public static function no_access()
    {

    }
    public static function changeslot()
    {
        $customer_id = Self::$customer_id;
        $new_slot_id = Request::input('slot_id'); 
        $count = Tbl_mlm_slot::where('slot_owner', $customer_id)->where('slot_id', $new_slot_id)->count();   
        if($count == 0)
        {
            $data['response_status'] = "warning";
            $data['message'] = "You don't own the slot";
            return Redirect::back();
        }
        else
        {
            Mlm_member::add_to_session_edit(Self::$shop_id, $customer_id, $new_slot_id);
            $data['response_status'] = "success";
            $data['message'] = "Slot Changed";
            return Redirect::to('/mlm');
        }
        return json_encode($data);
    }
    public static function get_customer_info($customer_id)
    {
        $data = [];
        return Mlm_member::get_customer_info($customer_id);
    }
    public static function show_no_access()
    {
        return view('mlm.no_access');
    }

}