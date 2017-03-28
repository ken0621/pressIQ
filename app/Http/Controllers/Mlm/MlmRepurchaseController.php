<?php
namespace App\Http\Controllers\Mlm;
use App\Http\Controllers\Controller;
use Crypt;
use Redirect;
use Request;
use View;
use Session;
use App\Globals\Item;
use App\Globals\Warehouse;
use App\Globals\Mlm_plan;
use App\Globals\Mlm_repurchase;

use App\Models\Tbl_warehouse;
use App\Models\Tbl_membership;
use App\Models\Tbl_mlm_item_discount;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_item;
use App\Models\Tbl_mlm_slot_wallet_log;
use App\Models\Tbl_item_code;
class MlmRepurchaseController extends Mlm
{
    public function index()
    {
    	// return Session::forget("mlm_repurchase"); 
    	$data = [];
    	$filter = ['tbl_item.archived' => 0, 'tbl_item.item_show_in_mlm' => 1];
    	$data['items'] = Item::get_all_item_per_shop(Self::$shop_id, $filter);
    	$warehouse_id = Tbl_warehouse::where('warehouse_shop_id', Self::$shop_id)
    	->where('main_warehouse', 1)
    	->first();

    	$data['item_w'] = [];
    	if(isset($warehouse_id->warehouse_id))
    	{
    		$warehouse = Warehouse::select_item_warehouse_single($warehouse_id->warehouse_id,'array');
    		foreach($warehouse as $key => $value)
    		{
    			$data['item_w'][$value->product_id] = $value;
    		}
    	}
    	else
    	{
    		$warehouse = [];
    	}

    	$item_discount = [];
		$item_percentage = [];
    	if(Self::$slot_now != null)
    	{
    		$membership_id= Self::$slot_now->slot_membership;
    		$membership_active = Tbl_membership::where('membership_id', $membership_id)
    		->first();
    		if(isset($membership_active->membership_id))
    		{
    			
    			foreach($data['items'] as $key => $item)
		    	{

		    		$item_discount[$item->item_id] = Tbl_mlm_item_discount::where('item_id', $item->item_id)->where('membership_id', $membership_active->membership_id)->pluck('item_discount_price'); 
		    		$item_percentage[$item->item_id] = Tbl_mlm_item_discount::where('item_id', $item->item_id)->where('membership_id', $membership_active->membership_id)->pluck('item_discount_percentage'); 
		    	}
    		}
	    	
    	}
    	else
    	{
    		$discount_card_log = Self::$discount_card_log;
    		if($discount_card_log != null)
    		{
    			foreach($data['items'] as $key => $item)
		    	{

		    		$item_discount[$item->item_id] = Tbl_mlm_item_discount::where('item_id', $item->item_id)->where('membership_id', $discount_card_log->discount_card_membership)->pluck('item_discount_price'); 
		    		$item_percentage[$item->item_id] = Tbl_mlm_item_discount::where('item_id', $item->item_id)->where('membership_id', $discount_card_log->discount_card_membership)->pluck('item_discount_percentage'); 
		    	}
    		}
    	}
    	$data['active_plan_product_repurchase'] = Mlm_plan::get_all_active_plan_repurchase(Self::$shop_id);
    	foreach($data['active_plan_product_repurchase'] as $key => $value)
	    {
    		$data['active'][$key]  = $value->marketing_plan_code;
            $data['active_label'][$key]  = $value->marketing_plan_label;
	    }
    	$data['item_discount'] = $item_discount;
    	$data['item_discount_percentage'] = $item_percentage;
        $data['slot_id'] = Self::$slot_id;
        // dd($data);
        $data['cart'] = Self::get_cart_repurchase(); 
    	return view('mlm.repurchase.repurchase', $data);
    }
    public static function get_cart_repurchase()
    {
    	$data['cart']  = Session::get("mlm_repurchase"); 
    	$data['wallet_sum'] = Tbl_mlm_slot_wallet_log::where('wallet_log_slot', Self::$slot_id)->sum('wallet_log_amount');
    	return view('mlm.repurchase.cart', $data);
    }
    public static function cart_checkout()
    {
    	return Redirect::back();
    }
    public static function remove_from_cart_repurchase()
    {
    	$item_id = Request::input('item_id');
    	Mlm_repurchase::remove_from_cart($item_id);
    	$data['status'] = 'success';
    	$data['message'] = 'Item removed from cart';
    	return json_encode($data);
    }
    public function add_to_cart()
    {
    	$item_id	= Request::input('item_id');
		$quantity	= intval (Request::input('quantity'));
    	if($item_id != null)
    	{
    		if($quantity != null || $quantity >= 1)
    		{
    			$item_info = Tbl_item::where('item_id', $item_id)->first();
    			if($item_info != null)
    			{
    				$slot_id 	= Self::$slot_id;
					$customer_id = Self::$customer_id;
					$slot_info = Self::$slot_now;
					$membership_id = null;
					if($slot_info != null)
					{
						$membership_id = $slot_info->slot_membership;
					}
					else
					{
						$discount_card_log = Self::$discount_card_log;
						if($discount_card_log != null)
						{
							$membership_id =  $discount_card_log->discount_card_membership;
						}
						else
						{
							$membership_id = null;
						}
					}
					
					Mlm_repurchase::add_to_cart($item_info, $quantity, $membership_id);
	    			$data['status'] = 'success';
	    			$data['message'] = 'Item Added To Cart.';
    			}
    			else
    			{
    				$data['status'] = 'warning';
    				$data['message'] = 'Invalid Item.';
    			}
    		}
    		else
    		{
    			$data['status'] = 'warning';
    			$data['message'] = 'Quantity must be greater than or equal to 1.';
    		}
    	}
    	else
    	{
    		$data['status'] = 'warning';
    		$data['message'] = 'Please Choose an Item.';
    	}
    	return json_encode($data);
    }
    public function use_item_code($item_code_id)
    {
        $data = [];
        $data['item_code'] = Tbl_item_code::where('item_code_id', $item_code_id)
        ->join('tbl_mlm_item_points', 'tbl_mlm_item_points.item_id', '=', 'tbl_item_code.item_id')
        ->first();

        $data['active_plan'] = Mlm_plan::get_all_active_plan_repurchase(Self::$shop_id);
        if($data['item_code'])
        {
           foreach($data['active_plan'] as $key2 => $value2)
            {
                $code = $value2->marketing_plan_code;
                if($code == 'DISCOUNT_CARD_REPURCHASE' || $code == 'UNILEVEL_REPURCHASE_POINTS' || $code == 'UNILEVEL')
                {
                    
                    
                }
                else
                {
                    // dd($code);
                    $data["membership_points"][$value2->marketing_plan_label] = $data['item_code']->$code;
                }
            } 
        }


        // dd($data);
        return view('mlm.repurchase.use', $data);
    }
}