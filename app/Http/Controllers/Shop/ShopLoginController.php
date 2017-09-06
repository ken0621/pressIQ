<?php
namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;

use App\Models\Tbl_customer;
use App\Models\Tbl_shop;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_mlm_encashment_settings;

use App\Globals\Mlm_member;
use App\Globals\Settings;
use App\Globals\Cart;
class ShopLoginController extends Shop
{
    public function index()
    {
        $data["page"] = "Login";
        return view("login", $data);
    }

    public function signin()
    {
        $data["page"] = "Sign In";
        return view("signin", $data);
    }

    public function submit()
    {
    	$email = Request::input('email');
		$password = Request::input('password');
		if($email != null || $password != null)
		{
			$data['type'] = 'error';
			$data['message'] = 'Invalid Username/Password';
			$count = Tbl_customer::where('email', $email)->count();
			if($count >= 1)
			{
				$enc_pass = Crypt::encrypt($password);
				$user = Tbl_customer::where('email', $email)->first();
				$user_pass = Crypt::decrypt($user->password);
                if($user->archived == 0)
                {
                    if($password == $user_pass)
                    {
                        $shop_id = $user->shop_id;
                        Mlm_member::add_to_session($shop_id, $user->customer_id);

                        $customer_info["email"] = trim(Request::input("email"));
			            $customer_info["new_account"] = false;
			            $customer_info["password"]= Request::input("password");
			            $customer_set_info_response = Cart::customer_set_info($this->shop_info->shop_id, $customer_info, array("check_account"));

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

		if (Request::input("global")) 
		{
			$data["from"] = "global_login";
		}
		else
		{
        	$data['from'] = "account_login";
		}
    
    	return json_encode($data);
    }
}