<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Carbon\Carbon;
use DB;
use App\Models\Tbl_customer;
use App\Models\Tbl_country;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_mlm_lead;
use App\Globals\Mlm_member;
use App\Globals\Sms;
use App\Models\Tbl_email_template;
use App\Globals\EmailContent;
use Mail;

class MlmRegisterController extends MlmLoginController
{
    public function index()
    {
        // return $this->mail_customer_success_register(1, 310);
        $data["page"] = "register";
        $data['lead'] = Self::$lead;
        if($data['lead'] != null)
        {
        	$data['lead_code'] = Tbl_membership_code::where('tbl_membership_code.customer_id', $data['lead']->customer_id)
        	->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_membership_code.slot_id')
        	->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
        	->whereNotNull('tbl_membership_code.slot_id')
        	->get();
        	$data['customer_info'] = Mlm_member::get_customer_info($data['lead']->customer_id);
        } 
        
        $data['country'] = Tbl_country::get();
        // dd($data);
        return view("mlm.register", $data);
    }
    public function post_register()
    {
    	$i['password'] = Request::input('pass');
    	$i['password_2'] = Request::input('pass2');
    	if($i['password'] == $i['password_2'])
    	{
    		
    		$insert['shop_id'] = Self::$shop_id;
	        $insert['first_name'] = Request::input('first_name');
	        $insert['last_name'] = Request::input('last_name');
	        $insert['email'] = Request::input('email');
	        $insert['password'] = $i['password'];
	        $insert['company'] = Request::input('company');
	        $insert['created_date'] = Carbon::now();
	        $insert['IsWalkin'] = 0;
	        $insert['ismlm'] = 1;
	        $insert['mlm_username'] = Request::input('username');
	        $insert['country_id'] = Request::input('country');
	        $insert['tin_number'] = Request::input('tinnumber');

	        $insert_address['customer_state'] = Request::input('customer_state');
            $insert_address['customer_city'] = Request::input('customer_city');
            $insert_address['customer_zipcode'] = Request::input('customer_zipcode');
            $insert_address['customer_street'] = Request::input('customer_street');

	        $data['type']   = "Success";
    		$data['message'] = "Password Matched";

    		if(strlen($insert['mlm_username']) >= 6)
            {
				$count_username = Tbl_customer::where('mlm_username', $insert['mlm_username'])->count();
				if($count_username == 0)
				{
					if(strlen($insert['password']) >= 6)
	                {
	                	$check_email = Tbl_customer::where('shop_id',Self::$shop_id)->where('email',$insert['email'])->count();
	                	if($check_email == 0)
	                	{

	                		// leads
    						$lead_customer = Self::$lead;
    						$continue = 1;
    						$lead = 0;
    						$membership_code = Request::input('membership_code');
    						if($lead_customer != null)
    						{
    							if($membership_code == null)
    							{
    								$continue = 0;
    								$data['type']   = "error";
	    							$data['message'] = "Membership Code Required.";
    							}
    							else
    							{
    								$sponsor_info = Tbl_membership_code::where('membership_activation_code', $membership_code)
							        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_membership_code.slot_id')
							        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
							        ->first();  
    								if($sponsor_info != null)
    								{
    									$insert_lead['lead_join_date'] = Carbon::now();
		    							$insert_lead['lead_customer_id_sponsor'] = $sponsor_info->customer_id;
		    							$insert_lead['lead_slot_id_sponsor'] = $sponsor_info->slot_id;
		    							$insert_lead['lead_sponsor_membership_code'] = $membership_code;
		    							$lead = 1;
    								} 
    								else
    								{
    									$continue = 0;
	    								$data['type']   = "error";
		    							$data['message'] = "Member not found.";
    								}
    							}
    						}
    						else
    						{
    							if($membership_code != null)
    							{
    								$sponsor_info = Tbl_membership_code::where('membership_activation_code', $membership_code)
							        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_membership_code.slot_id')
							        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
							        ->first(); 
							        if($sponsor_info != null)
    								{
    									$insert_lead['lead_join_date'] = Carbon::now();
		    							$insert_lead['lead_customer_id_sponsor'] = $sponsor_info->customer_id;
		    							$insert_lead['lead_slot_id_sponsor'] = $sponsor_info->slot_id;
		    							$insert_lead['lead_sponsor_membership_code'] = $membership_code;
		    							$lead = 1;
    								} 
    								else
    								{
    									$continue = 0;
	    								$data['type']   = "error";
		    							$data['message'] = "Member not found.";
    								} 
    							}
    						}
    						if($continue == 1)
    						{
    							if($insert['tin_number'] != null)
    							{
    								$insert['password'] = Crypt::encrypt($i['password']);
			                		$cus_id = Tbl_customer::insertGetId($insert);

                                    $insert_other['customer_mobile'] = Request::input('customer_mobile');
                                    $insert_other['customer_id'] = $cus_id;
                                    // $insert_other['shop_id'] = Self::$shop_id;
                                    DB::table('tbl_customer_other_info')->insert($insert_other);

                                    $updatetSearch['customer_id'] = $cus_id;
                                    $updatetSearch['body'] = $insert['first_name'].' '.$insert['last_name'].' '.$insert['email'].' '.$insert['mlm_username'];
                                    $updatetSearch['created_at'] = Carbon::now();
                                    $updatetSearch['updated_at'] = Carbon::now();
                                    DB::table('tbl_customer_search')->insert($updatetSearch);

                                    $insert_address['customer_id'] = $cus_id;
                                    $insert_address['customer_state'] = Request::input('customer_state');
                                    $insert_address['customer_city'] = Request::input('customer_city');
                                    $insert_address['customer_zipcode'] = Request::input('customer_zipcode');
                                    $insert_address['customer_street'] = Request::input('customer_street');
                                    $insert_address['purpose'] = 'billing';
                                    $insert_address['country_id'] = Request::input('country');
                                    DB::table('tbl_customer_address')->insert($insert_address);

			                		Mlm_member::add_to_session(Self::$shop_id, $cus_id);
			                		if($lead == 1)
			                		{
			                			$insert_lead['lead_customer_id_lead'] = $cus_id;
			                			Tbl_mlm_lead::insert($insert_lead);
			                		}
                                    $this->mail_customer_success_register(Self::$shop_id, $cus_id);
                                    /* Sms Notification */
                                    $txt[0]["txt_to_be_replace"]    = "[name]";
                                    $txt[0]["txt_to_replace"]       = $insert['first_name'];
                                    $result  = Sms::SendSms($insert_other['customer_mobile'], "success_register", $txt, Self::$shop_id);

			                		$data['type']   = "success";
		    						$data['message'] = "Success! you will be redirected";

    							}
    							else
    							{
    								$data['type']   = "error";
		    						$data['message'] = "Tin Number Is Required";
    							}
    						}
	                	}
	                	else
	                	{
	                		$data['type']   = "error";
    						$data['message'] = "Email Already Taken";
	                	}
					}
					else
					{
						$data['type']   = "error";
    					$data['message'] = "Password length is too short";
					}
				}
				else
				{
					$data['type']   = "error";
    				$data['message'] = "Username Already Exist";
				}
			}
			else
			{
				$data['type']   = "error";
    			$data['message'] = "Username length is too short";
			}
		}
    	else
    	{
    		$data['type']   = "error";
    		$data['message'] = "Password didn't match.";
    	}

    	return json_encode($data);

	    
        // Mlm_member::add_to_session(Self::$shop_id, $user->customer_id);

        // 
        // Tbl_customer::insert($insert);
        // $data['type']   = "Error";
    	// $data['message'] = "warning";
        // echo json_encode($data);
    }
    public function mail_customer_success_register($shop_id, $customer_id)
    {
                $data["template"] = Tbl_email_template::where("shop_id",$shop_id)->first();
                // $change_content[0]['membership_name'] = null;
                // $change_content[0]['membership_code'] = null;
                $data['customer'] = Tbl_customer::where('customer_id', $customer_id)->first();
                $change_content[0]["txt_to_be_replace"] = "[name_of_registrant]";
                $change_content[0]["txt_to_replace"] = name_format_from_customer_info($data['customer']);


                $change_content[1]["txt_to_be_replace"] = "[tin_of_registrant]";
                $change_content[1]["txt_to_replace"] = $data['customer']->tin_number;

                $change_content[2]["txt_to_be_replace"] = "[user_name]";
                $change_content[2]["txt_to_replace"] = $data['customer']->mlm_username;

                // dd($change_content);
                $content_key = 'success_register';
                $data['body'] = EmailContent::email_txt_replace($content_key, $change_content);

                $data['company']['email'] = DB::table('tbl_content')->where('shop_id', $shop_id)->pluck('value');
                Mail::send('emails.full_body', $data, function ($m) use ($data) {
                    $m->from(env('MAIL_USERNAME'), $_SERVER['SERVER_NAME']);

                    $m->to($data['customer']->email, env('MAIL_USERNAME'))->subject('SUCCESS REGISTRATION');
                });

                Mail::send('emails.full_body', $data, function ($m) use ($data) {
                    $m->from(env('MAIL_USERNAME'), $_SERVER['SERVER_NAME']);

                    $m->to('lukeglennjordan2@gmail.com', env('MAIL_USERNAME'))->subject('SUCCESS REGISTRATION');
                });
    }
    public static function view_customer_info_via_mem_code($membership_activation_code)
    {
        $data['customer_info'] = Tbl_membership_code::where('membership_activation_code', $membership_activation_code)
        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=', 'tbl_membership_code.slot_id')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
        ->first();  
        if(isset($data['customer_info']->customer_id))
        {
            $data['customer_view'] = Mlm_member::get_customer_info($data['customer_info']->customer_id);
        }
        return view('mlm.pre.view_customer_v_mem', $data);
    }
    public function package()
    {
        return view("mlm.register.package");
    }
    public function payment()
    {

    }
}