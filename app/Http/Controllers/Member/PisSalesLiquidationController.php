<?php

namespace App\Http\Controllers\Member;

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
use App\Globals\Purchasing_inventory_system;
use App\Globals\Pdf_global;
use DB;
use Carbon\Carbon;
use Session;
use Request;

class PisSalesLiquidationController extends Member
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["sales"] = "";
        $data["_sir"] = Purchasing_inventory_system::select_ilr_status($this->user_info->shop_id,'array',2,Request::input("sir_id"));

        return view("member.cashier.sales_liquidation.sales_liquidation",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report($sir_id)
    {

        $data["user"] = Tbl_user::where("user_id",$this->user_info->user_id)->first();

        // FOR ILR   
        $data["sir"] = Purchasing_inventory_system::select_single_sir($this->user_info->shop_id,$sir_id,'array');
        $agent_id = $data["sir"]->sales_agent_id;
        $data["sir_id"] = $sir_id;
        $data["_sir_item"] = Purchasing_inventory_system::select_sir_item($this->user_info->shop_id,$sir_id,'array');

        $data["_returns"] = Tbl_sir_cm_item::item()->where("sc_sir_id",$sir_id)->get();

        $data["type"] = "I.L.R";
        $loss = 0;
        $over = 0;
        $mts_loss = 0;
        $mts_over = 0;
        $agent_discerpancy = 0;
        $status = '';
        if($data["_sir_item"] != null)
        {
            foreach($data["_sir_item"] as $key => $value) 
            { 

                if($value->item_type_id != 4)
                {   
                    $rem_qty = Purchasing_inventory_system::count_rem_qty($sir_id, $value->item_id);
                    $sold_qty = Purchasing_inventory_system::count_sold_qty($sir_id, $value->item_id);

                    $um = Tbl_unit_measurement_multi::where("multi_id",$value->related_um_type)->first();

                    $data["_sir_item"][$key]->um_name = isset($um->multi_name) ? $um->multi_name : "";
                    $data["_sir_item"][$key]->um_abbrev = isset($um->multi_abbrev) ? $um->multi_abbrev : "PC";

                    $qt = UnitMeasurement::um_qty($value->related_um_type);
                        
                    $issued_qty = $value->item_qty * $qt;
                    $remaining_qty = $rem_qty;
                    $total_sold_qty = $sold_qty;
                    
                    $physical_ctr = $value->physical_count;
                    $rem = "";
                    $sold = "";
                    $physical_count = "";
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
                    $total_sold_qty = $sold_bundle_qty;


                    $remaining_qty = $rem;
                    $physical_ctr = $value->physical_count;
                }
            
                $data["_sir_item"][$key]->quantity_sold = $total_sold_qty;
                $data["_sir_item"][$key]->remaining_qty = $rem;
                $data["_sir_item"][$key]->sold_qty = $sold;
                $data["_sir_item"][$key]->physical_count = $physical_count;

                if($value->is_updated != 0)
                {
                    if($remaining_qty == $physical_ctr)
                    {
                        $status = 'OK';
                    }
                    elseif($physical_ctr > $remaining_qty)
                    {
                        $status = 'OVER '.UnitMeasurement::um_view($physical_ctr - $remaining_qty,$value->item_measurement_id,$value->related_um_type);   
                    }
                    elseif($physical_ctr < $remaining_qty) 
                    {
                       $status = 'SHORT '.UnitMeasurement::um_view($remaining_qty - $physical_ctr,$value->item_measurement_id,$value->related_um_type);
                    }                    
                }
                $data["_sir_item"][$key]->status = $status;


                $loss += $value->infos < 0 ? $value->infos : 0;
                $over += $value->infos > 0 ? $value->infos : 0;

            }
        }
        $data["ctr_returns"] = count($data["_returns"]);
        if($data["_returns"] != null)
        {
            foreach ($data["_returns"] as $key_return => $value_return)
            {
                $item_um = Tbl_unit_measurement_multi::where("multi_um_id",$value_return->item_measurement_id)->where("is_base",0)->pluck("multi_id");

                $data["_returns"][$key_return]->item_count = UnitMeasurement::um_view($value_return->sc_item_qty,$value_return->item_measurement_id,$item_um); 
                $data["_returns"][$key_return]->item_physical_count = UnitMeasurement::um_view($value_return->sc_physical_count,$value_return->item_measurement_id,$item_um); 

                $original_qty = $value_return->sc_item_qty;
                $physical_qty = $value_return->sc_physical_count;
                $status = "";
                if($value_return->sc_is_updated != 0)
                {
                    if($original_qty == $physical_qty)
                    {
                        $status = "OK";
                    }
                    elseif($physical_qty > $original_qty)
                    {
                        $status = "OVER ".(UnitMeasurement::um_view($physical_qty - $original_qty,$value_return->item_measurement_id,$item_um));   
                    }
                    elseif($physical_qty < $original_qty) 
                    {
                        $status = "SHORT ".(UnitMeasurement::um_view($original_qty - $physical_qty,$value_return->item_measurement_id,$item_um));
                    }                 
                }

                $data["_returns"][$key_return]->sc_physical_count = UnitMeasurement::um_view($physical_qty,$value_return->item_measurement_id,$item_um); 
                $data["_returns"][$key_return]->status = $status;      


                $mts_loss += $value_return->sc_infos < 0 ? $value_return->sc_infos : 0;
                $mts_over += $value_return->sc_infos > 0 ? $value_return->sc_infos : 0;  
            }
        }


        //FOR AGENT TRANSACTION

        $data["agent"] = Tbl_employee::position()->where("employee_id",$agent_id)->first();
        $start_date = '';
        $end_date = '';
        //for invoice
        $data["invoices"] = Tbl_manual_invoice::customer_invoice()->where("sir_id",$sir_id)->get(); 

        //union of invoice and receive payment
        $data['__transaction'] = array();
        $data['total_ar'] = 0;
        $data['total_cm'] = 0;
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

           
            $data['total_ar'] += $inv_value->inv_overall_price - $inv_value->inv_payment_applied;
           
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


            $data['total_cm'] += $cm_value->cm_amount;

            array_push($data['__transaction'], $_transaction);
        }

        $sir_data = Tbl_sir::where("sir_id",$sir_id)->first();
        $data["rem_amount"] = $sir_data->agent_collection;
        $data["rem_remarks"] = $sir_data->agent_collection_remarks;

        $data["tr"] = array();
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
        usort($data['tr'], function($a, $b)
        {
            $t1 = strtotime($a['date_created']);
            $t2 = strtotime($b['date_created']);
            return $t1 - $t2;
        });
        // dd($data['tr']);
        $data['_transaction'] = $data['tr'];

        $data['ctr_tr'] = count($data['_transaction']);
        $data['sdate'] = date('m/d/Y');

        $agent_discrepancy = ($data['total'] == $data["rem_amount"] ? 0 : $data["rem_amount"] - $data['total']);

        $data["total_discrepancy"] = $agent_discrepancy + (($loss + $over) - ($mts_loss + $mts_over));


        $html = view("member.cashier.sales_liquidation.liquidation_report",$data);
        return Pdf_global::show_pdf($html);
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
