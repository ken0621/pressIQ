<?php

namespace App\Http\Controllers\Member;

use Request;
use Carbon\Carbon;
use Session;


use App\Models\Tbl_user;
use App\Models\Tbl_category;
use App\Models\Tbl_product;
use App\Models\Tbl_item;
use App\Models\Tbl_product_vendor;
use App\Models\Tbl_mlm_product_points;
use App\Models\Tbl_mlm_item_points;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_item_discount;
use App\Models\Tbl_mlm_plan;

use App\Globals\Utilities;
use App\Globals\Mlm_plan;
use App\Globals\AuditTrail;
class MLM_ProductController extends Member
{
    public function index()
    {
        $access = Utilities::checkAccess('mlm-product-points', 'access_page');
        if($access == 0)
        {
            return $this->show_no_access(); 
        }

        $shop_id = $this->checkuser('user_shop');
        
        
        $data['active_plan_product_repurchase'] = Mlm_plan::get_all_active_plan_repurchase($shop_id);
	    $data['membership_active'] = Tbl_membership::getactive(0, $shop_id)->get();

	    // setup product on first try : no error on leftjoin
	    $_inventory = Tbl_item::where("shop_id",$shop_id)
        ->where('archived', 0)->orderBy('tbl_item.item_id','asc')->paginate(20);
	    $this->setup_points_initial($_inventory);
	    // end setup
	    
	    $_inventory  = Tbl_item::where("tbl_item.shop_id",$shop_id)
        ->where('tbl_item.archived', 0)
        // ->join("tbl_mlm_item_points","tbl_mlm_item_points.item_id","=","tbl_item.item_id")
        ->orderBy('tbl_item.item_id','asc')
        ->type()->category()
        ->paginate(10);

        foreach($_inventory as $key => $value)
        {
            foreach($data['membership_active'] as $key2 => $value2)
            {
                $item_points[$value2->membership_id] = Tbl_mlm_item_points::where('item_id', $value->item_id)->where('membership_id', $value2->membership_id)->first();
            }
            $_inventory[$key]->item_points = $item_points;
        }
        // dd($_inventory);
	    $data['active'] = [];
	    foreach($data['active_plan_product_repurchase'] as $key => $value)
	    {
    		$data['active'][$key]  = $value->marketing_plan_code;
            $data['active_label'][$key]  = $value->marketing_plan_label;
	    }

	    $data['item'] 		 = $this->iteminventory($_inventory, $data['active']);
	    $data['_inventory']  = $_inventory;	    
        
        return view('member.mlm_product.product', $data);
    }

    public function setup_points_initial($arr)
    {
        $shop_id = $this->user_info->shop_id;
        $membership = Tbl_membership::where('shop_id', $shop_id)->where('membership_archive', 0)->get();
        foreach($membership as $key => $value)
        {
            foreach($arr as $key2 => $value2)
            {
                $c = Tbl_mlm_item_points::where('item_id', $value2->item_id)->where('membership_id', $value->membership_id)->count();
                if($c == 0)
                {
                    $insert['item_points_stairstep'] = 0;
                    $insert['item_points_unilevel']  = 0;
                    $insert['item_points_binary']    = 0;
                    $insert['item_id']               = $value2->item_id;
                    $insert['membership_id'] = $value->membership_id;
                    Tbl_mlm_item_points::insert($insert);
                }
            }
        }
    }

    public function iteminventory($_inventory = array(), $active)
    {
		
        // dd($_inventory[0]);
		$item = array();
	    foreach($_inventory as $key => $inventory)
	    {
	        
	        foreach($active as $key2 => $value2)
	        {
	           $item[$key][$value2]       =  $inventory->$value2;
	        }
            $item[$key]['points'] = $inventory->item_points;

	        $item[$key]['item_id']   	   	   	  = $inventory->item_id;
	        $item[$key]['item_name'] 	   		  = $inventory->item_name;
	        $item[$key]['item_sales_information'] = $inventory->item_sales_information;
	        $item[$key]['item_price'] 			  = $inventory->item_price;
	        $item[$key]['item_sku'] 			  = $inventory->item_sku;
            $item[$key]['item_img']               = $inventory->item_img;
            $item[$key]['item_show_in_mlm']       = $inventory->item_show_in_mlm;
	        
	    }
	    return $item;
	}
	// Dont remove this /// used in other function
	public static function checkuser($str = '')
	{
        $user_info = Tbl_user::where("user_email", Session('user_email'))->shop()->first();
        switch ($str) 
        {
            case 'user_id':
                return $user_info->user_id;
                break;
            case 'user_shop':
                return $user_info->user_shop;
                break;
            default:
                return '';
                break;
        }
    }   
    public function add_product_points()
    {
        // return $_POST;
        $old_mlm_item_points = Tbl_mlm_item_points::where('item_id', Request::input('item_id'))->first()->toArray();        

        $shop_id 							    = $this->checkuser('user_shop');
        $data['active_plan_product_repurchase'] = Mlm_plan::get_all_active_plan_repurchase($shop_id);
        $update 								= null;
        $membership = Tbl_membership::getactive(0, $shop_id)->get();

        $points = Request::input('membership_points');
        foreach($data['active_plan_product_repurchase'] as $key => $value)
        {
	            $tablename 			 = $value->marketing_plan_code;

                foreach($membership as $key2 => $value2)
                {
                    $update[$tablename] = $points[$tablename][$value2->membership_id];
                    Tbl_mlm_item_points::where('item_id', Request::input('item_id'))
                    ->where('membership_id', $value2->membership_id)->update($update);
                }
        }

        if($update != null)
        {
            // Tbl_mlm_item_points::where('item_id', Request::input('item_id'))->update($update);

            // $new_mlm_item_points = Tbl_mlm_item_points::where('item_id', Request::input('item_id'))->first()->toArray();
            // AuditTrail::record_logs("Edited","mlm_item_points",Request::input('item_id'),serialize($old_mlm_item_points),serialize($new_mlm_item_points));
        }

        $data['response_status'] = "success_edit_points";
	    echo json_encode($data);
    }
    public function discount()
    {
        $access = Utilities::checkAccess('mlm-product-discount', 'access_page');
        if($access == 0)
        {
            return $this->show_no_access(); 
        }
    	$shop_id = $this->user_info->shop_id;
    	$data['items'] = Tbl_item::where("shop_id",$shop_id)
        ->where('tbl_item.archived', 0)
        ->orderBy('tbl_item.item_id','asc')->type()->category()->paginate(5);
    	$data['membership_active'] = Tbl_membership::getactive(0, $shop_id)->get();
    	$item_discount = [];
    	$item_percentage = [];
    	foreach($data['items'] as $key => $item)
    	{
    		foreach($data['membership_active'] as $value)
    		{
    			$item_discount[$item->item_id][$value->membership_id] = Tbl_mlm_item_discount::where('item_id', $item->item_id)->where('membership_id', $value->membership_id)->pluck('item_discount_price'); 
    			$item_percentage[$item->item_id][$value->membership_id] = Tbl_mlm_item_discount::where('item_id', $item->item_id)->where('membership_id', $value->membership_id)->pluck('item_discount_percentage'); 
    		}
    	}
    	$data['item_discount'] = $item_discount;
    	$data['item_discount_percentage'] = $item_percentage;
    	// dd($data);
    	return view('member.mlm_product.discount', $data);
    }
    public function discount_add()
    {
    	$membership_input = Request::input('membership_id');
    	$membership_price = Request::input('price');
    	$item_id = Request::input('item_id');
    	$percentage = Request::input('percentage');
    	foreach($membership_input as $key => $membership)
    	{
    		$count = Tbl_mlm_item_discount::where('item_id', $item_id)->where('membership_id', $key)->count();
    		if($count == 0)
    		{
    			$insert['item_discount_price'] = $membership_price[$key]; 
    			$insert['membership_id'] = $key;
    			$insert['item_id'] = $item_id;
    			$insert['item_discount_percentage'] = $percentage[$key];
    			$mlm_item_discount_id = Tbl_mlm_item_discount::insertGetId($insert);

                $mlm_item_discount = Tbl_mlm_item_discount::where('item_discount_d', $mlm_item_discount_id)->first()->toArray();
                AuditTrail::record_logs("Added","mlm_discount_item",$mlm_item_discount_id ,"",serialize($mlm_item_discount));
    		}
    		else
    		{
                $old_mlm_item_discount = Tbl_mlm_item_discount::where('item_id', $item_id)->where('membership_id', $key)->first()->toArray();

                $update['item_discount_price'] = $membership_price[$key]; 
    			$update['item_discount_percentage'] = $percentage[$key];
    			$count = Tbl_mlm_item_discount::where('item_id', $item_id)->where('membership_id', $key)->update($update);

                $new_mlm_item_discount = Tbl_mlm_item_discount::where('item_discount_d', $old_mlm_item_discount["item_discount_d"])->first()->toArray();
                AuditTrail::record_logs("Edited","mlm_discount_item",$new_mlm_item_discount["item_discount_d"] ,serialize($old_mlm_item_discount),serialize($new_mlm_item_discount));
    		}
    		$data['response_status'] = "success_add_slot";
    	}
    	
    	echo json_encode($data);

    }
    public function product_repurchase_points()
    {
        
    }
    public function set_all_points()
    {
        // return $_POST;
        $shop_id = $this->checkuser('user_shop');
        $plan_code_id = Request::input('marketing_plan_code_id');
        $membership_id = Request::input('membership_id');
        $percentage = Request::input('percentage');

        $plan = Tbl_mlm_plan::where('marketing_plan_code_id', $plan_code_id)->first();
        // marketing_plan_code
        $items = Tbl_item::where("shop_id",$shop_id)
        ->where('archived', 0)->orderBy('tbl_item.item_id','asc')->get();

        foreach ($items as $key => $value) 
        {  
            
            if($value->promo_price >= 1)
            {
                $now = Carbon::now();
                if($value->start_promo_date <= $now && $value->end_promo_date >= $now)
                {
                    $update[$plan->marketing_plan_code] = ($value->promo_price/100) * $percentage;
                    Tbl_mlm_item_points::where('item_id', $value->item_id)->where('membership_id', $membership_id)->update($update);
                }
                else
                {
                    $update[$plan->marketing_plan_code] = ($value->item_price/100) * $percentage;
                    Tbl_mlm_item_points::where('item_id', $value->item_id)->where('membership_id', $membership_id)->update($update);
                }
            }
            else
            {
                $update[$plan->marketing_plan_code] = ($value->item_price/100) * $percentage;
                Tbl_mlm_item_points::where('item_id', $value->item_id)->where('membership_id', $membership_id)->update($update);
            }
        }
        $data['response_status'] = 'success_edit_all_points';
        return $data;
    }
}
