<?php
namespace App\Globals;
use DB;
use App\Models\Tbl_chart_of_account;
use App\Models\Tbl_chart_account_type;
use App\Models\Tbl_journal_entry;
use App\Models\Tbl_journal_entry_line;
use App\Models\Tbl_user;
use App\Models\Tbl_item;
use App\Models\Tbl_payroll_record;
use App\Models\Tbl_payroll_period;
use App\Models\Tbl_payroll_period_company;
use App\Models\Tbl_payroll_deduction_employee;

use Log;
use Request;
use Session;
use Validator;
use Redirect;
use Carbon\carbon;

/**
 * Accounting Module - all accounting related module
 *
 * @author Bryan Kier Aradanas
 */
class PayrollJournalEntries()
{
	public static function getShopId()
	{
		return Tbl_user::where("user_email", session('user_email'))->shop()->pluck('user_shop');
	}

	/**
	 * Generate a report for the journal entries in payroll
	 *
	 */
	public function payroll_summary($start_date, $end_date)
	{
		
	}
}