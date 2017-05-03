<?php
namespace App\Globals;

use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_default_chart_account;
use App\Models\Tbl_shop;
use App\Models\Tbl_warehouse;
use App\Models\Tbl_warehouse_inventory;
use App\Models\Tbl_sub_warehouse;
use App\Models\Tbl_sir_item;
use App\Models\Tbl_sir;
use App\Models\Tbl_truck;
use App\Models\Tbl_employee;
use App\Models\Tbl_user;
use App\Models\Tbl_customer_invoice;
use App\Models\Tbl_sir_inventory;
use App\Models\Tbl_item;
use App\Models\Tbl_credit_memo_line;
use App\Models\Tbl_item_bundle;
use App\Models\Tbl_inventory_slip;
use App\Models\Tbl_sir_cm_item;
use App\Models\Tbl_temp_customer_invoice_line;
use App\Models\Tbl_temp_customer_invoice;
use App\Models\Tbl_manual_invoice;
use App\Models\Tbl_manual_receive_payment;
use App\Models\Tbl_unit_measurement;
use App\Models\Tbl_manual_credit_memo;
use App\Models\Tbl_credit_memo;
use App\Models\Tbl_unit_measurement_multi;
use App\Models\Tbl_settings;
use App\Globals\UnitMeasurement;
use DB;
use Carbon\Carbon;
use Session;
    /*
     * sir_status
     * 0 - new
     * 1 - open
     * 2 - close 


     * ilr_status
     * 0 - new
     * 1 - open
     * 2 - close 
     */
class Purchasing_inventory_system
{
    public static function check()
    {
        $check = Tbl_settings::where("settings_key","pis-jamestiong")->where("settings_value","enable")->where("shop_id",Purchasing_inventory_system::getShopId())->pluck("settings_setup_done");
        return $check;
    }

    public static function get_sir_total_amount($sir_id)
    {

        // $data["_sir"] = Tbl_sir::where("sales_agent_id",$agent_id)->whereIn("ilr_status",[1,2])->get();
        $data['__transaction'] = array();
        if($sir_id)
        {
            //for invoice
            $data["invoices"] = Tbl_manual_invoice::customer_invoice()->where("sir_id",$sir_id)->get(); 

            //union of invoice and receive payment
            foreach ($data["invoices"] as $inv_key => $inv_value) 
            {
                $_transaction = null;
                $cm = Tbl_credit_memo::where("cm_id",$inv_value->credit_memo_id)->first();
                $cm_amt = 0;
                if($cm != null)
                {
                  $cm_amt = $cm->cm_amount;  
                }
                $_transaction[$inv_key]['date'] = $inv_value->inv_date;
                if($inv_value->is_sales_receipt == 0)
                {
                    $_transaction[$inv_key]['type'] = 'Invoice';
                    $_transaction[$inv_key]['reference_name'] = 'invoice';                    
                }
                else
                {                
                    $_transaction[$inv_key]['type'] = 'Sales Receipt';
                    $_transaction[$inv_key]['reference_name'] = 'sales_receipt';
                }
                $_transaction[$inv_key]['customer_name'] = $inv_value->title_name." ".$inv_value->first_name." ".$inv_value->last_name." ".$inv_value->suffix_name;
                $_transaction[$inv_key]['no'] = $inv_value->inv_id;
                $_transaction[$inv_key]['balance'] = $inv_value->inv_overall_price - $inv_value->inv_payment_applied;
                $_transaction[$inv_key]['due_date'] = $inv_value->inv_due_date;
                $_transaction[$inv_key]['total'] = $inv_value->inv_overall_price - $cm_amt;
                $_transaction[$inv_key]['status'] = $inv_value->inv_is_paid;
                $_transaction[$inv_key]['date_created'] = $inv_value->manual_invoice_date;

                array_push($data['__transaction'], $_transaction);
            }
            
            $data["rcv_payment"] = Tbl_manual_receive_payment::customer_receive_payment()->selectRaw("*, tbl_manual_receive_payment.rp_date as manual_rp_date")->where("sir_id",$sir_id)->get();
            foreach ($data["rcv_payment"] as $rp_key => $rp_value) 
            {
                $_transaction = null;
                $_transaction[$rp_key]['date'] = $rp_value->rp_date;
                $_transaction[$rp_key]['type'] = 'Payment';
                $_transaction[$rp_key]['reference_name'] = 'receive_payment';
                $_transaction[$rp_key]['customer_name'] = $rp_value->title_name." ".$rp_value->first_name." ".$rp_value->last_name." ".$rp_value->suffix_name;
                $_transaction[$rp_key]['no'] = $rp_value->rp_id;
                $_transaction[$rp_key]['balance'] = 0;
                $_transaction[$rp_key]['due_date'] = $rp_value->rp_date;
                $_transaction[$rp_key]['total'] = $rp_value->rp_total_amount;
                $_transaction[$rp_key]['status'] = 'status';
                $_transaction[$rp_key]['date_created'] = $rp_value->manual_rp_date;

                array_push($data['__transaction'], $_transaction);
            }
            $data["credit_memo"] = Tbl_manual_credit_memo::customer_cm()->where("sir_id",$sir_id)->get();
            foreach ($data["credit_memo"] as $cm_key => $cm_value) 
            {
                $_transaction = null;
                $_transaction[$cm_key]['date'] = $cm_value->cm_date;
                $_transaction[$cm_key]['type'] = 'Credit Memo';
                $_transaction[$cm_key]['reference_name'] = 'credit_memo';
                $_transaction[$cm_key]['customer_name'] = $cm_value->title_name." ".$cm_value->first_name." ".$cm_value->last_name." ".$cm_value->suffix_name;
                $_transaction[$cm_key]['no'] = $cm_value->cm_id;
                $_transaction[$cm_key]['balance'] = 0;
                $_transaction[$cm_key]['due_date'] = $cm_value->cm_date;
                $_transaction[$cm_key]['total'] = $cm_value->cm_amount;
                $_transaction[$cm_key]['status'] = 'status';
                $_transaction[$cm_key]['date_created'] = $cm_value->manual_cm_date;

                array_push($data['__transaction'], $_transaction);
            }
        }


        $data["tr"] = [];
        foreach ($data['__transaction'] as $key => $value) 
        {
            foreach ($value as $key1 => $value1) 
            {
                array_push($data['tr'], $value1);
            }
        
        }
        $data["total"] = 0;
        foreach ($data['tr'] as $key2 => $value2)
        {
            if($value2['reference_name'] == "receive_payment" || $value2['reference_name'] == "sales_receipt")
            {
                $data['total'] += $value2['total'];
            }
        }
        // $data["total"] = currency("Php",$data['total']);

        return $data["total"];

    }
    public static function insert_sir_inventory($sir_id, $item, $ref_name, $ref_id)
    {
        $item_info = Tbl_item::where("item_id",$item["item_id"])->first();
        if($item_info->item_type_id == 4)
        {
            $bundle_item = Tbl_item_bundle::where("bundle_bundle_id",$item["item_id"])->get();
            foreach ($bundle_item as $key => $value) 
            {
                $item_bundle["item_id"] = $value->bundle_item_id;
                $item_bundle["qty"] = (UnitMeasurement::um_qty($value->bundle_um_id) * $value->bundle_qty) * $item["qty"];
                Purchasing_inventory_system::insert_sir_inventory($sir_id, $item_bundle, $ref_name, $ref_id);
            }
        }
        else
        {
            $insert["inventory_sir_id"] = $sir_id;
            $insert["sir_item_id"] = $item["item_id"];
            $insert["sir_inventory_count"] = $item["qty"];
            $insert["sir_inventory_ref_name"] = $ref_name;
            $insert["sir_inventory_ref_id"] = $ref_id;
            Tbl_sir_inventory::insert($insert);
        }        
    }

    public static function count_rem_qty($sir_id,$item_id)
    {
        return Tbl_sir_inventory::where("inventory_sir_id",$sir_id)->where("sir_item_id",$item_id)->where("sir_inventory_ref_name","!=","credit_memo")->sum("sir_inventory_count");
    }
    public static function count_sold_qty($sir_id,$item_id)
    {
        return abs(Tbl_sir_inventory::where("inventory_sir_id",$sir_id)->where("sir_item_id",$item_id)->where("sir_inventory_count","<=",0)->where("sir_inventory_ref_name","!=","credit_memo")->sum("sir_inventory_count"));
    }
    public static function get_qty_item_sir($sir_id,$item_id)
    {
        $qty = 0;
        $type = Tbl_item::where("item_id",$item_id)->pluck("item_type_id");
        if($type != 4)
        {
            $qty = Tbl_sir_inventory::where("inventory_sir_id",$sir_id)->where("sir_item_id",$item_id)->sum("sir_inventory_count");
        }

         return $qty;
    }
     public static function reject_return_stock($sir_id)
    {
        // inventroy_source_reason
        // inventory_source_id
        $warehouse_id = Purchasing_inventory_system::get_warehouse_based_sir($sir_id);
        $reason_refill = "sir_return";
        $refill_source = $sir_id;
        $remarks = "Return Stock from SIR NO: ".$sir_id;

        $sir_item = Tbl_sir_item::item()->where("sir_id",$sir_id)->get();

        foreach ($sir_item as $key => $value) 
        {
            $warehouse_refill_product[$key]["product_id"] = $value->item_id;
            $warehouse_refill_product[$key]["quantity"] = Purchasing_inventory_system::get_qty_item_sir($sir_id, $value->item_id);
        }

         $unset_key = null;
        foreach ($sir_item as $keyitem => $valueitem) 
        {            
            if($valueitem->item_type_id == 4)
            {
                $bundle = Tbl_item_bundle::where("bundle_bundle_id",$valueitem->item_id)->get();
                foreach ($bundle as $key_bundle => $value_bundle) 
                {
                    $qty =  UnitMeasurement::um_qty($valueitem->related_um_type);
                    $bundle_qty = UnitMeasurement::um_qty($value_bundle->bundle_um_id);
                    $_bundle[$key_bundle]['product_id'] = $value_bundle->bundle_item_id;
                    $_bundle[$key_bundle]['quantity'] = Purchasing_inventory_system::get_qty_item_sir($sir_id,$value_bundle->bundle_item_id);

                    array_push($warehouse_refill_product, $_bundle[$key_bundle]);
                }
                $unset_key[$keyitem] = $valueitem->item_id;
            }
        }

        foreach($warehouse_refill_product as $key_items => $value_items) 
        {
            $i = null;
            foreach ($sir_item as $value_itemid) 
            {
               $type = Tbl_item::where("item_id",$value_itemid->item_id)->pluck("item_type_id");
                if($type == 4)
                {
                    if($value_itemid->item_id == $value_items['product_id'])
                    {
                        $i = "true";
                    }
                }     
            }
            if($i != null)
            {
                unset($warehouse_refill_product[$key_items]);
            }
        }

        $data = Warehouse::inventory_refill($warehouse_id, $reason_refill, $refill_source, $remarks, $warehouse_refill_product,'array',$is_return = 1);

        // $up["ilr_status"] = 2;
        // Tbl_sir::where("sir_id",$sir_id)->update($up);

        return $data;
    }
    public static function return_stock($sir_id)
    {
        // inventroy_source_reason
        // inventory_source_id
        $warehouse_id = Purchasing_inventory_system::get_warehouse_based_sir($sir_id);
        $reason_refill = "sir_return";
        $refill_source = $sir_id;
        $remarks = "Return Stock from SIR NO: ".$sir_id;

        $sir_item = Tbl_sir_item::item()->where("sir_id",$sir_id)->get();

        foreach ($sir_item as $key => $value) 
        {
            $warehouse_refill_product[$key]["product_id"] = $value->item_id;
            $warehouse_refill_product[$key]["quantity"] = $value->physical_count;
        }
        $unset_key = null;
        foreach ($sir_item as $keyitem => $valueitem) 
        {            
            if($valueitem->item_type_id == 4)
            {
                $bundle = Tbl_item_bundle::where("bundle_bundle_id",$valueitem->item_id)->get();
                foreach ($bundle as $key_bundle => $value_bundle) 
                {
                   $qty =  UnitMeasurement::um_qty($valueitem->related_um_type);
                    $bundle_qty = UnitMeasurement::um_qty($value_bundle->bundle_um_id);
                    $_bundle[$key_bundle]['product_id'] = $value_bundle->bundle_item_id;
                    $_bundle[$key_bundle]['quantity'] = ($valueitem->physical_count * $qty) * ($value_bundle->bundle_qty * $bundle_qty);

                    array_push($warehouse_refill_product, $_bundle[$key_bundle]);
                }
                $unset_key[$keyitem] = $valueitem->item_id;
            }
        }

        foreach ($warehouse_refill_product as $key_items => $value_items) 
        {
            $i = null;
            foreach ($sir_item as $value_itemid) 
            {
                $type = Tbl_item::where("item_id",$value_itemid->item_id)->pluck("item_type_id");
                if($type == 4)
                {
                    if($value_itemid->item_id == $value_items['product_id'])
                    {
                        $i = "true";
                    }
                }                
            }
            if($i != null)
            {
                unset($warehouse_refill_product[$key_items]);
            }
        }

        $data = Warehouse::inventory_refill($warehouse_id, $reason_refill, $refill_source, $remarks, $warehouse_refill_product,'array',$is_return = 1);

        $up["ilr_status"] = 2;
        Tbl_sir::where("sir_id",$sir_id)->update($up);

        return $data;
    }
    public static function return_cm_item($sir_id)
    {
        // inventroy_source_reason
        // inventory_source_id
        $warehouse_id = Purchasing_inventory_system::get_warehouse_based_sir($sir_id);
        $reason_refill = "sir_empties_return";
        $refill_source = $sir_id;
        $remarks = "Return Empties Stock from SIR NO: ".$sir_id;

        $sir_item = Tbl_sir_cm_item::item()->where("sc_sir_id",$sir_id)->get();
        $data = [];
        $ctr = count($sir_item);
        if($ctr != 0)
        {
            foreach ($sir_item as $key => $value) 
            {
                $warehouse_refill_product[$key]["product_id"] = $value->sc_item_id;
                $warehouse_refill_product[$key]["quantity"] = $value->sc_physical_count;
            }
            // dd($warehouse_refill_product);
            $unset_key = null;
            foreach ($sir_item as $keyitem => $valueitem) 
            {            
                if($valueitem->item_type_id == 4)
                {
                    $bundle = Tbl_item_bundle::where("bundle_bundle_id",$valueitem->item_id)->get();
                    foreach ($bundle as $key_bundle => $value_bundle) 
                    {
                        // $qty =  UnitMeasurement::um_qty($valueitem->related_um_type);
                        $bundle_qty = UnitMeasurement::um_qty($value_bundle->bundle_um_id);
                        $_bundle[$key_bundle]['product_id'] = $value_bundle->bundle_item_id;
                        $_bundle[$key_bundle]['quantity'] = ($valueitem->sc_physical_count) * ($value_bundle->bundle_qty * $bundle_qty);

                        array_push($warehouse_refill_product, $_bundle[$key_bundle]);
                    }
                    $unset_key[$keyitem] = $valueitem->item_id;
                }
            }
            foreach ($warehouse_refill_product as $key_items => $value_items) 
            {
                $i = null;
                foreach ($sir_item as $value_itemid) 
                {
                    $type = Tbl_item::where("item_id",$value_itemid->item_id)->pluck("item_type_id");
                    if($type == 4)
                    {
                        if($value_itemid->item_id == $value_items['product_id'])
                        {
                            $i = "true";
                        }
                    }                
                }
                if($i != null)
                {
                    unset($warehouse_refill_product[$key_items]);
                }
            }
            $data = Warehouse::inventory_refill($warehouse_id, $reason_refill, $refill_source, $remarks, $warehouse_refill_product,'array',$is_return = 1);

        }

        return $data;

    }
    public static function reload_sir_item($sir_id)
    {
    
    }
    // public static function counter_lof()
    // {
    //     return Tbl_sir::whereIn("lof_status",[1,2,3])->where("sir_status",0)->where("ilr_status",0)->where("is_sync",0)->where("shop_id",Purchasing_inventory_system::getShopId())->count();
    // }
    // public static function counter_sir()
    // {
    //     return Tbl_sir::whereIn("sir_status",[1,2])->where("lof_status",0)->where("ilr_status",0)->where("is_sync",0)->where("shop_id",Purchasing_inventory_system::getShopId())->count();
    // }
    // public static function counter_ilr()
    // {
    
    // }
   
    public static function view_status($sir_id)
    {
        $sir_data["sir"] = Tbl_sir::saleagent()->truck()->where("sir_id",$sir_id)->first();

        $return = 'Rejected by Sales Agent <strong>'. $sir_data["sir"]->first_name." ".$sir_data["sir"]->middle_name." ".$sir_data["sir"]->last_name."</strong> <br><br><div class='text-center'> <strong >Reason : </strong><br>".$sir_data["sir"]->rejection_reason."</div>";
        if($sir_data["sir"]->ilr_status == 2 && $sir_data["sir"]->sir_status == 2 && $sir_data["sir"]->lof_status == 2 && $sir_data["sir"]->is_sync == 1)
        {

        $return = '<div class="col-md-12" style="text-decoration: line-through;">1. Create Load Out Form</div>
            <div class="col-md-12" style="text-decoration: line-through;">2. Confirmation of Load Out form by Sales Agent </div>
            <div class="col-md-12" style="text-decoration: line-through;">3. Convert LoadOutForm to SIR (Click here to convert to SIR)</div>
            <div class="col-md-12" style="text-decoration: line-through;">4. Currently Synced (Waiting for Truck and Agent to Return)</div>
            <div class="col-md-12" style="text-decoration: line-through;">5. Waiting for Sales Agent to Submit all transaction (Open I.L.R will be generated)</div>
            <div class="col-md-12">6. Accounting Department Confirmed Payment Remit by Agent (Click here to update Remittance)</div>
            <div class="col-md-12" style="text-decoration: line-through;">7. Warehose Supervisor Update Inventory and Closed the I.L.R (Click here to close the I.L.R)</div>';
        }
        else if($sir_data["sir"]->ilr_status == 1 && $sir_data["sir"]->sir_status == 2 && $sir_data["sir"]->lof_status == 2 && $sir_data["sir"]->is_sync == 1)
        {
           $return = '<div class="col-md-12" style="text-decoration: line-through;">1. Create Load Out Form</div>
            <div class="col-md-12" style="text-decoration: line-through;">2. Confirmation of Load Out form by Sales Agent </div>
            <div class="col-md-12" style="text-decoration: line-through;">3. Convert LoadOutForm to SIR (Click here to convert to SIR)</div>
            <div class="col-md-12" style="text-decoration: line-through;">4. Currently Synced (Waiting for Truck and Agent to Return)</div>
            <div class="col-md-12" style="text-decoration: line-through;">5. Waiting for Sales Agent to Submit all transaction (Open I.L.R will be generated)</div>
            <div class="col-md-12">6. Accounting Department Confirmed Payment Remit by Agent (Click <a class="popup" link="/member/pis_agent/collection_update/'.$sir_id.'" size="md">here</a> to update Remittance)</div>
            <div class="col-md-12" >7. Warehose Supervisor Update Inventory and Closed the I.L.R (Click <a href="/member/pis/ilr/'.$sir_id.'"> here </a> to close the I.L.R)</div>';
        }
        else if($sir_data["sir"]->ilr_status == 0 && $sir_data["sir"]->sir_status == 1 && $sir_data["sir"]->lof_status == 2 && $sir_data["sir"]->is_sync == 1)
        {
             $return = '<div class="col-md-12" style="text-decoration: line-through;">1. Create Load Out Form</div>
            <div class="col-md-12" style="text-decoration: line-through;">2. Confirmation of Load Out form by Sales Agent </div>
            <div class="col-md-12" style="text-decoration: line-through;">3. Convert LoadOutForm to SIR (Click here to convert to SIR)</div>
            <div class="col-md-12" style="text-decoration: line-through;">4. Currently Synced (Waiting for Truck and Agent to Return)</div>
            <div class="col-md-12" >5. Waiting for Sales Agent to Submit all transaction (Open I.L.R will be generated)</div>
            <div class="col-md-12">6. Accounting Department Confirmed Payment Remit by Agent (Click here to update Remittance)</div>
            <div class="col-md-12">7. Warehose Supervisor Update Inventory and Closed the I.L.R (Click here to close the I.L.R)</div>';
        }
        else if($sir_data["sir"]->ilr_status == 0 && $sir_data["sir"]->sir_status == 1 && $sir_data["sir"]->lof_status == 2 && $sir_data["sir"]->is_sync == 0)
        {
            $return = '<div class="col-md-12" style="text-decoration: line-through;">1. Create Load Out Form</div>
            <div class="col-md-12" style="text-decoration: line-through;">2. Confirmation of Load Out form by Sales Agent </div>
            <div class="col-md-12" style="text-decoration: line-through;">3. Convert LoadOutForm to SIR (Click here to convert to SIR)</div>
            <div class="col-md-12" >4. Currently Synced (Waiting for Truck and Agent to Return)</div>
            <div class="col-md-12" >5. Waiting for Sales Agent to Submit all transaction (Open I.L.R will be generated)</div>
            <div class="col-md-12">6. Accounting Department Confirmed Payment Remit by Agent (Click here to update Remittance)</div>
            <div class="col-md-12">7. Warehose Supervisor Update Inventory and Closed the I.L.R (Click here to close the I.L.R)</div>';
        }
        else if($sir_data["sir"]->ilr_status == 0 && $sir_data["sir"]->sir_status == 0 && $sir_data["sir"]->lof_status == 2 && $sir_data["sir"]->is_sync == 0)
        {
             $return = '<div class="col-md-12" style="text-decoration: line-through;">1. Create Load Out Form</div>
            <div class="col-md-12" style="text-decoration: line-through;">2. Confirmation of Load Out form by Sales Agent </div>
            <div class="col-md-12" >3. Convert LoadOutForm to SIR (Click <a size="md" link="/member/pis/sir/open/'.$sir_id.'/open" class="popup">here</a> to convert to SIR)</div>
            <div class="col-md-12" >4. Currently Synced (Waiting for Truck and Agent to Return)</div>
            <div class="col-md-12" >5. Waiting for Sales Agent to Submit all transaction (Open I.L.R will be generated)</div>
            <div class="col-md-12">6. Accounting Department Confirmed Payment Remit by Agent (Click here to update Remittance)</div>
            <div class="col-md-12">7. Warehose Supervisor Update Inventory and Closed the I.L.R (Click here to close the I.L.R)</div>';
        }
        else if($sir_data["sir"]->ilr_status == 0 && $sir_data["sir"]->sir_status == 0 && $sir_data["sir"]->lof_status == 1 && $sir_data["sir"]->is_sync == 0)
        {
                 $return = '<div class="col-md-12" style="text-decoration: line-through;">1. Create Load Out Form</div>
            <div class="col-md-12" >2. Confirmation of Load Out form by Sales Agent </div>
            <div class="col-md-12" >3. Convert LoadOutForm to SIR (Click here to convert to SIR)</div>
            <div class="col-md-12" >4. Currently Synced (Waiting for Truck and Agent to Return)</div>
            <div class="col-md-12" >5. Waiting for Sales Agent to Submit all transaction (Open I.L.R will be generated)</div>
            <div class="col-md-12">6. Accounting Department Confirmed Payment Remit by Agent (Click here to update Remittance)</div>
            <div class="col-md-12">7. Warehose Supervisor Update Inventory and Closed the I.L.R (Click here to close the I.L.R)</div>';
        }

        $sir_data["sir"]->gen_status = $return;

        $data = $sir_data["sir"];

        return $data;
    }
    public static function get_warehouse_based_sir($sir_id)
    {
        $sir = Tbl_sir::truck()->where("sir_id",$sir_id)->first();

        return $sir->sir_warehouse_id;
    }
    public static function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }
    public static function get_sir_item($sir_id)
    {
        $data["item"] = Tbl_sir_item::select_sir_item()->where("sir_id",$sir_id)->get();
        foreach ($data["item"] as $key => $value) 
        {   
            $um_qty = UnitMeasurement::um_qty($value->related_um_type);
            $data["item"][$key]->qty = UnitMeasurement::um_view($value->item_qty * $um_qty, $value->item_measurement_id, $value->related_um_type);   
        }
        $return_data = $data["item"];
        return $return_data;
    }
    public static function get_sir_data($sir_id)
    {        
        $price = "";
        $data["sir"] = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.sir_id",$sir_id)->first();

        $item = Tbl_sir_item::where("sir_id",$sir_id)->get();
        foreach ($item as $key2 => $value2)
        {   
            $qty = UnitMeasurement::um_qty($value2->related_um_type);
            $price += ($value2->sir_item_price * $qty) * $value2->item_qty;
        }
        $data["sir"]->total_amount = $price; 

        $return = $data["sir"];
        return $return->toArray();
    }
    public static function get_ilr_data($sir_id)
    {        
        $price = "";
        $data["ilr"] = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.sir_id",$sir_id)->first();

        $item = Tbl_sir_item::where("sir_id",$sir_id)->get();
        foreach ($item as $key2 => $value2)
        {   
            $price += $value2->sir_item_price *  $value2->physical_count;
        }
        $data["ilr"]->total_amount = $price; 

        $return = $data["ilr"];
        return $return->toArray();
    }
    public static function select_sir($shop_id = 0, $return = 'array',$srch_sir = '')
    {
    	$data = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",$shop_id)
                                ->where("tbl_sir.sir_id",'like','%'.$srch_sir.'%')
                                ->where("lof_status",2)
                                ->orderBy("tbl_sir.sir_id","DESC")->paginate(10);

        foreach ($data as $key => $value) 
        {              
            $data[$key]->total_amount = "";
            $item = Tbl_sir_item::item()->where("sir_id",$value->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {   
                $qty = UnitMeasurement::um_qty($value2->related_um_type);
                if($value2->item_type_id == 4)
                {
                    $price += Item::get_item_bundle_price($value2->item_id) * $value2->item_qty;;
                }
                else
                {
                    $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                    
                }
            }

            $data[$key]->total_amount += $price; 
        }

        if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    }
    public static function select_lof($shop_id = 0, $return = 'array',$srch_sir = '')
    {
        $data = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",$shop_id)
                                ->where("tbl_sir.sir_status","!=",2)
                                ->where("tbl_sir.sir_id",'like','%'.$srch_sir.'%')
                                ->orderBy("tbl_sir.sir_id","DESC")->paginate(10);
                                
        foreach ($data as $key => $value) 
        {              
            $data[$key]->total_amount = "";
            $item = Tbl_sir_item::item()->where("sir_id",$value->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {   
                $qty = UnitMeasurement::um_qty($value2->related_um_type);
                if($value2->item_type_id == 4)
                {
                    $price += Item::get_item_bundle_price($value2->item_id) * $value2->item_qty;;
                }
                else
                {
                    $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                    
                }
            }

            $data[$key]->total_amount += $price; 
        }
        if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    }

    public static function select_sir_list($srch_sir = '',$archived = 0)
    {
        $data = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",Purchasing_inventory_system::getShopId())->where("tbl_sir.archived",$archived)
                        ->where("tbl_sir.sir_id",'like','%'.$srch_sir.'%')
                        ->orderBy("tbl_sir.sir_id","DESC")->paginate(10);

        foreach ($data as $key => $value) 
        {              
            $data[$key]->total_amount = "";
            $item = Tbl_sir_item::item()->where("sir_id",$value->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {   
                $qty = UnitMeasurement::um_qty($value2->related_um_type);
                if($value2->item_type_id == 4)
                {
                    $price += Item::get_item_bundle_price($value2->item_id) * $value2->item_qty;;
                }
                else
                {
                    $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                    
                }             
            }

            $data[$key]->total_amount += $price; 
        }

        return $data;         
    }
    public static function select_sir_list_status($lof_status,$sir_status,$ilr_status,$sync, $srch_sir = '')
    {
        $data = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",Purchasing_inventory_system::getShopId())
                        ->where("tbl_sir.lof_status",$lof_status)
                        ->where("tbl_sir.sir_status",$sir_status)
                        ->where("tbl_sir.ilr_status",$ilr_status)
                        ->where("tbl_sir.is_sync",$sync)
                        ->where("tbl_sir.sir_id",'like','%'.$srch_sir.'%')
                        ->groupBy("tbl_sir.sir_id")
                        ->orderBy("tbl_sir.sir_id","DESC")->paginate(10);

        foreach ($data as $key => $value) 
        {              
            $data[$key]->total_amount = "";
            $item = Tbl_sir_item::where("sir_id",$value->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {   
                $qty = UnitMeasurement::um_qty($value2->related_um_type);
                if($value2->item_type_id == 4)
                {
                    $price += Item::get_item_bundle_price($value2->item_id) * $value2->item_qty;;
                }
                else
                {
                    $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                    
                }              
            }
            $data[$key]->total_amount += $price;

            if($lof_status == 3)
            {
                $data[$key]->status = "Rejected";
                $data[$key]->status_color = "danger";
            }
            elseif($lof_status == 2 && $sir_status == 1 && $ilr_status == 0 && $sync == 1 )
            {
                $data[$key]->status = "SIR";
                $data[$key]->status_color = "success";
            }
            elseif($lof_status == 2 && $sir_status == 2 && $ilr_status == 1 && $sync == 1 )
            {
                $data[$key]->status = "ILR";
                $data[$key]->status_color = "warning";
            }
            elseif($lof_status == 2 || $lof_status == 1 && $sir_status == 0 && $ilr_status == 0 && $sync == 0 )
            {
                $data[$key]->status = "LOF";
                $data[$key]->status_color = "info";
            }

        }

        return $data;         
    }
    public static function select_lof_status($shop_id = 0, $return = 'array',$status = 0,$archived = 0, $srch_sir = '')
    {
        $data = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",$shop_id)
                        ->where("tbl_sir.archived",$archived)
                        ->where("lof_status",$status)
                        ->where("tbl_sir.sir_status","!=",2)
                        ->where("tbl_sir.sir_id",'like','%'.$srch_sir.'%')
                        ->orderBy("tbl_sir.sir_id","DESC")->paginate(10);
        foreach ($data as $key => $value) 
        {              
            $data[$key]->total_amount = "";
            $item = Tbl_sir_item::item()->where("sir_id",$value->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {   
               $qty = UnitMeasurement::um_qty($value2->related_um_type);
                if($value2->item_type_id == 4)
                {
                    $price += Item::get_item_bundle_price($value2->item_id) * $value2->item_qty;
                }
                else
                {
                    $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                    
                }               
            }

            $data[$key]->total_amount += $price; 
        }

         if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    }
    public static function get_item_price($item_id)
    {
        $if_bundle = Tbl_item::where("item_id",$item_id)->pluck("item_type_id");

        $return_price = Tbl_item::where("item_id",$item_id)->pluck("item_price");
        if($if_bundle == 4)
        {
            $return_price = Item::get_item_bundle_price($item_id);
        }
        return $return_price;
    }
    public static function create_manual_invoice()
    {     
    } 
    public static function get_inventory_in_sir($sir_id)
    {
        $data["sir"] = Tbl_sir::truck()->saleagent()->where("sir_id",$sir_id)->where("sir_status",1)->where("tbl_sir.archived",0)->first();
        $data["_sir_item"] = Tbl_sir_item::select_sir_item()->where("sir_id",$sir_id)->get();
        // dd($data["_sir_item"]);
        if(count($data["_sir_item"]) > 0)
        {
            foreach($data["_sir_item"] as $key => $value) 
            {  
                $rem = "";
                $sold = "";
                $physical_count = "";
                if($value->item_type_id != 4)
                {
                    $rem_qty = Purchasing_inventory_system::count_rem_qty($sir_id, $value->item_id);
                    $sold_qty = Purchasing_inventory_system::count_sold_qty($sir_id, $value->item_id);


                    $um = Tbl_unit_measurement_multi::where("multi_id",$value->related_um_type)->first();

                    $data["_sir_item"][$key]->um_name = isset($um->multi_name) ? $um->multi_name : "";
                    $data["_sir_item"][$key]->um_abbrev = isset($um->multi_abbrev) ? $um->multi_abbrev : "PC";
                    $qty = UnitMeasurement::um_qty($value->related_um_type);

                    $issued_qty = $value->item_qty * $qty;
                    $remaining_qty = $rem_qty;
                    $total_sold_qty = $sold_qty;
                    
                    $rem = UnitMeasurement::um_view($remaining_qty, $value->item_measurement_id, $value->related_um_type);
                    $sold = UnitMeasurement::um_view($total_sold_qty, $value->item_measurement_id, $value->related_um_type);
                    $physical_count = UnitMeasurement::um_view($value->physical_count, $value->item_measurement_id,$value->related_um_type);
                }   
                else
                {
                    $bundle_item = Tbl_item_bundle::where("bundle_bundle_id",$value->item_id)->get();

                    $total_bundle_qty = 0;
                    $total_sold_bundle_qty = 0;
                    $qty = [];
                    $qtys = [];
                    foreach ($bundle_item as $key_bundle => $value_bundle)
                    {
                       $bundle_qty = UnitMeasurement::um_qty($value_bundle->bundle_um_id) * $value_bundle->bundle_qty;

                       $issued_bundle_qty_item = (UnitMeasurement::um_qty($value->related_um_type) * $value->item_qty) * $bundle_qty;

                       $total_sold_bundle_qty = Tbl_sir_inventory::where("sir_item_id",$value_bundle->bundle_item_id)->where("inventory_sir_id",$sir_id)->where("sir_inventory_count","<",0)->sum("sir_inventory_count");
                       $rem_bundle_qty = ($issued_bundle_qty_item - abs($total_sold_bundle_qty)) / $bundle_qty;
                       $sold_bundle_qty = $value->item_qty - $rem_bundle_qty;
                    }
                    $rem = UnitMeasurement::um_view(round($rem_bundle_qty), $value->item_measurement_id, $value->related_um_type);
                    $sold = UnitMeasurement::um_view(round($sold_bundle_qty), $value->item_measurement_id, $value->related_um_type);
                    $physical_count = UnitMeasurement::um_view($value->physical_count, $value->item_measurement_id,$value->related_um_type);
                }

                $data["_sir_item"][$key]->remaining_qty = $rem;
                $data["_sir_item"][$key]->sold_qty = $sold;
                $data["_sir_item"][$key]->physical_count = $physical_count;
            }
        }
        return $data;
    }

    public static function select_sir_status($shop_id = 0, $return = 'array',$status = 0,$archived = 0, $srch_sir = '',$is_sync = 0)
    {
        $data = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",$shop_id)
                        ->where("lof_status",2)
                        ->where("sir_status",$status)
                        ->where("tbl_sir.archived",$archived)
                        ->where("tbl_sir.is_sync",$is_sync)
                        // ->where("tbl_sir.sales_agent_id",$agent_id)
                        ->where("tbl_sir.sir_id",'like','%'.$srch_sir.'%')
                        ->orderBy("tbl_sir.sir_id","DESC")->paginate(10);

        // dd($data);
        foreach ($data as $key => $value) 
        {              
            $data[$key]->total_amount = "";
            $item = Tbl_sir_item::where("sir_id",$value->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {                  
                $qty = UnitMeasurement::um_qty($value2->related_um_type);
                if($value2->item_type_id == 4)
                {
                    $price += Item::get_item_bundle_price($value2->item_id);
                }
                else
                {
                    $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                    
                }               
            }

            $data[$key]->total_amount += $price; 
        }

         if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    }
    public static function tablet_lof_per_sales_agent($shop_id = 0, $return = 'array',$status = 0, $srch_sir = '', $agent_id)
    {
        $data["sir"] = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",$shop_id)
                        ->where("lof_status",$status)
                        ->where("tbl_sir.sales_agent_id",$agent_id)->first();
        if($data["sir"])
        {
            $item = Tbl_sir_item::where("sir_id",$data["sir"]->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {   
                $qty = UnitMeasurement::um_qty($value2->related_um_type);
                $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                
            }

            $data["sir"]->total_amount = $price; 
        }

        $return_data = $data["sir"];
        if($return == "json")
        {
            $return_data = json_encode($return_data);
        }
        return $return_data;

    }
    public static function tablet_sir_per_sales_agent($shop_id = 0, $return = 'array',$status = 0,$archived = 0, $srch_sir = '',$is_sync = 0, $agent_id)
    {
        $data = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",$shop_id)
                        ->where("sir_status",$status)
                        ->where("tbl_sir.archived",$archived)
                        ->where("tbl_sir.is_sync",$is_sync)
                        ->where("tbl_sir.sales_agent_id",$agent_id)
                        ->where("tbl_sir.sir_id",'like','%'.$srch_sir.'%')
                        ->orderBy("tbl_sir.sir_id","DESC")->get();

        // dd($data);
        foreach ($data as $key => $value) 
        {              
            $data[$key]->total_amount = "";
            $item = Tbl_sir_item::where("sir_id",$value->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {                   
                $qty = UnitMeasurement::um_qty($value2->related_um_type);
                $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                
            }

            $data[$key]->total_amount += $price; 
        }

         if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    }

    public static function select_ilr_status($shop_id = 0, $return = 'array',$status = 0, $srch_ilr = '')
    {
        $data = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",$shop_id)
                        ->where("ilr_status",$status)
                        ->where("tbl_sir.sir_id",'like','%'.$srch_ilr.'%')
                        ->orderBy("tbl_sir.sir_id","DESC")->paginate(10);

        // dd($data);
        foreach ($data as $key => $value) 
        {              
            $data[$key]->total_amount = "";
            $item = Tbl_sir_item::where("sir_id",$value->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {   
               $qty = UnitMeasurement::um_qty($value2->related_um_type);
                if($value2->item_type_id == 4)
                {
                    $price += Item::get_item_bundle_price($value2->item_id);
                }
                else
                {
                    $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                    
                }
            }

            $data[$key]->total_amount += $price;
        }

         if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    }
    public static function select_ilr($shop_id = 0, $return = 'array',$srch_sir = '')
    {
        $data = Tbl_sir::truck()->saleagent()->sir_item()->where("tbl_sir.shop_id",$shop_id)
                                ->where("tbl_sir.sir_id",'like','%'.$srch_sir.'%')
                                ->where("sir_status",2)
                                ->orderBy("tbl_sir.sir_id","DESC")->paginate(10);

        foreach ($data as $key => $value) 
        {              
            $data[$key]->total_amount = "";
            $item = Tbl_sir_item::where("sir_id",$value->sir_id)->get();
            $price = "";
            foreach ($item as $key2 => $value2)
            {   
                $qty = UnitMeasurement::um_qty($value2->related_um_type);
                if($value2->item_type_id == 4)
                {
                    $price += Item::get_item_bundle_price($value2->item_id);
                }
                else
                {
                    $price += ($value2->sir_item_price * $qty) * $value2->item_qty;                    
                }
            }

            $data[$key]->total_amount += $price; 
        }

        if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    }
    public static function check_qty_sir($sir_id, $item_id, $um, $qty, $invoice_id = 0, $invoice_table = '')
    {
        $return = 0;
        $type = Tbl_item::where("item_id",$item_id)->pluck("item_type_id");

        if($type == 4)
        {
            $item_bundle = Tbl_item_bundle::where("bundle_bundle_id",$item_id)->get();
            $bundle_return = 0;
            foreach ($item_bundle as $key => $value) 
            {
                $bundle_return += Purchasing_inventory_system::check_qty_sir($sir_id,$value->bundle_item_id,$value->bundle_um_id,$qty * $value->bundle_qty);
            }
            $return = $bundle_return;
        }
        else
        {
            $sir_item_count = Tbl_sir_inventory::where("inventory_sir_id",$sir_id)->where("sir_item_id",$item_id)->sum("sir_inventory_count");

            $inv_data = Tbl_sir_inventory::where("sir_inventory_ref_name","invoice")->where("sir_item_id",$item_id)->where("sir_inventory_ref_id",$invoice_id)->sum("sir_inventory_count");
            $old_invoice_qty = 0;
            if($inv_data != 0)
            {
                $old_invoice_qty = abs($inv_data);   
            }      
            $item_count = $sir_item_count + $old_invoice_qty; 
            $qty_1 = UnitMeasurement::um_qty($um);

            $new_invoice_qty = $qty_1 * $qty;
             
            if($new_invoice_qty > $item_count)
            {
                $return =  1;
            }
        }

        return $return;
    }

    public static function return_qty($sir_id, $item_id, $um, $qty)
    {
        $sir_item = Tbl_sir_item::where("sir_id",$sir_id)->where("item_id",$item_id)->first();

        $qty_1 = UnitMeasurement::um_qty($um);

        $invoice_qty = $qty_1 * $qty;

        $update_sold["sold_qty"] = $sir_item->sold_qty - $invoice_qty;

        Tbl_sir_item::where("sir_id",$sir_id)->where("item_id",$item_id)->update($update_sold);
    }
    public static function mark_as_sold($sir_id, $item_id, $um, $qty)
    {
        $sir_item = Tbl_sir_item::where("sir_id",$sir_id)->where("item_id",$item_id)->first();

        $um_qty = UnitMeasurement::um_qty($um);
        $invoice_qty = $um_qty * $qty;

        $update_sold["sold_qty"] = $invoice_qty + $sir_item->sold_qty;

        Tbl_sir_item::where("sir_id",$sir_id)->where("item_id",$item_id)->update($update_sold);

    }
    public static function count_sir($shop_id = 0, $return = 'array',$status = 0,$archived = 0)
    {
        $data = Tbl_sir::where("tbl_sir.shop_id",$shop_id)->where("sir_status",$status)->where("tbl_sir.archived",$archived)->count();

         if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    } 
    public static function count_ilr($shop_id = 0, $return = 'array',$status = 0,$archived = 0)
    {
        $data = Tbl_sir::where("tbl_sir.shop_id",$shop_id)->where("ilr_status",$status)->where("tbl_sir.archived",$archived)->count();

         if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    } 
    public static function select_single_sir($shop_id = 0,$sir_id, $return = 'array')
    {
        $data = Tbl_sir::truck()->saleagent()->where("tbl_sir.shop_id",$shop_id)
                                ->selectRaw("*, tbl_sir.created_at as sir_created")
                                ->where("tbl_sir.sir_id",$sir_id)->first();

        if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    }
    public static function select_sir_item($shop_id = 0, $sir_id, $return = 'array')
    {
        $data = Tbl_sir::select_sir_item()->where("tbl_sir.shop_id",$shop_id)->where("tbl_sir.sir_id",$sir_id)->get();

        foreach ($data as $key => $value) 
        {
            if($value->related_um_type != null)
            {
                $unit_m = Tbl_unit_measurement_multi::where("multi_id",$value->related_um_type)->first();
                $data[$key]->um_name = $unit_m->multi_name;
                $data[$key]->um_abbrev = $unit_m->multi_abbrev;              
            }
            else
            {
                $data[$key]->um_name = "PC";
                $data[$key]->um_abbrev = "";
            }
        }

        if($return == "json")
        {
            $data = json_encode($data);
        }
        return $data;
    }
    public static function open_sir_general()
    {        
        $update["is_sync"] = 1;
        $all_load_out_form = Tbl_sir::where("sir_status",1)->get();

        foreach ($all_load_out_form as $key => $value) 
        {
            Tbl_sir::where("sir_id",$value->sir_id)->update($update);
        }

        $data["status"] = "success";

        return $data;
    }    
    public static function close_sir($sir_id)
    {         
        $update["sir_status"] = 2;
        $update["ilr_status"] = 1;
 
        Tbl_sir::where("sir_id",$sir_id)->update($update);
        
        $m_inv = Tbl_manual_invoice::where("sir_id",$sir_id)->get();
        $items = array();
        foreach ($m_inv as $key_m => $value_m) 
        {
            $cm_items = Tbl_customer_invoice::returns_item()->where("inv_id",$value_m->inv_id)->get();
            if($cm_items)
            {
                foreach ($cm_items as $key_cm => $value_cm) 
                {
                     $cm_item["item_id"] = $value_cm->cmline_item_id;
                     $cm_item["item_qty"]= UnitMeasurement::um_qty($value_cm->cmline_um) * $value_cm->cmline_qty;

                     array_push($items, $cm_item);
                }
            }
        }
        $cm_items = null;
        $cm = Tbl_manual_credit_memo::where("sir_id",$sir_id)->get();
        foreach ($cm as $cm_key => $cm_value)
        {
            $cm_itemss = Tbl_credit_memo_line::where("cmline_cm_id",$cm_value->cm_id)->get();
            if($cm_itemss)
            {
                foreach ($cm_itemss as $keycm => $valuecm) 
                {
                    $cm_items["item_id"] = $valuecm->cmline_item_id;
                    $cm_items["item_qty"]= UnitMeasurement::um_qty($valuecm->cmline_um) * $valuecm->cmline_qty;

                     array_push($items, $cm_items);
                    
                }
            } 

            $up["is_sync"] = 1 ;
            Tbl_manual_credit_memo::where("manual_cm_id",$cm_value->manual_cm_id)->update($up);   
        }
        $result = array();
        foreach($items as $k => $v)
        {
            $id = $v['item_id'];
            $result[$id][] = $v['item_qty'];
        }

        $new_item = array();
        foreach($result as $key1 => $value1) 
        {
            $new_item[$key1] = array('item_id' => $key1, 'item_qty' => array_sum($value1));
        }
        foreach ($new_item as $key1 => $value1) 
        {
            $item_info = Tbl_item::where("item_id",$value1["item_id"])->first();
            // $data["_returns"][$key1]['item_name'] = "";
            // $data["_returns"][$key1]['item_count'] = "";
            // $data["_returns"][$key1]['item_base_um'] = "";
            // $data["_returns"][$key1]['item_issued_um'] = "";
            // $data["_returns"][$key1]['item_price'] = "";
            if($item_info)
            {
                // $item_um = Tbl_unit_measurement_multi::where("multi_um_id",$item_info->item_measurement_id)->where("is_base",0)->pluck("multi_id");
                // $data["_returns"][$key1]['item_name'] = $item_info->item_name;
                // $data["_returns"][$key1]['item_count'] = UnitMeasurement::um_view($value1["item_qty"],$item_info->item_measurement_id,$item_um);
                // $data["_returns"][$key1]['item_base_um'] = $item_info->item_measurement_id;
                // $data["_returns"][$key1]['item_issued_um'] = $item_um;
                // $data["_returns"][$key1]['item_price'] = $item_info->item_price;

                $ins["sc_sir_id"] = $sir_id;
                $ins["sc_item_id"] = $value1["item_id"];
                $ins["sc_item_qty"] = $value1["item_qty"];
                $item_price = $item_info->item_price;
                if($item_info->item_type_id == 4)
                {
                    $item_price = Item::get_item_bundle_price($value1["item_id"]);
                }
                $ins["sc_item_price"] = $item_price;
                Tbl_sir_cm_item::insert($ins);
            }
        }

        $data = "success-close";
        return $data;        
    }

    public static function close_sir_general()
    {        
        $update["sir_status"] = 2;
        $update["ilr_status"] = 1;
        $all_load_out_form = Tbl_sir::where("sir_status",1)->where("is_sync",1)->get();

        foreach ($all_load_out_form as $key => $value) 
        {
            Tbl_sir::where("sir_id",$value->sir_id)->update($update);
        }

        $data["status"] = "success";


        $all = Tbl_manual_invoice::sir()->customer_invoice() 
                                        ->where("tbl_manual_invoice.is_sync",0)
                                        ->get();
                 // dd($all);                       
        foreach ($all as $key => $value) 
        {
        //         $customer_info                      = [];
        //         $customer_info['customer_id']       = $value->inv_customer_id;
        //         $customer_info['customer_email']    = $value->inv_customer_email;

        //         $invoice_info                       = [];
        //         $invoice_info['new_inv_id']         = $value->new_inv_id;
        //         $invoice_info['invoice_terms_id']   = $value->inv_terms_id;
        //         $invoice_info['invoice_date']       = $value->inv_date;
        //         $invoice_info['invoice_due']        = $value->inv_due_date;
        //         $invoice_info['billing_address']    = $value->inv_customer_billing_address;

        //         $invoice_other_info                 = [];
        //         $invoice_other_info['invoice_msg']  = $value->inv_message;
        //         $invoice_other_info['invoice_memo'] = $value->inv_memo;

        //         $total_info                         = [];
        //         $total_info['total_subtotal_price'] = $value->inv_subtotal_price;
        //         $total_info['ewt']                  = $value->ewt;
        //         $total_info['total_discount_type']  = $value->inv_discount_type;
        //         $total_info['total_discount_value'] = $value->inv_discount_value;
        //         $total_info['taxable']              = $value->taxable;
        //         $total_info['total_overall_price']  = $value->inv_overall_price;

        //         $item_info                          = [];
        //         $_itemline                          = Tbl_temp_customer_invoice_line::where("invline_inv_id",$value->inv_id)->get();

        //     $return = 0;
        //     foreach($_itemline as $keys => $item_line)
        //     {
        //         if($item_line)
        //         {
        //             $item_info[$keys]['item_service_date']  = $item_line->invline_service_date;
        //             $item_info[$keys]['item_id']            = $item_line->invline_item_id;
        //             $item_info[$keys]['item_description']   = $item_line->invline_description;
        //             $item_info[$keys]['um']                 = $item_line->invline_um;
        //             $item_info[$keys]['quantity']           = $item_line->invline_qty;
        //             $item_info[$keys]['rate']               = $item_line->invline_rate;
        //             $item_info[$keys]['discount']           = $item_line->invline_discount;
        //             $item_info[$keys]['discount_remark']    = $item_line->invline_discount_remark;
        //             $item_info[$keys]['taxable']            = $item_line->taxable;
        //             $item_info[$keys]['amount']             = $item_line->invline_amount;
        //         }
        //     }
        //    $invoice_id = Invoice::postInvoice($customer_info, $invoice_info, $invoice_other_info, $item_info, $total_info);
           
        //    $update_ms["inv_id"] = $invoice_id;
           $update_ms["is_sync"] = 1;
        //    $update_m["is_sync"] = 1;
           Tbl_manual_invoice::where("manual_invoice_id",$value->manual_invoice_id)->update($update_ms);
        //    Tbl_temp_customer_invoice::where("inv_id",$value->inv_id)->update($update_m);
        }

        return $data;
    }
}