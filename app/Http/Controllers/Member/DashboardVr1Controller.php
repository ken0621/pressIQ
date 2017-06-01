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
use App\Models\Tbl_User;
use App\Models\Tbl_customer;
use App\Models\Tbl_unit_measurement;
use Carbon\Carbon;
use Request;
class DashboardVr1Controller extends Member
{

	

	public function index()
	{
		return view('member/dashboardv1');
		}
}