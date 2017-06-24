<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Session;
use DB;
use Validator;

use App\Models\Tbl_customer;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_shop;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_mlm_encashment_settings;
use App\Models\Tbl_ec_order;
use App\Models\Tbl_ec_order_item;

use App\Globals\Mlm_member;
use App\Globals\Settings;
use App\Globals\Ecom_Product;
use App\Globals\Ec_wishlist;
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
            // Self::$customer_info = $session['customer_info'];
            // Self::$shop_id = $session['shop_info']->shop_id;
            // Self::$shop_infos = $session['shop_info'];

            // if($session['slot_now'])
            // {
            //     Self::$slot_id = $session['slot_now']->slot_id;
            //     Self::$slot_now = $session['slot_now'];
            // }
            // else
            // {
            //     $count_all_slot = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)
            //     ->membershipcode()->count();
            //     if($count_all_slot >= 1)
            //     {
            //         $count_all_slot = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)
            //         ->membershipcode()->first();
            //         $new_slot_id = $count_all_slot->slot_id;
            //         Mlm_member::add_to_session_edit(Self::$shop_id, Self::$customer_id, $new_slot_id);
            //     }
            //     Self::$slot_id = null;
            //     Self::$slot_now = null;
            // }
            // if(isset($session['discount_card']))
            // {
            //     Self::$discount_card_log_id = null;
            //     Self::$discount_card_log = null;
            // }
            // else
            // {
            //     Self::$discount_card_log_id = null;
            //     Self::$discount_card_log = null;
            // }
            // $all_slot = Tbl_mlm_slot::where('slot_owner', Self::$customer_id)
            // ->membershipcode()
            // ->membership()
            // ->take(10)
            // ->get();
            // $plan_settings = Tbl_mlm_plan::where('shop_id', Self::$shop_id)
            // ->where('marketing_plan_enable', 1)
            // ->where('marketing_plan_trigger', 'Slot Creation')
            // ->get();

            // $plan_settings_repurchase = Tbl_mlm_plan::where('shop_id', Self::$shop_id)
            // ->where('marketing_plan_enable', 1)
            // ->where('marketing_plan_trigger', 'Product Repurchase')
            // ->where('marketing_plan_code', '!=', 'DISCOUNT_CARD_REPURCHASE')
            // ->get();  

            // $notification_s = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)
            // ->orderBy('wallet_log_notified', 'ASC')
            // ->orderBy('wallet_log_id', 'DESC')
            // ->sponsorslot()
            // ->where('wallet_log_notified', 0)
            // ->take(10)
            // ->get();

            // $noti_count = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)
            // ->where('wallet_log_notified', 0)->count();
            // $content = DB::table('tbl_content')->where('shop_id', Self::$shop_id)->get();
            // $content_a = [];
            // foreach($content as $c => $value)
            // {
            //     $content_a[$value->key] = $value->value;
            // }
            // $customer = Tbl_customer::where('customer_id', Self::$customer_id)->first();
            // $customer->profile != null ? $profile = $customer->profile :  $profile = '/assets/mlm/default-pic.png';

            // View::share("profile", $profile);
            // View::share("content", $content_a);
            // View::share("complan", $plan_settings);
            // View::share("complan_repurchase", $plan_settings_repurchase);
            // View::share("customer_info", Self::$customer_info);
            // View::share("shop_info", Self::$shop_infos);
            // View::share("slot_now", Self::$slot_now);
            // View::share("slot", $all_slot);
            // View::share("notification", $notification_s);
            // View::share("notification_count", $noti_count);
            // View::share('discount_card_log', Self::$discount_card_log );
        }
        else
        {
            return Redirect::to("/")->send();
        }
    }
    public function recently_viewed()
    {
        $recently = DB::table('tbl_ec_recently_viewed_products')->where('customer_id', Self::$customer_id)->where('shop_id', $this->shop_info->shop_id)->get();
        foreach ($recently as $key => $value) 
        {
            $recently[$key]->product = Ecom_Product::getProduct($value->product_id, $this->shop_info->shop_id);
        }

        return $recently;
    }
    public function cancel_order($order_id)
    {
        $update["order_status"] = "Cancelled";

        Tbl_ec_order::where('shop_id', $this->shop_info->shop_id)->where('customer_id', Self::$customer_id)->where("ec_order_id", $order_id)->update($update);
    }
    public function index()
    {
        $this->checkif_login();

        $data["page"] = "Account";
        $data["customer"] = Tbl_customer::where('tbl_customer.customer_id', Self::$customer_id)->info()->first();
        $data["order_count"] = Tbl_ec_order::where('shop_id', $this->shop_info->shop_id)->where('customer_id', Self::$customer_id)->count();
        $data["recently_viewed"] = $this->recently_viewed();

        return view("account_profile", $data);
    }
    public function order()
    {
        $this->checkif_login();

        if (Request::input("cancel_id")) 
        {
            $this->cancel_order(Request::input("cancel_id"));
            return Redirect::to("/account/order");
        }

        $data["page"] = "Order";
        $data["_order"] = Tbl_ec_order::where('shop_id', $this->shop_info->shop_id)->where('customer_id', Self::$customer_id)->get();

        return view("account_order", $data);
    }
    public function wishlist()
    {
        $this->checkif_login();
        
        $data["page"] = "Wishlist";
        $data["_wishlist"] = Ec_wishlist::getProduct(Self::$customer_id, $this->shop_info->shop_id);

        return view("account_wishlist", $data);
    }
    public function settings()
    {
        $this->checkif_login();

        $data["page"] = "Settings";
        $data["customer"] = Tbl_customer::where('tbl_customer.customer_id', Self::$customer_id)->info()->first();
        return view("account_settings", $data);
    }
    public function settings_submit()
    {
        $this->checkif_login();

        $validator = Validator::make(Request::input(), [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'customer_street' => 'required',
            'customer_state' => 'required',
            'customer_city' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/account/security')
                        ->withErrors($validator)
                        ->withInput();
        }

        $update['first_name'] = Request::input('first_name');
        $update['middle_name'] = Request::input('middle_name');
        $update['last_name'] = Request::input('last_name');
        $update['email'] = Request::input('email');

        Tbl_customer::where('customer_id', Self::$customer_id)->update($update);

        $update_address['customer_street'] = Request::input('customer_street');
        $update_address['customer_state'] = Request::input('customer_state');
        $update_address['customer_city'] = Request::input('customer_city');

        Tbl_customer_address::where('customer_id', Self::$customer_id)->update($update_address);

        return Redirect::to("/account/security")->with("success", "Sucessfully updated.");
    }
    public function security()
    {
        $this->checkif_login();

        $data["page"] = "Security";
        return view("account_security", $data);
    }
    public function security_submit()
    {
        $this->checkif_login();

        $validator = Validator::make(Request::input(), [
            'npass' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return redirect('/account/security')
                        ->withErrors($validator)
                        ->withInput();
        }

        $new = Request::input("npass");
        $confirm = Request::input("cpass");
        $old = Request::input("opass");

        $compare = Crypt::decrypt(Tbl_customer::where("customer_id", Self::$customer_id)->where("shop_id", $this->shop_info->shop_id)->first()->password);
        
        if ($compare == $old) 
        {
            if ($new == $confirm) 
            {
                $update["password"] = Crypt::encrypt($new);

                Tbl_customer::where("customer_id", Self::$customer_id)->where("shop_id", $this->shop_info->shop_id)->update($update);

                return Redirect::to("/account/security")->with("success", "Sucessfully updated.");
            }
            else
            {
                return Redirect::back()->with("fail", "New and confirm password mismatched.");
            }
        }
        else
        {
            return Redirect::back()->with("fail", "Old password mismatched.");
        }
    }
    public function invoice($id)
    {
        $data["page"] = "Invoice";
        $data["order"] = Tbl_ec_order::where("tbl_ec_order.ec_order_id", $id)->customer()->first();
        $data["_item"] = Tbl_ec_order_item::where("tbl_ec_order_item.ec_order_id", $id)->item()->get();
        
        return view("account_invoice", $data);
    }
    public function logout()
    {
        Session::forget('mlm_member');

        return Redirect::to("/");
    }
    public function account_register()
    {
        $data['error_message'] = null;
        return view('register', $data);
    }
}