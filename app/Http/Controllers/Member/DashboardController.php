<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Globals\Accounting;
use App\Globals\Category;
use App\Globals\Item;
use App\Globals\Customer;
use App\Models\Tbl_User;
use App\Models\Tbl_customer;
use App\Models\Tbl_unit_measurement;
use Request;
class DashboardController extends Member
{

	public function getShopId()
    {
        return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
    }

	public function index()
	{
		$data['_account']       = Accounting::getAllAccount();
		$data['_category']      = Category::getAllCategory();
		$data['_customer']      = Customer::getAllCustomer();
		$data['_item']			= Item::get_all_category_item();
		$data['_um']			= Tbl_unit_measurement::multi()->where("um_shop", $this->getShopId())
                                ->where("um_archived",0)
                                ->groupBy("tbl_unit_measurement.um_id")
                                ->get();

		// dd($data['_category']);
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