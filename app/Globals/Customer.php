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

	// public static function createCustomer

}