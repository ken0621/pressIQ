<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
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
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

	public function index()
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

		return view('member.dashboard.dashboardv1', $data);
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