<?php
namespace App\Http\Controllers\Super;
use App\Http\Controllers\Controller;
use App\Models\Tbl_Admin;
use Request;
use Redirect;
use Session;
use Intervention\Image\Image as Image;
use Illuminate\Support\Facades\Input;

class AdminControllers extends Controller
{
	public function getview()
	{
		
		return view("super_admin.index_admin");
	}

	public function add()
	{

		 $file = Input::file('user_pic');

         $destinationPath = public_path(). '/uploads/Digima-17';
         $filename = $file->getClientOriginalName();

         $file->move($destinationPath, $filename);

       	$insert["user_pic"] = ($file);
		$insert["username"] = Request::input("username");
		$insert["password"] = Request::input("password");
		$insert["first_name"] = Request::input("first_name");
		$insert["last_name"] = Request::input("last_name");
		$insert["mobile_number"] = Request::input("mobile_number");
		Tbl_Admin::insert($insert);

		Redirect::to("/super/login")->send();
	}
	public static function allow_logged_in_users_only()
	{
		if(session("login") == true)
		{
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

      $check_login = Tbl_Admin::where("username", Request::input("username"))->where("password", Request::input("password"))->first();

		
		if($check_login)
		{
			return "true";
		}
		else
		{
			return "false";
		}
		
			return "true";	
	}

	public function layout()
	{
		
		return view("super_admin.admin_layout");
	}

	public function sample()
	{
		
		return view("super_admin.sample");
	}
}