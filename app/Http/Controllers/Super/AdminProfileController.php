<?php
namespace App\Http\Controllers\Super;
use App\Http\Controllers\Controller;
use Request;
use Redirect;
use Session;
use DB;
use Response;
use Intervention\Image\Image as Image;
use Illuminate\Support\Facades\Input;
use App\Models\Tbl_Admin;
use App\Models\Tbl_shop;
use App\Models\Tbl_user;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Crypt;

class AdminProfileController extends Controller
{ 	

	public function get_user_accounts()
	{

		// $data["_user_account"] = Tbl_user::join('tbl_shop','tbl_user.user_shop','=','tbl_shop.shop_id')->select('tbl_user.user_email','tbl_user.user_level','tbl_user.user_first_name','tbl_user.user_last_name','tbl_user.user_contact_number','tbl_user.user_level','tbl_shop.shop_key')->get();
		$data["_user_account"]= Tbl_user::join('tbl_shop','tbl_user.user_shop','=','tbl_shop.shop_id')->select('tbl_user.user_email','tbl_user.user_level','tbl_user.user_first_name','tbl_user.user_last_name','tbl_user.user_contact_number','tbl_user.user_level','tbl_user.user_id','tbl_shop.shop_key')->paginate(7);
		$data["_shop"] = Tbl_shop::get();
		/*$data['shop'] = Tbl_shop::where('shop_id',Request::input('shop_id'));*/
		// dd($data);
		return view("super_admin.admin_client_user_accounts",$data);
		
	}

	/*public function web_cam_pic()
	{
		$file = file('user_pic');
		$filename =  time() . '.jpg';
		$filepath = '/uploads/Digima-17';
 
		$data['_pic_camera']= move_uploaded_file($_FILES['webcam'],$filename);
 
		return view("super_admin.admin_layout",$data);
	}
*/
	public function edit_user_password($id)
	{
		$data["_user_password_update"] = Tbl_user::where("user_id", $id)->first();
		// dd($data);
		$data['password1']= Crypt::decrypt($data["_user_password_update"]->user_password);
		// dd($password);
		// $data = $password;
		return view('super_admin.admin_edit_user_accounts', $data);
	}
	public function submit_user_password($id)
	{
		$update["user_password"] = Crypt::encrypt(Request::input("password"));
		Tbl_user::where("user_id", $id)->update($update);
		Redirect::to("/admin/shop_user_accounts")->send();
	}

	public function getview11()
	{

/*
		$data["_user_account"]= Tbl_user::join('tbl_shop','tbl_user.user_shop','=','tbl_shop.shop_id')->select('tbl_user.user_email','tbl_user.user_level','tbl_user.user_first_name','tbl_user.user_last_name','tbl_user.user_contact_number','tbl_user.user_level','tbl_user.user_id','tbl_shop.shop_key')->paginate(7);
		$data['_shop'] = Tbl_shop::where('shop_id',Request::input('shop_id'));
		return view("super_admin.admin_client_user_accounts", $data);*/

		/*$data['shop'] = Tbl_shop::where('shop_id',Request::input('shop_id'));
		return view("super_admin.admin_client_user_accounts", $data);*/
       if(Request::isMethod("GET"))
        {
		
            if(Request::input("shop_id") != 0)
            {
            	$partnerResult = Tbl_user::join('tbl_shop','tbl_user.user_shop','=','tbl_shop.shop_id')->select('tbl_user.user_email','tbl_user.user_level','tbl_user.user_first_name','tbl_user.user_last_name','tbl_user.user_contact_number','tbl_user.user_level','tbl_user.user_id','tbl_shop.shop_key')->where('shop_id',Request::input('shop_id'))->paginate(7);
            	$partnerResultView = view('super_admin/table', compact('partnerResult'))->render();
            	return Response::json($partnerResultView);   
              	/*$data["_shop"] = Tbl_shop::where('shop_id',Request::input('shop_id'))->first();	
			   return Response::json($data); */
            }
        }
        else
        {
            $data["_shop"] = Tbl_shop::get();
            return view("super_admin.admin_client_user_accounts", $data);
        }
	}

}