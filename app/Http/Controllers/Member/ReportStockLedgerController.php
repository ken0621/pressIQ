<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Globals\Warehouse2;
use App\Globals\Item;
use Illuminate\Http\Request;


class ReportStockLedgerController extends Member
{
    public function getIndex(Request $request)
    {
        $data["action"] 	= "/member/report/accounting/stock_ledger";
        $data['shop_name']  = $this->user_info->shop_key; 
        $data['head_title'] = 'Stock Ledger'; 
        $data['now'] 		= Carbon::now()->format('l F j, Y h:i:s A');

        $report_type    = $request->report_type;
        $load_view      = $request->load_view;

        $shop_id = $this->user_info->shop_id;

        $current_warehouse = Warehouse2::get_current_warehouse($shop_id);
        //dd($current_warehouse);
       	$data['_report'] = Warehouse2::stock_ledger_report($shop_id, $current_warehouse);

       	//dd($data['_report']);

       	/* IF REPORT TYPE IS EXIST AND NOT RETURNING VIEW */
        /*if($report_type && !$load_view)
        {
            $view =  'member.reports.output.stock_ledger'; 
            return Report::check_report_type($report_type, $view, $data, 'Stock Ledger-'.Carbon::now(), 'landscape');
        }
        else
        {
            return view('member.reports.accounting.stock_ledger', $data);
        }*/

        return view('.member.reports.accounting.stock_ledger', $data);
    }
}
