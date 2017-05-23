<?php
namespace App\Globals;

use App\Models\Tbl_membership_package;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_plan;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_mlm_plan_setting;
use App\Models\Tbl_tree_placement;
use App\Models\Tbl_tree_sponsor;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_mlm_slot_points_log;
use App\Models\Tbl_shop;
use App\Models\Tbl_customer;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_mlm_binary_setttings;
use App\Models\Tbl_membership_code;
use App\Models\Tbl_customer_search;
use App\Models\Tbl_customer_other_info;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_mlm_lead;
use App\Models\Tbl_country;

use App\Http\Controllers\Member\MLM_MembershipController;
use App\Http\Controllers\Member\MLM_ProductController;

use Schema;
use Session;
use DB;
use Carbon\Carbon;
use Request;
use Validator;
use Crypt;

use App\Globals\Mlm_compute;
use App\Globals\Mlm_slot_log;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_member;
class Mlm_member
{   
	public static function add_to_session($shop_id, $customer_id)
	{
		$data['shop_info'] = Tbl_shop::where('shop_id', $shop_id)->first();
		$data['customer_info'] = Tbl_customer::where('customer_id', $customer_id)->first();
		$data['slot_now'] = Tbl_mlm_slot::where('tbl_mlm_slot.slot_owner', $customer_id)->membershipcode()
		->membership()->first();
		// $data['discount_card'] = Tbl_mlm_discount_card_log::where('discount_card_customer_holder', $customer_id)->first();

		Session::put('mlm_member', $data);
	}
	public static function add_to_session_edit($shop_id, $customer_id, $slot_id)
	{
		$data['shop_info'] = Tbl_shop::where('shop_id', $shop_id)->first();
		$data['customer_info'] = Tbl_customer::where('customer_id', $customer_id)->first();
		$data['slot_now'] = Tbl_mlm_slot::where('slot_owner', $customer_id)
		->where('tbl_mlm_slot.slot_id', $slot_id)
		// ->membershipcode()
		->membership()
		->first();
		$data['discount_card'] = Tbl_mlm_discount_card_log::where('discount_card_customer_holder', $customer_id)->first();
		
		Session::put('mlm_member', $data);
	}
	public static function get_customer_info($customer_id, $discount_card_log_id = null)
	{
		$data = [];
		$data['customer_data'] = Tbl_customer::where('customer_id', $customer_id)->first();
        if($discount_card_log_id == null)
        {
            $data['discount_card'] = Tbl_mlm_discount_card_log::where('discount_card_customer_holder', $customer_id)->first();
        }
        else
        {
            $data['discount_card'] = Tbl_mlm_discount_card_log::where('discount_card_log_id', $discount_card_log_id)->first();
        }
		// dd($data);
        if(isset($data['discount_card']->discount_card_log_is_expired))
        {
            if($data['discount_card']->discount_card_log_date_expired != null)
            {
                $now = Carbon::now();
                if($now >= $data['discount_card']->discount_card_log_date_expired)
                {
                    $update['discount_card_log_is_expired'] = 1;
                    Tbl_mlm_discount_card_log::where('discount_card_log_id', $data['discount_card']->discount_card_log_id)->update($update);
                    $data['discount_card'] = Tbl_mlm_discount_card_log::where('discount_card_customer_holder', $customer_id)->first();
                }
            }
            
        }
        return view('mlm.pre.view_customer', $data);
        // \assets\mlm\barcode
	}
	public static function get_customer_info_w_slot($customer_id, $slot_id)
	{
		$data = [];
		$data['customer_data'] = Tbl_customer::where('customer_id', $customer_id)->first();
		$data['slot'] = Tbl_mlm_slot::where('tbl_mlm_slot.slot_id', $slot_id)
		->leftjoin('tbl_membership_code', 'tbl_membership_code.slot_id', '=', 'tbl_mlm_slot.slot_id')
		->first();
        if($data['slot']->slot_id == null)
        {
            $data['slot'] = Tbl_mlm_slot::where('tbl_mlm_slot.slot_id', $slot_id)
            ->first();
        }
        $data['slot_info'] = Tbl_mlm_slot::where('tbl_mlm_slot.slot_id', $slot_id)->first();
        // dd($data);
        return view('mlm.pre.view_customer', $data);
	}
	public static function breakdown_wallet($slot_id)
	{
		$data['slot'] = Tbl_mlm_slot::where('slot_id', $slot_id)->customer()->first();
        
        $data['wallet_log'] = Tbl_mlm_slot_wallet_log::where('tbl_mlm_slot_wallet_log.shop_id', $data['slot']->shop_id)
        ->orderBy('wallet_log_date_created', 'ASC')
        ->where('wallet_log_slot', $slot_id)
        ->where('wallet_log_amount', '!=', 0)
        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=','tbl_mlm_slot_wallet_log.wallet_log_slot')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=','tbl_mlm_slot.slot_owner')
        ->get();

        $data['sort_by_date'] = [];
        foreach($data['wallet_log'] as $key => $value)
        {
            $date = Carbon::parse($value->wallet_log_date_created)->format('Y-m-d');
            if(isset($data['sort_by_date'][$date][$value->wallet_log_plan]->wallet_log_amount))
            {
                $data['sort_by_date'][$date][$value->wallet_log_plan]->wallet_log_amount += $value->wallet_log_amount;
            }
            else
            {
                $data['sort_by_date'][$date][$value->wallet_log_plan] = $value;
            }
            
        }
        $data['customer_view'] = Mlm_member::get_customer_info_w_slot($data['slot']->customer_id, $slot_id);
        // dd($data['sort_by_date']);
        return view('member.mlm_wallet.breakdown', $data);
	}
	public static function add_slot($shop_id, $customer_id)
	{
        $disabled_validation_code = Request::input('disabled_validation_code');
		$validate['slot_owner'] = $customer_id;
        $validate['membership_code_id'] = Request::input('membership_code_id');
        $validate['membership_activation_code'] = Request::input('membership_activation_code');
        $validate['slot_sponsor'] = Request::input('slot_sponsor');
        
        
        $rules['slot_owner'] = "required";
        if($disabled_validation_code != 1)
        {
            $rules['membership_activation_code'] = "required";
        }
        $rules['membership_code_id'] = "required";
        $rules['slot_sponsor'] = "required";
        
        $binary_settings = Tbl_mlm_plan::where('shop_id', $shop_id)
            ->where('marketing_plan_code', 'BINARY')
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Slot Creation')
            ->first();

        $binary_advance = Tbl_mlm_binary_setttings::where('shop_id', $shop_id)->first(); 

        $count_tree_if_exist = 0;

        if(isset($binary_settings->marketing_plan_enable))
        {
           if($binary_settings->marketing_plan_enable == 1)
           {
                if(isset($binary_advance->binary_settings_placement))
                {
                    if($binary_advance->binary_settings_placement == 0)
                    {
                        $validate['slot_placement'] = Request::input('slot_placement');
                        $validate['slot_position'] = Request::input('slot_position');
                        $rules['slot_placement'] = "required";
                        $rules['slot_position'] = "required";


                        $insert['slot_placement'] = $validate['slot_placement'];
                        $insert['slot_position'] = $validate['slot_position'];

                        $count_tree_if_exist = Tbl_tree_placement::where('placement_tree_position', $validate['slot_position'])
                        ->where('placement_tree_parent_id', $validate['slot_placement'])
                        ->where('shop_id', $shop_id)
                        ->count();
                    } 
                }
           }      
        }

        $validator = Validator::make($validate,$rules);
        if ($validator->passes())
    	{
    	    
            if($disabled_validation_code == 1)
            {
                $membership = Tbl_membership_code::where('membership_code_id', $validate['membership_code_id'])
                // ->where('membership_activation_code', $validate['membership_activation_code'])
                ->package()->membership()->first();
            }
            else
            {
                $membership = Tbl_membership_code::where('membership_code_id', $validate['membership_code_id'])
                ->where('membership_activation_code', $validate['membership_activation_code'])
                ->package()->membership()->first();
            }
            
    	    
    	   // tbl_tree_placement
    	    if($membership)
            {
                if($membership->used == 0)
                {
                    if($count_tree_if_exist == 0 )
                    {
                        $insert['slot_no'] = Mlm_plan::set_slot_no($shop_id, $validate['membership_code_id']);
                        $insert['shop_id'] = $shop_id;
                        $insert['slot_owner'] = $validate['slot_owner'];
                        $insert['slot_created_date'] = Carbon::now();
                        $insert['slot_membership'] = $membership->membership_id;
                        $insert['slot_status'] = $membership->membership_type;
                        $insert['slot_sponsor'] = $validate['slot_sponsor'];
                        
                        $id = Tbl_mlm_slot::insertGetId($insert);
                        $slot_info = Tbl_mlm_slot::where('slot_id', $id)->membership()->membership_points()->customer()->first();
                        // compute mlm
                            $a = Mlm_compute::entry($id);
                        // end
                        // Mlm_member::add_to_session_edit($shop_id,  $validate['slot_owner'], $id);
                        $update['used'] = 1;
                        $update['date_used'] = Carbon::now();
                        $update['slot_id'] = $id;
                        Tbl_membership_code::where('membership_code_id', $validate['membership_code_id'])->update($update);

                        $insert['slot_id'] = $id;
                        $data['slot_data'] = $insert;
                        $data['response_status'] = "success_add_slot";

                        if(isset($_POST['lead_id']))
			            {
			                $update_lead['lead_used_date']		= Carbon::now();
			                $update_lead['lead_used']			= 1;
			                $update_lead['lead_slot_id_lead'] 	= $id;
			                DB::table('tbl_mlm_lead')->where('lead_id', $_POST['lead_id'])->update($update_lead);
			            }
                        $c = Mlm_gc::slot_gc($id);
                        $disable_session = Request::input('disable_session');

                        if($disable_session != 'true_a')
                        {
                            // dd($disable_session);
                            Mlm_member::add_to_session_edit($shop_id, $customer_id, $id);
                        }
                    }
                    else
                    {
                        $data['response_status'] = "warning_2";
                        $data['error'] = "Slot Placement Already Taken";
                    }
                }
                else
                {
                    $data['response_status'] = "warning_2";
                    $data['error'] = "Membership Code Already Used";
                }
            }
            else
            {
                $data['response_status'] = "warning_2";
                $data['error'] = "Invalid Membership code";
            }
    	    
    	    
    	}
    	else
    	{
    		$data['response_status'] = "warning";
    	    $data['warning_validator'] = $validator->messages();
    	}
    	return json_encode($data);
	}

    public static function register_slot_membership_code($shop_id, $register_session, $register_session_2, $ship, $code, $code_info)
    {
        // dd($code_info);
        $customer_id = Mlm_member::register_slot_insert_customer($shop_id, $register_session);
        $slot_id = Mlm_member::register_slot_insert($shop_id, $customer_id, $register_session, $code, $code_info);
        $update['used'] = 1;
        $update['date_used'] = Carbon::now();
        $update['slot_id'] = $slot_id;
        Tbl_membership_code::where('membership_code_id', $code['membership_pin'])->update($update);
        $c = Mlm_gc::slot_gc($slot_id);

        Mlm_member::add_to_session_edit($shop_id, $customer_id, $slot_id);
    }
    public static function register_slot_insert_customer($shop_id, $info)
    {
        $insert['shop_id'] = $shop_id;
        $insert['country_id'] = $info['country'];
        $insert['title_name'] = '';
        $insert['first_name'] =  $info['first_name'];
        $insert['middle_name'] = '';
        $insert['last_name'] = $info['last_name'];
        $insert['suffix_name'] = '';
        $insert['email'] =  $info['email'];
        $insert['ismlm'] = 1;
        $insert['mlm_username'] = $info['username'];
        $insert['password'] = Crypt::encrypt($info['password']);
        $insert['tin_number'] = '';
        $insert['company'] = $info['company'];
        $customer_id = Tbl_customer::insertGetId($insert);

        $insertSearch['customer_id'] = $customer_id;
        $insertSearch['body'] = $insert['title_name'].' '.$insert['first_name'].' '.$insert['middle_name'].' '.$insert['last_name'].' '.$insert['suffix_name'].' '.$insert['email'].' '.$insert['company'];
        Tbl_customer_search::insert($insertSearch);

        $insertInfo['customer_phone'] = $info['customer_phone'];
        $insertInfo['customer_mobile'] = $info['customer_mobile'];
        $insertInfo['customer_id'] = $customer_id;
        Tbl_customer_other_info::insert($insertInfo);

        $insertAddress[0]['customer_id'] = $customer_id;
        $insertAddress[0]['country_id'] = $info['country'];
        $insertAddress[0]['purpose'] = 'billing';
        $insertAddress[1]['customer_id'] = $customer_id;
        $insertAddress[1]['country_id'] = $info['country'];
        $insertAddress[1]['purpose'] = 'shipping';
        Tbl_customer_address::insert($insertAddress);

        return $customer_id;
    }
    public static function register_slot_insert($shop_id, $customer_id, $register_session, $code, $code_info)
    {
        $slot_sponsor = Tbl_mlm_slot::where('slot_nick_name', $register_session['sponsor'])->first();
        $insert['slot_no'] = Mlm_plan::set_slot_no($shop_id, $code['membership_pin']);
        $insert['shop_id'] = $shop_id;
        $insert['slot_owner'] = $customer_id;
        $insert['slot_created_date'] = Carbon::now();
        $insert['slot_membership'] = $code_info->membership_id;
        $insert['slot_status'] = $code_info->membership_type;
        $insert['slot_sponsor'] = $slot_sponsor->slot_id;
        
        $id = Tbl_mlm_slot::insertGetId($insert);
        $a = Mlm_compute::entry($id);

        return $id;
    }

    public static function add_slot_form($customer_id)
    {
        $customer = Tbl_customer::where('customer_id', $customer_id)->first();

        $shop_id = $customer->shop_id;
        $customer_id =$customer->customer_id;

        $data = [];
        $data['binary_settings'] = Tbl_mlm_plan::where('shop_id', $shop_id)
            ->where('marketing_plan_code', 'BINARY')
            ->where('marketing_plan_enable', 1)
            ->where('marketing_plan_trigger', 'Slot Creation')
            ->first();
        $data['binary_advance'] = Tbl_mlm_binary_setttings::where('shop_id', $shop_id)->first();
        $data['codes'] = Mlm_member::get_codes($customer_id);
        $data['lead'] = Tbl_mlm_lead::where('lead_customer_id_lead', $customer_id)
        ->join('tbl_mlm_slot', 'tbl_mlm_slot.slot_id', '=','tbl_mlm_lead.lead_slot_id_sponsor')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_mlm_slot.slot_owner')
        ->join('tbl_membership_code', 'tbl_membership_code.slot_id', '=', 'tbl_membership_code.slot_id')
        ->where('tbl_mlm_lead.lead_used', 0)
        ->first();

        $data['_slots']    = Tbl_mlm_slot::where('tbl_mlm_slot.shop_id', $shop_id)->customer()->get();
        $data['country']   = Tbl_country::get();
        $data['position']  = Request::input('position');
        $data['placement'] = Request::input('placement');
        $data['sponsor_a'] = Request::input('slot_sponsor');
        return view('mlm.slot_add.index', $data);
    }
    public static function get_codes($customer_id)
    {
        $data["membership_code"]    =   Tbl_membership_code::where('customer_id', $customer_id)
        ->leftjoin('tbl_membership_package', 'tbl_membership_package.membership_package_id', '=','tbl_membership_code.membership_package_id')
        ->leftjoin('tbl_membership', 'tbl_membership.membership_id', '=','tbl_membership_package.membership_id')
        ->where('used', 0)->where('blocked', 0)->get();
        // dd($data);
        return view('member.mlm_slot.mlm_slot_get_code', $data);
    }
}