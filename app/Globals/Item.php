<?php
namespace App\Globals;

use App\Models\Tbl_variant;
use App\Models\Tbl_user;
use App\Models\Tbl_mlm_item_discount;
use App\Models\Tbl_mlm_slot;
use App\Models\Tbl_category;
use App\Models\Tbl_item;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_sir_item;
use App\Models\Tbl_mlm_discount_card_log;
use App\Models\Tbl_item_discount;

use App\Globals\Item;
use Session;

class Item
{
    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    public static function get_item_details($item_id = 0)
    {
        return Tbl_item::category()->where("item_id",$item_id)->first();
    }
	public static function breakdown($_item='')
	{
		$data = '';
        $total = 0;
        foreach($_item as $key => $item){
            $data['item'][$key]['product_name'] = $item->product_name;
            $data['item'][$key]['variant_product_id'] = $item->variant_product_id;
            $data['item'][$key]['variant_id'] = $item->variant_id;
            $data['item'][$key]['tbl_order_item_id'] = $item->tbl_order_item_id;
            $data['item'][$key]['image_path'] = $item->image_path;
            $data['item'][$key]['variant_sku'] = $item->variant_sku;
            $data['item'][$key]['item_amount_def'] = $item->item_amount;
            $data['item'][$key]['item_amount'] = number_format($item->item_amount,2);
            $data['item'][$key]['quantity'] = $item->quantity;
            $data['item'][$key]['discount'] = $item->item_discount;
            $data['item'][$key]['discount_reason'] = $item->item_discount_reason;
            $data['item'][$key]['discount_var'] = $item->item_discount_var;
            $data['item'][$key]['variant_charge_taxes'] = $item->variant_charge_taxes;
            $discount_amount = 0;
            $amount_to_show = 0;
            if($item->item_discount_var == 'amount'){
                $discount_amount = $item->discount;
            }
            else{
                $discount_amount = ($item->item_discount / 100) * $item->item_amount;
            }
            $discount_amount_def = $discount_amount;
            $variant_id = $item->variant_id;
            if($discount_amount == 0){
                $discount_amount = '';
                $amount_to_show = '';
            }
            else{
                $discount_amount = number_format($discount_amount,2);
                $amount_to_show = number_format($item->item_amount,2);
            }
            $data['item'][$key]['amount_to_show'] = $amount_to_show;
            $less_discount = $item->item_amount - $discount_amount;
            $data['item'][$key]['less_discount'] = number_format($less_discount,2);
            $data['item'][$key]['less_discount_def'] = $less_discount;
            $data['item'][$key]['discount_amount'] = $discount_amount;
            $data['item'][$key]['discount_amount_def'] = $discount_amount_def;
            $data['item'][$key]['total_amount'] = number_format($item->quantity * $less_discount,2);
            $data['item'][$key]['total_amount_def'] = $item->quantity * $less_discount;
            $variat = Tbl_variant::VariantOnly($variant_id)->get();
            $strvariant = '';
            foreach($variat as $var){
                if($strvariant != ''){
                    $strvariant.=' / ';
                }
                $strvariant.=$var->option_value;
            }

            $data['item'][$key]['variant_name'] = $strvariant;
            $total += ($item->quantity * $less_discount);

        }
        $data['total'] = $total;
        // dd($data);
        return $data;
	}

    public static function get_all_item()
    {
        return Tbl_item::where("shop_id", Item::getShopId())->where("archived", 0)->get();
    }
    public static function insert_item_discount($item_info)
    {
        $chck = Tbl_item_discount::where("discount_item_id",$item_info["item_id"])->first();

        if($chck == null)
        {
            if($item_info["item_discount_value"] >= 1)
            {
                $insert["discount_item_id"] = $item_info["item_id"];
                $insert["item_discount_value"] = $item_info["item_discount_value"];
                $insert["item_discount_date_start"] = date("Y-m-d g:i:s",strtotime($item_info["item_discount_date_start"]));
                $insert["item_discount_date_end"]  =  date("Y-m-d g:i:s",strtotime($item_info["item_discount_date_end"]));

                Tbl_item_discount::insert($insert);
            }   
        }
        else
        {
            if($item_info["item_discount_value"] <= 0)
            {
                Tbl_item_discount::where("item_discount_id",$chck->item_discount_id)->delete();
                Tbl_item_discount::where("item_discount_value",0)->delete();
            }
            else
            {
                $insert["item_discount_value"] = $item_info["item_discount_value"];
                $insert["item_discount_date_start"] = date("Y-m-d g:i:s",strtotime($item_info["item_discount_date_start"]));
                $insert["item_discount_date_end"]  =  date("Y-m-d g:i:s",strtotime($item_info["item_discount_date_end"]));

                Tbl_item_discount::where("discount_item_id",$item_info["item_id"])->update($insert);
            }
        }
    }
    public static function get_all_category_item($type = array(1,2,3,4))
    {
        $shop_id = Item::getShopId();
        $_category = Tbl_category::where("type_shop",$shop_id)->where("type_parent_id",0)->where("archived",0)->get()->toArray();

        foreach($_category as $key =>$category)
        {
            $_category[$key]['item_list']   = Tbl_item::where("item_category_id",$category['type_id'])->whereIn("item_type_id",$type)->get()->toArray();
            foreach($_category[$key]['item_list'] as $key1=>$item_list)
            {
                $_category[$key]['item_list'][$key1]['multi_price'] = Tbl_item::multiPrice()->where("item_id", $item_list['item_id'])->get()->toArray();
            }
            $_category[$key]['subcategory'] = Item::get_item_per_sub($category['type_id'], $type);
        }

        return $_category;
    }
    public static function get_item_per_sub($category_id, $type = array())
    {
        $_category  = Tbl_category::where("type_parent_id",$category_id)->where("archived",0)->get()->toArray();
        foreach($_category as $key =>$category)
        {
            $_category[$key]['item_list']   = Tbl_item::where("item_category_id",$category['type_id'])->whereIn("item_type_id",$type)->get()->toArray();
            foreach($_category[$key]['item_list'] as $key1=>$item_list)
            {
                $_category[$key]['item_list'][$key1]['multi_price'] = Tbl_item::multiPrice()->where("item_id", $item_list['item_id'])->get()->toArray();
            }
            $_category[$key]['subcategory'] = Item::get_item_per_sub($category['type_id'], $type);
        }

        return $_category;
    } 
   
    public static function get_all_item_sir($sir_id)
    {
        $shop_id = Item::getShopId();

        $item = Tbl_sir_item::select_sir_item()->where("tbl_sir_item.sir_id",$sir_id)->groupBy("tbl_item.item_category_id")->get();
        foreach ($item as $key1 => $value) 
        {         
            $_category[$key1] = Tbl_category::where("type_shop",$shop_id)->where("archived",0)->where("type_id",$value->item_category_id)->first();  
        }
        foreach($_category as $key => $category)
        {
            $_category[$key]->item_list   = Tbl_sir_item::select_sir_item()->where("tbl_sir_item.sir_id",$sir_id)->where("item_category_id",$category->type_id)->groupBy("tbl_sir_item.item_id")->get()->toArray();
            // dd($_category[$key]->item_list);
            $_category[$key]->subcategory = Item::get_item_per_sub_sir($category->type_id,$sir_id);        
        }

        return collect($_category)->toArray();
    }

    public static function get_item_per_sub_sir($category_id, $sir_id)
    {
        $_category  = Tbl_category::where("type_parent_id",$category_id)->where("archived",0)->get();
        foreach($_category as $key =>$category)
        {
            $_category[$key]->item_list   = Tbl_sir_item::select_sir_item()->where("tbl_sir_item.sir_id",$sir_id)->where("item_category_id",$category->type_id)->groupBy("tbl_sir_item.item_id")->get()->toArray();
            $_category[$key]->subcategory = Item::get_item_per_sub_sir($category->type_id,$sir_id);
        }

        return collect($_category)->toArray();
    }

    public static function get_item_bundle($item_id = null)
    {
        $data = Tbl_item::where("item_type_id", 4);
        $items = [];

        if($item_id)
        {
            $items           = $data->where("item_id", $item_id)->first()->toArray();
            $items["bundle"] = Tbl_item_bundle::item()->where("bundle_bundle_id", $item_id)->get()->toArray();
        }
        else
        {
            $_item = $data->get()->toArray();

            foreach($_item as $key=>$item)
            {
                $items[$key]             = $item;
                $items[$key]["bundle"]   = Tbl_item_bundle::item()->where("bundle_bundle_id", $item["item_id"])->get()->toArray();
            }
        }

        return $items;
    }

    public static function view_item_dropdown($shop_id,$sel = null,$multiple = false)
    {
        if($sel == null)
        {
            $sel = 0;
        }
        $data["multiple"] = $multiple;
        $data['selected'] = $sel;
        $data['_item']    = Tbl_item::where("shop_id",$shop_id)
        ->where('tbl_item.item_type_id', '!=', 4)
        ->where('tbl_item.archived', 0)
        ->orderBy('tbl_item.item_id','asc')
        ->type()->category()->get();

        return view('member.mlm_product_code.dropdown.mlm_item_dropdown', $data);
    }
    public static function get_all_item_per_shop($shop_id, $array_filter)
    {
        $data['_item']    = Tbl_item::where("shop_id",$shop_id)
        ->where(function($query) use($array_filter)
        {
            foreach($array_filter as $key => $value)
            {
                $query->where($key, $value);
            }
        })
        ->where('item_price', '>=', 1)
        ->join("tbl_mlm_item_points","tbl_mlm_item_points.item_id","=","tbl_item.item_id")
        ->orderBy('tbl_item.item_id','asc')->type()->category()->get();

        return $data['_item'];
    }
    public static function sell_item_add_to_session($array)
    {
       // Session::forget('sell_item_codes_session');
        $get_session = Session::get("sell_item_codes_session"); 
        
        if(!empty($get_session))
        {
            $condition = "false";

            foreach($get_session as $key => $value)
            {
                if($array['item_id'] == $key)
                {
                   $get_session[$key]['quantity']        = $get_session[$key]['quantity'] + $array['quantity'];
                   $get_session[$key]['total']           = $get_session[$key]['total'] + $array['total'];
                   $condition = "true";
                }
            }

            if($condition == "false")
            {
                $get_session[$array['item_id']] = $array;
                Session::put('sell_item_codes_session', $get_session);  
            }
            else
            {
                Session::put('sell_item_codes_session', $get_session); 
            }
        }
        else
        {
            $array2[$array['item_id']] = $array;
            Session::put('sell_item_codes_session', $array2);
        }

        $get_session = Session::get("sell_item_codes_session"); 
        return $get_session;
    }

    public static function sell_item_edit_to_session($array,$removed = null)
    {
       // Session::forget('sell_item_codes_session');
        $get_session = Session::get("sell_item_codes_session"); 
        $total       = 0;
        if(!empty($get_session))
        {
            $condition = "false";
            if($removed)
            {
                $get_session[$array['item_id']] = $array; 
                Session::put('sell_item_codes_session', $get_session);
                
                $remove_session = Session::get("sell_item_codes_session");
                $remove_session = Item::replace_key_function($remove_session,$removed,$array["item_id"]);
                
                unset($remove_session[$removed]);
                Session::put('sell_item_codes_session', $remove_session);
                $get_session = Session::get("sell_item_codes_session");
            }
            else
            {
                foreach($get_session as $key => $value)
                {
                    if($array['item_id'] == $key)
                    {
                       $get_session[$key]['quantity'] = $array['quantity'];
                       $get_session[$key]['total'] = $array['total'];
                       $condition = "true";
                    }
                }
                
            }
            
            if($condition == "false")
            {
                $get_session[$array['item_id']] = $array;
                Session::put('sell_item_codes_session', $get_session);  
            }
            else
            {
                Session::put('sell_item_codes_session', $get_session); 
            }
            
            
            $get_session = Session::get("sell_item_codes_session"); 
            foreach($get_session as $key => $value)
            {
                $total = $total + $get_session[$key]['total'];
                $data["total"] = $total;
            }
            
            return $data;
        }
        else
        {
            return json_encode("Fail"); 
        }
    }

    public static function replace_key_function($array, $key1, $key2)
    {
        $keys = array_keys($array);
        $index = array_search($key1, $keys);
    
        if ($index !== false) {
            $keys[$index] = $key2;
            $array = array_combine($keys, $array);
        }
    
        return $array;
    }

    public static function get_discounted_price_mlm($item_id, $membership)
    {
        $count = Tbl_mlm_item_discount::where('item_id', $item_id)->where('membership_id', $membership)->count();
        $item_price = Item::get_original_price($item_id);
        if($count === 0)
        {
            return $item_price;
        }
        else
        {

            $discount = Tbl_mlm_item_discount::where('item_id', $item_id)->where('membership_id', $membership)->first();
            if($discount)
            {
                $discounted_value = get_discount_price($item_price, $discount->item_discount_percentage, $discount->item_discount_price);
                return $discounted_value;
            }
            else
            {
                return $item_price;
            }
            
        }
    }
    public static function get_discount_only($item_id, $membership_id)
    {
        $count = Tbl_mlm_item_discount::where('item_id', $item_id)->where('membership_id', $membership_id)->count();
        $item_price = Item::get_original_price($item_id);
        if($count === 0)
        {
            return 0;
        }
        else
        {
            $discount = Tbl_mlm_item_discount::where('item_id', $item_id)->where('membership_id', $membership_id)->first();
            // return $discount->item_discount_percentage;
            if($discount->item_discount_percentage == 0){
                $discounted_value = $discount->item_discount_price;
            }
            else
            {
                return $discounted_value = $item_price *  ($discount->item_discount_price/100);
            }
            return $discounted_value;
        }
    }
    public static function get_original_price($item_id)
    {
        $item_count = Tbl_item::where('item_id', $item_id)->count();
        if($item_count == 0)
        {
            $item_price = 0;
        }
        else
        {
           $item_price = Tbl_item::where('item_id', $item_id)->pluck('item_price'); 
        }
        return $item_price;
    }
    public static function fix_discount_session($slot_id)
    {

        
        $slot = Tbl_mlm_slot::where('slot_id', $slot_id)->first();
        if($slot)
        {
          $item_session = Session::get("sell_item_codes_session");
            foreach($item_session as $key => $item)
            {
                $item_session[$key]['membership_discount'] = Item::get_discount_only($key, $slot->slot_membership);
                $item_session[$key]['membership_discounted_price'] = $item['price'] - $item_session[$key]['membership_discount'];
                $item_session[$key]['membership_discounted_price_total'] =  $item['quantity'] * $item_session[$key]['membership_discounted_price'];
            }  
            Session::put('sell_item_codes_session', $item_session);
        }
        else
        {
            $item_session = Session::get("sell_item_codes_session");
            foreach($item_session as $key => $item)
            {
                $item_session[$key]['membership_discount'] = 0;
                $item_session[$key]['membership_discounted_price'] = $item['price'] - $item_session[$key]['membership_discount'];
                $item_session[$key]['membership_discounted_price_total'] =  $item['quantity'] * $item_session[$key]['membership_discounted_price'];
            }
            Session::put('sell_item_codes_session', $item_session);
        }
        return $item_session;
    }
    public static function fix_discount_session_w_dis($slot_id, $discount_card_log_id)
    {

        if($slot_id != 0)
        {
            $slot = Tbl_mlm_slot::where('slot_id', $slot_id)->first();
            if($slot)
            {
              $item_session = Session::get("sell_item_codes_session");
              if($item_session != null)
              {
                foreach($item_session as $key => $item)
                {
                    $item_session[$key]['membership_discount'] = Item::get_discount_only($key, $slot->slot_membership);
                    $item_session[$key]['membership_discounted_price'] = $item['price'] - $item_session[$key]['membership_discount'];
                    $item_session[$key]['membership_discounted_price_total'] =  $item['quantity'] * $item_session[$key]['membership_discounted_price'];
                }  
                Session::put('sell_item_codes_session', $item_session);
              }
                
            }
            else
            {
                $item_session = Session::get("sell_item_codes_session");
                foreach($item_session as $key => $item)
                {
                    $item_session[$key]['membership_discount'] = 0;
                    $item_session[$key]['membership_discounted_price'] = $item['price'] - $item_session[$key]['membership_discount'];
                    $item_session[$key]['membership_discounted_price_total'] =  $item['quantity'] * $item_session[$key]['membership_discounted_price'];
                }
                Session::put('sell_item_codes_session', $item_session);
            }
        }
        else
        {
            $discount_card  = Tbl_mlm_discount_card_log::where('discount_card_log_id', $discount_card_log_id)->first();
            if($discount_card)
            {
              $item_session = Session::get("sell_item_codes_session");
              if($item_session != null)
              {
                foreach($item_session as $key => $item)
                {
                    $item_session[$key]['membership_discount'] = Item::get_discount_only($key, $discount_card->discount_card_membership);
                    $item_session[$key]['membership_discounted_price'] = $item['price'] - $item_session[$key]['membership_discount'];
                    $item_session[$key]['membership_discounted_price_total'] =  $item['quantity'] * $item_session[$key]['membership_discounted_price'];
                } 
                }
                Session::put('sell_item_codes_session', $item_session);
            }
            else
            {
                $item_session = Session::get("sell_item_codes_session");
                if($item_session != null)
                {
                    foreach($item_session as $key => $item)
                    {
                        $item_session[$key]['membership_discount'] = 0;
                        $item_session[$key]['membership_discounted_price'] = $item['price'] - $item_session[$key]['membership_discount'];
                        $item_session[$key]['membership_discounted_price_total'] =  $item['quantity'] * $item_session[$key]['membership_discounted_price'];
                    }
                    Session::put('sell_item_codes_session', $item_session);
                }
                
            }
        }
        
        return $item_session;
    }
}