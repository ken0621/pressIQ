<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use DB;
use Validator;
use App\Globals\Mlm_member;
use App\Models\Tbl_customer;
use App\Globals\Cards;
use App\Models\Tbl_mlm_slot;
use App\Globals\Pdf_global;
class MlmProfileController extends Mlm
{
    public function index()
    {
    	$data = [];
    	$data['country'] = DB::table('tbl_country')->get();
    	$data['customer_address'] = DB::table('tbl_customer_address')->where('customer_id', Self::$customer_id)->first();
    	$data['other_info'] = DB::table('tbl_customer_other_info')->where('customer_id', Self::$customer_id)->first();
    	if(Self::$slot_id != null)
    	{
    		$data['cus_info'] = Mlm_member::get_customer_info_w_slot(Self::$customer_id, Self::$slot_id);
    		$data['card'] = $this->card(Self::$slot_id);

    		if(Request::input('pdf') == 'true')
    		{
    			return Pdf_global::show_image($data['card']);
    		}
    	}
    	else
    	{
    		$data['cus_info'] = Mlm_member::get_customer_info(Self::$customer_id);
    	}
    	 

    	return view('mlm.profile.new', $data);
    }
    public function password()
    {
    	$customer_id = Self::$customer_id;
    	$password_o	= Request::input('password_o');
		$password_n	= Request::input('password_n');
		$password_n_c	= Request::input('password_n_c');
		$old_password = Crypt::decrypt(Self::$customer_info->password);

		if($password_o == $old_password)
		{
			if($password_n == $password_n_c)
			{
				$update['password'] = Crypt::encrypt($password_n);
				Tbl_customer::where('customer_id', Self::$customer_id)->update($update);
				$data['status'] = 'success';
				$data['message'] = 'Success';
				Mlm_member::add_to_session_edit(Self::$shop_id, Self::$customer_id, Self::$slot_id);
			}
			else
			{
				$data['status'] = 'warning';
				$data['message'] = 'Wrong Password Confirmation';
			}
		}
		else
		{
			$data['status'] = 'warning';
			$data['message'] = 'Wrong Password';
		}
		return json_encode($data);
    }
    public function contact()
    {
    	$customer_id = Self::$customer_id;
    	$email = Request::input('email');
		$customer_phone = Request::input('customer_phone');
		$customer_mobile = Request::input('customer_mobile');
		$customer_fax = Request::input('customer_fax');

		$validate['email'] = $email;
		$validate['customer_phone'] = $customer_phone;
		$validate['customer_mobile'] = $customer_mobile;
		$validate['customer_fax'] = $customer_fax;

		$rules['email'] = 'required|email';
		$rules['customer_phone'] = 'required';
		$rules['customer_mobile'] = 'required';
		$rules['customer_fax'] = 'required';
	    $validator = Validator::make($validate,$rules);
	    if ($validator->passes())
	    {
	    	$count_other = DB::table('tbl_customer_other_info')->where('customer_id', $customer_id)->count();
	    	if($count_other >= 1)
	    	{
	    		$update['customer_phone'] = $customer_phone;
				$update['customer_mobile'] = $customer_mobile;
				$update['customer_fax'] = $customer_fax;
	    		DB::table('tbl_customer_other_info')->where('customer_id', $customer_id)->update($update);
	    	}
	    	else
	    	{
	    		$update['customer_id'] = $customer_id;
	    		$update['customer_phone'] = $customer_phone;
				$update['customer_mobile'] = $customer_mobile;
				$update['customer_fax'] = $customer_fax;
	    		DB::table('tbl_customer_other_info')->insert($update);
	    	}
	    	

	    	$update_2['email'] = $email;
	    	DB::table('tbl_customer')->where('customer_id', $customer_id)->update($update_2);

	    	$data['status'] = 'success';
			$data['message'] = 'Success';
			Mlm_member::add_to_session_edit(Self::$shop_id, Self::$customer_id, Self::$slot_id);
	    }
	    else
	    {
	    	$data['response_status'] = "warning_2";
    	    $data['warning_validator'] = $validator->messages();
	    }
	    return json_encode($data);
    }
    public function basic()
    {
    	
    	$customer_id = Self::$customer_id;
    	// tbl_customer
    	$b_day = Request::input('b_day');
		$country_id = Request::input('country_id');
    	// tbl_customer_address
    	$customer_state = Request::input('customer_state');
		$customer_city = Request::input('customer_city');
		$customer_zipcode = Request::input('customer_zipcode');
		$customer_street = Request::input('customer_street');

		$validate['b_day'] = Request::input('b_day');
		$validate['country_id'] = Request::input('country_id');
		$validate['customer_state'] = Request::input('customer_state');
		$validate['customer_city'] = Request::input('customer_city');
		$validate['customer_zipcode'] = Request::input('customer_zipcode');
		$validate['customer_street'] = Request::input('customer_street');

		$rules['b_day'] = 'required';
		$rules['country_id'] = 'required';
		$rules['customer_state'] = 'required';
		$rules['customer_city'] = 'required';
		$rules['customer_zipcode'] = 'required';
		$rules['customer_street'] = 'required';
		$validator = Validator::make($validate,$rules);
		if ($validator->passes())
	    {
	    	$count_address = DB::table('tbl_customer_address')->where('customer_id', $customer_id)->count();
	    	if($count_address >= 1)
	    	{
	    		$update['country_id'] = $country_id;
	    		$update['customer_state'] = $customer_state;
				$update['customer_city'] = $customer_city;
				$update['customer_zipcode'] = $customer_zipcode;
				$update['customer_street'] = $customer_street;
				DB::table('tbl_customer_address')->where('customer_id', $customer_id)->update($update);
	    	}
	    	else
	    	{
	    		$update['country_id'] = $country_id;
	    		$update['customer_id'] = $customer_id;
	    		$update['customer_state'] = $customer_state;
				$update['customer_city'] = $customer_city;
				$update['customer_zipcode'] = $customer_zipcode;
				$update['customer_street'] = $customer_street;
				DB::table('tbl_customer_address')->insert($update);
	    	}
	    	

			$update_2['b_day'] = $b_day;
			$update_2['country_id'] = $country_id;
			DB::table('tbl_customer')->where('customer_id', $customer_id)->update($update_2);

			$data['status'] = 'success';
			$data['message'] = 'Success';
			Mlm_member::add_to_session_edit(Self::$shop_id, Self::$customer_id, Self::$slot_id);
	    }
	    else
	    {
	    	$data['response_status'] = "warning_2";
    	    $data['warning_validator'] = $validator->messages();
	    }
	    return json_encode($data);
    }
    public function card($slot_id)
    {
    	$slot = Tbl_mlm_slot::where('slot_id', $slot_id)->membership()->customer()
    	->leftjoin('tbl_customer_other_info', 'tbl_customer_other_info.customer_id', '=', 'tbl_mlm_slot.slot_owner')
        ->leftjoin('tbl_customer_address', 'tbl_customer_address.customer_id', '=', 'tbl_mlm_slot.slot_owner')
    	->first();
    	if(Self::$shop_id == 1)
    	{
    		
    		$a = Cards::show_card($slot);
    		return $a;
    		return Pdf_global::show_image($a);
    	}
    }
}