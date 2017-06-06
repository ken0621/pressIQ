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
use App\Globals\Reportsss;

use App\Models\Tbl_User;
use App\Models\Tbl_customer;
use App\Models\Tbl_unit_measurement;
use App\Models\Tbl_jounal_entry_line;
use Carbon\Carbon;
use Request;
class DashboardController extends Member
{

	public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

	public function index()
	{
		$data["mants"] = Carbon::now()->subMonths(6);

		$data["shop_name"]		= $this->user_info->shop_key;

		$start_date = date("Y-m-d H:i:s",strtotime(Carbon::now()->subMonths(6)->format("Y-m-d") . " 00:00:00"));
		$end_date = date("Y-m-d H:i:s",strtotime(Carbon::now()));
		if(Request::input("start_date") && Request::input("end_date"))
		{
			$start_date = date("Y-m-d H:i:s",strtotime(Request::input("start_date")));
			$end_date   = date("Y-m-d H:i:s", strtotime(Request::input("end_date")));			
		}

		$data["po_amount"]		= currency("PHP",Purchase_Order::get_po_amount($start_date, $end_date));
		$data["count_po"]		= Purchase_Order::count_po($start_date, $end_date);

		$data["ar_amount"]		= currency("PHP",Invoice::get_ar_amount($start_date, $end_date));
		$data["count_ar"]		= Invoice::count_ar($start_date, $end_date);

		$data["ap_amount"]		= currency("PHP",Billing::get_ap_amount($start_date, $end_date));
		$data["count_ap"]		= Billing::count_ap($start_date, $end_date);

		$data["pb_amount"]		= currency("PHP",Billing::get_paid_bills_amount($start_date, $end_date));
		$data["count_pb"]		= Billing::count_paid_bills($start_date, $end_date);

		$data["pis"]			= Purchasing_inventory_system::check();

		$data["sales_amount"]	= currency("PHP",Invoice::get_sales_amount($start_date, $end_date));

		return view('member.dashboard.dashboard', $data);
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


		$data["_expenses"]          = Tbl_journal_entry_line::account()->journal()->totalAmount()
                                    ->where("je_shop_id", $this->getShopId())
                                    ->whereIn("chart_type_name", ['Expense', 'Other Expense', 'Cost of Good Sold'])
                                    ->whereRaw("DATE(je_entry_date) >= '$from'")
                                    ->whereRaw("DATE(je_entry_date) <= '$to'")
                                    ->get();

		return view('member.dashboard.dashboard', $data);
	}
}