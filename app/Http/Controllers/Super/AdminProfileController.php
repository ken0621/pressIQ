<?php
namespace App\Http\Controllers\Super;
use App\Http\Controllers\Controller;
use App\Models\Tbl_Admin;
use Request;
use Redirect;
use Session;
use Intervention\Image\Image as Image;
use Illuminate\Support\Facades\Input;
use \Auth;
use Illuminate\Contracts\Auth\Guard;

class AdminProfileController extends Controller
{
	public function profilepic(Guard $auth)
	{

		
		$user = Auth()->user();
		dd($user);

		/*$id = Auth::id();
      	$admin_id = Tbl_Admin::find('admin_id');*/
		
		/*$data["user_info"] = ($userId);
		$data["user_info"]  = Tbl_Admin::where('admin_id','=',$userId)->first();
		return view("super_admin.index_admin",$data);*/
	}

}