<?php
namespace App\Http\Controllers\Super;
use App\Http\Controllers\Controller;
use App\Models\Tbl_Admin;
use Request;
use Redirect;


class AdminControllers extends Controller
{
	public function getview()
	{
		return view("super_admin.admin_layout");
	}

	public function add()
	{
		$insert["username"] = Request::input("username");
		$insert["password"] = Request::input("password");
		$insert["first_name"] = Request::input("first_name");
		$insert["last_name"] = Request::input("last_name");
		$insert["mobile_number"] = Request::input("mobile_number");
		Tbl_Admin::insert($insert);

		Redirect::to("/super/login")->send();
	}

	public function login()
	{
		return view("super_admin.login_admin");
	}
	
}