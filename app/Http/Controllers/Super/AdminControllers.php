<?php
namespace App\Http\Controllers\Super;
use App\Http\Controllers\Controller;
use App\Models\Tbl_Admin;
use App\Models\Tbl_shop;
use Request;
use Redirect;
use Session;
use Intervention\Image\Image as Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;

class AdminControllers extends Controller
{
	 
	public function getview()
	{
		Self::allow_logged_in_users_only();
		$data["_shop"] = Tbl_shop::get();
		$data["_shop"] = Tbl_shop::paginate(7);
		return view("super_admin.index_admin",$data);
	}

	public function add()
	{

		 $file = Input::file('user_pic');

         $destinationPath = public_path(). '/uploads/Digima-17';
         $filename = $file->getClientOriginalName();

         $file->move($destinationPath, $filename);

       	$insert["user_pic"] = $filename;
		$insert["username"] = Request::input("username");
		$insert["password"] = Crypt::encrypt(Request::input("password"));
		$insert["first_name"] = Request::input("first_name");
		$insert["last_name"] = Request::input("last_name");
		$insert["mobile_number"] = Request::input("mobile_number");
		$admin_id=Tbl_Admin::insertGetId($insert);
		$admin_info = Tbl_Admin::where("admin_id",$admin_id)->first();
		Session::put('user', $admin_info);
		Redirect::to("/admin/profile")->send();
	}
	public static function allow_logged_in_users_only()
	{
		if(session("login") == true)
		{
			Session::put('user', 'login');
			return Redirect::to("/super")->send();
		}
	}
	public static function allow_logged_out_users_only()
	{
		if(session("login") != true)
		{
			return Redirect::to("/super/login")->send();
		}
	}
	public function view()
	{

		return view("super_admin.login_admin");

	}

	public function login_submit()
	{
      $check_login = Tbl_Admin::where("username", Request::input("username"))->first();
			
 		/*Session::put('user', $check_login); */

		if($check_login)
		{
			$password= Crypt::decrypt($check_login->password);
			$request_password=Request::input("password");
			/*return $password."=".$request_password;*/
			if($password == $request_password){
				Session::put('user', $check_login);
				return "true";

			}

			else{

				return "false";
				

			}
		}	
		else
		{
			
			return "false";
		}
			
	}

	public function layout()
	{
		$data['admin']= Session::get('user');
		return view("super_admin.admin_layout",$data);
	}

	public function sample()
	{
		
		return view("super_admin.sample");
	}
}