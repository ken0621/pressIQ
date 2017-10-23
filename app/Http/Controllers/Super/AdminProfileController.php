<?php
namespace App\Http\Controllers\Super;
use App\Http\Controllers\Controller;
use Redirect;
use Session;
use Request;
use DB;
use Response;
use Image;
use Carbon\Carbon;
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
		$data["_user_info_update"] = Tbl_user::join('tbl_shop','tbl_user.user_shop','=','tbl_shop.shop_id')->where("user_id",$id)->select('tbl_user.user_email','tbl_user.user_level','tbl_user.user_first_name','tbl_user.user_last_name','tbl_user.user_contact_number','tbl_user.user_level','tbl_user.user_id','tbl_user.user_password','tbl_shop.shop_key')->first();
		/*dd($data);*/
		$data['password1']= Crypt::decrypt($data["_user_info_update"]->user_password);
		/*dd('password1');*/
		// $data = $password;
		return view('super_admin.admin_edit_user_accounts', $data);
	}
	public function submit_user_password($id)
	{
		$user= Tbl_user::join('tbl_shop','tbl_user.user_shop','=','tbl_shop.shop_id')->where("tbl_user.user_id", $id)->first();
		$update["user_password"] = Crypt::encrypt(Request::input("password"));
		$update["user_first_name"] = Request::input("user_first_name");
		$update["user_last_name"] = Request::input("user_last_name");
		$update["user_email"] = Request::input("user_email");
		$update["user_contact_number"] = Request::input("user_contact_number");
		$update["user_level"] = Request::input("user_level");
		$update_shop["shop_key"] = Request::input("shop_key");
		Tbl_user::where("tbl_user.user_id", $id)->update($update);
		Tbl_shop::where("shop_id", $user->user_shop)->update($update_shop);
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
            else
            {
               	$partnerResult = Tbl_user::join('tbl_shop','tbl_user.user_shop','=','tbl_shop.shop_id')->select('tbl_user.user_email','tbl_user.user_level','tbl_user.user_first_name','tbl_user.user_last_name','tbl_user.user_contact_number','tbl_user.user_level','tbl_user.user_id','tbl_shop.shop_key')->paginate(7);
            	$partnerResultView = view('super_admin/table', compact('partnerResult'))->render();
            	return Response::json($partnerResultView);   	
            }
        }
        else
        {
            $data["_shop"] = Tbl_shop::get();
            return view("super_admin.admin_client_user_accounts", $data);
        }
	}

	public function update_user_profile_pic()
	{
		/*$id = Session::get('user')->admin_id;
		$file = Input::file('avatar');
         $destinationPath = public_path(). '/uploads/Digima-17';
         $filename = $file->getClientOriginalName();

         $file->move($destinationPath, $filename);

        $update["user_pic"] = $filename;
		Tbl_Admin::where("admin_id", $id)->update($update);
		Session::put('image_src', $filename);
		Redirect::to("/admin/profile")->send();*/

		$id = Session::get('user')->admin_id;
		$target_dir = "uploads/Digima-17/";
		$filename = Carbon::parse(Carbon::now())->format('dmYhis')."_".$id.".".pathinfo($target_dir.basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
		$return_data['status'] = null;
		$return_data['message'] = null;
		$target_file = $target_dir.$filename;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_dir.basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);


		// Check if image file is a actual image or fake image
		if(isset($_POST["_token"])) 
		{
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) 
		    {
		    	$uploadOk = 1;
		    }
		    else 
		    {
		        $uploadOk = 0;
		    }
		}

			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) 
			{
				$return_data['status'] = 'error';
				$return_data['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}
		
		if ($uploadOk == 0) 
		{
			$return_data['status'] = 'error';
			$return_data['message'] = "Sorry, your file was not uploaded.";
		   
		// if everything is ok, try to upload file
		} 		
		else 
		{
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		    {
		        $update["user_pic"] = $filename;
				Tbl_Admin::where("admin_id", $id)->update($update);
				$file = $target_dir.Session::get('image_src');
				unlink($file);
				Session::put('image_src', $filename);
				$return_data['status'] = 'success';
				$return_data['message'] = $filename;
		    } 
		    else 
		    {
		    	$return_data['status'] = 'error';
				$return_data['message'] = "Sorry, there was an error uploading your file.";
		    }
		}

		return $return_data;
	}

}