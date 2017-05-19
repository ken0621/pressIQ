<?php

namespace App\Http\Controllers\Member;
use App\Models\Tbl_customer;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_credit_memo_line;
use App\Models\Tbl_debit_memo;
use App\Models\Tbl_item;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_debit_memo_line;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_unit_measurement_multi;
use App\Models\Tbl_user;
use App\Models\Tbl_debit_memo_replace_line;
use App\Globals\Item;
use App\Globals\UnitMeasurement;
use App\Globals\Customer;
use App\Globals\Vendor;
use App\Globals\DebitMemo;
use App\Globals\Warehouse;
use App\Globals\Utilities;
use App\Http\Controllers\Controller;
use Request;

class DebitMemoController extends Member
{
    public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $access = Utilities::checkAccess('vendor-debit-memo', 'access_page');
        if($access == 1)
        { 
            $data["page"]       = "Debit Memo";
            $data["_vendor"]    = Vendor::getAllVendor('active');
            $data['_item']      = Item::get_all_category_item();
            $data['_um']        = UnitMeasurement::load_um_multi();
            $data["action"]     = "/member/vendor/debit_memo/create_submit";

            $id = Request::input('id');
            if($id)
            {
                $data["db"]            = Tbl_debit_memo::where("db_id", $id)->first();
                $data["_dbline"]       = Tbl_debit_memo_line::um()->where("dbline_db_id", $id)->get();
                $data["action"]         = "/member/vendor/debit_memo/update";
            }

            return view("member.vendor.debit_memo.debit_memo_add",$data);
        }
        else
        {
            return $this->show_no_access();
        }
    }
    public function create_submit()
    {
        $vendor_info[] = null;
        $vendor_info["db_vendor_id"] = Request::input("db_vendor_id");
        $vendor_info["db_vendor_email"] = Request::input("db_vendor_email");
        $vendor_info["db_date"] = datepicker_input(Request::input("db_date"));
        $vendor_info["db_message"] = Request::input("db_message");
        $vendor_info["db_memo"] = Request::input("db_memo");
        $vendor_info["db_amount"] = Request::input("overall_price");

        $item_info[] = null;
        $ctr_items = 0;
        $product_consume = [];
        $_items = Request::input("dbline_item_id");
        foreach ($_items as $key => $value) 
        {   
            if($value)
            {
                $ctr_items++;
                $item_info[$key]['item_service_date']  = datepicker_input(Request::input('dbline_service_date')[$key]);
                $item_info[$key]['item_id']            = Request::input('dbline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('dbline_description')[$key];
                $item_info[$key]['um']                 = Request::input('dbline_um')[$key];
                $item_info[$key]['quantity']           = str_replace(',', "",Request::input('dbline_qty')[$key]);
                $item_info[$key]['rate']               = str_replace(',', "", Request::input('dbline_rate')[$key]);
                $item_info[$key]['amount']             = str_replace(',', "", Request::input('dbline_amount')[$key]);

                // $item_type = Tbl_item::where("item_id",Request::input('dbline_item_id')[$key])->pluck("item_type_id");
                // if($item_type == 4 || $item_type == 1)
                // {
                //     $um_qty = UnitMeasurement::um_qty(Request::input("dbline_um")[$key]);
                //     $product_consume[$key]["quantity"] = $um_qty * $item_info[$key]['quantity'];
                //     $product_consume[$key]["product_id"] = Request::input('dbline_item_id')[$key];
                // }
            }
        }

        //START if bundle inventory_consume arcy
        // foreach ($_items as $keyitem => $value_item) 
        // {
        //     $item_bundle_info = Tbl_item::where("item_id",Request::input("dbline_item_id")[$keyitem])->where("item_type_id",4)->first();
        //     if($item_bundle_info)
        //     {
        //         $bundle = Tbl_item_bundle::where("bundle_bundle_id",Request::input("dbline_item_id")[$keyitem])->get();
        //         foreach ($bundle as $key_bundle => $value_bundle) 
        //         {
        //             $qty = UnitMeasurement::um_qty(Request::input("dbline_um")[$keyitem]);
        //             $bundle_qty = UnitMeasurement::um_qty($value_bundle->bundle_um_id);
        //             $_bundle[$key_bundle]['product_id'] = $value_bundle->bundle_item_id;
        //             $_bundle[$key_bundle]['quantity'] = (str_replace(',', "",Request::input('dbline_qty')[$keyitem]) * $qty) * ($value_bundle->bundle_qty * $bundle_qty);

        //             array_push($product_consume, $_bundle[$key_bundle]);
        //         }
        //     } 
        // }
        // foreach ($product_consume as $key_items => $value_items) 
        // {
        //      $i = null;
        //      foreach ($_items as $keyitemline => $valueitemline)
        //      {
        //         $type = Tbl_item::where("item_id",Request::input("dbline_item_id")[$keyitemline])->pluck("item_type_id");
        //         if($type == 4)
        //         {
        //             if(Request::input("dbline_item_id")[$keyitemline] == $value_items['product_id'])
        //             {
        //                 $i = "true";
        //             }                    
        //         }
        //      }
        //     if($i != null)
        //     {
        //         unset($product_consume[$key_items]);
        //     }           
        // }

        // $data["status"] = null;
        // $data["status_message"] = null;

        // $warehouse_id       = $this->current_warehouse->warehouse_id;
        // if(count($product_consume) > 0)
        // {
        //     foreach ($product_consume as $key => $value) 
        //     {
        //        $inventory_consume_product[$key]["product_id"] = $value["product_id"];
        //        $inventory_consume_product[$key]["quantity"] = $value["quantity"];

        //        $count_on_hand = Tbl_warehouse_inventory::check_inventory_single($warehouse_id, $value["product_id"])->pluck('inventory_count');
        //         if($count_on_hand == null)
        //         {
        //             $count_on_hand = 0;   
        //         }
        //         if($value['quantity'] > 0 && $count_on_hand > 0 && $count_on_hand >= $value['quantity'])
        //         {

        //         }
        //         else
        //         {
        //             $item_name = Tbl_item::where("item_id",$value["product_id"])->pluck("item_name");

        //             $data["status"] = "error";
        //             $data["status_message"] .= "<li style='list-style:none'>The quantity of item ".$item_name." is not enough to consume </li>";
        //         }
        //     }                
        // }


        if($ctr_items != 0)
        {
            if($data["status"] == null)
            {
                $db_id = DebitMemo::postdb($vendor_info, $item_info);

                $data["status"] = "success-debit-memo";
                $data["redirect_to"] = "/member/vendor/debit_memo?id=".$db_id;
            }         
        }
        else
        {
            $data["status"] = "error";
            $data["status_message"] = "Please Insert Items";
        }

        return json_encode($data);
    }
    public function update_submit()
    {
        $db_id = Request::input("debit_memo_id");

        $vendor_info[] = null;
        $vendor_info["db_vendor_id"] = Request::input("db_vendor_id");
        $vendor_info["db_vendor_email"] = Request::input("db_vendor_email");
        $vendor_info["db_date"] = datepicker_input(Request::input("db_date"));
        $vendor_info["db_message"] = Request::input("db_message");
        $vendor_info["db_memo"] = Request::input("db_memo");
        $vendor_info["db_amount"] = Request::input("overall_price");

        $item_info[] = null;
        $product_consume = [];
        $_items = Request::input("dbline_item_id");
        $ctr_items = 0;
        foreach ($_items as $key => $value) 
        {
            if($value)
            {
                $ctr_items++;
                $item_info[$key]['item_service_date']  = datepicker_input(Request::input('dbline_service_date')[$key]);
                $item_info[$key]['item_id']            = Request::input('dbline_item_id')[$key];
                $item_info[$key]['item_description']   = Request::input('dbline_description')[$key];
                $item_info[$key]['um']                 = Request::input('dbline_um')[$key];
                $item_info[$key]['quantity']           = str_replace(',', "",Request::input('dbline_qty')[$key]);
                $item_info[$key]['rate']               = str_replace(',', "", Request::input('dbline_rate')[$key]);
                $item_info[$key]['amount']             = str_replace(',', "", Request::input('dbline_amount')[$key]);

                // $item_type = Tbl_item::where("item_id",Request::input('dbline_item_id')[$key])->pluck("item_type_id");
                // if($item_type == 4 || $item_type == 1)
                // {
                //     $um_qty = UnitMeasurement::um_qty(Request::input("dbline_um")[$key]);
                //     $product_consume[$key]["quantity"] = $um_qty * $item_info[$key]['quantity'];
                //     $product_consume[$key]["product_id"] = Request::input('dbline_item_id')[$key];
                // }
            }     
        }


        //START if bundle inventory_consume arcy
        // foreach ($_items as $keyitem => $value_item) 
        // {
        //     $item_bundle_info = Tbl_item::where("item_id",Request::input("dbline_item_id")[$keyitem])->where("item_type_id",4)->first();
        //     if($item_bundle_info)
        //     {
        //         $bundle = Tbl_item_bundle::where("bundle_bundle_id",Request::input("dbline_item_id")[$keyitem])->get();
        //         foreach ($bundle as $key_bundle => $value_bundle) 
        //         {
        //             $qty = UnitMeasurement::um_qty(Request::input("dbline_um")[$keyitem]);
        //             $bundle_qty = UnitMeasurement::um_qty($value_bundle->bundle_um_id);
        //             $_bundle[$key_bundle]['product_id'] = $value_bundle->bundle_item_id;
        //             $_bundle[$key_bundle]['quantity'] = (str_replace(',', "",Request::input('dbline_qty')[$keyitem]) * $qty) * ($value_bundle->bundle_qty * $bundle_qty);

        //             array_push($product_consume, $_bundle[$key_bundle]);
        //         }
        //     } 
        // }
        // foreach ($product_consume as $key_items => $value_items) 
        // {
        //      $i = null;
        //      foreach ($_items as $keyitemline => $valueitemline)
        //      {
        //         $type = Tbl_item::where("item_id",Request::input("dbline_item_id")[$keyitemline])->pluck("item_type_id");
        //         if($type == 4)
        //         {
        //             if(Request::input("dbline_item_id")[$keyitemline] == $value_items['product_id'])
        //             {
        //                 $i = "true";
        //             }                    
        //         }
        //      }
        //     if($i != null)
        //     {
        //         unset($product_consume[$key_items]);
        //     }           
        // }

        // $data["status"] = null;
        // $data["status_message"] = null;

        // $transaction_id = $db_id;
        // $transaction_type = "debit_memo";
        // $warehouse_id       = Warehouse::getWarehouseIdFromSlip($transaction_id, $transaction_type);
        // if(count($product_consume) > 0)
        // {
        //     foreach ($product_consume as $key => $value) 
        //     {
        //        $inventory_consume_product[$key]["product_id"] = $value["product_id"];
        //        $inventory_consume_product[$key]["quantity"] = $value["quantity"];

        //        $count_on_hand = Tbl_warehouse_inventory::check_inventory_single($warehouse_id, $value["product_id"])->pluck('inventory_count');
        //         if($count_on_hand == null)
        //         {
        //             $count_on_hand = 0;   
        //         }
        //         if($value['quantity'] > 0 && $count_on_hand + $value['quantity'] > 0 && $count_on_hand + $value['quantity'] >= $value['quantity'])
        //         {

        //         }
        //         else
        //         {
        //             $item_name = Tbl_item::where("item_id",$value["product_id"])->pluck("item_name");

        //             $data["status"] = "error";
        //             $data["status_message"] .= "<li style='list-style:none'>The quantity of item ".$item_name." is not enough to consume </li>";
        //         }
        //     }                
        // }

        if($ctr_items != 0)
        {
            if($data["status"] == null)
            {
                DebitMemo::updatedb($db_id, $vendor_info, $item_info);
                // if(count($product_consume) > 0)
                // {
                //     $data = Warehouse::inventory_update($transaction_id, $transaction_type, $product_consume, $return = 'array');
                // }
                $data["status"] = "success-debit-memo";
                $data["redirect_to"] = "/member/vendor/debit_memo?id=".$db_id;
            }
        }
        else
        {
            $data["status"] = "error";
            $data["status_message"] = "Please Insert Items";            
        }

        return json_encode($data);
    }
    public function db_list()
    {        
        $access = Utilities::checkAccess('vendor-debit-memo', 'access_page');
        if($access == 1)
        { 
            $data["_db"] = Tbl_debit_memo::vendor()->where("vendor_shop_id", $this->getShopId())->orderBy("tbl_debit_memo.db_id","DESC")->get();

            foreach ($data["_db"] as $key => $value) 
            {
                $replace_amount = 0;
                $dbline = Tbl_debit_memo_line::replace_dbitem()->db_item()->where("dbline_db_id",$value->db_id)->get();
                foreach ($dbline as $keydb => $valuedb) 
                {
                    $replace_amount += $valuedb->dbline_replace_amount;
                }
                $data["_db"][$key]->db_amount = $value->db_amount - $replace_amount;
            }

            return view("member.vendor.debit_memo.db_list",$data);
        }
        else
        {
            return $this->show_no_access();
        }        
    }
    public function replace($debit_memo_id)
    {
        $data["debit_memo_id"] = $debit_memo_id;
        $data["_db_item"] = Tbl_debit_memo_line::replace_dbitem()->db_item()->where("dbline_db_id",$debit_memo_id)->get();

        $data["_vendor"]    = Vendor::getAllVendor('active');
        $data['_item']      = Item::get_all_category_item();
        $data['_um']        = UnitMeasurement::load_um_multi();

        $data["db"]            = Tbl_debit_memo::where("db_id", $debit_memo_id)->first();
        $data["_dbline"]       = Tbl_debit_memo_line::um()->where("dbline_db_id", $debit_memo_id)->get();


        $data["action"] = "/member/vendor/debit_memo/save_replace_submit";

        foreach($data["_db_item"] as $key => $value) 
        {
            $um_qty = UnitMeasurement::um_qty($value->dbline_um);
            $data["_db_item"][$key]->dbline_qty_um = UnitMeasurement::um_view($um_qty * $value->dbline_qty,$value->item_measurement_id,$value->dbline_um);


            $data["_db_item"][$key]->dbline_replace_qty_um = UnitMeasurement::um_view($value->dbline_replace_qty,$value->item_measurement_id,$value->dbline_um);

        }
        return view("member.vendor.debit_memo.debit_memo_replace",$data);
    }
    public function replace_item($dbline_id)
    {
        $data["db_item"] = Tbl_debit_memo_line::replace_dbitem()->db_item()->where("dbline_id",$dbline_id)->first();

        $data["base_name"] = null;
        $data["base_qty"] = null;
        $data["base_um_id"] = null;

        $data["issued_um_qty"] = null;
        $data["issued_um_name"] = null;
        $data["issued_um_id"] = null;

        $um_info = UnitMeasurement::um_info($data["db_item"]->dbline_um);

        if($um_info)
        {
            if($um_info->is_base != 0)
            {
                $data["base_name"] = $um_info->multi_name." (".$um_info->multi_abbrev.")";
                $data["base_qty"] = $data["db_item"]->dbline_qty * UnitMeasurement::um_qty($data["db_item"]->item_measurement_id);
                $data["base_um_id"] = $data["db_item"]->item_measurement_id;
            }
            else
            {
                $total_qty = UnitMeasurement::um_qty($data["db_item"]->dbline_um) * $data["db_item"]->dbline_qty;

                $issued_qty = round($total_qty / UnitMeasurement::um_qty($data["db_item"]->dbline_um));

                $um = UnitMeasurement::um_info($data["db_item"]->item_measurement_id);

                $q = floor($total_qty / UnitMeasurement::um_qty($data["db_item"]->dbline_um)) - $issued_qty;
                $base = round(UnitMeasurement::um_qty($data["db_item"]->dbline_um) * $q);

                $data["base_name"] = $um->multi_name." (".$um->multi_abbrev.")";
                $data["base_qty"] = $base;
                $data["base_um_id"] =$data["db_item"]->dbline_um;

                $data["issued_um_qty"] = $issued_qty;
                $data["issued_um_name"] = $um_info->multi_name." (".$um_info->multi_abbrev.")";
                $data["issued_um_id"] = $data["db_item"]->dbline_um;

            }
        }
        else
        {
           $data["base_qty"] = $data["db_item"]->dbline_qty;
           $data["base_name"] = "Piece(s)";
           $data["base_um_id"] = "";   
        }


        return view("member.vendor.debit_memo.update_replace_item",$data);
    }
    public function replace_submit()
    {        
        $dbline_id = Request::input("dbline_id");

        $dbline_data = Tbl_debit_memo_line::replace_dbitem()->db_item()->where("dbline_id",$dbline_id)->first();

        //example BOX
        $issued_um_id = Request::input("issued_um_id");
        $issued_qty = Request::input("issued_qty");

        //example PIECE
        $base_um_id = Request::input("base_um_id");
        $base_qty = Request::input("base_qty");

        $qty = (UnitMeasurement::um_qty($issued_um_id) * $issued_qty) + $base_qty;

        $db_qty = UnitMeasurement::um_qty($dbline_data->dbline_um) * $dbline_data->dbline_qty;

        if($qty <= $db_qty)
        {
            $chck = Tbl_debit_memo_replace_line::where("dbline_replace_dbline_id",$dbline_id)->first();

            $rate = ($dbline_data->dbline_rate / UnitMeasurement::um_qty($issued_um_id)) * UnitMeasurement::um_qty($issued_um_id);
            if($qty < UnitMeasurement::um_qty($issued_um_id))
            {
                $rate = $dbline_data->dbline_rate / UnitMeasurement::um_qty($issued_um_id);
            }

            if($chck)
            {
                $up["dbline_replace_qty"] = $qty;
                $up["dbline_replace_rate"] = $rate;
                $up["dbline_replace_item_id"] = $dbline_data->dbline_item_id;
                $up["dbline_replace_amount"] = ($dbline_data->dbline_rate/UnitMeasurement::um_qty($issued_um_id)) * $qty;
                $total_amount = $dbline_data->dbline_amount - $up["dbline_replace_amount"];
                $up["dbline_replace_status"] = 0;
                if($total_amount > 0)
                {
                    $up["dbline_replace_status"] = 1;
                }

                Tbl_debit_memo_replace_line::where("dbline_replace_dbline_id",$dbline_id)->update($up);

            }
            else
            {   
                $ins["dbline_replace_qty"] = $qty;
                $ins["dbline_replace_dbline_id"] = $dbline_id;
                $ins["dbline_replace_item_id"] = $dbline_data->dbline_item_id;
                $ins["dbline_replace_rate"] = $rate;
                $ins["dbline_replace_amount"] = ($dbline_data->dbline_rate/UnitMeasurement::um_qty($issued_um_id)) * $qty;
                $total_amount = $dbline_data->dbline_amount - $ins["dbline_replace_amount"];
                if($total_amount > 0)
                {
                    $ins["dbline_replace_status"] = 1;
                }

                Tbl_debit_memo_replace_line::insert($ins);
            }

            $return["status"] = "success-db-replace";
            $return["id"] = $dbline_data->dbline_db_id;            
        }
        else
        {
            $return["status"] = "error";
            $return["status_message"] = "The replace quantity must not grater than the issued quantity on Debit Memo.";
        }

        return $return;

    }
    public function save_replace_submit()
    {
        $db_id = Request::input("debit_memo_id");

        $db_data = Tbl_debit_memo_line::replace_dbitem()->db_item()->where("dbline_db_id",$db_id)->get();

        $ctr_condemned = 0;
        foreach ($db_data as $key => $value) 
        {
            if($value->dbline_replace_status == 1)
            {
                $ctr_condemned ++;
            }
        }

        if($ctr_condemned > 0)
        {
            $return["status"] = "msg-popup-condemned";
            $return["dbid"] = $db_id;
        }
        else
        {
            $return["status"] = "msg-popup-replace";
            $return["dbid"] = $db_id;            
        }

        return $return;
    }
    public function confirm_condemned($db_id, $action = '')
    {
        $db_data = Tbl_debit_memo::where("db_id",$db_id)->first();
    
        $data["action"] = "/member/vendor/debit_memo/confirm_submit/".$db_id;

        $data["message"] = "Do you really want to ".$action." these item?";

        return view("member.vendor.debit_memo.confirm_debit_memo",$data);
    }
    public function confirm_submit($db_id)
    {
        $dbline_data = Tbl_debit_memo_line::replace_dbitem()->db_item()->where("dbline_db_id",$db_id)->get();
        
        foreach ($dbline_data as $key => $value) 
        {
            $item_type = Tbl_item::where("item_id",$value->dbline_item_id)->pluck("item_type_id");
            if($item_type == 4 || $item_type == 1)
            {
                $um_qty = UnitMeasurement::um_qty($value->dbline_um);
                $product_consume[$key]["quantity"] = ($um_qty * $value->dbline_qty) - $value->dbline_replace_qty;
                $product_consume[$key]["product_id"] = $value->dbline_item_id;
            }
        }

         //START if bundle inventory_consume arcy
        foreach ($dbline_data as $keyitem => $value_item) 
        {
            $item_bundle_info = Tbl_item::where("item_id",$value_item->dbline_item_id)->where("item_type_id",4)->first();
            if($item_bundle_info)
            {
                $bundle = Tbl_item_bundle::where("bundle_bundle_id",$value_item->dbline_item_id)->get();
                foreach ($bundle as $key_bundle => $value_bundle) 
                {
                    $qty = UnitMeasurement::um_qty($value_item->dbline_um);
                    $bundle_qty = UnitMeasurement::um_qty($value_bundle->bundle_um_id);
                    $_bundle[$key_bundle]['product_id'] = $value_bundle->bundle_item_id;
                    $_bundle[$key_bundle]['quantity'] = (($value_item->dbline_qty * $qty) - $value_item->dbline_replace_qty) * ($value_bundle->bundle_qty * $bundle_qty);

                    array_push($product_consume, $_bundle[$key_bundle]);
                }
            } 
        }
        foreach ($product_consume as $key_items => $value_items) 
        {
            $i = null;
            foreach ($dbline_data as $keyitemline => $valueitemline)
            {
                $type = Tbl_item::where("item_id",$value_item->dbline_item_id)->pluck("item_type_id");
                if($type == 4)
                {
                    if($valueitemline->dbline_item_id == $value_items['product_id'])
                    {
                        $i = "true";
                    }                    
                }
            }
            if($i != null)
            {
                unset($product_consume[$key_items]);
            }           
        }

        $data["status"] = null;
        $data["status_message"] = null;

        $warehouse_id       = $this->current_warehouse->warehouse_id;
        if(count($product_consume) > 0)
        {
            foreach ($product_consume as $key => $value) 
            {
               $inventory_consume_product[$key]["product_id"] = $value["product_id"];
               $inventory_consume_product[$key]["quantity"] = $value["quantity"];

               $count_on_hand = Tbl_warehouse_inventory::check_inventory_single($warehouse_id, $value["product_id"])->pluck('inventory_count');
                if($count_on_hand == null)
                {
                    $count_on_hand = 0;   
                }
                if($value['quantity'] > 0 && $count_on_hand > 0 && $count_on_hand >= $value['quantity'])
                {

                }
                else
                {
                    $item_name = Tbl_item::where("item_id",$value["product_id"])->pluck("item_name");

                    $data["status"] = "error";
                    $data["status_message"] .= "<li style='list-style:none'>The quantity of item ".$item_name." is not enough to consume </li>";
                }
            }                
        }

        if($data["status"] == null)
        {
            $db_data = Tbl_debit_memo::where("db_id",$db_id)->first();

            if($db_data->db_memo_status != 1)
            {
                if(count($product_consume) > 0)
                {
                    $remarks            = "Debit Memo Report";
                    $warehouse_id       = $this->current_warehouse->warehouse_id;
                    $transaction_type   = "debit_memo";
                    $transaction_id     = $db_id;
                    $data               = Warehouse::inventory_consume($warehouse_id, $remarks, $product_consume, 0, '' ,  'array', $transaction_type, $transaction_id);

                    $data["status"] = "success-condemned-all";
                }
                else
                {
                    $data["status"] = "success-replace-all";   
                }

                $update["db_memo_status"] = 1;
                Tbl_debit_memo::where("db_id",$db_id)->update($update);

            }
            else
            {
                $transaction_id = $db_id;
                $transaction_type = "debit_memo";
                $warehouse_id       = Warehouse::getWarehouseIdFromSlip($transaction_id, $transaction_type);
                if(count($product_consume) > 0)
                {
                    $data = Warehouse::inventory_update($transaction_id, $transaction_type, $product_consume, $return = 'array');

                    $data["status"] = "success-condemned-all";
                }
                else
                {

                    $data["status"] = "success-replace-all"; 
                }

            }
        }

        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function edit($id)
    {
        //
    }

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
