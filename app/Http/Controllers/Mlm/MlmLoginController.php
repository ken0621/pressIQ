<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Route;
use Session;
use App\Globals\Mlm_member;
use App\Models\Tbl_shop;
use App\Models\Tbl_customer;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_mlm_lead;
use App\Models\Tbl_mlm_slot;
class MlmLoginController extends Controller
{
	public static $shop_id;
    public static $lead;
	public function __construct()
    {	
    	$domain = Request::url();
    	$check_expole = explode('//', $domain);
    	if(count($check_expole) == 2 )
    	{
    		$check_expole_2 = explode('.', $check_expole[1]);
    		$key = $check_expole_2[0];
    		$check_domain = Tbl_shop::where('shop_key', $key)->first();
            $lead_e = null;
            if($check_domain == null)
            {
                $check_domain = Tbl_customer::where('mlm_username', $key)->first();
                $lead_e = $check_domain;
            }
            
    	}
    	if($check_domain != null)
    	{
    		 Self::$shop_id = $check_domain->shop_id;
             if($lead_e != null)
             {
                Self::$lead = $lead_e;
             }
             else
             {
                Self::$lead = null;
             }
    	}
        else
        {
            $domain = Request::url();
            $check_expole = explode('.', $domain);
            if(isset($check_expole[2]))
            {
                $check_expole_2 = explode('/', $check_expole[2]);
                if(isset($check_expole_2[0]))
                {
                    $shop_domain = $check_expole[1] . '.' . $check_expole_2[0];
                    $shop = Tbl_shop::where('shop_domain', $shop_domain)->first();
                    if($shop != null)
                    {
                        Self::$shop_id = $shop->shop_id;
                    }

                }
            }
            else
            {

                if(isset($check_expole[1]))
                {

                    $check_expole_2 = explode('/', $check_expole[1]);
                    if(isset($check_expole_2[0]))
                    {
                        $check_expole_slash = explode('//', $check_expole[0]);
                        if(count($check_expole_slash) >= 2)
                        {
                          $check_expole[0] = $check_expole_slash[1];  
                        }
                        $shop_domain = $check_expole[0] . '.' . $check_expole_2[0];
                        $shop = Tbl_shop::where('shop_domain', $shop_domain)->first();
                        if($shop != null)
                        {
                            Self::$shop_id = $shop->shop_id;
                        }
                    }   
                }
            }
        }

    	
    }
    public function index()
    {
    	Session::forget('mlm_member');
        $data["page"] = "Login";
        return view("mlm.login", $data);
    }   
    public static function error404()
    {
    	 return view('errors.404');
    }
    public function post_login()
    {
    	// return $_POST;
    	$username = Request::input('user');
		$password = Request::input('pass');
		if($username != null || $password != null)
		{
			$data['type'] = 'error';
			$data['message'] = 'Invalid Username/Password';
			$count = Tbl_customer::where('mlm_username', $username)->count();
			if($count >= 1)
			{
				$enc_pass = Crypt::encrypt($password);
				$user = Tbl_customer::where('mlm_username', $username)
				->first();
				$user_pass = Crypt::decrypt($user->password);
                // return $user->archived;
                if($user->archived == 0)
                {
                    if($password == $user_pass)
                    {
                        $shop_id = $user->shop_id;
                        Mlm_member::add_to_session($shop_id, $user->customer_id);
                        $data['type'] = 'success';
                        $data['message'] = 'You will be redirected.';
                    }
                    else
                    {
                        $data['type'] = 'error';
                        $data['message'] = 'Invalid Username/Password';
                    }
                }
				else
                {
                    $data['type'] = 'error';
                    $data['message'] = 'Sorry Your Account is Disabled, Please Contact the Administrator.';
                }
			}
			else
			{
				$data['type'] = 'error';
				$data['message'] = 'Username Does Not Exist';
			}
		}
		else
		{
			$data['type'] = 'error';
			$data['message'] = 'Invalid Username/Password';
		}
    	return json_encode($data);
    }
    public function membership_active_code($pin)
    {
        $data = [];
        $pin_d = Crypt::decrypt($pin);
        $data['membership_code'] = Tbl_membership_code::where('membership_code_id', $pin_d)->first();
        if(isset($data['membership_code']->customer_id))
        {
        $data['customer'] = Mlm_member::get_customer_info($data['membership_code']->customer_id);
        $data['cus'] = Tbl_customer::where('customer_id', $data['membership_code']->customer_id)->first();
        $shop_id = $data['cus']->shop_id;
        $customer_id = $data['membership_code']->customer_id;
        $data['binary_settings'] = Tbl_mlm_plan::where('shop_id', $shop_id)
            ->where('marketing_plan_code', 'BINARY')
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Slot Creation')
            ->first();
        $data['binary_advance'] = Tbl_mlm_binary_setttings::where('shop_id', $shop_id)->first();
        
        $data['lead'] = Tbl_mlm_lead::where('lead_customer_id_lead', $customer_id)
        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=','tbl_mlm_lead.lead_slot_id_sponsor')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
        ->join('tbl_membership_code', 'tbl_membership_code.slot_id', '=', 'tbl_membership_code.slot_id')
        ->where('tbl_mlm_lead.lead_used', 0)
        ->first();

        $data['_slots'] = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)->customer()->get();
        // $data['sponsor'] = view('mlm.dashboard.no_slot_v2', $data);
        }

        // dd($data);
        return view('mlm.email.use', $data);
        // return Crypt::decrypt($pin);    
    }
    public function membership_active_code_post()
    {
        // return json_encode($_POST);
        $membership_code_id = Request::input('membership_code_id');
        $membership_activation_code = Request::input('membership_activation_code');
        $customer_id = Request::input('customer_id');
        $password = Request::input('password');
        if($membership_code_id != null)
        {
            if($membership_activation_code != null)
            {
                if($customer_id != null)
                {
                    if($password != null)
                    {
                        $mem_code = Tbl_membership_code::where('membership_code_id', $membership_code_id)->where('membership_activation_code', $membership_activation_code)->count();
                        if($mem_code >= 1)
                        {
                            $mem_code = Tbl_membership_code::where('membership_code_id', $membership_code_id)->where('membership_activation_code', $membership_activation_code)->where('used', 0)->count();
                            if($mem_code >= 1)
                            {
                                $customer = Tbl_customer::where('customer_id', $customer_id)->first();
                                $password_d = Crypt::decrypt($customer->password);
                                if($password == $password_d)
                                {
                                    $data['status'] = 'success';
                                    $data['message'] = 'Invalid Password';

                                    return Mlm_member::add_slot($customer->shop_id, $customer->customer_id);
                                }
                                else
                                {
                                    $data['status'] = 'warning';
                                    $data['message'] = 'Invalid Password';
                                }
                            }
                            else
                            {
                                $data['status'] = 'warning';
                                $data['message'] = 'Membership Code Already Used.';
                            }
                        }
                        else
                        {
                            $data['status'] = 'warning';
                            $data['message'] = 'Invalid Membership Code.';
                        }
                    }
                    else
                    {
                        $data['status'] = 'warning';
                        $data['message'] = 'Password is required';
                    }
                }
                else
                {
                    $data['status'] = 'warning';
                    $data['message'] = 'Invalid customer.';
                }
            }
            else
            {
                $data['status'] = 'warning';
                $data['message'] = 'Invalid Membership Code.';
            }
        }
        else
        {
            $data['status'] = 'warning';
            $data['message'] = 'Invalid Membership Code Pin.';
        }
        return json_encode($data);
        $data['membership_code'] = Tbl_membership_code::where('membership_code_id', $pin_d)->first();
    }
}