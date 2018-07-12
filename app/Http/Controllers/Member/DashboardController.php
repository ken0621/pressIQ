<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
// use App\Http\Middleware\RandomColor;
use App\Globals\Accounting;
use App\Globals\Category;
use App\Globals\Item;
use App\Globals\Customer;
use App\Globals\Purchase_Order;
use App\Globals\Purchasing_inventory_system;
use App\Globals\Invoice;
use App\Globals\Billing;
use App\Globals\Report;

use App\Models\Tbl_User;
use App\Models\Tbl_customer;
use App\Models\Tbl_unit_measurement;
use App\Models\Tbl_journal_entry_line;

use Carbon\Carbon;
use Request;
use DB;

class DashboardController extends Member
{

	public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->value('user_shop');
    }

	public function index()
	{
		$period 		= Request::input("period");
		$period 		= "days_ago";
		$date["days"] 	= "365";
		$from  			= Report::checkDatePeriod($period, $date)['start_date'];
        $to     		= Report::checkDatePeriod($period, $date)['end_date'];

        /* INVOICE DATA */
		$data["open_invoice"] 	= Invoice::invoiceStatus($from, $to)["open"];
		$data["overdue_invoice"]= Invoice::invoiceStatus($from, $to)["overdue"];

		$date["days"] 			= "30";
		$from  					= Report::checkDatePeriod($period, $date)['start_date'];
        $to     				= Report::checkDatePeriod($period, $date)['end_date'];
		$data["paid_invoice"] 	= Invoice::invoiceStatus($from, $to)["paid"];


		/* EXPENSE DATA */
		$data["_expenses"]   = Tbl_journal_entry_line::account()->journal()->totalAmount()
                            ->where("je_shop_id", $this->getShopId())
                            ->whereIn("chart_type_name", ['Expense', 'Other Expense', 'Cost of Good Sold'])
                            ->whereRaw("DATE(je_entry_date) >= '$from'")
                            ->whereRaw("DATE(je_entry_date) <= '$to'")
                            ->get();

        $data["expense_name"]	= [];
        $data["expense_color"]	= [];
        $data["expense_value"]	= [];
        foreach($data["_expenses"] as $key=>$expense)
        {
        	$data["_expenses"][$key]->percentage = currency('',((@($expense->amount / collect($data["_expenses"])->sum('amount'))) * 100))." %";
        	array_push($data["expense_name"], $expense->account_name);
        	array_push($data["expense_value"], currency('',((@($expense->amount / collect($data["_expenses"])->sum('amount'))) * 100)));
        	array_push($data["expense_color"], $this->random_color());
        }
        $data["expense_name"]	= json_encode($data["expense_name"]);
        $data["expense_value"] 	= json_encode($data["expense_value"]);
        $data["expense_color"]	= json_encode($data["expense_color"]);

        /* INCOME DATA */
		$data["_income"]     = Tbl_journal_entry_line::account()->journal()
							->selectRaw("*")
							->amount()
                            ->where("je_shop_id", $this->getShopId())
                            ->whereIn("chart_type_name", ['Income', 'Other Income'])
                            ->whereRaw("DATE(je_entry_date) >= '$from'")
                            ->whereRaw("DATE(je_entry_date) <= '$to'")
                            ->groupBy(DB::raw("DATE(je_entry_date)"))
                            ->get();

        $data["income_date"]	= [];
        $data["income_value"]	= [];
        foreach($data["_income"] as $key=>$income)
        {
        	array_push($data["income_date"], dateFormat($income->je_entry_date));
        	array_push($data["income_value"], $income->amount);
        }
        $data["income_date"]	= json_encode($data["income_date"]);
        $data["income_value"] 	= json_encode($data["income_value"]);

        /* BANK DATA */
        $data["_bank"]		= Tbl_journal_entry_line::account()->journal()->totalAmount()
                            ->where("je_shop_id", $this->getShopId())
                            ->whereIn("chart_type_name", ['Bank'])
                            ->get();
        $data['pis'] = Purchasing_inventory_system::check();
        if($data['pis'])
        {

            $sixmonths = Carbon::now()->subMonths(12)->format("Y-m-d") . " 00:00:00";

            $end_date = date("Y-m-d H:i:s", strtotime(Carbon::now()));
            $start_date = date("Y-m-d H:i:s", strtotime($sixmonths));
            
            if(Request::input("start_date") && Request::input("end_date")) 
            {
                $end_date = date("Y-m-d H:i:s", strtotime(Request::input("end_date")));
                $start_date = date("Y-m-d H:i:s", strtotime(Request::input("start_date")));
            }

            $data['po_amount'] = currency('PHP ',Purchase_Order::get_po_amount($start_date, $end_date)); 
            $data['count_po']  =number_format(Purchase_Order::count_po($start_date, $end_date));

            $data['count_ar'] = number_format(Invoice::count_ar($start_date, $end_date)); 
            $data['ar_amount']  = currency('PHP ',Invoice::get_ar_amount($start_date, $end_date));

            $data['count_ap'] = number_format(Billing::count_ap($start_date, $end_date)); 
            $data['ap_amount']  = currency('PHP ',Billing::get_ap_amount($start_date, $end_date));

            $data['sales_amount'] = currency('PHP ',Invoice::get_sales_amount($start_date, $end_date));
            $data['pb_amount'] = currency('PHP ',Billing::get_paid_bills_amount($start_date, $end_date));

            $data["mants"] = Carbon::now()->subMonths(12);
            return view('member.dashboard.dashboard', $data);
        }
		return view('member.dashboard.new_dashboard', $data);
	}

	public function random_color_part() {
    	return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	public function random_color() {	
	    return '#'.$this->random_color_part() .''. $this->random_color_part() .''. $this->random_color_part();
	}

	public function new_dashboard()
	{
		return view('member.dashboard.new_dashboard');
	}

	public function change_warehouse()
	{
		if(Request::input("change_warehouse"))
		{
			$data = $this->save_warehouse_id(Request::input("change_warehouse"));
			return json_encode($data);
		}
		else
		{
			dd("Error 404");
		}
	}

	/**
	 * Dashboard Statistics
	 *
	 * @return 	view
	 */
	public function statistics()
	{
		$period 		= Request::input("period");
		$period 		= "days_ago";
		$date["days"] 	= "365";
		$from  			= Report::checkDatePeriod($period, $date)['start_date'];
        $to     		= Report::checkDatePeriod($period, $date)['end_date'];

		$data["open_invoice"] 		= Invoice::invoiceStatus($from, $to)["open"];
		$data["overdue_invoice"] 	= Invoice::invoiceStatus($from, $to)["overdue"];

		$date["days"] 	= "30";
		$from  			= Report::checkDatePeriod($period, $date)['start_date'];
        $to     		= Report::checkDatePeriod($period, $date)['end_date'];
        
		$data["paid_invoice"] 		= Invoice::invoiceStatus($from, $to)["paid"];


		$data["_expenses"]   = Tbl_journal_entry_line::account()->journal()->totalAmount()
                            ->where("je_shop_id", $this->getShopId())
                            ->whereIn("chart_type_name", ['Expense', 'Other Expense', 'Cost of Good Sold'])
                            ->whereRaw("DATE(je_entry_date) >= '$from'")
                            ->whereRaw("DATE(je_entry_date) <= '$to'")
                            ->get();

		$data["_income"]     = Tbl_journal_entry_line::account()->journal()
							->selectRaw("*")
							->amount()
                            ->where("je_shop_id", $this->getShopId())
                            ->whereIn("chart_type_name", ['Income', 'Other Income'])
                            ->whereRaw("DATE(je_entry_date) >= '$from'")
                            ->whereRaw("DATE(je_entry_date) <= '$to'")
                            ->groupBy(DB::raw("DATE(je_entry_date)"))
                            ->get();

        $data["_bank"]		= Tbl_journal_entry_line::account()->journal()->totalAmount()
                            ->where("je_shop_id", $this->getShopId())
                            ->whereIn("chart_type_name", ['Bank'])
                            ->get();

		return view('member.dashboard.dashboard', $data);
	}
}