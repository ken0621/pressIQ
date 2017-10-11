<?php
namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Tbl_user;
use App\Models\Tbl_user_position;
use App\Models\Tbl_user_warehouse_access;
use App\Models\Tbl_warehouse;

use App\Globals\Account;
use App\Globals\Warehouse;
use App\Globals\Seed_manual;
use App\Globals\Utilities;
use App\Globals\Payroll;
use App\Globals\Settings;

use Crypt;
use Redirect;
use Request;
use View;
use Session;
use Carbon\Carbon;
use App\Globals\Mlm_seed;
class PayrollMember extends Controller
{

	public function __construct()
	{
		
		$this->middleware(function ($request, $next)
		{
			if(!session('user_email') || !session('user_password'))
			{
				return Redirect::to("/employee_login")->send();
			}
			else
			{
				
			}
		}
	}
}