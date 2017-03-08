<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_user;
use App\Globals\Account;
use App\Globals\Seed;
use App\Globals\Utilities;
use Crypt;
use Redirect;
use Request;
use View;
use Session;

class Member extends Controller
{
	public $user_info;

	function __construct()
	{
		
		/* IF SESSION FOR EMAIL OR PASSWORD DOESN'T EXIST - REDIRECT TO FRONTPAGE */
		if(!session('user_email') || !session('user_password'))
		{
			return Redirect::to("/")->send();
		}
		else
		{
			/* CHECK IF USERNAME DOESN'T EXIST IN DB - REDIRECT TO FRONTPAGE */
			$user_info = Tbl_user::where("user_email", session('user_email'))->shop()->first();
			if(!$user_info)
			{
				return Redirect::to('/')->send();
			}
			else
			{
				/* CHECK IF PASSWORD IS NOT CORRECT - REDIRECT TO FRONTPAGE */
				$decrypted_session_password = Crypt::decrypt(session("user_password"));
				$decrypted_db_password = Crypt::decrypt($user_info->user_password);
				if($decrypted_db_password != $decrypted_session_password)
				{
					return Redirect::to('/')->send();
				}
				else
				{

					$this->user_info = $user_info;
					View::share('user_info', $user_info);

					/* CHECK IF SHOP STATUS IS INITIAL - REDIRECT TO INITIAL PAGE */
					if($user_info->shop_status == "initial" && Request::segment(2) != "setup")
					{
						return Redirect::to('/member/setup')->send();
					}
				}
			}
		}

		View::share("_page", Utilities::filterPageList());
		
		/* Seeding */
		Seed::auto_seed();
		
		/* GET CURRENT DOMAIN FOR FRONTEND */
		if($this->user_info->shop_domain != "unset_yet")
		{
			$data["frontend_domain"] = $this->user_info->shop_domain;
		}
		else
		{
			
			$data["frontend_domain"] = $this->user_info->shop_key . "." . get_domain();
		}

		View::share("frontend_domain", $data["frontend_domain"]);

		/* INSERT DEFAULT CHART OF ACCOUNT */
		Account::put_default_account($this->user_info->shop_id);
	}
	public function show_no_access()
	{
		return view('member.no_access');
	}
	public function show_no_access_modal()
	{
		return view('member.no_access_modal');
	}
	public function getShop_Id()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
	}
}