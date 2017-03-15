<?php

namespace App\Http\Controllers\Member;

use App\Models\Tbl_item;
use App\Globals\Warehouse;
use App\Globals\Utilities;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_sub_warehouse;
use App\Models\Tbl_user_warehouse_access;
use App\Models\Tbl_settings;
use Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Tbl_category;
use App\Models\Tbl_inventory_serial_number;
use Session;
use Validator;
class WarehouseController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $data["_warehouse"] = Tbl_warehouse::inventory()->select_info($this->user_info->shop_id, 0)->groupBy("tbl_warehouse.warehouse_id")->get();
            if(Request::input("search_txt"))
            {
               $data["_warehouse"] = Tbl_warehouse::inventory()->select_info($this->user_info->shop_id, 0)->where("warehouse_name","LIKE","%".Request::input("search_txt")."%")->groupBy("tbl_warehouse.warehouse_id")->get();            
            }

            $data["_warehouse_archived"] = Tbl_warehouse::inventory()->select_info($this->user_info->shop_id, 1)->groupBy("tbl_warehouse.warehouse_id")->get();

            $all_item = null;
            foreach($data["_warehouse"] as $key => $value)
            {
                $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$value->warehouse_id)->first();
                if(!$check_if_owned)
                {
                    unset($data["_warehouse"][$key]);
                }
                else
                {          
                    $selling_price = 0;
                    $cost_price = 0;
                    
                    $all_item = Tbl_sub_warehouse::select_item($value->warehouse_id)
                                                 ->get();

                    foreach ($all_item as $key2 => $value2) 
                    {
                        $qty = Tbl_warehouse_inventory::where("inventory_item_id",$value2->item_id)
                                                            ->where("warehouse_id",$value->warehouse_id)
                                                            ->sum("inventory_count");

                        $selling_price += $value2->item_price * $qty;
                        $cost_price += $value2->item_cost * $qty;
                    }
                    $data["_warehouse"][$key]->total_selling_price = $selling_price;
                    $data["_warehouse"][$key]->total_cost_price = $cost_price;
                }
            }

            $archive_item = null;
            foreach($data["_warehouse_archived"] as $key3 => $value3)
            {
                $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$value3->warehouse_id)->first();
                if(!$check_if_owned)
                {
                    unset($data["_warehouse_archived"][$key3]);
                }
                else
                {
                    $selling_price_a = 0;
                    $cost_price_a = 0;
                    $archive_item = Tbl_sub_warehouse::select_item($value3->warehouse_id)
                                                 ->get();

                    foreach ($archive_item as $key4 => $value4) 
                    {
                        $qty = Tbl_warehouse_inventory::where("inventory_item_id",$value4->item_id)
                                                            ->where("warehouse_id",$value3->warehouse_id)
                                                            ->sum("inventory_count");

                        $selling_price_a += $value4->item_price * $qty;
                        $cost_price_a += $value4->item_cost * $qty;
                    }
                    $data["_warehouse_archived"][$key3]->total_selling_price = $selling_price_a;
                    $data["_warehouse_archived"][$key3]->total_cost_price = $cost_price_a;
                }
            }

            $this->create_main();

            return view("member.warehouse.warehouse_list",$data);
        }
        else
        {
            return $this->show_no_access();
        }
        // $data['warehouse'] = Warehouse::get_transfer_warehouse_information(225, 226);
        // dd($data);
        // $count_on_hand = Tbl_warehouse_inventory::check_inventory_single(1, 28)->pluck('inventory_count');
        // dd($count_on_hand);

    }
    public function load_warehouse()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            if(Request::input("id"))
            {
                $data = Tbl_user_warehouse_access::join("tbl_warehouse","tbl_warehouse.warehouse_id","=","tbl_user_warehouse_access.warehouse_id")->where("user_id",$this->user_info->user_id)->where("archived",0)->where("tbl_warehouse.warehouse_id","!=",Request::input("id"))->get();
            }
            else
            {
                $data = Tbl_user_warehouse_access::join("tbl_warehouse","tbl_warehouse.warehouse_id","=","tbl_user_warehouse_access.warehouse_id")->where("user_id",$this->user_info->user_id)->where("archived",0)->get();
            }

            return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function confirm_serial()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            return view('member.warehouse.confirm_serial');
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function confirm_serial_submit()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $answer = Request::input("answer");

            $items = Session::get("item");
            $data = null;
            $data["item_id"] = isset($items["item_id"]) ? $items["item_id"] : '';   

            if($answer == "yes")
            {            
                $up["has_serial_number"] = 1;
                foreach ($items["item_list"] as $key1 => $value1) 
                {
                    Tbl_item::where("item_id",$key1)->update($up);                
                }
                $data["status"] = "confirmed-serial";
            }
            else
            {
                Session::forget("item");
                $data["status"] = "success";
                $data['message'] = 'Success';
                $data["type"]    = "item";
            }
            
            return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function add_serial_number()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $items = Session::get("item");
            $data["items"] = null;
            foreach ($items["item_list"] as $key => $value) 
            {
                $data["items"][$key] = Tbl_item::where("item_id",$key)->first();
                $data["items"][$key]->quantity = $value["quantity"]; 
                $data["items"][$key]->inventory_id = $value["inventory_id"]; 
            }

            return view('member.warehouse.add_serial',$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function add_serial_number_submit()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $inventory = Request::input("inventory_id");
            $quantity = Request::input("quantity");
            $serials = Request::input("serial");
            $item_id = Request::input("item_id");
     
            $count = 1;
            $id = null;
            $insert = null;
            $duplicate_serial = null;

            $data["status"] = null;
            $data["status_message"] = null;
            foreach ($item_id as $key => $value) 
            {
                if($value == $id)
                {                
                    $count ++;
                }
                else
                {
                    $count = 1;
                }

                $insert[$key]["inventory_id"] = $inventory[$value];
                $insert[$key]["item_id"] = $value;
                $insert[$key]["serial_number"] = strtoupper($serials[$key]);
                $insert[$key]["serial_created"] = Carbon::now();
                $insert[$key]["item_count"] = $count;
                $id = $value;


                $rules[$key]["serial_number"] = 'required|alpha_num|unique:tbl_inventory_serial_number,serial_number';

                $validator[$key] = Validator::make($insert[$key],$rules[$key]);

                if($validator[$key]->fails())
                {
                  $data["status"] = "error";
                    foreach ($validator[$key]->messages()->all('<li style="list-style:none">:message</li>') as $keys => $message)
                    {
                        $data["status_message"] .= $message . " ".$insert[$key]["serial_number"];
                    }
                }
                else
                {
                    if($this->array_is_unique($serials) == false)
                    {
                        $duplicate_serial = $serials[$key];
                        $data["status"] = "error";
                        $data["status_message"] = "<li style='list-style:none'> This ".$duplicate_serial." serial number is ducplicate to your entry.</li>";
                    }
                    else
                    {
                        if($serials[$key] == null)
                        {
                            $data["status"] = "error";
                            $data["status_message"] = "The Serial Number is required";
                        }  
                    }

                }
            }

            if($data["status"] == null)
            {        
                $items = Session::get("item");
                $data["item_id"] = $items["item_id"];
                $data["type"]    = "item";
                $data["status"] = "success-adding-serial";
                Tbl_inventory_serial_number::insert($insert);
                Session::forget("item");
            }

            return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }

    }
    public static function array_is_unique($array)
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            return array_unique($array) == $array;
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function view($id)
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$id)->first();
            if(!$check_if_owned)
            {
                return $this->show_no_access_modal();
            }
            $data["warehouse"] = Tbl_warehouse::where("warehouse_id",$id)->first();
            $data["warehouse_item"] = Warehouse::select_item_warehouse_single($id,'array');
            // dd($data["warehouse_item"]);

            return view("member.warehouse.warehouse_view",$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function refill()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $id = Request::input("warehouse_id");
            $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$id)->first();
            if(!$check_if_owned)
            {
                return $this->show_no_access_modal();
            }
            $data["warehouse"] = Tbl_warehouse::where("warehouse_id",$id)->first();
            
            $data["warehouse_item"] = Warehouse::select_item_warehouse_single($id,'array');
            
            $data["_cat"] = Tbl_category::where("type_category","inventory")->where("type_parent_id",0)
                                                                            ->where("type_shop",$this->user_info->shop_id)
                                                                            ->get();
            return view("member.warehouse.warehouse_refill",$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public static function check_if_critical($c_stock, $reorder_point)
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $color = "";
            if($c_stock <= $reorder_point)
            {
                $color = "red";
            }
            return $color;
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function create_main()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $warehouse = Tbl_warehouse::get();

            if($warehouse == null)
            {
                //MAKE MAIN WAREHOUSE
                $ins_warehouse["warehouse_name"] = "Main Warehouse";
                $ins_warehouse["warehouse_shop_id"] = $this->user_info->shop_id;
                $ins_warehouse["warehouse_created"] = Carbon::now();
                $ins_warehouse["main_warehouse"] = 1;

                Tbl_warehouse::insert($ins_warehouse);
            }
        }
        else
        {
            return $this->show_no_access();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
           $data["_item"] = Tbl_item::where("archived",0)->where("item_type_id",1)->where("shop_id",$this->user_info->shop_id)->get();
           // $data["_cat"] = Tbl_category::where("type_category","inventory")->where("type_parent_id",0)->where("type_shop",$this->user_info->shop_id)->get();
           return view("member.warehouse.warehouse_add",$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function load_item()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $data = Tbl_item::where("archived",0)->where("item_type_id",1)->where("shop_id",$this->user_info->shop_id)->get();

            if(Session::get("item_id") != null)
            {
                $_item_id = Session::get("item_id");
                foreach ($_item_id as $key => $value) 
                {
                    $_item_id[$key] = $value;
                }
            }
            // $item_id = Request::input("item_id");
            // foreach ($data as $key => $value) 
            // {
            //     if($value == $item_id)
            //     {

            //     }    
            // }
            return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function archived($warehouse_id)
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$warehouse_id)->first();
            if(!$check_if_owned)
            {
                return $this->show_no_access_modal();
            }
            $shop_id               = $this->user_info->shop_id;
            $data["page"]          = "Warehouse";
            $data["warehouse"]          = Tbl_warehouse::inventory()
                                                        ->selectRaw('*, sum(tbl_warehouse_inventory.inventory_count) as total_qty')
                                                        ->where("tbl_warehouse.warehouse_id",$warehouse_id)
                                                        ->where("tbl_warehouse.warehouse_shop_id",$shop_id)
                                                        ->first();

            $selling_price = 0;
            $cost_price = 0;
            $all_item = Tbl_sub_warehouse::join("tbl_warehouse","tbl_warehouse.warehouse_id","=","tbl_sub_warehouse.warehouse_id")
                                             ->join("tbl_item","tbl_item.item_id","=","tbl_sub_warehouse.item_id")
                                             ->where("tbl_sub_warehouse.warehouse_id",$warehouse_id) 
                                             ->get();

            foreach ($all_item as $key2 => $value2) 
            {
                $qty = Tbl_warehouse_inventory::where("inventory_item_id",$value2->item_id)
                                                    ->where("warehouse_id",$warehouse_id)
                                                    ->sum("inventory_count");

                $selling_price += $value2->item_price * $qty;
                $cost_price += $value2->item_cost * $qty;
            }
            $data["warehouse"]->total_selling_price = $selling_price;
            $data["warehouse"]->total_cost_price = $cost_price;

            if(!$data["warehouse"])
            {
                dd("Please try again.");
            }
            return view('member.warehouse.warehouse_confirm_archived',$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function restore($warehouse_id)
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $shop_id               = $this->user_info->shop_id;
            $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$warehouse_id)->first();
            if(!$check_if_owned)
            {
                return $this->show_no_access_modal();
            }
            $data["page"]          = "Warehouse";
            $data["warehouse"]     = Tbl_warehouse::inventory()
                                                        ->selectRaw('*, sum(tbl_warehouse_inventory.inventory_count) as total_qty')
                                                        ->where("tbl_warehouse.warehouse_id",$warehouse_id)
                                                        ->where("tbl_warehouse.warehouse_shop_id",$shop_id)
                                                        ->first();

            $selling_price = 0;
            $cost_price = 0;
            $all_item = Tbl_sub_warehouse::join("tbl_warehouse","tbl_warehouse.warehouse_id","=","tbl_sub_warehouse.warehouse_id")
                                             ->join("tbl_item","tbl_item.item_id","=","tbl_sub_warehouse.item_id")
                                             ->where("tbl_sub_warehouse.warehouse_id",$warehouse_id) 
                                             ->get();

            foreach ($all_item as $key2 => $value2) 
            {
                $qty = Tbl_warehouse_inventory::where("inventory_item_id",$value2->item_id)
                                                    ->where("warehouse_id",$warehouse_id)
                                                    ->sum("inventory_count");

                $selling_price += $value2->item_price * $qty;
                $cost_price += $value2->item_cost * $qty;
            }
            $data["warehouse"]->total_selling_price = $selling_price;
            $data["warehouse"]->total_cost_price = $cost_price;

            if(!$data["warehouse"])
            {
                dd("Please try again.");
            }
            return view('member.warehouse.warehouse_restore',$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function refill_submit()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $warehouse_id = Request::input("warehouse_id");
            $remarks = Request::input("remarks");
            $reason_refill = Request::input("reason_refill");
            $refill_source = 0;
            $quantity_product = Request::input("quantity");

            $warehouse_refill_product = null;
            foreach ($quantity_product as $key => $value) 
            {
                if($value != 0)
                {
                    $warehouse_refill_product[$key]['product_id'] = $key;
                    $warehouse_refill_product[$key]['quantity'] = str_replace(",","",$value);                
                }
            }

            $data = Warehouse::inventory_refill($warehouse_id, $reason_refill, $refill_source, $remarks, $warehouse_refill_product,'json');

            return $data;
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function restore_submit()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $shop_id    = $this->user_info->shop_id;
            $id         = Request::input("warehouse_id");
            $warehouse  = Tbl_warehouse::where("warehouse_id",$id)->where("warehouse_shop_id",$shop_id)->first();
            if($warehouse)
            {
                   $update["archived"] = 0;
                   Tbl_warehouse::where("warehouse_id",$id)->update($update);
                   $return["error"][0]  = "Successfully restore";
                   $return["status"]   = "Sucess-restore";
            }
            else
            {
                $return["error"][0]  = "Please try again";
                $return["status"]   = "Failed";
            }

            return json_encode($return);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function archived_submit()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $shop_id    = $this->user_info->shop_id;
            $id         = Request::input("warehouse_id");
            $warehouse  = Tbl_warehouse::where("warehouse_id",$id)->where("warehouse_shop_id",$shop_id)->first();
            if($warehouse->main_warehouse != 1 )
            {
                if($warehouse)
                {
                       $update["archived"] = 1;
                       Tbl_warehouse::where("warehouse_id",$id)->update($update);
                       $return["error"][0]  = "Successfully archived";
                       $return["status"]   = "Sucess-archived";
                }
                else
                {
                    $return["error"][0]  = "Please try again";
                    $return["status"]   = "Failed";
                }            
            }
            else
            {
                $return["error"][0]  = "You cannot Delete the Main Warehouse";
                $return["status"]   = "Failed";
            }

            return json_encode($return);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function select_item()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            // Session::forget('item_id');
            $item_id = Request::input("item_id");

            // $item["item"] = $item_id;
            $item = array();
            if(Session::has("item_id")){
                $item = Session::get("item_id");
                // dd("meron");
            }
            
            $space = '';
            if (!in_array($item_id, $item))
            {     
                array_push($item, $item_id);
            }
            Session::put("item_id",$item);
            Session::save();

            $data = Tbl_item::where("item_id",$item_id)->first();
            
            return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function add_submit()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            //INSERT TO tbl_warehouse
            $ins_warehouse["warehouse_name"] = Request::input("warehouse_name");
            $ins_warehouse["warehouse_address"] = Request::input("warehouse_address");
            $ins_warehouse["warehouse_shop_id"] = $this->user_info->shop_id;
            $ins_warehouse["warehouse_created"] = Carbon::now();

            $id = Tbl_warehouse::insertGetId($ins_warehouse);

            //INSERT tbl_warehouse per item reorderpoint
            $reorderpoint = Request::input("reoder_point");
            foreach ($reorderpoint as $key => $value) 
            {
                $check = Tbl_sub_warehouse::where("item_id",$key)->where("warehouse_id",$id)->first();
                if($check == null)
                {
                    $ins_sub["warehouse_id"] = $id;
                    $ins_sub["item_id"] = $key;
                    $ins_sub["item_reorder_point"] = str_replace(",","",$value);

                    Tbl_sub_warehouse::insert($ins_sub);
                }
            }
            //TRANSFER INVENTORY From MAIN to NEW warehouse 
            $quantity = Request::input("quantity");
            foreach($quantity as $key => $value)
            {
                $ins_inventory["inventory_item_id"] = $key;
                $ins_inventory["warehouse_id"] = $id;
                $ins_inventory["inventory_created"] = Carbon::now();  
                $ins_inventory["inventory_count"] = str_replace(",","",$value);

                $inventory_id = Tbl_warehouse_inventory::insertGetId($ins_inventory);

                $for_serial_item[$key]["quantity"] = str_replace(",","",$value);
                $for_serial_item[$key]["product_id"] = $key;
                $for_serial_item[$key]["inventory_id"] = $inventory_id;       
            }

                $items["item_id"] = "";
                $items["item_list"] = $for_serial_item;


            $serial = Tbl_settings::where("settings_key","item_serial")->where("settings_value","enable")->where("shop_id",$this->user_info->shop_id)->first();
            if($serial != null)
            {
                $data['status'] = 'success-serial';
                Session::put("item", $items);
            }
            else
            {
                $data['status'] = 'success';
            }

             return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function edit($id)
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $check_if_owned = Tbl_user_warehouse_access::where("user_id",$this->user_info->user_id)->where("warehouse_id",$id)->first();
            if(!$check_if_owned)
            {
                return $this->show_no_access_modal();
            }
            $data["_item"] = Tbl_item::where("archived",0)->where("item_type_id",1)->where("shop_id",$this->user_info->shop_id)->get();
            $data["warehouse"] = Tbl_warehouse::where("warehouse_id",$id)->first();

            $data["warehouse_item"] = Tbl_warehouse::warehouseitem()
                                                    ->selectRaw('*, tbl_sub_warehouse.item_reorder_point as sub_reorder_point')
                                                    ->where("tbl_sub_warehouse.warehouse_id",$id)
                                                    ->groupBy("tbl_sub_warehouse.item_id")
                                                    ->get();
            foreach ($data["warehouse_item"] as $key => $value) 
            {
                $qty = Tbl_warehouse_inventory::where("inventory_item_id",$value->item_id)
                                              ->where("warehouse_id",$id)
                                              ->sum("inventory_count");
                $data["warehouse_item"][$key]->item_qty = $qty;
            }
     
            return view("member.warehouse.warehouse_edit",$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function edit_submit()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $up_warehouse["warehouse_name"] = Request::input("warehouse_name");
            $up_warehouse["warehouse_address"] = Request::input("warehouse_address");
            $up_warehouse["warehouse_shop_id"] = $this->user_info->shop_id;
            // $up_warehouse["warehouse_created"] = Carbon::now();

            Tbl_warehouse::where("warehouse_id",Request::input("warehouse_id"))->update($up_warehouse);

            //EDIT tbl_warehouse per item reorderpoint
            $reorderpoint = Request::input("reoder_point");
            $quantity = Request::input("quantity");

            // dd($reorderpoint);
            foreach ($reorderpoint as $key => $value) 
            {
                $up_sub["warehouse_id"] = Request::input("warehouse_id");
                $up_sub["item_id"] = $key;
                $up_sub["item_reorder_point"] = str_replace(",","",$value);

                $sub = Tbl_sub_warehouse::where("item_id",$key)->where("warehouse_id",Request::input("warehouse_id"))->first();
                if($sub)
                {
                    Tbl_sub_warehouse::where("item_id",$key)->where("warehouse_id",Request::input("warehouse_id"))->update($up_sub);                
                }
                else
                {
                    Tbl_sub_warehouse::insert($up_sub);
                    
                    $ins_inventory["inventory_item_id"] = $key;
                    $ins_inventory["warehouse_id"] = Request::input("warehouse_id");
                    $ins_inventory["inventory_created"] = Carbon::now();            
                    $ins_inventory["inventory_count"] = $quantity[$key];

                    Tbl_warehouse_inventory::insert($ins_inventory);
                }
            }
            //CREATE INVENTORY From warehouse 
            // foreach($quantity as $key => $value)
            // {          
            //     $ins_inventory["inventory_item_id"] = $key;
            //     $ins_inventory["warehouse_id"] = Request::input("warehouse_id");
            //     $ins_inventory["inventory_created"] = Carbon::now();            
            //     $ins_inventory["inventory_count"] = $value;

            //     Tbl_warehouse_inventory::insert($ins_inventory);

            // }

             $data['status'] = 'success';

             return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function transferinventory()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
           // $data = Tbl_user_warehouse_access::join("tbl_warehouse","tbl_warehouse.warehouse_id","=","tbl_user_warehouse_access.warehouse_id")->where("user_id",$this->user_info->user_id)->where("archived",0)->get();
           $data["warehouse"] = Tbl_warehouse::where("archived",0)->where("warehouse_shop_id",$this->user_info->shop_id)->get();
           return view("member.warehouse.warehouse_transfer",$data);
        }
        else
        {
            return $this->show_no_access_modal();
        }
    }
    public function transferinventory_submit()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $from = Request::input("inventory_from");
            $to = Request::input("inventory_to");
            if($from != null && $to != null)
            {
                $data["from"] = Tbl_warehouse::where("archived",0)->where("warehouse_id",$from)->first();
                $data["to"] = Tbl_warehouse::where("archived",0)->where("warehouse_id",$to)->first();

                Warehouse::insert_item($from,$to);

                $count = Tbl_sub_warehouse::where("warehouse_id",$to)->get();
                $ctr = 0;
                foreach ($count as $key => $value) 
                { 
                  $qty_item = Tbl_warehouse_inventory::where("warehouse_id",$to)->where("inventory_item_id",$value->item_id)->sum("inventory_count");
                
                  if($qty_item <= $value->item_reorder_point)
                  {
                    $ctr = $ctr + 1; 
                  }
                }

                $data["ctr"] = $ctr;
                
                $data["warehouse_list"] = Warehouse::get_transfer_warehouse_information($from, $to,'array');

                return view("member.warehouse.warehouse_transferring",$data);
            }
            else
            {
                return Redirect("/member/item/warehouse");
            }
        }
        else
        {
            return $this->show_no_access();
        }
        
    }
    public function transfer_submit()
    {
        $access = Utilities::checkAccess('item-warehouse', 'access_page');
        if($access == 1)
        { 
            $from = Request::input("warehouse_from");
            $to = Request::input("warehouse_to");

            $remarks = Request::input("remarks");
            $quantity_product = Request::input("quantity");

            foreach ($quantity_product as $key => $value) 
            {
                $info[$key]['product_id'] = $key;
                $info[$key]['quantity'] = str_replace(",","",$value);
            }

            $data = Warehouse::inventory_transfer_bulk($from, $to, $info, $remarks, 'json');
            
            return json_encode($data);
        }
        else
        {
            return $this->show_no_access();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
