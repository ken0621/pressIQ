<?php
namespace App\Http\Controllers\Shop;
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
use App\Models\Tbl_mlm_encashment_settings;

use App\Globals\Mlm_member;
use App\Globals\Settings;
class ShopAccountController extends Shop
{
    public static $customer_id;
    public static $customer_info;
    public static $shop_id;
    public static $shop_infos;
    public static $slot_now;
    public static $slot_id;
    public static $discount_card_log_id;
    public static $discount_card_log;
	public function checkif_login()
    {
        if(Session::get('mlm_member') != null)
        {
            $session = Session::get('mlm_member');
            Self::$customer_id = $session['customer_info']->customer_id;
            Self::$customer_info = $session['customer_info'];

            Self::$shop_id = $session['shop_info']->shop_id;
            Self::$shop_infos = $session['shop_info'];

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
            if(isset($session['discount_card']))
            {
                Self::$discount_card_log_id = null;
                Self::$discount_card_log = null;
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
            ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD_REPURCHASE')
            ->get();  

            $notification_s = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)
            ->orderBy('wallet_log_notified', 'ASC')
            ->orderBy('wallet_log_id', 'DESC')
            ->sponsorslot()
            ->where('wallet_log_notified', 0)
            ->take(10)
            ->get();

            $noti_count = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)
            ->where('wallet_log_notified', 0)->count();
            $content = DB::table('tbl_content')->where('shop_id', Self::$shop_id)->get();
            $content_a = [];
            foreach($content as $c => $value)
            {
                $content_a[$value->key] = $value->value;
            }
            $customer = Tbl_customer::where('customer_id', Self::$customer_id)->first();
            $customer->profile != null ? $profile = $customer->profile :  $profile = '/assets/mlm/default-pic.png';

            View::share("profile", $profile);
            View::share("content", $content_a);
            View::share("complan", $plan_settings);
            View::share("complan_repurchase", $plan_settings_repurchase);
            View::share("customer_info", Self::$customer_info);
            View::share("shop_info", Self::$shop_infos);
            View::share("slot_now", Self::$slot_now);
            View::share("slot", $all_slot);
            View::share("notification", $notification_s);
            View::share("notification_count", $noti_count);
            View::share('discount_card_log', Self::$discount_card_log );
        }
        else
        {
            return Redirect::to("/")->send();
        }
    }
    public function index()
    {
        $this->checkif_login();

        $data["page"] = "Account";
        return view("account_profile", $data);
    }
    public function order()
    {
        $this->checkif_login();

        $data["page"] = "Order";
        return view("account_order", $data);
    }
    public function logout()
    {
        Session::forget('mlm_member');

        return Redirect::to("/");
    }
}