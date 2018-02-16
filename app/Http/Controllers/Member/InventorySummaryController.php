<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Globals\Transaction;
use App\Globals\Warehouse2;
use App\Globals\Report;
use App\Globals\Item;
use Carbon\Carbon;
use App\Models\Tbl_item;

class InventorySummaryController extends Member
{
    public function getIndex(Request $request)
    {
        /*$data['page'] = 'Inventory - Summary';
        return view('.member.reports.inventory.inventory_summary', $data);*/

        $data["action"] = "/member/report/inventory/summary";
        $data['shop_name']  = $this->user_info->shop_key; 
        $data['head_title']  = 'Inventory - Summary'; 
        $data['now']        = Carbon::now()->format('l F j, Y h:i:s A');
        
        $data['head_icon']  = 'fa fa-area-chart';
        $data['head_discription'] = '';

        $report_type    = $request->report_type;
        $load_view      = $request->load_view;
        $period         = $request->report_period ? $request->report_period : 'all';
        $date['start']  = $request->from;
        $date['end']    = $request->to;
        $data['from']   = Report::checkDatePeriod($period, $date)['start_date'];
        $data['to']     = Report::checkDatePeriod($period, $date)['end_date'];

        //dd($data);
        //$data['_report'] = Tbl_item::um()->where('shop_id',$this->user_info->shop_id)->get();
        $warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
        $data['_report'] = Tbl_item::recordloginventory($warehouse_id)->where('shop_id',$this->user_info->shop_id)
                        ->whereBetween('record_log_date_updated',[$data['from'], $data['to']])->get();
        //dd($data['_report']);
        foreach($data['_report']as $key => $value) 
        {
        	// $warehouse_id = Warehouse2::get_current_warehouse($this->user_info->shop_id);
         //    $data['_report'][$key]->inventory_count = Tbl_item::recordloginventory($warehouse_id)
         //                                        ->where('item_id', $value->item_id)
         //                                        ->value('inventory_count');
            $data['_report'][$key]->total_cost = $value->item_cost * $value->inventory_count;
            $data['_report'][$key]->total_price = $value->item_price * $value->inventory_count;
        }

        $data['inventory_count_total']  = null;
        $data['cost_total']         = null;
        $data['total_cost_total']   = null;
        $data['asset_value_total']  = null;
        $data['price_total']         = null;
        $data['total_price_total']   = null;

        foreach ($data['_report'] as $key => $value)
        {
            $data['inventory_count_total'] += $value->inventory_count;
            $data['cost_total'] += $value->item_cost;
            $data['total_cost_total'] += $value->total_cost;
            $data['price_total'] += $value->item_price;
            $data['total_price_total'] += $value->total_price;
        }
        
        /* IF REPORT TYPE IS EXIST AND NOT RETURNING VIEW */
        if($report_type && !$load_view)
        {
            $view =  'member.reports.output.inventory_summary'; 
            return Report::check_report_type($report_type, $view, $data, 'Inventory - Summary'.Carbon::now(), 'landscape');
        }
        else
        {
            return view('member.reports.inventory.inventory_summary', $data);
        }
    }
}
