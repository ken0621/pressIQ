<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Globals\Warehouse2;
use App\Globals\Item;
use App\Globals\Report;

use Carbon\Carbon;



class ReportStockLedgerController extends Member
{
    public function getIndex(Request $request)
    {
    	$shop_id 	= $this->user_info->shop_id;

        $data["action"] 	= "/member/report/accounting/stock_ledger";
        $data['shop_name']  = $this->user_info->shop_key; 
        $data['head_title'] = 'Stock Ledger'; 
        $data['now'] 		= Carbon::now()->format('l F j, Y h:i:s A');

        $item   		= $request->item;
        $vendor   		= $request->vendor;
        $report_type   	= $request->report_type;
        $load_view     	= $request->load_view;
        $period         = $request->report_period ? $request->report_period : 'this_week';
        $date['start']  = $request->from;
        $date['end']    = $request->to;
        $data['from']   = Report::checkDatePeriod($period, $date)['start_date'];
        $data['to']     = Report::checkDatePeriod($period, $date)['end_date'];

        $current_warehouse = Warehouse2::get_current_warehouse($shop_id);

       	$data['_report'] = Warehouse2::stock_ledger_report($shop_id, $current_warehouse, $data['from'],$data['to'], $item);

       	$data['_vendor'] = Warehouse2::get_vendor($shop_id);
       	//dd($data['_vendor']);
       	$data['_item']  = Item::get_all_category_item([1,4,5]);

       	$data['item'] = $item;
       	

       	/* IF REPORT TYPE IS EXIST AND NOT RETURNING VIEW */
        if($report_type && !$load_view)
        {
            $view =  'member.reports.output.stock_ledger'; 
            return Report::check_report_type($report_type, $view, $data, 'Stock Ledger-'.Carbon::now(), 'landscape');
        }
        else
        {
            return view('member.reports.accounting.stock_ledger', $data);
        }
    }
}
