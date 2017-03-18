<?php
namespace App\Globals;
use App\Models\Tbl_variant;
use App\Models\Tbl_customer;
use App\Models\Tbl_customer_search;
use App\Models\Tbl_order;
use App\Models\Tbl_order_item;
use App\Models\Tbl_customer_address;
use App\Models\Tbl_user;
use App\Models\Tbl_customer_other_info;
use DB;
use Carbon\Carbon;
use Request;
class Customer
{

	public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }
    
	public static function info($id = 0, $shop_id = 0, $order_id = 0)
	{
        $data['customer'] = Tbl_customer::join('tbl_country','tbl_country.country_id','=','tbl_customer.country_id')->where('tbl_customer.customer_id',$id)->first();
        $data['shipping'] = Tbl_customer_address::join('tbl_country','tbl_country.country_id','=','tbl_customer_address.country_id')->where('tbl_customer_address.customer_id',$id)->where('tbl_customer_address.purpose','shipping')->where('tbl_customer_address.archived',0)->first();
        $data['other'] = Tbl_customer_other_info::where('customer_id',$id)->first();
        // $tax_exempt = $data['customer']->taxt_exempt;
        $tax_exempt = 0;
        $count = Tbl_order::where('shop_id', $shop_id)->where('status','new')->count();
        $order['customer_id'] = $id;
        $order['isTaxExempt'] = $tax_exempt;
        $data['order_id'] = $order_id;
        dd();
        return $data;
	}
	
	public static function search($str = '', $shop_id = 0, $archived = 0){
		if($str != '' && $str != null){
    		$data['_customer'] = Tbl_customer_search::join('tbl_customer','tbl_customer.customer_id','=','tbl_customer_search.customer_id')
    						->join('tbl_customer_other_info','tbl_customer_other_info.customer_id','=','tbl_customer.customer_id')
    						->whereRaw("MATCH(tbl_customer_search.body) AGAINST('*".$str."*' IN BOOLEAN MODE)")
    						->where('tbl_customer.archived',$archived)
    						->where('tbl_customer.IsWalkin',0)
    						->where('tbl_customer.shop_id',$shop_id)
    						->select(DB::raw('tbl_customer.*'))
    						->orderBy('tbl_customer.first_name','asc')
    						->get();
    	}
    	else{
    		$data['_customer'] = Tbl_customer::where('archived',0)->where('shop_id',$shop_id)->where('tbl_customer.IsWalkin',0)->orderBy('first_name','asc')->get();
    	}
    	// dd($shop_id);
    	return $data;
	}

	public static function getAllCustomer()
	{
		$customer = Tbl_customer::info()->where("tbl_customer.archived", 0)->where("shop_id", Customer::getShopId())->groupBy("tbl_customer.customer_id")->orderBy("tbl_customer.customer_id","DESC")->get();
		return $customer;
	}
	public static function countAllCustomer()
	{
		$count = Tbl_customer::where("tbl_customer.archived", 0)->where("shop_id", Customer::getShopId())->count();
		return $count;
	}

	public static function createCustomer($shop_id, $customer_info)
	{
		$insert["shop_id"] 		= $shop_id;
		$insert["title_name"] 	= isset($customer_info['customer_title_name']) 
								       ? $customer_info['customer_title_name'] : '';
		$insert["first_name"] 	= isset($customer_info['customer_first_name'])
								      ? $customer_info['customer_first_name'] : '';
		$insert["middle_name"]  = isset($customer_info['customer_middle_name'])
								      ? $customer_info['customer_middle_name'] : '';
		$insert["last_name"]    = isset($customer_info['customer_last_name'])
									  ? $customer_info['customer_last_name'] : '';
		$insert["suffix_name"]  = isset($customer_info['customer_suffix_name'])
									  ? $customer_info['customer_suffix_name'] : '';
		$insert["email"]        = isset($customer_info['customer_email'])
									  ? $customer_info['customer_email'] : '';
		$insert["password"]     = isset($customer_info['customer_password'])
									  ? $customer_info['customer_password'] : '';
		$insert["company"]      = isset($customer_info['customer_company'])
									  ? $customer_info['customer_company'] : '';
		$insert["b_day"]        = isset($customer_info['customer_birthdate'])
									  ? datepicker_input($customer_info['customer_birthdate']) : '';
		$insert["IsWalkin"]     = isset($customer_info['customer_iswalkin'])
									  ? $customer_info['customer_iswalkin'] : 0;
		$insert["created_date"] = Carbon::now();

		$customer_id = Tbl_customer::insertGetId($insert);

		$insertAddress[0]['customer_id'] 		= $customer_id;
		$insertAddress[0]['country_id'] 		= isset($customer_info['customer_country_id'])
									  				  ? $customer_info['customer_country_id'] : 420;
		$insertAddress[0]['customer_state'] 	= isset($customer_info['customer_state'])
									  				  ? $customer_info['customer_state'] : '';
		$insertAddress[0]['customer_city'] 		= isset($customer_info['customer_city'])
									  				  ? $customer_info['customer_city'] : '';
		$insertAddress[0]['customer_zipcode'] 	= isset($customer_info['customer_zipcode'])
									  				  ? $customer_info['customer_zipcode'] : '';
		$insertAddress[0]['customer_street'] 	= isset($customer_info['customer_street'])
									  				  ? $customer_info['customer_street'] : '';
		$insertAddress[0]['purpose'] 			= 'billing';

		$insertAddress[1]['customer_id'] 		= $customer_id;
		$insertAddress[1]['country_id'] 		=isset($customer_info['customer_country_id_ship'])
									  				  ? $customer_info['customer_country_id_ship'] : 420;
		$insertAddress[1]['customer_state'] 	= isset($customer_info['customer_state_ship'])
									  				  ? $customer_info['customer_state_ship'] : '';
		$insertAddress[1]['customer_city'] 		= isset($customer_info['customer_city_ship'])
									  				  ? $customer_info['customer_city_ship'] : '';
		$insertAddress[1]['customer_zipcode'] 	= isset($customer_info['customer_zipcode_ship'])
									  				  ? $customer_info['customer_zipcode_ship'] : '';
		$insertAddress[1]['customer_street'] 	= isset($customer_info['customer_street_ship'])
									  				  ? $customer_info['customer_street_ship'] : '';
		$insertAddress[1]['purpose'] 			= 'shipping';

		Tbl_customer_address::insert($insertAddress);

		$insertOtherInfo['customer_id'] 	= $customer_id;
		$insertOtherInfo['customer_phone'] 	= isset($customer_info['customer_phone'])
									  			  ? $customer_info['customer_phone'] : '';
		$insertOtherInfo['customer_mobile'] = isset($customer_info['customer_mobile'])
									  			  ? $customer_info['customer_mobile'] : '';
		$insertOtherInfo['customer_notes'] 	= isset($customer_info['customer_notes'])
									  			  ? $customer_info['customer_notes'] : '';

		Tbl_customer_other_info::insert($insertOtherInfo);

		return $customer_id;
	}

}