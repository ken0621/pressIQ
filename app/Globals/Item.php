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
use App\Models\Tbl_audit_trail;
use App\Models\Tbl_warehouse_inventory_record_log;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Purchasing_inventory_system;
use App\Globals\Tablet_global;
use App\Globals\Currency;
use App\Models\Tbl_price_level;
use App\Models\Tbl_price_level_item;
use App\Models\Tbl_shop;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_manufacturer;
use App\Models\Tbl_item_type;
use App\Models\Tbl_membership;
use Session;
use DB;
use Carbon\carbon;
use App\Globals\Merchant;
use App\Globals\Warehouse2;
use Validator;
use stdClass;
class Item
{
    /* ITEM CRUD START */

    public static function create_validation($shop_id, $item_type, $insert)
    {
        $return['item_id'] = 0;
        $return['status'] = null;
        $return['message'] = null;

        $rules['item_name'] = 'required';
        $rules['item_sku'] = 'required';
        $rules['item_price'] = 'required';

        if($item_type <= 2)
        {
            $rules['item_cost'] = 'required';
            if($insert['item_cost'] > $insert['item_price'])
            {       
                $return['status'] = 'error';
                $return['message'] .= 'The cost is greater than the sales price.'."<br>";
            }            
        }
        $validator = Validator::make($insert, $rules);

        if($validator->fails())
        {
            $return["status"] = "error";
            foreach ($validator->messages()->all('') as $keys => $message)
            {
                $return["message"] .= $message."<br>";
            }
        }
        if($shop_id)
        {
            $shop_data = Tbl_shop::where('shop_id',$shop_id)->first();
            if(!$shop_data)
            {
                $return['status'] = 'error';
                $return['message'] .= 'Your account does not exist. <br>';                
            }
        }
        if($item_type)
        {
            $type_data = Tbl_item_type::where('item_type_id',$item_type)->first();
            if(!$type_data)
            {
                $return['status'] = 'error';
                $return['message'] .= 'Item type does not exist. <br>';            
            }
        }
        if($insert['item_category_id'] != 0)
        {
            $category_data = Tbl_category::where('type_id',$insert['item_category_id'])->where('type_shop',$shop_id)->first();
            if(!$category_data)
            {
                $return['status'] = 'error';
                $return['message'] .= 'Category does not exist. <br>';            
            }            
        }
        if($insert['item_manufacturer_id'] != 0)
        {
            $category_data = Tbl_manufacturer::where('manufacturer_id',$insert['item_manufacturer_id'])->where('manufacturer_shop_id',$shop_id)->first();
            if(!$category_data)
            {
                $return['status'] = 'error';
                $return['message'] .= 'Manufacturer does not exist. <br>';            
            }            
        }
        if($insert['item_asset_account_id'] != 0)
        {
            $asset_data = Tbl_chart_of_account::where('account_id',$insert['item_asset_account_id'])->where('account_shop_id',$shop_id)->first();
            if(!$asset_data)
            {
                $return['status'] = 'error';
                $return['message'] .= 'Asset account does not exist. <br>';            
            }            
        }
        if($insert['item_income_account_id'] != 0)
        {
            $income_data = Tbl_chart_of_account::where('account_id',$insert['item_income_account_id'])->where('account_shop_id',$shop_id)->first();
            if(!$income_data)
            {
                $return['status'] = 'error';
                $return['message'] .= 'Income account does not exist. <br>';            
            }            
        }
        if($insert['item_expense_account_id'] != 0)
        {
            $expense_data = Tbl_chart_of_account::where('account_id',$insert['item_expense_account_id'])->where('account_shop_id',$shop_id)->first();
            if(!$expense_data)
            {
                $return['status'] = 'error';
                $return['message'] .= 'Expense account does not exist. <br>';            
            }            
        }

        return $return;

    }
    public static function create($shop_id, $item_type, $insert)
    {
        $return['item_id'] = 0;
        $return['status'] = null;
        $return['message'] = null; 

        $rules['item_name'] = 'required';
        $rules['item_sku'] = 'required';
        $rules['item_price'] = 'required';

        if($item_type <= 2)
        {
            $rules['item_cost'] = 'required';
            if($insert['item_cost'] > $insert['item_price'])
            {       
                $return['status'] = 'error';
                $return['message'] .= 'The cost is greater than the sales price.'."<br>";
            }
        }
        $validator = Validator::make($insert, $rules);

        if($validator->fails())
        {
            $return["status"] = "error";
            foreach ($validator->messages()->all('') as $keys => $message)
            {
                $return["message"] .= $message."<br>";
            }
        }
        if(!$return['status'])
        {
            $insert['shop_id'] = $shop_id;
            $insert['item_type_id'] = $item_type;
            $insert['item_date_created'] = Carbon::now();

            $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
            
            $return = Warehouse2::refill_validation($shop_id, $warehouse_id, 0, $insert['item_quantity'], 'Initial Quantity from Item');
            if(!$return['message'])
            {
                $item_id = Tbl_item::insertGetId($insert);
                
                $source['name'] = 'initial_qty';
                $source['id'] = $item_id;
                $warehouse_id = Warehouse2::get_current_warehouse($shop_id);
                $return = Warehouse2::refill($shop_id, $warehouse_id, $item_id, $insert['item_quantity'], 'Initial Quantity from Item',$source);         

                $return['item_id']       = $item_id;
                $return['status']        = 'success';
                $return['message']       = 'Item successfully created.';
                $return['call_function'] = 'success_item';       
            }
        }

        return $return;
    }
    public static function modify($shop_id, $item_id, $update)
    {
        $return['item_id'] = $item_id;
        $return['status'] = null;
        $return['message'] = null; 

        $rules['item_name'] = 'required';
        $rules['item_sku'] = 'required';
        $rules['item_price'] = 'required';
        $rules['item_cost'] = 'required';

        $validator = Validator::make($update, $rules);

        if($update['item_cost'] > $update['item_price'])
        {       
            $return['status'] = 'error';
            $return['message'] = 'The cost is greater than the sales price.'."<br>";
        }

        if($validator->fails())
        {
            $return["status"] = "error";
            foreach ($validator->messages()->all('') as $keys => $message)
            {
                $return["message"] .= $message."<br>";
            }
        }
        if(!$return['status'])
        {
            $update['updated_at'] = Carbon::now();

            $item_id = Tbl_item::where("shop_id", $shop_id)->where("item_id", $item_id)->update($update);

            $return['item_id']       = $item_id;
            $return['status']        = 'success';
            $return['message']       = 'Item successfully created.';
            $return['call_function'] = 'success_item';
        }

        return $return;
    }
    public static function archive($shop_id, $item_id)
    {
        $update["archived"] = 1;
        $update["item_date_archived"] = Carbon::now();
        Tbl_item::where("shop_id", $shop_id)->where("item_id", $item_id)->update($update);
    }
    public static function restore($shop_id, $item_id)
    {
        $update["archived"] = 0;
        $update["item_date_archived"] = null;
        Tbl_item::where("shop_id", $shop_id)->where("item_id", $item_id)->update($update);
    }

    public static function create_bundle_validation($shop_id, $item_type, $insert, $_item)
    {
        $return = null;

        $rules['item_name'] = 'required';
        $rules['item_sku'] = 'required';
        $rules['item_price'] = 'required';

        $validator = Validator::make($insert, $rules);

        if($validator->fails())
        {
            foreach ($validator->messages()->all('') as $keys => $message)
            {
                $return .= $message."<br>";
            }
        }
        if($shop_id)
        {
            $shop_data = Tbl_shop::where('shop_id',$shop_id)->first();
            if(!$shop_data)
            {
                $return .= 'Your account does not exist. <br>';                
            }
        }
        if($item_type)
        {
            $type_data = Tbl_item_type::where('item_type_id',$item_type)->first();
            if(!$type_data)
            {
                $return .= 'Item type does not exist. <br>';            
            }
        }
        if($insert['item_category_id'] != 0)
        {
            $category_data = Tbl_category::where('type_id',$insert['item_category_id'])->where('type_shop',$shop_id)->first();
            if(!$category_data)
            {
                $return .= 'Category does not exist. <br>';            
            }            
        }
        if($insert['item_income_account_id'] != 0)
        {
            $income_data = Tbl_chart_of_account::where('account_id',$insert['item_income_account_id'])->where('account_shop_id',$shop_id)->first();
            if(!$income_data)
            {
                $return .= 'Income account does not exist. <br>';            
            }            
        }
        if(count($_item) <= 0)
        {
            $return .= 'Please add items to bundle. <br>';  
        }

        return $return;
    }
    public static function create_bundle($shop_id, $item_type, $insert, $_item)
    {
        $insert['shop_id'] = $shop_id;
        $insert['item_type_id'] = $item_type;
        $insert['item_date_created'] = Carbon::now();
       
        $item_id = Tbl_item::insertGetId($insert);
        foreach ($_item as $key => $value) 
        {
            $ins_item['bundle_bundle_id'] = $item_id;
            $ins_item['bundle_item_id'] = $value['item_id'];
            $ins_item['bundle_qty'] = $value['quantity'];

            Tbl_item_bundle::insert($ins_item);
        }

        $return['item_id']       = $item_id;
        $return['status']        = 'success';
        $return['message']       = 'Item successfully created.';
        $return['call_function'] = 'success_item';       

        return $return;
    }
    public static function modify_bundle($shop_id, $item_id, $insert, $_item)
    {  
        $insert['shop_id'] = $shop_id;
        Tbl_item::where('item_id',$item_id)->update($insert);
        Tbl_item_bundle::where('bundle_bundle_id',$item_id)->delete();

        foreach ($_item as $key => $value) 
        {
            $ins_item['bundle_bundle_id'] = $item_id;
            $ins_item['bundle_item_id'] = $value['item_id'];
            $ins_item['bundle_qty'] = $value['quantity'];

            Tbl_item_bundle::insert($ins_item);
        }

        $return['item_id']       = $item_id;
        $return['status']        = 'success';
        $return['message']       = 'Item successfully updated.';
        $return['call_function'] = 'success_item';       

        return $return;

    }
    /* ITEM CRUD END */


    /* READ DATA */
    public static function get($shop_id = 0, $paginate = false, $archive = 0)
    {
        $query = Tbl_item::where("tbl_item.shop_id", $shop_id)->where("tbl_item.archived", $archive)->type()->um_multi()->membership();

        if(session("get_inventory"))
        {
            $query = $query->inventory(session("get_inventory"));
        }

        /* SEARCH */
        if (session("get_search")) 
        {
            $query = $query->searchName(session("get_search"));
        }

        /* FILTER BY TYPE */
        if (session("get_filter_type")) 
        {
            $query = $query->where("tbl_item.item_type_id", session("get_filter_type"));
        }

        /* FILTER BY CATEGORY */
        if (session("get_filter_category")) 
        {
            $query = $query->where("tbl_item.item_category_id", session("get_filter_category"));
        }

        /* CHECK IF THERE IS PAGINATION */
        if($paginate)
        {
            $_item = $query->paginate($paginate);
            session(['item_pagination' => $_item->render()]);
        }
        else
        {
            $_item = $query->get();
        }

        /* ITEM ADDITIONAL DATA */
        foreach($_item as $key => $item)
        {
            $item = Self::add_info($item);
            $_item_new[$key] = $item;
        }

        $return = isset($_item_new) ? $_item_new : null;  

        Self::get_clear_session();

        return $return;
    }
    
    public static function get_all_item()
    {
        return Tbl_item::where("shop_id", Item::getShopId())->where("archived", 0)->get();
    }
    public static function info($item_id)
    {
        $query = Tbl_item::type()->where("item_id", $item_id);

        if(session("get_inventory"))
        {
            $query = $query->inventory(session("get_inventory"));
        }

        $item = $query->first();

        Self::add_info($item);
        Self::get_clear_session();
        return $item;
    }
    public static function get_inventory($warehouse_id)
    {
        session(['get_inventory' => $warehouse_id]);
    }
    public static function get_search($keyword)
    {
        session(['get_search' => $keyword]);
    }
    public static function get_pagination()
    {
        $pagination = session("item_pagination");
        session(['item_pagination' => null]);
        return $pagination;
    }
    public static function get_add_markup()
    {
        session(['get_add_markup' => true]);
    }
    public static function get_add_display()
    {
        session(['get_add_display' => true]);
    }
    public static function get_filter_type($id)
    {
        session(['get_filter_type' => $id]);
    }
    public static function get_filter_category($id)
    {
        session(['get_filter_category' => $id]);
    }
    public static function get_apply_price_level($price_level_id)
    {
        session(['get_apply_price_level' => $price_level_id]);
    }

    public static function get_clear_session()
    {
        $store["get_add_markup"] = null;
        $store["get_add_display"] = null;
        $store["get_filter_type"] = null;
        $store["get_filter_category"] = null;
        $store["get_apply_price_level"] = null;
        $store["get_search"] = null;
        $store["get_inventory"] = null;
        session($store);
    }

    public static function add_info($item)
    {
        if(session("get_apply_price_level"))
        {
            $item = Self::add_apply_price_level($item);
        }

        if(session("get_add_markup"))
        {
            $item = Self::add_info_markup($item);
        }

        if(session("get_add_display"))
        {
            $item = Self::add_info_display($item);
        }


        return $item;
    }
    public static function add_apply_price_level($item)
    {
        $price_level_id         = session("get_apply_price_level");
        $check_price_level      = Tbl_price_level::where("price_level_id", $price_level_id)->first();

        if($check_price_level)
        {
            if($check_price_level->price_level_type == "per-item")
            {
                $check_item = Tbl_price_level_item::where("price_level_id", $price_level_id)->where("item_id", $item->item_id)->first();
            
                if($check_item)
                {
                    $new_computed_price     = $check_item->custom_price;
                }
                else
                {
                    $new_computed_price     = $item->item_price;
                }
            }
            else
            {
                $percentage_mode        = $check_price_level->fixed_percentage_mode;
                $percentage_value       = $check_price_level->fixed_percentage_value;
                $percentage_source      = $check_price_level->fixed_percentage_source;
                $applied_multiplier     = ($percentage_mode == "lower" ? ($percentage_value * -1) : $percentage_value);
                $price_basis            = ($percentage_source == "standard price" ? $item->item_price : $item->item_cost);
                $addend                 = $price_basis * ($applied_multiplier / 100);
                $new_computed_price     = $price_basis + $addend; 
            }
        }
        else
        {
            $new_computed_price     = $item->item_price;
        }

        $item->original_item_price = $item->item_price;
        $item->item_price = $new_computed_price;

        return $item;
    }
    public static function add_info_markup($item)
    {
        $item->computed_price   = $item->item_price;
        $item->markup           = $item->item_price - $item->item_cost;
        $item->display_markup   = Currency::format($item->markup);
        return $item;
    }
    public static function add_info_display($item)
    {
        $item->display_price   = Currency::format($item->item_price);
        $item->display_cost   = Currency::format($item->item_cost);
        return $item;
    }
    /* READ DATA END */
    public static function list_price_level($shop_id)
    {
        $_price_level = Tbl_price_level::where("shop_id", $shop_id)->get();
        return $_price_level;
    }
    public static function insert_price_level($shop_id, $price_level_name, $price_level_type, $fixed_percentage_mode, $fixed_percentage_source, $fixed_percentage_value)
    {  
        $insert_price_level["price_level_name"] = $price_level_name;
        $insert_price_level["price_level_type"] = $price_level_type;
        $insert_price_level["shop_id"] = $shop_id;
        
        if($price_level_type == "fixed-percentage")
        {

            $insert_price_level["fixed_percentage_mode"] = $fixed_percentage_mode;
            $insert_price_level["fixed_percentage_source"] = $fixed_percentage_source;
            $insert_price_level["fixed_percentage_value"] = $fixed_percentage_value;
        }

        return Tbl_price_level::insertGetId($insert_price_level);
    }
    public static function insert_price_level_item($shop_id, $price_level_id, $_item)
    {  
        $_insert = array();

        foreach($_item as $item_id => $custom_price)
        {
            if($custom_price != "")
            {
                $insert["price_level_id"]   = $price_level_id;
                $insert["item_id"]          = $item_id;
                $insert["custom_price"]     = $custom_price;
                array_push($_insert, $insert);
            }
        }

        if($_insert)
        {
            Tbl_price_level_item::insert($_insert);
        }
    }
    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
    }
    public static function generate_barcode($barcode = 0)
    {
        $return = $barcode;
        $chk =  Tbl_item::where("item_barcode",$return)->get();
        if(count($chk) > 1)
        {
            $num = '1234567890';
            $return = str_shuffle($return);
        }

        return $return;
    }
    public static function get_item_price_history($item_id, $show_all = false)
    {
        $item_data = Item::get_item_details($item_id);
        $return = "";
        $text = "";
        $trail = Tbl_audit_trail::where("source","item")->where("source_id",$item_id)->orderBy("created_at","DESC")->get();
        // dd($trail);
        $last = null;
        foreach ($trail as $key => $value) 
        {
            $item_qty = 1;
            if(Purchasing_inventory_system::check())
            {
                $item_qty = UnitMeasurement::um_qty($item_data->item_measurement_id, 1);
            }
            $old[$key] = unserialize($value->old_data);
            $amount = 0;
            if($old)
            {
                if($item_data->item_price != $old[$key]["item_price"] || $old[$key]["item_price"] != 0)
                {
                    $len = strlen($return);
                    
                    $amount = $old[$key]["item_price"] * $item_qty;
                    if ($last != $amount) 
                    {
                        $return .= date('m/d/Y',strtotime($value->created_at))." - ".currency("PHP ",$amount)."<br>";

                        $text = $return;
                        if($show_all == false)
                        {
                            if($len > 25)
                            {
                                $text = (substr($text, 0, 30)."...<a class='popup' size='sm' link='/member/item/view_item_history/".$item_id."'>View</a>");
                            }
                        }
                    }
                }

                $last = $amount;
            }
        }  

        return $text;
    }
    public static function get_item_details($item_id = 0)
    {
        $data = Tbl_item::um_item()->category()->where("item_id",$item_id)->first();

        if($data->item_type_id == 4)
        {
            $data->item_price = Item::get_item_bundle_price($item_id);
        }

        return $data;
    }

    public static function get_item_in_bundle($item_id = 0)
    {
        $items = array();
        if($item_id != 0)
        {
            $items = Tbl_item_bundle::where("bundle_bundle_id",$item_id)->get();
        }
        return $items;
    }    
    public static function get_item_type($item_id = 0)
    {
        $type = null;
        if($item_id != 0)
        {
            $type = Tbl_item::where("item_id",$item_id)->value("item_type_id");
        }
        return $type;
    }
    public static function get_item_type_list()
    {
        return Tbl_item_type::where("archived", 0)->get();
    }
    public static function get_item_type_id($type_name = '') // Inventory, Non-Inventory, Service, Bundle, Membership
    {        
        $id = Tbl_item_type::where("item_type_name", $type_name)->value('item_type_id');        
        if(!$id)
        {
            $id = 5; //For Membership (Temporary)
        }
        return $id;
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


    public static function apply_additional_info_to_array($_item)
    {
        $_new_item = null;

        foreach($_item as $key => $item)
        {
            $_new_item[$key] = $item;
            $_new_item[$key] = Self::item_additional_info($_new_item[$key]);
        }

        return $_new_item;
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

    public static function get_returnable_item($for_tablet = false)
    {        
        $shop_id = Item::getShopId();
        if($for_tablet == true)
        {
            $shop_id = Tablet_global::getShopId();
        }
        $data = Tbl_item::category()->where("shop_id",$shop_id)
                                    ->where("tbl_item.archived",0)
                                    ->where("is_mts",1)
                                    ->groupBy("tbl_item.item_id")
                                    ->get();  
        foreach ($data as $key => $value) 
        {
            if($value->item_type_id == 4)
            {
               $data[$key]->item_price = Item::get_item_bundle_price($value->item_id);   
               $data[$key]->item_cost= Item::get_item_bundle_cost($value->item_id); 
            }
        }       
 
        return $data;        
    }



    public static function pis_get_all_category_item_transaction($type = array(1,2,3,4))
    {        
        $shop_id = Item::getShopId();
        $_category = Tbl_category::where("type_shop",$shop_id)->where("type_parent_id",0)->where("is_mts",0)->where("archived",0)->get()->toArray();

        foreach($_category as $key =>$category)
        {
            $_category[$key]['item_list']   = Tbl_item::where("item_category_id",$category['type_id'])->whereIn("item_type_id",$type)->where("archived",0)->get()->toArray();
            foreach($_category[$key]['item_list'] as $key1=>$item_list)
            {
                //  //cycy
                if($item_list['item_type_id'] == 4)
                {
                   $_category[$key]['item_list'][$key1]['item_price'] = Item::get_item_bundle_price($item_list['item_id']); 
                   $_category[$key]['item_list'][$key1]['item_cost'] = Item::get_item_bundle_cost($item_list['item_id']); 
                }
                $_category[$key]['item_list'][$key1]['multi_price'] = Tbl_item::multiPrice()->where("item_id", $item_list['item_id'])->get()->toArray();
            }
            $_category[$key]['subcategory'] = Item::pis_get_item_per_sub($category['type_id'], $type);
        }

        return $_category;
    }
    public static function pis_get_item_per_sub($category_id, $type = array())
    {
        $_category  = Tbl_category::where("type_parent_id",$category_id)->where("archived",0)->where("is_mts",0)->get()->toArray();
        foreach($_category as $key =>$category)
        {
            $_category[$key]['item_list']   = Tbl_item::where("item_category_id",$category['type_id'])->where("archived",0)->whereIn("item_type_id",$type)->get()->toArray();
            foreach($_category[$key]['item_list'] as $key1=>$item_list)
            {
                if($item_list['item_type_id'] == 4)
                {
                   $_category[$key]['item_list'][$key1]['item_price'] = Item::get_item_bundle_price($item_list['item_id']); 
                   $_category[$key]['item_list'][$key1]['item_cost'] = Item::get_item_bundle_cost($item_list['item_id']); 
                }
                $_category[$key]['item_list'][$key1]['multi_price'] = Tbl_item::multiPrice()->where("item_id", $item_list['item_id'])->get()->toArray();
            }
            $_category[$key]['subcategory'] = Item::get_item_per_sub($category['type_id'], $type);
        }

        return $_category;
    } 
    public static function get_all_category_item($type = array(1,2,3,4) , $for_tablet = false)
    {
        $shop_id = Item::getShopId(); 
        if($for_tablet == true)
        {
            $shop_id = Tablet_global::getShopId();
        }

        $_category = Tbl_category::where("type_shop",$shop_id)->where("type_parent_id",0)->where("archived",0)->get()->toArray();


        foreach($_category as $key =>$category)
        {
            $ismerchant = Merchant::ismerchant();
            if($ismerchant == 1)
            {
                $user_id = Merchant::getuserid();
                $_category[$key]['item_list'] = Tbl_item::where("item_category_id",$category['type_id'])
                ->join("tbl_item_merchant_request","tbl_item_merchant_request.merchant_item_id","=","tbl_item.item_id")
                ->where('item_merchant_requested_by', $user_id)
                ->whereIn("item_type_id",$type)->where("archived",0)->get()->toArray(); 
            }
            else
            {
               $_category[$key]['item_list']   = Tbl_item::where("item_category_id",$category['type_id'])->whereIn("item_type_id",$type)->where("archived",0)->get()->toArray(); 
            }
            foreach($_category[$key]['item_list'] as $key1=>$item_list)
            {
                //  //cycy
                if($item_list['item_type_id'] == 4)
                {
                   $_category[$key]['item_list'][$key1]['item_price'] = Item::get_item_bundle_price($item_list['item_id']); 
                   $_category[$key]['item_list'][$key1]['item_cost'] = Item::get_item_bundle_cost($item_list['item_id']); 
                }
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
            $ismerchant = Merchant::ismerchant();
            if($ismerchant == 1)
            {
                $user_id = Merchant::getuserid();
                $_category[$key]['item_list'] = Tbl_item::where("item_category_id",$category['type_id'])
                ->join("tbl_item_merchant_request","tbl_item_merchant_request.merchant_item_id","=","tbl_item.item_id")
                ->where('item_merchant_requested_by', $user_id)
                ->whereIn("item_type_id",$type)->where("archived",0)->get()->toArray(); 
            }
            else
            {
                $_category[$key]['item_list']   = Tbl_item::where("item_category_id",$category['type_id'])->where("archived",0)->whereIn("item_type_id",$type)->get()->toArray();
            }
            foreach($_category[$key]['item_list'] as $key1=>$item_list)
            {
                if($item_list['item_type_id'] == 4)
                {
                   $_category[$key]['item_list'][$key1]['item_price'] = Item::get_item_bundle_price($item_list['item_id']); 
                   $_category[$key]['item_list'][$key1]['item_cost'] = Item::get_item_bundle_cost($item_list['item_id']); 
                }
                $_category[$key]['item_list'][$key1]['multi_price'] = Tbl_item::multiPrice()->where("item_id", $item_list['item_id'])->get()->toArray();
            }
            $_category[$key]['subcategory'] = Item::get_item_per_sub($category['type_id'], $type);
        }

        return $_category;
    } 
   
    public static function get_all_item_sir($sir_id, $for_tablet = false)
    {
        $shop_id = Item::getShopId();
        if($for_tablet == true)
        {
            $shop_id = Tablet_global::getShopId();
        }
        $item = Tbl_sir_item::select_sir_item()->where("tbl_sir_item.sir_id",$sir_id)->groupBy("tbl_item.item_category_id")->get();
        foreach ($item as $key1 => $value) 
        {         
            $_category[$key1] = collect(Tbl_category::where("type_shop",$shop_id)->where("archived",0)->where("type_id",$value->item_category_id)->first())->toArray();  
        }

        foreach($_category as $key => $category)
        {
            $_category[$key]['item_list']   = Tbl_sir_item::select_sir_item()->where("tbl_sir_item.sir_id",$sir_id)->where("item_category_id",$category['type_id'])->groupBy("tbl_sir_item.item_id")->get()->toArray();
            foreach($_category[$key]['item_list'] as $key3 => $item_list)
            {
                if($item_list['item_type_id'] == 4)
                {
                   $_category[$key]['item_list'][$key3]['item_price'] = Item::get_item_bundle_price($item_list['item_id']); 
                }
            }
            $_category[$key]['subcategory'] = Item::get_item_per_sub_sir($category['type_id'],$sir_id);        
        }

        return collect($_category)->toArray();
    }

    public static function get_item_per_sub_sir($category_id, $sir_id)
    {
        $_category  = Tbl_category::where("type_parent_id",$category_id)->where("archived",0)->get()->toArray();
        foreach($_category as $key =>$category)
        {
            $_category[$key]['item_list']   = Tbl_sir_item::select_sir_item()->where("tbl_sir_item.sir_id",$sir_id)->where("item_category_id",$category['type_id'])->groupBy("tbl_sir_item.item_id")->get()->toArray();

            foreach ($_category[$key]['item_list'] as $key3 => $value3)
            {               
               if($value3['item_type_id'] == 4)
                {
                   $_category[$key]['item_list'][$key3]['item_price'] = Item::get_item_bundle_price($value3['item_id']); 
                }
            }
            $_category[$key]['subcategory'] = Item::get_item_per_sub_sir($category['type_id'],$sir_id);
        }

        return collect($_category)->toArray();
    }
    public static function bundle_count($item_id, $warehouse_id)
    {
        $_item = Item::get_item_from_bundle($item_id, $warehouse_id);
        $limit_array = array();

        foreach($_item as $item)
        {
            $ans = $item->inventory_count / $item->bundle_qty;
            array_push($limit_array, (int)$ans);
        }

        return min($limit_array);
    }
    public static function get_item_bundle_price($item_id = null)
    {
        $price = 0;
        $item_type = Tbl_item::where("item_id",$item_id)->value("item_type_id");
        if($item_id != null && $item_type == 4)
        {
            $bundle_item = Tbl_item_bundle::where("bundle_bundle_id",$item_id)->get();
            foreach ($bundle_item as $key => $value) 
            {
                $item_price =  Purchasing_inventory_system::get_item_price($value->bundle_item_id);
                $um_qty = UnitMeasurement::um_qty($value->bundle_um_id);

                $price += $item_price * ($um_qty * $value->bundle_qty);
            }
        }
        return $price;
    }   
    public static function get_item_bundle_cost($item_id = null)
    {
        $cost = 0;
        $item_type = Tbl_item::where("item_id",$item_id)->value("item_type_id");
        if($item_id != null && $item_type == 4)
        {
            $bundle_item = Tbl_item_bundle::where("bundle_bundle_id",$item_id)->get();
            foreach ($bundle_item as $key => $value) 
            {
                $item_cost =  Purchasing_inventory_system::get_item_cost($value->bundle_item_id);
                $um_qty = UnitMeasurement::um_qty($value->bundle_um_id);

                $cost += $item_cost * ($um_qty * $value->bundle_qty);
            }
        }
        return $cost;
    }    
    public static function get_bundle_item_qty($item_id = null)
    {
        $qty = 0;
        $item_type = Tbl_item::where("item_id",$item_id)->value("item_type_id");
        if($item_id != null && $item_type == 4)
        {
            $bundle_item = Tbl_item_bundle::where("bundle_bundle_id",$item_id)->get();
            foreach ($bundle_item as $key => $value) 
            {
                
            }
        }
        return $qty;
    }  
    public static function get_item_from_bundle($item_id, $warehouse_id = null)
    {
        $_item_bundle = Tbl_item_bundle::where("bundle_bundle_id", $item_id)->get();
        $_item = array();

        foreach($_item_bundle as $item_bundle)
        {  
            if($warehouse_id)
            {
                Item::get_inventory($warehouse_id);
            }

            $item = Item::info($item_bundle->bundle_item_id);
            $item->bundle_qty = $item_bundle->bundle_qty;

            array_push($_item, $item);
        }

        return $_item;
    }  
    public static function get_item_bundle($item_id = null)
    {
        $items = [];

        if($item_id)
        {
            $items           = Tbl_item::where("item_id", $item_id)->first()->toArray();

            $items["bundle"] = Tbl_item_bundle::item()->where("bundle_bundle_id", $item_id)->get()->toArray();
        }
        else
        {
            $_item = Tbl_item::get()->toArray();

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
        $ismerchant = Merchant::ismerchant();
            if($ismerchant == 1)
            {
                $user_id = Merchant::getuserid();

                $data['_item'] = Tbl_item::where("shop_id",$shop_id)
                ->where('tbl_item.item_type_id', '!=', 4)
                ->where('tbl_item.archived', 0)
                ->join("tbl_item_merchant_request","tbl_item_merchant_request.merchant_item_id","=","tbl_item.item_id")
                ->where('item_merchant_requested_by', $user_id)
                ->orderBy('tbl_item.item_id','asc')
                ->type()->category()->get();

                // $data['_item'] = Tbl_item::where("shop_id",$shop_id)
                // ->join("tbl_item_merchant_request","tbl_item_merchant_request.merchant_item_id","=","tbl_item.item_id")
                // ->where('item_merchant_requested_by', $user_id)
                // ->whereIn("item_type_id",$type)->where("archived",0)->get()->toArray(); 
            }
            else
            {
                $data['_item']    = Tbl_item::where("shop_id",$shop_id)
                ->where('tbl_item.item_type_id', '!=', 4)
                ->where('tbl_item.archived', 0)
                ->orderBy('tbl_item.item_id','asc')
                ->type()->category()->get();
            }
        

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
            // return $get_session;
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
           $item_price = Tbl_item::where('item_id', $item_id)->value('item_price'); 
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
    public static function getOtherChargeItem()
    {
        $exist_item = Tbl_item::where("shop_id", Item::getShopId())->where("item_code", "other-charge")->first();
        if(!$exist_item)
        {
            $insert["shop_id"]                  = Item::getShopId();
            $insert["item_type_id"]             = 3;
            $insert["item_category_id"]         = Item::getServiceCategory();
            $insert["item_name"]                = "Other Charge";
            $insert["item_income_account_id"]   = Accounting::getOpenBalanceEquity();
            $insert["item_code"]                = "other-charge";
            
            return Tbl_item::insertGetId($insert);
        }

        return $exist_item->item_id;
    }
    public static function getServiceCategory()
    {
        $exist_type = Tbl_category::where("type_shop", Item::getShopId())->where("type_name", "Service")->first();
        if(!$exist_type)
        {
            $insert["type_shop"]                = Item::getShopId();
            $insert["type_category"]            = "services";
            $insert["type_name"]                = "Service";
            $insert["type_date_created"]        = Carbon::now();  
            
            return Tbl_category::insertGetId($insert);
        }

        return $exist_type->type_id;
    }
    public static function getItemCategory($shop_id)
    {
        return Tbl_category::where("type_shop", $shop_id)->where("archived", 0)->get();
    }
    public static function get_choose_item($id)
    {
        $items = Tbl_item_bundle::where('bundle_bundle_id', $id)->get();
        $data = [];
        foreach ($items as $key => $value) 
        {
            $info = Item::info($value->bundle_item_id);

            $data[$value->bundle_item_id]['item_id'] = $value->bundle_item_id;
            $data[$value->bundle_item_id]['item_sku'] = $info->item_sku;
            $data[$value->bundle_item_id]['item_price'] = $info->item_price;
            $data[$value->bundle_item_id]['item_cost'] = $info->item_cost;
            $data[$value->bundle_item_id]['quantity'] = $value->bundle_qty;

            Session::put('choose_item',$data);
        }

        return $data;
    }
    public static function get_item_type_modify($type_id = 0)
    {
        $data['inventory_type'] = 'display: none';
        $data['non_inventory_type'] = 'display: none';
        $data['service_type'] = 'display: none';
        $data['bundle_type'] = 'display: none';
        $data['membership_kit_type'] = 'display: none';
        $data['type_main'] = 'display : none';
        $data['type_bundle_main'] = 'display : none';
        $data['type_remove_main'] = 'remove-this-type';
        $data['type_remove_bundle'] = 'remove-this-type';

        if($type_id == 1)
        {
            $data['inventory_type'] = '';
            $data['type_main'] = '';
            $data['type_remove_main'] = '';
        }
        if($type_id == 2)
        {
            $data['non_inventory_type'] = '';
            $data['type_main'] = '';
            $data['type_remove_main'] = '';
        }
        if($type_id == 3)
        {
            $data['service_type'] = '';
            $data['type_main'] = '';
            $data['type_remove_main'] = '';
        }
        if($type_id == 4)
        {
            $data['bundle_type'] = '';
            $data['type_bundle_main'] = '';
            $data['type_remove_bundle'] = '';

        }
        if($type_id == 5)
        {
            $data['membership_kit_type'] = '';
            $data['type_bundle_main'] = '';
            $data['type_remove_bundle'] = '';

        }

        return $data;
    }
    public static function get_membership()
    {
        $shop_id = Item::getShopId();
        return Tbl_membership::where('shop_id',$shop_id)->where('membership_archive',0)->get();
    }
    public static function get_assembled_kit($record_id = 0, $item_kit_id = 0, $item_membership_id = 0, $search_keyword = '', $status = '')
    {
        $shop_id = Item::getShopId();
        $warehouse_id = Warehouse2::get_current_warehouse($shop_id);

        $query = Tbl_warehouse_inventory_record_log::where('item_type_id',5)->item()->membership()->where('record_shop_id',$shop_id)->where('record_warehouse_id',$warehouse_id)->where('record_inventory_status',0)->groupBy('record_log_id')->orderBy('record_log_id');
        if($record_id)
        {
            $query = Tbl_warehouse_inventory_record_log::where('item_type_id',5)->where('record_log_id',$record_id)->item()->membership()->where('record_shop_id',$shop_id)->where('record_warehouse_id',$warehouse_id)->where('record_inventory_status',0)->groupBy('record_log_id')->orderBy('record_log_id');
        }

        if($item_kit_id)
        {
            $query->where('record_item_id',$item_kit_id);
        }
        if($item_membership_id)
        {
            $query->where('tbl_item.membership_id',$item_membership_id);
        }
        if($search_keyword)
        {
            $query->where('mlm_pin', "LIKE", "%" . $search_keyword . "%")->orWhere('mlm_activation', "LIKE", "%" . $search_keyword . "%");
        }

        if($status)
        {
            
        }

        return $query->get();
    }
    public static function assemble_membership_kit($shop_id, $warehouse_id, $item_id, $quantity)
    {
        $item_list = Item::get_item_in_bundle($item_id);
        $_item = [];
        foreach ($item_list as $key => $value) 
        {
            $_item[$key]['item_id'] = $value->bundle_item_id;
            $_item[$key]['quantity'] = $value->bundle_qty * $quantity;
            $_item[$key]['remarks'] = 'consume item upon assembling item';
        }
        $validate_consume = Warehouse2::consume_bulk($shop_id, $warehouse_id, 'assemble_item', $item_id, 'Consume Item upon assembling membership kit Item#'.$item_id, $_item);

        $source['name'] = 'assemble_item';
        $source['id'] = $item_id;
        $validate_consume .= Warehouse2::refill($shop_id, $warehouse_id, $item_id, $quantity, 'Refill Item upon assembling membership kit Item#'.$item_id, $source);

        return $validate_consume;
    } 
    public static function disassemble_membership_kit($record_log_id)
    {
        $record_data = Tbl_warehouse_inventory_record_log::where('record_log_id',$record_log_id)->first();

        if($record_data)
        {
            $item_list = Item::get_item_in_bundle($record_data->record_item_id);
           foreach ($item_list as $key => $value) 
           {
                Warehouse2::consume_update('assemble_item', $record_data->record_item_id, $value->bundle_item_id, $value->bundle_qty);
           }

           Tbl_warehouse_inventory_record_log::where('record_log_id',$record_log_id)->delete();
        }
    }
}