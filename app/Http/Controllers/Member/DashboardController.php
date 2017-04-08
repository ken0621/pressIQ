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
use App\Models\Tbl_User;
use App\Models\Tbl_customer;
use App\Models\Tbl_unit_measurement;

class DashboardController extends Member
{

	public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

	public function index()
	{
		$data["shop_name"]		= $this->user_info->shop_key;

		$data["po_amount"]		= currency("PHP",Purchase_Order::get_po_amount());
		$data["count_po"]		= Purchase_Order::count_po();


		$data["ar_amount"]		= currency("PHP",Invoice::get_ar_amount());
		$data["count_ar"]		= Invoice::count_ar();
		$data["pis"]			= Purchasing_inventory_system::check();

		$data["sales_amount"]	= currency("PHP",Invoice::get_sales_amount());

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
}