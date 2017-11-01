<?php
namespace App\Http\Controllers\Super;
use App\Models\Tbl_admin;
use Crypt;
use Illuminate\Validation\Rule;
use Validator;


class SuperAdminController extends Super
{
    public $admin_info;

    public function getIndex()
    {
    	$data["page"] = "Admin List";
    	$data["_admin"] = Tbl_admin::where("admin_id", "<>", 1)->get();
    	return view("super.admin", $data);
    }
    public function getAdd()
    {
    	$data["page"] 			= "Admin Add";
    	return view("super.admin_add", $data);
    }
    public function getEdit()
    {
    	$data["admin_id"]		= $admin_id = request("admin_id");
    	$data["page"] 			= "Admin Edit (" . $admin_id . ")";
    	$data["admin"] 			= $admin = Tbl_admin::where("admin_id", $admin_id)->first();
    	$data["admin_password"] = Crypt::decrypt($admin->password);
    	return view("super.admin_edit", $data);
    }
    public function postEdit()
    {
        $condition["first_name"]        = array("required");
        $condition["last_name"]         = array("required");
        $condition["username"]        	= array("required", Rule::unique('tbl_admin')->ignore('', 'username'));
        $condition["password"]        	= array("min:5");

        if ($validator->fails())
        {
            $errors                     = $validator->errors();
            $return["status"]           = "error";
            $return["title"]            = "Validation Error";
            $return["message"]          = $errors->first();
        }
        else
        {
        	$update["first_name"] 		= request("first_name");
        	$update["last_name"] 		= request("last_name");
        	$update["username"]			= request("username");
        	Tbl_admin::insert($update);
        }

    }
}